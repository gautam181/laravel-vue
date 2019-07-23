<script>
    const menu = [
        { path: '/dashboard', title: 'Dashboard', badge: {'class': 'success', 'label': 'v 1.0'} },
        { path: '/projects', title: 'Projects', badge: {'class': 'success', 'label': 'new'} },
        { path: '/analytics', title: 'Analytics', badge: {'class': 'warning', 'label': 'new'} },
        { path: '/shipments', title: 'Shipments',
            children: [
                { path: '/shipments/view', title: 'View'}
            ]
        },
        {
            path: '/sales', 'title': 'Sales',
            children: [
                {path: '/sales/customers', title:'Customers'},
                {path: '/sales/sales', title:'Sales'}
            ]
        }
    ]
    export default menu;
</script>