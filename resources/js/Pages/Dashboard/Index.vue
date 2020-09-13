<template>
  <div>
    <h1 class="mb-8 font-bold text-3xl">Dashborad</h1>
    <div class="container">
      <div class="row justify-content-center">
        <div class="col-md-10">
          <div class="row d-flex">
            <card-component v-for="(card, index) in cards" :key="index" :title="card.title" :desc="card.desc" />
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import Layout from '@/Shared/Layout'
import Card from '@/Shared/Card'

export default {
  metaInfo: { title: 'Dashboard' },
  layout: Layout,
  components: {
    CardComponent : Card,
  },
  data(){
    return {
      cards: [
        {
          title: 'Jumlah Training',
          desc: '67',
        },
        {
          title: 'Training Bulan ini',
          desc: '11',
        },
        {
          title: 'Jumlah Pegawai',
          desc: '145',
        },
      ],
    }
  },
}
</script>
