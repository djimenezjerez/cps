// Components
import App from './App.vue'

// Composables
import { createApp } from 'vue'

// Plugins
import { registerPlugins } from '@/plugins'
const app = createApp(App)
registerPlugins(app)
import SearchInput from '@/components/shared/SearchInput.vue';
app.component('SearchInput', SearchInput)

// Store
import { useAppStore } from '@/store/app'
import { storeToRefs } from 'pinia'
const store = useAppStore()
const { loggedIn, acccessToken } = storeToRefs(store)

// Axios
import axios from 'axios'
import VueAxios from 'vue-axios'
axios.defaults.withCredentials = true
axios.defaults.baseURL = `${import.meta.env.VITE_APP_URL}/api/`
axios.defaults.timeout = 10000
axios.defaults.headers.common['Authorization'] = `Bearer ${acccessToken.value}`
axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest'
axios.defaults.headers.common['Access-Control-Allow-Origin'] = '*'
axios.defaults.headers.common['Accept'] = 'application/json'
axios.defaults.headers.common['Content-Type'] = 'application/json'
app.use(VueAxios, axios)
app.provide('axios', app.config.globalProperties.axios)

// Router
import router from './router'
router.beforeEach((to, from, next) => {
  if (!loggedIn.value) {
    if (to.path != '/') {
      next({ name: 'Root' })
    } else {
      next()
    }
  } else {
    if (to.path == '/') {
      next({ name: 'CredentialsIndex' })
    } else {
      next()
    }
  }
})

app.mount('#app')
