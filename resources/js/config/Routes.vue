<script>
import Dashboard from '../components/Dashboard'
import Analytics from '../components/Analytics'
import Error404 from '../components/NotFound'
import Shipments from '../components/Shipments'
import Datatable from '../components/Datatable'

const routes =[
    {path: '*', name: '404', component: Error404, meta: {}},
    {path: '/', redirect:'/dashboard'},
    {path: '/dashboard', name: 'dashboard', component: Dashboard, meta: {}},
    {path: '/analytics', name:'Analytics', component: Analytics, meta: {}},
    {path: '/interface/shipments', name:'Shipments', component: Shipments, meta: {}},
    {path: '/interface/datatable', name:'Datatable', component: Datatable, meta: {}}
];

export default routes;
</script>