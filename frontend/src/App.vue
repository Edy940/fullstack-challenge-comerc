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
:root { --primary: #2563eb; --muted: #eef2ff; }
body { margin: 0; font-family: system-ui, -apple-system, Segoe UI, Roboto, Arial, sans-serif; background:#f8fafc; }
.container { max-width: 1000px; margin: 0 auto; padding: 16px; }
.appbar { display:flex; gap:16px; align-items:center; justify-content:space-between; }
nav a { margin-right: 12px; color: var(--primary); text-decoration:none; }
nav a.router-link-active { font-weight: 700; }
.content { margin-top: 20px; background:#fff; padding: 16px; border-radius: 12px; box-shadow: 0 1px 4px rgba(0,0,0,.06); }
.form-row { display:grid; grid-template-columns: 1fr 1fr; gap:12px; }
@media (max-width: 640px){ .form-row { grid-template-columns: 1fr; } }
.btn { background: var(--primary); color:#fff; padding:8px 12px; border:0; border-radius:8px; cursor:pointer; }
.btn.ghost { background:#e2e8f0; color:#111827; }
.table { width:100%; border-collapse: collapse; }
.table th, .table td { padding: 8px; border-bottom: 1px solid #eee; }
.alert { background:#fee2e2; color:#991b1b; padding: 8px 12px; border-radius: 8px; margin-bottom:12px; }
</style>