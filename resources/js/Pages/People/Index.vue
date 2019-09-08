<template>
  <layout title="People">
    <div class="mb-8 flex justify-between items-start">
      <h1 class="font-bold text-3xl">People</h1>
      <!-- <inertia-link class="btn-green" :href="route('libraries.create')">
        <span>Create</span>
        <span class="hidden md:inline">Library</span>
      </inertia-link> -->
    </div>
    <div class="flex flex-wrap">
      jhgfc
    </div>
  </layout>
</template>

<script>
import Icon from '@/Shared/Icon'
import Layout from '@/Shared/Layout'

export default {
  components: {
    Icon,
    Layout
  },
  props: ['followers', 'following'],
  data() {
    return {

    }
  },
  methods: {

  }
}
</script>
