<template>
  <div>
    <h1 class="mb-8 font-bold text-3xl">
      <inertia-link class="text-indigo-400 hover:text-indigo-600" :href="route('trainings')">Trainings</inertia-link>
      <span class="text-indigo-400 font-medium">/</span> Create
    </h1>
    <div class="bg-white rounded shadow overflow-hidden max-3xl">
      <form @submit.prevent="submit">
        <div class="p-8 -mr-6 -mb-8 flex flex-wrap">
          <text-input v-model="form.title" :errors="$page.errors.title" class="pr-6 pb-8 w-full lg:w-1/2" label="Title" />
        
          <text-input v-model="form.date" :errors="$page.errors.date" class="pr-6 pb-8 w-full lg:w-1/2" label="Date" />
        
          <text-input v-model="form.type" :errors="$page.errors.type" class="pr-6 pb-8 w-full lg:w-1/2" label="Type" />
        
          <text-input v-model="form.location" :errors="$page.errors.location" class="pr-6 pb-8 w-full lg:w-1/2" label="Location" />
        
          <text-input v-model="form.method" :errors="$page.errors.method" class="pr-6 pb-8 w-full lg:w-1/2" label="Method" />
        
          <text-input v-model="form.trainer" :errors="$page.errors.trainer" class="pr-6 pb-8 w-full lg:w-1/2" label="Trainer" />
          
          <text-input v-model="form.content" :errors="$page.errors.content" class="pr-6 pb-8 w-full lg:w-1/2" label="Content" />
          
          <text-input v-model="form.note" :errors="$page.errors.note" class="pr-6 pb-8 w-full lg:w-1/2" label="Note" />
        </div>
        <div class="p-8 -mr-6 -mb-8 flex flex-wrap">
          <table class="w-full whitespace-no-wrap">
            <tr class="text-left font-bold">
              <th class="px-6 pt-6 pb-4" />
              <th class="px-6 pt-6 pb-4">Name</th>
              <th class="px-6 pt-6 pb-4">NIK</th>
              <th class="px-6 pt-6 pb-4">Department</th>
              <th class="px-6 pt-6 pb-4">Section</th>
              <th class="px-6 pt-6 pb-4">Result value</th>
            </tr>
            <tr v-for="(employee, index) in employees.data" :key="employee.id">
              <td class="border-t">
                <input v-model="form.participans[index].checked" :value="employee.id" type="checkbox">
              </td>
              <td class="bordet-t">
                <span class="px-6 py-4 flex items-center">
                  {{ employee.name }}
                </span>
              </td>
              <td class="bordet-t">
                <span class="px-6 py-4 flex items-center">
                  {{ employee.nik }}
                </span>
              </td>
              <td class="bordet-t">
                <span class="px-6 py-4 flex items-center">
                  {{ employee.department.name }}
                </span>
              </td>
              <td class="bordet-t">
                <span class="px-6 py-4 flex items-center">
                  {{ employee.section.name }}
                </span>
              </td>
              <td class="bordet-t">
                <input v-model="form.participans[index].result" type="text" class="form-input">
              </td>
            </tr>
          </table>
        </div>
        <div class="px-8 py-4 bg-gray-100 border-t border-gray-200 flex justify-end items-center">
          <loading-button :loading="sending" class="btn-indigo" type="submit">Create Training</loading-button>
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
  metaInfo: { title: 'Create Training' },
  layout: Layout,
  components: {
    LoadingButton,
    // eslint-disable-next-line vue/no-unused-components
    SelectInput,
    TextInput,
  },
  props: {
    employees: Object,
    participans: Object,
  },
  remember: 'form',
  data() {
    return {
      sending: false,
      form: {
        title: null,
        date: null,
        type: null,
        location: null,
        trainer: null,
        content: null,
        method: null,
        participans: this.participans.data,
      },
    }
  },
  methods: {
    submit() {
      this.sending = true
      this.$inertia.post(this.route('trainings.store'), this.form)
        .then(() => this.sending = false)
    },
  },
}
</script>
