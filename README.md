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

サンプル データ追加
```shell
$ docker-compose exec app php artisan tinker
$ \App\Models\User::factory(10)->create()
```

```shell
# Create IDE helper files to improve type checking and autocompletion.
$ docker-compose exec app php artisan lighthouse:ide-helper

# ide-helper command generating broken schema-directives.graphql file #1661
$ sed -i '' 's/repeatable//g' src/schema-directives.graphql
```

モデル作成
```shell
$ docker-compose exec app php artisan make:model {ModelName} -mf
```

リゾルバ作成
```shell
$ docker-compose exec app php artisan lighthouse:mutation {ResolverName}Resolver
```

パッケージ導入
```shell
$	docker-compose exec app composer require stripe/stripe-php
```
# ref
Artisan Commands

[Artisan Commands \| Lighthouse](https://lighthouse-php.com/4/api-reference/commands.html#cache)
