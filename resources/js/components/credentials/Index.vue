<template>
  <v-container>
    <v-sheet>
      <v-container>
        <div class="text-h6 text-sm-h5 text-md-h4">
          <v-breadcrumbs :items="breadcrumbs">
            <template v-slot:title="{ item }">
              {{ item.text }}
            </template>
          </v-breadcrumbs>
        </div>
        <v-row class="py-4">
          <v-col cols="12" sm="8" md="9" lg="10">
            <search-input :inputLength="2" @input="onSearch"/>
          </v-col>
          <v-col cols="12" sm="4" md="3" lg="2">
            <v-btn color="accent" prepend-icon="mdi-plus" flat block :to="{ name: 'CredentialsForm', params: { id: 0 } }">
              Nuevo
            </v-btn>
          </v-col>
        </v-row>
        <v-table fixed-header hover density="comfortable">
          <thead class="grey--text text--darken-2">
            <tr>
              <th width="5%" class="text-center bg-secondary" style="border: 1px solid white; border-width: 0 1px 0 0;">
                #
              </th>
              <th width="15%" class="text-center bg-secondary" style="border: 1px solid white; border-width: 0 1px 0 0;">
                Código
              </th>
              <th width="20%" class="text-center bg-secondary" style="border: 1px solid white; border-width: 0 1px 0 0;">
                Razón Social
              </th>
              <th width="10%" class="text-center bg-secondary" style="border: 1px solid white; border-width: 0 1px 0 0;">
                Gestión Inicial
              </th>
              <th width="10%" class="text-center bg-secondary" style="border: 1px solid white; border-width: 0 1px 0 0;">
                Gestión Final
              </th>
              <th width="20%" class="text-center bg-secondary" style="border: 1px solid white; border-width: 0 1px 0 0;">
                Contacto
              </th>
              <th width="10%" class="text-center bg-secondary" style="border: 1px solid white; border-width: 0 1px 0 0;">
                Teléfono
              </th>
              <th width="10%" class="text-center bg-secondary" style="min-width: 152px;">
                Acciones
              </th>
            </tr>
          </thead>
          <tbody v-if="options.totalItems > 0">
            <tr v-for="item in items" :key="item.id">
              <td class="text-center">{{ item.id }}</td>
              <td class="text-center">{{ item.code }}</td>
              <td class="text-center">{{ item.business_name }}</td>
              <td class="text-center">{{ item.year_start }}</td>
              <td class="text-center">{{ item.year_end }}</td>
              <td class="text-center">{{ item.contact_name }}</td>
              <td class="text-center">{{ item.contact_phone }}</td>
              <td class="text-center">
                <v-btn
                  @click="yearDialog.onDialog(item.id)"
                  size="x-small"
                  icon="mdi-eye"
                  color="info"
                  class="mx-1"
                ></v-btn>
                <v-btn
                  :to="{ name: 'CredentialsForm', params: { id: item.id } }"
                  size="x-small"
                  icon="mdi-pencil"
                  color="warning"
                  class="mx-1"
                ></v-btn>
                <v-btn
                  @click="onDialog(item.id, item.code)"
                  size="x-small"
                  icon="mdi-delete"
                  color="error"
                  class="mx-1"
                ></v-btn>
              </td>
            </tr>
          </tbody>
          <tbody v-else>
            <tr>
              <td colspan="7" class="text-center">No hay datos para mostrar</td>
            </tr>
          </tbody>
        </v-table>
        <v-row v-if="options.totalItems > 0" class="text-center bg-grey-lighten-5 mt-2" align="center" dense justify="end">
          <v-col cols="12" sm="4" md="2" xl="1" class="d-none d-sm-inline">
            <v-select
              v-model="options.itemsPerPage"
              density="compact"
              label="Filas a mostrar"
              :items="options.itemsPerPageOptions"
              @update:modelValue="getData"
              hide-details
            ></v-select>
          </v-col>
          <v-col cols="12" sm="8" md="5" lg="4" xl="2">
            <v-pagination
              v-model="options.page"
              density="compact"
              :length="options.lastPage"
              :total-visible="5"
              rounded="circle"
              prev-icon="mdi-menu-left"
              next-icon="mdi-menu-right"
            ></v-pagination>
          </v-col>
        </v-row>
      </v-container>
    </v-sheet>
  </v-container>
  <remove-dialog :data="dialog" @removed="getData" />
  <year-dialog ref="yearDialog" />
</template>

<script setup>
import { inject, reactive, ref, onMounted } from 'vue'
import { useAppStore } from '@/store/app'
import { storeToRefs } from 'pinia'
import RemoveDialog from '@/components/shared/RemoveDialog.vue'
import YearDialog from '@/components/credentials/YearDialog.vue'

const axios = inject('axios')
const store = useAppStore()
const { loading } = storeToRefs(store)

const breadcrumbs = [
  {
    text: 'Credenciales',
    to: { name: 'CredentialsIndex' },
    disabled: true,
  },
]
const options = ref({
  page: 1,
  lastPage: 0,
  totalItems: 0,
  itemsPerPage: 8,
  itemsPerPageOptions: [8, 15, 30],
})
const items = ref([])

const yearDialog = ref()

const dialog = reactive({
  id: null,
  url: 'credential',
  title: 'la credencial',
  code: null,
  show: false,
})

const onSearch = function(value) {
  options.value.page = 1
  getData(value)
}

const onDialog = function(id, code) {
  dialog.id = id
  dialog.code = code
  dialog.show = true
}

const getData = async function(search = '') {
  try {
    loading.value = true
    const response = await axios.get('/credential', {
      params: {
        page: options.value.page,
        per_page: options.value.itemsPerPage,
        search: search,
      },
    })
    items.value = response.data.payload.data
    options.value.lastPage = response.data.payload.last_page
    options.value.totalItems = response.data.payload.total
  } catch(error) {
    console.log(error)
  } finally {
    loading.value = false
  }
}

onMounted(() => {
  getData()
})

</script>
