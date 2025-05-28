.DEFAULT_GOAL := help

build-dev-mode: ## Build and run application in development mode
	docker compose -f docker-compose.dev.yaml build
	docker exec php php artisan key:generate

start-dev-mode: ## Start application in development mode
	docker compose -f docker-compose.dev.yaml up -d

down-dev-mode: ## Stop application in development mode
	docker compose -f docker-compose.dev.yaml down -v

full-dev-rebuild: ## Full re-install application
	docker compose -f docker-compose.dev.yml down -v
	docker compose -f docker-compose.dev.yml up -d
	docker exec php php artisan migrate:fresh --seed
	docker exec php php artisan storage:unlink
	docker exec php php artisan storage:link

migrate-seed: ## Run migration and seeders
	docker exec php php artisan migrate:fresh --seed

backend-cache-clear: ## Clean backend application cache
	docker exec php php artisan cache:clear

backend-tests: ## Run backend tests.
	docker exec php php artisan test

.PHONY: help
help:
	@echo "Available commands:"
	@grep -E '^[a-zA-Z_-]+:.*?## .*$$' $(MAKEFILE_LIST) | sort | awk 'BEGIN {FS = ":.*?## "}; {printf "\033[36m%-30s\033[0m %s\n", $$1, $$2}'