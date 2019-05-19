<template>
    <main>
        <!-- Header -->
        <div id="header">
            <div id="logo" class="light-version">
        <span>
            {{this.application.name}}
        </span>
            </div>
            <nav role="navigation"  class="navbar-expand-lg">
                <div class="header-link hide-menu"><i class="fa fa-bars"></i></div>
                <div class="small-logo">
                    <span class="text-primary">{{ this.application.name }}</span>
                </div>
                <form role="search" class="navbar-form-custom" method="post" action="#">
                    <div class="form-group">
                        <input type="text" placeholder="Search something special" class="form-control" name="search">
                    </div>
                </form>
                <div class="mobile-menu">
                    <button type="button" class="navbar-toggler mobile-menu-toggle" data-toggle="collapse" data-target="#mobile-collapse">
                        <i class="fa fa-chevron-down"></i>
                    </button>
                    <div class="collapse mobile-navbar" id="mobile-collapse">
                        <ul class="nav navbar-nav">
                            <li>
                                <a class="" href="#">Link</a>
                            </li>
                            <li>
                                <a class="" href="#">Link</a>
                            </li>
                        </ul>
                    </div>
                </div>
                <div class="navbar-right pull-right">
                    <ul class="nav navbar-nav no-borders">
                        <li>
                            <a href="#">
                                <i class="fa fa-sign-out"></i>
                            </a>
                        </li>
                    </ul>
                </div>
            </nav>
        </div>
        <Sidebar></Sidebar>
        <div id="wrapper">
            <div class="content animate-panel">
                <router-view></router-view>
            </div>
        </div>
    </main>
</template>

<script>
    import Sidebar from './components/sidebar/Sidebar.vue'
    export default {
        data() {
          return {
              user: this.$user,
              application: this.$app
          }
        },
        name: "app",

        components: {
            Sidebar
        },
        mounted() {
            console.log('App mounted.', this.user)
        }
    }
</script>