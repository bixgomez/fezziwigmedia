<template>
  <div class="layout">
    <SiteMenu />
    <main><slot /></main>
  </div>
</template>

<script setup>
import SiteMenu from './SiteMenu.vue'
</script>
