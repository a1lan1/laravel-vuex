import axios from 'axios'

export default {
    namespaced: true,
    state: {
        route: '',
        users: {}
    },
    mutations: {
        setRoute(state, route) {
            state.route = route
        },
        setUsers(state, users) {
            state.users = users
        }
    },
    actions: {
        setRoute(context, route) {
            context.commit('setRoute', route)
        },
        getUsers(context, data) {
            axios
                .get(context.state.route)
                .then(response => {
                    context.commit('setUsers', response.data)
                })
        }
    }
}
