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

<script setup>
import SiteHeader from './SiteHeader.vue'
import SiteMain from './SiteMain.vue'
import SiteFooter from './SiteFooter.vue'
</script>
