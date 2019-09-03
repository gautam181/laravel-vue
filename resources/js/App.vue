<template>
    <div :class="{'fixed-navbar':1, 'mini-sidebar':settings.sidebarMinified, 'no-sidebar': settings.hideSideBar}">
        <!-- Header -->
        <Header></Header>
        <div id="page-container">
            <div class="content-wrapper">
                <PageHeader :headerData="pageHeaderData"></PageHeader>
                <Sidebar v-if="!settings.hideSideBar"></Sidebar>
                <div class="content animate-panel">
                    <router-view v-on:handle-page-header="handlePageHeader"></router-view>
                    <vue-ins-progress-bar></vue-ins-progress-bar>
                </div>
            </div>
        </div>
        <notifications group="form" position="bottom right" :max="3" />
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
        created(){
            this.$insProgress.start();
            this.$router.beforeEach((to, from, next) => {
                this.$insProgress.start()
                next()
            })
            this.$router.afterEach(() => {
                this.$insProgress.finish()
            })
        },
        mounted() {
            this.$insProgress.finish();
            console.log('App mounted.', this.user);
        },
        methods:{
            handlePageHeader: function(data){
                this.pageHeaderData = data
            }
        }
    }
</script>
