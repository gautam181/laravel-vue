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
                    <div class="assignedto" v-if="ticket.assigned_to">
                        <span class="">{{ ticket.assigned_to.name }}</span>
                    </div>
                    <div class="ticket-title">
                        <p class="ticket-name">
                            <router-link v-bind:to="{'name': 'ticket-detail', params: {'id': ticket.id }}" v-if="is_list" active-class="" class="">{{ ticket.title }}</router-link>
                            <span v-else>{{ ticket.title }}</span>
                        </p>
                        <div class="ticket-options">
                            <span class="ticket-more" v-if="is_list">
                                <a href="javascript:void(0);" class="btn btn-xs btn-link" v-on:click="showDesc">{{ more_desc }} ....</a>
                            </span>
                            <span class="ticket-dates">
                                <date-range @update="updateValues" :dates="dateRange">

                                </date-range>
                            </span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="ticket-description" >
                <div class="ticket-desc" v-if="show_desc" v-html="ticket.description">
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
                    <div class="ticket-title">
                        <input type="text" class="form-control input-sm" v-model="ticket_detail.title">
                    </div>
                </div>
            </div>
            <div class="ticket-description" >
                <div class="ticket-desc">
                    <div class="hpanel">
                        <ul class="nav nav-tabs">
                            <li class="nav-item"><a data-toggle="tab" :href="'#tab-'+ticket_detail.id+'-1'" class="nav-link active" v-b-tooltip.hover title="Who & When?"><i class="fa fa-user"></i></a></li>
                            <li class="nav-item"><a data-toggle="tab" :href="'#tab-'+ticket_detail.id+'-2'"  class="nav-link" v-b-tooltip.hover title="Description"><i class="fa fa-align-left"></i></a></li>
                        </ul>
                        <div class="tab-content">
                            <div :id="'tab-'+ticket_detail.id+'-1'" class="tab-pane active">
                                <div class="panel-body">
                                    <div class="row">
                                        <div class="col-md-9 col-lg-7">
                                            <div class="row">
                                                <div class="col">
                                                    <div class="form-group">
                                                        <label class="control-label">Assigned to</label>
                                                        <v-select
                                                            v-model="ticket_detail.assigned_to"
                                                            label="name"
                                                            :options="users"
                                                        ></v-select>
                                                    </div>
                                                </div>
                                                <div class="col">
                                                    <div class="form-group">
                                                        <label class="control-label">Start Date</label>
                                                        <date-picker lang="en" v-model="ticket_detail.start_date" type="date" :format="date_format" input-class="form-control"></date-picker>
                                                    </div>
                                                </div>
                                                <div class="col">
                                                    <div class="form-group">
                                                        <label class="control-label">End Date</label>
                                                        <date-picker lang="en" v-model="ticket_detail.end_date" :format="date_format" input-class="form-control"></date-picker>
                                                    </div>
                                                </div>
                                            </div>

                                        </div>

                                    </div>
                                </div>
                            </div>
                            <div :id="'tab-'+ticket_detail.id+'-2'" class="tab-pane">
                                <div class="panel-body">
                                    <textarea name="comments" v-model="ticket_detail.description" class="form-control" placeholder="Provide a detailed description for this task (optional)"></textarea>
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
    import DateRange from './DateRange';
    import { cloneDeep } from 'lodash'
    export default {
        inheritAttrs: false,
        name: "Ticket",
        /*model: {
            prop: 'ticket',
            event: 'update',
        },*/
        props: {
            'ticket': {type: Object},
            'view': {type: Boolean, default: true},
            'desc': {type: Boolean, default: false},
            'list': {type: Boolean, default: false},
            'add' : {type: Boolean, default: false}
        },
        data(){
            let data = {
                mode: this.view == true ? 'view': 'form',
                is_deleted: false,
                is_list: this.list,
                show_desc: this.desc,
                more_desc: this.desc ? 'less': 'more',
                view_desc: this.desc ? 'Hide': 'Show',
                date_format: this.$settings.DATEFROMAT,
                ranges: true,
                auto_apply: false,
                singleDatePicker: false,
                linkedCalendars: true,
                is_deleted: false,
                ticket_detail: cloneDeep(this.ticket)
            };
            return data
        },
        components:{
            DateRange
        },
        computed:{
            dateRange(){
                return {
                    startDate: this.ticket.start_date,
                    endDate: this.ticket.end_date
                }
            },
            users(){
                return this.$store.getters['users/getUsersList'];
            }
        },
        watch: {
            show_desc: function(val){
                this.view_desc =  val ? 'Hide' : 'Show'
                this.more_desc =  this.show_desc ? 'less' : 'more'
            },
            ticket:function (val) {
                this.ticket_detail = cloneDeep(val);
            }
        },
        mounted(){
            //console.log(this.ticket, this.author_id);
        },
        methods: {
            updateValues (values){
                let dates = {id:this.ticket.id, 'start_date':values.startDate, 'end_date':values.endDate };
                this.$store.dispatch('tickets/updateDates', {id:this.ticket.id, body: dates})
                    .then(res => {
                        this.$store.commit('tickets/setDates', dates);
                    });
            },
            showDesc: function(){
                this.show_desc = !this.show_desc;
            },
            saveTicket: function () {
                this.$store.dispatch('tickets/saveTicket', {
                    id: this.ticket_detail.id,
                    body: {
                        id: this.ticket_detail.id,
                        title: this.ticket_detail.title,
                        description: this.ticket_detail.description,
                        assigned_to: this.ticket_detail.assigned_to.id,
                        start_date: this.ticket_detail.start_date,
                        end_date: this.ticket_detail.end_date,
                        project_id: this.ticket_detail.project.id
                    }
                })
                    .then(response => {
                        this.activated = false;
                        if(this.add=== false){
                            this.mode = 'view';
                        }
                        else {
                            // reset the from.
                        }
                        this.$store.commit('tickets/setTicket', this.ticket_detail);
                        this.$emit('ticketUpdate', response);
                    })
                    .catch(error => {
                        console.log(error);
                    });
            },
            resetTicket: function () {
                this.mode = 'view';
                this.ticket_detail = cloneDeep(this.ticket);
            },
            enableComment(){
                this.activated = true;
            },
            editTicket(){
                this.$store.dispatch('users/getUsersList');
                this.mode = 'update';
                this.activated = true;
                this.ticket_detail = cloneDeep(this.ticket);
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
