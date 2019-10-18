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
        <b-toast id="message_alert" :variant="variant" solid :toaster="position">
            <template v-slot:toast-title>
                <div class="d-flex flex-grow-1 align-items-baseline">
                    {{ message.message }}
                </div>
            </template>
            <ul v-if="message.errors">
                <template v-for="(item, index) in message.errors">
                <li><template v-for="row in item">
                        {{ row }}<br>
                    </template>

                </li>
                </template>
            </ul>
            <p v-if="message.text">{{ message.text }}</p>
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
              message:{},
              position: 'b-toaster-top-full',
              settings: settings,
              height: 500,
              width:500,

          }
        },
        computed:{
            variant(){
                return this.message.type ? this.message.type : (this.message.errors ? 'danger': '');
            }
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
            this.$root.$on('showAlert', (data)=>{
                this.message = data;
                this.$bvToast.show('message_alert');
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
