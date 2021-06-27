# sample-lighthouse

## Requirement

- PHP 7.4+
- Docker
- Docker Compose 

## Setup

docker-compose.yml 用の `.env` 、 Laravel 用の `.env` をコピーする。
```shell
$ cp .env.example .env
$ cp src/.env.example src/.env
```

docker をビルドして起動する。
```shell
$ make up
```

以下のコマンドを実行してセットアップを完了させる
```shell
$ make app-init
```

キャッシュクリア

```shell
$ make app-clear
```

データ追加
```
$ docker-compose exec app php artisan tinker
$ \App\Models\User::factory(10)->create()
```
