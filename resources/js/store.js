import { getLocalUser } from "./helpers/auth.js";
import Axios from 'axios'
const user = getLocalUser()

export default{
    state: {
       welcomeMessage:"wow",
       currentUser: user,
       isLoggedIn: !!user, //double because bool
       loading: false,
       auth_error: null,
    },
    getters: {
        welcome(state){
            return state.welcomeMessage
        },
        isLoading(state){
            return state.loading
        },
        isLoggedin(state){
            return state.isLoggedIn
        },
        currentUser(state){
            return state.currentUser
        },
        authError(state){
            return state.auth_error
        },
    },
    mutations: {
        //anytime a commit happens, trigger mutation in store
        login(state){
            // console.log('login')
            state.loading = true,
            state.authError = null
        },
        loginSuccess(state, payload){
            // console.log('success')
            state.authError = null,
            state.isLoggedIn = true,
            state.loading = false,
            state.currentUser = Object.assign({}, payload.user, {token:payload.access_token})
            localStorage.setItem('user', JSON.stringify(state.currentUser))
        },
        loginFailed(state,payload){
            state.loading = false,
            state.auth_error = payload.error
        },
        logout(state){
            localStorage.removeItem('user'),
            state.isLoggedIn = false,
            state.currentUser = null
        },
        getTicket(){
            // console.log(this.getters.currentUser.id)
            Axios.post(`/api/auth/refreshUser/`,{
                id: this.getters.currentUser.id,
            }).then((response)=>{
                // console.log(response.data)
                this.getters.currentUser.tickets = response.data.tickets
                this.getters.currentUser.events = response.data.events
                // console.log(this.getters.currentUser)
            })
        }



    },
    actions: {
        login(context){
            context.commit('login')
        },
        getTicket(context){
            // context.commit('getTicket')
        }
    }
}
