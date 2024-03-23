#!/bin/bash
cd /var/www/html

chown -R www:www-data ../html

php database/migrations/migrate

exec "$@"