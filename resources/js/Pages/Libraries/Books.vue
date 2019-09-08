<template>
  <layout title="Libraries">
    <div class="mb-8 flex justify-between items-start">
      <h1 class="mb-8 font-bold text-3xl">
        <inertia-link class="text-green-light hover:text-green-dark" :href="route('libraries')">Libraries</inertia-link>
        <span class="text-green-light font-medium">/</span> {{library.name}}
      </h1>
      <inertia-link class="btn-green" :href="route('book.create', library.id)">
        <span>Add</span>
        <span class="hidden md:inline">Book</span>
      </inertia-link>
    </div>
    <div class="bg-white rounded shadow">
      <div v-for="(book, index) in books" :key="index" :class="{'border-t': index != 0}" class="hover:bg-grey-lightest focus-within:bg-grey-lightest flex flex-wrap items-center">
        <div class="w-4/5 md:w-2/5">
          <inertia-link class="px-4 md:px-6 py-4 flex flex-row justify-start items-center focus:text-green" :href="route('book.edit', book.id)">
            <img v-if="book.image_url" class="block w-8 h-8 rounded-full mr-2 -my-2" :src="book.image_url">
            <div class="flex flex-col">
              <span>{{ book.title }}</span>
              <span class="text-grey-darker text-sm">{{ book.author }}</span>
            </div>
          </inertia-link>
        </div>
        <div class="w-full md:w-2/5 hidden md:flex">
          <inertia-link class="px-6 py-4 flex items-center" :href="route('book.edit', book.id)" tabindex="-1">
            <span v-if="book.publisher && book.publication_day && book.publication_month && book.publication_year">Published by {{ book.publisher }} on {{ publicationDate(book.publication_day, book.publication_month, book.publication_year) }}</span>
            <span v-else-if="book.publisher">Published by {{ book.publisher }}</span>
            <span v-else-if="book.publication_month && book.publication_year">Published on {{ publicationDate(book.publication_day, book.publication_month, book.publication_year) }}</span>
            <span v-else>-</span>
          </inertia-link>
        </div>
        <div class="w-1/5 flex items-center justify-end">
          <div class="flex flex-row px-2 md:px-6 py-4">
              <inertia-link class="p-1 text-green-dark hover:text-green" :href="route('book.edit', book.id)">
                  <icon name="edit" class="block w-6 h-6 fill-current" />
              </inertia-link>
              <div class="p-1 text-green-dark hover:text-red-light cursor-pointer" @click="deleteBook(book.id)">
                  <icon name="trash" class="block w-6 h-6 fill-current" />
              </div>
          </div>
        </div>
      </div>
      <div v-if="books.length === 0" class="px-6 py-4">
        <span>No books found.</span>
      </div>
    </div>
    <pagination :links="paginated_books.links" />
  </layout>
</template>

<script>
import Icon from '@/Shared/Icon'
import Layout from '@/Shared/Layout'
import Pagination from '@/Shared/Pagination'

export default {
  components: {
    Icon,
    Layout,
    Pagination
  },
  props: ['library', 'paginated_books'],
  data() {
    return {

    }
  },
  computed: {
    books() {
      return this.paginated_books.data
    }
  },
  methods: {
    deleteBook(id) {
      this.$inertia.delete(this.route('book.destroy', id))
    },
    publicationDate(day, month, year) {
      let date = new Date(year, month, day);
      let monthName = date.toLocaleString('en-US', {month: 'long'});
      let dayNth = ''
      switch (day % 10) {
        case 1:  dayNth = "st";
        case 2:  dayNth = "nd";
        case 3:  dayNth = "rd";
        default: dayNth = "th";
      }

      return day + dayNth + ' of ' + monthName + ', ' + year
    }
  }
}
</script>
