<template>
  <div>
    <div style="background-color:white;" class="d-flex flex-row-reverse mb-6">
      <button class="flex btn-indigo" @click="download">
        <span>
          <icon name="printer" class="w-4 h-4 mr-2 fill-white" />
        </span>
        Cetak dokumen
      </button>
    </div>
    
    <div ref="content" style="background-color:white;">
      <h2 class="text-center my-5">Laporan Training</h2>
      <div class="table-bordered border border-light">
        <table class="table table-bordered" style="width:100%;">
          <tbody class="text-center border-light" style="color: rgb(1,1,1);">
            <tr>
              <td style="font-weight: normal;font-size: 15px;" rowspan="2"><br>Judul Training<br><br></td>
              <td class="text-center font-weight-bold" rowspan="2">{{ training.title }}</td>
              <td class="text-center font-weight-bold" rowspan="2">TTD</td>
              <td class="text-center font-weight-bold">Dibuat</td>
              <td class="text-center font-weight-bold">Diperiksa</td>
              <td class="text-center font-weight-bold">Disetujui</td>
            </tr>
            <tr>
              <td />
              <td />
              <td />
            </tr>
            <tr>
              <td class="font-weight-bold">Tanggal</td>
              <td colspan="5">{{ training.date }}</td>
            </tr>
            <tr>
              <td class="font-weight-bold">Tempat</td>
              <td colspan="2">{{ training.location }}</td>
              <td class="font-weight-bold">Lama Disimpan</td>
              <td colspan="2" />
            </tr>
            <tr>
              <td class="font-weight-bold">Trainer</td>
              <td colspan="2">{{ training.trainer }}</td>
              <td class="font-weight-bold">Tanggal Disposal</td>
              <td colspan="2" />
            </tr>
            <tr>
              <td class="font-weight-bold">Konten Training</td>
              <td colspan="5" />
            </tr>
            <tr>
              <td class="font-weight-bold">Metode Evaluasi</td>
              <td colspan="5">{{ training.method }}</td>
            </tr>
          </tbody>
        </table>
      </div>
      <h6 class="text-center my-4">Daftar Peserta Training</h6>
      <div class="table-bordered">
        <table class="table table-bordered" style="color: rgb(1,1,1); width:100%;">
          <thead>
            <tr class="text-center">
              <th class="text-center">No.</th>
              <th>NIK</th>
              <th>Nama</th>
              <th>Departemen</th>
              <th>Nilai</th>
              <th>Hasil</th>
            </tr>
          </thead>
          <tbody class="border rounded-0 border-dark">
            <tr v-for="(participant, index) in participants" :key="index">
              <td class="text-center">{{ index+1 }}</td>
              <td class="text-center">{{ participant.nik }}</td>
              <td class="text-center">{{ participant.name }}</td>
              <td class="text-center">{{ participant.department }}</td>
              <td class="text-center">{{ participant.result }}</td>
              <td class="text-center"><input type="button" class="btn btn-success" style="bg-color:green;">Pass</input></td>
            </tr>
            <tr>
              <td colspan="2">Keterangan</td>
              <td colspan="4"></td>
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
import Icon from '@/Shared/Icon'

export default {
  metaInfo: { title: 'Training List' },
  layout: Layout,
  components: {
    Icon,
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
      /* global jsPDF */
      const doc = new jsPDF()

      const html = this.$refs.content.innerHTML

      doc.fromHTML(html, 15, 15, {
        width:150,
      })

      doc.save('test.pdf')
    },
  },
}
</script>

<style scoped>
  h1,h2,h3,h4,h5,h6{
    color: black;
  }
  table{
    width: 100%;
  }
  th{
    border:1px solid black;
    border-collapse: collapse;
    padding: 10px 0;
  }
  tr{
    border:1px solid black;
    border-collapse: collapse;
  }
  td{
    border:1px solid black;
    border-collapse: collapse;
    padding: 10px 0;
  }
</style>