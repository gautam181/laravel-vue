<template>
    <div :class="{'fixed-navbar':1, 'mini-sidebar':settings.sidebarMinified}">
        <!-- Header -->
        <Header></Header>
        <div id="page-container">
            <div class="content-wrapper">
                <PageHeader :headerData="pageHeaderData"></PageHeader>
                <Sidebar></Sidebar>
                <div class="content animate-panel">
                    <router-view v-on:handle-page-header="handlePageHeader"></router-view>
                </div>
            </div>

        </div>
    </div>
</template>

<script>
    import Sidebar from './components/sidebar/Sidebar.vue'
    import Header from './components/header/Header'
    import PageHeader from './components/page/Header'
    import settings from "./config/Settings"

    export default {
        name: "app",
        components: {
            Sidebar,
            Header,
            PageHeader
        },
        data(){
          return {
              pageHeaderData: '',
              settings: settings
          }
        },
        computed:{
        },
        mounted() {
            console.log('App mounted.', this.user)
        },
        methods:{
            handlePageHeader: function(data){
                this.pageHeaderData = data
            }
        }
    }
</script>
