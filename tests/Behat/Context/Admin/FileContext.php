<?php

declare(strict_types=1);

namespace App\Tests\Behat\Context\Admin;

use App\Entity\Admin;
use App\Entity\StoredFile;
use App\Repository\AdminRepository;
use App\Tests\Behat\Context\FeatureContext;
use Behat\Behat\Context\Context;
use Behat\Gherkin\Node\TableNode;
use Behat\MinkExtension\Context\RawMinkContext;
use Behat\Step\Given;
use Doctrine\ORM\EntityManagerInterface;
use League\Flysystem\FilesystemException;
use League\Flysystem\FilesystemOperator;
use Symfony\Bundle\FrameworkBundle\KernelBrowser;
use Symfony\Component\DependencyInjection\Attribute\Target;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Uid\Ulid;
use Webmozart\Assert\Assert;

final class FileContext extends RawMinkContext implements Context
{
    private ?string $fileUuid = null;

    /** @var array<string, string> */
    private array $loadedFileUuids = [];

    /** @var string[] */
    private array $storagePaths = [];

    public function __construct(
        private readonly AdminRepository $adminRepository,
        private readonly EntityManagerInterface $entityManager,
        #[Target('s3.storage')]
        private readonly FilesystemOperator $storage,
    ) {
    }

    #[Given('/^stored files are loaded:$/')]
    public function storedFilesAreLoaded(TableNode $table): void
    {
        $propertyAccessor = FeatureContext::getPropertyAccessor();
        /** @var array<string, StoredFile> $files */
        $files = [];

        foreach ($table as $row) {
            $adminEmail = $row['uploadedByAdmin'] ?? null;
            Assert::notNull($adminEmail, 'Stored file fixture row must include uploadedByAdmin.');

            $admin = $this->adminRepository->findOneByEmail($adminEmail);
            Assert::notNull($admin);

            $file = $this->createStoredFile(
                $admin,
                $row['originalName'],
                $row['content'] ?? '',
                $row['mimeType'] ?? 'text/plain',
            );

            foreach ($row as $property => $value) {
                if (in_array($property, ['uploadedByAdmin', 'content', 'originalName', 'mimeType'], true)) {
                    continue;
                }

                $propertyAccessor->setValue($file, $property, $value);
            }

            $this->entityManager->persist($file);
            $files[$row['originalName']] = $file;
        }

        $this->entityManager->flush();

        foreach ($files as $originalName => $file) {
            Assert::notNull($file->getId());
            $this->loadedFileUuids[$originalName] = $file->getId()->toRfc4122();
        }
    }

    #[Given('I download the stored file')]
    public function iDownloadTheStoredFile(): void
    {
        Assert::notNull($this->fileUuid);
        $this->iDownloadStoredFile($this->fileUuid);
    }

    #[Given('I download stored file :uuid')]
    public function iDownloadStoredFile(string $uuid): void
    {
        $this->getClient()->request('GET', '/files/'.$uuid);
    }

    #[Given('stored file :name uploaded by :email is registered for download')]
    public function storedFileUploadedByIsRegisteredForDownload(string $name, string $email): void
    {
        $admin = $this->adminRepository->findOneByEmail($email);
        Assert::notNull($admin);

        $file = $this->entityManager->getRepository(StoredFile::class)->findOneBy([
            'originalName' => $name,
            'uploadedByAdmin' => $admin,
        ]);
        Assert::notNull($file, sprintf('Stored file "%s" uploaded by "%s" was not found.', $name, $email));
        Assert::notNull($file->getId());

        $this->loadedFileUuids[$name] = $file->getId()->toRfc4122();
    }

    #[Given('I download stored file :name by original name')]
    public function iDownloadStoredFileByOriginalName(string $name): void
    {
        Assert::keyExists(
            $this->loadedFileUuids,
            $name,
            sprintf('Stored file "%s" is not registered for download. Use "stored files are loaded:" or "stored file ... uploaded by ... is registered for download".', $name),
        );

        $this->iDownloadStoredFile($this->loadedFileUuids[$name]);
    }

    #[Given('the last response should be a file_s3 download')]
    public function theLastResponseShouldBeAFileS3Download(): void
    {
        $path = $this->getClient()->getRequest()->getPathInfo();
        Assert::true((bool) preg_match('#^/files/[0-9a-f-]{36}$#', $path));
    }

    #[Given('the downloaded stored file content should be :content')]
    public function downloadedStoredFileContentShouldBe(string $content): void
    {
        Assert::same($this->getSession()->getPage()->getContent(), $content);
    }

    #[Given('the downloaded stored file should be an attachment named :name')]
    public function downloadedStoredFileShouldBeAnAttachmentNamed(string $name): void
    {
        $header = $this->getClient()->getResponse()->headers->get('Content-Disposition');
        Assert::string($header);
        Assert::contains($header, 'attachment');
        Assert::contains($header, sprintf("filename*=utf-8''%s", rawurlencode($name)));
    }

    #[Given('file metadata without an S3 object exists for admin :email')]
    public function fileMetadataWithoutS3ObjectExists(string $email): void
    {
        $admin = $this->adminRepository->findOneByEmail($email);
        Assert::notNull($admin);

        $file = (new StoredFile())
            ->setUploadedByAdmin($admin)
            ->setFileName('missing-'.uniqid('', true).'.txt')
            ->setOriginalName('missing.txt')
            ->setFileSize(1)
            ->setMimeType('text/plain');

        $this->entityManager->persist($file);
        $this->entityManager->flush();
        $this->fileUuid = $file->getId()?->toRfc4122();
        Assert::notNull($this->fileUuid);
    }

    #[Given('the admin session is cleared')]
    public function theAdminSessionIsCleared(): void
    {
        $this->getClient()->restart();
    }

    #[Given('the file download should redirect to admin login')]
    public function fileDownloadShouldRedirectToAdminLogin(): void
    {
        Assert::same($this->getClient()->getResponse()->getStatusCode(), Response::HTTP_OK);
        $this->assertSession()->addressMatches('#/admin/login#');
    }

    /** @AfterScenario */
    public function removeUploadedObjects(): void
    {
        foreach ($this->storagePaths as $path) {
            try {
                if ($this->storage->fileExists($path)) {
                    $this->storage->delete($path);
                }
            } catch (FilesystemException) {
            }
        }

        $this->storagePaths = [];
        $this->fileUuid = null;
        $this->loadedFileUuids = [];
    }

    private function createStoredFile(
        Admin $admin,
        string $originalName,
        string $content,
        string $mimeType,
    ): StoredFile {
        $extension = pathinfo($originalName, PATHINFO_EXTENSION);
        $path = 'behat-'.new Ulid().($extension !== '' ? '.'.$extension : '');
        $this->storage->write($path, $content, ['mimetype' => $mimeType]);

        $this->storagePaths[] = $path;

        return (new StoredFile())
            ->setUploadedByAdmin($admin)
            ->setFileName($path)
            ->setOriginalName($originalName)
            ->setFileSize(strlen($content))
            ->setMimeType($mimeType);
    }

    private function getClient(): KernelBrowser
    {
        $client = $this->getSession()->getDriver()->getClient();
        Assert::isInstanceOf($client, KernelBrowser::class);

        return $client;
    }
}
