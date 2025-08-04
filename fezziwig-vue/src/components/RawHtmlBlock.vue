<template>
  <div v-html="block.innerHTML" />
</template>

<script setup>
defineProps({ block: Object })
</script>
