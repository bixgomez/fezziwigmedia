<template>
  <section role="main" class="section section-nav">
    <div id="nav-inner" class="section-inner">
      <nav id="site-navigation" class="main-navigation" role="navigation">
        <SiteMenu />
      </nav>
    </div>
  </section>
</template>

<style lang="scss" scoped>
@import '@/assets/styles/base/base';

.section-nav {
  background-color: $color-beige-lighter;
  border-top: 0.5cqi solid $color-orange--palest;
}
</style>

<script setup>
import SiteMenu from './SiteMenu.vue'
</script>
