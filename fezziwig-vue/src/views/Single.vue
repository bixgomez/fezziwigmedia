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

  // 1) Fetch page data for title
  try {
    const pageRes = await fetch(`${apiBase}/wp-json/wp/v2/pages?slug=${slug.value}`)
    const [pageData] = await pageRes.json()
    if (pageData) {
      pageTitle.value = pageData.title.rendered
    }
  } catch (e) {
    console.error('Page fetch error:', e)
  }

  // 2) hit our custom proxy endpoint for raw block comments
  try {
    const res = await fetch(`${apiBase}/wp-json/fezziwig/v1/blocks/${slug.value}`)
    const { blocks: raw } = await res.json()

    // 3) parse them into structured block objects
    blocks.value = parse(raw)
    console.log('Parsed blocks:', blocks.value)
  } catch (e) {
    console.error('Block parse error:', e)
  }
})
</script>
