<template>
  <v-dialog
    v-model="show"
    persistent
    width="300px"
  >
    <v-card>
      <v-card-title class="text-h6 bg-primary">
        Gestiones
      </v-card-title>
      <v-card-text class="pa-0">
        <v-list class="text-center">
          <template v-for="year in years" :key="year.id">
            <v-list-item
              :title="year.name"
              @click="onSelect(year.id)"
            ></v-list-item>
            <v-divider color="black" thickness="2"></v-divider>
          </template>
        </v-list>
      </v-card-text>
      <v-card-actions>
        <v-spacer></v-spacer>
        <v-btn
          color="error"
          variant="flat"
          @click="show = false"
        >
          CERRAR
        </v-btn>
      </v-card-actions>
    </v-card>
  </v-dialog>
</template>

<script setup>
import { inject, ref } from 'vue'
import { useRoute, useRouter } from 'vue-router'
import { useAppStore } from '@/store/app'
import { storeToRefs } from 'pinia'

const axios = inject('axios')
const route = useRoute()
const router = useRouter()
const store = useAppStore()
const { loading } = storeToRefs(store)
const { alert } = store

const show = ref(false)
const years = ref([])

const onSelect = function(id) {
  console.log(id);
}

const onDialog = function(id) {
  show.value = true
  getData(id)
}

const getData = async function(id) {
  try {
    loading.value = true
    const response = await axios.get('/year', {
      params: {
        credential_id: id,
      },
    })
    years.value = response.data.payload
  } catch(error) {
    alert(error.response.data.message, true)
  } finally {
    loading.value = false
  }
}

defineExpose({
  onDialog,
})

</script>
