<template>
    <div class="small-header" v-if="headerData.label" >
        <div class="panel dark">
            <div class="panel-heading">
                {{ headerData.label }}
                <div class="panel-tools" v-if="headerData.tools">
                    <template v-for="row in headerData.tools">
                        <a class="edit" v-on:click="row.event(row.id)"><i :class="'fa '+row.icon" ></i></a>
                    </template>

                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        name: "Header",
        data(){
            return {
                headerData: {'label': '', type: ''}
            }
        },
        created(){
            this.$root.$on('header-update', val =>{ this.headerData = val});
        }
    }
</script>

<style scoped>

</style>
