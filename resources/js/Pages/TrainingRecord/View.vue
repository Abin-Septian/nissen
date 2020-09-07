<template>
  <div class="container mb-12">
    <h4 class="mb-8 font-bold text-3xl">
      <inertia-link class="text-indigo-400 hover:text-indigo-600" :href="route('training_list')">Training Record</inertia-link>
      <span class="text-indigo-400 font-medium">/</span> {{ employee.name }}
    </h4>
    <div class="mb-6 flex justify-end items-center">
      <inertia-link class="btn-indigo" :href="route('trainings.create')">
        <span>Cetak</span>
        <span class="hidden md:inline">Dokumen</span>
      </inertia-link>
    </div>
    <div class="card p-4">
      <div class="row">
        <div class="form-group col-md-6 col-sm-12">
          <label for="title">Nama</label>
          <input id="title" type="text" class="form-control" aria-describedby="emailHelp" disabled :value="employee.name">
        </div>
        <div class="form-group col-md-6 col-sm-12">
          <label for="title">NIK</label>
          <input id="title" type="text" class="form-control" aria-describedby="emailHelp" disabled :value="employee.nik">
        </div>
        <div class="form-group col-md-6 col-sm-12">
          <label for="title">Departement</label>
          <input id="title" type="text" class="form-control" aria-describedby="emailHelp" disabled :value="employee.department.name">
        </div>
        <div class="form-group col-md-6 col-sm-12">
          <label for="title">Section</label>
          <input id="title" type="text" class="form-control" aria-describedby="emailHelp" disabled :value="employee.section.name">
        </div>
        <div class="form-group col-md-6 col-sm-12">
          <label for="title">Posisi</label>
          <input id="title" type="text" class="form-control" aria-describedby="emailHelp" disabled :value="employee.position.name">
        </div>
        <div class="form-group col-md-6 col-sm-12">
          <label for="title">Tanggal Masuk</label>
          <input id="title" type="text" class="form-control" aria-describedby="emailHelp" disabled :value="employee.date_entry">
        </div>
      </div>
    </div>
    <div class="d-flex justify-content-center my-3">
      <h4 class="font-bold">Daftar Training</h4>
    </div>
    <div class="bg-white rounded shadow">
      <table class="w-full whitespace-no-wrap">
        <tr class="text-center font-bold">
          <th class="px-6 pt-6 pb-4">No. </th>
          <th class="px-6 pt-6 pb-4">Training</th>
          <th class="px-6 pt-6 pb-4">Hasil</th>
        </tr>
        <tr v-for="(training, index) in trainings" :key="index" class="hover:bg-gray-100 focus-within:bg-gray-100">
          <td class="border-t">
            <div class="px-6 py-4 flex items-center">
              {{ index + 1 }}
            </div>
          </td><td class="border-t">
            <div class="px-6 py-4 flex items-center">
              {{ training.title }}
            </div>
          </td>
          <td class="border-t">
            <div class="px-6 py-4 flex items-center">
              {{ training.result }}
            </div>
          </td>
        </tr>
        <tr v-if="trainings.length === 0">
          <td class="border-t px-6 py-4" colspan="4">No Training found.</td>
        </tr>
      </table>
    </div>
  </div>
</template>

<script>
import Layout from '@/Shared/Layout'
import mapValues from 'lodash/mapValues'
import pickBy from 'lodash/pickBy'
import throttle from 'lodash/throttle'

export default {
  metaInfo: { title: 'Training Record' },
  layout: Layout,
  components: {
  },
  props: {
    employee: Object,
    trainings: Array,
  },
  data() {
    return {

    }
  },
  watch: {
    form: {
      handler: throttle(function() {
        let query = pickBy(this.form)
        this.$inertia.replace(this.route('employees', Object.keys(query).length ? query : { remember: 'forget' }))
      }, 150),
      deep: true,
    },
  },
  methods: {
    reset() {
      this.form = mapValues(this.form, () => null)
    },
  },
}
</script>
