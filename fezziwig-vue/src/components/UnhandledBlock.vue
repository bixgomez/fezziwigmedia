<template>
  <div class="unhandled-block">
    <strong>Unhandled block:</strong>
    {{ block.blockName }}
  </div>
</template>

<script setup>
defineProps({
  block: Object,
})
</script>
