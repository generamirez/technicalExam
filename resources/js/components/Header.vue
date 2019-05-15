<template>
<nav class="mb-5">
      <v-toolbar app>
        <v-toolbar-side-icon class="hidden-md-and-up" @click="showDrawer" v-if="this.$store.getters.currentUser"></v-toolbar-side-icon>
        <v-toolbar-title v-if="this.$store.getters.currentUser">{{this.$store.getters.currentUser.name}}</v-toolbar-title>
        <v-toolbar-title v-else>Welcome</v-toolbar-title>
        <v-spacer></v-spacer>
        <v-toolbar-items class="hidden-sm-and-down" v-if="this.$store.getters.currentUser">
            <v-btn flat to="/events">Events</v-btn>
            <v-btn flat to="/tickets">Tickets</v-btn>
            <v-btn flat @click.prevent="logout">Logout</v-btn>
        </v-toolbar-items>
         <v-toolbar-items class="hidden-sm-and-down" v-else>
            <v-dialog max-width="600px" v-model="registerForm">
                            <template v-slot:activator="{ on }">
                                <v-btn v-on="on"> Register </v-btn>
                            </template>
                        <v-card>
                        <v-layout >
                        <v-container >
                                    <v-alert  v-model="error" dismissible type="error" mt-5 >
                                        Email is already in use
                                    </v-alert>
                                <v-flex xs12 sm12 md12 lg12>
                                    <v-card class="text-xs-center">

                                        <v-card-title primary-title>
                                        <div>
                                            <h3 class="headline">Register</h3>
                                        </div>

                                    </v-card-title>
                                        <v-flex>
                                        <v-form @submit.prevent = "register" ref="form">

                                            <v-text-field v-model="form.name" label="Name" :rules="[v => !!v || 'Please enter your name']"  prepend-icon="label_important" ></v-text-field>

                                              <v-text-field v-model="form.email" label="email" prepend-icon="email" :rules="[ v => !!v || 'E-mail is required', v => /.+@.+/.test(v) || 'E-mail must be valid']"  ></v-text-field>
                                              <v-text-field v-model="form.password" label="password" type="password" prepend-icon="fingerprint" :rules="[v => !!v || 'Please enter a password']" ></v-text-field>
                                            <v-btn type="submit" color="info" @click="createNew=false">Register</v-btn>
                                        </v-form>
                                        </v-flex>

                                    </v-card>
                                </v-flex>
                        </v-container>
                        </v-layout>
                        </v-card>
                        </v-dialog>
        </v-toolbar-items>


  </v-toolbar>
   <v-navigation-drawer v-model="drawer" app-class="blue" temporary app>

            <v-list>
                 <v-list-tile router :to="`/events`">
                     <v-list-tile-content>
                         <v-list-tile-title>
                            Events
                         </v-list-tile-title>
                     </v-list-tile-content>
                </v-list-tile>

                <v-list-tile router :to="`/tickets`">
                     <v-list-tile-content>
                         <v-list-tile-title>
                            Tickets
                         </v-list-tile-title>
                     </v-list-tile-content>
                </v-list-tile>

                <v-list-tile @click="logout">
                     <v-list-tile-content>
                         <v-list-tile-title>
                            Logout
                         </v-list-tile-title>
                     </v-list-tile-content>
                </v-list-tile>
            </v-list>
       </v-navigation-drawer>
</nav>
</template>

<script>
import Axios from "axios";
    export default {

        name: 'app-header',
        data(){
            return{
                drawer: false,
                form:{
                name: '',
                email: '',
                password: '',
                },
                registerForm: false,
                error: false
            }
        },
        methods:{
            logout(){
                this.$store.commit('logout')
                this.$router.push('/')
            },

            showDrawer(){
                this.drawer = true
            },

            register(){
                   if(this.$refs.form.validate()){
                     Axios.post(`/api/auth/users/`,{
                        name: this.$data.form.name,
                        email: this.$data.form.email,
                        password: this.$data.form.password
                    }).then((response)=>{
                        if(response.data.code == 422){
                           this.error=true
                        }
                        else{
                            this.$data.form.email = "",
                            this.$data.form.name = "",
                            this.$data.form.password = ""
                            this.registerForm = false
                        }
                    })
                   }

            }
         },
         computed:{
             currentUser(){
                 return this.$store.getters.currentUser
             }
         }
    }

</script>
<style scoped>
    .navbar{
        background-color: #FAB259;
    }
</style>
