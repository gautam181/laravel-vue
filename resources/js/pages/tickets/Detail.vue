<template>
    <div>
        <vue-title :title="ticket.title"></vue-title>
        <div class="row">
            <div class="col-md-12">
                <div id="ticket" class="hpanel">
                    <div class="panel-heading hbuilt">
                        {{ ticket.title }}
                        <div class="panel-tools">
                            <a class="showhide" v-on:click="togglePanel('#ticket')"><i class="fa fa-chevron-up"></i></a>
                        </div>
                    </div>
                    <div class="panel-body">
                        <p>
                            {{ ticket.description }}
                        </p>
                    </div>

                </div>
            </div>
            <div class="col-md-12">
                <div class="list-options">
                    <h2 class="">Comments</h2>
                    <div class="btn-options text-right">
                        <button data-toggle="dropdown" class="btn btn-default dropdown-toggle" aria-expanded="false">Sort: <span class="action">Date ASC</span><span class="caret"></span></button>
                        <ul class="dropdown-menu dropdown-menu-right">
                            <li>Date ASC</li>
                            <li>Date DESC</li>
                        </ul>
                    </div>
                </div>

            </div>
            <div class="col-md-12">
                <Comment
                    :author="this.$user"
                    :comment="add_comment"
                    :ticket="ticket"
                    :edit="true"
                ></Comment>
            </div>
            <div class="col-md-12">
                <div class="hpanel forum-box" v-if="comments.length > 0">
                    <template v-for="row in comments">
                        <Comment
                            :author="row.created_by"
                            :comment="row"
                            :ticket="ticket"
                            :edit="false"
                        ></Comment>
                    </template>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    import Comment from "../../components/util/Comment";
    export default {
        name: "ticket-detail",
        data(){
            return {
                myRoute : {},
                ticket_id : this.$route.params.id,
                ticket: {},
                comments: [],
                add_comment: {comment:'', id:''}

            }
        },
        components: {
            Comment
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
                        this.ticket = response.data;
                    });
            },
            getComments: function (id, data) {
                axios.get(this.$settings.APIURL+"/ticket/"+id+'/comments')
                    .then(response => {
                        const {data: data1} = response;
                        this.comments = data1.data;
                    });
            },
            togglePanel: function (id) {
                $(id).find(".showhide i").toggleClass('fa-chevron-up').toggleClass('fa-chevron-down');
                $(id).find(".panel-body").slideToggle(300);
                $(id).find(".panel-footr").slideToggle(200);
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
