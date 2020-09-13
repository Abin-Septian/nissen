<template>
  <div>
    <label v-if="label" class="form-label" :for="id">{{ label }}:</label>
    <date-picker :id="id" ref="input" v-model="value" v-bind="$attrs" valueType="format" style="width: 100%;" placeholder="Pilih Tanggal" input-class="form-input d-block" class="d-block" @blur="$emit('blur', $event.target.value)" />
    <div v-if="errors.length" class="form-error">{{ errors[0] }}</div>
  </div>
</template>

<script>
import DatePicker from 'vue2-datepicker'
import 'vue2-datepicker/index.css'

export default {
  components:{
    DatePicker,
  },
  inheritAttrs: false,
  props: {
    id: {
      type: String,
      default() {
        return `text-input-${this._uid}`
      },
    },
    type: {
      type: String,
      default: 'text',
    },
    value: String,
    label: String,
    errors: {
      type: Array,
      default: () => [],
    },
  },
  data(){
    return {
      date: this.value,
    }
  },
  methods: {
    focus() {
      this.$refs.input.focus()
    },
    select() {
      this.$refs.input.select()
    },
    setSelectionRange(start, end) {
      this.$refs.input.setSelectionRange(start, end)
    },
  },
}
</script>
