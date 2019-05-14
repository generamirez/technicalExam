<<template>
    <v-layout>

        <v-container class="my-2">

                        <v-layout row wrap>
                        <!-- Popup for export event -->
                        <v-dialog max-width="600px">
                        <v-btn flat slot="activator" class="info ml-5"> Export Events </v-btn>
                                <v-card>
                                    <v-card-title><h1 class="lead-1">Export events </h1></v-card-title>
                                    <v-form class="pa-3" @submit.prevent="download">
                                        <v-menu>
                                            <v-text-field slot="activator" label="Date" prepend-icon="date_range" :value="date"> </v-text-field>
                                            <v-date-picker v-model="date" offset-y> </v-date-picker>

                                        </v-menu>
                                         <v-btn type="submit success">Download</v-btn>
                                    </v-form>
                                </v-card>
                        </v-dialog>

                        <!-- popup for creating an event -->
                        <v-dialog max-width="600px" v-model="createNew">
                            <template v-slot:activator="{ on }">
                                <v-btn color="success" v-on="on"><v-icon> add </v-icon></v-btn>
                            </template>
                        <v-card>
                        <v-layout >
                        <v-container >

                                <v-flex xs12 sm12 md12 lg12>



                                    <v-card class="text-xs-center">

                                        <v-card-title primary-title>
                                        <div>
                                            <h3 class="headline">Create an Event</h3>
                                        </div>
                                    </v-card-title>
                                        <v-flex>
                                        <v-form @submit.prevent = "create" ref="form">

                                            <v-text-field v-model="form.name" label="Name" :rules="createRules" prepend-icon="label_important" ></v-text-field>

                                            <v-text-field v-model="form.city" label="City" required :rules="createRules" prepend-icon="location_on"></v-text-field>
                                            <v-text-field v-model="form.maximum" type = "number" prepend-icon="person_pin" placeholder="Maximum number of participants" :rules="[v => v > 0 || 'Number should be greater than 0']" > </v-text-field>
                                            <v-textarea v-model="form.description" label="Description" :rules="createRules" prepend-icon="description"></v-textarea>
                                            <v-menu>
                                            <v-text-field slot="activator" label="Date" prepend-icon="date_range" :value="form.date" :rules="createRules"> </v-text-field>
                                            <v-date-picker v-model="form.date" offset-y> </v-date-picker>
                                            </v-menu>
                                            <v-btn type="submit" color="info" @click="createNew=false">Create Event</v-btn>
                                        </v-form>
                                        </v-flex>

                                    </v-card>
                                </v-flex>
                        </v-container>
                        </v-layout>
                        </v-card>
                        </v-dialog>


                        <v-flex xs12 sm4 md2>
                             <v-spacer> </v-spacer>
                             <v-text-field v-model="search" label="search" prepend-icon="search"></v-text-field>
                        </v-flex>
                        </v-layout>
            <!-- loop through the list of events -->
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
                         <v-dialog max-width="1000px">
                             <v-btn flat slot="activator" class="info">View Event</v-btn>

                                <v-card>
                                   <Event :event="event">

                                    </Event>
                                </v-card>
                        </v-dialog>

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
import Event from "./Event.vue"
export default {
    components:{
        Event,
    },
    name: 'events',
    mounted() {

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
            date: null,
              form:{
                name: '',
                date: '',
                description: '',
                city: '',
                maximum:''
            },
            createRules:[
                v => !!v || "Please enter a valid input"
            ],
            createNew: false

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
                const url = window.URL.createObjectURL(new Blob([response.data]));
                const link = document.createElement('a');
                link.href = url;
                link.setAttribute('download', 'file.xlsx');
                document.body.appendChild(link);
                link.click();
            }).catch((err)=>{
            })
        },
        create(){
            if(this.$refs.form.validate()){
                 Axios.post(`/api/auth/events/`,{
                user: this.$store.getters.currentUser.id,
                name: this.$data.form.name,
                date: this.$data.form.date,
                description: this.$data.form.description,
                city: this.$data.form.city,
                maximum: this.$data.form.maximum,
            })
            .then((response)=>{
                console.log(response.data)
                this.events.push(response.data)
            }).catch((e)=>{
                console.log(e)
            })
            }

        }
    }
}
</script>

<style scoped>

</style>
