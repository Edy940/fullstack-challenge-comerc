$readme = @'
# 🍴 Fullstack Challenge – Comerc  
### Sistema de Gerenciamento de Pedidos – *Pastelaria*  

Aplicação **Fullstack** desenvolvida com **Laravel 11 (API)** e **Vue 3 + Vite (Frontend)**, totalmente **dockerizada**, responsiva e com **testes automatizados acima de 90% de cobertura**.


---

## 🚀 Como Executar (Windows PowerShell)

> Pré-requisitos: **Docker Desktop** e **Docker Compose** instalados.

Na raiz do projeto, execute:

# subir tudo (API, DB, Mailhog, Front)
.\scripts\up.ps1

# ou: docker compose up -d

Primeira vez (gera chave e estrutura de BD + seeds) já é feito pelo script up.ps1.
Acesse:
API (Nginx): http://localhost:8080
Mailhog: http://localhost:8025
