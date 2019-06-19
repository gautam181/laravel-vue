<template>
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">Sales</div>

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
            this.$emit('handle-page-header', {label:'Sales', desc:'All active sales'})
        }
    }
</script>

<style scoped>

</style>