<template>
    <div class="ticket-wrapper" :id="'ticket_'+ticket.id" v-if="!is_deleted">
        <div v-if="mode == 'view'">
            <div class="ticket-row">
                <div class="ticket-controls">
                    <a href="javascript:void(0);" class="edit" v-on:click="editTicket"><i class="fa fa-pencil-alt"></i></a> &nbsp;
                    <a href="javascript:void(0);" class="delete" v-on:click="deleteTicket"><i class="fa fa-trash-alt"></i></a>
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
        <div class="ticket-edit" v-else>
            <div class="ticket-row">
                <div class="ticket-controls">
                    <a href="javascript:void(0);" class="edit" v-on:click="editTicket"><i class="fa fa-pencil-alt"></i></a> &nbsp;
                    <a href="javascript:void(0);" class="delete" v-on:click="deleteTicket"><i class="fa fa-trash-alt"></i></a>
                </div>
                <div class="ticket-heading">
                    <!--<div class="assignedto">
                        <span class="">{{ ticket.assigned_to.name }}</span>
                    </div>
                    -->
                    <div class="ticket-title">
                        <input type="text" class="form-control input-sm" :value="ticket.title">
                    </div>
                </div>
            </div>
            <div class="ticket-description" >
                <div class="ticket-desc">
                    <div class="hpanel">
                        <ul class="nav nav-tabs">
                            <li class="nav-item"><a data-toggle="tab" :href="'#tab-'+ticket.id+'-1'" class="nav-link active" v-b-tooltip.hover title="Who & When?"><i class="fa fa-user"></i></a></li>
                            <li class="nav-item"><a data-toggle="tab" :href="'#tab-'+ticket.id+'-2'"  class="nav-link" v-b-tooltip.hover title="Description"><i class="fa fa-align-left"></i></a></li>
                        </ul>
                        <div class="tab-content">
                            <div :id="'tab-'+ticket.id+'-1'" class="tab-pane active">
                                <div class="panel-body">
                                    <div class="row">
                                        <div class="col-md-9 col-lg-7">
                                            <div class="row">
                                                <div class="col">
                                                    <div class="form-group">
                                                        <label class="control-label">Assigned to</label>
                                                        <input type="text" placeholder="Default input" class="form-control m-b">
                                                    </div>


                                                </div>
                                                <div class="col">
                                                    <div class="form-group">
                                                        <label class="control-label">Start Date</label>
                                                        <input type="text" placeholder="Default input" class="form-control m-b">
                                                    </div>


                                                </div>
                                                <div class="col">
                                                    <div class="form-group">
                                                        <label class="control-label">End Date</label>
                                                        <input type="text" placeholder="Default input" class="form-control m-b">
                                                    </div>


                                                </div>
                                            </div>

                                        </div>

                                    </div>
                                </div>
                            </div>
                            <div :id="'tab-'+ticket.id+'-2'" class="tab-pane">
                                <div class="panel-body">
                                    <textarea name="comments" class="form-control" placeholder="Provide a detailed description for this task (optional)"> {{ ticket.description }}</textarea>
                                </div>
                            </div>
                        </div>
                    </div>
                    <button class="btn btn-primary" type="button" v-on:click="saveTicket()" >Save Changes</button> or
                    <button class="btn w-xs btn-link"  type="button" v-on:click="resetTicket()">Cancel</button>
                </div>

            </div>
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
                is_deleted: false,
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
            editTicket(){
                this.mode = 'update';
                this.activated = true;
                console.info("Edit Called")
            },
            deleteTicket(){
                this.$swal(
                    {
                        title: 'Are you sure?',
                        text: "You won't be able to revert this!",
                        type: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#3085d6',
                        cancelButtonColor: '#d33',
                        confirmButtonText: 'Yes, delete it!'
                    }).then((result) => {
                        if (result.value) {
                            this.$store.dispatch('tickets/deleteTicket', this.ticket.id)
                                .then(res=>{
                                    this.is_deleted = true;
                                    if (!this.is_list) //redirect to ticket list
                                        this.$router.push({ name: 'tickets', query: { } });
                                })
                                .catch(exp=>{
                                    this.$emit('handle-exception', exp);
                                })
                        }
                    }
                );
            }
        },

    }
</script>

<style scoped>
    textarea {height: 40px; background: #f1f3f6;}
    .active textarea {height: 100px; background: transparent;}
</style>
