install:
	composer install
	npm install
	bower install
	app/console assets:install
	gulp build
	app/console doctrine:schema:update

dev:
	app/console assets:install --symlink
	gulp watch
	app/console server:run
