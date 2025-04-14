# Laravel Docker

<!-- A simple test project with no specific goals other than to grow based on necessity. This project serves as a practice ground for: -->
Um projeto simples com o objetivo de crescer com base na necessidade. Este projeto serve como um campo de prática para:

- Laravel
- Docker
- Princípios SOLID
- API RESTful
- Integração com banco de dados
- Integração com Grafana
- E outras tecnologias que possam surgir.

## Setup

Start the Docker containers:
```bash
docker compose up -d
```

Access the application container:
```bash
docker compose exec -it app bash
```

Set up the Laravel environment:
```bash
cp .env.example .env
composer install
php artisan key:generate
php artisan migrate
php artisan db:seed
```

Run the application:
```bash
php artisan serve --host 0.0.0.0
```