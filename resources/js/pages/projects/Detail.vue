<template>
    <div>
        <vue-title :title="project.name"></vue-title>
        <div class="row projects">

            <div class="col-md-12">
                <!-- Nav tabs -->
                <div class="">
                <ul class="tabs" role="tablist">
                    <li role="presentation"><a href="javascript:void(0)" aria-controls="summary" role="tab" data-toggle="tab">Summary</a></li>
                    <li role="presentation"><a href="javascript:void(0)" aria-controls="tickets" role="tab" data-toggle="tab">Tickets</a></li>
                    <li role="presentation" class="active"><a href="javascript:void(0)" aria-controls="time" role="tab" data-toggle="tab">Time</a></li>
                </ul>

                <!-- Tab panes -->
                <div class="tab-content">
                    <div role="tabpanel" class="tab-pane" id="summary">
                        Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.
                    </div>
                    <div role="tabpanel" class="tab-pane" id="tickets">
                        <div class="col-md-12" style="display: none;">
                            <vue-panel
                                id="project"
                                :title="project.name"
                                tools="1"
                            >{{ project.description }}</vue-panel>
                        </div>
                        <div class="col-md-12">
                            <div class="list-options">
                                <h2 class="">Tickets</h2>
                                <div class="btn-options text-right">
                                    <button class="btn btn-md btn-primary" @click="addTicket">Add Ticket</button>
                                </div>
                            </div>

                        </div>
                    </div>
                    <div role="tabpanel" class="tab-pane" id="time">
                        Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.
                    </div>
                </div>
            </div>
                <div class="panel forum-box">
                    <div class="panel-body">
                        <Ticket v-if="showAddTicket"
                            :ticket="blankTicket" :view="!showAddTicket"
                        ></Ticket>
                        <template v-if="tickets.length > 0">
                            <template v-for="row in tickets">
                                <Ticket
                                    :ticket="row"
                                    :list=ticketList
                                ></Ticket>
                            </template>
                        </template>
                        <template v-else>
                            <p v-if="!showAddTicket" class="text-center">
                                <button class="btn btn-xs btn-secondary" @click="addTicket">Add Ticket</button>
                            </p>
                        </template>

                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    import Ticket from '../../components/util/Ticket';

    export default {
        name: "project-detail",
        data(){
            return {
                myRoute : {},
                project_id : this.$route.params.id,
                project: {},
                tickets: [],
                ticketList: true,
                showAddTicket: false,
                blankTicket: {
                    project: {id:this.$route.params.id},
                    title: '', description: '',
                    assigned_to: {id:'', name: ''}
                }
            }
        },
        watch: {
            project: function(val) {
                this.$emit('handle-page-header', {label:val.name, tools:[{'icon': 'fa-pen',
                        'event':(val)=>{
                            this.editProjct(val);
                        },
                        'id': val.id
                }]});
            }
        },
        components: {
            Ticket
        },
        mounted(){
            this.getProject(this.project_id);
            this.getTickets(this.project_id);
            this.myRoute = this.$router.options.routes.find(route => route.name === this.$route.name);
        },
        methods:{
            handlePageHeader: function(data){
                this.$emit('handle-page-header', data);
            },
            getProject: function (id) {
                axios.get("/project/"+id)
                    .then(response => {
                        let res = response.data;
                        this.project = res;
                    });
            },
            addTicket: function(){
              this.showAddTicket = true;
            },
            getTickets: function (id, data) {
                axios.get("/project/tickets/"+id)
                    .then(response => {
                        let res = response.data;
                        this.tickets = res.data;
                    });
            },
            editProjct: function (id) {
                console.log(id);
            }
        },
        beforeRouteUpdate (to, from, next) {
            this.project_id = to.params.id;
            this.getProject(this.project_id);
            this.getTickets(this.project_id);
            next();
        }
    }
</script>

<style scoped>
h5{font-size: 14px;}
</style>
