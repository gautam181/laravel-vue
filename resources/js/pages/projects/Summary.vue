<template xmlns="http://www.w3.org/1999/html">
    <div>
        <vue-title :title="project.name"></vue-title>
        <div class="row">
            <div class="col-md-12">
                <div class="list-options">
                    <h2 class="">Summary</h2>
                </div>
            </div>
            <div class="col-md-6 summary-row">
                <div class="row">
                    <div class="col-sm-12">
                        <h3>Tasks</h3>
                    </div>

                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="summary-col section-holder has-settings tasks">
                            <div class="summary-col mini-chart" style="">
                                <h4 data-bind="click: function(){OnQuickView('tasks','anytime',selectedUser.id())}" style="cursor:pointer;">
                                    Mine
                                </h4>

                                <ul class="lhs chart-legend">
                                    <li class="late empty" data-bind="click: function(){OnQuickView('tasks','late',selectedUser.id())}, css:{'empty':summaryStats().tasks.mine.late()==0}">
                                        <i class="fa fa-circle"></i>
                                        <label><!--ko text:app.tl('Late')-->Late<!--/ko--></label> <span>(<!--ko text:summaryStats().tasks.mine.late-->0<!--/ko-->)</span>
                                    </li>
                                    <!-- ko if: showStartedTasks() -->
                                    <li class="started empty" data-bind="click: function(){OnQuickView('tasks','started',selectedUser.id())}, css:{'empty':summaryStats().tasks.mine.started()==0}">
                                        <i class="fa fa-circle"></i>
                                        <label><!--ko text:app.tl('Started')-->Started<!--/ko--></label> <span>(<!--ko text:summaryStats().tasks.mine.started-->0<!--/ko-->)</span>
                                    </li>
                                    <!-- /ko -->
                                    <li class="today empty" data-bind="click: function(){OnQuickView('tasks','today',selectedUser.id())}, css:{'empty':summaryStats().tasks.mine.today()==0}">
                                        <i class="fa fa-circle"></i>
                                        <label><!--ko text:app.tl('Today')-->Today<!--/ko--></label> <span>(<!--ko text:summaryStats().tasks.mine.today-->0<!--/ko-->)</span>
                                    </li>
                                    <li class="upcoming empty" data-bind="click: function(){OnQuickView('tasks','upcoming',selectedUser.id())}, css:{'empty':summaryStats().tasks.mine.upcoming()==0}">
                                        <i class="fa fa-circle"></i>
                                        <label><!--ko text:app.tl('Upcoming')-->Upcoming<!--/ko--></label> <span>(<!--ko text:summaryStats().tasks.mine.upcoming-->0<!--/ko-->)</span>
                                    </li>
                                    <li class="nodate empty" data-bind="click: function(){OnQuickView('tasks','nodate',selectedUser.id())}, css:{'empty':summaryStats().tasks.mine.nodate()==0}">
                                        <i class="fa fa-circle"></i>
                                        <label><!--ko text:app.tl('No date')-->No date<!--/ko--></label> <span>(<!--ko text:summaryStats().tasks.mine.nodate-->0<!--/ko-->)</span>
                                    </li>
                                </ul>
                            </div>
                            <!-- /ko -->
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="summary-col section-holder has-settings tasks">
                            <div class="summary-col mini-chart" style="">
                                <h4>All</h4>

                                <ul class="lhs chart-legend">
                                    <li class="late empty" data-bind="click: function(){OnQuickView('tasks','late',selectedUser.id())}, css:{'empty':summaryStats().tasks.mine.late()==0}">
                                        <i class="fa fa-circle"></i>
                                        <label><!--ko text:app.tl('Late')-->Late<!--/ko--></label> <span>(<!--ko text:summaryStats().tasks.mine.late-->0<!--/ko-->)</span>
                                    </li>
                                    <!-- ko if: showStartedTasks() -->
                                    <li class="started empty" data-bind="click: function(){OnQuickView('tasks','started',selectedUser.id())}, css:{'empty':summaryStats().tasks.mine.started()==0}">
                                        <i class="fa fa-circle"></i>
                                        <label><!--ko text:app.tl('Started')-->Started<!--/ko--></label> <span>(<!--ko text:summaryStats().tasks.mine.started-->0<!--/ko-->)</span>
                                    </li>
                                    <!-- /ko -->
                                    <li class="today empty" data-bind="click: function(){OnQuickView('tasks','today',selectedUser.id())}, css:{'empty':summaryStats().tasks.mine.today()==0}">
                                        <i class="fa fa-circle"></i>
                                        <label><!--ko text:app.tl('Today')-->Today<!--/ko--></label> <span>(<!--ko text:summaryStats().tasks.mine.today-->0<!--/ko-->)</span>
                                    </li>
                                    <li class="upcoming empty" data-bind="click: function(){OnQuickView('tasks','upcoming',selectedUser.id())}, css:{'empty':summaryStats().tasks.mine.upcoming()==0}">
                                        <i class="fa fa-circle"></i>
                                        <label><!--ko text:app.tl('Upcoming')-->Upcoming<!--/ko--></label> <span>(<!--ko text:summaryStats().tasks.mine.upcoming-->0<!--/ko-->)</span>
                                    </li>
                                    <li class="nodate empty" data-bind="click: function(){OnQuickView('tasks','nodate',selectedUser.id())}, css:{'empty':summaryStats().tasks.mine.nodate()==0}">
                                        <i class="fa fa-circle"></i>
                                        <label><!--ko text:app.tl('No date')-->No date<!--/ko--></label> <span>(<!--ko text:summaryStats().tasks.mine.nodate-->0<!--/ko-->)</span>
                                    </li>
                                </ul>
                            </div>
                            <!-- /ko -->
                        </div>
                    </div>
                </div>

            </div>
            <div class="col-md-6 summary-row">
                <div class="row">
                    <div class="col-sm-12">
                        <h3>Time</h3>
                    </div>

                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="summary-col section-holder has-settings tasks">
                            <div class="summary-col mini-chart" style="">
                                <h4 data-bind="click: function(){OnQuickView('tasks','anytime',selectedUser.id())}" style="cursor:pointer;">
                                    Logged Time
                                </h4>

                                <ul class="lhs chart-legend">
                                    <li class="mine empty" data-bind="click: function(){OnQuickView('tasks','late',selectedUser.id())}, css:{'empty':summaryStats().tasks.mine.late()==0}">
                                        <i class="fa fa-square"></i>
                                        <label>Mine</label> <span>(0)</span>
                                    </li>
                                    <!-- ko if: showStartedTasks() -->
                                    <li class="others empty" data-bind="click: function(){OnQuickView('tasks','started',selectedUser.id())}, css:{'empty':summaryStats().tasks.mine.started()==0}">
                                        <i class="fa fa-circle"></i>
                                        <label>All Others</label> <span>(0)</span>
                                    </li>
                                </ul>
                            </div>
                            <!-- /ko -->
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="summary-col section-holder has-settings tasks">
                            <div class="summary-col mini-chart" style="">
                                <h4>BreakDown</h4>

                                <ul class="lhs chart-legend">
                                    <li class="empty">
                                        <i class="fa fa-check-circle"></i>
                                        <label>Abdul Khan</label> <span>(0)</span>
                                    </li>
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
    import Ticket from '../../components/util/Ticket';
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
        },
        watch: {

        },
        components: {
            Ticket
        },
        mounted(){

        },
        methods:{
            handlePageHeader: function(data){
                this.$emit('handle-page-header', data);
            },
        },
        beforeRouteUpdate (to, from, next) {
            next();
        }
    }
</script>

<style scoped>
h5{font-size: 14px;}
</style>
