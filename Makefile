GATEWAY_COMPOSE_FILE=gateway/docker-compose.yml
USER_COMPOSE_FILE=userService/docker-compose.yml
USER=app
GROUP=app

gateway-build:
	docker-compose -f $(GATEWAY_COMPOSE_FILE) build

gateway-up:
	docker-compose -f $(GATEWAY_COMPOSE_FILE) up -d

gateway-destroy:
	docker-compose -f $(GATEWAY_COMPOSE_FILE) down

gateway-status:
	docker-compose -f $(GATEWAY_COMPOSE_FILE) ps

gateway-command:
	docker-compose -f $(GATEWAY_COMPOSE_FILE) exec --user=$(shell echo $$(id -u)':'$$(id -g)) php zsh

gateway-shell-as-root:
	docker-compose -f $(GATEWAY_COMPOSE_FILE) exec php zsh

rebuild-user-service:
	docker-compose -f $(USER_COMPOSE_FILE) kill
	docker-compose -f $(USER_COMPOSE_FILE) rm --force
	docker-compose -f $(USER_COMPOSE_FILE) build
	docker-compose -f $(USER_COMPOSE_FILE) up -d

user-service-command:
	docker-compose -f $(USER_COMPOSE_FILE) exec --user=$(shell echo $$(id -u)':'$$(id -g)) php zsh
