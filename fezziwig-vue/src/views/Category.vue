<template>
  <PostTeaserSection :categorySlug="$route.params.slug" />
</template>

<script setup>
import PostTeaserSection from '../components/PostTeaserSection.vue'
</script>
