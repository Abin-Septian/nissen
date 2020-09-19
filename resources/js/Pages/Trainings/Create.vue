<template>
  <div>
    <h1 class="mb-8 font-bold text-3xl">
      <inertia-link class="text-indigo-400 hover:text-indigo-600" :href="route('training_list')">Daftar Training</inertia-link>
      <span class="text-indigo-400 font-medium">/</span> Tambah Training
    </h1>
    <div class="bg-white rounded shadow overflow-hidden max-3xl">
      <form @submit.prevent="submit">
        <div class="p-8 -mr-6 -mb-8 flex flex-wrap">
          <text-input v-model="form.title" :errors="$page.errors.title" class="pr-6 pb-8 w-full lg:w-1/2" label="Nama Training" />

          <div class="pr-6 pb-8 w-full lg:w-1/2">
            <label class="form-label" for="date-entry">Tanggal:</label>
            <date-picker id="date-entry" v-model="form.date" valueType="format" style="width: 100%;" placeholder="Pilih Tanggal" input-class="form-input d-block" class="d-block" />
            <div v-if="$page.errors.date_entry" class="form-error">{{ $page.errors.date_entry }}</div>
          </div>
        
          <!-- type Select -->
          <select-input v-model="form.type_id" :errors="$page.errors.type_id" class="pr-6 pb-8 w-full lg:w-1/2" label="Tipe">
            <option :value="null" />
            <option v-for="type in types" :key="type.id" :value="type.id">{{ type.type }}</option>
          </select-input>
        
          <text-input v-model="form.location" :errors="$page.errors.location" class="pr-6 pb-8 w-full lg:w-1/2" label="Lokasi" />
        
          <text-input v-model="form.method" :errors="$page.errors.method" class="pr-6 pb-8 w-full lg:w-1/2" label="Metode" />
        
          <text-input v-model="form.trainer" :errors="$page.errors.trainer" class="pr-6 pb-8 w-full lg:w-1/2" label="Trainer" />
          
          <text-area v-model="form.content" :errors="$page.errors.content" class="pr-6 pb-8 w-full lg:w-1/2" label="Content" />
          
          <text-area v-model="form.note" :errors="$page.errors.note" class="pr-6 pb-8 w-full lg:w-1/2" label="Keterangan" />
        </div>
        <div class="p-8 -mr-6 -mb-8 flex flex-wrap">
          <table class="w-full whitespace-no-wrap">
            <tr class="text-left font-bold">
              <th class="px-6 pt-6 pb-4" />
              <th class="px-6 pt-6 pb-4">Nama</th>
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
          <loading-button :loading="sending" class="btn-indigo" type="submit">Simpan Training</loading-button>
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
import TextArea from '@/Shared/TextArea'
import DatePicker from 'vue2-datepicker'

export default {
  metaInfo: { title: 'Tambah Training' },
  layout: Layout,
  components: {
    LoadingButton,
    // eslint-disable-next-line vue/no-unused-components
    SelectInput,
    TextInput,
    TextArea,
    DatePicker,
  },
  props: {
    employees: Object,
    participans: Object,
    types: Object,
  },
  remember: 'form',
  data() {
    return {
      sending: false,
      form: {
        title: null,
        date: null,
        type_id: null,
        location: null,
        trainer: null,
        content: null,
        note: null,
        method: null,
        participans: this.participans.data,
        department_id : this.$parent.department_id,
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
