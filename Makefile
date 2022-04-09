COMPOSE_FILES=docker-compose.yml
USER=app
GROUP=app

build:
	docker-compose -f $(COMPOSE_FILES) up -d --build

up:
	docker-compose -f $(COMPOSE_FILES) up -d

destroy:
	docker-compose -f $(COMPOSE_FILES) down

status:
	docker-compose -f $(COMPOSE_FILES) ps

command:
	docker-compose -f $(COMPOSE_FILES) exec --user=$(shell echo $$(id -u)':'$$(id -g)) php zsh

shell-as-root:
	docker-compose -f $(COMPOSE_FILES) exec php zsh
