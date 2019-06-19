<template>
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">Shipments</div>

                <div class="card-body">
                    Coming Soon
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        name: "view",
        mounted(){
            this.$emit('handle-page-header', {label:'Shipments', desc:'All active shipments'})
        }

    }
</script>

<style scoped>

</style>