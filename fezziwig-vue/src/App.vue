<template>
  <div>
    <SiteMenu />
    <router-view />
  </div>
</template>

<script>
import SiteMenu from './components/SiteMenu.vue'

export default {
  name: 'App',
  components: {
    SiteMenu
  }
}
</script>
