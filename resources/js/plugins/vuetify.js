/**
 * plugins/vuetify.js
 *
 * Framework documentation: https://vuetifyjs.com`
 */

// Styles
import '@mdi/font/css/materialdesignicons.css'
import 'vuetify/styles'
import { es, en } from 'vuetify/locale'


// Composables
import { createVuetify } from 'vuetify'

// https://vuetifyjs.com/en/introduction/why-vuetify/#feature-guides
export default createVuetify({
  locale: {
    locale: 'es',
    fallback: 'en',
    messages: { es, en }
  },
  theme: {
    themes: {
      light: {
        colors: {
          primary: '#43796C',
          secondary: '#185143',
          accent: '#31a19e',
          background: '#EFEFEF',
        },
      },
    },
  },
})
