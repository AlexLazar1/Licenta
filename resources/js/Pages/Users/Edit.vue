<template>
  <layout :title="`${form.first_name} ${form.last_name}`">
    <div class="mb-8 flex justify-start">
      <h1 class="font-bold text-3xl">
        {{ form.first_name }} {{ form.last_name }}
      </h1>
      <img v-if="user.photo" class="block w-8 h-8 rounded-full ml-4" :src="user.photo">
    </div>
    <div class="bg-white rounded shadow overflow-hidden">
      <form @submit.prevent="submit">
        <div class="p-8 -mr-6 -mb-8 flex flex-wrap">
          <text-input v-model="form.first_name" :errors="$page.errors.first_name" class="pr-6 pb-8 w-full lg:w-1/2" label="First name" />
          <text-input v-model="form.last_name" :errors="$page.errors.last_name" class="pr-6 pb-8 w-full lg:w-1/2" label="Last name" />
          <text-input v-model="form.email" :errors="$page.errors.email" class="pr-6 pb-8 w-full lg:w-1/2" label="Email" />
          <div class="pr-6 pb-8 w-full lg:w-1/2">
	    <label class="form-label">Phone Number:</label>	
            <vue-phone-number-input default-country-code="RO"  @update="updateNumber" class="pb-1" v-model="form.phone_number" />
            <span class="text-sm text-grey-dark">Make sure to fill out your phone number in order to share books!</span>
          </div>
	</div>
        <div class="px-8 py-4 bg-grey-lightest border-t border-grey-lighter flex items-center">
          <loading-button :loading="sending" class="btn-green ml-auto" type="submit">Update User</loading-button>
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
import FileInput from '@/Shared/FileInput'
import TrashedMessage from '@/Shared/TrashedMessage'

export default {
  components: {
    Layout,
    LoadingButton,
    SelectInput,
    TextInput,
    FileInput,
    TrashedMessage,
  },
  props: {
    user: Object,
  },
  remember: 'form',
  data() {
    return {
      sending: false,
      form: {
        first_name: this.user.first_name,
        last_name: this.user.last_name,
        email: this.user.email,
        phone_number: this.user.phone_number,
        formatted_phone_number: this.user.phone_number
      },
    }
  },
  methods: {
    submit() {
      this.sending = true

      var data = new FormData()
      data.append('first_name', this.form.first_name || '')
      data.append('last_name', this.form.last_name || '')
      data.append('email', this.form.email || '')
      data.append('phone_number', this.form.formatted_phone_number || '')
      data.append('password', this.form.password || '')
      data.append('_method', 'put')

      this.$inertia.post(this.route('users.update', this.user.id), data)
        .then(() => {
          this.sending = false
          if (Object.keys(this.$page.errors).length === 0) {
            this.form.password = null
          }
        })
    },
    updateNumber(e) {
    	this.form.formatted_phone_number = e.formattedNumber
    }	
  },
}
</script>
