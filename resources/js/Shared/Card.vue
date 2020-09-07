<template>
  <div class="col-md-4 col-sm-12">
    <div class="card mb-4">
      <div class="card-body">
        <h3 class="card-title">{{ title }}</h3>
        <h1>{{ desc }}</h1>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  props: {
    title: String,
    desc: String,
  },
}
</script>