<template>
  <layout title="Dashboard">
    <h1 class="text-4xl font-normal">Welcome, <strong>{{$page.auth.user.first_name}}</strong></h1>
    <h2 class="text-xl font-normal pt-2 text-grey-darker">Your current location is <strong>{{city}}, {{country}}</strong></h2>
    
    <h3 class="text-2xl  pt-16 font-bold">Your stats</h3>
    <div class="flex flex-wrap pt-4 -mx-2">
      <div class="w-full sm:w-1/2 px-2">
        <div class="flex flex-row justify-between items-center px-6 bg-green-dark h-24 rounded sm:mb-0 mb-2">
            <div class="text-3xl text-white">Libraries</div>
            <div class="text-3xl text-white">{{libraries}}</div>
        </div>
      </div>
      <div class="w-full sm:w-1/2 px-2">
        <div class="flex flex-row justify-between items-center px-6 bg-green-dark h-24 rounded">
            <div class="text-3xl text-white">Books</div>
            <div class="text-3xl text-white">{{books}}</div>
        </div>
      </div>
    </div>

    <h2 v-if="authors.length > 0" class="text-2xl font-normal pt-12 pb-4">Popular authors amongst your books</h2>
    <div v-if="authors.length > 0" class="bg-white rounded shadow">
      <div v-for="(author, index) in authors" :key="index" :class="{'border-t': index != 0}" class="hover:bg-grey-lightest focus-within:bg-grey-lightest flex flex-wrap items-center">
        <div class="w-full py-4 flex justify-between">
          <span class="text-grey-darker text-sm px-4">{{ author.author }}</span>
          <span class="text-grey-darker text-sm px-4">{{ author.count }}</span>
        </div>
      </div>
    </div>

    <h2 v-if="ratings.length > 0" class="text-2xl font-normal pt-12 pb-4">Highest rated books</h2>
    <div v-if="ratings.length > 0" class="bg-white rounded shadow">
      <div v-for="(book, index) in ratings" :key="index" :class="{'border-t': index != 0}" class="hover:bg-grey-lightest focus-within:bg-grey-lightest flex flex-wrap items-center">
        <div class="w-full py-4 flex justify-between">
          <span class="text-grey-darker text-sm px-4">{{ book.title }}</span>
          <span class="text-grey-darker text-sm px-4">{{ book.rating }}</span>
        </div>
      </div>
    </div>
  </layout>
</template>

<script>
import Layout from '@/Shared/Layout'

export default {
  components: {
    Layout,
  },
  props: ['libraries', 'books', 'city', 'country', 'authors', 'ratings']
}
</script>
