BIN=vendor/bin

# Lancer le serveur Laravel localement
.PHONY: start
start:
	@echo "🚀 Démarrage du serveur Laravel..."
	npm run build
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
	php artisan migrate --seed

# Reset et migrate la base de données
.PHONY: fresh
fresh:
	@echo "♻️ roll-back et application des migrations..."
	php artisan migrate:fresh --seed

# Appliquer les seeders de la base de données
.PHONY: seed
seed:
	php artisan db:seed

# Installer les dépendances Composer
.PHONY: install
install:
	@echo "📂 Installation des dépendances via Composer et NPM..."
	npm install
	composer install

# Vérifier le code sans modification (dry-run)
.PHONY: cs-ci
cs-ci:
	echo "🔍 Vérification du code sans modification (dry-run)..."
	php $(BIN)/php-cs-fixer fix --dry-run

# Corriger automatiquement le code
.PHONY: cs-fix
cs-fix:
	echo "✨ Correction automatique du code..."
	php $(BIN)/php-cs-fixer fix

# Lancer les tests Pest
.PHONY: pest
pest:
	@echo "🧪 Exécution des tests Pest..."
	php artisan test

# Lancer l'analyse statique avec PHPStan
.PHONY: phpstan
phpstan:
	@echo "🔎 Lancement de l'analyse statique avec PHPStan..."
	php $(BIN)/phpstan analyse app

# Lancer les tests Pest et PHPStan
.PHONY: test
test: pest phpstan
