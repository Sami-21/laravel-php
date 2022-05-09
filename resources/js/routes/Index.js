
import Home from '../Views/Home.vue'
import Client from '../Views/clients/Index.vue'
import Provider from '../Views/providers/Index.vue'
import Product from '../Views/products/Index.vue'
import Transaction from '../Views/transactions/Index.vue'

const routes = [
    {
        path :'/',
        component :Home
       },
       {
        path :'/clients',
        component :Client
       },
       {
        path :'/providers',
        component :Provider
       },
       {
        path :'/products',
        component :Product
       },
       {
        path :'/transactions',
        component :Transaction
       },
   
]


export default routes;