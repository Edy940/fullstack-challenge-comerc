<template>
  <div>
    <h2>Pedidos</h2>

    <ErrorAlert :messages="errors" />

    <div v-if="loading" style="text-align:center; padding:20px; color:#666;">
      Carregando dados do Pedido...
    </div>

    <form v-else @submit.prevent="salvar">
      <div class="form-row">
        <label class="field">
          <span>Cliente</span>
          <select v-model.number="form.cliente_id">
            <option value="0" disabled>Selecione um cliente</option>
            <option :value="c.id" v-for="c in clientes" :key="c.id">{{ c.nome }}</option>
          </select>
        </label>
        <button class="btn ghost" type="button" @click="addItem">+ Item</button>
      </div>

      <div v-for="(i,idx) in form.itens" :key="idx" class="form-row" style="align-items:end">
        <label class="field">
          <span>Produto</span>
          <select v-model.number="i.produto_id" @change="atualizarPreco(idx)">
            <option value="0" disabled>Selecione um produto</option>
            <option :value="p.id" v-for="p in produtos" :key="p.id">{{ p.nome }} (R$ {{ Number(p.preco).toFixed(2) }})</option>
          </select>
        </label>
        <InputField label="Quantidade" type="number" v-model="i.quantidade" />
        <InputField label="Preço unitário" type="text" v-model="i.preco_unitario" placeholder="R$ " readonly style="background:#f5f5f5" />
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

const clientes = ref<any[]>([]);
const produtos = ref<any[]>([]);
const lista = ref<any[]>([]);
const errors = ref<string[]>([]);
const loading = ref<boolean>(true);
const form = ref<any>({ cliente_id: 0, itens: [] });

function addItem(){ form.value.itens.push({ produto_id: 0, quantidade: 1, preco_unitario: "" }); }
function removerItem(idx:number){ form.value.itens.splice(idx,1); }

function atualizarPreco(idx: number) {
  const item = form.value.itens[idx];
  const produto = produtos.value.find((p: any) => p.id === item.produto_id);
  if (produto) {
    // Preenche automaticamente o preço do produto selecionado
    item.preco_unitario = Number(produto.preco).toFixed(2).replace('.', ',');
  }
}

async function carregar(){
  try {
    loading.value = true;
    const [r1, r2, r3] = await Promise.all([
      api.get("/api/pedidos"),
      api.get("/api/clientes"),
      api.get("/api/produtos"),
    ]);
    lista.value = r1.data.data ?? r1.data;
    clientes.value = r2.data.data ?? r2.data;
    produtos.value = r3.data.data ?? r3.data;
  } catch(err) {
    console.error("Erro ao carregar dados:", err);
    errors.value = ["Erro ao carregar dados. Verifique a conexão."];
  } finally {
    loading.value = false;
  }
}

function validar(): string[] {
  const e: string[] = [];
  if (required(form.value.cliente_id, "Cliente")) e.push("Cliente é obrigatório");
  if (!Array.isArray(form.value.itens) || form.value.itens.length === 0) e.push("Inclua ao menos um item");
  form.value.itens.forEach((i:any, idx:number)=>{
    if (!i.produto_id) e.push(`Item ${idx+1}: Produto é obrigatório`);
    const q = minValue(Number(i.quantidade), "Quantidade", 1); if (q) e.push(`Item ${idx+1}: ${q}`);
    const pu = minValue(Number(String(i.preco_unitario).replace(',', '.')), "Preço unitário", 0); if (pu) e.push(`Item ${idx+1}: ${pu}`);
  });
  return e;
}

async function salvar(){
  errors.value = validar();
  if (errors.value.length) return;

  try{
    // normaliza numéricos e converte vírgula para ponto
    const payload = {
      cliente_id: Number(form.value.cliente_id),
      itens: form.value.itens.map((i:any)=>({ 
        produto_id: Number(i.produto_id), 
        quantidade: Number(i.quantidade), 
        preco_unitario: Number(String(i.preco_unitario).replace(',', '.'))
      }))
    };
    await api.post("/api/pedidos", payload);
    await carregar();
    form.value = { cliente_id: 0, itens: [] };
    addItem(); // Adiciona um item vazio após resetar
  }catch(err:any){
    errors.value = err?.validation ?? ["Erro inesperado."];
  }
}

async function remover(id:number){
  await api.delete(`/api/pedidos/${id}`);
  await carregar();
}

onMounted(()=>{
  addItem();
  carregar();
});
</script>