<template>
    <div :class="{'fixed-navbar':1, 'mini-sidebar':settings.sidebarMinified, 'no-sidebar': settings.hideSideBar}">
        <!-- Header -->
        <Header></Header>
        <div id="page-container">
            <div class="content-wrapper" :style="{minHeight: height+'px'}">
                <PageHeader :headerData="pageHeaderData"></PageHeader>
                <Sidebar v-if="!settings.hideSideBar"></Sidebar>
                <div class="content animate-panel">
                    <router-view v-on:handle-page-header="handlePageHeader"></router-view>
                    <vue-ins-progress-bar></vue-ins-progress-bar>
                </div>
            </div>
        </div>
        <b-toast id="form_error" variant="danger" solid toaster="b-toaster-top-full">
            <template v-slot:toast-title>
                <div class="d-flex flex-grow-1 align-items-baseline">
                    {{ toast.message }}
                </div>
            </template>
            <ul>
                <template v-for="(item, index) in toast.errors">
                <li><template v-for="row in item">
                        {{ row }}<br>
                    </template>

                </li>
                </template>
            </ul>



        </b-toast>
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
              toast:{},
              settings: settings,
              height: 500,
              width:500,
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
            window.addEventListener('resize', this.handleResize)
            this.handleResize();

        },
        mounted() {
            this.$insProgress.finish();
            this.$root.$on('showToast', (data)=>{
                this.toast = data;
                this.$bvToast.show('form_error');
            });
        },
        methods:{
            handlePageHeader: function(data){
                this.pageHeaderData = data
            },
            handleResize() {
                this.width = window.innerWidth;
                this.height = window.innerHeight- (58);
            }
        }
    }
</script>
