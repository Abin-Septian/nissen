<template>
  <div class="container mb-12">
    <h4 class="mb-8 font-bold text-2xl">
      <inertia-link class="text-indigo-400 hover:text-indigo-600" :href="route('training_list')">Daftar Training</inertia-link>
      <span class="text-indigo-400 font-medium">/</span> {{ training.name }}
    </h4>
    <div class="mb-6 flex justify-end items-center">
      <inertia-link class="btn-indigo mr-3" :href="route('trainings.edit', training.id)">
        <span>Edit</span>
        <span class="hidden md:inline">Training</span>
      </inertia-link>
      <inertia-link class="btn-indigo mr-3" :href="route('training.preview', training.id)">
        <span>Preview</span>
        <span class="hidden md:inline">Training</span>
      </inertia-link>
    </div>
    <div ref="content">
      <div class="card p-4">
        <div class="row">
          <div class="form-group col-md-6 col-sm-12">
            <label for="title">Nama Training</label>
            <input id="title" type="text" class="form-control" aria-describedby="emailHelp" disabled :value="training.name">
          </div>
          <div class="form-group col-md-6 col-sm-12">
            <label for="title">Tanggal Training</label>
            <input id="title" type="text" class="form-control" aria-describedby="emailHelp" disabled :value="training.date">
          </div>
          <div class="form-group col-md-6 col-sm-12">
            <label for="title">Jenis Training</label>
            <input id="title" type="text" class="form-control" aria-describedby="emailHelp" disabled :value="training.type.type">
          </div>
          <div class="form-group col-md-6 col-sm-12">
            <label for="title">Trainer</label>
            <input id="title" type="text" class="form-control" aria-describedby="emailHelp" disabled :value="training.trainer">
          </div>
          <div class="form-group col-md-6 col-sm-12">
            <label for="title">Metode</label>
            <input id="title" type="text" class="form-control" aria-describedby="emailHelp" disabled :value="training.method">
          </div>
          <div class="form-group col-md-6 col-sm-12">
            <label for="title">Lokasi Training</label>
            <input id="title" type="text" class="form-control" aria-describedby="emailHelp" disabled :value="training.location">
          </div>
          <div class="form-group col-md-12 col-sm-12">
            <label for="title">Materi Training</label>
            <textarea id="title" class="form-control" style="white-space:pre;" disabled :value="training.content" />
          </div>
        </div>
      </div>
      <div class="d-flex justify-content-center my-3">
        <h4 class="font-bold">Daftar Peserta Training</h4>
      </div>
      <div class="bg-white rounded shadow">
        <table class="w-full table-auto">
          <tr class="text-center font-bold">
            <th class="px-6 pt-6 pb-4">NIK</th>
            <th class="px-6 pt-6 pb-4">Nama Peserta</th>
            <th class="px-6 pt-6 pb-4">Departemen</th>
            <th class="px-6 pt-6 pb-4">Hasil</th>
            <th class="px-6 pt-6 pb-4">Score</th>
            <th class="px-6 pt-6 pb-4">Catatan</th>
          </tr>
          <tr v-for="participant in participants" :key="participant.id" class="hover:bg-gray-100 focus-within:bg-gray-100">
            <td class="border-t" style="color:blue;">
              <inertia-link class="px-6 py-4 flex items-center" :href="route('training_record.show', participant.id)" tabindex="-1">
                {{ participant.nik }}
              </inertia-link>
            </td>
            <td class="border-t">
              <div class="px-6 py-4 flex items-center">
                {{ participant.name }}
              </div>
            </td>
            <td class="border-t">
              <div class="px-6 py-4 flex items-center">
                {{ participant.department }}
              </div>
            </td>
            <td class="border-t">
              <div class="px-6 py-4 flex items-center">
                <div class="rounded green">
                  {{ participant.result ? 'Lulus' : 'Tidak Lulus' }}
                </div>
              </div>
            </td>
            <td class="border-t">
              <div class="px-6 py-4 flex items-center">
                <div class="rounded green">
                  {{ participant.score }}
                </div>
              </div>
            </td>
            <td class="border-t">
              <div class="px-6 py-4 flex items-center">
                <div class="rounded green">
                  {{ participant.note }}
                </div>
              </div>
            </td>
          </tr>
          <tr v-if="participants.length === 0">
            <td class="border-t px-6 py-4" colspan="4">No participant found.</td>
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
// import TextArea from '@/Shared/TextArea'
import jsPDF from 'jspdf' 
import html2canvas from 'html2canvas'
// import Icon from '@/Shared/Icon'

export default {
  metaInfo: { title: 'Training List' },
  layout: Layout,
  components: {
    // Icon,
  },
  props: {
    training: Object,
    participants: Array,
  },
  data() {
    return {
      form: {
      },
    }
  },
  watch: {
    form: {
      handler: throttle(function() {
        let query = pickBy(this.form)
        this.$inertia.replace(this.route('trainings', Object.keys(query).length ? query : { remember: 'forget' }))
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
      const name = this.training.name
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