<template>
  <main class="container">
    <header class="appbar">
      <h1>🥟Sistema Monte Sião</h1>
      <nav>
        <RouterLink to="/">Home</RouterLink>
        <RouterLink to="/clientes">Clientes</RouterLink>
        <RouterLink to="/produtos">Produtos</RouterLink>
        <RouterLink to="/pedidos">Pedidos</RouterLink>
      </nav>
    </header>
    <section class="content">
      <RouterView />
    </section>
  </main>
</template>

<style>
:root { 
  --primary: #2563eb; 
  --muted: #eef2ff; 
  --bg-beige: #f5f0e8;
  --bg-sand: #ebe4d8;
  --card-bg: #fefbf6;
}
body { 
  margin: 0; 
  font-family: system-ui, -apple-system, Segoe UI, Roboto, Arial, sans-serif; 
  background: linear-gradient(135deg, #f5f0e8 0%, #ebe4d8 100%);
  min-height: 100vh;
}
.container { max-width: 1000px; margin: 0 auto; padding: 16px; }
.appbar { 
  display:flex; 
  gap:16px; 
  align-items:center; 
  justify-content:space-between; 
  background: rgba(255, 255, 255, 0.85);
  backdrop-filter: blur(10px);
  padding: 16px;
  border-radius: 12px;
  box-shadow: 0 2px 8px rgba(139, 117, 95, 0.12);
}
nav a { margin-right: 12px; color: var(--primary); text-decoration:none; }
nav a.router-link-active { font-weight: 700; }
.content { 
  margin-top: 20px; 
  background: var(--card-bg); 
  padding: 24px; 
  border-radius: 12px; 
  box-shadow: 0 2px 12px rgba(139, 117, 95, 0.15);
  border: 1px solid rgba(139, 117, 95, 0.12);
}
.form-row { display:grid; grid-template-columns: 1fr 1fr; gap:12px; }
@media (max-width: 640px){ .form-row { grid-template-columns: 1fr; } }
.btn { background: var(--primary); color:#fff; padding:8px 12px; border:0; border-radius:8px; cursor:pointer; }
.btn.ghost { background:#ddd4c7; color:#111827; }
.table { width:100%; border-collapse: collapse; }
.table th, .table td { padding: 8px; border-bottom: 1px solid #e8dfd2; }
.table th { background: #f5f0e8; font-weight: 600; }
.table tbody tr:hover { background: #f9f5ee; }
.alert { background:#fee2e2; color:#991b1b; padding: 8px 12px; border-radius: 8px; margin-bottom:12px; }
</style>