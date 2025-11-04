#!/bin/bash

###############################################################################
# Allergy.tr Deployment Script
#
# Usage:
#   ./deploy.sh              # Interactive deployment
#   ./deploy.sh --auto       # Auto deployment with saved credentials
###############################################################################

set -e  # Exit on error

# Colors
RED='\033[0;31m'
GREEN='\033[0;32m'
YELLOW='\033[1;33m'
BLUE='\033[0;34m'
NC='\033[0m' # No Color

echo -e "${BLUE}╔════════════════════════════════════════════╗${NC}"
echo -e "${BLUE}║   Allergy.tr - Hostinger Deployment       ║${NC}"
echo -e "${BLUE}╔════════════════════════════════════════════╗${NC}"
echo ""

# Config file
CONFIG_FILE=".deploy-config"

# Check if auto mode
if [ "$1" == "--auto" ] && [ -f "$CONFIG_FILE" ]; then
    echo -e "${GREEN}📦 Loading saved configuration...${NC}"
    source "$CONFIG_FILE"
else
    echo -e "${YELLOW}📝 Please enter your Hostinger details:${NC}"
    echo ""

    read -p "SSH Host (e.g., ssh.yourdomain.com): " SSH_HOST
    read -p "SSH Username (e.g., u123456789): " SSH_USER
    read -sp "SSH Password: " SSH_PASS
    echo ""
    read -p "Remote Path (e.g., /home/u123456789/domains/yourdomain.com): " REMOTE_PATH

    echo ""
    read -p "💾 Save credentials for future use? (y/n): " SAVE_CREDS

    if [ "$SAVE_CREDS" == "y" ]; then
        cat > "$CONFIG_FILE" <<EOF
SSH_HOST="$SSH_HOST"
SSH_USER="$SSH_USER"
SSH_PASS="$SSH_PASS"
REMOTE_PATH="$REMOTE_PATH"
EOF
        chmod 600 "$CONFIG_FILE"
        echo -e "${GREEN}✅ Credentials saved to $CONFIG_FILE${NC}"
    fi
fi

echo ""
echo -e "${BLUE}🚀 Starting deployment...${NC}"
echo ""

# Check if sshpass is installed
if ! command -v sshpass &> /dev/null; then
    echo -e "${YELLOW}⚠️  sshpass not found. Installing...${NC}"
    if [[ "$OSTYPE" == "darwin"* ]]; then
        brew install hudochenkov/sshpass/sshpass
    elif [[ "$OSTYPE" == "linux-gnu"* ]]; then
        sudo apt-get install -y sshpass || sudo yum install -y sshpass
    fi
fi

# Create deployment commands
DEPLOY_COMMANDS=$(cat <<'DEPLOY_EOF'
set -e

echo "📂 Navigating to project directory..."
cd "${REMOTE_PATH}"

# Check if git is initialized
if [ ! -d ".git" ]; then
    echo "🔄 First time setup - cloning repository..."
    git clone -b claude/allergy-portal-dashboard-011CUoRQwKL75DR6xs1K8yHJ \
        https://github.com/okansay/allergy.tr.git temp_repo

    # Move files
    cp -r temp_repo/* .
    cp -r temp_repo/.git .
    rm -rf temp_repo
else
    echo "🔄 Pulling latest changes..."
    git fetch origin
    git reset --hard origin/claude/allergy-portal-dashboard-011CUoRQwKL75DR6xs1K8yHJ
fi

# Set permissions
echo "🔒 Setting permissions..."
chmod -R 755 public
chmod -R 644 public/*.php
chmod -R 755 api
chmod -R 644 api/*.php

# Check if database needs migration
if [ -f "database/migrate.php" ]; then
    echo "🗄️  Running database migrations..."
    cd database
    php migrate.php || echo "⚠️  Migration warning (might be already applied)"
    cd ..
fi

echo ""
echo "✅ Deployment completed successfully!"
echo "🌐 Visit your site: https://yourdomain.com"
DEPLOY_EOF
)

# Execute deployment
echo -e "${GREEN}🔗 Connecting to Hostinger...${NC}"

sshpass -p "$SSH_PASS" ssh -o StrictHostKeyChecking=no "$SSH_USER@$SSH_HOST" \
    "export REMOTE_PATH='$REMOTE_PATH'; $DEPLOY_COMMANDS"

echo ""
echo -e "${GREEN}╔════════════════════════════════════════════╗${NC}"
echo -e "${GREEN}║   ✅ DEPLOYMENT SUCCESSFUL!                ║${NC}"
echo -e "${GREEN}╔════════════════════════════════════════════╗${NC}"
echo ""
echo -e "${BLUE}📌 Next time run: ${YELLOW}./deploy.sh --auto${NC}"
echo ""
