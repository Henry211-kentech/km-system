# Project Setup & Deployment Guide

## 1. Clone the Repository

```
git clone https://github.com/Henry211-kentech/km-system.git
cd km-system
```

## 2. Install Dependencies

```
composer install
npm install
```

## 3. Environment Setup

- Copy the example environment file:
  ```
  cp .env.example .env
  ```
- Edit `.env` and set your database and app settings.

## 4. Generate Application Key

```
php artisan key:generate
```

## 5. Run Migrations

```
php artisan migrate
```

## 6. Build Frontend Assets

```
npm run build
```

## 7. Start the Application (Local Development)

```
php artisan serve
```
Visit `http://localhost:8000` in your browser.

---

## 8. Deployment (Automatic via GitHub Actions)

### Prerequisites

- SSH access to your server.
- Public key added to your server’s `~/.ssh/authorized_keys`.
- Private key and deployment details added as GitHub Secrets:
  - `SSH_PRIVATE_KEY`
  - `SSH_USER`
  - `SSH_HOST`
  - `SSH_PORT`
  - `SSH_TARGET_DIR`

### How Deployment Works

- Every push to the `master` branch triggers a GitHub Actions workflow.
- The workflow connects to your server via SSH and deploys the latest code to `/home/kmautom1/system.km-automobile.com`.
- It runs `composer install`, `npm install`, `npm run build`, and `php artisan migrate --force` automatically.

### To Trigger Deployment

1. Make changes locally.
2. Commit and push to `master`:
   ```
   git add .
   git commit -m "Your message"
   git push origin master
   ```
3. Monitor deployment in the GitHub Actions tab.
4. Visit `https://system.km-automobile.com/` to see your changes.

---

## 9. Troubleshooting

- Check the Actions tab on GitHub for deployment logs.
- Ensure your `.env` file on the server is correctly configured (the workflow does not overwrite it).
- File permissions on the server may need to be adjusted for `storage` and `bootstrap/cache`.

---

For further help, contact your system administrator or open an issue on the repository.
