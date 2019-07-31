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
                    <form action="">
                        <div v-if="mode == 'update'">
                            <textarea name="comments" v-model="comment_body" class="form-control" placeholder="add your comments"> {{ comment_body }}</textarea>
                            <div class="hr-line-dashed"></div>
                            <button class="btn btn-primary" type="button" v-on:click="saveComment()" :disabled="comment_body.length < 1">Save Comment</button> or
                            <button class="btn w-xs btn-link"  type="button" v-on:onclick="resetComment()">Cancel</button>
                        </div>
                        <div class="formatted-comment" v-else="">
                            {{ comment_body }}
                        </div>
                    </form>
                </div>
                <div class="media-info pull-right" v-if="mode == 'view'">
                    <span v-bind:title="comment_updated_at">{{ comment_updated_at | moment("from", "now") }}</span>
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
        name: "CommentForm",
        props: ['author', 'comment', 'ticket', 'edit'],
        data(){
            return {
                author_id: this.author.id,
                ticket_id: this.ticket.id,
                project_id: this.ticket.project_id,
                comment_body: this.comment.body,
                comment_id: this.comment.id,
                comment_updated_at : this.comment.updated_at,
                mode: this.edit ? 'update': 'view'
            }
        },
        methods: {
            saveComment: function () {
                axios({
                    method: this.comment_id ? 'put' : 'post',
                    url: this.$settings.APIURL+'/comment'+(this.comment_id ? '/'+this.comment_id : ''),
                    data: {
                        author_id: this.author_id,
                        ticket_id: this.ticket_id,
                        project_id: this.project_id,
                        comment: this.comment_body
                    }
                }).
                then(function (response) {
                    console.log(response);
                });
            },
            resetComment: function () {
                console.log('reset comment');
                this.comment_body = '';
            }
        },

    }
</script>

<style scoped>

</style>
