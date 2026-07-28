<?php

declare(strict_types=1);

namespace App\Tests\Behat\Context\Admin;

use App\Entity\StoredFile;
use App\Repository\AdminRepository;
use Behat\Behat\Context\Context;
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

    /** @var string[] */
    private array $storagePaths = [];

    public function __construct(
        private readonly AdminRepository $adminRepository,
        private readonly EntityManagerInterface $entityManager,
        #[Target('s3.storage')]
        private readonly FilesystemOperator $storage,
    ) {
    }

    #[Given('stored file :name with content :content exists for admin :email')]
    public function storedFileExists(string $name, string $content, string $email): void
    {
        $admin = $this->adminRepository->findOneByEmail($email);
        Assert::notNull($admin);

        $extension = pathinfo($name, PATHINFO_EXTENSION);
        $path = 'behat-'.new Ulid().($extension !== '' ? '.'.$extension : '');
        $this->storage->write($path, $content, ['mimetype' => 'text/plain']);

        $file = new StoredFile()
            ->setUploadedByAdmin($admin)
            ->setFileName($path)
            ->setOriginalName($name)
            ->setFileSize(strlen($content))
            ->setMimeType('text/plain');

        $this->entityManager->persist($file);
        $this->entityManager->flush();
        $this->fileUuid = $file->getId()?->toRfc4122();
        Assert::notNull($this->fileUuid);
        $this->storagePaths[] = $path;
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

        $file = new StoredFile()
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
    }

    private function getClient(): KernelBrowser
    {
        $client = $this->getSession()->getDriver()->getClient();
        Assert::isInstanceOf($client, KernelBrowser::class);

        return $client;
    }
}
