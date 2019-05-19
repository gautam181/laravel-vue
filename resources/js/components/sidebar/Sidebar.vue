<template>
    <aside id="menu">
        <div id="navigation">
            <div class="profile-picture">
                <a href="index.html">
                    <img src="../../images/profile.jpg" class="img-circle m-b" alt="logo">
                </a>

                <div class="stats-label text-color">
                    <span class="font-extra-bold font-uppercase">Robert Razer</span>

                    <div class="dropdown">
                        <a class="dropdown-toggle" href="#" data-toggle="dropdown">
                            <small class="text-muted">Founder of App <b class="caret"></b></small>
                        </a>
                        <ul class="dropdown-menu animated flipInX m-t-xs">
                            <li><a href="contacts.html">Contacts</a></li>
                            <li><a href="profile.html">Profile</a></li>
                            <li><a href="analytics.html">Analytics</a></li>
                            <li class="divider"></li>
                            <li><a href="login.html">Logout</a></li>
                        </ul>
                    </div>


                    <div id="sparkline1" class="small-chart m-t-sm"><canvas style="display: inline-block; width: 119px; height: 30px; vertical-align: top;" width="119" height="30"></canvas></div>
                    <div>
                        <h4 class="font-extra-bold m-b-xs">
                            $260 104,200
                        </h4>
                        <small class="text-muted">Your income from the last year in sales product X.</small>
                    </div>
                </div>
            </div>
            <SidebarNav></SidebarNav>
        </div>
    </aside>
</template>

<script>
    import SidebarNav from "./SidebarNav"
    export default {
        name: "Sidebar",
        components: {
            SidebarNav
        }
    }
</script>

<style scoped>

</style>