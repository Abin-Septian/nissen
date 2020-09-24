<template>
  <div class="container mb-12">
    <h4 class="mb-8 font-bold text-2xl">
      <inertia-link class="text-indigo-400 hover:text-indigo-600" :href="route('training_record')">Training Record</inertia-link>
      <span class="text-indigo-400 font-medium">/</span> {{ employee.name }}
    </h4>
    <div class="mb-6 flex justify-end items-center">
      <button class="btn-indigo" @click="download">
        <span>Cetak</span>
        <span class="hidden md:inline">Dokumen</span>
      </button>
    </div>
    <div ref="content">
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
            <label for="title">Departemen</label>
            <input id="title" type="text" class="form-control" aria-describedby="emailHelp" disabled :value="employee.department.name">
          </div>
          <div class="form-group col-md-6 col-sm-12">
            <label for="title">Bagian</label>
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
        <table class="w-full table-auto">
          <tr class="text-center font-bold">
            <th class="px-6 pt-6 pb-4">No. </th>
            <th class="px-6 pt-6 pb-4">Training</th>
            <th class="px-6 pt-6 pb-4">Hasil</th>
            <th class="px-6 pt-6 pb-4">Nilai</th>
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
                {{ training.result == 1 ? 'Lulus' : 'Tidak Lulus' }}
              </div>
            </td>
            <td class="border-t">
              <div class="px-6 py-4 flex items-center">
                {{ training.score }}
              </div>
            </td>
          </tr>
          <tr v-if="trainings.length === 0">
            <td class="border-t px-6 py-4" colspan="4">No Training found.</td>
          </tr>
        </table>
      </div>
    </div>
  </div>
</template>

<script>
import Layout from '@/Shared/Layout'
import mapValues from 'lodash/mapValues'
import pickBy from 'lodash/pickBy'
import throttle from 'lodash/throttle'
import jsPDF from 'jspdf' 
import html2canvas from 'html2canvas'

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
    download(){
      const doc = new jsPDF('p', 'mm', 'a4')
      const name = `${this.employee.nik} - ${this.employee.name}`
      /** WITH CSS */
      // var canvasElement = document.createElement('canvas')

      html2canvas(this.$refs.content).then(function (canvas) {
        const imgData = canvas.toDataURL('image/png')
        const pdf = new jsPDF({
          orientation: 'potrait',
        })
        const imgProps= pdf.getImageProperties(imgData)
        const pdfWidth = pdf.internal.pageSize.getWidth()
        const pdfHeight = (imgProps.height * pdfWidth) / imgProps.width
        doc.addImage(imgData, 'PNG', 0, 0, pdfWidth, pdfHeight)
        doc.save(`${name}.pdf`)
      })
    },
  },
}
</script>
