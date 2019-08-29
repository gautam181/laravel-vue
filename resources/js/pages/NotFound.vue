<template>
    <div class="error">
        <div class="error-code mb-4">404 <i class="fa fa-warning"></i></div>
        <div class="error-content">
            <div class="error-message">We couldn't find it...</div>
            <div class="error-desc mb-5">
                The page you're looking for doesn't exist. <br>
                Perhaps, there pages will help find what you're looking for.
            </div>
            <div>
                <router-link class="btn btn-success" to="/">
                    Go Back to dashboard
                </router-link>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        mounted() {
            console.log('Component mounted.')
        },
        created(){
            this.$settings.hideSideBar = true;
        },
        beforeRouteLeave (to, from, next) {
            this.$settings.hideSideBar = false;
            next();
        }
    }
</script>
