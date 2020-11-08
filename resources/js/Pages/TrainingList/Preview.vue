<template>
  <div class="container mb-12">
    <h4 class="mb-8 font-bold text-2xl">
      <inertia-link class="text-indigo-400 hover:text-indigo-600" :href="route('training_list')">Daftar Training</inertia-link>
      <span class="text-indigo-400 font-medium">/</span> 
      <inertia-link class="text-indigo-400 hover:text-indigo-600" :href="route('training_list.show', training.id)">{{ training.name }}</inertia-link>
    </h4>
    <div class="mb-6 flex justify-end items-center">
      <inertia-link class="btn-indigo mr-3" :href="route('trainings.edit', training.id)">
        <span>Update</span>
        <span class="hidden md:inline">Training</span>
      </inertia-link>
      <button class="btn-indigo" @click="download">
        <span>Cetak</span>
        <span class="hidden md:inline">Dokumen</span>
      </button>
    </div>
    <div ref="content">
      <div class="m-4 pt-2">
        <table style="width:100%;" class="tBorder text-center m-4">
          <col width="25%">
          <col width="25%">
          <col width="25%">
          <col width="25%">

          <thead class="tBorder">
            <tr>
              <td row>
                <img class="block w-20 l-30 ml-4" src="../../../../storage/app/users/n1bBG54O1vlr3S6xpeDaMClFI8IerB8AIaIepswA.png">
              </td>
              <td colspan="2" class="text-center font-bold text-xl">
                <br>
                <br>
                Laporan Training
                <br>
                <br>
              </td>
              <td />
            </tr>
            <tr class="tBorder">
              <td class="tBorder">Nama Training</td>
              <td class="tBorder font-bold">{{ training.name }}</td>
              <td class="tBorder">Tanggal Training</td>
              <td class="tBorder">{{ training.date }}</td>
            </tr>
            <tr class="tBorder">
              <td class="tBorder">Lokasi Training</td>
              <td class="tBorder">{{ training.location }}</td>
              <td class="tBorder">Trainer</td>
              <td class="tBorder">{{ training.trainer }}</td>
            </tr>
            <tr class="tBorder">
              <td class="tBorder">Metode Training</td>
              <td class="tBorder">{{ training.method }}</td>
              <td class="tBorder">Jenis Training</td>
              <td class="tBorder">{{ training.type.type }}</td>
            </tr>
            <tr class="tBorder">
              <td colspan="4" class="tBorder font-bold">Peserta Training</td>
            </tr>
          </thead>
          <tbody>
            <tr>
              <td colspan="4">
                <table style="width:100%">
                  <col style="width:20%">
                  <col style="width:30%">
                  <col style="width:20%">
                  <col style="width:10%">
                  <col style="width:10%">
                  <col style="width:10%">

                  <tr>
                    <th class="tBorder">NIK</th>
                    <th class="tBorder">Nama Peserta</th>
                    <th class="tBorder">Departemen</th>
                    <th class="tBorder">Hasil</th>
                    <th class="tBorder">Score</th>
                    <th class="tBorder">Catatan</th>
                  </tr>
                  <tr v-for="participant in participants" :key="participant.id" class="tBorder">
                    <td class="tBorder">
                      {{ participant.nik }}
                    </td>
                    <td class="tBorder">
                      {{ participant.name }}
                    </td>
                    <td class="tBorder">
                      {{ participant.department }}
                    </td>
                    <td class="tBorder">
                      <div class="rounded green">
                        {{ participant.result ? 'Lulus' : 'Tidak Lulus' }}
                      </div>
                    </td>
                    <td class="tBorder">
                      <div class="rounded green">
                        {{ participant.score }}
                      </div>
                    </td>
                    <td class="tBorder">
                      <div class="rounded green">
                        {{ participant.note }}
                      </div>
                    </td>
                  </tr>
                  <tr v-if="participants.length === 0">
                    <td class="tBorder px-6 py-4" colspan="4">No participant found.</td>
                  </tr>
                  <tr class="tBorder">
                    <td class="p-4 text-left">Keterangan : </td>
                    <td colspan="3" />
                  </tr>
                </table>
              </td>
            </tr>
          </tbody>
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
        const imgData = canvas.toDataURL({type : 'jpeg'})
        const pdf = new jsPDF({
          orientation: 'potrait',
        })
        const imgProps= pdf.getImageProperties(imgData)
        const pdfWidth = pdf.internal.pageSize.getWidth() - 10
        const pdfHeight = (imgProps.height * pdfWidth) / imgProps.width
        doc.addImage(imgData, 'JPEG', 0, 0, pdfWidth, pdfHeight)
        doc.save(`${name}.pdf`)
      })
    },
  },
}
</script>