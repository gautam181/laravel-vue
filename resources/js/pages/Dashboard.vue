<template>
    <div>
        <div class="row mt-3">
            <div class="col-lg-12 text-center m-t-md" style="">
                <h2>
                    Welcome to Laravel VUE
                </h2>

                <p>
                    Showcase application for laravel with VueJS using laravel passport APIs.
                </p>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        created(){
            this.$settings.hideSideBar = true;
        },
        mounted() {
            console.log('Component mounted.');
            this.$root.$emit('header-update', {})
        },
        beforeRouteLeave (to, from, next) {
            this.$settings.hideSideBar = false;
            next();
        }
    }
</script>
