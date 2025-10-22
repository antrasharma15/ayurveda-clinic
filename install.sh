#!/bin/bash

# Quick Installation Script for Menu Management System
# This script will setup everything automatically

echo "================================================"
echo "  Menu Management System - Quick Installer"
echo "================================================"
echo ""

# Colors for output
GREEN='\033[0;32m'
RED='\033[0;31m'
YELLOW='\033[1;33m'
NC='\033[0m' # No Color

# Get current directory
CURRENT_DIR=$(pwd)

echo -e "${YELLOW}Step 1: Updating Database...${NC}"
/opt/lampp/bin/mysql -u root ayurveda_clinic < update_db.sql

if [ $? -eq 0 ]; then
    echo -e "${GREEN}✓ Database updated successfully!${NC}"
else
    echo -e "${RED}✗ Database update failed! Please check your MySQL connection.${NC}"
    exit 1
fi

echo ""
echo -e "${YELLOW}Step 2: Setting up permissions...${NC}"

# Create uploads directory if not exists
if [ ! -d "images/uploads" ]; then
    mkdir -p images/uploads
    echo -e "${GREEN}✓ Created images/uploads directory${NC}"
fi

# Set permissions
chmod -R 777 images/uploads

if [ $? -eq 0 ]; then
    echo -e "${GREEN}✓ Permissions set successfully!${NC}"
else
    echo -e "${RED}✗ Failed to set permissions!${NC}"
    exit 1
fi

echo ""
echo -e "${YELLOW}Step 3: Verifying files...${NC}"

# Check if all required files exist
files=(
    "admin/manage_menus.php"
    "admin/edit_menu.php"
    "admin/delete_menu.php"
    "admin/upload_image.php"
    "update_db.sql"
)

all_files_exist=true
for file in "${files[@]}"; do
    if [ -f "$file" ]; then
        echo -e "${GREEN}✓${NC} $file"
    else
        echo -e "${RED}✗${NC} $file ${RED}(MISSING)${NC}"
        all_files_exist=false
    fi
done

echo ""
if [ "$all_files_exist" = true ]; then
    echo -e "${GREEN}================================================${NC}"
    echo -e "${GREEN}  Installation Complete! 🎉${NC}"
    echo -e "${GREEN}================================================${NC}"
    echo ""
    echo -e "${YELLOW}Next Steps:${NC}"
    echo "1. Login to your admin panel"
    echo "2. Go to Manage Menus"
    echo "3. Create a new menu with custom page"
    echo "4. Edit the menu to add content"
    echo ""
    echo -e "${YELLOW}Documentation:${NC}"
    echo "- English Guide: MENU_SYSTEM_GUIDE.md"
    echo "- Hindi Guide: HINDI_GUIDE.md"
    echo "- Changes Summary: CHANGES_SUMMARY.md"
    echo ""
    echo -e "${GREEN}Happy Creating! 🚀${NC}"
else
    echo -e "${RED}================================================${NC}"
    echo -e "${RED}  Installation Incomplete!${NC}"
    echo -e "${RED}================================================${NC}"
    echo "Some files are missing. Please check the files above."
fi
