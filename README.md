# dankovtsev-site

## Run local
```shell
docker-compose up
```

## Exec in running container
```shell
docker-compose exec backend bash
```

## Build code for local development:
```shell
composer install
./vendor/bin/phing build -Denv=local
kill -HUP 1
```
