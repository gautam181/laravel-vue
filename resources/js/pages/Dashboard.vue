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
        mounted() {
            console.log('Component mounted.');
            this.$emit('handle-page-header', {})
        }
    }
</script>
