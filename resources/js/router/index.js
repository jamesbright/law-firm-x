import {createWebHistory, createRouter} from "vue-router";


import Clients from '../components/Clients';
import AddClient from '../components/AddClient';
import Dashboard from '../components/Dashboard';

export const routes = [
    {
        name: 'clients',
        path: '/',
        component: Clients
    },
  
    {
        name: 'dashboard',
        path: '/clients/dashboard/:id',
        component: Dashboard,
        props:true
    },
  
    {
        name: 'addclient',
        path: '/clients/add',
        component: AddClient
    },
  
];

const router = createRouter({
    history: createWebHistory(),
    routes: routes,
});

export default router;
