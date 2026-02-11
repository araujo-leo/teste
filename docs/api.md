## Documentação da API Interna

A aplicação opera sob uma arquitetura **Backend-for-Frontend (BFF)**. O Frontend não se comunica diretamente com a API externa (SWAPI). Em vez disso, ele faz requisições para nossa API local, que processa os dados, registra logs de auditoria e performance, e então retorna a resposta formatada.

### Base URL

`http://localhost:8080/api`

### Formato de Resposta

Todas as respostas são em formato JSON.

---

## Endpoints Disponíveis

### 1. Filmes (Films)

| Método | Rota | Descrição |
| :--- | :--- | :--- |
| `GET` | `/api/films` | Retorna a lista completa de filmes, ordenados por data de lançamento. |
| `GET` | `/api/films/{id}` | Retorna os detalhes de um filme específico (incluindo cálculo de idade). |

### 2. Personagens (People)

| Método | Rota | Descrição |
| :--- | :--- | :--- |
| `GET` | `/api/people` | Lista personagens (paginado pela SWAPI). |
| `GET` | `/api/people/{id}` | Retorna detalhes de um personagem específico. |

### 3. Planetas (Planets)

| Método | Rota | Descrição |
| :--- | :--- | :--- |
| `GET` | `/api/planets` | Lista planetas. |
| `GET` | `/api/planets/{id}` | Retorna detalhes de um planeta específico. |

### 4. Naves e Veículos

| Método | Rota | Descrição |
| :--- | :--- | :--- |
| `GET` | `/api/starships/{id}` | Detalhes de uma nave estelar. |
| `GET` | `/api/vehicles/{id}` | Detalhes de um veículo de transporte. |

### 5. Espécies

| Método | Rota | Descrição |
| :--- | :--- | :--- |
| `GET` | `/api/species/{id}` | Detalhes de uma espécie alienígena. |

---

## Auditoria e Logs

Toda requisição feita a estes endpoints gera automaticamente um registro na tabela `api_logs` contendo:
* Endpoint acessado.
* Método HTTP.
* Código de Status (200, 404, 500).
* **Tempo de Resposta (ms):** Latência total do processamento backend + request externo.
* Timestamp da solicitação.