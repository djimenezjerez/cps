<template>
  <v-text-field
    v-model="searchValue"
    label="Buscar"
    prepend-inner-icon="mdi-magnify"
    variant="outlined"
    hide-details
    density="compact"
    clearable
    @update:modelValue="inputUpdated"
    @keyup.enter="(searchValue.length > 0) && emit('input', searchValue)"
    @keyup.esc="clearInput"
  ></v-text-field>
</template>

<script setup>
import { ref, toRefs } from 'vue'
import _ from 'lodash'

const emit = defineEmits(['input'])
const props = defineProps({
  inputLength: {
    type: Number,
    default: 2
  },
})
const { inputLength } = toRefs(props)
const searchValue = ref('')

const inputUpdated = _.debounce(function () {
  if (searchValue.value == null || searchValue.value.length >= inputLength.value || searchValue.value.length == 0) {
    emit('input', searchValue.value)
  }
}, 500)

const clearInput = function () {
  searchValue.value = ''
  emit('input', searchValue.value)
}

</script>
