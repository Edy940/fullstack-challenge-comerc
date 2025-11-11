<template>
  <div>
    <h2>Pedidos</h2>

    <ErrorAlert :messages="errors" />

    <form @submit.prevent="salvar">
      <div class="form-row">
        <label class="field">
          <span>Cliente</span>
          <select v-model.number="form.cliente_id">
            <option :value="c.id" v-for="c in clientes" :key="c.id">{{ c.nome }}</option>
          </select>
        </label>
        <button class="btn ghost" type="button" @click="addItem">+ Item</button>
      </div>

      <div v-for="(i,idx) in form.itens" :key="idx" class="form-row" style="align-items:end">
        <label class="field">
          <span>Produto</span>
          <select v-model.number="i.produto_id">
            <option :value="p.id" v-for="p in produtos" :key="p.id">{{ p.nome }} (R$ {{ p.preco.toFixed(2) }})</option>
          </select>
        </label>
        <InputField label="Quantidade" type="number" v-model="i.quantidade" />
        <InputField label="Preço unitário" type="number" v-model="i.preco_unitario" />
        <button class="btn ghost" type="button" @click="removerItem(idx)">Remover</button>
      </div>

      <button class="btn" type="submit">Criar Pedido</button>
    </form>

    <hr style="margin:16px 0" />

    <table class="table">
      <thead><tr><th>#</th><th>Cliente</th><th>Total</th><th></th></tr></thead>
      <tbody>
        <tr v-for="p in lista" :key="p.id">
          <td>{{ p.id }}</td>
          <td>{{ p.cliente?.nome }}</td>
          <td>R$ {{ Number(p.total).toFixed(2) }}</td>
          <td><button class="btn ghost" @click="remover(p.id)">Remover</button></td>
        </tr>
      </tbody>
    </table>
  </div>
</template>

<script setup lang="ts">
import api from "@/services/api";
import InputField from "@/components/InputField.vue";
import ErrorAlert from "@/components/ErrorAlert.vue";
import { ref, onMounted } from "vue";
import { required, minValue } from "@/utils/validators";

const auth = { auth: { username: "admin@pastelaria.local", password: "secret123" } };

const clientes = ref<any[]>([]);
const produtos = ref<any[]>([]);
const lista = ref<any[]>([]);
const errors = ref<string[]>([]);
const form = ref<any>({ cliente_id: 0, itens: [] });

function addItem(){ form.value.itens.push({ produto_id: 0, quantidade: 1, preco_unitario: 0 }); }
function removerItem(idx:number){ form.value.itens.splice(idx,1); }

async function carregar(){
  const [r1, r2, r3] = await Promise.all([
    api.get("/api/pedidos", auth),
    api.get("/api/clientes", auth),
    api.get("/api/produtos", auth),
  ]);
  lista.value = r1.data.data ?? r1.data;
  clientes.value = r2.data.data ?? r2.data;
  produtos.value = r3.data.data ?? r3.data;
}

function validar(): string[] {
  const e: string[] = [];
  if (required(form.value.cliente_id, "Cliente")) e.push("Cliente é obrigatório");
  if (!Array.isArray(form.value.itens) || form.value.itens.length === 0) e.push("Inclua ao menos um item");
  form.value.itens.forEach((i:any, idx:number)=>{
    if (!i.produto_id) e.push(`Item ${idx+1}: Produto é obrigatório`);
    const q = minValue(Number(i.quantidade), "Quantidade", 1); if (q) e.push(`Item ${idx+1}: ${q}`);
    const pu = minValue(Number(i.preco_unitario), "Preço unitário", 0); if (pu) e.push(`Item ${idx+1}: ${pu}`);
  });
  return e;
}

async function salvar(){
  errors.value = validar();
  if (errors.value.length) return;

  try{
    // normaliza numéricos
    const payload = {
      cliente_id: Number(form.value.cliente_id),
      itens: form.value.itens.map((i:any)=>({ produto_id:Number(i.produto_id), quantidade:Number(i.quantidade), preco_unitario:Number(i.preco_unitario) }))
    };
    await api.post("/api/pedidos", payload, auth);
    await carregar();
    form.value = { cliente_id: 0, itens: [] };
  }catch(err:any){
    errors.value = err?.validation ?? ["Erro inesperado."];
  }
}

async function remover(id:number){
  await api.delete(`/api/pedidos/${id}`, auth);
  await carregar();
}

onMounted(()=>{
  addItem();
  carregar();
});
</script>