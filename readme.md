### Running the Application: A Step-by-Step Guide

1. **Set Up Environment Variables**  
   Copy the example environment file and configure it as needed:
   ```bash
   cp .env.example .env
   ```

2. **Ensure Required Tools are Installed**
    - Verify that Docker is installed, available, and running in the background.
    - Ensure the `make` command is available on your system.

3. **Access the Application Container**  
   SSH into the `app` service defined in the `docker-compose.yml` file:
   ```bash
   make app-shell
   ```

4. **Install Dependencies**  
   Once inside the `app` container, install all necessary dependencies:
   ```bash
   composer install
   ```

5. **Set Up the Database and Run Migrations**  
   **For the Development Environment:**
   ```bash
   php bin/console doctrine:database:create
   symfony console doctrine:database:create
   symfony console doctrine:migrations:migrate
   ```
   **For the Test Environment:**
   ```bash
   php bin/console doctrine:database:create --env=test
   symfony console doctrine:database:create --env=test
   symfony console doctrine:migrations:migrate --env=test
   ```

6. **Verify Tests**  
   Ensure all PHPUnit tests pass by running:
   ```bash
   vendor/bin/phpunit
   ```

7. **Start the Backend Application**  
   Inside the `app` container, start the backend application for the frontend to use:
   ```bash
   symfony server:start --allow-http --port=8000 --listen-ip=0.0.0.0 --document-root=/var/www/api-app/public
   ```

By following these steps, you’ll have your application up and running, ready for development and testing.
