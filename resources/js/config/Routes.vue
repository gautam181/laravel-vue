<script>
import Dashboard from '../components/Dashboard'
import Analytics from '../components/Analytics'
import Error404 from '../components/NotFound'
import Shipments from '../pages/shipments/Index'
import ShipmentsList from '../pages/shipments/List'

import CustomersList from '../pages/sales/customers/Index'
import SalesIndex from '../pages/sales/Index'
import SalesList from '../pages/sales/sales/Index'
import ProjectList from '../pages/projects/Index'
import ProjectDetail from '../pages/projects/Detail'
import TicketList from '../pages/tickets/Index'
import TicketDetail from '../pages/tickets/Detail'
import TicketComments from '../pages/tickets/Comments'


const routes =[
    {path: '/', redirect:'/dashboard', meta:{breadcrumb: 'Dashboard'}},
    {path: '/dashboard', name: 'dashboard', component: Dashboard, meta: {breadcrumb: 'Dashboard'}},
    {path: '/projects', name: 'projects', component: ProjectList,
        children: [],
        meta: {breadcrumb: 'Projects'}
    },
    {path: '/projects/:id/tickets', name: 'project-detail', component: ProjectDetail, meta: {breadcrumb: 'Project Detail'}},
    {path: '/tickets', name: 'tickets', component: TicketList, meta: {breadcrumb: 'Tickets'}},
    {path: '/tickets/:id', name: 'ticket-detail', component: TicketDetail, meta: {breadcrumb: 'Ticket Detail'}},
    {path: '/tickets/:id/comments', name: 'ticket-comments', component: TicketComments, meta: {breadcrumb: 'Ticket Comments'}},

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
