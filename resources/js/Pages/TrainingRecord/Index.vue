<template>
  <div>
    <h1 class="mb-8 font-bold text-2xl">Training Record</h1>
    <div class="bg-white rounded shadow overflow-x-auto text-sm">
      <table class="w-full table-auto">
        <tr class="text-left font-bold">
          <th class="px-6 pt-6 pb-4">NIK</th>
          <th class="px-6 pt-6 pb-4">Nama</th>
          <th class="px-6 pt-6 pb-4">Posisi</th>
          <th class="px-6 pt-6 pb-4">Departement</th>
          <th class="px-6 pt-6 pb-4" colspan="2">Bagian</th>
        </tr>
        <tr v-for="employee in employees" :key="employee.id" class="hover:bg-gray-100 focus-within:bg-gray-100">
          <td class="border-t">
            <inertia-link class="px-6 py-4 flex items-center focus:text-indigo-500" :href="route('training_record.show', employee.id)">
              {{ employee.nik }}
              <icon v-if="employee.deleted_at" name="trash" class="flex-shrink-0 w-3 h-3 fill-gray-400 ml-2" />
            </inertia-link>
          </td>
          <td class="border-t">
            <inertia-link class="px-6 py-4 flex items-center" :href="route('training_record.show', employee.id)" tabindex="-1">
              {{ employee.name }}
            </inertia-link>
          </td>
          <td class="border-t">
            <inertia-link class="px-6 py-4 flex items-center" :href="route('training_record.show', employee.id)" tabindex="-1">
              <div v-if="employee.dname">
                {{ employee.pname }}
              </div>
            </inertia-link>
          </td>
          <td class="border-t">
            <inertia-link class="px-6 py-4 flex items-center" :href="route('training_record.show', employee.id)" tabindex="-1">
              <div v-if="employee.pname">
                {{ employee.dname }}
              </div>
            </inertia-link>
          </td>
          <td class="border-t">
            <inertia-link class="px-6 py-4 flex items-center" :href="route('training_record.show', employee.id)" tabindex="-1">
              <div v-if="employee.sname">
                {{ employee.sname }}
              </div>
            </inertia-link>
          </td>
          <td class="border-t w-px">
            <inertia-link class="px-4 flex items-center" :href="route('training_record.show', employee.id)" tabindex="-1">
              <icon name="cheveron-right" class="block w-6 h-6 fill-gray-400" />
            </inertia-link>
          </td>
        </tr>
        <tr v-if="employees.length === 0">
          <td class="border-t px-6 py-4" colspan="5">No employees found.</td>
        </tr>
      </table>
    </div>
  </div>
</template>

<script>
import Icon from '@/Shared/Icon'
import Layout from '@/Shared/Layout'
import mapValues from 'lodash/mapValues'
import pickBy from 'lodash/pickBy'
import throttle from 'lodash/throttle'

export default {
  metaInfo: { title: 'Employees' },
  layout: Layout,
  components: {
    Icon,
  },
  props: {
    employees: Array,
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
  },
}
</script>
