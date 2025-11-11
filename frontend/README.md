# Pastelaria - Frontend

Frontend do sistema de gerenciamento de pedidos de pastelaria.

## 🚀 Tecnologias

- **Vue 3** - Framework progressivo
- **TypeScript** - Tipagem estática
- **Vite** - Build tool
- **Vue Router** - Roteamento
- **Axios** - Cliente HTTP
- **Vitest** - Framework de testes
- **PWA** - Progressive Web App

## ✅ Requisitos Implementados

### Funcionalidades
- ✅ Tela responsiva (@media queries)
- ✅ Validações client-side (validators.ts)
- ✅ Exibição amigável de erros do backend (ErrorAlert.vue)
- ✅ Configuração PWA (vite-plugin-pwa)

### CRUD Completo
- ✅ Clientes (nome, email, telefone, CEP)
- ✅ Produtos (nome, preço, foto, tipo)
- ✅ Pedidos (cliente + N produtos com quantidade/preço)

### Testes
- ✅ **98.31% de cobertura** (requisito: 90%)
- ✅ 30 testes unitários passando
- ✅ Components: 100% | Views: 98.38% | Utils: 100% | Services: 94.11%

## 📦 Instalação

```bash
npm install
```

## 🏃 Executar

```bash
# Desenvolvimento
npm run dev

# Build produção
npm run build

# Preview
npm run preview
```

## 🧪 Testes

```bash
# Executar testes
npm run test

# Cobertura de testes
npm run test:coverage
```

## 🔐 Autenticação

O sistema usa HTTP Basic Auth para comunicação com a API:
- **Usuário**: admin@pastelaria.local
- **Senha**: secret123

## 📁 Estrutura

```
src/
├── components/     # Componentes reutilizáveis
│   ├── ErrorAlert.vue
│   └── InputField.vue
├── views/          # Páginas/Views
│   ├── Home.vue
│   ├── Clientes.vue
│   ├── Produtos.vue
│   └── Pedidos.vue
├── services/       # API client
│   └── api.ts
├── utils/          # Utilitários
│   └── validators.ts
├── App.vue         # Componente raiz
├── main.ts         # Entry point
└── router.ts       # Configuração de rotas
```

## 🎨 Responsividade

A interface adapta-se automaticamente para dispositivos móveis usando CSS Grid e media queries:
- Desktop: Layout de 2 colunas nos formulários
- Mobile: Layout de 1 coluna (< 640px)

## 📱 PWA

O aplicativo está configurado como PWA (Progressive Web App):
- Service Worker com auto-update
- Cache de API requests
- Manifest configurado
- ⚠️ **Nota**: Adicione ícones `pwa-192x192.png` e `pwa-512x512.png` em `/public`

## 🔗 API Endpoints

- `GET/POST /api/clientes`
- `DELETE /api/clientes/:id`
- `GET/POST /api/produtos`
- `DELETE /api/produtos/:id`
- `GET/POST /api/pedidos`
- `DELETE /api/pedidos/:id`
