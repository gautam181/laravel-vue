<template>
    <div class="normalheader  small-header" v-if="headerData.label" >
        <div class="hpanel">
            <div class="panel-body">
                <div id="hbreadcrumb" class="pull-right">
                    <breadcrumbs></breadcrumbs>
                </div>
                <h2 class="font-light m-b-xs">
                    {{ this.headerData.label }}
                </h2>
                <small v-if="headerData.desc">{{ this.headerData.desc }}</small>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        name: "Header",
        props: ['headerData']
    }
</script>

<style scoped>

</style>