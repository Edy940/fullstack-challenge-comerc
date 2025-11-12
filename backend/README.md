$readme = @'
# 🍴 Fullstack Challenge – Comerc  
### Sistema de Gerenciamento de Pedidos – *Pastelaria*  

Aplicação **Fullstack** desenvolvida com **Laravel 11 (API)** e **Vue 3 + Vite (Frontend)**, totalmente **dockerizada**, responsiva e com **testes automatizados acima de 90% de cobertura**.

## 📁 Estrutura do Projeto

/backend     → Laravel API (Clientes, Produtos, Pedidos)
/frontend    → Vue 3 + Vite + PWA
/docker      → Arquivos Docker (PHP-FPM, Nginx, MySQL, Mailhog)
/scripts     → Scripts PowerShell (subir, atualizar, parar)

## Definição dos EndPoints no backend
📁 backend/
├── 📁 routes/
│   └── api.php                    ← Define os endpoints (GET, POST, DELETE, etc)
├── 📁 app/Http/Controllers/
│   ├── ClienteController.php      ← Lógica do GET, POST, DELETE de clientes
│   ├── ProdutoController.php      ← Lógica do GET, POST, DELETE de produtos
│   └── PedidoController.php       ← Lógica do GET, POST, DELETE de pedidos
---

## 🚀 Como Executar (Windows PowerShell)

> **Pré-requisitos:** 
> - Docker Desktop instalado e **RODANDO** (verifique se o ícone está verde na bandeja)

### 1. Clonar o repositório

```bash
git clone https://github.com/Edy940/fullstack-challenge-comerc.git
cd fullstack-challenge-comerc
```

### 2. Na raiz do projeto, execute:

# subir tudo (API, DB, Mailhog, Front)
Subir ambiente
.\scripts\up.ps1
Resultado no Shell ao subir o ambiente (Clique nos links e seja direcionado)
== Pronto! ==
API:      http://localhost:8080
Frontend: http://localhost:5173
Mailhog:  http://localhost:8025

# Se quiser fazer rebuild
Rebuild completo
.\scripts\up.ps1 -Rebuild

# Se quiser zerar o banco para novos testes 
Recriar banco e dados de exemplo
.\scripts\refresh.ps1

# subir tudo (API, DB, Mailhog, Front)
.\scripts\down.ps1

2.2 Utilizando o Docker
 docker compose up -d
---

## 🧪 Testes

### Backend (Laravel)

```bash
# Executar todos os testes com cobertura
docker compose exec api-php php artisan test --coverage

# Executar um teste específico
docker compose exec api-php php artisan test --filter=test_email_unico

# Ou especificar o arquivo completo
docker compose exec api-php php artisan test tests/Feature/ClienteTest.php

# Cobertura alcançada: 97.3%
# Total: 17 testes, 67 assertions
```

### Frontend (Vue + Vitest)

```bash
# Executar testes com cobertura
docker compose exec web npm run test:coverage -- --run

# Cobertura alcançada: 98.31%
# Total: 30 testes
```

---

## 📋 Regras de Negócio Implementadas

Todas as **8 regras de negócio** foram implementadas e testadas:

### ✅ 1. E-mail único para clientes
- **Validação:** `unique:clientes,email`
- **Teste automatizado:** `backend/tests/Feature/ClienteTest.php::test_email_unico()`
- **Rodar o teste:**
  ```bash
  docker compose exec api-php php artisan test --filter=test_email_unico
  ```
- **Como testar manualmente:**
  1. Crie um cliente com e-mail "teste@email.com"
  2. Tente criar outro com o mesmo e-mail → Erro: "O e-mail já está em uso."

### ✅ 2. Produtos devem ter foto obrigatória
- **Validação:** `'foto' => 'required|string'`
- **Teste automatizado:** `backend/tests/Feature/ProdutoTest.php::test_foto_obrigatoria()`
- **Rodar o teste:**
  ```bash
  docker compose exec api-php php artisan test --filter=test_foto_obrigatoria
  ```
- **Como testar manualmente:**
  1. Na interface de Produtos, tente salvar sem preencher o campo "Foto"
  2. Ou via API: `POST /api/produtos` sem campo `foto` → Erro 422
  3. **Nota:** O campo aceita qualquer string (URL, caminho ou nome de arquivo)

### ✅ 3. Apenas produtos com foto podem compor pedidos
- **Implementação:** Validação no backend antes de criar pedido
- **Teste:** `backend/tests/Feature/PedidoTest.php` (validação implícita)
- **Como testar:**
  1. Todos os produtos criados pela interface já têm foto obrigatória (regra #2)
  2. Se tentar criar pedido com produto sem foto no BD → Erro

### ✅ 4. Soft delete em todas as tabelas
- **Implementação:** Trait `SoftDeletes` em todos os modelos
- **Teste automatizado:** `backend/tests/Unit/ModelsExtrasTest.php::test_soft_deletes()`
- **Rodar o teste:**
  ```bash
  docker compose exec api-php php artisan test --filter=test_soft_deletes
  ```
- **Como testar manualmente:**
  1. Delete qualquer registro (Cliente, Produto, Pedido)
  2. No banco: `SELECT * FROM clientes WHERE deleted_at IS NOT NULL`
  3. Registro não é removido, apenas marcado com `deleted_at`

### ✅ 5. Envio de e-mail ao criar pedido
- **Implementação:** `App\Mail\PedidoCriadoMail` + observer
- **Teste automatizado:** `backend/tests/Feature/PedidoTest.php::test_criar_pedido_envia_email()`
- **Rodar o teste:**
  ```bash
  docker compose exec api-php php artisan test --filter=test_criar_pedido_envia_email
  ```
- **Como testar manualmente:**
  1. Crie um pedido pela interface
  2. Acesse http://localhost:8025 (Mailhog)
  3. Verifique o e-mail enviado com detalhes do pedido

### ✅ 6. Validação: telefone deve ter apenas números
- **Validação:** `'telefone' => 'required|digits_between:10,11'`
- **Frontend:** Máscara automática remove caracteres não numéricos antes de enviar
- **Como testar:**
  1. Campo aceita entrada formatada: `(11) 98765-4321`
  2. Backend recebe apenas: `11987654321`

### ✅ 7. Relacionamento N:N entre Pedidos e Produtos
- **Implementação:** Tabela pivot `pedido_itens`
- **Teste automatizado:** `backend/tests/Unit/ModelsRelationshipsTest.php::test_pedido_produtos_relationship()`
- **Rodar o teste:**
  ```bash
  docker compose exec api-php php artisan test --filter=test_pedido_produtos_relationship
  ```
- **Como testar manualmente:**
  1. Crie um pedido com múltiplos produtos
  2. No banco: `SELECT * FROM pedido_itens`
  3. Múltiplas linhas ligam um pedido a vários produtos

### ✅ 8. Nomenclatura em português
- **Implementação:** Todas tabelas, campos e variáveis em PT-BR
- **Exemplos:** `clientes`, `pedidos`, `tipo_produto_id`, `preco`, `quantidade`
- **Validações:** Mensagens traduzidas em `backend/lang/pt_BR/validation.php`

---

## 🔐 Autenticação

**HTTP Basic Auth** configurado:
- **Usuário:** `admin@pastelaria.local`
- **Senha:** `secret123`

Criado automaticamente pelo seeder. Todas as requisições à API exigem autenticação.

