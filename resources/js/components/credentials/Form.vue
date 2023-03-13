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
        <v-form @submit.prevent="onSubmit">
          <v-row class="py-4">
            <v-col cols="12" md="6">
              <v-card
                variant="outlined"
              >
                <v-card-title>
                  Datos de la Credencial
                </v-card-title>
                <v-card-text>
                  <v-row>
                    <v-col cols="12" class="pb-0">
                      <v-text-field
                        density="compact"
                        v-model="form.code"
                        label="Código"
                        variant="outlined"
                        prepend-inner-icon="mdi-barcode-scan"
                        :error="errors.code.length > 0"
                        :error-messages="errors.code.length ? errors.code[0] : ''"
                        required
                      ></v-text-field>
                    </v-col>
                    <v-col cols="12" sm="6" class="pb-0">
                      <v-text-field
                        density="compact"
                        v-model="form.year_start"
                        label="Gestión Inicial"
                        variant="outlined"
                        prepend-inner-icon="mdi-calendar-range"
                        :error="errors.year_start.length > 0"
                        :error-messages="errors.year_start.length ? errors.year_start[0] : ''"
                        required
                        type="number"
                        min="2000"
                        max="2030"
                      ></v-text-field>
                    </v-col>
                    <v-col cols="12" sm="6" class="pb-0">
                      <v-text-field
                        density="compact"
                        v-model="form.year_end"
                        label="Gestión Final"
                        variant="outlined"
                        prepend-inner-icon="mdi-calendar-range"
                        :error="errors.year_end.length > 0"
                        :error-messages="errors.year_end.length ? errors.year_end[0] : ''"
                        required
                        type="number"
                        min="2000"
                        max="2030"
                      ></v-text-field>
                    </v-col>
                    <v-col cols="12" class="pb-0">
                      <v-text-field
                        density="compact"
                        label="Asignación"
                        variant="outlined"
                        prepend-inner-icon="mdi-account-check"
                        v-model="user.name"
                        readonly
                      ></v-text-field>
                    </v-col>
                  </v-row>
                </v-card-text>
              </v-card>
            </v-col>
            <v-col cols="12" md="6">
              <v-card
                variant="outlined"
              >
                <v-card-title>
                  Datos de la Empresa
                </v-card-title>
                <v-card-text>
                  <v-row>
                    <v-col cols="12" class="pb-0">
                      <v-text-field
                        density="compact"
                        v-model="form.business_name"
                        label="Razón Social"
                        variant="outlined"
                        prepend-inner-icon="mdi-store"
                        :error="errors.business_name.length > 0"
                        :error-messages="errors.business_name.length ? errors.business_name[0] : ''"
                        required
                      ></v-text-field>
                    </v-col>
                    <v-col cols="12" class="pb-0">
                      <v-text-field
                        density="compact"
                        v-model="form.address"
                        label="Dirección"
                        variant="outlined"
                        prepend-inner-icon="mdi-map-marker"
                        :error="errors.address.length > 0"
                        :error-messages="errors.address.length ? errors.address[0] : ''"
                      ></v-text-field>
                    </v-col>
                    <v-col cols="12" sm="6" class="pb-0">
                      <v-text-field
                        density="compact"
                        v-model="form.nit"
                        label="NIT"
                        variant="outlined"
                        prepend-inner-icon="mdi-counter"
                        :error="errors.nit.length > 0"
                        :error-messages="errors.nit.length ? errors.nit[0] : ''"
                        type="number"
                        min="0"
                      ></v-text-field>
                    </v-col>
                    <v-col cols="12" sm="6" class="pb-0">
                      <v-text-field
                        density="compact"
                        v-model="form.business_code"
                        label="SEPREC"
                        variant="outlined"
                        prepend-inner-icon="mdi-qrcode"
                        :error="errors.business_code.length > 0"
                        :error-messages="errors.business_code.length ? errors.business_code[0] : ''"
                      ></v-text-field>
                    </v-col>
                  </v-row>
                </v-card-text>
              </v-card>
            </v-col>
            <v-col cols="12" md="6">
              <v-card
                variant="outlined"
              >
                <v-card-title>
                  Datos del Representante Legal
                </v-card-title>
                <v-card-text>
                  <v-row>
                    <v-col cols="12" lg="7" class="pb-0">
                      <v-text-field
                        density="compact"
                        v-model="form.ceo_name"
                        label="Nombre"
                        variant="outlined"
                        prepend-inner-icon="mdi-account"
                        :error="errors.ceo_name.length > 0"
                        :error-messages="errors.ceo_name.length ? errors.ceo_name[0] : ''"
                        required
                      ></v-text-field>
                    </v-col>
                    <v-col cols="12" lg="5" class="pb-0">
                      <v-text-field
                        density="compact"
                        v-model="form.ceo_phone"
                        label="Teléfono"
                        variant="outlined"
                        prepend-inner-icon="mdi-phone"
                        :error="errors.ceo_phone.length > 0"
                        :error-messages="errors.ceo_phone.length ? errors.ceo_phone[0] : ''"
                        type="number"
                      ></v-text-field>
                    </v-col>
                    <v-col cols="12" xl="5" class="pb-0">
                      <v-text-field
                        density="compact"
                        v-model="form.ceo_ci"
                        label="Cédula de Identidad"
                        variant="outlined"
                        prepend-inner-icon="mdi-card-account-details"
                        :error="errors.ceo_ci.length > 0"
                        :error-messages="errors.ceo_ci.length ? errors.ceo_ci[0] : ''"
                        required
                        type="number"
                        min="0"
                      ></v-text-field>
                    </v-col>
                    <v-col cols="12" sm="6" xl="3" class="pb-0">
                      <v-text-field
                        density="compact"
                        v-model="form.ceo_ci_complement"
                        label="Complemento"
                        variant="outlined"
                        prepend-inner-icon="mdi-card-bulleted"
                        :error="errors.ceo_ci_complement.length > 0"
                        :error-messages="errors.ceo_ci_complement.length ? errors.ceo_ci_complement[0] : ''"
                      ></v-text-field>
                    </v-col>
                    <v-col cols="12" sm="6" xl="4" class="pb-0">
                      <v-select
                        density="compact"
                        :items="cities"
                        v-model="form.ceo_city_id"
                        item-title="code"
                        item-value="id"
                        label="Expedición"
                        variant="outlined"
                        prepend-inner-icon="mdi-map-marker-outline"
                        :error="errors.ceo_city_id.length > 0"
                        :error-messages="errors.ceo_city_id.length ? errors.ceo_city_id[0] : ''"
                      ></v-select>
                    </v-col>
                  </v-row>
                </v-card-text>
              </v-card>
            </v-col>
            <v-col cols="12" md="6">
              <v-card
                variant="outlined"
              >
                <v-card-title>
                  Datos del Contacto
                </v-card-title>
                <v-card-text>
                  <v-row>
                    <v-col cols="12" lg="7" class="pb-0">
                      <v-text-field
                        density="compact"
                        v-model="form.contact_name"
                        label="Nombre"
                        variant="outlined"
                        prepend-inner-icon="mdi-account"
                        :error="errors.contact_name.length > 0"
                        :error-messages="errors.contact_name.length ? errors.contact_name[0] : ''"
                        required
                      ></v-text-field>
                    </v-col>
                    <v-col cols="12" lg="5" class="pb-0">
                      <v-text-field
                        density="compact"
                        v-model="form.contact_phone"
                        label="Teléfono"
                        variant="outlined"
                        prepend-inner-icon="mdi-phone"
                        :error="errors.contact_phone.length > 0"
                        :error-messages="errors.contact_phone.length ? errors.contact_phone[0] : ''"
                        type="number"
                      ></v-text-field>
                    </v-col>
                    <v-col cols="12" xl="5" class="pb-0">
                      <v-text-field
                        density="compact"
                        v-model="form.contact_ci"
                        label="Cédula de Identidad"
                        variant="outlined"
                        prepend-inner-icon="mdi-card-account-details"
                        :error="errors.contact_ci.length > 0"
                        :error-messages="errors.contact_ci.length ? errors.contact_ci[0] : ''"
                        required
                        type="number"
                        min="0"
                      ></v-text-field>
                    </v-col>
                    <v-col cols="12" sm="6" xl="3" class="pb-0">
                      <v-text-field
                        density="compact"
                        v-model="form.contact_ci_complement"
                        label="Complemento"
                        variant="outlined"
                        prepend-inner-icon="mdi-card-bulleted"
                        :error="errors.contact_ci_complement.length > 0"
                        :error-messages="errors.contact_ci_complement.length ? errors.contact_ci_complement[0] : ''"
                      ></v-text-field>
                    </v-col>
                    <v-col cols="12" sm="6" xl="4" class="pb-0">
                      <v-select
                        density="compact"
                        :items="cities"
                        v-model="form.contact_city_id"
                        item-title="code"
                        item-value="id"
                        label="Expedición"
                        variant="outlined"
                        prepend-inner-icon="mdi-map-marker-outline"
                        :error="errors.contact_city_id.length > 0"
                        :error-messages="errors.contact_city_id.length ? errors.contact_city_id[0] : ''"
                      ></v-select>
                    </v-col>
                  </v-row>
                </v-card-text>
              </v-card>
            </v-col>
            <v-col cols="12" md="6" offset-md="6" lg="4" offset-lg="8" xl="3" offset-xl="9">
              <v-btn
                type="submit"
                class="mt-2"
                color="primary"
                prepend-icon="mdi-check-bold"
                block
              >Guardar</v-btn>
            </v-col>
          </v-row>
        </v-form>
      </v-container>
    </v-sheet>
  </v-container>
