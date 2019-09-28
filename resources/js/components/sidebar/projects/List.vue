<template>
    <div class="project-filter-list" v-if="showWidget">
        <form action="">
            <div class="filter-block">
                <div class="filter-header">
                    Keyword
                </div>
                <div class="filter-body">
                    <input type="text" v-model="filter.keyword" class="form-control form-control-sm" placeholder="project title or description">
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
                    Project Owner
                </div>
                <div class="filter-body">
                    <v-select :clearable="clearable" :taggable="taggable" :multiple="true"
                        v-model="filter.owner"
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
    import { cloneDeep } from 'lodash'
    export default {
        name: "project-list",
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

        created(){
            this.$root.$on('filter-bar::clear', (val) => {
                if (val.id == 'project-list')
                    this.resetFilter();
            });
            this.filter = cloneDeep(this.$store.getters['projects/getFilters']);
        },
        computed:{
            showWidget(){

                if (this.$route.name == 'projects-active' || this.$route.name == 'projects-completed'){
                    this.$store.dispatch('users/getUsersList');
                    return true;
                } else
                    return false;
            },
            users(){
                return cloneDeep(this.$store.getters['users/getUsersList']);
            }
        },
        methods:{
            getUsers: function(){
                this.$store.dispatch('projects/getProjects');
            },
            getProjects: function(){
                this.$store.commit('projects/setPage', 1);
                this.$root.$emit('project-list-loading', true);
                this.$store.dispatch('projects/getProjects').finally(res => {
                    this.$root.$emit('project-list-loading', false);
                });
            },
            applyFilter: function () {
                if (!_.isEqual(this.filter, this.$store.getters['projects/getFilters'])) {
                    this.$store.commit('projects/setFilters', this.filter);
                    this.getProjects();
                }

            },
            resetFilter: function () {
                this.filter = {...this.$filters.project_list};
                this.$store.commit('projects/setFilters', this.filter);
                this.getProjects();
            }
        }
    }
</script>

<style scoped>

</style>
