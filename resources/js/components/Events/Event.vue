<template>

    <div class="events">
        <div v-if="event.length < 1">
           <h1> Invalid Event </h1>
        </div>
        <!-- <div  v-else class="row justify-content-center" >
            <div class="jumbotron header col-md-10 mt-2" :style="{ backgroundImage: 'url(' + image + ')' }">

            </div>

            <div class="jumbotron col-md-10">
                    <h1 class="display-4">{{event.name}}</h1>
                    <p class="lead">{{event.description}}</p>
                    <p class="lead">{{event.date}}</p>
                    <p class="lead">{{event.city}}</p>
                    <p class="lead">{{event.maximum - event.tickets.length}} tickets left</p>
                    <a v-if="!this.hasJoined && event.maximum-event.tickets.length > 0 @click.prevent='join' role="button">Join</a>
                    <a v-else-if="this.hasJoined" class="btn btn-info btn-lg"> You've already joined this event! </a>

                    <a v-if="event.maximum-event.tickets.length == 0" class="btn btn-info btn-lg" @click.prevent='join' role="button">Event Full</a>
                    <br>
                    <router-link  to="/events" class="btn btn-default mt-3"> Back to events </router-link>

                    <hr class="my-4">
                    <h1> Organizer </h1>
                    <div class="circle type1"></div>

                    <h4>{{event.user.name}} </h4>
                    <h5>{{event.user.email}} </h5>

            </div>
        </div>

-->
 <v-layout>
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
                            <div class="subheading body-1 my-2"> <h2>{{event.maximum - event.tickets.length}} tickets left</h2> </div>
                             <v-card-actions class="justify-center pb-4">
                                 <v-btn depressed :to="`/events`"> Back to Events </v-btn>
                                <v-btn class="info" v-if="!this.hasJoined && event.maximum-event.tickets.length > 0" @click.prevent='join'>Join Event</v-btn>
                                <v-btn depressed class="info" v-else-if="this.hasJoined">You've already joined this event!</v-btn>
                                <v-btn depressed class="info"    v-if="event.maximum-event.tickets.length == 0">Event is full</v-btn>


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
export default {
    name: 'event',
    mounted() {
        Axios.get(`/api/auth/events/${this.$route.params.id}`)
            .then((response)=>{
                this.event = response.data
                this.image = response.data.image


            })
            //check if user has joined this event
            Axios.get(`/api/auth/checkTicket`,{
                params:{
                    user: this.$store.getters.currentUser.id,
                    event: this.$route.params.id
                }
            }).then((response)=>{
                if(response.data.hasJoined === true){
                    this.hasJoined = true
                }else{
                    this.hasJoined = false
                }
            })



    },

    data(){
        return{
            event: {},
            search: null,
            image: null,
            hasJoined: false
        }
    },
    computed:{


    },
    methods:{
        join(){
            Axios.post(`/api/auth/tickets/`,{
                user: this.$store.getters.currentUser.id,
                event: this.event.id
            })
            .then((response)=>{
                this.$store.commit('getTicket')
                this.$router.push('/events')
            })
        }
    }
}
</script>

<style scoped>

</style>
