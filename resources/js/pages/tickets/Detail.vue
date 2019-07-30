<template>
    <div>
        <div class="row">
            <div class="col-md-12">
                <div class="hpanel">
                    <div class="panel-heading">{{ ticket.title }}</div>
                    <div class="panel-body">
                        <p>
                            {{ ticket.description }}
                        </p>
                    </div>

                </div>
            </div>
            <div class="col-md-12">
                <div class="hpanel forum-box" v-if="comments.length > 0">
                    <template v-for="row in comments">
                    <div class="panel-body">
                        <div class="media">
                            <div class="media-author pull-left">
                                <div class="author-info">
                                    <p class="author-name" v-bind:title="row.created_by.name">{{ row.created_by.name }} </p>
                                    {{ row.updated_at | moment("from", "now" ) }}
                                    <!--<div class="badges">
                                        <i class="fa fa-star text-warning"></i>
                                        <i class="fa fa-shield text-success"></i>
                                    </div>-->
                                </div>
                            </div>
                            <div class="media-body">
                               {{ row.comment }}
                            </div>
                            <div class="media-info pull-right">
                                <span v-bind:title="row.updated_at">{{ row.updated_at | moment("from", "now") }}</span>
                                <button class="btn btn-default dropdown" data-toggle="dropdown" type="button" aria-expanded="false"><i class="fas fa-ellipsis-v"></i></button>
                                <div class="dropdown-menu dropdown-menu-right">
                                    <a href="" class="dropdown-item">Edit</a>
                                    <a href="" class="dropdown-item">Delete</a>
                                </div>
                            </div>
                        </div>
                    </div>
                    </template>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        name: "ticket-detail",
        data(){
            return {
                myRoute : {},
                ticket_id : this.$route.params.id,
                ticket: {},
                comments: []

            }
        },
        mounted(){
            this.getTicket(this.ticket_id);
            this.getComments(this.ticket_id);
            this.$emit('handle-page-header', {label:'Ticket', desc:'Ticket Detail'});
            this.myRoute = this.$router.options.routes.find(route => route.name === this.$route.name);
        },
        methods:{
            handlePageHeader: function(data){
                this.$emit('handle-page-header', data);
            },
            getTicket: function (id) {
                axios.get(this.$settings.APIURL+"/ticket/"+id)
                    .then(response => {
                        let res = response.data;
                        this.ticket = res;
                    });
            },
            getComments: function (id, data) {
                axios.get(this.$settings.APIURL+"/ticket/"+id+'/comments')
                    .then(response => {
                        let res = response.data;
                        this.comments = res.data;
                    });
            }
        },
        beforeRouteUpdate (to, from, next) {
            this.ticket_id = to.params.id;
            this.getTicket(this.ticket_id);
            this.getComments(this.ticket_id);
            next();
        }
    }
</script>

<style scoped>

</style>
