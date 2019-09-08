<template>
  <div>
    <div class="mb-4">
      <inertia-link class="flex items-center group py-3" :href="route('dashboard')">
        <icon name="dashboard" class="w-4 h-4 mr-2" :class="isUrl('') ? 'fill-white' : 'fill-green-light group-hover:fill-white'" />
        <div :class="isUrl('') ? 'text-white' : 'text-green-light group-hover:text-white'">Dashboard</div>
      </inertia-link>
    </div>
    <div class="mb-4">
      <inertia-link class="flex items-center group py-3" :href="route('libraries')">
        <icon name="book" class="w-4 h-4 mr-2" :class="isUrl('libraries') ? 'fill-white' : 'fill-green-light group-hover:fill-white'" />
        <div :class="isUrl('libraries') ? 'text-white' : 'text-green-light group-hover:text-white'">Libraries</div>
      </inertia-link>
    </div>
    <!-- <div class="mb-4">
      <inertia-link class="flex items-center group py-3" :href="route('people')">
        <icon name="users" class="w-4 h-4 mr-2" :class="isUrl('people') ? 'fill-white' : 'fill-green-light group-hover:fill-white'" />
        <div :class="isUrl('people') ? 'text-white' : 'text-green-light group-hover:text-white'">People</div>
      </inertia-link>
    </div> -->
  </div>
</template>

<script>
import Icon from '@/Shared/Icon'

export default {
  components: {
    Icon,
  },
  methods: {
    isUrl(...urls) {
      if (urls[0] === '') {
        return location.pathname.substr(1) === ''
      }

      return urls.filter(url => location.pathname.substr(1).startsWith(url)).length
    },
  },
}
</script>
