ci: codestyle phpunit

codestyle: codestyle-src codestyle-tests

codestyle-src:
	vendor/bin/phpcs --standard=etc/phpcs/ruleset-src.xml --extensions=php -n --report=checkstyle --report-file=./build/checkstyle-src.xml

codestyle-tests:
	vendor/bin/phpcs --standard=etc/phpcs/ruleset-tests.xml --extensions=php -n --report=checkstyle --report-file=./build/checkstyle-tests.xml

phpunit:
	vendor/bin/phpunit -c etc/phpunit/phpunit.xml