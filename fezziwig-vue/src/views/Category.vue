<template>
  <div>
    <h1>{{ categoryTitle }}</h1>
    <div v-if="categoryDescription" v-html="categoryDescription"></div>
    <div class="post-teasers" v-if="posts.length > 0">
      <PostTeaser v-for="post in posts" :key="post.id" :post="post" />
    </div>
    <div v-else>
      <p>Loading posts...</p>
    </div>
  </div>
</template>

<style lang="scss" scoped>
@import '@/assets/styles/base/base';

.post-teasers {
  display: grid;
  grid-template-columns: 1fr;
  gap: 3cqi;
  margin: 1.25rem 0;
  list-style: none;
  padding: 0;
  container-type: inline-size;
}
</style>

<script setup>
import { ref, onMounted } from 'vue'
import { useRoute } from 'vue-router'
import PostTeaser from '../components/PostTeaser.vue'

// reactive state
const posts = ref([])
const categoryTitle = ref('')
const categoryDescription = ref('')
const loading = ref(true)
const error = ref(null)

// grab slug and API base
const route = useRoute()
const slug = route.params.slug
const apiBase = import.meta.env.VITE_API_BASE_URL.replace(/\/$/, '')

// fetcher
async function loadCategory() {
  loading.value = true
  try {
    // 1) fetch the category by slug (with embed so we can pull name/description)
    const catRes = await fetch(
      `${apiBase}/wp-json/wp/v2/categories?slug=${slug}&_embed`,
    )
    const [cat] = await catRes.json()
    categoryTitle.value = cat.name
    categoryDescription.value = cat.description

    // 2) fetch posts in that category (with embed so teasers get featured media)
    const postRes = await fetch(
      `${apiBase}/wp-json/wp/v2/posts?categories=${cat.id}&per_page=10&_embed`,
    )
    posts.value = await postRes.json()
  } catch (e) {
    error.value = e
  } finally {
    loading.value = false
  }
}

// kick off the load on mount
onMounted(loadCategory)
</script>
