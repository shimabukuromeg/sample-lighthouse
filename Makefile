up:
	docker-compose up -d app web db mailhog

down:
	docker-compose down

# Init application after start docker
app-init:
	docker-compose exec app ash -c ' \
		chmod -R 777 /app/storage && \
		php -d memory_limit=-1 /usr/bin/composer install && \
		composer install && \
		php artisan storage:link && \
		php artisan key:generate && \
		php artisan jwt:secret'

# Laravelのキャッシュ周りを削除する際に実行する
app-clear:
	docker-compose exec app composer dump-autoload
	docker-compose exec app php artisan optimize:clear

# tinker使うよ
app-tinker:
	docker-compose exec app php artisan tinker

# route::list使うよ
app-route:
	docker-compose exec app php artisan route:list

# 静的解析、テストを実行する
app-phpcs:
	docker-compose exec app composer phpcs

app-phpcbf:
	docker-compose exec app composer phpcbf

app-phpmd:
	docker-compose exec app composer phpmd

app-phpstan:
	docker-compose exec app composer phpstan

app-phpunit:
	docker-compose exec app composer phpunit

# DBをリフレッシュする
app-db-fresh:
	docker-compose exec app ash -c ' \
		php artisan migrate:fresh && \
		php artisan migrate:fresh --env=testing'

# ゲストの/app/vendor配下のファイルをホストに同期する際に実行する
# appコンテナが起動している状態で実行すること
app-sync-vendor:
	mkdir -p ./src/vendor
	docker cp `docker-compose ps -q app`:/app/vendor/. ./src/vendor

# Laravelのide-helper周りをまとめて実行してくれる
app-ide-helper:
	docker-compose exec app ash -c ' \
		php artisan ide-helper:eloquent && \
		php artisan ide-helper:models --nowrite && \
		php artisan ide-helper:generate && \
		php artisan ide-helper:meta'

# DBをリフレッシュしてSeederを流す、testingにはSeederは流さない
app-db-fresh-seed:
	docker-compose exec app php artisan migrate:fresh --seed
