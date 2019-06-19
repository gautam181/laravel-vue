<script>
import Dashboard from '../components/Dashboard'
import Analytics from '../components/Analytics'
import Error404 from '../components/NotFound'
import Shipments from '../pages/shipments/Index'
import ShipmentsList from '../pages/shipments/List'

import CustomersList from '../pages/sales/customers/Index'
import SalesIndex from '../pages/sales/Index'
import SalesList from '../pages/sales/sales/Index'

const routes =[
    {path: '/', redirect:'/dashboard', meta:{breadcrumb: 'Dashboard'}},
    {path: '/dashboard', name: 'dashboard', component: Dashboard, meta: {breadcrumb: 'Dashboard'}},
    {path: '/analytics', name:'Analytics', component: Analytics, meta: {breadcrumb: 'Analytics'}},
    {path: '/shipments', name:'shipments', component: Shipments,
        children: [
            {path: 'view', name:'shipments-list', component: ShipmentsList, meta: {breadcrumb: 'View'}}
        ],
        meta: {breadcrumb: 'shipments'}
    },
    {path: '/sales', name: 'Sales', component: SalesIndex,
        children: [
            {path: 'customers', name:'customers-list', component: CustomersList, meta: {breadcrumb: 'Customer'}},
            {path: 'sales', name:'sales-list', component: SalesList, meta: {breadcrumb: 'Sales'}}
        ],
        meta:{breadcrumb: 'Sales'}
    },
    {path: '*', name: '404', component: Error404, meta: {}}

];

export default routes;
</script>