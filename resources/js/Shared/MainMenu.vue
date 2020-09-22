<template>
  <div>
    <div class="mb-4">
      <inertia-link class="flex items-center group py-3" :href="route('dashboard')">
        <icon name="dashboard" class="w-4 h-4 mr-2" :class="isUrl('') ? 'fill-white' : 'fill-indigo-400 group-hover:fill-white'" />
        <div :class="isUrl('') ? 'text-white' : 'text-indigo-300 group-hover:text-white'">Dashboard</div>
      </inertia-link>
    </div>
    <template v-if="owner == true">
      <div class="mb-4">
        <inertia-link class="flex items-center group py-3" :href="route('employees')">
          <icon name="users" class="w-4 h-4 mr-2" :class="isUrl('employees') ? 'fill-white' : 'fill-indigo-400 group-hover:fill-white'" />
          <div :class="isUrl('employees') ? 'text-white' : 'text-indigo-300 group-hover:text-white'">Daftar Karyawan</div>
        </inertia-link>
      </div>

      <!-- <div class="mb-4">
      <inertia-link class="flex items-center group py-3" :href="route('organizations')">
        <icon name="office" class="w-4 h-4 mr-2" :class="isUrl('organizations') ? 'fill-white' : 'fill-indigo-400 group-hover:fill-white'" />
        <div :class="isUrl('organizations') ? 'text-white' : 'text-indigo-300 group-hover:text-white'">Organizations</div>
      </inertia-link>
    </div> -->

      <!-- <div class="mb-4">
        <inertia-link class="flex items-center group py-3" :href="route('departments')">
          <icon name="office" class="w-4 h-4 mr-2" :class="isUrl('departments') ? 'fill-white' : 'fill-indigo-400 group-hover:fill-white'" />
          <div :class="isUrl('departments') ? 'text-white' : 'text-indigo-300 group-hover:text-white'">Daftar Departemen</div>
        </inertia-link>
      </div> -->

      <!-- <div class="mb-4">
        <inertia-link class="flex items-center group py-3" :href="route('sections')">
          <icon name="book" class="w-4 h-4 mr-2" :class="isUrl('sections') ? 'fill-white' : 'fill-indigo-400 group-hover:fill-white'" />
          <div :class="isUrl('sections') ? 'text-white' : 'text-indigo-300 group-hover:text-white'">Daftar Section</div>
        </inertia-link>
      </div> -->
      
      <!-- <div class="mb-4">
        <inertia-link class="flex items-center group py-3" :href="route('positions')">
          <icon name="book" class="w-4 h-4 mr-2" :class="isUrl('positions') ? 'fill-white' : 'fill-indigo-400 group-hover:fill-white'" />
          <div :class="isUrl('positions') ? 'text-white' : 'text-indigo-300 group-hover:text-white'">Daftar Posisi</div>
        </inertia-link>
      </div> -->
    </template>
    <!-- <div class="mb-4">
      <inertia-link class="flex items-center group py-3" :href="route('contacts')">
        <icon name="users" class="w-4 h-4 mr-2" :class="isUrl('contacts') ? 'fill-white' : 'fill-indigo-400 group-hover:fill-white'" />
        <div :class="isUrl('contacts') ? 'text-white' : 'text-indigo-300 group-hover:text-white'">Contacts</div>
      </inertia-link>
    </div> -->
    <!-- <div class="mb-4">
      <inertia-link class="flex items-center group py-3" :href="route('trainings')">
        <icon name="printer" class="w-4 h-4 mr-2" :class="isUrl('trainings') ? 'fill-white' : 'fill-indigo-400 group-hover:fill-white'" />
        <div :class="isUrl('trainings') ? 'text-white' : 'text-indigo-300 group-hover:text-white'">Input Training</div>
      </inertia-link>
    </div> -->
    <div class="mb-4">
      <inertia-link class="flex items-center group py-3" :href="route('training_list', { idDepartment: department_id, admin: owner })">
        <icon name="printer" class="w-4 h-4 mr-2" :class="isUrl('training_list') ? 'fill-white' : 'fill-indigo-400 group-hover:fill-white'" />
        <div :class="isUrl('training_list') ? 'text-white' : 'text-indigo-300 group-hover:text-white'">Laporan Training</div>
      </inertia-link>
    </div>
    <div class="mb-4">
      <inertia-link class="flex items-center group py-3" :href="route('training_record', { idDepartment: department_id, admin: owner })">
        <icon name="book" class="w-4 h-4 mr-2" :class="isUrl('training_record') ? 'fill-white' : 'fill-indigo-400 group-hover:fill-white'" />
        <div :class="isUrl('training_record') ? 'text-white' : 'text-indigo-300 group-hover:text-white'">Training Record</div>
      </inertia-link>
    </div>
  </div>
</template>

<script>
import Icon from '@/Shared/Icon'

export default {
  components: {
    Icon,
  },
  props: {
    url: String,
  },
  data(){
    return {
      owner : this.$parent.owner,
      department_id : this.$parent.department_id,
    }
  },
  methods: {
    isUrl(...urls) {
      if (urls[0] === '') {
        return this.url === ''
      }

      return urls.filter(url => this.url.startsWith(url)).length
    },
  },
}
</script>
