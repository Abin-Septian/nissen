<template>
  <div>
    <h1 class="mb-8 font-bold text-2xl">
      <inertia-link class="text-indigo-400 hover:text-indigo-600" :href="route('training_list')">Daftar Training</inertia-link>
      <span class="text-indigo-400 font-medium">/</span> Edit Training
      <span class="text-indigo-400 font-medium">/</span> {{ training.name }}
    </h1>
    <div class="bg-white rounded shadow overflow-hidden max-3xl">
      <form @submit.prevent="submit">
        <div class="p-8 -mr-6 -mb-8 flex flex-wrap">
          <text-input v-model="form.name" :errors="$page.errors.name" class="pr-6 pb-8 w-full lg:w-1/2" label="Nama Training" />

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
        
          <select-input v-model="form.method" :errors="$page.errors.method" class="pr-6 pb-8 w-full lg:w-1/2" label="Metode Evaluasi">
            <option :value="null" />
            <option v-for="(met, index) in methods" :key="index" :value="met.name">{{ met.name }}</option>
          </select-input>
        
          <text-input v-model="form.trainer" :errors="$page.errors.trainer" class="pr-6 pb-8 w-full lg:w-1/2" label="Trainer" />
          
          <text-area v-model="form.content" :errors="$page.errors.content" class="pr-6 pb-8 w-full" label="Materi Training" />
        </div>
        <div class="px-8 py-4 bg-gray-100 border-t border-gray-200 flex items-center">
          <button class="btn btn-danger hover:underline" tabindex="-1" type="button" @click="destroy">Delete Training</button>
        </div>
        <div class="p-8 mb-12 flex flex-wrap">
          <table class="w-full table-auto mb-12">
            <tr class="text-left font-bold">
              <th class="pr-1 pt-6 pb-4" />
              <th class="pr-1 pt-6 pb-4">NIK</th>
              <th class="pr-1 pt-6 pb-4">Nama</th>
              <th class="pr-1 pt-6 pb-4">Departemen</th>
              <th class="pr-1 pt-6 pb-4">Bagian</th>
              <th class="pr-1 pt-6 pb-4">Hasil</th>
              <th class="pr-1 pt-6 pb-4">Nilai</th>
              <th class="pr-1 pt-6 pb-4">Catatan</th>
            </tr>
            <tr v-for="(employee, index) in employees" :key="index">
              <td class="border-t">
                <input v-model="form.employee[index].participant" type="checkbox">
              </td>
              <td class="border-t">
                <span class="pr-1 py-4 flex items-center">
                  {{ employee.nik }}
                </span>
              </td>
              <td class="border-t">
                <span class="pr-1 py-4 flex items-center">
                  {{ employee.name }}
                </span>
              </td>
              <td class="border-t">
                <span class="pr-1 py-4 flex items-center">
                  {{ employee.dname }}
                </span>
              </td>
              <td class="border-t">
                <span class="pr-1 py-4 flex items-center">
                  {{ employee.sname }}
                </span>
              </td>
              <td class="border-t">
                <select-input v-model="form.employee[index].result" class="w-full">
                  <option :value="true">Lulus</option>
                  <option :value="false">Tidak Lulus</option>
                </select-input>
              </td>
              <td class="border-t">
                <input v-model="form.employee[index].score" type="text" class="form-input">
              </td>
              <td class="border-t">
                <input v-model="form.employee[index].note" type="text" class="form-input">
              </td>
            </tr>
          </table>
        </div>
        <div class="px-8 py-4 bg-transparant border-t border-gray-200 flex justify-end items-center" style="display:block; position:fixed; bottom:20px; right:20px;">
          <loading-button :loading="sending" class="btn-indigo" type="submit">Update Training</loading-button>
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
    training: Object,
    employees: Array,
    types: Array,
    methods: Array,
  },
  remember: 'form',
  data() {
    return {
      sending: false,
      form: {
        name: this.training.name,
        date: this.training.date,
        type_id: this.training.type.id,
        location: this.training.location,
        trainer: this.training.trainer,
        content: this.training.content,
        method: this.training.method,
        department_id : this.training.department_id,
        employee: this.employees,
      },
    }
  },
  methods: {
    submit() {
      this.sending = true
      this.$inertia.put(this.route('trainings.update', this.training.id), this.form)
        .then(() => this.sending = false)
    },
    destroy() {
      if (confirm(`Apakah anda yakin akan menghapus ${this.form.name} ?`)) {
        this.$inertia.delete(this.route('trainings.destroy', this.training.id))
      }
    },
  },
}
</script>
