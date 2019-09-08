<template>
  <layout title="Add Book">
    <h1 class="mb-8 font-bold text-3xl">
      <inertia-link class="text-green-light hover:text-green-dark" :href="route('libraries.books', library.id)">{{library.name}}</inertia-link>
      <span class="text-green-light font-medium">/</span> Create
    </h1>
    <div class="bg-white rounded shadow overflow-hidden">
      <form @submit.prevent="submit">
        <div class="p-8 -mr-6 -mb-8 flex flex-wrap justify-center">
          <v-quagga class="pr-6 pb-8 w-full xl:w-1/2" :onDetected="detected" :readerSize="readerSize" :readerTypes="['ean_reader']"></v-quagga>
          <text-input v-model="form.isbn" :errors="$page.errors.isbn" class="pr-6 pb-8 w-full lg:w-full" label="ISBN" />
        </div>
        <div class="px-8 py-4 bg-grey-lightest border-t border-grey-lighter flex justify-end items-center">
          <loading-button :loading="sending" class="btn-green" type="submit">Add Book</loading-button>
        </div>
      </form>
    </div>
  </layout>
</template>

<script>
import Layout from '@/Shared/Layout'
import LoadingButton from '@/Shared/LoadingButton'
import SelectInput from '@/Shared/SelectInput'
import TextInput from '@/Shared/TextInput'

export default {
  components: {
    Layout,
    LoadingButton,
    SelectInput,
    TextInput,
  },
  remember: 'form',
  props: ['library'],
  data() {
    return {
      sending: false,
      form: {
        isbn: null
      },
      readerSize: {
        width: 640,
        height: 480
      },
      detecteds: []
    }
  },
  methods: {
    submit() {
      this.sending = true
      this.$inertia.post(this.route('book.store', this.library.id), this.form)
        .then(() => this.sending = false)
    },
    detected(data) {
      this.form.isbn = data.codeResult.code
    }
  },
}
</script>

<style>
    #interactive video {
        width: 100%;
        position: relative;
    }

    #interactive canvas {
        display: none;
    }
</style>
