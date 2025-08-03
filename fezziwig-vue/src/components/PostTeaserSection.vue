<template>
  <section class="post-teaser-section">
    <!-- Optional heading from the block -->
    <h2 v-if="useTitle">{{ titleText }}</h2>
    <div class="post-teasers" v-if="posts.length > 0">
      <PostTeaser v-for="post in posts" :key="post.id" :post="post" />
    </div>
    <div v-else>
      <p>Loading posts...</p>
    </div>
  </section>
</template>

<style scoped>
.post-teaser-section {
  margin-bottom: 2rem;
}
</style>

<script setup>
import PostTeaser from './PostTeaser.vue'
import { ref, onMounted } from 'vue'

const props = defineProps({
  block: { type: Object, required: true },
})

const posts = ref([])
const titleText = ref('')
const useTitle = ref(false)

onMounted(async () => {
  const data = props.block.attrs.data
  const catId = data.post_teasers_category

  // Handle the heading logic
  useTitle.value = data.use_category_title === '1'
  titleText.value = data.heading || ''

  // Fetch posts in this category (limit to 5; adjust as needed)
  const apiBase = import.meta.env.VITE_API_BASE_URL.replace(/\/$/, '')
  const res = await fetch(
    `${apiBase}/wp-json/wp/v2/posts?categories=${catId}&_embed`,
  )
  posts.value = await res.json()
})
</script>
