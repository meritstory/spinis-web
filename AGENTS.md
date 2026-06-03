# AGENTS.md

## Project Rules

- Do not read `.env`, `.env.*`, or other local secret/config files unless the user explicitly asks for it.
- PHP is not expected to be available on the host machine.
- Run PHP, Composer, Symfony console, PHPStan, Rector, and Behat through Docker.
- Use Behat as the test layer for behavior/API coverage. Do not add PHPUnit tests unless the user explicitly asks for them.
- Do not refactor existing code unless it is required for the requested change.
- Do not rename classes, methods, routes, fields, or files for cleanliness unless the requested change requires it.
- Do not introduce new dependencies unless the user explicitly approves them.
- Before changing code, inspect the existing implementation and follow the project's current patterns.
- When implementing something new, find similar existing examples first and adapt only what is necessary.
- Project-specific conventions and existing practices take precedence over generic Symfony best practices.
- Preserve existing response formats, validation approach, and data handling style.
- Keep changes minimal and focused on the requested behavior.

## Development Environment

Open a shell inside the PHP/app container:

```bash
./backend.sh
```

Run a one-off command inside the PHP/app container:

```bash
./backend.sh "php -v"
```

The `./backend.sh` script runs commands via:

```bash
docker compose exec -u www-data -T app bash -c "..."
```

## Behat Tests

Run Behat commands through Docker, not directly on the host.

- Before adding a new Behat step, search for an existing project step first.
- Prefer existing project steps and built-in Mink steps when they fit.
- Add a new custom step only when the assertion cannot be expressed clearly with existing steps.
- Follow the existing `.feature` file style and wording.

Create the test schema:

```bash
./backend.sh "php bin/console doctrine:schema:create --env=test"
```

Run all Behat tests:

```bash
./backend.sh "vendor/bin/behat"
```

Run a specific feature:

```bash
./backend.sh "vendor/bin/behat features/Api/auth.feature"
```

Run a specific scenario by line:

```bash
./backend.sh "vendor/bin/behat features/Api/auth.feature:3"
```

## Database

- Use Doctrine migrations for schema changes.
- Do not change existing schema conventions unless required by the requested behavior.
- Generate migrations through Symfony console inside Docker.

Generate a migration:

```bash
./backend.sh "php bin/console doctrine:migrations:generate"
```

## Static Checks

Run PHPStan through the project script:

```bash
./backend.sh "./phpstan/check-project.sh"
```

Update PHPStan baseline only when intentionally fixing/updating the baseline:

```bash
./backend.sh "./phpstan/update-baseline-config.sh"
```

Run Rector dry-run:

```bash
./backend.sh "vendor/bin/rector process --dry-run"
```

## Notes For Agents

- Prefer existing Behat helpers in `tests/Behat/Context/FeatureContext.php`.
- When adding or updating tests, prefer reusing existing Behat steps and helpers before creating new ones.
- Behat suite config is in `tests/Behat/Resources/config/suites.yaml`.
- Behat features are in `features/`.
- Do not assume host `php` exists; use `./backend.sh`.
- If existing code differs from common Symfony recommendations, preserve the existing project style unless the user asks for a broader refactor.
- Avoid introducing new abstractions, services, or patterns only to align with framework best practices.
- Do not introduce DTOs, serializer groups, services, or new architecture only because they are Symfony best practices.
- If unsure, ask: "How is this already done in this project?", not "What is the best generic Symfony way?"
