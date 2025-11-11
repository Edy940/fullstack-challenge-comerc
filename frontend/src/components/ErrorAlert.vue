<template>
  <div class="alert" v-if="messages?.length">
    <ul>
      <li v-for="(m,i) in messages" :key="i">{{ m }}</li>
    </ul>
  </div>
</template>
<script setup lang="ts">
defineProps<{ messages?: string[] }>();
</script>