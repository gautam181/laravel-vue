<template>
    <nav class="navbar fixed-top bg-dark top-nav">
        <div id="logo" class="dark-version">
            <img src="../../images/vue-laravel.png" :alt="application.name" class="brand-image">
        </div>
        <nav role="navigation"  class="navbar-expand-lg">
            <div class="header-link hide-menu hide" v-on:click="handleSidebarMinified"><i class="fa fa-bars"></i></div>
            <div class="small-logo">
                <span class="text-primary">{{ this.application.name }}</span>
            </div>
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
            <ul class="nav navbar-nav navbar-left">
                <router-link v-bind:to="{'name': 'dashboard'}" active-class="active" class="nav-item" tag="li" >
                    <a class="">Dashboard</a>
                </router-link>
                <router-link v-bind:to="{'name': 'projects'}"  :class="{
                'nav-item': true,
                'active': subIsActive('/projects'),
                'active': subIsActive('/ticket')
                }" tag="li" >
                    <a class="">Projects</a>
                </router-link>
            </ul>
            <div class="navbar-right pull-right">
                <ul class="nav navbar-nav no-borders">
                    <li class="dropdown ">
                        <a class="nav-item b-nav-dropdown dropdown count-info" href="#" data-toggle="dropdown" aria-expanded="false">
                            <i class="fa fa-envelope"></i>
                            <!--<span class="badge badge-warning">16</span>-->
                        </a>
                        <ul class="dropdown-menu dropdown-menu-right hdropdown notification animated flipInX">
                            <li>
                                <a>
                                    <span class="badge badge-success">NEW</span> It is a long established.
                                </a>
                            </li>
                            <li>
                                <a>
                                    <span class="badge badge-warning">WAR</span> There are many variations.
                                </a>
                            </li>
                            <li>
                                <a>
                                    <span class="badge badge-danger">ERR</span> Contrary to popular belief.
                                </a>
                            </li>
                            <li class="summary"><a href="#">See all notifications</a></li>
                        </ul>
                    </li>
                    <li class="nav-item dropdown dropdown-authentication show">
                        <a class="nav-link dropdown-toggle user-nav no-caret" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
                            <img src="../../images/profile.jpg" class="user-img rounded-circle" alt="logo">
                            <span>{{ this.$user.name }}</span>
                        </a>
                        <div class="dropdown-menu dropdown-menu-right" data-dropdown-in="flipInX" data-dropdown-out="flipOutX">
                            <a class="dropdown-item" href="profile.html"><i class="fa fa-user"></i> Profile</a>
                            <a class="dropdown-item" href="#"><i class="fa fa-power-off"></i> <span>Log out</span></a>
                        </div>
                    </li>
                </ul>
            </div>
        </nav>
    </nav>
</template>

<script>
    import Settings from '../../config/Settings'
    import TopNav from "./menu/TopNav";

    export default {
        name: "Header",
        data() {
            return {
                user: this.$user,
                application: this.$app,
                settings: Settings
            }
        },
        components:{
            //TopNav
        },
        methods: {
            handleSidebarMinified: function(){
                this.settings.sidebarMinified = !this.settings.sidebarMinified;
                if (this.settings.sidebarMinified)
                    document.body.classList.add('hide-sidebar');
                else
                    document.body.classList.remove('hide-sidebar');
            },
            subIsActive(path) {
                const paths = Array.isArray(path) ? path : [path]
                return paths.some(path => {
                    console.log(this.$route.path.indexOf(path));
                    return this.$route.path.indexOf(path) === 0
                })
            }
        }
    }
</script>
