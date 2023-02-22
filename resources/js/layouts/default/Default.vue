<template>
  <v-app>
    <app-bar/>
    <v-navigation-drawer
      color="secondary"
      expand-on-hover
      rail
      permanent
      absolute
    >
      <v-img
        contain
        height="50"
        src="@/assets/logo.png"
        class="my-3"
      />
      <v-divider theme="dark" style="border-color: white;" thickness="2"></v-divider>
      <v-list density="compact" nav>
        <v-list-item prepend-icon="mdi-card-account-details" title="Credenciales" :to="{ name: 'CredentialsIndex' }"></v-list-item>
        <v-list-item prepend-icon="mdi-account" title="Perfil"></v-list-item>
        <v-list-item prepend-icon="mdi-power" title="Salir" @click="onSubmit"></v-list-item>
      </v-list>
    </v-navigation-drawer>
    <v-main>
      <router-view />
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
      <v-snackbar
        v-model="displayNotification"
        :color="errorNotification ? 'error' : 'blue-grey'"
        location="bottom"
        timeout="4000"
        rounded="pill"
      >
        {{ notification }}

        <template v-slot:actions>
          <v-btn
            color="orange-lighten-1"
            variant="plain"
            @click="displayNotification = false"
          >
            <v-icon>mdi-close</v-icon>
          </v-btn>
        </template>
      </v-snackbar>
    </v-main>
  </v-app>
</template>

<script setup>
import AppBar from './AppBar.vue'

import { inject } from 'vue'
import { useRouter } from 'vue-router'
import { useAppStore } from '@/store/app'
import { storeToRefs } from 'pinia'

const axios = inject('axios')
const router = useRouter()
const store = useAppStore()
const { loading, notification, errorNotification, displayNotification } = storeToRefs(store)
const { logout } = store

const onSubmit = async function() {
  try {
    loading.value = true
    await axios.post('/auth/logout')
    logout()
    router.replace({ name: 'Root' })
  } catch(error) {
    console.log(error)
  } finally {
    loading.value = false
  }
}
</script>
