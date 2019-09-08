<template>
  <layout title="Search Results">
    <div class="mb-8 flex justify-start items-start">
      <h1 class="mb-8 font-bold text-3xl">
        Found {{paginated_search_results.data.length}} {{ paginated_search_results.data.length == 1 ? 'book' : 'books' }} near you
      </h1>
    </div>
    <div class="bg-white rounded shadow">
      <div v-for="(book, index) in books" :key="index" :class="{'border-t': index != 0}" class="hover:bg-grey-lightest focus-within:bg-grey-lightest flex flex-wrap items-center">
        <div class="w-4/5 md:w-2/5">
          <div class="px-4 md:px-6 py-4 flex flex-row justify-start items-center focus:text-green">
            <img v-if="book.image_url" class="block w-8 h-8 rounded-full mr-2 -my-2" :src="book.image_url">
            <div class="flex flex-col">
              <span>{{ book.title }}</span>
              <span class="text-grey-darker text-sm">{{ book.author }}</span>
            </div>
          </div>
        </div>
        <div class="w-full md:w-2/5 hidden md:flex">
          <div v-if="book.user_id != $page.auth.user.id">
            Owned by {{book.user.first_name}}, 
            <span v-if="book.distance <= 500">within 500m</span>
            <span v-else-if="book.distance <= 1000">within 1km</span>
            <span v-else-if="book.distance <= 5000">within 5km</span>
            <span v-else-if="book.distance <= 10000">within 10km</span>
            <span v-else-if="book.distance <= 20000">within 20km</span>
            <span v-else-if="book.distance <= 50000">within 50km</span>
            <span v-else-if="book.distance <= 100000">within 100km</span>
            <span v-else-if="book.distance <= 500000">within 500km</span>
          </div>
          <div v-else>
            Owned by you
          </div>
        </div>
        <div class="w-1/5 flex items-center justify-end">
          <a v-if="book.user_id != $page.auth.user.id" target="_blank" class="btn-green mx-4 md:mx-6 my-4" :href="'https://wa.me/' + book.user.phone_number">
            Message
          </a>
          <inertia-link v-else class="btn-green mx-4 md:mx-6 my-4" :href="route('libraries.books', book.library_id)">
            Go to Library
          </inertia-link>
        </div>
      </div>
      <div v-if="books.length === 0" class="px-6 py-4">
        <span>No books found.</span>
      </div>
    </div>
    <pagination :links="paginated_search_results" />
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
  props: ['paginated_search_results'],
  data() {
    return {

    }
  },
  computed: {
    books() {
      return this.paginated_search_results.data
    }
  },
  methods: {

  }
}
</script>
