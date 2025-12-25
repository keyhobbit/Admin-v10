# Ansible Deployment for AFK Game

This directory contains Ansible playbooks and configuration for deploying the AFK Game application.

## Directory Structure

```
ansible/
├── ansible.cfg           # Ansible configuration
├── inventory/
│   └── hosts            # Inventory file with server definitions
├── playbooks/
│   ├── setup.yml        # Server initial setup
│   ├── deploy.yml       # Application deployment
│   └── rollback.yml     # Rollback to previous version
├── group_vars/
│   ├── all.yml          # Variables for all environments
│   ├── production.yml   # Production-specific variables
│   └── staging.yml      # Staging-specific variables
├── templates/
│   └── .env.j2          # Environment file template
└── roles/               # Custom roles (if needed)
```

## Prerequisites

1. Install Ansible:
```bash
pip install ansible
```

2. Configure SSH access to target servers
3. Update inventory file with your server IPs

## Usage

### Initial Server Setup

Set up a new server with Docker and dependencies:

```bash
# For staging
ansible-playbook playbooks/setup.yml --extra-vars "target=staging"

# For production
ansible-playbook playbooks/setup.yml --extra-vars "target=production"
```

### Deploy Application

Deploy or update the application:

```bash
# Deploy to staging
ansible-playbook playbooks/deploy.yml --extra-vars "target=staging"

# Deploy to production
ansible-playbook playbooks/deploy.yml --extra-vars "target=production"

# Deploy specific branch
ansible-playbook playbooks/deploy.yml --extra-vars "target=staging git_branch=develop"
```

### Rollback

Rollback to a previous version:

```bash
# Rollback to previous commit
ansible-playbook playbooks/rollback.yml --extra-vars "target=staging"

# Rollback to specific commit
ansible-playbook playbooks/rollback.yml --extra-vars "target=staging commit=abc123"
```

## Configuration

### Inventory

Edit `inventory/hosts` to add your servers:

```ini
[production]
prod-server ansible_host=1.2.3.4 ansible_user=ubuntu

[staging]
staging-server ansible_host=5.6.7.8 ansible_user=ubuntu
```

### Environment Variables

Edit the appropriate file in `group_vars/`:
- `all.yml` - Variables for all environments
- `production.yml` - Production-specific variables
- `staging.yml` - Staging-specific variables

### Sensitive Data

Use Ansible Vault for sensitive data:

```bash
# Create encrypted vault file
ansible-vault create group_vars/vault.yml

# Edit encrypted file
ansible-vault edit group_vars/vault.yml

# Run playbook with vault
ansible-playbook playbooks/deploy.yml --ask-vault-pass
```

## CI/CD Integration

### GitHub Actions Example

```yaml
name: Deploy to Staging
on:
  push:
    branches: [develop]

jobs:
  deploy:
    runs-on: ubuntu-latest
    steps:
      - uses: actions/checkout@v2
      - name: Install Ansible
        run: pip install ansible
      - name: Deploy
        run: ansible-playbook ansible/playbooks/deploy.yml --extra-vars "target=staging"
        env:
          ANSIBLE_HOST_KEY_CHECKING: False
```

### GitLab CI Example

```yaml
deploy:staging:
  stage: deploy
  image: python:3.9
  before_script:
    - pip install ansible
  script:
    - ansible-playbook ansible/playbooks/deploy.yml --extra-vars "target=staging"
  only:
    - develop
```

## Best Practices

1. **Always test in staging first** before deploying to production
2. **Use Ansible Vault** for sensitive data (passwords, API keys)
3. **Tag your releases** in Git for easy rollback
4. **Monitor deployments** and keep logs
5. **Run syntax check** before deploying:
   ```bash
   ansible-playbook playbooks/deploy.yml --syntax-check
   ```
6. **Dry run** to see what will change:
   ```bash
   ansible-playbook playbooks/deploy.yml --check
   ```
