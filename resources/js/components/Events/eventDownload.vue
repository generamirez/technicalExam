<template>

<!--
        <div class="row justify-content-center">
            <div class="col-md-4 mt-5">
                    <div class="card">
                        <div class="card-header">
                            Download by date
                            <div class="card-body">
                                <form @submit.prevent="download">
                                    <div class="form-group row">
                                        <label for="date">Date</label>
                                        <input type="date" v-model="date" class="form-control" required>
                                    </div>
                                    <div class="form-group row">

                                        <input type="submit" value="Download" class="btn btn-primary">
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
        </div> -->
   <v-app>
       <v-dialog max-width="600px">
           <v-btn flat slot="activator" class="info"> Export Events </v-btn>
                <v-card>
                    Hello there
                </v-card>
       </v-dialog>
   </v-app>

</template>

<script>
import Axios from "axios";
export default {
    name: 'download',
    mounted() {

    },

    data(){
        return{
           date: null
        }
    },
    computed:{


    },
    methods:{
        download(){
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
            })
        }
    }
}
</script>

<style scoped>
</style>
