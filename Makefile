COMPOSE_FILES=gateway/docker-compose.yml
USER=app
GROUP=app

gateway-build:
	docker-compose -f $(COMPOSE_FILES) build

gateway-up:
	docker-compose -f $(COMPOSE_FILES) up -d

gateway-destroy:
	docker-compose -f $(COMPOSE_FILES) down

gateway-status:
	docker-compose -f $(COMPOSE_FILES) ps

gateway-command:
	docker-compose -f $(COMPOSE_FILES) exec --user=$(shell echo $$(id -u)':'$$(id -g)) php zsh

gateway-shell-as-root:
	docker-compose -f $(COMPOSE_FILES) exec php zsh
