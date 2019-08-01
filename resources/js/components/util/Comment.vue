<template>
    <div v-bind:class="{'hpanel forum-box' : mode == 'update'}">
        <div class="panel-body">
            <div class="media">
                <div class="media-author pull-left">
                    <div class="author-info">
                        <p class="author-name" v-bind:title="author.name">{{ author.name }} </p>
                    </div>
                </div>
                <div class="media-body">
                    <form action="" >
                        <div v-if="mode == 'update'" v-bind:class="{active: activated}">
                            <textarea name="comments" v-model="comment_body" v-on:click.self="enableComment()" class="form-control" placeholder="add your comments"> {{ comment_body }}</textarea>
                            <div v-if="activated">
                                <div class="hr-line-dashed"></div>
                                <button class="btn btn-primary" type="button" v-on:click="saveComment()" :disabled="comment_body.length < 1">Save Comment</button> or
                                <button class="btn w-xs btn-link"  type="button" v-on:click="resetComment()">Cancel</button>
                            </div>

                        </div>
                        <div class="formatted-comment" v-else="">
                            {{ comment_body }}
                        </div>
                    </form>
                </div>
                <div class="media-info pull-right" v-if="mode == 'view'">
                    <span v-bind:title="comment.updated_at">{{ comment.updated_at | moment("from", "now") }}</span>
                    <button class="btn btn-default dropdown" data-toggle="dropdown" type="button" aria-expanded="false"><i class="fas fa-ellipsis-v"></i></button>
                    <div class="dropdown-menu dropdown-menu-right">
                        <a href="" class="dropdown-item">Edit</a>
                        <a href="" class="dropdown-item">Delete</a>
                    </div>
                </div>
            </div>

        </div>
    </div>
</template>

<script>
    export default {
        name: "Comment",
        props: ['author', 'comment', 'ticket', 'edit'],
        data: function(){
            return {
                mode: this.edit ? 'update': 'view',
                comment_body: this.comment.comment,
                activated: false
            }
        },
        mounted(){
            //console.log(this.ticket, this.author_id);
        },
        methods: {
            saveComment: function () {
                axios({
                    method: this.comment.id ? 'put' : 'post',
                    url: this.$settings.APIURL+'/comment'+(this.comment.id ? '/'+this.comment.id : ''),
                    data: {
                        author_id: this.author.id,
                        ticket_id: this.ticket.id,
                        project_id: this.ticket.project_id,
                        comment: this.comment_body
                    }
                }).
                then(function (response) {
                    console.log(response);
                });
            },
            resetComment: function () {
                this.comment_body = "";
                this.activated = false;
            },
            enableComment(){
                this.activated = true;
            }
        },

    }
</script>

<style scoped>
    textarea {height: 40px; background: #f1f3f6;}
    .active textarea {height: 100px; background: transparent;}
</style>
