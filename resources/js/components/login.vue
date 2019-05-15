<template>
  <v-layout>
    <v-flex xs10 sm6 offset-sm3 pt-5 pl-4>
        <v-alert  v-model="error" dismissible type="error" mt-5 >
                Invalid credentials
            </v-alert>
      <v-card class>
        <v-card-title primary-title>

          <div>
            <h3 class="headline">Login</h3>

           </div>

        </v-card-title>
        <v-card-text>
            <v-form @submit.prevent="authenticate" id="login" class="px-3" ref="form">
                <v-text-field v-model="form.email" label="email" prepend-icon="email" :rules="[ v=> !!v || 'Please enter your email address', v => /.+@.+/.test(v) || 'E-mail must be valid'] "  ></v-text-field>
                <v-text-field v-model="form.password" label="password" type="password" prepend-icon="fingerprint" :rules="[ v=> !!v || 'Please enter your password'] "></v-text-field>

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

            error:false
        }

    },
    methods:{
        authenticate(){
             if(this.$refs.form.validate()){
            // //dispatch an action called login, dispatch is async
            this.$store.dispatch('login')
            login(this.$data.form).then((res)=>{
                //change loading state to false and authenticated user

                this.$store.commit('loginSuccess', res)
                this.$router.push({path: '/events'})
            })
            .catch((error)=>{
                this.error = true
                this.$store.commit('loginFailed', {error})
            })
             }

        }
    }
}
</script>

<style scoped>
</style>
