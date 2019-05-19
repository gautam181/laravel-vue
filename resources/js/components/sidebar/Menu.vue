<script>
    const menu = [
        { path: '/dashboard', title: 'Dashboard', badge: {'class': 'success', 'label': 'v 1.0'} },
        { path: '/analytics', title: 'Analytics', badge: {'class': 'warning', 'label': 'new'} },
        { path: '/interface', title: 'Interface',
            children: [
                { path: '/panels', title: 'Panels design'},
                { path: '/typography', title: 'Typography'},
            ]
        }
    ]
    export default menu;
</script>