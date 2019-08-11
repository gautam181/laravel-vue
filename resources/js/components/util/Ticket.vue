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
                                <a href="javascript:void(0);" class="btn btn-xs" v-on:click="showDesc">{{ more_desc }} ....</a>
                            </span>
                            <span class="ticket-dates">
                                <date-picker @update="updateValues" :dates="dateRange">
                                    <div slot="input" slot-scope="ticket">
                                        {{ dateRange.startDate | date }} - {{ dateRange.endDate | date }}
                                    </div>
                                </date-picker>
                                (
                                <span class="start_date" v-if="ticket.start_date">Start on: {{ ticket.start_date | date }}</span>
                                <i class="fa fa-arrows-alt-h"></i>
                                <span class="end_date" v-if="ticket.end_date">End on: {{ ticket.end_date | date }}</span>
                                )
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
                        <input type="text" class="form-control input-sm" v-model="tmpTicket.title">
                    </div>
                </div>
            </div>
            <div class="ticket-description" >
                <div class="ticket-desc">
                    <div class="hpanel">
                        <ul class="nav nav-tabs">
                            <li class="nav-item"><a data-toggle="tab" :href="'#tab-'+tmpTicket.id+'-1'" class="nav-link active" v-b-tooltip.hover title="Who & When?"><i class="fa fa-user"></i></a></li>
                            <li class="nav-item"><a data-toggle="tab" :href="'#tab-'+tmpTicket.id+'-2'"  class="nav-link" v-b-tooltip.hover title="Description"><i class="fa fa-align-left"></i></a></li>
                        </ul>
                        <div class="tab-content">
                            <div :id="'tab-'+tmpTicket.id+'-1'" class="tab-pane active">
                                <div class="panel-body">
                                    <div class="row">
                                        <div class="col-md-9 col-lg-7">
                                            <div class="row">
                                                <div class="col">
                                                    <div class="form-group">
                                                        <label class="control-label">Assigned to</label>
                                                        <v-select
                                                            v-model="tmpTicket.assigned_to"
                                                            label="name"
                                                            :options="users"
                                                        ></v-select>
                                                    </div>
                                                </div>
                                                <div class="col">
                                                    <div class="form-group">
                                                        <label class="control-label">Start Date</label>
                                                        <date-picker lang="en" v-model="tmpTicket.start_date" type="date" :format="date_format" input-class="form-control"></date-picker>
                                                    </div>
                                                </div>
                                                <div class="col">
                                                    <div class="form-group">
                                                        <label class="control-label">End Date</label>
                                                        <date-picker lang="en" v-model="tmpTicket.end_date" :format="date_format" input-class="form-control"></date-picker>
                                                    </div>
                                                </div>
                                            </div>

                                        </div>

                                    </div>
                                </div>
                            </div>
                            <div :id="'tab-'+tmpTicket.id+'-2'" class="tab-pane">
                                <div class="panel-body">
                                    <textarea name="comments" v-model="tmpTicket.description" class="form-control" placeholder="Provide a detailed description for this task (optional)"></textarea>
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
    import DatePicker from './DatePicker';
    export default {
        name: "Ticket",
        props: {
            'ticket': Object,
            'view': {type: Boolean, default: true},
            'desc': {type: Boolean, default: false},
            'list': {type: Boolean, default: false},
            'add' : {type: Boolean, default: false}
        },
        data: function(){
            return {
                mode: this.view == true ? 'view': 'from',
                is_deleted: false,
                is_list: this.list,
                show_desc: this.desc,
                more_desc: this.desc ? 'less': 'more',
                view_desc: this.desc ? 'Hide': 'Show',
                tmpTicket: this.ticket,
                date_format: this.$settings.DATEFROMAT,
                ranges: true,
                auto_apply: false,
                singleDatePicker: false,
                linkedCalendars: true
            }
        },
        components:{
            DatePicker
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
            ticket: function(val){
              this.tmpTicket = val;
            },
            show_desc: function(val){
                this.view_desc =  val ? 'Hide' : 'Show'
                this.more_desc =  this.show_desc ? 'less' : 'more'
            }
        },
        mounted(){

            //console.log(this.ticket, this.author_id);
        },
        methods: {
            updateValues (values) {
                this.$store.dispatch('tickets/updateDates', {id:this.tmpTicket.id, body: {'start_date':values.startDate, 'end_date':values.endDate }});
                console.log('event: update', values)
            },
            showDesc: function(){
                this.show_desc = !this.show_desc;
            },
            saveTicket: function () {
                this.$store.dispatch('tickets/saveTicket', {
                    id: this.tmpTicket.id,
                    body: {
                        id: this.tmpTicket.id,
                        title: this.tmpTicket.title,
                        description: this.tmpTicket.description,
                        assigned_to: this.tmpTicket.assigned_to.id,
                        start_date: this.tmpTicket.start_date,
                        end_date: this.tmpTicket.end_date
                    }
                })
                    .then(response => {
                        this.activated = false;
                        if(this.add=== false)
                            this.mode = 'view';
                        else {
                            // reset the from.
                        }
                        this.$emit('ticketUpdate', response);
                    })
                    .catch(error => {
                        console.log(error);
                    });
            },
            resetTicket: function () {
                this.mode = 'view';

                this.tmpTicket = this.ticket;
            },
            enableComment(){
                this.activated = true;
            },
            editTicket(){
                this.$store.dispatch('users/getUsersList');
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
