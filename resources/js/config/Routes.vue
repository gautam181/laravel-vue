<script>
import Dashboard from '../components/Dashboard'
import Error404 from '../components/NotFound'
import Shipments from '../components/Shipments'

const routes =[
    {path: '*', name: '404', component: Error404, meta: {}},
    {path: '/', name: 'dashboard', component: Dashboard, meta: {}},
    {path: '/shipments', name:'Shipments', component: Shipments, meta: {}}
];

export default routes;
</script>