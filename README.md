DOCKER:

1. In Terminal run:
    1. `docker-compose build --no-cache`
    2. `docker-compose up -d`
    3. `docker exec -it individuyelection bash`
    4. `composer install`
    5. `php artisan migrate --seed`
    6. `php artisan app:calculate-all-ranking-averages`
2. Open `http://localhost:8088/`
3. for subsequent uses: `docker-compose down -v; if ($?) { docker-compose build --no-cache; if ($?) { docker-compose up -d} }`