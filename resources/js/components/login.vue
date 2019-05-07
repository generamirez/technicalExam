<template>
  <v-layout>
    <v-flex xs10 sm6 offset-sm3 pt-5 pl-4>
      <v-card class>
        <v-card-title primary-title>
          <div>
            <h3 class="headline">Login</h3>
           </div>
        </v-card-title>
        <v-card-text>
            <v-form @submit.prevent="authenticate" id="login" class="px-3">
                <v-text-field v-model="form.email" label="email" prepend-icon="email" required  ></v-text-field>
                <v-text-field v-model="form.password" label="password" type="password"></v-text-field>

                <v-btn type="submit success">Login</v-btn>

            </v-form>
        </v-card-text>
      </v-card>
    </v-flex>
  </v-layout>
</template>

<script>
import {login} from '../helpers/auth.js'
export default {

    name: "login",
    data(){
        return{
            form:{
                email:"",
                password:""
            },

            error: null
        }

    },
    methods:{
        authenticate(){
            // //be in loading state
            // //dispatch an action called login, dispatch is async
            this.$store.dispatch('login')
            console.log(this.$data.form)
            login(this.$data.form).then((res)=>{
                console.log("res")
                //change loading state to false and authenticated user
                this.$store.commit('loginSuccess', res)
                this.$router.push({path: '/events'})
            })
            .catch((error)=>{
                this.$store.commit('loginFailed', error)
            })
        },
        click(){
            console.log(this.email)
        }
    }
}
</script>

<style scoped>
</style>
