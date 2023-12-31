# TripBuilder

TripBuilder is a comprehensive flight search application made with a Laravel-based backend and a React-based frontend.

## Prerequisites

- php, php-sqlite3, php-dom, php-curl & php-xml >= **8.1**
- Composer
- Laravel Framework
- Nginx
- Node.js >= 15.14.0 and npm

### Local Development Setup

Make sure at least php 8.1 and all the extensions are installed

#### Backend Setup:

1. Navigate to the backend directory:
   ```bash
   cd tripbuilder-backend
   ```
2. Install PHP dependencies:

   ```bash
   composer install
   ```

3. Create required .env file

   ```
   DB_CONNECTION=sqlite
   ```

4. Create database.sqlite, migrate and seed database information:

   ```bash
   touch database/database.sqlite
   php artisan migrate:refresh --seed
   ```

5. Serve Laravel application:
   ```bash
   php artisan serve
   ```
   The api will now be accessible from http://localhost:8000/api

#### Frontend Setup:

1. Navigate to the frontend directory:
   ```bash
   cd tripbuilder-frontend
   ```
2. Install the required npm packages:
   ```bash
   npm install
   ```
3. Create required .env file

   ```
   REACT_APP_API_URL=http://[host]/api
   ```

4. Start the React development server:

   ```bash
   npm start
   ```

The React frontend should now be served at http://localhost:3000

#### Configuring Nginx as a Proxy

Here's a sample httpd.conf file that should work with the current setup.

```
server {
   listen 80;

   location /api/ {
      proxy_pass http://localhost:8000;
      proxy_set_header Host $host;
      proxy_set_header X-Real-IP $remote_addr;
      proxy_set_header X-Forwarded-For $proxy_add_x_forwarded_for;
      proxy_set_header X-Forwarded-Proto $scheme;
   }

   location /docs/ {
      proxy_pass http://localhost:8000;
      proxy_set_header Host $host;
      proxy_set_header X-Real-IP $remote_addr;
      proxy_set_header X-Forwarded-For $proxy_add_x_forwarded_for;
      proxy_set_header X-Forwarded-Proto $scheme;
   }

   location / {
      proxy_pass http://localhost:3000;
      proxy_set_header Host $host;
      proxy_set_header X-Real-IP $remote_addr;
      proxy_set_header X-Forwarded-For $proxy_add_x_forwarded_for;
      proxy_set_header X-Forwarded-Proto $scheme;
   }
}
```

Reload the nginx configuration and everything should be good to go.

```bash
sudo service nginx reload
```

### API Documentation

After serving the website, you can finid the api documentation at http://[host]/docs

Generated by Scribe
