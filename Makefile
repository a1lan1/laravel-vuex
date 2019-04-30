install:
	composer install && npm i && php artisan key:generate && php artisan migrate && php artisan db:seed

start:
	docker-compose up --build

stop:
	docker-compose down

serve:
	php artisan serve

watch:
	npm run watch

share:
	valet start && valet share

lint:
	./node_modules/.bin/eslint --ext .js,.vue .

lint-fix:
	./node_modules/.bin/eslint --ext .js,.vue . --fix
