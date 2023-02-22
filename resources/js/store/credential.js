import { defineStore } from 'pinia'
import { ref } from 'vue'

export const useCredentialStore = defineStore('credential', () => {
  const year = ref()
  const credential = ref()
  const business = ref()

  return {
    year,
    credential,
    business,
  }
})
