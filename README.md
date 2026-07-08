# spinis-web

**Skundų priėmimo ir nagrinėjimo informacinė sistema**

## Requirements

* Read the [Contributing to this repository](CONTRIBUTION.md) guide
* To run the project you should have installed: Docker, Docker Compose
* The project requirements you can check if needed `./docker-compose.yaml`

## Development environment

1. cd project directory
2. Run `cp docker-compose.override.dist.yaml docker-compose.override.yaml`<br />
3. Build/run containers `./start-dev.sh`
4. Update your system host file (add sf.dev) or you can use localhost:8080
    ```
    sudo echo "127.0.0.1 sf.dev" >> /etc/hosts
    ```
5. Connect to php container by running this command: `./backend.sh` and run next steps inside the connected php container
    1. Run this command `composer install`
    2. Run this command `bin/console lexik:jwt:generate-keypair` to generate the SSL keys for LexikJWTAuthenticationBundle
    3. Run this command `bin/console doctrine:migrations:migrate`
    4. Run this command `bin/console app:create-admin <username> <password>` to create an admin user
    5. Run this command `bin/console assets:install --symlink`
6. PhpStorm only
    1. Install plugins:
        - Symfony Support
        - PHP Annotations
        - PHP Toolbox
        - deep-assoc-completion
        - Php Inspections (EA Extended)
        - PHPUnit Enhancement
    2. Choose correct PHP interpreter:
        - Settings -> PHP -> CLI Interpreter -> choose `php from docker-compose`
        - Settings -> PHP -> Quality Tools -> PHP_CodeSniffer -> Configuration -> choose `By default project interpreter`
        - Settings -> PHP -> Quality Tools -> PHPStan -> Configuration -> choose `By default project interpreter`
    3. Sync settings with composer
        - Press `Enable sync` if you see popup
        - Otherwise: Settings -> PHP -> Composer -> check `Synchronize IDE Settings with composer.json`
7. Run `./phpstan/check-project.sh` to check for errors before git push.
    1. You need to regenerate baseline config after some fixes to old code:
        - run `./phpstan/update-baseline-config.sh`
8. Run behat tests:
    1. php bin/console doctrine:schema:create --env=test
    2. vendor/bin/behat

## LocalStack S3

For local development, S3 goes through LocalStack instead of AWS. It starts with `./start-dev.sh`. Connection details are in `.env`.

Run this command to see if the `dev` bucket is there:

```bash
docker compose exec localstack awslocal s3 ls
```
