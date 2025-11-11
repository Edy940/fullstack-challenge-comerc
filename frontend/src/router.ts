import { createRouter, createWebHistory } from "vue-router";
import Home from "./views/Home.vue";
import Clientes from "./views/Clientes.vue";
import Produtos from "./views/Produtos.vue";
import Pedidos from "./views/Pedidos.vue";

export default createRouter({
  history: createWebHistory(),
  routes: [
    { path: "/", component: Home },
    { path: "/clientes", component: Clientes },
    { path: "/produtos", component: Produtos },
    { path: "/pedidos", component: Pedidos }
  ]
});