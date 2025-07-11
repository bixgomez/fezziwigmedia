<template>
  <nav>
    <a 
      v-for="item in menuItems" 
      :key="item.id"
      :href="getRelativeUrl(item.url)"
    >
      {{ item.title.rendered }}
    </a>
  </nav>
</template>

<script>
export default {
  name: 'SiteMenu',
  data() {
    return {
      menuItems: []
    }
  },
  mounted() {
    fetch('https://fezziwigmedia.ddev.site/wp-json/wp/v2/menu-items')
      .then(response => response.json())
      .then(data => {
        this.menuItems = data.sort((a, b) => a.menu_order - b.menu_order)
      })
  },
  methods: {
    getRelativeUrl(url) {
      // Remove the domain to make it relative
      return url.replace('https://fezziwigmedia.ddev.site', '')
    }
  }
}
</script>