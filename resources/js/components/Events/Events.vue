<<template>
    <!-- <div class="events">
            <router-view> </router-view>
            <input type="text" placeholder="search here" v-model="search" class="col-md-2 search">

         <div class="row justify-content-center">


                <div class="card col-md-3 ml-3 mr-3 mb-5"  v-for="event in filteredEvents" :key="event.id" style="width: 18rem;">
                   <router-link :to="`/events/${event.id}`">
                    <img class="card-img" :src="event.image" alt="Card image cap">
                    <div class="card-body">
                        <h5 class="card-title">{{event.name}}</h5>
                        <h6 class="card-subtitle mb-2">{{event.date}}</h6>
                        <p class="card-text">{{event.description}}</p>
                    </div>
                   </router-link>
                </div>


        </div>
    </div> -->
    <v-layout>

        <v-container class="my-2">

                        <v-layout row wrap>
                        <v-spacer> </v-spacer>
                        <v-dialog max-width="600px">

                        <v-btn flat slot="activator" class="info ml-5"> Export Events </v-btn>
                                <v-card>
                                    <v-card-title><h1 class="lead-1">Export events </h1></v-card-title>
                                    <v-form class="pa-3" @submit.prevent="download">
                                        <v-menu>
                                            <v-text-field slot="activator" label="Date" prepend-icon="date_range" :value="date"> </v-text-field>
                                            <v-date-picker v-model="date"> </v-date-picker>

                                        </v-menu>
                                         <v-btn type="submit success">Login</v-btn>
                                    </v-form>
                                </v-card>
                        </v-dialog>
                        <v-flex xs12 sm4 md2>

                             <v-text-field v-model="search" label="search"></v-text-field>
                        </v-flex>
                        </v-layout>

            <v-layout row wrap>

                <v-flex xs12 sm6 md4 lg4 v-for="event in filteredEvents" :key="event.id">
                    <v-hover>
                    <v-card class="text-xs-center mx-5 my-2">
                        <v-responsive>
                            <v-img :src="event.image"> </v-img>
                        </v-responsive>
                        <v-card-text>
                            <div class="green--text"> <h2>{{event.name}} </h2></div>
                            <hr>
                            <div><span class="subheading green--text--lighten-1"> {{event.date}} </span></div>
                            <div class="subheading grey--text"> {{event.description}} </div>
                        </v-card-text>

                        <v-card-actions class="justify-center">
                            <v-btn class="info" :to="`/events/${event.id}`"> View Event </v-btn>
                        </v-card-actions>
                    </v-card>
                    </v-hover>
                </v-flex>
            </v-layout>
        </v-container>
  </v-layout>
</template>

<script>
import Axios from "axios";
import eventDownload from './eventDownload'
export default {
    components:{
        eventDownload
    },
    name: 'events',
    mounted() {
        // console.log(this.$store.getters.currentUser)
        Axios.get('/api/auth/events',{
            params:{

            }
        })
            .then((response)=>{
               this.events = response.data
            })

    },

    data(){
        return{
            events:[],
            search: "",
            date: null
        }
    },
    computed:{
       filteredEvents(){
            return this.events.filter((events)=>{
                return events.name.match(this.search)
            })
        }
    },
    methods:{
         download(){
             console.log(this.date)
            Axios.get(`/api/auth/exportEvents`,{
                params:{
                    date: this.date
                },
                responseType: 'blob'
            }).then((response)=>{
                console.log(response)
                const url = window.URL.createObjectURL(new Blob([response.data]));
                const link = document.createElement('a');
                link.href = url;
                link.setAttribute('download', 'file.xlsx');
                document.body.appendChild(link);
                link.click();
            }).catch((err)=>{
                console.log(err)
            })
        }
    }
}
</script>

<style scoped>

</style>
