#!/bin/bash

set -euo pipefail

docker-compose --profile setup up -d wpcli

[[ -f .env.staging ]] && sh setup-wordpress.sh staging
[[ -f .env.production ]] && sh setup-wordpress.sh production


docker-compose down && docker-compose up -d


