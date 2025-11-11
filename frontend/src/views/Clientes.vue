<template>
  <div>
    <h2>Clientes</h2>

    <ErrorAlert :messages="errors" />

    <form @submit.prevent="salvar">
      <div class="form-row">
        <InputField label="Nome" v-model="form.nome" />
        <InputField label="E-mail" v-model="form.email" type="email" />
      </div>
      <div class="form-row">
        <InputField label="Telefone" v-model="form.telefone" />
        <InputField label="CEP" v-model="form.cep" />
      </div>
      <button class="btn" type="submit">Salvar</button>
      <button class="btn ghost" type="button" @click="reset">Limpar</button>
    </form>

    <hr style="margin:16px 0" />

    <table class="table">
      <thead><tr><th>#</th><th>Nome</th><th>E-mail</th><th></th></tr></thead>
      <tbody>
        <tr v-for="c in lista" :key="c.id">
          <td>{{ c.id }}</td>
          <td>{{ c.nome }}</td>
          <td>{{ c.email }}</td>
          <td><button class="btn ghost" @click="remover(c.id)">Remover</button></td>
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
import { required, email as emailVal } from "@/utils/validators";

const auth = { auth: { username: "admin@pastelaria.local", password: "secret123" } };

const form = ref({ nome: "", email: "", telefone: "", cep: "" });
const lista = ref<any[]>([]);
const errors = ref<string[]>([]);

async function carregar() {
  const r = await api.get("/api/clientes", auth);
  lista.value = r.data.data ?? r.data;
}

function validar(): string[] {
  const e: string[] = [];
  [required(form.value.nome, "Nome"), required(form.value.email, "E-mail"), emailVal(form.value.email, "E-mail")]
    .filter(Boolean)
    .forEach((m: any) => e.push(m));
  return e;
}

async function salvar() {
  errors.value = validar();
  if (errors.value.length) return;

  try {
    await api.post("/api/clientes", form.value, auth);
    await carregar();
    reset();
  } catch (err: any) {
    errors.value = err?.validation ?? ["Erro inesperado."];
  }
}
function reset(){ form.value = { nome:"", email:"", telefone:"", cep:"" }; }
async function remover(id:number){
  await api.delete(`/api/clientes/${id}`, auth);
  await carregar();
}

onMounted(carregar);
</script>