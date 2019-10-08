<template xmlns="http://www.w3.org/1999/html">
    <div>
        <vue-title :title="project.name"></vue-title>
        <div class="row">
            <div class="col-md-12">
                <div class="list-options">
                    <h2 class="">Summary</h2>
                </div>
            </div>
            <div class="col-md-6 summary-row" v-if="summary.tickets">
                <div class="row">
                    <div class="col-sm-12">
                        <h3>Tasks</h3>
                    </div>

                </div>
                <div class="row">
                    <div class="col-md-6" v-if="my_tasks">
                        <div class="summary-col section-holder has-settings tasks">
                            <div class="summary-col mini-chart" style="">
                                <h4>Mine</h4>

                                <ul class="lhs chart-legend">
                                    <summary-legend label="Late" color="late" :value="my_tasks.late"></summary-legend>
<!--                                    <summary-legend label="Started" class="started" :value="my_tasks.started"></summary-legend>-->
                                    <summary-legend label="Today" color="today" :value="my_tasks.today"></summary-legend>
                                    <summary-legend label="Upcoming" color="upcoming" :value="my_tasks.upcoming"></summary-legend>
                                    <summary-legend label="Nodate" color="nodate" :value="my_tasks.nodate"></summary-legend>
                                </ul>
                            </div>
                            <!-- /ko -->
                        </div>
                    </div>
                    <div class="col-md-6" v-if="all_tasks">
                        <div class="summary-col section-holder has-settings tasks">
                            <div class="summary-col mini-chart" style="">
                                <h4>All</h4>

                                <ul class="lhs chart-legend">
                                    <summary-legend label="Late" color="late" :value="all_tasks.late"></summary-legend>
                                    <!--                                    <summary-legend label="Started" class="started" :value="my_tasks.started"></summary-legend>-->
                                    <summary-legend label="Today" color="today" :value="all_tasks.today"></summary-legend>
                                    <summary-legend label="Upcoming" color="upcoming" :value="all_tasks.upcoming"></summary-legend>
                                    <summary-legend label="Nodate" color="nodate" :value="all_tasks.nodate"></summary-legend>
                                </ul>
                            </div>
                            <!-- /ko -->
                        </div>
                    </div>
                </div>

            </div>
            <div class="col-md-6 summary-row" v-if="summary.time">
                <div class="row">
                    <div class="col-sm-12">
                        <h3>Time</h3>
                    </div>

                </div>
                <div class="row">
                    <div class="col-md-6" v-if="time.logged">
                        <div class="summary-col">
                            <div class="summary-col mini-chart" style="">
                                <h4>
                                    Logged Time
                                </h4>

                                <ul class="lhs chart-legend">
                                    <li :class="{'mine': true,  'empty': time.logged.mine == 0}" >
                                        <i class="fa fa-square"></i>
                                        <label>Mine</label> <span>{{ time.logged.mine | min2hours }}</span>
                                    </li>
                                    <li :class="{'others': true, 'empty': time.logged.everyone == 0 }">
                                        <i class="fa fa-circle"></i>
                                        <label>Total</label> <span>{{ time.logged.everyone | min2hours }}</span>
                                    </li>
                                </ul>
                            </div>
                            <!-- /ko -->
                        </div>
                    </div>
                    <div class="col-md-6" v-if="time.breakdown">
                        <div class="summary-col">
                            <div class="summary-col mini-chart" style="">
                                <h4>BreakDown</h4>

                                <ul class="lhs chart-legend">
                                    <template v-for="row in time.breakdown">
                                        <li class="">
                                            <i class="fa fa-check-circle"></i>
                                            <label>{{ row.user.name }}</label> <span>{{ row.minutes | min2hours }}</span>
                                        </li>
                                    </template>

                                </ul>
                            </div>
                            <!-- /ko -->
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
</template>

<script>
    import SummaryLegend from "../../components/ui/SummaryLegend";

    export default {
        name: "project-summary",
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
        created(){
            this.$root.$emit('project-info', this.project_id);
            this.getSummary();
        },
        computed: {
            summary:{
                get() { return this.$store.getters['projects/getSummary']; },
                set(value) { this.$store.commit('projects/setSummary', value); },
            },
            time() {
                return this.summary.time;
            },
            my_tasks() {
                return this.summary.tickets.mine;
            },
            all_tasks() {
                return this.summary.tickets.everyone;
            }
        },
        components: {
            SummaryLegend
        },
        mounted(){

        },
        methods:{
            handlePageHeader: function(data){
                this.$emit('handle-page-header', data);
            },
            getSummary(){
                this.$store.dispatch('projects/getSummary', this.project_id)
                    .then(response =>{

                    });
            }
        },
        beforeRouteUpdate (to, from, next) {
            next();
        }
    }
</script>

<style scoped>
h5{font-size: 14px;}
</style>
