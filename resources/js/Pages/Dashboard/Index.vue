<template>
  <div>
    <h1 class="mb-8 font-bold text-3xl">Dashborad</h1>
    <div class="container">
      <div class="row">
      </div>
    </div>
  </div>
</template>

<script>
import Layout from '@/Shared/Layout'

export default {
  metaInfo: { title: 'Dashboard' },
  layout: Layout,
  components: {
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
