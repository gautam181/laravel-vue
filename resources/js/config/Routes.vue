<script>
import Dashboard from '../pages/Dashboard'
import Error404 from '../pages/NotFound'

import ProjectList from '../pages/projects/Index'
import ProjectListActive from '../pages/projects/list/Active'
import ProjectListCompleted from '../pages/projects/list/Active'
import ProjectDetail from '../pages/projects/Detail'
import ProjectSummary from '../pages/projects/Summary'
import ProjectTickets from '../pages/projects/Tickets'
import ProjectTicket from '../pages/projects/Ticket'
import ProjectTime from '../pages/projects/Time'
import ProjectFiles from '../pages/projects/Files'
import TicketList from '../pages/tickets/Index'
import TicketDetail from '../pages/tickets/Detail'
import TicketComments from '../pages/tickets/Comments'

const TITLE = 'Laravel Vue App';
const TITLE_SEP = ' - ';

const routes =[
    {path: '/', redirect:'/dashboard', meta:{breadcrumb: 'Dashboard'}},
    {path: '/dashboard', name: 'dashboard', component: Dashboard, meta: {breadcrumb: 'Dashboard'}},
    {path: '/projects', name: 'projects', component: ProjectList, redirect: {name: 'projects-active'},
        children: [
            {path: '/projects/active', name: 'projects-active', component: ProjectListActive, meta: {breadcrumb: 'Active Projects', title: 'Active Projects'+TITLE_SEP+TITLE}},
            {path: '/projects/completed', name: 'projects-completed', component: ProjectListCompleted, meta: {breadcrumb: 'Completed Projects', title: 'Completed Projects'+TITLE_SEP+TITLE}},
        ],
        meta: {breadcrumb: 'Projects', title: 'Projects list'+TITLE_SEP+TITLE}
    },

    {path: '/projects/:id', name: 'project-detail', component: ProjectDetail, redirect: {name: 'project-tickets'},
        children: [
            {path: '/projects/:id/tickets', name: 'project-tickets', component: ProjectTickets, meta: {breadcrumb: 'Project Tickets', title: 'Project tickets'+TITLE_SEP+TITLE}},
            {path: '/projects/:id/summary', name: 'project-summary', component: ProjectSummary, meta: {breadcrumb: 'Project Summary', title: 'Project summary'+TITLE_SEP+TITLE}},
            {path: '/projects/:id/times', name: 'project-time', component: ProjectTime, meta: {breadcrumb: 'Project Time', title: 'Project time'+TITLE_SEP+TITLE}},
            {path: '/projects/:id/files', name: 'project-files', component: ProjectFiles, meta: {breadcrumb: 'Project Files', title: 'Project Files'+TITLE_SEP+TITLE}},
            {path: '/ticket/:ticket_id', name: 'project-ticket', component: ProjectTicket, meta: {breadcrumb: 'Ticket Detail', title: 'Ticket detail'+TITLE_SEP+TITLE}},
        ],
        meta: {breadcrumb: 'Project Detail', title: 'Project detail'+TITLE_SEP+TITLE}},

    {path: '/tickets', name: 'tickets', component: TicketList, meta: {breadcrumb: 'Tickets', title: 'Tickets List'+TITLE_SEP+TITLE}},
    {path: '/tickets/:id', name: 'ticket-detail', component: TicketDetail, meta: {breadcrumb: 'Ticket Detail', title: 'ticket detail'+TITLE_SEP+TITLE}},
    {path: '/tickets/:id/comments', name: 'ticket-comments', component: TicketComments, meta: {breadcrumb: 'Ticket Comments', title: 'ticket comments'+TITLE_SEP+TITLE}},
    {path: '*', name: '404', component: Error404, meta: {}}

];

export default routes;
</script>
