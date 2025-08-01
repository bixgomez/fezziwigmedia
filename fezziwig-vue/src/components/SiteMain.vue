<template>
  <main role="main" class="section section-main">
    <slot />
  </main>
</template>

<style lang="scss" scoped>
@import '@/assets/styles/base/base';

.section-main {
  background-color: $color-beige-lightest;
  border-top: 0.5cqi solid $color-orange--palest;
  padding: 2.25cqi;
}
</style>
