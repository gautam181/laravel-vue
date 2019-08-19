<template>
    <div class="fixed-navbar mini-sidebar">
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


    export default {
        name: "app",
        components: {
            Sidebar,
            Header,
            PageHeader
        },
        data(){
          return {
              pageHeaderData: ''
          }
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
