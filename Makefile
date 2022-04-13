GATEWAY_COMPOSE_FILE=gateway/docker-compose.yml
USER_COMPOSE_FILE=userService/docker-compose.yml
MSG_BROKER_NETWORK=msg-broker-food-microservice
USER_SERVICE_PHP_CONTAINER=php_user_serivce
GATEWAY_PHP_CONTAINER=php_gateway
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

rebuild-gateway:
	docker-compose -f $(GATEWAY_COMPOSE_FILE) kill
	docker-compose -f $(GATEWAY_COMPOSE_FILE) rm --force
	docker-compose -f $(GATEWAY_COMPOSE_FILE) build
	docker-compose -f $(GATEWAY_COMPOSE_FILE) up -d

rebuild-user-service:
	docker-compose -f $(USER_COMPOSE_FILE) kill
	docker-compose -f $(USER_COMPOSE_FILE) rm --force
	docker-compose -f $(USER_COMPOSE_FILE) build
	docker-compose -f $(USER_COMPOSE_FILE) up -d

user-service-command:
	docker-compose -f $(USER_COMPOSE_FILE) exec --user=$(shell echo $$(id -u)':'$$(id -g)) php zsh

msg-build:
	docker pull rabbitmq:3-management
	docker run -d -p 15672:15672 -p 5672:5672 --name msg-broker rabbitmq:3-management

msg-run:
	docker run -d -p 15672:15672 -p 5672:5672 --name msg-broker rabbitmq:3-management

msg-make-network:
	docker network disconnect --force $(MSG_BROKER_NETWORK) $(GATEWAY_PHP_CONTAINER)
	docker network disconnect --force $(MSG_BROKER_NETWORK) $(USER_SERVICE_PHP_CONTAINER)
	docker network rm $(MSG_BROKER_NETWORK)
	docker network create $(MSG_BROKER_NETWORK)
	docker network connect $(MSG_BROKER_NETWORK) $(USER_SERVICE_PHP_CONTAINER)
	docker network connect $(MSG_BROKER_NETWORK) $(GATEWAY_PHP_CONTAINER)
	echo "* * * * * GATEWAY * * * * *"
	docker network inspect msg-broker-food-microservice --format='{{range .IPAM.Config}}{{.Gateway}}{{end}}'

msg-gateway-ip:
	docker network inspect msg-broker-food-microservice --format='{{range .IPAM.Config}}{{.Gateway}}{{end}}'



