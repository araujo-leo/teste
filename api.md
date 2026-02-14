## Documentação da API

### Base URL

`http://localhost:8080/api`

### Formato de Resposta

Todas as respostas são em formato JSON.

---

## Endpoints Disponíveis

### 1. Auth

| Método | Rota            | Descrição                                                   |
|:-------|:----------------|:------------------------------------------------------------|
| `POST` | `/api/login`    | Retorna o token de autenticação do usuário, além dos dados. |
| `POST` | `/api/register` | Cadastra os dados do usuário no sistema.                    |

### 2. Products (Produtos)

| Método | Rota                | Descrição                                  |
|:-------|:--------------------|:-------------------------------------------|
| `POST` | `/api/product`      | Cadastra os produtos no sistema.           |
| `PUT`  | `/api/product/{id}` | Edita um produto específico.               |
| `GET`  | `/api/products`     | Retorna os produtos cadastrados no sistema |


### 3. Suppliers (Fornecedores)

| Método | Rota                 | Descrição                                       |
|:-------|:---------------------|:------------------------------------------------|
| `POST` | `/api/supplier`      | Cadastra um fornecedor no sistema.              |
| `PUT`  | `/api/supplier/{id}` | Edita um fornecedor específico.                 |
| `GET`  | `/api/suppliers`     | Retorna os fornecedores cadastrados no sistema. |


### 4. Links supplier-product (Vínculos entre fornecedores e produtos)

| Método   | Rota                                             | Descrição                                                 |
|:---------|:-------------------------------------------------|:----------------------------------------------------------|
| `POST`   | `/api/link-product-supplier`                     | Cria vínculo entre produto e fornecedor.                  |
| `GET`    | `/api/products/{id}/suppliers`                   | Retorna os fornecedores vinculados a um produto.          |
| `GET`    | `/api/suppliers/{id}/products`                   | Retorna os produtos vinculados a um fornecedor.           |
| `DELETE` | `/api/products/{productId}/suppliers/{supplierId}` | Remove vínculo específico entre produto e fornecedor.   |
| `DELETE` | `/api/products/{id}/suppliers`                   | Remove todos os fornecedores vinculados a um produto.     |
| `DELETE` | `/api/suppliers/{id}/products`                   | Remove todos os produtos vinculados a um fornecedor.      |

---

## Autenticação

A API utiliza **JWT (JSON Web Token)** para autenticação.

### Como autenticar:

1. Faça login no endpoint `/api/login`
2. Receba o token JWT na resposta
3. Inclua o token no header das requisições protegidas:

```
Authorization: Bearer {TOKEN}
```

### Rotas públicas:
- `POST /api/login`
- `POST /api/register`

### Rotas protegidas (requerem autenticação):
- Todas as rotas de produtos, fornecedores e vínculos

### Rotas administrativas (requerem perfil Admin):
- `POST /api/product`
- `PUT /api/product/{id}`
- `POST /api/supplier`
- `PUT /api/supplier/{id}`
- `POST /api/link-product-supplier`
- `DELETE` (todos os endpoints de remoção)



---

## Códigos de Resposta

| Código | Descrição |
|:-------|:----------|
| `200`  | Sucesso |
| `201`  | Criado com sucesso |
| `400`  | Requisição inválida |
| `401`  | Não autenticado |
| `403`  | Acesso negado (não é admin) |
| `404`  | Recurso não encontrado |
| `409`  | Conflito (registro duplicado) |
| `500`  | Erro interno do servidor |
