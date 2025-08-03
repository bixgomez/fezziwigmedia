<template>
  <section class="post-teaser-section">
    <h2>{{ categoryTitle }}</h2>
    <div v-if="categoryDescription" v-html="categoryDescription"></div>
    <div class="post-teasers" v-if="posts.length > 0">
      <PostTeaser v-for="post in posts" :key="post.id" :post="post" />
    </div>
    <div v-else>
      <p>Loading posts...</p>
    </div>
  </section>
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
import PostTeaser from './PostTeaser.vue'

const props = defineProps({
  block: { type: Object, required: true },
})

const posts = ref([])
const categoryTitle = ref('')
const categoryDescription = ref('')

onMounted(async () => {
  const data = props.block.attrs.data
  const catId = data.post_teasers_category
  const apiBase = import.meta.env.VITE_API_BASE_URL.replace(/\/$/, '')

  // Fetch category data by ID
  const catRes = await fetch(`${apiBase}/wp-json/wp/v2/categories/${catId}`)
  const category = await catRes.json()

  // Handle the heading logic
  categoryTitle.value = category.name
  categoryDescription.value = category.description

  // Fetch posts in this category
  const postRes = await fetch(
    `${apiBase}/wp-json/wp/v2/posts?categories=${catId}&_embed`,
  )
  posts.value = await postRes.json()
})
</script>
