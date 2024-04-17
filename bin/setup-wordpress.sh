#!/bin/sh


# Useful docs:
# WP-CLI: https://developer.wordpress.org/cli/commands/


set -euo pipefail

ENVIRONMENT=$1

echo $ENVIRONMENT

Color_Off='\033[0m'
Yellow='\033[0;33m'

function check_dependencies() {
  [[ -x "$(command -v docker)" ]] || { echo -e "Please install docker"; exit 1; }
  [[ -x "$(command -v docker-compose)" ]] || { echo -e "Please install docker-compose"; exit 1; }
  SSH '[[ -x "$(command -v php)" ]]' || { echo -e "Please make sure PHP > 7 is installed on the remote server ${SSH_SERVER_IP}."; exit 1;}
}

function WP_CLI() {
  docker-compose exec -T wpcli wp --path=/var/www/html $@
}

function SSH() {
  ssh -p ${SSH_SERVER_PORT} ${SSH_SERVER_USER}@${SSH_SERVER_IP} "bash -c '$@'"
}


# Check if .env exists
if [[ ! -f .env.${ENVIRONMENT} ]]; then 
  echo -e "Files .env.${ENVIRONMENT} not found. Please create them and add your credentials." 
  exit 1
fi

clear
source ./.env.${ENVIRONMENT} # Loading environment variables

echo -e "${Yellow}Setting up SSH connection..${Color_Off}"
ssh-copy-id ${SSH_SERVER_USER}@${SSH_SERVER_IP}

echo -e "${Yellow}Deploying ovhconfig file for PHP 7..${Color_Off}"
scp -P ${SSH_SERVER_PORT} ./src/ovhconfig ${SSH_SERVER_USER}@${SSH_SERVER_IP}:.ovhconfig

check_dependencies # Make sure everything's installed

[[ -f ./src/wordpress/wp-settings.php ]] || {
  WP_CLI core download --locale=fr_FR --force --skip-content
}

SSH '[[ -f .bin/wp-cli ]]' || {
  echo -e "\n\n${Yellow}Installing WP-CLI..${Color_Off}"
  SSH wget https://raw.githubusercontent.com/wp-cli/builds/gh-pages/phar/wp-cli.phar
  SSH chmod +x wp-cli.phar
  SSH mkdir -p .bin
  SSH mv wp-cli.phar .bin/wp-cli
}

# Configure Wordpress and generate wp-config.php
echo -e "\n\n${Yellow}Configuring Wordpress..${Color_Off}"
WP_CLI package install wp-cli/restful # Can be used for REST based operations


WP_CLI config create --skip-check --force --dbname="${MYSQL_DATABASE}" --dbuser="${MYSQL_USER}" --dbpass="${MYSQL_PASSWORD}" \
  --dbhost="${MYSQL_HOST}" --dbprefix=${WORDPRESS_TABLE_PREFIX}


echo -e "\n\n${Yellow}Uploading Wordpress to ${SSH_SERVER_IP}..${Color_Off}"
rsync --info=progress2 -avPz ./src/wordpress/* ${SSH_SERVER_USER}@${SSH_SERVER_IP}:. # Fast upload to the remote server via SSH

# Here we ensure DB connection works. If so, we drop it to create it anew
echo -e "\n\n${Yellow}Creating backup of database in db/${MYSQL_DATABASE}.backup.sql just in case before dropping.${Color_Off}"
SSH ./.bin/wp-cli db export ${MYSQL_DATABASE}.${ENVIRONMENT}.backup.sql --dbuser="${MYSQL_USER}" --dbpass="${MYSQL_PASSWORD}"
scp -P ${SSH_SERVER_PORT} ${SSH_SERVER_USER}@${SSH_SERVER_IP}:${MYSQL_DATABASE}.${ENVIRONMENT}.backup.sql ./db/
SSH rm -f ${MYSQL_DATABASE}.${ENVIRONMENT}.backup.sql

echo -e "\n\n${Yellow}Cleaning the database..${Color_Off}"
SSH ./.bin/wp-cli db drop --yes --dbuser="${MYSQL_USER}" --dbpass="${MYSQL_PASSWORD}"
SSH ./.bin/wp-cli db create --dbuser="${MYSQL_USER}" --dbpass="${MYSQL_PASSWORD}"

# Installation of Wordpress
echo -e "\n\n${Yellow}Installing Wordpress..${Color_Off}"
SSH ./.bin/wp-cli core install --skip-email --url="${SITE_URL}" --title="${SITE_TITLE}" --admin_user="${SITE_ADMIN_USER}" \
  --admin_password="${SITE_ADMIN_PASSWORD}" --admin_email="${SITE_ADMIN_EMAIL}"

SSH ./.bin/wp-cli theme activate dsbd
SSH ./.bin/wp-cli theme delete --all

# If package.txt exists, we then install all the packages
echo -e "\n\n${Yellow}Installing packages..${Color_Off}"
if [[ -f ./src/wp-plugins.txt ]]; then
    
    # This retrieves all the plugins to be installed + activated
    SSH ./.bin/wp-cli plugin install `grep -v '#' src/wp-plugins.txt| grep -Eo '^\+.*' | tr '\n+' '  '` --activate
    # This retrieves all the plugins to be installed + not activated
    SSH ./.bin/wp-cli plugin install `grep -v '#' src/wp-plugins.txt| grep -Ev '^\+.*' | tr '\n' ' '`
fi

# Website should be setup, we open it in the browser
[[ -x "command -v open" ]] && open "https://${SITE_URL}" || xdg-open "https://${SITE_URL}"


