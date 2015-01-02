install:
	composer install
	npm install --production
	bower install
	app/console assets:install
	gulp build
	app/console doctrine:schema:update --force
	app/console doctrine:fixtures:load

dev:
	app/console assets:install --symlink
	gulp watch & app/console server:run
