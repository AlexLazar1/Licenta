<template>
  <layout title="Libraries">
    <div class="mb-8 flex justify-between items-start">
      <h1 class="font-bold text-3xl">Libraries</h1>
      <inertia-link class="btn-green" :href="route('libraries.create')">
        <span>Create</span>
        <span class="hidden md:inline">Library</span>
      </inertia-link>
    </div>
    <div class="flex flex-wrap">
      <div v-for="(library, index) in libraries" :key="index" class="w-full flex content-between flex-wrap py-2">
        <inertia-link class="flex items-center px-6 bg-green-dark w-full sm:w-3/4 h-24 cursor-pointer hover:bg-green rounded-t sm:rounded-l-lg sm:rounded-t-none" :href="route('libraries.books', library.id)">
          <div>
            <div class="text-3xl text-white">{{library.name}}</div>
            <div class="text-base pt-2 text-green-lightest">{{library.description}}</div>
          </div>
        </inertia-link>
        <div class="flex flex-col bg-green-darker h-24 w-full sm:w-1/4 sm:rounded-r-lg rounded-b-lg sm:rounded-b-none">
          <inertia-link class="text-white p-4 text-center cursor-pointer hover:bg-green sm:rounded-tr-lg" :href="route('libraries.edit', library.id)">
            Edit
          </inertia-link>
          <div class="text-white p-4 text-center cursor-pointer hover:bg-red-light sm:rounded-br-lg rounded-b-lg sm:rounded-b-none" @click="deleteLibrary(library.id)" :href="route('libraries.destroy', library.id)">
            Delete
          </div>
        </div>
      </div>
    </div>
  </layout>
</template>

<script>
import Icon from '@/Shared/Icon'
import Layout from '@/Shared/Layout'

export default {
  components: {
    Icon,
    Layout,
  },
  props: ['libraries'],
  data() {
    return {

    }
  },
  methods: {
    deleteLibrary(id) {
      this.$inertia.delete(this.route('libraries.destroy', id))
    }
  }
}
</script>
