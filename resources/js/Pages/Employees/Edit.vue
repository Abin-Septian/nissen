<template>
  <div>
    <h1 class="mb-8 font-bold text-2xl">
      <inertia-link class="text-indigo-400 hover:text-indigo-600" :href="route('employees')">Daftar Karyawan</inertia-link>
      <span class="text-indigo-400 font-medium">/</span>
      {{ form.name }} / {{ form.nik }}
    </h1>
    <trashed-message v-if="employee.deleted_at" class="mb-6" @restore="restore">
      This employee has been deleted.
    </trashed-message>
    <div class="bg-white rounded shadow overflow-hidden max-w-8xl">
      <form @submit.prevent="submit">
        <div class="p-8 -mr-6 -mb-8 flex flex-wrap">
          <text-input v-model="form.nik" :errors="$page.errors.nik" class="pr-6 pb-8 w-full lg:w-1/2" label="NIK" />
          <text-input v-model="form.name" :errors="$page.errors.name" class="pr-6 pb-8 w-full lg:w-1/2" label="Nama" />
          <select-input v-model="form.department_id" :errors="$page.errors.department_id" class="pr-6 pb-8 w-full lg:w-1/2" label="Departement">
            <option :value="null" />
            <option v-for="department in departments" :key="department.id" :value="department.id">{{ department.name }}</option>
          </select-input>
          <select-input v-model="form.section_id" :errors="$page.errors.section_id" class="pr-6 pb-8 w-full lg:w-1/2" label="Section">
            <option :value="null" />
            <option v-for="section in sections" :key="section.id" :value="section.id">{{ section.name }}</option>
          </select-input>
          <select-input v-model="form.position_id" :errors="$page.errors.position_id" class="pr-6 pb-8 w-full lg:w-1/2" label="Posisi">
            <option :value="null" />
            <option v-for="position in positions" :key="position.id" :value="position.id">{{ position.name }}</option>
          </select-input>
          <div class="pr-6 pb-8 w-full lg:w-1/2">
            <label class="form-label" for="date-entry">Tanggal Masuk:</label>
            <date-picker id="date-entry" v-model="form.date_entry" valueType="format" style="width: 100%;" placeholder="Pilih Tanggal" input-class="form-input d-block" class="d-block" />
            <div v-if="$page.errors.date_entry" class="form-error">{{ $page.errors.date_entry }}</div>
          </div>
        </div>
        <div class="px-8 py-4 bg-gray-100 border-t border-gray-200 flex items-center">
          <button v-if="!employee.deleted_at" class="text-red-600 hover:underline" tabindex="-1" type="button" @click="destroy">Delete Contact</button>
          <loading-button :loading="sending" class="btn-indigo ml-auto" type="submit">Simpan</loading-button>
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
import TrashedMessage from '@/Shared/TrashedMessage'
import DatePicker from 'vue2-datepicker'

export default {
  metaInfo() {
    return {
      title: `Edit ${this.employee.name}`,
    }
  },
  layout: Layout,
  components: {
    LoadingButton,
    SelectInput,
    TextInput,
    TrashedMessage,
    DatePicker,
  },
  props: {
    employee: Object,
    departments: Array,
    sections: Array,
    positions: Array,
  },
  remember: 'form',
  data() {
    return {
      sending: false,
      form: {
        name: this.employee.name,
        nik: this.employee.nik,
        department_id: this.employee.department_id,
        section_id: this.employee.section_id,
        position_id: this.employee.position_id,
        date_entry: this.employee.date_entry,
      },
    }
  },
  methods: {
    submit() {
      this.sending = true
      this.$inertia.put(this.route('employees.update', this.employee.id), this.form)
        .then(() => this.sending = false)
    },
    destroy() {
      if (confirm('Are you sure you want to delete this employee?')) {
        this.$inertia.delete(this.route('employees.destroy', this.employee.id))
      }
    },
    restore() {
      if (confirm('Are you sure you want to restore this employee?')) {
        this.$inertia.put(this.route('employees.restore', this.employee.id))
      }
    },
  },
}
</script>
