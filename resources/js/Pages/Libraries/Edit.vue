<template>
  <layout title="Create Library">
    <h1 class="mb-8 font-bold text-3xl">
      <inertia-link class="text-green-light hover:text-green-dark" :href="route('libraries')">{{form.name}}</inertia-link>
      <span class="text-green-light font-medium">/</span> Edit
    </h1>
    <div class="bg-white rounded shadow overflow-hidden">
      <form @submit.prevent="submit">
        <div class="p-8 -mr-6 -mb-8 flex flex-wrap">
          <text-input v-model="form.name" :errors="$page.errors.name" class="pr-6 pb-8 w-full lg:w-full" label="Name" />
          <text-input v-model="form.description" :errors="$page.errors.description" class="pr-6 pb-8 w-full lg:w-full" label="Description" />
        </div>
        <div class="px-8 py-4 bg-grey-lightest border-t border-grey-lighter flex justify-end items-center">
          <loading-button :loading="sending" class="btn-green" type="submit">Update Library</loading-button>
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
  props: ['library'],
  remember: 'form',
  data() {
    return {
      sending: false,
      form: {
        name: this.library.name,
        description: this.library.description
      }
    }
  },
  methods: {
    submit() {
      this.sending = true
      this.$inertia.put(this.route('libraries.update', this.library.id), this.form)
        .then(() => this.sending = false)
    }
  },
}
</script>
