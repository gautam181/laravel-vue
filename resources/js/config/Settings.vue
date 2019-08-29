<script>
    var baseurl = '/api';
    var apiversion = '/v1';
    const settings = {
        baseURL: baseurl,
        APIVersion: apiversion,
        APIURL: baseurl+apiversion,
        DATEFROMAT: 'MMM Do YYYY',
        FORMDATEFROMAT: 'MM/DD/YYYY',
        hideSideBar: false,
        sidebarMinified: localStorage.getItem('sidebar_minified') ? (localStorage.getItem('sidebar_minified') == 'true'? true: false)  : false
    }

    export default settings
</script>
