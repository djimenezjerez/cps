import { useLocalStorage } from '@vueuse/core'
import { defineStore } from 'pinia'
import { ref } from 'vue'

export const useAppStore = defineStore('app', () => {
  const loading = ref(false)
  const loggedIn = ref(useLocalStorage('loggedIn', false))
  const acccessToken = ref(useLocalStorage('acccessToken', ''))
  const user = ref(useLocalStorage('user', {
    name: ''
  }))
  const notification = ref('')
  const errorNotification = ref(false)
  const displayNotification = ref(false)

  function login(payload) {
    loggedIn.value = true
    acccessToken.value = payload.access_token
    user.value = payload.user
  }
  function logout() {
    loggedIn.value = false
    acccessToken.value = ''
    user.value = {}
  }
  function alert(message, error = false) {
    notification.value = message
    errorNotification.value = error
    displayNotification.value = true
  }

  return {
    loading,
    loggedIn,
    acccessToken,
    user,
    notification,
    errorNotification,
    displayNotification,
    login,
    logout,
    alert,
  }
})
