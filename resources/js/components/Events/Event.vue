<template>

    <div class="events">
        <div v-if="event.length > 0">
           <h1> Invalid Event </h1>
        </div>

 <v-layout v-else>

        <v-container class="my-2">
            <v-layout row wrap>

                <v-flex xs12 sm12 md12 lg12>



                    <v-card class="text-xs-center">
                        <v-responsive>
                            <v-img :src="event.image" contain> </v-img>
                        </v-responsive>
                        <v-card-text>
                            <div class="my-2"> <h1 class="display-1">{{event.name}} </h1></div>

                            <div class="subheading body-1 my-2"><h2> {{event.date}} </h2></div>
                            <div class="subheading body-1 my-2"> <h2>{{event.description}}</h2> </div>
                            <div class="subheading body-1 my-2"> <h2>{{event.city}}</h2> </div>
                            <div class="subheading body-1 my-2 red--text"> <h2>{{maxTickets}} tickets left</h2> </div>
                             <v-card-actions class="justify-center pb-4">

                                 <div v-if="maxTickets > 0">
                                      <div class="body-1 my-2 green--text"> <h2>Get a ticket?</h2> </div>
                                     <v-text-field md2 xs4 s4 v-model="buy" type = "number" placeholder="Enter number of tickets"> </v-text-field>
                                    <v-btn class="info" @click.prevent='join' md2  v-if="buy <= maxTickets && buy && buy > 0"><v-icon> add </v-icon></v-btn>
                                    <v-btn v-else class="warning">Enter a valid number </v-btn>
                                 </div>
                                <v-btn depressed class="info" v-if="maxTickets == 0">Event is full</v-btn>


                            </v-card-actions>
                            <hr>
                            <h1 class="display-1"> Coordinator </h1>
                        <v-avatar size="150">
                            <v-img :src="event.user.image"> </v-img>
                        </v-avatar>
                            <h1 class="subheading my-2"> {{event.user.name}} </h1>
                        </v-card-text>


                    </v-card>
                </v-flex>
            </v-layout>
        </v-container>
  </v-layout>
    </div>
</template>

<script>
import Axios from "axios";
import { isNull } from 'util';
export default {
    name: 'Event',
    props:{
        event: null
    },
    mounted() {
         this.maxTickets = this.event.maximum - this.event.tickets.length
    },

    data(){
        return{
            image: null,
            maxTickets: null,
            hasLoaded: false,
            buy: null,
        }
    },
    computed:{


    },
    methods:{
        join(){
            Axios.post(`/api/auth/tickets/`,{
                user: this.$store.getters.currentUser.id,
                event: this.event.id,
                count: this.buy
            },{
                headers:{
                'Content-Type': 'application/json',
                'Authorization': 'Bearer '+this.$store.getters.currentUser.token,
                'X-Requested-With' : "XMLHttpRequest"
            },
            })
            .then((response)=>{
                this.$store.commit('getTicket')
                this.$router.push('/tickets')
            })

        }
    }
}
</script>

<style scoped>

</style>
