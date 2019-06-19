<template>
    <fragment>
        <!-- Header -->
        <Header></Header>
        <Sidebar></Sidebar>
        <div id="wrapper">
            <PageHeader :headerData="pageHeaderData"></PageHeader>
            <div class="content animate-panel">
                <router-view v-on:handle-page-header="handlePageHeader"></router-view>
            </div>
        </div>
    </fragment>
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