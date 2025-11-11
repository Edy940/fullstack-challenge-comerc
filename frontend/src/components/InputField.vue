<template>
  <label class="field">
    <span>{{ label }}</span>
    <input :type="type" v-model="model" :placeholder="placeholder" />
  </label>
</template>

<script setup lang="ts">
import { computed } from "vue";
const props = defineProps<{ modelValue: string | number | null | undefined; label: string; type?: string; placeholder?: string }>();
const emit = defineEmits(["update:modelValue"]);
const model = computed({
  get: () => props.modelValue as any,
  set: (v) => emit("update:modelValue", v)
});
</script>

<style>
.field { display:flex; flex-direction:column; gap:4px; }
input { padding:8px; border:1px solid #e5e7eb; border-radius:8px; }
</style>