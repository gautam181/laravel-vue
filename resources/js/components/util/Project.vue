<template>
    <div class="col-md-12" :id="'ticket_'+project.id">
        <div class="hpanel hgreen">
            <div class="panel-body">
                <div class="row" v-if="!project.edit">
                    <div class="col-sm-8 col-md-10">
                        <h5>
                            <router-link v-bind:to="{'name': 'ticket-detail', params: {'id': project.id }}" active-class="" class="">
                                {{ project.title }}
                            </router-link>
                        </h5>
                        <p>
                            {{ project.description}}
                        </p>

                        <div class="row">
                            <div class="col-sm-4">
                                <div class="project-label">DEADLINE</div>
                                <small>{{ project.end_date }}</small>
                            </div>
                            <div class="col-sm-4">
                                <div class="project-label">Assigned To</div>
                                <small v-if="project.assigned_to">{{ project.assigned_to.name }}</small>
                            </div>
                            <div class="col-sm-4">
                                <div class="project-label">Created By</div>
                                <small v-if="project.created_by">{{ project.created_by.name }}</small>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-4 col-md-2 project-info">
                        <div class="project-action m-t-md">
                            <div class="btn-group">
                                <router-link v-bind:to="{'name': 'ticket-detail', params: {'id': project.id }}" active-class="" class="btn btn-xs btn-default">
                                    View
                                </router-link>
                                <button class="btn btn-xs btn-default" v-on:click="editTicket(project.id)"> Edit</button>
                                <button class="btn btn-xs btn-default" v-on:click="deleteTicket(project.id)"> Delete</button>
                            </div>
                        </div>
                        <div class="project-value">
                            <h2 class="text-success">
                                TotalHours
                            </h2>
                        </div>
                        <div class="project-people">
                            <!--<img alt="logo" class="img-circle" src="images/a1.jpg">-->
                        </div>
                    </div>
                </div>
                <div class="row" v-if="project.edit">

                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        name: "Project",
        props: ['project','view'],
        data: function(){
            return {
                mode: this.view ? 'view': 'from',
                id_deleted: false
            }
        },
        watch: {
            comment: function(val){
                this.comment_body = this.comment.comment;
            }
        },
        mounted(){
            //console.log(this.ticket, this.author_id);
        },
        methods: {
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
