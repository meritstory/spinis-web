---
name: security-audit
description: "Use when conducting security assessments or reviewing/implementing authentication, authorization, user input, file uploads, API endpoints, secrets, payments, signed transactions, or sensitive-data handling. Covers OWASP Top 10/API/LLM, CWE Top 25, CVSS scoring, PHP/TYPO3/Symfony, frontend, Terraform/K8s/Docker IaC, AWS, AI agent configs, and dependency scanning."
license: "(MIT AND CC-BY-SA-4.0). See LICENSE-MIT and LICENSE-CC-BY-SA-4.0"
metadata:
  author: Netresearch DTT GmbH
  version: "2.11.1"
  repository: https://github.com/netresearch/security-audit-skill
  compatibility: "Requires grep, jq, gh CLI."
allowed-tools: Bash(grep:*) Bash(jq:*) Bash(gh:*) Read Glob Grep
---

# Security Audit Skill

Security audit patterns (OWASP Top 10, LLM Top 10 2025, CWE Top 25 2025, CVSS v4.0), cloud/IaC, GitHub security. 80+ PHP/TYPO3 checkpoints (v14.3 LTS in `typo3-security.md`).

## Expertise Areas

- **Vulnerabilities**: XXE, SQLi, XSS, CSRF, command injection, path traversal, file upload, deserialization, SSRF, SSTI, JWT, type juggling
- **Standards**: OWASP Top 10 / API / LLM (2025), CWE Top 25, CVSS v3.1/v4.0, OWASP ASVS
- **Cloud & IaC**: AWS; Terraform, Kubernetes, Docker, Helm
- **API & Frontend**: REST/GraphQL authZ, rate limits, mass assignment, CSP, DOM-XSS
- **AI Agents**: SKILL.md/AGENTS.md/CLAUDE.md/mcp.json/hooks.json audit; prompt injection; excessive agency

## Audit Workflow

1. Define the scope, protected assets, entry points, trust boundaries, and attacker capabilities.
2. Detect the relevant stack and load only the reference files needed for that stack and risk area.
3. Trace untrusted data and authorization decisions through the actual implementation before reporting a vulnerability.
4. Use scanners to generate candidates, then confirm each finding manually and eliminate false positives.
5. Prioritize exploitable issues over checklist completeness. Use CVSS when requested or when consistent severity scoring is needed.
6. Recommend the smallest remediation that fits the project's existing architecture and add negative-path regression coverage using the project's test conventions.

## Review Coverage

- **Secrets and sensitive data**: Check source, configuration, history, storage, transmission, logs, and error responses. Do not expose raw secrets, credentials, payment data, or stack traces.
- **Input and data access**: Validate on the server, prefer allowlists, parameterize queries, encode output for its destination, and verify uploaded file content as well as metadata.
- **Authentication and authorization**: Check session/token lifecycle, secure cookie attributes, CSRF protection, role and object-level authorization, and authorization before every sensitive operation.
- **APIs and abuse controls**: Check request limits, brute-force and expensive-operation throttling, payload limits, CORS allowlists, mass assignment, replay protection, and safe error handling.
- **Frontend**: Check DOM and stored XSS, unsafe HTML rendering, token exposure, CSP, third-party resources, and leakage of server-only data into client bundles.
- **Payments and signed transactions**: Recompute and validate recipient, amount, currency/network, and authorization server-side; bind signatures to an explicit action, nonce, audience, and expiry; enforce replay protection and idempotency.
- **Dependencies and delivery**: Check lock files, known vulnerabilities, provenance, CI permissions, and secret exposure. Investigate compatibility and exploitability before applying automated upgrades.

## Reference Files (in `references/`, `.md` implied)

- **Core**: owasp-top10, cwe-top25, xxe-prevention, cvss-scoring, api-key-encryption
- **Prevention**: deserialization-prevention, path-traversal-prevention, file-upload-security, input-validation, error-message-sanitization
- **Architecture**: authentication-patterns, security-headers, security-logging, cryptography-guide, security-invariants, indistinguishability-defences
- **Language features** (`*-security-features`): php, python, javascript-typescript, nodejs, go
- **Frameworks** (`*-security`): typo3, typo3-fluid, typo3-typoscript, symfony, react, vue
- **Cloud & IaC**: aws-security, iac-security
- **API & Frontend**: api-security, frontend-security
- **AI Agent**: llm-security (OWASP LLM Top 10 2025)
- **Threats**: modern-attacks, cve-patterns
- **DevSecOps**: ci-security-pipeline, supply-chain-security, automated-scanning, gha-security, git-history-secrets
- **Incident**: supply-chain-incident-response

## Security Checklist

- [ ] `semgrep`/`opengrep`, `trivy fs --severity HIGH,CRITICAL`, `gitleaks` clean
- [ ] bcrypt/Argon2 passwords, CSRF on state changes, TLS 1.2+
- [ ] Server-side input validation; parameterized SQL; XML entities off
- [ ] Output encoding + CSP; no unserialize() on user input
- [ ] API keys encrypted; exception messages sanitized
- [ ] Authentication, object-level authorization, session lifecycle, and CSRF verified
- [ ] Rate limits on authentication, expensive, and abuse-prone operations
- [ ] CORS restricted to explicitly trusted origins; request/payload limits enforced
- [ ] Secrets out of VCS and history; sensitive values absent from logs; audit logging on
- [ ] Uploads validated, renamed, outside web root
- [ ] Headers HSTS + X-Content-Type-Options; dependencies scanned
- [ ] Payment and signed-transaction values verified server-side; replay/idempotency controls present
- [ ] Negative tests cover unauthenticated, unauthorized, malformed, replayed, and rate-limited requests

## Reporting Findings

- Lead with confirmed findings ordered by severity; keep observations and unverified scanner candidates separate.
- For each finding, provide the affected location, weakness, evidence/data flow, realistic impact, severity rationale, minimal remediation, and verification step.
- Do not claim exploitability without evidence. State assumptions, unavailable checks, and residual risk explicitly.
- If no findings are confirmed, summarize what was inspected and which checks could not be completed; do not equate this with proof of security.

## GitHub Actions Security

- **NEVER** interpolate `${{ inputs.* }}` / `${{ github.event.* }}` in `run:` — use `env:`
- Dependency triage: upgrade > override > dismiss. Full patterns: `references/gha-security.md`.

---

> Contributing: https://github.com/netresearch/security-audit-skill
