# DiluxOne Sandbox: what CI and the autopilot run before a pull request.
SHELL := /bin/bash

.PHONY: install lint test pre-pr

install:
	composer install --no-interaction --no-progress

lint:
	find . -name '*.php' -not -path './vendor/*' -print0 | xargs -0 -n1 php -l > /dev/null

test: install
	vendor/bin/phpunit

pre-pr: lint test
