import login from './components/login.vue';
import Events from './components/Events/Events.vue'
import Event from './components/Events/Event.vue'
import Tickets from './components/Tickets/Tickets.vue'


export const routes = [
{
    path:'/',
    component: login
},
{
    path:'/events',
    component: Events,
    meta:{
        requiresAuth: true
    },

},
{
    path: '/events/:id',
    component: Event,
    meta:{
        requiresAuth:true
    }
},

{
    path: '/tickets',
    meta:{
        requiresAuth: true
    },
    component: Tickets
},

]
