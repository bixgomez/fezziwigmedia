<template>
  <header class="section section-header">
    <SiteBranding />
    <SiteNav />
  </header>
</template>

<style lang="scss" scoped>
@import '@/assets/styles/base/base';

.section-header {
  background-color: $color-beige-lighter;
}
</style>

<script setup>
import SiteBranding from './SiteBranding.vue'
import SiteNav from './SiteNav.vue'
</script>
