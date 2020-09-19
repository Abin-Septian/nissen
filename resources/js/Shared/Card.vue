<template>
  <div class="col-md-4 col-sm-12">
    <div class="max-w-sm rounded overflow-hidden shadow-lg">
      <div class="border border-gray-400 rounded-lg py-2 flex flex-col justify-between leading-normal">
        <div class="card-body bg-white">
          <div class="font-bold text-xl mb-2">{{ title }}</div>
          <h1 class="font-semi-bold text-gray-700 ">{{ desc }}</h1>
        </div>
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