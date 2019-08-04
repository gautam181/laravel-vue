<template>
    <div v-bind:class="{'hpanel forum-box' : mode == 'update'}" v-if="!id_deleted">
        <div class="panel-body">
            <div class="media">
                <div class="media-author pull-left">
                    <div class="author-info">
                        <avatar :username="author.name" :size="size"></avatar>
                        <div class="author-name" v-bind:title="author.name" >{{ author.name }} </div>
                    </div>
                </div>
                <div class="media-body">
                    <form action="" >
                        <div v-show="'update'===mode" v-bind:class="{active: activated}">
                            <textarea name="comments" v-model="comment_body" v-on:click.self="enableComment()" class="form-control" placeholder="add your comments"> {{ comment_body }}</textarea>
                            <div v-if="activated">
                                <div class="hr-line-dashed"></div>
                                <button class="btn btn-primary" type="button" v-on:click="saveComment()" :disabled="comment_body.length < 1">Save Comment</button> or
                                <button class="btn w-xs btn-link"  type="button" v-on:click="resetComment()">Cancel</button>
                            </div>

                        </div>
                        <div class="formatted-comment" v-show="'view'===mode">
                            {{ comment_body }}
                        </div>
                    </form>
                </div>
                <div class="media-info pull-right" v-if="'view'===mode">
                    <span v-bind:title="comment.updated_at">{{ comment.updated_at | moment("from", "now") }}</span>
                    <b-dropdown right variant="default" no-caret>
                        <template slot="button-content">
                            <i class="fas fa-ellipsis-v"></i>
                        </template>
                        <b-dropdown-item href="javascript:void(0);" @click="editComment()" >Edit</b-dropdown-item>
                        <b-dropdown-item href="javascript:void(0);" @click="deleteComment()">Delete</b-dropdown-item>
                    </b-dropdown>
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
                activated: false,
                size: 40,
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
                    this.activated = false;
                    if(this.edit=== false)
                        this.mode = 'view';
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
                this.id_deleted = true;
            }
        },

    }
</script>

<style scoped>
    textarea {height: 40px; background: #f1f3f6;}
    .active textarea {height: 100px; background: transparent;}
</style>
