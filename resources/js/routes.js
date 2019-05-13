import login from './components/login.vue';
import Events from './components/Events/Events.vue'
import NewEvent from './components/Events/NewEvent.vue'
import Event from './components/Events/Event.vue'
import eventDownload from './components/Events/eventDownload.vue'
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
        children:[
            {
                path: '/new',
                component: NewEvent
            },

        ]

},
{
    path: '/events/:id',
    component: Event,
    meta:{
        requiresAuth:true
    }
},
{
    path: '/export',
    meta:{
        requiresAuth: true
    },
    component: eventDownload
},
{
    path: '/tickets',
    meta:{
        requiresAuth: true
    },
    component: Tickets
},

]
