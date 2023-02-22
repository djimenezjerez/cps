<template>
  <v-app style="background: linear-gradient(0deg, rgba(34,193,195,1) 0%, rgba(3,119,112,1) 100%);">
    <v-main>
      <v-container fluid>
        <v-row justify="center" align="center">
          <v-col cols="12" sm="8" md="6" lg="4">
            <v-sheet elevation="4" rounded class="py-5 px-sm-8 mt-16">
              <div class="text-center text-h4">Bienvenido</div>
              <v-form @submit.prevent="onSubmit">
                <v-container>
                  <v-row dense>
                    <v-col cols="12">
                      <v-text-field
                        v-model="form.username"
                        label="Usuario"
                        variant="underlined"
                        prepend-inner-icon="mdi-account"
                        :error="errors.username.length > 0"
                        :error-messages="errors.username.length ? errors.username[0] : ''"
                        required
                      ></v-text-field>
                    </v-col>
                    <v-col cols="12">
                      <v-text-field
                        v-model="form.password"
                        label="Contraseña"
                        variant="underlined"
                        type="password"
                        prepend-inner-icon="mdi-lock"
                        :error="errors.password.length > 0"
                        :error-messages="errors.password.length ? errors.password[0] : ''"
                        required
                      ></v-text-field>
                    </v-col>
                    <v-col cols="12">
                      <v-btn
                        type="submit"
                        class="mt-2"
                        color="primary"
                        block
                      >Ingresar</v-btn>
                    </v-col>
                  </v-row>
                </v-container>
              </v-form>
            </v-sheet>
          </v-col>
        </v-row>
      </v-container>
      <v-overlay
        v-model="loading"
        class="align-center justify-center"
        persistent
      >
        <v-progress-circular
          color="primary"
          indeterminate
          size="64"
        ></v-progress-circular>
      </v-overlay>
    </v-main>
  </v-app>
</template>

<script setup>
import { inject } from 'vue'
import { useRouter } from 'vue-router'
import { useAppStore } from '@/store/app'
import { storeToRefs } from 'pinia'
import { ref } from 'vue'

const axios = inject('axios')
const router = useRouter()
const store = useAppStore()
const { loading, acccessToken } = storeToRefs(store)
const { login } = store

const errors = ref({
  username: [],
  password: [],
})
const form = ref({
  username: null,
  password: null,
})

const onSubmit = async function() {
  try {
    loading.value = true
    const response = await axios.post('/auth/login', form.value)
    login(response.data.payload)
    axios.defaults.headers.common['Authorization'] = `Bearer ${acccessToken.value}`
    router.replace({ name: 'CredentialsIndex' })
  } catch(error) {
    form.value.password = null
    Object.keys(error.response.data.errors).forEach((key) => {
      errors.value[key] = error.response.data.errors[key]
    })
  } finally {
    loading.value = false
  }
}
</script>
