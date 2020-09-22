<template>
  <div>
    <h1 class="mb-8 font-bold text-2xl">
      <inertia-link class="text-indigo-400 hover:text-indigo-600" :href="route('employees')">Daftar Karyawan</inertia-link>
      <span class="text-indigo-400 font-medium">/</span> Tambah Karyawan
    </h1>
    <div class="bg-white rounded shadow overflow-hidden max-w-8xl">
      <form @submit.prevent="submit">
        <div class="p-8 -mr-6 -mb-8 flex flex-wrap">
          <text-input v-model="form.nik" :errors="$page.errors.nik" class="pr-6 pb-8 w-full lg:w-1/2" label="NIK" />

          <text-input v-model="form.name" :errors="$page.errors.name" class="pr-6 pb-8 w-full lg:w-1/2" label="Nama" />
          
          <!-- Department Select -->
          <select-input v-model="form.department_id" :errors="$page.errors.department_id" class="pr-6 pb-8 w-full lg:w-1/2" label="Departement">
            <option :value="null" />
            <option v-for="department in departments" :key="department.id" :value="department.id">{{ department.name }}</option>
          </select-input>

          <!-- Position Select -->
          <select-input v-model="form.position_id" :errors="$page.errors.position_id" class="pr-6 pb-8 w-full lg:w-1/2" label="Posisi">
            <option :value="null" />
            <option v-for="position in positions" :key="position.id" :value="position.id">{{ position.name }}</option>
          </select-input>

          <!-- Section Input -->
          <select-input v-model="form.section_id" :errors="$page.errors.section_id" class="pr-6 pb-8 w-full lg:w-1/2" label="Section">
            <option :value="null" />
            <option v-for="section in sections" :key="section.id" :value="section.id">{{ section.name }}</option>
          </select-input>
        
          <div class="pr-6 pb-8 w-full lg:w-1/2">
            <label class="form-label" for="date-entry">Tanggal Masuk:</label>
            <date-picker id="date-entry" v-model="form.date_entry" valueType="format" style="width: 100%;" placeholder="Pilih Tanggal" input-class="form-input d-block" class="d-block" />
            <div v-if="$page.errors.date_entry" class="form-error">{{ $page.errors.date_entry }}</div>
          </div>
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
import DatePicker from 'vue2-datepicker'

export default {
  metaInfo: { title: 'Add Employee' },
  layout: Layout,
  components: {
    LoadingButton,
    SelectInput,
    TextInput,
    DatePicker,
  },
  props: {
    departments: Array,
    sections: Array,
    positions: Array,
  },
  remember: 'form',
  data() {
    return {
      sending: false,
      form: {
        name: null,
        nik: null,
        department_id: null,
        position_id: null,
        section_id: null,
        date_entry: null,
      },
    }
  },
  methods: {
    submit() {
      this.sending = true
      this.$inertia.post(this.route('employees.store'), this.form)
        .then(() => this.sending = false)
    },
  },
}
</script>
