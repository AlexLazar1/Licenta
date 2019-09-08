<template>
  <div class="p-6 bg-green-darker min-h-screen flex justify-center items-center">
    <div class="w-full max-w-sm">
      <logo class="block mx-auto w-full max-w-xs fill-white text-center" height="50" />
      <form class="mt-8 bg-white rounded-lg shadow-lg overflow-hidden" @submit.prevent="submit">
        <div class="px-10 py-12">
          <h1 class="text-center font-bold text-3xl">Register</h1>
          <div class="mx-auto mt-6 w-24 border-b-2" />
          <text-input v-model="form.firstName" :errors="$page.errors.first_name" class="mt-10" label="First Name" type="text" autofocus autocapitalize="off" :required="true" />
          <text-input v-model="form.lastName" :errors="$page.errors.last_name" class="mt-6" label="Last Name" type="text" autofocus autocapitalize="off" :required="true" />
          <text-input v-model="form.email" :errors="$page.errors.email" class="mt-6" label="Email" type="email" autofocus autocapitalize="off" :required="true" />
	  <label class="form-label" class="mt-6">Phone Number:</label>
          <vue-phone-number-input class="pb-1" default-country-code="RO"  v-model="form.phoneNumber" @update="updateNumber" />
	  <span class="text-sm text-grey-dark">Make sure to fill out your phone number in order to share books!</span>
          <text-input v-model="form.password" :errors="$page.errors.password" class="mt-6" label="Password" type="password" :required="true" />
          <text-input v-model="form.passwordConfirmation" :errors="$page.errors.password_confirmation" class="mt-6" label="Password Confirmation" type="password" :required="true" />
        </div>
        <div class="px-10 py-4 bg-grey-lightest border-t border-grey-lighter flex justify-end items-center">
          <loading-button :loading="sending" class="btn-green" type="submit">Register</loading-button>
        </div>
      </form>
    </div>
  </div>
</template>

<script>
import LoadingButton from '@/Shared/LoadingButton'
import Logo from '@/Shared/Logo'
import TextInput from '@/Shared/TextInput'

export default {
  components: {
    LoadingButton,
    Logo,
    TextInput,
  },
  props: {
    errors: Object,
  },
  data() {
    return {
      sending: false,
      form: {
        firstName: null,
        lastname: null,
        email: null,
        phoneNumber: null,
	formattedNumber: null,
        password: null,
        passwordConfirmation: null
      },
    }
  },
  mounted() {
    document.title = 'Register | BookIt'
  },
  methods: {
    submit() {
      this.sending = true
      this.$inertia.post(this.route('register.submit'), {
        first_name: this.form.firstName,
        last_name: this.form.lastName,
        email: this.form.email,
        phone_number: this.form.formattedNumber,
        password: this.form.password,
        password_confirmation: this.form.passwordConfirmation
      }).then(() => this.sending = false)
    },
    updateNumber(e) {
	this.form.formattedNumber = e.formattedNumber
    },
  }
}
</script>
