<template>
    <div>
        <router-view v-on:handle-page-header="handlePageHeader" ref="myChild"></router-view>
        <div v-if="$route.name == 'tickets'" class="row projects">
            <template v-for="row in tickets">
                <div class="col-md-12">
                    <div class="hpanel hgreen">
                        <div class="panel-body">
                            <div class="row">
                                <div class="col-sm-8">
                                    <h4>
                                        <router-link v-bind:to="{'name': 'ticket-detail', params: {'id': row.id }}" active-class="" class="">
                                            {{ row.title }}
                                        </router-link>
                                    </h4>


                                    <p>
                                        {{ row.description}}
                                    </p>

                                    <div class="row">
                                        <div class="col-sm-4">
                                            <div class="project-label">DEDLINE</div>
                                            <small>{{ row.end_date }}</small>
                                        </div>
                                        <div class="col-sm-4">
                                            <div class="project-label">Assigned To</div>
                                            <small v-if="row.assigned_to">{{ row.assigned_to.name }}</small>
                                        </div>
                                        <div class="col-sm-4">
                                            <div class="project-label">Created By</div>
                                            <small v-if="row.created_by">{{ row.created_by.name }}</small>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-4 project-info">
                                    <div class="project-action m-t-md">
                                        <div class="btn-group">
                                            <button class="btn btn-xs btn-default"> View</button>
                                            <button class="btn btn-xs btn-default"> Edit</button>
                                            <button class="btn btn-xs btn-default"> Delete</button>
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
                        </div>
                    </div>
                </div>
            </template>
        </div>
    </div>
</template>

<script>
    export default {
        name: "ticket-index",
        data(){
            return {
                myRoute : {},
                tickets : [],
                current_page: 1,
                totalPages : 0
            }
        },
        mounted(){
            this.$emit('handle-page-header', {label:'Tickets', desc:'List of tickets'});
            this.myRoute = this.$router.options.routes.find(route => route.name === this.$route.name);
            if(this.$route.name == 'tickets')
                this.projects = this.getTickets();
        },
        methods:{
            handlePageHeader: function(data){
                this.$emit('handle-page-header', data);
            },
            getTickets: function (data) {
                axios.get(this.$settings.APIURL+"/tickets")
                    .then(response => {
                        let res = response.data;
                        this.tickets = res.data;
                    });
            }
        }
    }
</script>

<style scoped>

</style>
