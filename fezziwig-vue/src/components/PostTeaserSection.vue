<template>
  <section class="post-teaser-section">
    <h2 v-if="showTitle">{{ categoryTitle }}</h2>
    <div v-if="showDescription" v-html="categoryDescription" />
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
import { ref, onMounted, computed } from 'vue'
import PostTeaser from './PostTeaser.vue'

const props = defineProps({
  block: { type: Object, required: false },
  categorySlug: { type: String, required: false },
})

const asBool = (v) => v === true || v === 1 || v === '1' || v === 'true'
const acf = computed(() => props.block?.attrs?.data ?? {})

const posts = ref([])
const categoryTitle = ref('')
const categoryDescription = ref('')
const showTitle = computed(() =>
  props.categorySlug ? true : asBool(acf.value?.show_title),
)
const showDescription = computed(() =>
  props.categorySlug ? true : asBool(acf.value?.show_description),
)

onMounted(async () => {
  const apiBase = import.meta.env.VITE_API_BASE_URL.replace(/\/$/, '')
  let catId, category

  if (props.categorySlug) {
    // Route-based: fetch by slug first
    const catRes = await fetch(
      `${apiBase}/wp-json/wp/v2/categories?slug=${encodeURIComponent(props.categorySlug)}&_fields=id,name,description,slug`,
    )
    const cats = await catRes.json()
    const cat = cats?.[0]
    if (!cat) return
    category = cat
    catId = cat.id
  } else {
    // Block-based: use ID from block data
    const idRaw = acf.value.post_teasers_category
    if (!idRaw) return
    catId = parseInt(String(idRaw), 10)
    if (Number.isNaN(catId)) return
    const catRes = await fetch(
      `${apiBase}/wp-json/wp/v2/categories/${catId}?_fields=id,name,description,slug`,
    )
    category = await catRes.json()
  }

  categoryTitle.value = category?.name || ''
  categoryDescription.value = category?.description || ''

  // Fetch posts (same for both cases)
  const postRes = await fetch(
    `${apiBase}/wp-json/wp/v2/posts?categories=${catId}&per_page=6&orderby=date&order=desc&_embed`,
  )
  posts.value = await postRes.json()
  console.log('Posts with ACF fields:', posts.value)
})
</script>
