import Vue from 'vue'
import { createStore } from './store'
import axios from 'axios'
import VueAxios from 'vue-axios'

import BootstrapVue from 'bootstrap-vue'

import UsersList from './components/UsersList'

Vue.use(VueAxios, axios)
Vue.use(BootstrapVue)
Vue.use(UsersList)

const store = createStore()

const config = {
  store,
  components: {
    UsersList
  }
}

// const files = require.context('./', true, /\.vue$/i)
// files.keys().map(key => Vue.component(key.split('/').pop().split('.')[0], files(key).default))

const app = new Vue(config)
app.$mount('#app')
