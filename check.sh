CATEGORY_SERVICE_PHP=php_category_serivce
USER_SERVICE_PHP=php_user_serivce

for container_name in $CATEGORY_SERVICE_PHP $USER_SERVICE_PHP
do
    echo "$(tput setaf 3) SERVICE: $(tput sgr0) $(tput setaf 6) $container_name $(tput sgr0)"
    docker exec $container_name composer update
    docker exec $container_name php artisan migrate
    docker exec $container_name vendor/bin/phpunit
done

