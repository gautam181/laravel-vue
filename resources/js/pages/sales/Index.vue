<template>
    <div>
        <router-view v-on:handle-page-header="handlePageHeader" ref="myChild"></router-view>
        <div v-if="$route.name == 'Sales'" class="row">

            <template v-for="schild in this.myRoute.children">
                <div class="col-md-2">
                    <div class="hpanel">
                        <div class="panel-body">
                            <div class="text-center">
                                <h2 class="m-b-xs">{{ schild.meta.breadcrumb }}</h2>
                                <p class="font-bold text-success">&nbsp;</p>
                                <router-link v-bind:to="schild.path">
                                    <a class="btn btn-info btn-sm btn-block">
                                        {{ schild.path }}
                                    </a>
                                </router-link>
                            </div>
                        </div>
                    </div>

                </div>

            </template>

        </div>
    </div>
</template>

<script>
    export default {
        name: "sale-index",
        data(){
            return {
                myRoute : {}
            }
        },
        mounted(){
            this.$emit('handle-page-header', {label:'Sales', desc:'Sale Modules'});
            this.myRoute = this.$router.options.routes.find(route => route.name === this.$route.name);
        },
        methods:{
            handlePageHeader: function(data){
                this.$emit('handle-page-header', data);
            }
        }
    }
</script>

<style scoped>

</style>