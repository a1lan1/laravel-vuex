import axios from 'axios'

const route = '/users'

export default {
  namespaced: true,
  state: {
    users: [],
    totalRows: 0
  },
  mutations: {
    setUsers (state, users) {
      state.users = users
    },
    setTotalRows (state, totalRows) {
      state.totalRows = totalRows
    }
  },
  actions: {
    getUsers (context) {
      axios
        .get(route)
        .then(response => {
          context.commit('setUsers', response.data)
          context.commit('setTotalRows', response.data.length)
        })
    },
    setTotalRows (context, totalRows) {
      context.commit('setTotalRows', totalRows)
    }
  }
}
