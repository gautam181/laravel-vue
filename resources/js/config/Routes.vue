<script>
import Dashboard from '../components/Dashboard'
import Error404 from '../components/NotFound'
import Shipments from '../components/Shipments'
import Datatable from '../components/Datatable'

const routes =[
    {path: '*', name: '404', component: Error404, meta: {}},
    {path: '/', redirect:'/dashboard'},
    {path: '/dashboard', name: 'dashboard', component: Dashboard, meta: {}},
    {path: '/shipments', name:'Shipments', component: Shipments, meta: {}},
    {path: '/datatable', name:'Datatable', component: Datatable, meta: {}}
];

export default routes;
</script>