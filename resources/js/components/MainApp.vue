<template>

<div id="main">
    <v-app>
    <Header/>
    <div class="content">
        <router-view> </router-view>
    </div>
    </v-app>
</div>
</template>
<script>

 import Header from './Header.vue';
    export default {
        mounted() {

        },
         name:'main-app',
         components: { Header },
         data(){
           return{
               events:{}
           }
         },
    }
</script>

<style scoped>
    .content{
        background-color: #7d304b;
        height:100%;
    }

    html body{
        overflow-x: hidden;
        background-color: #7d304b;
        height:100%;
    }


</style>
