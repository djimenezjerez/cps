<template>
  <v-dialog
    v-model="data.show"
    persistent
    width="auto"
  >
    <v-card>
      <v-card-title class="text-h6 bg-primary">
        ¿Seguro que desea eliminar el regitro?
      </v-card-title>
      <v-card-text>
        Confirme para elminar {{ data.title }} {{ data.code }}
      </v-card-text>
      <v-card-actions>
        <v-spacer></v-spacer>
        <v-btn
          color="success"
          variant="flat"
          @click="onSubmit"
        >
          SI
        </v-btn>
        <v-btn
          color="error"
          variant="flat"
          @click="data.show = false"
        >
          NO
        </v-btn>
      </v-card-actions>
    </v-card>
  </v-dialog>
</template>

<script setup>
import { inject, toRefs } from 'vue'
import { useAppStore } from '@/store/app'
import { storeToRefs } from 'pinia'

const axios = inject('axios')
const store = useAppStore()
const { loading } = storeToRefs(store)
const { alert } = store

const emit = defineEmits(['removed'])
const props = defineProps({
  data: {
    type: Object,
    default: {
      id: null,
      url: null,
      title: null,
      code: null,
      show: false,
    },
  },
})
const { data } = toRefs(props)

const onSubmit = async function() {
  try {
    loading.value = true
    const response = await axios.delete(`/${data.value.url}/${data.value.id}`)
    alert(response.data.message)
    data.value.show = false
    emit('removed')
  } catch(error) {
    alert(error.response.data.message, true)
  } finally {
    loading.value = false
  }
}

</script>
