# Star Wars Api

![PHP](https://img.shields.io/badge/PHP-7.4-777BB4?style=flat&logo=php&logoColor=white)
![Docker](https://img.shields.io/badge/Docker-Compose-2496ED?style=flat&logo=docker&logoColor=white)

A simple, robust web application to browse Star Wars films. Built with **Vanilla PHP 7.4** using a custom **MVC architecture** and consuming the **SWAPI**.


## 🛠️ Quick Start

### Using Docker (Recommended)

1.  **Clone and Setup:**
    ```bash
    git clone git@github.com:araujo-leo/starwars-project.git
    cd starwars-wiki
    cp .env-example .env
    ```

2.  **Run:**
    ```bash
    docker compose up -d --build
    ```

3.  **Access:**
    Open [http://localhost:8080](http://localhost:8080)

### Manual Installation

1.  Start a MySQL database and import `src/Config/init.sql`.
2.  Update `.env` with your database credentials.
3.  Run the PHP server: `php -S localhost:8080`

## 📡 API Endpoints

The internal API acts as a proxy to the SWAPI to handle logging and formatting.

| Method | Endpoint | Description |
| :--- | :--- | :--- |
| `GET` | `/api/films` | List all films |
| `GET` | `/api/films/{id}` | Get film details |
| `GET` | `/api/people` | List all characters |
| `GET` | `/api/people/{id}` | Get character details |
| `GET` | `/api/planets` | List all planets |
| `GET` | `/api/planets/{id}` | Get planet details |
| `GET` | `/api/starships` | List all starships |
| `GET` | `/api/starships/{id}` | Get starship details |
| `GET` | `/api/vehicles` | List all vehicles |
| `GET` | `/api/vehicles/{id}` | Get vehicle details |
| `GET` | `/api/species` | List all species |
| `GET` | `/api/species/{id}` | Get species details |
