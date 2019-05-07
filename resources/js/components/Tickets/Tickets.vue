<template>
    <div class="tickets">
        <div v-if="!tickets.length" class="body">
               <h1 class="error"> You currently have no tickets </h1>
        </div>

        <div v-else class="body">
            <!-- <table class="table table-primary">
                <thead>
                    <tr>
                    <th scope="col">Ticket No.</th>
                    <th scope="col">Event Name</th>
                    <th scope="col">Coordinator Email</th>
                    <th scope="col">Handle</th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="ticket in tickets" :key="ticket.id">
                        <th scope="row">{{ticket.id}}</th>
                        <td>{{ticket.event.name}}</td>
                        <td>{{ticket.event.user.email}}</td>

                        <td>
                        <a class="btn btn-danger btn-md" @click.prevent='remove(ticket.id)' role="button">Delete</a>
                        <router-link :to="`/events/${ticket.event.id}`" class="btn btn-primary"> View Event
                        </router-link></td>

                    </tr>
                </tbody>
            </table> -->
             <v-data-table :headers="headers" :items="tickets" class="elevation-1 mt-4" xs12 s12 md12 xl12>
                 <template v-slot:items="props">
                    <td>{{ props.item.id }}</td>
                    <td class="text-xs-left">{{ props.item.event.name }}</td>
                    <td class="text-xs-left">{{ props.item.event.user.email }}</td>
                    <td class="text-xs-left">
                        <v-btn class="info" :to="`/events/${props.item.id}`">Show Event</v-btn>
                        <v-btn class="danger" @click.prevent="remove(`${props.item.id}`)">Delete</v-btn>
                    </td>
                </template>
             </v-data-table>
        </div>
    </div>
</template>

<script>
import Axios from "axios";
export default {
    name: 'tickets',

    mounted() {
        Axios.get('/api/auth/myTickets',{
            params:{
                id: this.$store.getters.currentUser.id
            }
        })
            .then((response)=>{
                // console.log(response.data)
           this.tickets = response.data
         })
        //  console.log(this.tickets)

    },

    data(){
        return{
           tickets: [],

            headers: [ {
            text: 'Ticket ID',
            align: 'left',
            value: 'id'
             },
                { text: 'Event Name', value: 'event.name' },
                { text: 'Coordinator Email', value: 'event.user.email' },
                { text: 'Actions', value: 'actions', sortable:false },
             ],
             tickets:[]
        }

    },
    computed:{

    },
    methods:{
        remove(id){
           Axios.delete(`api/auth/tickets/${id}`).then((res)=>{
                Axios.get('/api/auth/myTickets',{
                params:{
                    id: this.$store.getters.currentUser.id
                    }
                 }) .then((response)=>{
                     this.tickets = response.data
                     })
                }).catch(error => {
                console.log(error.message)
                })
        },
    }
}
</script>

<style scoped>
    .search{
        margin: 3%;
        margin-left:78em;
        border-radius:25px;
    }

    .card{
        background-color: #EFF4c8;
    }
    .card-title{
        color:#7dae8d;
    }

    .card-text{
        color:#7dae8d;
    }

    .card-subtitle{
        color: #AD423c;
    }

    .tickets{
        height:200vh;
    }

    .tickets{
        height:200vh;
        text-align:center;
    }

    .body{
        display: inline;
    }

    .error{
        margin:auto;
        padding-top: 20vh;
    }

</style>
