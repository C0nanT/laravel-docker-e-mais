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

Inicie os containers no Docker:
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

Reinicie e alimente os bancos caso necessário: 
```bash
./reset.sh
```

```bash
php artisan migrate
php artisan db:seed
```

## Executando a aplicação
Acesse o container da aplicação:
```bash
php artisan serve --host 0.0.0.0
```

## Rodando PEST dentro do Docker
Certifique-se de que o container do app está rodando e execute os testes com o seguinte comando:
```bash
./tests.sh
```