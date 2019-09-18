<template>
    <div>
        <vue-title v-if="ticket" :title="ticket.title+ ' - '+ ticket.project.name"></vue-title>
        <div class="row">
            <div class="col-md-12">
                <div class="list-options">
                    <h2 class="">Ticket Detail</h2>
                </div>

            </div>
            <div class="col-md-12">
                <div class="hpanel">
                    <div class="panel-body pb-3" v-if="ticket">
                        <Ticket
                            :ticket="ticket"
                            :desc="desc"
                        ></Ticket>
                    </div>
                </div>
            </div>
            <div class="col-md-12">
                <div class="list-options">
                    <h2 class="">Files</h2>
                </div>
            </div>
            <div class="col-md-12">
                <div class="hpanel">
                    <div class="panel-body pb-3">
                        <template v-for="file in files">
                            <div class="file-upload-row">
                                <a href="#" class="upload-cancel" @click.prevent="file.active ? $refs.upload.update(file, {error: 'cancel'}) : false"><i class="fa fa-times text-danger fa-2x"></i></a>
                                <div class="filename">
                                    {{file.name}}
                                </div>
                                <div class="progress" v-if="file.active || file.progress !== '0.00'">
                                    <div :class="{'progress-bar': true, 'progress-bar-striped': true, 'bg-danger': file.error, 'progress-bar-animated': file.active}" role="progressbar" :style="{width: file.progress + '%'}">{{file.progress}}%</div>
                                </div>
                            </div>

                        </template>
                        <file-list :files="ticketFiles" @edit-file="fileEdit"></file-list>
                        <div>
                            <br>
                            <a href="javascript:void(0);" class="text-green"> Manage Attachments</a>
                        </div>
                        <file-upload
                            class="btn btn-primary d-none"
                            :post-action="upload_url"
                            :multiple="true"
                            :drop="true"
                            :headers="headers"
                            :drop-directory="false"
                            v-model="files"
                            :data="{'ticket_id': ticket_id, 'project_id': ticket.project_id, 'description': ''}"
                            @input="inputUpdate"
                            @input-file="inputFile"
                            ref="upload">
                        </file-upload>
                        <div v-show="$refs.upload && $refs.upload.dropActive" class="drop-active">
                            <h3>Drop files to upload</h3>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-12">
                <div class="list-options">
                    <h2 class="">Time Log</h2>
                </div>

            </div>
            <div class="col-md-12">
                <div class="hpanel">
                    <div class="panel-body pb-3">
                        <div v-if="time_entries.length > 0">
                            <div class="total-filter">
                                <div class="section">
                                    <strong>Time Totals: </strong>
                                </div>
                                <div class="section">
                                    <span class="text-muted">Logged:</span>
                                    <span>{{ getTotalHours() }}</span>
                                </div>
                                <div class="section">
                                    <span class="text-muted">Estimated:</span>
                                    <span>10 hours (10.00)</span>
                                </div>
                                <div class="action-btns">
                                    <button name="add-time" class="btn btn-sm btn-success" @click="addTime"> <i class="fa fa-plus"></i> Add More Time</button>
                                </div>
                            </div>
                            <time-list :time_entries="time_entries"></time-list>
                            <a href="javascript:void(0);" class="text-green" @click="addTime">Add more time</a>
                        </div>
                        <p v-else>No time have been logged against this ticket - <a href="javascript:void(0);" @click="addTime">Log time</a></p>
                        <time-form :id="ticket.id" v-if="time_form" :project_id="ticket.project.id" :ticket="ticket"></time-form>
                    </div>
                </div>
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
                <Comment v-on:commentUpdate="commentUpdate"
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
    import Ticket from "../../components/util/Ticket";
    import {mapGetters} from 'vuex';
    import TimeForm from "./forms/TimeForm";
    import FileList from "../../components/ui/FileList";
    import TimeList from "../../components/ui/TimeList";

    export default {
        name: "ticket-detail",
        data(){
            return {
                myRoute : {},
                ticket_id : this.$route.params.ticket_id,
                order_by: 'date',
                add_comment: {comment:'', id:''},
                desc: true,
                time_form: false,
                file_form: false,
                upload_url: this.$settings.APIURL+'/files',
                files: [],
                headers: this.$ajaxHeader,
                /*ticketFiles: [
                    {
                        id: 1,
                        thumbnail: '',
                        name: 'team-access.png',
                        updated_at: new Date(),
                        size: 120*1024,
                        uploaded_by: {
                            name: 'Abdul Khan'
                        }
                    },
                    {
                        id: 2,
                        thumbnail: '',
                        name: 'team-access-2.png',
                        updated_at: new Date(),
                        size: 120*3*1024,
                        uploaded_by: {
                            name: 'Abdul Khan'
                        }
                    }
                ]*/
            }
        },
        created(){
            //this.$eventBus.$emit('header-update', {label:'ticket detail ...'});
            //this.$eventBus.$emit('project-info', this.project_id);
        },
        computed:{
            ...mapGetters({
                sort: 'tickets/getSortBy',
            }),
            ticketFiles(){
                return this.$store.getters['tickets/getTicketFiles'](this.ticket_id);
            },
            comments(){
                return this.$store.getters['tickets/getTicketComments'](this.ticket_id);
            },
            time_entries(){
                return this.$store.getters['tickets/getTicketTimes'](this.ticket_id);
            },
            ticket(){
                return this.$store.getters['tickets/getTicket'](this.ticket_id);
            },
        },
        components: {
            Comment, Ticket,  TimeForm, FileList, TimeList
        },
        mounted(){
            this.getTicket(this.ticket_id);
            this.getComments(this.ticket_id);
            this.getTimes(this.ticket_id);
            this.getFiles(this.ticket_id);
            this.myRoute = this.$router.options.routes.find(route => route.name === this.$route.name);
            this.$eventBus.$on('timeUpdate', (data)=> {
                console.log(data);
                this.getTimes(this.ticket_id);
            });
            this.$eventBus.$on('fileUpdate', (data)=> {
                console.log(data);
                this.getFiles(this.ticket_id);
            });
            this.$root.$on('bv::modal::hidden', (bvEvent, modalId) => {
                if (modalId == 'time-form')
                    this.time_form = false;
                if (modalId == 'file-form')
                    this.file_form = false;
            })
        },
        methods:{
            fileEdit: function(file){
                console.log(file);
            },
            inputUpdate(newFile) {
                this.$refs.upload.active = true;
                if (newFile.xhr) {
                    //  Get the response status code
                    console.log('status', newFile.xhr.status)
                }
            },
            inputFile: function (newFile, oldFile) {
                if (newFile && oldFile && !newFile.active && oldFile.active) {
                    // Get response data
                    console.log('response', newFile.response)
                    if (newFile.xhr) {
                        //  Get the response status code
                        console.log('status', newFile.xhr.status)
                        if (newFile.xhr.status == 200){
                            this.$refs.upload.remove(newFile);
                            this.getFiles(this.ticket_id);
                        }

                    }
                }
            },
            addTime: function(){
                this.time_form = true;
            },
            handlePageHeader: function(data){
                this.$emit('handle-page-header', data);
            },
            getTicket: function (val) {
                this.$store.dispatch('tickets/getTicket', val)
                    .then(res => {
                        this.$eventBus.$emit('project-info', res.project_id);
                    })
            },
            changeCommentSort: function(val){
                this.$store.commit('tickets/setSortBy', val)
                this.getComments(this.ticket_id);
            },
            getComments: function (val) {
                this.$store.dispatch('tickets/getTicketComments', val)
            },
            getFiles: function (val) {
                this.$store.dispatch('tickets/getTicketFiles', val)
            },
            getTimes: function (val) {
                this.$store.dispatch('tickets/getTicketTimes', val)
            },

            getHours: function(h, m){
                return ((h*60 + m)/60).toFixed(2);
            },
            getTotalHours: function(){
                let sum = this.time_entries.reduce((s, f) => {
                    return s + (f.hours*60) + f.minutes;
                }, 0);
                let hrs = (sum/60).toFixed(2);
                let m = (sum%60);
                let h = ((sum-m)/60).toFixed(0);
                let ts = '';
                if (h > 0)
                    ts += h + ' hours ';
                if (m > 0)
                    ts += m + ' minutes ';

                ts += ' ('+hrs+')';
                return ts;//{'hours': hrs, 'time': { 'hours': h, 'minutes': m}};
            },
            togglePanel: function (id) {
                $(id).find(".showhide i").toggleClass('fa-chevron-up').toggleClass('fa-chevron-down');
                $(id).find(".panel-body").slideToggle(300);
                $(id).find(".panel-footr").slideToggle(200);
            },
            commentUpdate: function (val) {
                this.getComments(this.ticket_id);
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
    .drop-active {
        top: 0;
        bottom: 0;
        right: 0;
        left: 0;
        position: absolute;
        z-index: 9999;
        opacity: .6;
        text-align: center;
        background: rgba(0,0,0,0.25);
        border-radius: 5px;
    }
    .drop-active h3 {
        margin: -.5em 0 0;
        position: absolute;
        top: 50%;
        left: 0;
        right: 0;
        -webkit-transform: translateY(-50%);
        -ms-transform: translateY(-50%);
        transform: translateY(-50%);
        font-size: 40px;
        color: #505050;
        padding: 0;
    }
</style>
