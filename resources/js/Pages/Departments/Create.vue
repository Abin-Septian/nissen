<template>
  <div>
    <h1 class="mb-8 font-bold text-3xl">
      <inertia-link class="text-indigo-400 hover:text-indigo-600" :href="route('departments')">Daftar Departement</inertia-link>
      <span class="text-indigo-400 font-medium">/</span> Tambah Departement
    </h1>
    <div class="bg-white rounded shadow overflow-hidden max-w-8xl">
      <form @submit.prevent="submit">
        <div class="p-8 -mr-6 -mb-8 flex flex-wrap">
          <text-input v-model="form.name" :errors="$page.errors.name" class="pr-6 pb-8 w-full lg:w-1/2" label="Nama Departement" />
        </div>
        <div class="px-8 py-4 bg-gray-100 border-t border-gray-200 flex justify-end items-center">
          <loading-button :loading="sending" class="btn-indigo" type="submit">Simpan</loading-button>
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
  metaInfo: { title: 'Create Department' },
  layout: Layout,
  components: {
    LoadingButton,
    // eslint-disable-next-line vue/no-unused-components
    SelectInput,
    TextInput,
  },
  remember: 'form',
  data() {
    return {
      sending: false,
      form: {
        name: null,
      },
    }
  },
  methods: {
    submit() {
      this.sending = true
      this.$inertia.post(this.route('departments.store'), this.form)
        .then(() => this.sending = false)
    },
  },
}
</script>
