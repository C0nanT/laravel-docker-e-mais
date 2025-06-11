#!/bin/bash

# Definir cores para melhor visualização
GREEN='\033[0;32m'
BLUE='\033[0;34m'
RED='\033[0;31m'
NC='\033[0m' # No Color

# Funções auxiliares
function echo_step() {
  echo -e "${BLUE}==>${NC} $1"
}

function echo_success() {
  echo -e "${GREEN}==>${NC} $1"
}

function echo_error() {
  echo -e "${RED}==>${NC} $1"
}

# Pasta atual
CURRENT_DIR=$(pwd)
echo_step "Diretório atual: $CURRENT_DIR"

# Verificar se estamos na pasta do projeto
if [[ "$CURRENT_DIR" != *"laravel-docker-e-mais"* ]]; then
  echo_error "Por favor, execute este script da pasta do projeto laravel-docker-e-mais"
  exit 1
fi

# 1. Limpar o banco de dados de testes
echo_step "Limpando o banco de dados de testes..."
docker compose exec -e DB_CONNECTION=pgsql_testing -e DB_HOST=db_tests -e DB_DATABASE=laravel_testing app php artisan migrate:fresh
echo_success "Banco de dados de testes limpo com sucesso!"

# 2. Executar migrações no banco de dados de testes (sem seeders)
echo_step "Executando migrações no banco de dados de testes (sem seeders)..."
docker compose exec -e DB_CONNECTION=pgsql_testing -e DB_HOST=db_tests -e DB_DATABASE=laravel_testing app php artisan migrate
echo_success "Migrações no banco de dados de testes concluídas!"

# 3. Executar os testes com o Pest
echo_step "Executando testes com o Pest..."
docker compose exec app php artisan test --env=testing
TEST_RESULT=$?

# 4. Verificar o resultado dos testes
if [ $TEST_RESULT -eq 0 ]; then
  echo_success "Todos os testes passaram com sucesso!"
else
  echo_error "Alguns testes falharam. Verifique os detalhes acima."
fi

exit $TEST_RESULT
