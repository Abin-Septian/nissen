<template>
  <div>
    <h1 class="mb-8 font-bold text-2xl">
      <inertia-link class="text-indigo-400 hover:text-indigo-600" :href="route('positions')">Positions</inertia-link>
      <span class="text-indigo-400 font-medium">/</span>
      {{ form.name }}
    </h1>
    <trashed-message v-if="position.deleted_at" class="mb-6" @restore="restore">
      This position has been deleted.
    </trashed-message>
    <div class="bg-white rounded shadow overflow-hidden max-w-8xl">
      <form @submit.prevent="submit">
        <div class="p-8 -mr-6 -mb-8 flex flex-wrap">
          <text-input v-model="form.name" :errors="$page.errors.name" class="pr-6 pb-8 w-full lg:w-1/2" label="Name" />
        </div>
        <div class="px-8 py-4 bg-gray-100 border-t border-gray-200 flex items-center">
          <button v-if="!position.deleted_at" class="text-red-600 hover:underline" tabindex="-1" type="button" @click="destroy">Delete Position</button>
          <loading-button :loading="sending" class="btn-indigo ml-auto" type="submit">Update Position</loading-button>
        </div>
      </form>
    </div>
  </div>
</template>

<script>
import Icon from '@/Shared/Icon'
import Layout from '@/Shared/Layout'
import LoadingButton from '@/Shared/LoadingButton'
import SelectInput from '@/Shared/SelectInput'
import TextInput from '@/Shared/TextInput'
import TrashedMessage from '@/Shared/TrashedMessage'

export default {
  metaInfo() {
    return { title: this.form.name }
  },
  layout: Layout,
  components: {
    // eslint-disable-next-line vue/no-unused-components
    Icon,
    LoadingButton,
    // eslint-disable-next-line vue/no-unused-components
    SelectInput,
    TextInput,
    TrashedMessage,
  },
  props: {
    position: Object,
  },
  remember: 'form',
  data() {
    return {
      sending: false,
      form: {
        name: this.position.name,
      },
    }
  },
  methods: {
    submit() {
      this.sending = true
      this.$inertia.put(this.route('positions.update', this.position.id), this.form)
        .then(() => this.sending = false)
    },
    destroy() {
      if (confirm('Are you sure you want to delete this position?')) {
        this.$inertia.delete(this.route('positions.destroy', this.position.id))
      }
    },
    restore() {
      if (confirm('Are you sure you want to restore this position?')) {
        this.$inertia.put(this.route('positions.restore', this.position.id))
      }
    },
  },
}
</script>
