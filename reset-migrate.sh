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

# 1. Derrubar os contêineres existentes
echo_step "Derrubando os contêineres existentes..."
docker compose down
echo_success "Contêineres derrubados com sucesso!"

# 2. Subir os contêineres novamente
echo_step "Subindo os contêineres novamente..."
docker compose up -d
echo_success "Contêineres iniciados em segundo plano!"

# 3. Esperar um pouco para garantir que os bancos de dados estejam prontos
echo_step "Aguardando os bancos de dados inicializarem..."
sleep 5

# 4. Executar as migrações no banco de dados principal
echo_step "Executando migrações no banco de dados principal..."
docker compose exec app php artisan migrate:fresh --seed
echo_success "Migrações no banco de dados principal concluídas!"

# 5. Executar as migrações no banco de dados de testes
echo_step "Executando migrações no banco de dados de testes..."
docker compose exec -e DB_CONNECTION=pgsql_testing -e DB_HOST=db_tests -e DB_DATABASE=laravel_testing app php artisan migrate:fresh
echo_success "Migrações no banco de dados de testes concluídas!"

echo_success "Processo completo! Ambos os bancos de dados foram configurados com sucesso."
