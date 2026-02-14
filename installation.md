# Instalação

## Opção 1: Docker (Recomendado)

### Pré-requisitos
- Docker
- Docker Compose

### Passos

1. **Clone o repositório**
```bash
git clone git@github.com:araujo-leo/teste.git
cd teste-pratico
```

2. **Configure o .env**
```bash
cp .env.example .env
```

3. **Suba os containers**
```bash
docker-compose up -d --build
```

4**Acesse**
```
http://localhost:8080
```

**Credenciais:**
- Admin: `admin@example.com` / `senha`
- User: `user@example.com` / `senha`

---

## Opção 2: PHP Built-in Server

### Pré-requisitos
- PHP 7.4+
- MySQL 8.0+
- Composer

### Passos

1. **Clone e instale**
```bash
git clone <seu-repositorio>
cd teste-pratico
composer install
```

2. **Configure o .env**
```bash
cp .env.example .env
# Edite DB_HOST para localhost ou seu servidor MySQL
```

3. **Crie o banco**
```bash
mysql -u root -p < docker/db/init.sql
```

4. **Rode o servidor**
```bash
php -S localhost:8080
```

5. **Acesse**
```
http://localhost:8080
```

**Credenciais:**
- Admin: `admin@example.com` / `senha`
- User: `user@example.com` / `senha`

