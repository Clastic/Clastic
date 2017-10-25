install:
	mkdir -p -m 777 web/uploads
	composer install
	npm install --production
	bower install
	bin/console assets:install
	gulp build
	bin/console doctrine:schema:drop --force
	bin/console doctrine:schema:create
	bin/console doctrine:fixtures:load -n
	bin/console cache:clear

update:
	composer install
	npm install --production
	bower install
	bin/console assets:install
	gulp build
	bin/console doctrine:schema:update --force
	bin/console doctrine:fixtures:load
	bin/console cache:clear

dev:
	bin/console assets:install --symlink
	gulp watch & bin/console server:run

test:
	docker-compose -f docker-compose.test.yml up -d
	composer install
	set -a; . .env; vendor/bin/phpunit
	docker-compose -f docker-compose.test.yml down

