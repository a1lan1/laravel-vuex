import Vue from 'vue'
import Vuex from 'vuex'
import users from './modules/users'

Vue.use(Vuex)

export function createStore () {
  return new Vuex.Store({
    modules: {
      users
    }
  })
}
