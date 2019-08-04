<template>
    <div>
        <vue-title :title="ticket.title"></vue-title>
        <div class="row">
            <div class="col-md-12">
                <vue-panel
                    id="ticket"
                    :title="ticket.title"
                    tools="1"
                >{{ ticket.description }}</vue-panel>
            </div>
            <div class="col-md-12">
                <div class="list-options">
                    <h2 class="">Comments</h2>
                    <div class="btn-options text-right">
                        <b-dropdown variant="default" >
                            <template slot="button-content">
                                <strong>Sort By: </strong> Date <span v-show="sort == 'desc'">Descending</span> <span v-show="sort == 'asc'">Ascending</span>
                            </template>
                            <b-dropdown-item-button  v-on:click="changeCommentSort('asc')" :active="sort === 'asc'">Date Ascending</b-dropdown-item-button>
                            <b-dropdown-item-button v-on:click="changeCommentSort('desc')" :active="sort === 'desc'">Date Descending</b-dropdown-item-button>
                        </b-dropdown>
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
                sort: 'asc',
                order_by: 'date',
                add_comment: {comment:'', id:''}

            }
        },
        components: {
            Comment
        },
        mounted(){
            this.getTicket();
            this.getComments();
            this.$emit('handle-page-header', {label:'Ticket', desc:'Ticket Detail'});
            this.myRoute = this.$router.options.routes.find(route => route.name === this.$route.name);
        },
        methods:{
            handlePageHeader: function(data){
                this.$emit('handle-page-header', data);
            },
            getTicket: function () {
                axios.get(this.$settings.APIURL+"/ticket/"+this.ticket_id)
                    .then(response => {
                        this.ticket = response.data;
                    });
            },
            changeCommentSort: function(val){
                console.log("data changed", val);
                this.sort = val;
                this.getComments();
            },
            getComments: function () {
                axios.get(this.$settings.APIURL+"/ticket/"+this.ticket_id+'/comments?sort='+this.sort)
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
