<script>
    var baseurl = '/api';
    var apiversion = '/v1';
    const settings = {
        baseURL: baseurl,
        APIVersion: apiversion,
        APIURL: baseurl+apiversion,
        DATEFROMAT: 'MMM Do YYYY',
        FULLDATEFROMAT: 'dd Do MMMM YYYY, hh:mmA',
        FORMDATEFROMAT: 'MM/DD/YYYY',
        TIMEFROMAT: 'hh:mm a',
        FROMFUllFROMAT: 'MM/DD/YYYY hh:mm a',
        hideSideBar: false,
        sidebarMinified: localStorage.getItem('sidebar_minified') ? (localStorage.getItem('sidebar_minified') == 'true'? true: false)  : false
    }

    export default settings
</script>
