install:
	mkdir -p -m 777 web/uploads
	composer install
	npm install --production
	bower install
	app/console assets:install
	gulp build
	app/console doctrine:schema:drop --force
	app/console doctrine:schema:create
	app/console doctrine:fixtures:load -n
	app/console cache:clear

update:
	composer install
	npm install --production
	bower install
	app/console assets:install
	gulp build
	app/console doctrine:schema:update --force
	app/console doctrine:fixtures:load
	app/console cache:clear

dev:
	app/console assets:install --symlink
	gulp watch & app/console server:run
