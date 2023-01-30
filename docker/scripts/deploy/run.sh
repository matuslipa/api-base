#!/bin/bash

set -e


# run script from docker root
cd $(cd `dirname $0` && pwd)/../../

echo "Checking workspace is running..."

if [[ $(docker ps | grep workspace-$PHP_VERSION) = "" ]]; then
  echo "Workspace is not running!"
  exit 1
fi

run_in_container() {
    USER=${2:-simplo};

    echo "Executing command \"$1\" as user \"${USER}\"...";
    docker compose exec -u ${USER} workspace bash -ic "cd api-base && $1"

    if [[ $? -ne 0 ]]; then
        echo "... failed! Output: ";
        echo "Status code: $?";
        exit 1;
    fi
};

echo "Running composer install..."
run_in_container "composer install -o --no-interaction";

echo "Running migrations..."
run_in_container "php artisan migrate --no-interaction --force";

echo "Clearing application cache...";
run_in_container "php artisan cache:clear";

echo "Revalidating cache...";
run_in_container "php artisan route:cache";
run_in_container "php artisan view:cache";
run_in_container "php artisan config:cache";

echo "Restarting queue workers...";
run_in_container "php artisan queue:restart";

