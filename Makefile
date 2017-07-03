COMPOSE_PROJECT_NAME ?= miep-public-api-client
DOCKER_COMPOSE = docker-compose -p "$(COMPOSE_PROJECT_NAME)" -f etc/docker/docker-compose.yml

ci: codestyle phpunit

codestyle: codestyle-src codestyle-tests

phpunit: phpunit-56 phpunit-70 phpunit-71

codestyle-src:
	$(DOCKER_COMPOSE) run --rm php71 vendor/bin/phpcs --standard=etc/phpcs/ruleset-src.xml --extensions=php -n --report=checkstyle --report-file=./build/checkstyle-src.xml

codestyle-tests:
	$(DOCKER_COMPOSE) run --rm php71 vendor/bin/phpcs --standard=etc/phpcs/ruleset-tests.xml --extensions=php -n --report=checkstyle --report-file=./build/checkstyle-tests.xml

phpunit-56:
	$(DOCKER_COMPOSE) run --rm php56 vendor/bin/phpunit -c etc/phpunit/phpunit.xml

phpunit-70:
	$(DOCKER_COMPOSE) run --rm php70 vendor/bin/phpunit -c etc/phpunit/phpunit.xml

phpunit-71:
	$(DOCKER_COMPOSE) run --rm php71 vendor/bin/phpunit -c etc/phpunit/phpunit.xml