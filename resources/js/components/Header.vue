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
    export default {
        name: 'app-header',
        data(){
            return{
                drawer: false
            }
        },
        methods:{
            logout(){
                this.$store.commit('logout')
                this.$router.push('/')
            },

            showDrawer(){
                this.drawer = true
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
