# Decisões Técnicas

## Banco de Dados

### Modelo
```
products (id, internal_code, name, description, price, status)
suppliers (id, cnpj, company_name, email, phone, status)
supplier_products (id, supplier_id, product_id)
```

**Relacionamento N:N** entre produtos e fornecedores por tabela pivô.

---

## Arquitetura

**MVC puro em PHP**

- **Model:** PDO com prepared statements (proteção SQL Injection)
- **Controller:** Validação e lógica de negócio
- **View:** PHP + jQuery + Bootstrap

**Router customizado** com middlewares de autenticação/autorização.

---

## Diferenciais Implementados

**Opção A - UX:**
- Feedback visual (toasts, spinners)
- Máscaras de entrada
- Interface intuitiva para o vínculo

**Opção B - Regras:**
- Bloqueia vínculo com fornecedor inativo

**Opção C - Organização:**
- MVC bem separado
- BaseController reutilizável
- Middlewares de segurança

**Extra:**
- Sistema de autenticação JWT
- Controle de acesso Admin/User
- Docker compose

Implementei as três opções de criatividade (A, B e C), ficando alguns requisitos de fora por conta do tempo. Além disso, adicionei autenticação JWT e controle de acesso para demonstrar conhecimento de segurança e organização, mesmo não sendo requisito obrigatório.

---

## Melhorias Futuras

- Busca e filtros
- Paginação
- Testes automatizados
- Sistema de logs
- Validação avançada de campos
