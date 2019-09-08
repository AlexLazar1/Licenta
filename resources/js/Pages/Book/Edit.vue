<template>
  <layout title="Edit Book">
    <h1 class="mb-8 font-bold text-3xl">
      <inertia-link class="text-green-light hover:text-green-dark" :href="route('libraries.books', book.library_id)">{{form.title}}</inertia-link>
      <span class="text-green-light font-medium">/</span> Edit
    </h1>
    <div class="bg-white rounded shadow overflow-hidden">
      <form @submit.prevent="submit">
        <div class="p-8 -mr-6 -mb-8 flex flex-wrap">
          <text-input v-model="form.title" :errors="$page.errors.title" class="pr-6 pb-8 w-full lg:w-full" label="Title" />
          <text-input v-model="form.author" :errors="$page.errors.author" class="pr-6 pb-8 w-full lg:w-full" label="Author" />
          <text-input v-model="form.publication_day" :errors="$page.errors.publication_day" class="pr-6 pb-8 w-full lg:w-full" label="Publication Day" />
          <text-input v-model="form.publication_month" :errors="$page.errors.publication_month" class="pr-6 pb-8 w-full lg:w-full" label="Publication Month" />
          <text-input v-model="form.publication_year" :errors="$page.errors.publication_year" class="pr-6 pb-8 w-full lg:w-full" label="Publication Year" />
          <text-input v-model="form.publisher" :errors="$page.errors.publisher" class="pr-6 pb-8 w-full lg:w-full" label="Publisher" />
        </div>
        <div class="px-8 py-4 bg-grey-lightest border-t border-grey-lighter flex justify-end items-center">
          <loading-button :loading="sending" class="btn-green" type="submit">Update Book</loading-button>
        </div>
      </form>
    </div>
  </layout>
</template>

<script>
import Icon from '@/Shared/Icon'
import Layout from '@/Shared/Layout'
import LoadingButton from '@/Shared/LoadingButton'
import TextInput from '@/Shared/TextInput'

export default {
  components: {
    Icon,
    Layout,
    LoadingButton,
    TextInput,
  },
  props: ['book'],
  remember: 'form',
  data() {
    return {
      sending: false,
      form: {
        title: this.book.title,
        author: this.book.author,
        publication_day: this.book.publication_day,
        publication_month: this.book.publication_month,
        publication_year: this.book.publication_year,
        publisher: this.book.publisher,
      }
    }
  },
  methods: {
    submit() {
      this.sending = true
      this.$inertia.put(this.route('book.update', this.book.id), this.form)
        .then(() => this.sending = false)
    }
  },
}
</script>
