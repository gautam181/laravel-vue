<template>
    <div class="profile-picture">
        <a href="index.html">
            <img src="../../images/profile.jpg" class="rounded-circle" alt="logo">
        </a>

        <div class="stats-label text-color">
            <span class="font-extra-bold font-uppercase">Abdul Khan</span>

            <div class="dropdown">
                <a class="dropdown-toggle" href="#" data-toggle="dropdown">
                    <small class="text-muted">Super Admin <b class="caret"></b></small>
                </a>
                <ul class="dropdown-menu dropdown-menu-right animated flipInX m-t-xs">
                    <li class="dropdown-item"><a href="contacts.html">Contacts</a></li>
                    <li class="dropdown-item"><a href="profile.html">Profile</a></li>
                    <li class="dropdown-item"><a href="analytics.html">Analytics</a></li>
                    <li class="dropdown-divider"></li>
                    <li class="dropdown-item"><a href="login.html">Logout</a></li>
                </ul>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        name: "Profile"
    }
</script>

<style scoped>

</style>