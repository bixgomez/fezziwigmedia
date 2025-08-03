<template>
  <div v-if="blocks.length">
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
const content = ref(null)

function resolveComponent(blockName) {
  switch (blockName) {
    case 'acf/post-teasers':
      return PostTeaserSection
    case null:
      return RawHtmlBlock
    default:
      return UnhandledBlock
  }
}

onMounted(async () => {
  slug.value = window.location.pathname.split('/').filter(Boolean).pop()
  const apiBase = import.meta.env.VITE_API_BASE_URL

  const fetchPageOrPost = async (type) => {
    const res = await fetch(
      `${apiBase}/wp-json/wp/v2/${type}?slug=${slug.value}&_fields=content.rendered`,
    )
    const data = await res.json()
    return data?.[0] || null
  }

  content.value =
    (await fetchPageOrPost('pages')) || (await fetchPageOrPost('posts'))

  if (content.value?.content?.rendered) {
    try {
      blocks.value = parse(content.value.content.rendered)
      console.log('Parsed blocks:', blocks.value)
    } catch (e) {
      console.error('Block parse error:', e)
    }
  }
})
</script>
