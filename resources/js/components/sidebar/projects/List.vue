<template>
    <div class="project-list" v-if="showWidget">
        <div class="filter-block">
            <div class="filter-header">
                Keyword
            </div>
            <div class="filter-body">
                <input type="text" v-model="filter.keyword" class="form-control form-control-sm" placeholder="project tile or description">
            </div>
        </div>
        <div class="filter-block">
            <div class="filter-header">
                Created Date
            </div>
            <div class="filter-body">
                <v-select
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
                                <date-picker v-model="filter.created_dates.start_date" ref="startDate" placeholder="Start Date"></date-picker>
                            </b-input-group>
                        </div>
                    </div>
                    <div class="date-range-block">
                        <label class="label">Created Before</label>
                        <b-input-group size="sm">
                            <b-input-group-text slot="prepend"><i class="fa fa-calendar"></i></b-input-group-text>
                            <date-picker v-model="filter.created_dates.end_date" ref="startDate" placeholder="End Date"></date-picker>
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
                <v-select
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
                                <date-picker v-model="filter.due_dates.start_date" ref="startDate" placeholder="Start Date"></date-picker>
                            </b-input-group>
                        </div>
                    </div>
                    <div class="date-range-block">
                        <label class="label">Due Before</label>
                        <b-input-group size="sm">
                            <b-input-group-text slot="prepend"><i class="fa fa-calendar"></i></b-input-group-text>
                            <date-picker v-model="filter.due_dates.due_end" ref="startDate" placeholder="End Date"></date-picker>
                        </b-input-group>
                    </div>
                </div>

            </div>
        </div>
        <div class="filter-block">
            <div class="filter-body">
                <button @click="resetFilter"  class="btn btn-default btn-sm"><i class="fa fa-retweet"></i> Reset Filter</button>
                <button @click="applyFilter" class="btn btn-primary pull-right btn-sm"><i class="fa fa-filter"></i> Apply Filter</button>
            </div>
        </div>

    </div>
</template>

<script>
    import { cloneDeep } from 'lodash'
    let default_filter = {
        'keyword': '',
        'created_dates':{
            'start_date': '',
            'end_date': ''
        },
        'created_range':{id: '0', value: 'Any Time'},
        'due_dates':{
            'start_date': '',
            'end_date': ''
        },
        'due_date_range':{id: '0', value: 'Any Time'},
    };
    export default {
        name: "project-list",
        data(){
            return {
                size:20,
                avatarStyle: {'margin-right':'5px'},
                filter: default_filter,
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
            this.filter = cloneDeep(this.$store.getters['projects/getFilters']);
        },
        computed:{
            showWidget(){
                return this.$route.name == 'projects'?  true : false;
            }
        },
        methods:{
            applyFilter: function () {
                this.$store.commit('projects/setFilters', this.filter);
                this.$store.dispatch('tickets/getTickets');
            },
            resetFilter: function () {
                localStorage.removeItem('projects_filters');
                this.$store.dispatch('tickets/getTickets');
            }
        }
    }
</script>

<style scoped>

</style>
