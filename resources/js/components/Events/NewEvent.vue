<<template>
    <div class="events">
            <input type="text" placeholder="search here" v-model="search" class="col-md-2 search">

         <div class="row justify-content-center">



                 <div class="card col-md-3 ml-3 mr-3 mb-5"  v-for="event in filteredEvents" :key="event.id" style="width: 18rem;">
                    <a>
                    <img class="card-img" :src="event.image" alt="Card image cap">
                    <div class="card-body">
                        <h5 class="card-title">{{event.name}}</h5>
                        <h6 class="card-subtitle mb-2">{{event.date}}</h6>
                        <p class="card-text">{{event.description}}</p>
                    </div>
                    </a>
                </div>





        </div>
    </div>
</template>

<script>
import Axios from "axios";
export default {
    name: 'newEvent',
    mounted() {
        Axios.get('/api/auth/events')
            .then((response)=>{
                return (response)
            })
            .then((jsonData)=>{
                this.events = jsonData.data
                console.log(this.events)
            })
    },

    data(){
        return{
            events:[],
            search: ""
        }
    },
    computed:{
       filteredEvents(){
            return this.events.filter((events)=>{
                return events.name.match(this.search)
            })
        }
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

    .events{
        height:1000vh;
    }
</style>
