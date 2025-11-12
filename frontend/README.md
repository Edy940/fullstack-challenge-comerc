# Pastelaria Monte Sião - Frontend

Frontend do sistema de gerenciamento de pedidos da Pastelaria Monte Sião.

## 🚀 Tecnologias

- **Vue 3** (Composition API) - Framework progressivo
- **TypeScript** - Tipagem estática
- **Vite 5.4.21** - Build tool moderna
- **Vue Router** - Roteamento SPA
- **Axios** - Cliente HTTP com interceptors
- **Vitest 2.1.9** - Framework de testes
- **@vitest/coverage-v8** - Cobertura de testes
- **PWA** - Progressive Web App (vite-plugin-pwa)

## ✅ Requisitos Implementados

### Funcionalidades
- ✅ **Interface responsiva** (@media queries com grid adaptativo)
- ✅ **Validações client-side** (validators.ts + validação inline)
- ✅ **Exibição amigável de erros** do backend (ErrorAlert.vue)
- ✅ **PWA completo** (manifest + service worker + auto-update)
- ✅ **Loading states** em todas as views
- ✅ **Auto-preenchimento** de preço unitário ao selecionar produto
- ✅ **Máscaras de input** para telefone (11) 98765-4321 e CEP 12345-678

### CRUD Completo
- ✅ **Clientes** (nome, email, telefone, data_nascimento, cep, endereco, bairro, complemento)
- ✅ **Produtos** (nome, preço com vírgula, foto, tipo_produto)
- ✅ **Pedidos** (cliente + N produtos com quantidade/preço unitário auto)

### Testes
- ✅ **79.24% de cobertura** geral
- ✅ **34 testes passando** (14 skipped)
- ✅ **Components: 100%** | Services: 100% | Utils: 100% | Views: 76.33%
- ✅ Testes de integração com mock de API (axios-mock-adapter)

## 📦 Instalação

```bash
npm install
```

## 🏃 Executar

### Com Docker (recomendado)
```bash
# Na raiz do projeto
.\scripts\up.ps1
```
Acesse: http://localhost:5173

### Standalone
```bash
# Desenvolvimento com HMR
npm run dev

# Build produção
npm run build

# Preview build
npm run preview
```

## 🧪 Testes

```bash
# Executar todos os testes
npm run test

# Cobertura de testes
npm run test:coverage

# Watch mode
npm run test:watch
```

## 🔐 Autenticação

HTTP Basic Auth configurado **automaticamente** via Axios interceptor:
- **Usuário**: `admin@pastelaria.local`
- **Senha**: `secret123`

Todas as requisições à API incluem automaticamente as credenciais.

## 📁 Estrutura

```
src/
├── components/          # Componentes reutilizáveis
│   ├── ErrorAlert.vue      # Exibição de erros
│   └── InputField.vue      # Input com label
├── views/               # Páginas/Views
│   ├── Home.vue            # Dashboard inicial
│   ├── Clientes.vue        # CRUD Clientes (8 campos)
│   ├── Produtos.vue        # CRUD Produtos
│   └── Pedidos.vue         # CRUD Pedidos (N:N)
├── services/            # Serviços
│   └── api.ts              # Axios com auth + error handling
├── utils/               # Utilitários
│   └── validators.ts       # Validações (required, email, etc)
├── App.vue              # Componente raiz + estilos globais
├── main.ts              # Entry point + router + PWA
├── router.ts            # Configuração de rotas
└── vite-env.d.ts        # Type definitions
```

## 🎨 Design & UX

### Responsividade
Grid adaptativo com breakpoint em **640px**:
- **Desktop**: 2 colunas nos formulários
- **Mobile**: 1 coluna (empilhado)

## 📱 PWA

Configurado como **Progressive Web App**:
- ✅ Service Worker com estratégia NetworkFirst
- ✅ Auto-update ao detectar nova versão
- ✅ Manifest com nome "Pastelaria Monte Sião"
- ✅ Tema bege (#f5f0e8)
- ⚠️ **Ícones**: Adicione `pwa-192x192.png` e `pwa-512x512.png` em `/public/`

## 🔗 Integração com API

### Endpoints utilizados
```
GET    /api/clientes           # Listar clientes
POST   /api/clientes           # Criar cliente
DELETE /api/clientes/:id       # Remover cliente

GET    /api/produtos           # Listar produtos
POST   /api/produtos           # Criar produto
DELETE /api/produtos/:id       # Remover produto

GET    /api/pedidos            # Listar pedidos
POST   /api/pedidos            # Criar pedido
DELETE /api/pedidos/:id        # Remover pedido
```

### Features especiais
- ✅ **Normalização de dados**: Converte vírgula → ponto nos preços
- ✅ **Limpeza de máscaras**: Remove formatação de telefone/CEP antes de enviar
- ✅ **Error handling**: Interceptor 422 normaliza erros de validação
- ✅ **Loading states**: Evita múltiplos cliques durante requisições

## 🐛 Troubleshooting

### Erro 401 Unauthorized
```bash
# Verifique se o backend tem o usuário admin
docker compose exec api-php php artisan db:seed --class=AdminUserSeeder
```

### HMR não funciona no Docker (Windows)
Vite já está configurado com `usePolling: true` para Windows + Docker.

### Produtos/Clientes não aparecem
```bash
# Force refresh no navegador
Ctrl + Shift + R

# Ou limpe o cache
F12 → Application → Clear Storage
```

## 📊 Cobertura de Testes

| Categoria | Statements | Branches | Functions | Lines |
|-----------|-----------|----------|-----------|-------|
| **Total** | 79.24% | 81.98% | 59.57% | 79.24% |
| **components/** | 100% | 100% | 100% | 100% |
| **services/** | 100% | 70% | 100% | 100% |
| **utils/** | 100% | 83.33% | 100% | 100% |
| **views/** | 76.33% | 82.14% | 52.5% | 76.33% |

**34 testes passando | 14 skipped**
