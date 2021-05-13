# IMPORT CONFIG WITH ENVS. You can change the default config with `make cnf="config_special.env" up-dev`
# This will output the help for each task
# thanks to https://marmelab.com/blog/2016/02/29/auto-documented-makefile.html
help:## This is help.
	@awk 'BEGIN {FS = ":.*?## "} /^[a-zA-Z_-]+:.*?## / {printf "\033[36m%-30s\033[0m %s\n", $$1, $$2}' $(MAKEFILE_LIST)

.PHONY: help

echo-project-dir:## Show current working directory.
	@echo $(LOCALHOST_PROJECT_DIR)

.PHONY: echo-project-dir

print:## print
	@printenv

.PHONY: print

## Docker compose shortcuts
up-dev print-compose-file: COMPOSE_FILE=./docker-compose.yml
up-dev: ## Up current containers for dev
	docker-compose -f $(COMPOSE_FILE) up -d

print-compose-file:## print compose file
	@echo $(COMPOSE_FILE)

.PHONY: up-dev print-compose-file

php-exec: CMD?=-r 'phpinfo();'
php-exec: ## Run any php command in our container
	docker exec ${PROJECT_NAME}-php php $(CMD)

.PHONY: php-exec

some-cmd:
	docker run \
	-it \
	--network some-network \
	--rm \
	mongo mongo \
	--host some-mongo \
	test

docker-run:
	docker-compose up

docker-check-containters:
	docker ps

docker-rebuild:
	docker-compose up --build