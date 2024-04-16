#!/bin/bash

set -euo pipefail

# Start containers
docker-compose up -d wpcli

[[ -f .env.staging ]] && sh setup-wordpress.sh staging
[[ -f .env.production ]] && sh setup-wordpress.sh production



function WP_CLI() {
  docker-compose --env-file ./.env.local exec -T wpcli  wp --path=/var/www/html $@
}


[[ -f .env.local ]] && {
  source ./.env.local
  
  docker-compose up -d db wordpress
  
  sleep 10 # Make sure mysql is up

  WP_CLI config create --skip-check --force --dbname="${MYSQL_DATABASE}" --dbuser="${MYSQL_USER}" --dbpass="${MYSQL_PASSWORD}" \
  --dbhost="${MYSQL_HOST}" --dbprefix=${WORDPRESS_TABLE_PREFIX}
  WP_CLI core install --skip-email --url="${SITE_URL}" --title="${SITE_TITLE}" --admin_user="${SITE_ADMIN_USER}" \
    --admin_password="${SITE_ADMIN_PASSWORD}" --admin_email="${SITE_ADMIN_EMAIL}"

  # Website should be setup, we open it in the browser
  [[ -x "command -v open" ]] && open "http://localhost" || xdg-open "http://localhost"
}

