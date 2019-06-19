<template>
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">Customers</div>

                <div class="card-body">
                    Coming Soon
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        name: "Index",
        mounted() {
            this.$emit('handle-page-header', {label:'Customers', desc:'All active customers'})
        }
    }
</script>

<style scoped>

</style>