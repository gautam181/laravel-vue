<template>
    <fragment>
        <!-- Header -->
        <Header></Header>
        <Sidebar></Sidebar>
        <div id="wrapper">
            <div class="content animate-panel">
                <router-view></router-view>
            </div>
        </div>
    </fragment>
</template>

<script>
    import Sidebar from './components/sidebar/Sidebar.vue'
    import Header from './components/header/Header'


    export default {
        name: "app",
        components: {
            Sidebar,
            Header
        },
        mounted() {
            console.log('App mounted.', this.user)
        }
    }
</script>