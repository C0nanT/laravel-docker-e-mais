# Laravel Docker

Um projeto simples com o objetivo de crescer com base na necessidade. Este projeto serve como um campo de prática para:

- Laravel
- Docker
- Princípios SOLID
- API RESTful
- Integração com banco de dados
- Integração com Grafana
- Testes com Pest
- E outras tecnologias que possam surgir.

## Pré-requisitos

Inicie os containers do Docker:
```bash
docker compose up -d
```

Acesse o container da aplicação:
```bash
docker compose exec -it app bash
```

Configure o ambiente Laravel:
```bash
cp .env.example .env
composer install
php artisan key:generate
php artisan migrate
php artisan db:seed
```

## Executando a aplicação
Acesse o container da aplicação:
```bash
php artisan serve --host 0.0.0.0
```

## Rodando PEST dentro do Docker
Suba o container temporário de testes:
```bash
docker compose run test
```

Esse comando gera um container temporário, e sempre criará um novo, caso queira rodar os testes e remover os antigos, você pode usar o comando:
```bash
docker compose run --remove-orphans test
```