<template xmlns="http://www.w3.org/1999/html">
    <div>
        <vue-title :title="project.name"></vue-title>
        <div class="row">
            <div class="col-md-12">
                <div class="list-options">
                    <h2 class="">Summary</h2>
                </div>
                <vue-ladda button-class="btn btn-primary" data-size="sm">Click Me!</vue-ladda>

            </div>
        </div>
    </div>
</template>

<script>
    import Ticket from '../../components/util/Ticket';

    export default {
        name: "project-summary",
        data(){
            return {
                myRoute : {},
                project_id : this.$route.params.id,
                project: {},
                tickets: [],
                ticketList: true,
                showAddTicket: false,
                blankTicket: {
                    project: {id:this.$route.params.id},
                    title: '', description: '',
                    assigned_to: {id:'', name: ''}
                }
            }
        },
        watch: {

        },
        components: {
            Ticket
        },
        mounted(){

        },
        methods:{
            handlePageHeader: function(data){
                this.$emit('handle-page-header', data);
            },
        },
        beforeRouteUpdate (to, from, next) {
            next();
        }
    }
</script>

<style scoped>
h5{font-size: 14px;}
</style>
