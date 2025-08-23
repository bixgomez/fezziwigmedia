<template>
  <div v-if="blocks.length || pageTitle">
    <h1 v-if="pageTitle" v-html="pageTitle" />
    <component
      v-for="(block, index) in blocks"
      :key="index"
      :is="resolveComponent(block.blockName)"
      :block="block"
    />
  </div>
  <div v-else>
    <p>Loading...</p>
  </div>
</template>

<script setup>
import { ref, onMounted } from 'vue'
import { parse } from '@wordpress/block-serialization-default-parser'
import UnhandledBlock from '@/components/UnhandledBlock.vue'
import PostTeaserSection from '@/components/PostTeaserSection.vue'
import RawHtmlBlock from '@/components/RawHtmlBlock.vue'

const blocks = ref([])
const slug = ref('')
const pageTitle = ref('')

function resolveComponent(blockName) {
  switch (blockName) {
    case 'acf/post-teasers':
      return PostTeaserSection
    case 'core/post-terms':
      return RawHtmlBlock
    case null:
      return RawHtmlBlock
    default:
      return UnhandledBlock
  }
}

onMounted(async () => {
  slug.value = window.location.pathname.split('/').filter(Boolean).pop()
  const apiBase = import.meta.env.VITE_API_BASE_URL

  // Fetch blocks and title in parallel
  try {
    const [blocksRes, pageRes, postRes] = await Promise.all([
      fetch(`${apiBase}/wp-json/fezziwig/v1/blocks/${slug.value}`),
      fetch(`${apiBase}/wp-json/wp/v2/pages?slug=${slug.value}`),
      fetch(`${apiBase}/wp-json/wp/v2/posts?slug=${slug.value}`)
    ])
    
    const { blocks: raw } = await blocksRes.json()
    const [pageData] = await pageRes.json()
    const [postData] = await postRes.json()
    
    // Set the title - check posts first, then pages
    if (postData) {
      pageTitle.value = postData.title.rendered
    } else if (pageData) {
      pageTitle.value = pageData.title.rendered
    }
    
    // Parse the blocks
    blocks.value = parse(raw)
    console.log('Parsed blocks:', blocks.value)
  } catch (e) {
    console.error('Block parse error:', e)
  }
})
</script>
