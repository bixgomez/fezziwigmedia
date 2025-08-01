<template>
  <div class="site-outer">
    <div class="site-wrapper">
      <div class="site-container">
        <div id="page" class="site">
          <SiteHeader />
          <SiteMain>
            <slot />
          </SiteMain>
          <SiteFooter />
        </div>
      </div>
    </div>
  </div>
</template>

<style lang="scss" scoped>
@import '@/assets/styles/base/base';

.site-outer {
  overflow-x: hidden;
  padding: 0;
  margin: 0.5rem auto;
  min-width: 375px;
  width: 90%;
  max-width: ($sm - 25px);
  background-color: $color-inner-bg;
  container-type: inline-size;

  @include breakpoint($sm-up) {
    width: calc($sm * 0.9);
    max-width: calc($md * 0.9);
  }

  @include breakpoint($md-up) {
    width: calc($md * 0.9);
    max-width: ($lg * 0.9);
  }

  @include breakpoint($lg-up) {
    width: calc($lg * 0.9);
    max-width: ($xl * 0.9);
  }
}

.site-wrapper {
  border: 0.5cqi solid $color-orange--paler;
}

.site-container {
  margin: 0.5cqi;
  border: 1cqi solid $color-blue--paler;

  .site {
    margin: 0.5cqi;
    padding: 0;
    border: 0.5cqi solid $color-orange--paler;
  }
}
</style>

<script setup>
import SiteHeader from './SiteHeader.vue'
import SiteMain from './SiteMain.vue'
import SiteFooter from './SiteFooter.vue'
</script>
