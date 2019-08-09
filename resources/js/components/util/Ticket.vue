<template>
    <div class="ticket-wrapper" :id="'ticket_'+ticket.id">
        <div class="ticket-row">
            <div class="ticket-controls">
                <a href="javascript:void(0);" class="edit"><i class="fa fa-pencil-alt"></i></a> &nbsp;
                <a href="javascript:void(0);" class="edit"><i class="fa fa-trash-alt"></i></a>
            </div>
            <span class="estimate">10 Hours</span>
            <div class="ticket-heading">
                <div class="assignedto">
                    <span class="">{{ ticket.assigned_to.name }}</span>
                </div>
                <div class="ticket-title">
                   <p class="ticket-name">
                       <router-link v-bind:to="{'name': 'ticket-detail', params: {'id': ticket.id }}" v-if="is_list" active-class="" class="">{{ ticket.title }}</router-link>
                       <span v-else>{{ ticket.title }}</span>
                   </p>
                    <span class="ticket-more" v-if="is_list">
                        <a href="javascript:void(0);" class="btn btn-xs" v-on:click="showDesc">{{ more_desc }} ....</a>
                    </span>
                </div>
            </div>

        </div>
        <div class="ticket-description" >
            <div class="ticket-desc" v-if="show_desc">
               {{ ticket.description }}
            </div>
            <button type="button" class="btn btn-default btn-xs" v-on:click="showDesc" v-if="!is_list">{{ view_desc }} Description ...</button>
        </div>
    </div>
</template>

<script>
    export default {
        name: "Ticket",
        props: {
            'ticket': Object,
            'view': {type: Boolean, default: true},
            'desc': {type: Boolean, default: false},
            'list': {type: Boolean, default: false}
        },
        data: function(){
            return {
                mode: this.view == true ? 'view': 'from',
                id_deleted: false,
                is_list: this.list,
                show_desc: this.desc,
                more_desc: this.desc ? 'less': 'more',
                view_desc: this.desc ? 'Hide': 'Show'
            }
        },
        watch: {
            show_desc: function(val){
                this.view_desc =  val ? 'Hide' : 'Show'
                this.more_desc =  this.show_desc ? 'less' : 'more'
            },
            comment: function(val){
                this.comment_body = this.comment.comment;
            }
        },
        mounted(){
            //console.log(this.ticket, this.author_id);
        },
        methods: {
            showDesc: function(){
                this.show_desc = !this.show_desc;
            },
            saveComment: function () {
                this.$store.dispatch('comments/saveComment', {
                    id: this.comment.id,
                    body: {
                        author_id: this.author.id,
                        ticket_id: this.ticket.id,
                        project_id: this.ticket.project_id,
                        comment: this.comment_body
                    }
                })
                    .then(response => {
                        this.activated = false;
                        if(this.edit=== false)
                            this.mode = 'view';
                        if (!this.comment.id)
                            this.comment_body = this.comment.comment;
                        this.$emit('commentUpdate', response);
                    })
                    .catch(error => {
                        console.log(error);
                    });
            },
            resetComment: function () {
                this.activated = false;
                if(this.edit=== false)
                    this.mode = 'view';
                this.comment_body = this.comment.comment;
            },
            enableComment(){
                this.activated = true;
            },
            editComment(){
                this.mode = 'update';
                this.activated = true;
                console.info("Edit Called")
            },
            deleteComment(){
                console.info("delete called");
                this.$store.dispatch('comments/deleteComment', this.comment.id)
                    .then(res=>{
                        this.id_deleted = true;
                    })


            }
        },

    }
</script>

<style scoped>
    textarea {height: 40px; background: #f1f3f6;}
    .active textarea {height: 100px; background: transparent;}
</style>
