<template>
  <div>
    <h2>Produtos</h2>

    <ErrorAlert :messages="errors" />

    <form @submit.prevent="salvar">
      <div class="form-row">
        <InputField label="Nome" v-model="form.nome" />
        <InputField label="Preço" v-model="form.preco" type="number" />
      </div>
      <div class="form-row">
        <InputField label="Foto (URL/caminho)" v-model="form.foto" />
        <label class="field">
          <span>Tipo</span>
          <select v-model="form.tipo_produto_id">
            <option :value="t.id" v-for="t in tipos" :key="t.id">{{ t.nome }}</option>
          </select>
        </label>
      </div>
      <button class="btn" type="submit">Salvar</button>
      <button class="btn ghost" type="button" @click="reset">Limpar</button>
    </form>

    <hr style="margin:16px 0" />

    <table class="table">
      <thead><tr><th>#</th><th>Nome</th><th>Preço</th><th>Tipo</th><th></th></tr></thead>
      <tbody>
        <tr v-for="p in lista" :key="p.id">
          <td>{{ p.id }}</td><td>{{ p.nome }}</td><td>R$ {{ p.preco.toFixed(2) }}</td><td>{{ p.tipo_produto?.nome }}</td>
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

const form = ref({ nome:"", preco: 0, foto:"", tipo_produto_id: 1 });
const lista = ref<any[]>([]);
const tipos = ref<any[]>([]);
const errors = ref<string[]>([]);

async function carregar() {
  const [r1, r2] = await Promise.all([
    api.get("/api/produtos", auth),
    api.get("/api/clientes", auth) // dummy call pra manter consistência de auth; tipos virão do backend via seed + endpoint? aqui simplificamos:
  ]);
  lista.value = r1.data.data ?? r1.data;

  // Para obter tipos, podemos inferir via seed fixa no front (ou expor endpoint). Simples: cache de nomes fixos:
  tipos.value = [
    {id:1,nome:"Pastel Salgado"},
    {id:2,nome:"Pastel Doce"},
    {id:3,nome:"Bebida"},
    {id:4,nome:"Combo"},
  ];
}

function validar(): string[] {
  const e: string[] = [];
  [required(form.value.nome, "Nome"), required(form.value.foto, "Foto"), minValue(Number(String(form.value.preco).replace(',', '.')), "Preço", 0)]
    .filter(Boolean)
    .forEach((m: any) => e.push(m));
  if (!form.value.tipo_produto_id) e.push("Tipo é obrigatório");
  return e;
}

async function salvar() {
  errors.value = validar();
  if (errors.value.length) return;

  try {
    await api.post("/api/produtos", { ...form.value, preco: Number(form.value.preco) }, auth);
    await carregar();
    reset();
  } catch (err: any) {
    errors.value = err?.validation ?? ["Erro inesperado."];
  }
}
function reset(){ form.value = { nome:"", preco:0, foto:"", tipo_produto_id:1 }; }
async function remover(id:number){
  await api.delete(`/api/produtos/${id}`, auth);
  await carregar();
}

onMounted(carregar);
</script>