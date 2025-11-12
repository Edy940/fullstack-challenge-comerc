<template>
  <div>
    <h2>Cadastrar Produtos</h2>

    <ErrorAlert :messages="errors" />

    <div v-if="loading" style="text-align:center; padding:20px; color:#666;">
      Carregando dados dos Produtos...
    </div>

    <form v-else @submit.prevent="salvar">
      <div class="form-row">
        <InputField label="Nome" v-model="form.nome" />
        <InputField label="Preço" v-model="form.preco" type="text" placeholder="Ex: 15,99" />
      </div>
      <div class="form-row">
        <InputField label="Foto (URL/caminho)"  v-model="form.foto" placeholder="Ex: Digite img.foto.jpg , apenas para testes" />
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

    <h3 style="margin-bottom: 12px; color: #333;">Produtos Cadastrados</h3>

    <table class="table">
      <thead><tr><th>#</th><th>Nome</th><th>Preço</th><th>Tipo</th><th></th></tr></thead>
      <tbody>
        <tr v-for="p in lista" :key="p.id">
          <td>{{ p.id }}</td><td>{{ p.nome }}</td><td>R$ {{ Number(p.preco).toFixed(2) }}</td><td>{{ p.tipo_produto?.nome }}</td>
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
import { normalizarPreco } from "@/utils/formatters";

const form = ref({ nome:"", preco: "", foto:"", tipo_produto_id: 1 });
const lista = ref<any[]>([]);
const tipos = ref<any[]>([]);
const errors = ref<string[]>([]);
const loading = ref<boolean>(true);

async function carregar() {
  try {
    loading.value = true;
    const r1 = await api.get("/api/produtos");
    lista.value = r1.data.data ?? r1.data;

    tipos.value = [
      {id:1,nome:"Pastel Salgado"},
      {id:2,nome:"Pastel Doce"},
      {id:3,nome:"Bebida"},
      {id:4,nome:"Combo"},
    ];
  } catch(err) {
    console.error("Erro ao carregar produtos:", err);
    errors.value = ["Erro ao carregar produtos. Verifique a conexão."];
  } finally {
    loading.value = false;
  }
}

function validar(): string[] {
  const e: string[] = [];
  [required(form.value.nome, "Nome"), required(form.value.foto, "Foto"), minValue(normalizarPreco(form.value.preco), "Preço", 0)]
    .filter(Boolean)
    .forEach((m: any) => e.push(m));
  if (!form.value.tipo_produto_id) e.push("Tipo é obrigatório");
  return e;
}

async function salvar() {
  errors.value = validar();
  if (errors.value.length) return;

  try {
    const payload = {
      ...form.value,
      preco: normalizarPreco(form.value.preco)
    };
    await api.post("/api/produtos", payload);
    await carregar();
    reset();
  } catch (err: any) {
    errors.value = err?.validation ?? ["Erro inesperado."];
  }
}
function reset(){ form.value = { nome:"", preco:"", foto:"", tipo_produto_id:1 }; }
async function remover(id:number){
  await api.delete(`/api/produtos/${id}`);
  await carregar();
}

onMounted(carregar);
</script>