<template>
    <div class="project-filter-list" v-if="showWidget">
        <form action="">
            <div class="filter-block">
                <div class="filter-header">
                    Keyword
                </div>
                <div class="filter-body">
                    <input type="text" v-model="filter.keyword" class="form-control form-control-sm" placeholder="ticket title or description">
                </div>
            </div>
            <div class="filter-block">
                <div class="filter-header">
                    Created Date
                </div>
                <div class="filter-body">
                    <v-select :clearable="clearable"
                        v-model="filter.created_range"
                        label="value"
                        :options="created_options"
                    ></v-select>
                    <div class="date-range" v-if="filter.created_range.id == 1">
                        <div class="date-range-block">
                            <div class="input-group date">
                                <label class="label">Created After</label>
                                <b-input-group size="sm">
                                    <b-input-group-text slot="prepend"><i class="fa fa-calendar"></i></b-input-group-text>
                                    <date-picker v-model="filter.start_date" ref="startDate" placeholder="Start Date"></date-picker>
                                </b-input-group>
                            </div>
                        </div>
                        <div class="date-range-block">
                            <label class="label">Created Before</label>
                            <b-input-group size="sm">
                                <b-input-group-text slot="prepend"><i class="fa fa-calendar"></i></b-input-group-text>
                                <date-picker v-model="filter.end_date" ref="startDate" placeholder="End Date"></date-picker>
                            </b-input-group>
                        </div>
                    </div>

                </div>
            </div>
            <div class="filter-block">
                <div class="filter-header">
                    Due Date
                </div>
                <div class="filter-body">
                    <!--<date-picker :config="dateOptions" value="" ref="inlineDate" placeholder="Start Date"></date-picker>-->
                    <v-select :clearable="clearable"
                        v-model="filter.due_date_range"
                        label="value"
                        :options="due_options"
                    ></v-select>
                    <div class="date-range" v-if="filter.due_date_range.id == 4">
                        <div class="date-range-block">
                            <div class="input-group date">
                                <label class="label">Due After</label>
                                <b-input-group size="sm">
                                    <b-input-group-text slot="prepend"><i class="fa fa-calendar"></i></b-input-group-text>
                                    <date-picker v-model="filter.due_start_date" ref="startDate" placeholder="Start Date"></date-picker>
                                </b-input-group>
                            </div>
                        </div>
                        <div class="date-range-block">
                            <label class="label">Due Before</label>
                            <b-input-group size="sm">
                                <b-input-group-text slot="prepend"><i class="fa fa-calendar"></i></b-input-group-text>
                                <date-picker v-model="filter.due_end_date" ref="startDate" placeholder="End Date"></date-picker>
                            </b-input-group>
                        </div>
                    </div>

                </div>
            </div>

            <div class="filter-block">
                <div class="filter-header">
                    Assigned To
                </div>
                <div class="filter-body">
                    <v-select :clearable="clearable" :taggable="taggable" :multiple="true"
                        v-model="filter.assigned_to"
                        label="name"
                        :options="users"
                    ></v-select>
                </div>
            </div>
            <div class="filter-block">
                <div class="filter-body">
                    <button @click="applyFilter" type="submit" class="btn btn-primary pull-right btn-sm"><i class="fa fa-filter"></i> Apply Filter</button>
                    <button @click="resetFilter"  class="btn btn-default btn-sm"><i class="fa fa-retweet"></i> Reset Filter</button>
                </div>
            </div>
        </form>
    </div>
</template>

<script>
    export default {
        name: "project-tickets",
        data(){
            return {
                size:20,
                inline:true,
                avatarStyle: {'margin-right':'5px'},
                filter: {},
                dateOptions: {
                    inline: true
                },
                clearable: false,
                taggable: true,
                due_options: [
                    {id: '0', value: 'Any Time'},
                    {id: '1', value: 'No Due Date'},
                    {id: '2', value: 'No Start Date'},
                    {id: '3', value: 'No Due or Start Date'},
                    {id: '4', value: 'Custom Range'},
                ],
                created_options: [
                    {id: '0', value: 'Any Time'},
                    {id: '1', value: 'Custom Range'},
                ]
            }
        },
        mounted(){
            this.$store.dispatch('users/getUsersList');
        },
        created(){
            this.filter = _.cloneDeep(this.$store.getters['tickets/getFilters']);
            this.$eventBus.$on('filter-bar::clear', (val) => {
                if (val.id == 'project-tickets-list')
                    this.resetFilter();
            })
        },
        computed:{
            showWidget(){
                return this.$route.name == 'project-tickets'?  true : false;
            },
            users(){
                return _.cloneDeep(this.$store.getters['users/getUsersList']);
            }
        },
        methods:{
            getTickets: function(){
                this.$store.commit('tickets/setPage', 1);
                this.$eventBus.$emit('project-tickets-loading', true);
                this.$store.dispatch('tickets/getTickets')
                    .then(res => {
                        this.$eventBus.$emit('project-tickets-loading', false);
                });
            },
            applyFilter: function () {
                if (!_.isEqual(this.filter, this.$store.getters['tickets/getFilters'])) {
                    this.$store.commit('tickets/setFilters', this.filter);
                    this.getTickets();
                }

            },
            resetFilter: function () {
                this.filter = {...this.$filters.project_tickets};
                this.$store.commit('tickets/setFilters', this.filter);
                this.getTickets();
            }
        }
    }
</script>

<style scoped>

</style>
