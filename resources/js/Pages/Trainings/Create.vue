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
        
          <text-input v-model="form.method" :errors="$page.errors.method" class="pr-6 pb-8 w-full lg:w-1/2" label="Metode Evaluasi" />
        
          <text-input v-model="form.trainer" :errors="$page.errors.trainer" class="pr-6 pb-8 w-full lg:w-1/2" label="Trainer" />
          
          <text-area v-model="form.content" :errors="$page.errors.content" class="pr-6 pb-8 w-full" label="Materi Training" />
        </div>
        <div class="d-flex justify-content-center"><strong>Daftar Peserta Training</strong></div>
        <div class="p-4 mb-12 flex flex-wrap">
          <table class="w-full whitespace-no-wrap mb-4">
            <tr class="text-left font-bold">
              <th class="pl-1 pt-6 pb-4" />
              <th class="pl-1 pt-6 pb-4">NIK</th>
              <th class="pl-1 pt-6 pb-4">Nama</th>
              <th class="pl-1 pt-6 pb-4">Departement</th>
              <th class="pl-1 pt-6 pb-4">Bagian</th>
              <th class="pl-1 pt-6 pb-4">Hasil</th>
              <th class="pl-1 pt-6 pb-4">Nilai</th>
              <th class="pl-1 pt-6 pb-4">Catatan</th>
            </tr>
            <tr v-for="(employee, index) in employees" :key="employee.id">
              <td class="border-t">
                <input v-model="form.emp[index].checked" :value="employee.id" type="checkbox">
              </td>
              <td class="border-t">
                <span class="pl-1 py-4 flex items-center">
                  {{ employee.nik }}
                </span>
              </td>
              <td class="border-t">
                <span class="pl-1 py-4 flex items-center">
                  {{ employee.name }}
                </span>
              </td>
              <td class="border-t">
                <span class="pl-1 py-4 flex items-center">
                  {{ employee.dname }}
                </span>
              </td>
              <td class="border-t">
                <span class="pl-1 py-4 flex items-center">
                  {{ employee.sname }}
                </span>
              </td>
              <td class="border-t">
                <select-input v-model="form.emp[index].result" :value="employees.result" class="w-full">
                  <option :value="true">Lulus</option>
                  <option :value="false">Tidak Lulus</option>
                </select-input>
              </td>
              <td class="border-t">
                <input v-model="form.emp[index].score" type="text" class="form-input">
              </td>
              <td class="border-t">
                <input v-model="form.emp[index].note" type="text" class="form-input">
              </td>
            </tr>
          </table>
        </div>
        <div class="px-8 py-4 bg-transparant border-t border-gray-200 flex justify-end items-center" style="display:block; position:fixed; bottom:20px; right:20px;">
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
    employees: Array,
    participans: Object,
    types: Array,
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
        method: null,
        emp: this.employees,
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
