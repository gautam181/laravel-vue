<template>
    <div class="project-tickets" v-if="showWidget">
        <div class="filter-block">
            <div class="filter-header">
                Keyword
            </div>
            <div class="filter-body">
                <input type="text" class="form-control form-control-sm" placeholder="project tile or description">
            </div>
        </div>
        <div class="filter-block">
            <div class="filter-header">
                Created Date
            </div>
            <div class="filter-body">
                <v-select
                    v-model="created_range"
                    label="value"
                    :options="created_options"
                ></v-select>
                <div class="date-range" v-if="created_range.id == 1">
                    <div class="date-range-block">
                        <div class="input-group date">
                            <label class="label">Created After</label>
                            <b-input-group size="sm">
                                <b-input-group-text slot="prepend"><i class="fa fa-calendar"></i></b-input-group-text>
                                <date-picker v-model="start_date" ref="startDate" placeholder="Start Date"></date-picker>
                            </b-input-group>
                        </div>
                    </div>
                    <div class="date-range-block">
                        <label class="label">Created Before</label>
                        <b-input-group size="sm">
                            <b-input-group-text slot="prepend"><i class="fa fa-calendar"></i></b-input-group-text>
                            <date-picker v-model="end_date" ref="startDate" placeholder="End Date"></date-picker>
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
                    v-model="due_range"
                    label="value"
                    :options="due_options"
                ></v-select>
                <div class="date-range" v-if="due_range.id == 4">
                    <div class="date-range-block">
                        <div class="input-group date">
                            <label class="label">Due After</label>
                            <b-input-group size="sm">
                                <b-input-group-text slot="prepend"><i class="fa fa-calendar"></i></b-input-group-text>
                                <date-picker v-model="due_start" ref="startDate" placeholder="Start Date"></date-picker>
                            </b-input-group>
                        </div>
                    </div>
                    <div class="date-range-block">
                        <label class="label">Due Before</label>
                        <b-input-group size="sm">
                            <b-input-group-text slot="prepend"><i class="fa fa-calendar"></i></b-input-group-text>
                            <date-picker v-model="due_end" ref="startDate" placeholder="End Date"></date-picker>
                        </b-input-group>
                    </div>
                </div>

            </div>
        </div>
        <div class="filter-block">
            <div class="filter-body">
                <a href="javascript:void(0)" class="btn btn-default btn-sm"><i class="fa fa-retweet"></i> Reset Filter</a>
                <a href="javascript:void(0)" class="btn btn-primary pull-right btn-sm"><i class="fa fa-filter"></i> Apply Filter</a>
            </div>
        </div>

    </div>
</template>

<script>
    export default {
        name: "project-tickets",
        data(){
            return {
                project_id : this.$route.params.id,
                size:20,
                avatarStyle: {'margin-right':'5px'},
                start_date:'',
                end_date:'',
                due_start:'',
                due_end:'',
                due_range: {id: '0', value: 'Any Time'},
                created_range: {id: '0', value: 'Any Time'},
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
        computed:{
            project(){
                return this.$store.getters['projects/getProject'](this.project_id);
            },
            showWidget(){
                return this.$route.name == 'project-tickets'?  true : false;
            }
        }
    }
</script>

<style scoped>

</style>
