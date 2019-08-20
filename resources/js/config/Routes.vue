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
import ProjectSummary from '../pages/projects/Summary'
import ProjectTickets from '../pages/projects/Tickets'
import ProjectTime from '../pages/projects/Time'
import TicketList from '../pages/tickets/Index'
import TicketDetail from '../pages/tickets/Detail'
import TicketComments from '../pages/tickets/Comments'

const TITLE = 'Laravel Vue App';
const TITLE_SEP = ' - ';

const routes =[
    {path: '/', redirect:'/dashboard', meta:{breadcrumb: 'Dashboard'}},
    {path: '/dashboard', name: 'dashboard', component: Dashboard, meta: {breadcrumb: 'Dashboard'}},
    {path: '/projects', name: 'projects', component: ProjectList,
        children: [],
        meta: {breadcrumb: 'Projects', title: 'Projects list'+TITLE_SEP+TITLE}
    },

    {path: '/projects/:id', name: 'project-detail', component: ProjectDetail,
        children: [
            {path: '/projects/:id/tickets', name: 'project-tickets', component: ProjectTickets, meta: {breadcrumb: 'Project Tickets', title: 'Project tickets'+TITLE_SEP+TITLE}},
            {path: '/projects/:id/summary', name: 'project-summary', component: ProjectSummary, meta: {breadcrumb: 'Project Summary', title: 'Project summary'+TITLE_SEP+TITLE}},
            {path: '/projects/:id/time', name: 'project-time', component: ProjectTime, meta: {breadcrumb: 'Project Time', title: 'Project time'+TITLE_SEP+TITLE}},
        ],
        meta: {breadcrumb: 'Project Detail', title: 'Project detail'+TITLE_SEP+TITLE}},

    {path: '/tickets', name: 'tickets', component: TicketList, meta: {breadcrumb: 'Tickets', title: 'Tickets List'+TITLE_SEP+TITLE}},
    {path: '/tickets/:id', name: 'ticket-detail', component: TicketDetail, meta: {breadcrumb: 'Ticket Detail', title: 'ticket detail'+TITLE_SEP+TITLE}},
    {path: '/tickets/:id/comments', name: 'ticket-comments', component: TicketComments, meta: {breadcrumb: 'Ticket Comments', title: 'ticket comments'+TITLE_SEP+TITLE}},

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
