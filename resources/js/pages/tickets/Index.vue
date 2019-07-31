<template>
    <div>
        <router-view v-on:handle-page-header="handlePageHeader" ref="myChild"></router-view>
        <b-pagination
            v-model="page"
            :total-rows="totalRows"
            :per-page="perPage"
            align="right"
        ></b-pagination>
        <div v-if="$route.name == 'tickets'" class="row projects">
            <template v-for="row in tickets">
                <div class="col-md-12">
                    <div class="hpanel hgreen">
                        <div class="panel-body">
                            <div class="row">
                                <div class="col-sm-8 col-md-10">
                                    <h5>
                                        <router-link v-bind:to="{'name': 'ticket-detail', params: {'id': row.id }}" active-class="" class="">
                                            {{ row.title }}
                                        </router-link>
                                    </h5>


                                    <p>
                                        {{ row.description}}
                                    </p>

                                    <div class="row">
                                        <div class="col-sm-4">
                                            <div class="project-label">DEADLINE</div>
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
                                <div class="col-sm-4 col-md-2 project-info">
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
        <b-pagination
            v-model="page"
            :total-rows="totalRows"
            :per-page="perPage"
            align="right"
        ></b-pagination>
    </div>
</template>

<script>
    export default {
        name: "ticket-index",
        data(){
            return {
                myRoute : {},
                tickets : [],
                page: 1,
                totalPages : 0,
                totalRows : 0,
                perPage: 0
            }
        },
        mounted(){
            this.$emit('handle-page-header', {label:'Tickets', desc:'List of tickets'});
            this.myRoute = this.$router.options.routes.find(route => route.name === this.$route.name);
            if(this.$route.name == 'tickets')
                this.projects = this.getTickets();
        },
        watch:{
            page: function (val) {
                this.getTickets();
            }
        },
        methods:{
            handlePageHeader: function(data){
                this.$emit('handle-page-header', data);
            },
            getTickets: function () {
                let url = this.$settings.APIURL+"/tickets?page="+this.page;

                axios.get(url)
                    .then(response => {
                        let res = response.data;
                        this.tickets = res.data;
                        this.totalPages = res.last_page;
                        this.page = res.current_page;
                        this.perPage = res.per_page;
                        this.totalRows = res.total;
                    });
            }

        }
    }
</script>

<style scoped>

</style>
