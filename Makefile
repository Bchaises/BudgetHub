# Lancer le serveur Laravel localement
.PHONY: start
start:
	@echo "🚀 Démarrage du serveur Laravel..."
	php artisan serve

# Démarrer les conteneurs Docker
.PHONY: docker
docker:
	@echo "🐳 Lancement des conteneurs Docker..."
	docker compose up -d

.PHONY: docker-stop
docker-stop:
	@echo "🛑 Arrêt des conteneurs Docker..."
	docker compose stop

# Arrêter et supprimer les conteneurs Docker
.PHONY: down
down:
	@echo "🛑 Arrêt et suppression des conteneurs Docker..."
	docker compose down

# Appliquer les migrations de la base de données
.PHONY: migrate
migrate:
	@echo "📦 Application des migrations..."
	php artisan migrate

# Appliquer les migrations avec un reset
.PHONY: migrate-reset
migrate-reset:
	@echo "♻️ Réinitialisation et application des migrations..."
	php artisan migrate:reset && php artisan migrate

# Installer les dépendances Composer
.PHONY: install
install:
	@echo "📂 Installation des dépendances via Composer..."
	composer install
