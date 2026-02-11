# Instruções de Instalação e Execução

Este guia detalha o passo a passo para rodar o projeto em ambiente local. A aplicação foi dockerizada para facilitar a execução e garantir compatibilidade, mas também pode ser executada manualmente via servidor embutido do PHP.

## Pré-requisitos

* **Git** 
* **Docker** e **Docker Compose** 
* **PHP 7.4** e **MySQL 5.7+** 

---

## Opção A: Execução via Docker 

Esta é a forma mais rápida e limpa de rodar o projeto, pois sobe o servidor PHP, Nginx e Banco de Dados automaticamente em containers isolados.

### 1. Obter o Projeto

Você pode obter o projeto de duas formas:

**Opção 1: Clonar do GitHub**

```bash
git clone git@github.com:araujo-leo/starwars-project.git
cd starwars-project
```

**Opção 2: Extrair arquivo compactado**

Se você recebeu o projeto como arquivo .zip, extraia-o e navegue até a pasta:

```bash
unzip starwars-project.zip
cd starwars-project
```

### 2. Configurar Variáveis de Ambiente

O projeto utiliza variáveis de ambiente para conexão com banco e configurações gerais. Copie o arquivo de exemplo para o arquivo de produção:

```bash
cp .env-example .env
```

**Nota:** O arquivo `.env-example` já vem pré-configurado com as credenciais padrão do Docker Compose.

### 3. Subir os Containers

Na raiz do projeto, execute o comando abaixo para construir as imagens e iniciar os serviços:

```bash
docker-compose up -d --build
```

Aguarde alguns instantes enquanto o Docker baixa as imagens e configura o ambiente.

### 4. Banco de Dados

O container do banco de dados executará automaticamente o script `database/init.sql` na primeira inicialização.

Caso precise importar manualmente ou resetar o banco, o dump atualizado está localizado na pasta: `database/dump.sql`.

### 5. Acessar a Aplicação

Abra o navegador e acesse o endereço local: `http://localhost:8080` (Caso tenha alterado a porta no arquivo `.env`, utilize a porta configurada)

---

## Opção B: Execução Manual (Servidor Embutido PHP)

Caso não queira usar Docker, siga estes passos:

### 1. Banco de Dados

Crie um banco de dados MySQL local.

Importe o arquivo `database/dump.sql` contido no pacote.

Edite o arquivo `.env` com suas credenciais locais (`DB_HOST`, `DB_USER`, `DB_PASS`).

### 2. Instalar Dependências


```bash
composer install
```

### 3. Iniciar Servidor

Na raiz do projeto, execute o servidor embutido do PHP apontando para a pasta pública:

```bash
php -S localhost:8080
```

### 4. Acessar

Abra `http://localhost:8080` no navegador.
