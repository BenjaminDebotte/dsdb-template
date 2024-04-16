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

  while ! docker-compose exec db mysqladmin -u"${MYSQL_USER}" -p"${MYSQL_PASSWORD}"  ping --silent &> /dev/null; do sleep 1; done
  
  WP_CLI config create --skip-check --force --dbname="${MYSQL_DATABASE}" --dbuser="${MYSQL_USER}" --dbpass="${MYSQL_PASSWORD}" \
  --dbhost="${MYSQL_HOST}" --dbprefix=${WORDPRESS_TABLE_PREFIX}
  WP_CLI core install --skip-email --url="${SITE_URL}" --title="${SITE_TITLE}" --admin_user="${SITE_ADMIN_USER}" \
    --admin_password="${SITE_ADMIN_PASSWORD}" --admin_email="${SITE_ADMIN_EMAIL}"

  WP_CLI theme activate dsbd
  WP_CLI theme delete --all

  if [[ -f ./wp-plugins.txt ]]; then
      
      # This retrieves all the plugins to be installed + activated
      WP_CLI plugin install `grep -v '#' wp-plugins.txt| grep -Eo '^\+.*' | tr '\n+' '  '` --activate
      # This retrieves all the plugins to be installed + not activated
      WP_CLI plugin install `grep -v '#' wp-plugins.txt| grep -Ev '^\+.*' | tr '\n' ' '`
  fi

  # Website should be setup, we open it in the browser
  [[ -x "command -v open" ]] && open "http://localhost" || xdg-open "http://localhost"
}

