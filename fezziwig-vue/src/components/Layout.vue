<template>
  <div class="site-outer">
    <div class="site-wrapper">
      <div class="site-container">
        <div id="page" class="site">
          <SiteHeader />
          <SiteNav />
          <main id="content" role="main" class="section site-content">
            <div id="content-inner" class="section-inner">
              <section>
                <slot />
              </section>
            </div>
          </main>
          <SiteFooter />
        </div>
      </div>
    </div>
  </div>
</template>

<script setup>
import SiteHeader from './SiteHeader.vue'
import SiteFooter from './SiteFooter.vue'
import SiteNav from './SiteNav.vue'
</script>