</template>

<script setup>
import { inject, ref, onMounted } from 'vue'
import { useRoute, useRouter } from 'vue-router'
import { useAppStore } from '@/store/app'
import { storeToRefs } from 'pinia'

const axios = inject('axios')
const route = useRoute()
const router = useRouter()
const store = useAppStore()
const { alert } = store
const { loading, user } = storeToRefs(store)

const breadcrumbs = [
  {
    text: 'Credenciales',
    to: { name: 'CredentialsIndex' },
    disabled: false,
  }, {
    text: route.params.id > 0 ? 'Editar' : 'Nueva',
    to: { name: 'CredentialsForm', params: { id: route.params.id } },
    disabled: true,
  },
]

const cities = ref([])

const errors = ref({
  code: [],
  business_name: [],
  year_start: [],
  year_end: [],
  nit: [],
  business_code: [],
  address: [],
  ceo_name: [],
  ceo_phone: [],
  ceo_ci: [],
  ceo_ci_complement: [],
  ceo_city_id: [],
  contact_name: [],
  contact_phone: [],
  contact_ci: [],
  contact_ci_complement: [],
  contact_city_id: [],
})
const form = ref({
  id: null,
  code: null,
  business_name: null,
  year_start: null,
  year_end: null,
  nit: null,
  business_code: null,
  address: null,
  ceo_name: null,
  ceo_phone: null,
  ceo_ci: null,
  ceo_ci_complement: null,
  ceo_city_id: null,
  contact_name: null,
  contact_phone: null,
  contact_ci: null,
  contact_ci_complement: null,
  contact_city_id: null,
})

const onSubmit = async function() {
  try {
    loading.value = true
    Object.keys(errors.value).forEach((key) => {
      errors.value[key] = []
    })
    let response
    if (form.value.id > 0) {
      response = await axios.patch(`/credential/${form.value.id}`, form.value)
    } else {
      response = await axios.post('/credential', form.value)
    }
    alert(response.data.message)
    router.push({ name: 'CredentialsIndex' })
  } catch(error) {
    alert(error.response.data.message, true)
    Object.keys(error.response.data.errors).forEach((key) => {
      errors.value[key] = error.response.data.errors[key]
    })
  } finally {
    loading.value = false
  }
}

const getCities = async function() {
  try {
    loading.value = true
    const response = await axios.get('/city')
    cities.value = response.data.payload
  } catch(error) {
    console.log(error)
  } finally {
    loading.value = false
  }
}

const getData = async function() {
  try {
    loading.value = true
    const response = await axios.get(`/credential/${route.params.id}`)
    form.value = response.data.payload
  } catch(error) {
    console.log(error)
  } finally {
    loading.value = false
  }
}

onMounted(() => {
  getCities()
  if (parseInt(route.params.id) > 0) {
    getData()
  } else {
    form.value.id = null
  }
})

</script>
