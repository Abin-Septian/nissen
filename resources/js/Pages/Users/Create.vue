<template>
  <div>
    <h1 class="mb-8 font-bold text-3xl">
      <inertia-link class="text-indigo-400 hover:text-indigo-600" :href="route('users')">Users</inertia-link>
      <span class="text-indigo-400 font-medium">/</span> Create
    </h1>
    <div class="bg-white rounded shadow overflow-hidden max-w-8xl">
      <form @submit.prevent="submit">
        <div class="p-8 -mr-6 -mb-8 flex flex-wrap">
          <text-input v-model="form.first_name" :errors="$page.errors.first_name" class="pr-6 pb-8 w-full lg:w-1/2" label="First name" />
          <text-input v-model="form.last_name" :errors="$page.errors.last_name" class="pr-6 pb-8 w-full lg:w-1/2" label="Last name" />
          <text-input v-model="form.email" :errors="$page.errors.email" class="pr-6 pb-8 w-full lg:w-1/2" label="Email" />
          <text-input v-model="form.password" :errors="$page.errors.password" class="pr-6 pb-8 w-full lg:w-1/2" type="password" autocomplete="new-password" label="Password" />
          <select-input v-model="form.owner" :errors="$page.errors.owner" class="pr-6 pb-8 w-full lg:w-1/2" label="Role">
            <option :value="true">Admin</option>
            <option :value="false">User</option>
          </select-input>
          <!-- Department Select -->
          <select-input v-model="form.department_id" :errors="$page.errors.department_id" class="pr-6 pb-8 w-full lg:w-1/2" label="Department">
            <option :value="null" />
            <option v-for="department in departments" :key="department.id" :value="department.id">{{ department.name }}</option>
          </select-input>
        </div>
        <div class="px-8 py-4 bg-gray-100 border-t border-gray-200 flex justify-end items-center">
          <loading-button :loading="sending" class="btn-indigo" type="submit">Create User</loading-button>
        </div>
      </form>
    </div>
  </div>
</template>

<script>
import Layout from '@/Shared/Layout'
import LoadingButton from '@/Shared/LoadingButton'
import SelectInput from '@/Shared/SelectInput'
import TextInput from '@/Shared/TextInput'

export default {
  metaInfo: { title: 'Create User' },
  layout: Layout,
  components: {
    LoadingButton,
    SelectInput,
    TextInput,
  },
  remember: 'form',
  props: {
    departments: Array,
  },
  data() {
    return {
      sending: false,
      form: {
        first_name: null,
        last_name: null,
        email: null,
        password: null,
        owner: false,
        department_id: null,
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
      data.append('password', this.form.password || '')
      data.append('owner', this.form.owner ? '1' : '0')
      data.append('department_id', this.form.department_id || '')

      this.$inertia.post(this.route('users.store'), data)
        .then(() => this.sending = false)
    },
  },
}
</script>
