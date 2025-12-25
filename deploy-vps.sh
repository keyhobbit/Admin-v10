#!/bin/bash

# Deploy to VPS using Ansible
# Usage: ./deploy-vps.sh [production|staging] [branch]

set -e

TARGET="${1:-production}"
BRANCH="${2:-master}"

echo "======================================"
echo "Deploying to ${TARGET}"
echo "Branch: ${BRANCH}"
echo "======================================"

# Check if ansible is installed
if ! command -v ansible-playbook &> /dev/null; then
    echo "Error: ansible-playbook not found. Please install Ansible first."
    exit 1
fi

# Run deployment playbook
ansible-playbook -i ansible/inventory/hosts \
    ansible/playbooks/deploy.yml \
    -e "target=${TARGET}" \
    -e "git_branch=${BRANCH}"

echo "======================================"
echo "Deployment completed successfully!"
echo "======================================"
