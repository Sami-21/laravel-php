import Stores from '../Views/Stores.vue'
import Products from '../Views/Products.vue'
import Home from '../Views/Home.vue'

const routes = [
    {
        path :'/',
        component :Home
       },
    {
     path :'/stores',
     component :Stores
    },
    {
        path :'/products',
        component :Products
       }
]


export default routes;