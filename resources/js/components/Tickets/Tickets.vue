<template>
    <div class="tickets">
        <div v-if="!tickets.length" class="body">
                   <v-alert :value="true" type="error">
     You have no tickets!
    </v-alert>
        </div>

        <div v-else class="body">
            <v-alert  v-model="alert" dismissible type="success" mt-5 >
                {{alertMessage}}
            </v-alert>
             <v-data-table :headers="headers" :items="tickets" class="elevation-1 mt-4" hide-actions xs12 s12 md12 xl12>
                 <template v-slot:items="props">
                    <td>{{ props.item.id }}</td>
                    <td class="text-xs-left">{{ props.item.event.name }}</td>
                    <td class="text-xs-left">{{ props.item.event.user.email }}</td>
                    <td class="text-xs-left">
                         <v-dialog max-width="1000px">
                             <v-btn slot="activator" class="info"><v-icon>search </v-icon></v-btn>

                                <v-card>
                                   <Event :event="props.item.event">

                                    </Event>
                                </v-card>
                        </v-dialog>
                        <v-btn class="danger" @click.prevent="remove(`${props.item.id}`)"><v-icon>delete </v-icon></v-btn>


                    </td>
                </template>
             </v-data-table>
        </div>
    </div>
</template>

<script>
import Axios from "axios";
import Event from "../Events/Event"
export default {
    components:{
        Event
    },
    name: 'tickets',
    mounted() {
        Axios.get('/api/auth/myTickets',{
              headers:{
                'Content-Type': 'application/json',
                'Authorization': 'Bearer '+this.$store.getters.currentUser.token,
                'X-Requested-With' : "XMLHttpRequest"
            },
            params:{
                id: this.$store.getters.currentUser.id
            },

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
           alertMessage: "",
            alert: false,
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
    methods:{
        remove(id){
           Axios.delete(`api/auth/tickets/${id}`,{
               headers:{
                    'Content-Type': 'application/json',
                    'Authorization': 'Bearer '+this.$store.getters.currentUser.token,
                    'X-Requested-With' : "XMLHttpRequest"
                },
               data:{

               }
           }).then((res)=>{
                Axios.get('/api/auth/myTickets',{
                    headers:{
                    'Content-Type': 'application/json',
                    'Authorization': 'Bearer '+this.$store.getters.currentUser.token,
                    'X-Requested-With' : "XMLHttpRequest"
                },
                params:{
                    id: this.$store.getters.currentUser.id
                    }
                 }) .then((response)=>{
                     this.tickets = response.data
                     this.alertMessage = "Ticket number:"+id+" has been deleted"
                     this.alert = true
                     })
                }).catch(error => {
                console.log(error.message)
                })
        },
    }
}
</script>
