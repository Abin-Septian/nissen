<template>
  <div class="container mb-12">
    <h4 class="mb-8 font-bold text-3xl">
      <inertia-link class="text-indigo-400 hover:text-indigo-600" :href="route('training_list')">Daftar Training</inertia-link>
      <span class="text-indigo-400 font-medium">/</span> {{ training.title }}
    </h4>
    <div class="mb-6 flex justify-end items-center">
      <inertia-link class="btn-indigo mr-3" :href="route('trainings.create')">
        <span>Edit</span>
        <span class="hidden md:inline">Training</span>
      </inertia-link>
      <inertia-link class="btn-indigo" :href="route('trainings.create')">
        <span>Cetak</span>
        <span class="hidden md:inline">Dokumen</span>
      </inertia-link>
    </div>
    <div class="card p-4">
      <div class="row">
        <div class="form-group col-md-6 col-sm-12">
          <label for="title">Nama Training</label>
          <input id="title" type="text" class="form-control" aria-describedby="emailHelp" disabled :value="training.title">
        </div>
        <div class="form-group col-md-6 col-sm-12">
          <label for="title">Tanggal Training</label>
          <input id="title" type="text" class="form-control" aria-describedby="emailHelp" disabled :value="training.date">
        </div>
        <div class="form-group col-md-6 col-sm-12">
          <label for="title">Jenis Training</label>
          <input id="title" type="text" class="form-control" aria-describedby="emailHelp" disabled :value="training.type">
        </div>
        <div class="form-group col-md-6 col-sm-12">
          <label for="title">Lokasi Training</label>
          <input id="title" type="text" class="form-control" aria-describedby="emailHelp" disabled :value="training.location">
        </div>
      </div>
    </div>
    <div class="d-flex justify-content-center my-3">
      <h4 class="font-bold">Daftar Peserta Training</h4>
    </div>
    <div class="bg-white rounded shadow">
      <table class="w-full whitespace-no-wrap">
        <tr class="text-center font-bold">
          <th class="px-6 pt-6 pb-4">Nama Peserta</th>
          <th class="px-6 pt-6 pb-4">NIK</th>
          <th class="px-6 pt-6 pb-4">Departement</th>
          <th class="px-6 pt-6 pb-4">Hasil</th>
        </tr>
        <tr v-for="participant in participants" :key="participant.id" class="hover:bg-gray-100 focus-within:bg-gray-100">
          <td class="border-t">
            <div class="px-6 py-4 flex items-center">
              {{ participant.name }}
            </div>
          </td>
          <td class="border-t link">
            <inertia-link class="px-6 py-4 flex items-center" :href="route('training_record.show', participant.id)" tabindex="-1">
              {{ participant.nik }}
            </inertia-link>
          </td>
          <td class="border-t">
            <div class="px-6 py-4 flex items-center">
              {{ participant.department }}
            </div>
          </td>
          <td class="border-t">
            <div class="px-6 py-4 flex items-center">
              <div class="rounded green">
                {{ participant.result }}
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
</template>

<script>
import Layout from '@/Shared/Layout'
import mapValues from 'lodash/mapValues'
import pickBy from 'lodash/pickBy'
import throttle from 'lodash/throttle'
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

<style>
.link {
  color:blue
}
.link:hover{
  text-decoration: underline;
}
</style>