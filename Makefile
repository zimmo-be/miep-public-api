.PHONY: ci
ci: codestyle psalm phpstan phpunit

.PHONY: codestyle
codestyle:
	vendor/bin/phpcs --standard=etc/phpcs/ruleset.xml

.PHONY: psalm
psalm:
	vendor/bin/psalm --config=etc/psalm/psalm.xml

.PHONY: phpstan
phpstan:
	vendor/bin/phpstan analyze -c etc/phpstan/phpstan.neon

.PHONY: phpunit
phpunit:
	vendor/bin/phpunit -c etc/phpunit/phpunit.xml
