<template>
    <div id="header">
        <div id="logo" class="light-version">
            <span>
                {{this.application.name}}
            </span>
        </div>
        <nav role="navigation"  class="navbar-expand-lg">
            <div class="header-link hide-menu" v-on:click="handleSidebarMinified"><i class="fa fa-bars"></i></div>
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
                    <li>
                        <a href="#">
                            <i class="fa fa-sign-out"></i>
                        </a>
                    </li>
                </ul>
            </div>
        </nav>
    </div>
</template>

<script>
    import Settings from '../../config/Settings'

    export default {
        name: "Header",
        data() {
            return {
                user: this.$user,
                application: this.$app,
                settings: Settings
            }
        },
        methods: {
            handleSidebarMinified: function(){
                this.settings.sidebarMinified = !this.settings.sidebarMinified;
                if (this.settings.sidebarMinified)
                    document.body.classList.add('hide-sidebar');
                else
                    document.body.classList.remove('hide-sidebar');
            }
        }
    }
</script>