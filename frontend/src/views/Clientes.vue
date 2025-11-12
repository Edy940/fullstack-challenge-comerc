<template>
  <div>
    <h2>{{ editandoId ? 'Editar Cliente' : 'Cadastrar Cliente' }}</h2>

    <ErrorAlert :messages="errors" />

    <div v-if="loading" style="text-align:center; padding:20px; color:#666;">
      Carregando dados dos Clientes...
    </div>

    <form v-else @submit.prevent="salvar">
      <div class="form-row">
        <InputField label="Nome" v-model="form.nome" />
        <InputField label="E-mail" v-model="form.email" type="email" />
      </div>
      <div class="form-row">
        <InputField label="Telefone" v-model="form.telefone" @input="aplicarMascaraTelefone" placeholder="(00) 00000-0000" maxlength="15" />
        <InputField label="Data de Nascimento" v-model="form.data_nascimento" type="date" />
      </div>
      <div class="form-row">
        <InputField label="CEP" v-model="form.cep" @input="aplicarMascaraCep" placeholder="00000-000" maxlength="9" />
        <InputField label="Endereço" v-model="form.endereco" placeholder="Rua, Av, etc" />
      </div>
      <div class="form-row">
        <InputField label="Bairro" v-model="form.bairro" />
        <InputField label="Complemento" v-model="form.complemento" placeholder="Apto, Bloco, etc (opcional)" />
      </div>
      <button class="btn" type="submit">{{ editandoId ? 'Atualizar' : 'Salvar' }}</button>
      <button class="btn ghost" type="button" @click="reset">{{ editandoId ? 'Cancelar' : 'Limpar' }}</button>
    </form>

    <hr style="margin:16px 0" />

    <h3 style="margin-bottom: 12px; color: #333;">Clientes Cadastrados</h3>

    <table class="table">
      <thead><tr><th>#</th><th>Nome</th><th>E-mail</th><th></th></tr></thead>
      <tbody>
        <tr v-for="c in lista" :key="c.id">
          <td>{{ c.id }}</td>
          <td>{{ c.nome }}</td>
          <td>{{ c.email }}</td>
          <td>
            <button class="btn ghost" @click="editar(c)" style="margin-right: 8px;">Editar</button>
            <button class="btn ghost" @click="remover(c.id)">Remover</button>
          </td>
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

const form = ref({ 
  nome: "", 
  email: "", 
  telefone: "", 
  data_nascimento: "",
  cep: "",
  endereco: "",
  bairro: "",
  complemento: ""
});
const lista = ref<any[]>([]);
const errors = ref<string[]>([]);
const loading = ref<boolean>(true);
const editandoId = ref<number | null>(null);

async function carregar() {
  try {
    loading.value = true;
    const r = await api.get("/api/clientes");
    lista.value = r.data.data ?? r.data;
  } catch(err) {
    console.error("Erro ao carregar clientes:", err);
    errors.value = ["Erro ao carregar clientes. Verifique a conexão."];
  } finally {
    loading.value = false;
  }
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
    // Remove máscaras antes de enviar para o backend
    const payload = {
      ...form.value,
      telefone: form.value.telefone.replace(/\D/g, ''),
      cep: form.value.cep.replace(/\D/g, '')
    };
    
    if (editandoId.value) {
      // Atualizar cliente existente
      await api.put(`/api/clientes/${editandoId.value}`, payload);
    } else {
      // Criar novo cliente
      await api.post("/api/clientes", payload);
    }
    
    await carregar();
    reset();
  } catch (err: any) {
    errors.value = err?.validation ?? ["Erro inesperado."];
  }
}

function editar(cliente: any) {
  editandoId.value = cliente.id;
  
  // Aplica máscaras nos campos
  const telefoneMask = cliente.telefone?.replace(/(\d{2})(\d{5})(\d{4})/, '($1) $2-$3') || 
                       cliente.telefone?.replace(/(\d{2})(\d{4})(\d{4})/, '($1) $2-$3') || '';
  const cepMask = cliente.cep?.replace(/(\d{5})(\d{3})/, '$1-$2') || '';
  
  form.value = {
    nome: cliente.nome || '',
    email: cliente.email || '',
    telefone: telefoneMask,
    data_nascimento: cliente.data_nascimento || '',
    cep: cepMask,
    endereco: cliente.endereco || '',
    bairro: cliente.bairro || '',
    complemento: cliente.complemento || ''
  };
  
  // Scroll para o formulário
  window.scrollTo({ top: 0, behavior: 'smooth' });
}

function reset(){ 
  editandoId.value = null;
  form.value = { 
    nome: "", 
    email: "", 
    telefone: "", 
    data_nascimento: "",
    cep: "",
    endereco: "",
    bairro: "",
    complemento: ""
  }; 
}
async function remover(id:number){
  await api.delete(`/api/clientes/${id}`);
  await carregar();
}

// Máscaras
function aplicarMascaraTelefone(e: Event) {
  const input = e.target as HTMLInputElement;
  let valor = input.value.replace(/\D/g, ''); // Remove tudo que não é dígito
  
  if (valor.length <= 10) {
    // (00) 0000-0000
    valor = valor.replace(/(\d{2})(\d)/, '($1) $2');
    valor = valor.replace(/(\d{4})(\d)/, '$1-$2');
  } else {
    // (00) 00000-0000
    valor = valor.replace(/(\d{2})(\d)/, '($1) $2');
    valor = valor.replace(/(\d{5})(\d)/, '$1-$2');
  }
  
  form.value.telefone = valor;
}

function aplicarMascaraCep(e: Event) {
  const input = e.target as HTMLInputElement;
  let valor = input.value.replace(/\D/g, ''); // Remove tudo que não é dígito
  valor = valor.replace(/(\d{5})(\d)/, '$1-$2'); // 00000-000
  form.value.cep = valor;
}

onMounted(carregar);
</script>