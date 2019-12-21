import 'babel-polyfill'
import Vue from 'vue'
import App from './App.vue'
import Vuetify from 'vuetify'
import axios from 'axios'
import VueAxios from 'vue-axios'
import Vuelidate from 'vuelidate'
import VueSweetalert2 from 'vue-sweetalert2'
import 'vuetify/dist/vuetify.min.css'
import Storage from 'vue-ls'

// LightBootstrap plugin
import LightBootstrap from './light-bootstrap-main'
// router setup
import Routes from './routes/routes'
// filtros
import Filtros from './filters'
// plugin setup

Vue.use(LightBootstrap)
Vue.use(Vuetify)
Vue.use(VueAxios, axios)
Vue.use(Vuelidate)
Vue.use(VueSweetalert2)
Vue.use(Filtros)
Vue.use(Storage)

axios.defaults.baseURL = 'http://127.0.0.1:8001/api'

/* eslint-disable no-new */
new Vue({
  el: '#app',
  render: h => h(App),
  router: Routes
})
