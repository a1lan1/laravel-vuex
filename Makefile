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

cs:
	./vendor/squizlabs/php_codesniffer/bin/phpcs --standard=PSR12 --extensions=php --ignore=vendor/*,storage/,bootstrap/*,*.blade.php,public/*,database/*,.phpstorm.meta.php,_ide_helper.php .

cs-fix:
	./vendor/squizlabs/php_codesniffer/bin/phpcbx --standard=PSR12 --extensions=php --ignore=vendor/*,storage/,bootstrap/*,*.blade.php,public/*,database/*,.phpstorm.meta.php,_ide_helper.php .

lint:
	./node_modules/.bin/eslint --ext .js,.vue .

lint-fix:
	./node_modules/.bin/eslint --ext .js,.vue . --fix
