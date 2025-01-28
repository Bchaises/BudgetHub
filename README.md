# Budget Hub 💰

> **⚡ Site en construction : Certaines fonctionnalités peuvent être incomplètes ou en cours de développement. Merci de votre compréhension.**

Un site web moderne pour suivre vos finances personnelles et gérer vos budgets de manière efficace. Avec Budget Hub, vous pouvez :
- Suivre vos transactions.
- Planifier vos budgets mensuels.
- Gérer plusieurs types de comptes financiers.

Budget Hub est construit avec **Laravel** pour offrir une expérience rapide, sécurisée et flexible.

---

## ✨ Fonctionnalités
- 📈 **Visualisation des finances** : Consultez vos dépenses et vos revenus en temps réel.
- 🛠️ **Personnalisation des budgets** : Configurez vos catégories de dépenses selon vos besoins.
- 🔒 **Sécurité** : Protégez vos données avec des pratiques de sécurité modernes.
- 📂 **Multi-comptes** : Gérez plusieurs comptes bancaires, épargnes ou autres.

---

## 🚀 Installation

### Prérequis
- PHP (>= 8.2)
- Composer
- PostgreSQL
- Node.js & npm (pour la compilation des assets front-end)

### Étapes d'installation

1. **Cloner le projet** :
   ```bash
   git clone https://github.com/Bchaises/BudgetHub.git
   cd BudgetHub
   ```

2. **Installer les dépendances PHP et Node.js** :
   ```bash
   make install
   ```

3. **Configurer l'application** :
   - Dupliquez le fichier `.env.example` :
     ```bash
     cp .env.example .env
     ```
   - Modifiez les paramètres de connexion à la base de données et autres clés dans `.env`.

4. **Créer une base de données avec Docker** :
   ```bash
   make docker
   ```

5. **Migrer la base de données** :
   ```bash
   make migrate
   ```

6. **Lancer le serveur local** :
   ```bash
   make start
   ```
   Cette commande effectue également un `npm run build` pour compiler les assets front-end.
   Accédez au site sur [http://localhost:8000](http://localhost:8000).

---

## ✉️ Mails
Pour activer les fonctionnalités liées aux emails, comme la récupération de mot de passe, la vérification des adresses email ou les invitations, vous devez configurer un fournisseur de service mail. Voici les étapes :

Configurer les variables d'environnement dans le fichier .env :

```dotenv
MAIL_MAILER=your_mailer         # Exemple : smtp, sendmail, mailgun, etc.
MAIL_FROM_ADDRESS=no-reply@example.com
MAIL_FROM_NAME=BudgetHub
RESEND_KEY=your_resend_api_token
```

Configurer votre fournisseur de messagerie : Assurez-vous d’avoir configuré correctement votre fournisseur (par exemple : SMTP, Mailgun, Resend, etc.) dans le fichier .env ou dans votre panel d'administration. Consultez la documentation officielle de Laravel pour plus d'informations.

---

## 🧪 Tests
Exécutez les tests pour vous assurer que tout fonctionne comme prévu :
```bash
make tests
```

Pour les tests de qualité du code, utilisez :
```bash
make cs-ci
```

---

## 📒 Documentation
- Consultez la [documentation Laravel](https://laravel.com/docs) pour plus de détails sur le framework.

---

## 📔 Licence
Ce projet est sous licence [MIT](LICENSE).
