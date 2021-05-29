DOCKER_COMPOSE ?= winpty docker-compose
EXECUTE_APP ?= $(DOCKER_COMPOSE) exec app
EXECUTE_DB ?= $(DOCKER_COMPOSE) exec db

up:
	$(DOCKER_COMPOSE) up --remove-orphans -d
.PHONY: up

down:
	$(DOCKER_COMPOSE) down --remove-orphans
.PHONY: down

pull:
	$(DOCKER_COMPOSE) pull
.PHONY: pull

clean:
	$(DOCKER_COMPOSE) rm --force --stop
.PHONY: clean

ps:
	$(DOCKER_COMPOSE) ps
.PHONY: ps

up-app:
	$(DOCKER_COMPOSE) up --no-deps --remove-orphans -d app
.PHONY: up-app

build: build-install
.PHONY: build

build-install: up-app
.PHONY: build-install

ssh:
	@$(EXECUTE_APP) bash
.PHONY: ssh

composer-install:
	@$(EXECUTE_APP) composer install
.PHONY: composer-install

cc:
	@$(EXECUTE_APP) php bin/console cache:clear
.PHONY: cc

## DEBUG
debug-router:
	@$(EXECUTE_APP) php bin/console debug:router
.PHONE: debug-router

## CS
cs:
	@$(EXECUTE_APP) vendor/bin/php-cs-fixer fix src --verbose
.PHONE: cs

sync-start:
	@$(EXECUTE_APP) docker-sync start
.PHONE: docker-sync start