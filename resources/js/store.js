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
            state.loading = true,
            state.authError = null
        },
        loginSuccess(state, payload){
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
            var headers = {
                'Content-Type': 'application/json',
                'Authorization': 'Bearer '+this.getters.currentUser.token,
                'X-Requested-With' : "XMLHttpRequest"
            }

            Axios.post(`/api/auth/logout/`,{},{
               headers: headers
            })
            .then((response)=>{
                    localStorage.removeItem('user'),
                    state.isLoggedIn = false,
                    state.currentUser = null

                    return true;
            }).catch((e)=>{
                console.log(e)
            })

        },
        getTicket(){
            Axios.post(`/api/auth/refreshUser/`,{
                id: this.getters.currentUser.id,
            },{
                headers:{
                'Content-Type': 'application/json',
                'Authorization': 'Bearer '+this.getters.currentUser.token,
                'X-Requested-With' : "XMLHttpRequest"
                }
            }).then((response)=>{

                this.getters.currentUser.tickets = response.data.tickets
                this.getters.currentUser.events = response.data.events

            })
        }



    },
    actions: {
        login(context){
            context.commit('login')
            this.state.auth_error = null
        },

    }
}
