<template>
    <div class="project-tickets" v-if="showWidget">
        <div class="filter-block">
            <div class="filter-header">
                Keyword
            </div>
            <div class="filer-body">
                <input type="text" class="form-control form-control-sm">
            </div>
        </div>
        <div class="filter-block">
            <div class="filter-header">
                Created Date
            </div>
            <div class="filer-body">

                <div class="date-range">

                    <div class="date-range-block">
                        <div class="input-group date">
                            <label class="label">Start Date</label>
                            <b-input-group size="sm">
                                <b-input-group-text slot="prepend"><i class="fa fa-calendar"></i></b-input-group-text>
                                <date-picker v-model="start_date" ref="startDate" placeholder="Start Date"></date-picker>
                            </b-input-group>
                        </div>
                    </div>
                    <div class="date-range-block">
                        <label class="label">End Date</label>
                        <b-input-group size="sm">
                            <b-input-group-text slot="prepend"><i class="fa fa-calendar"></i></b-input-group-text>
                            <date-picker v-model="start_date" ref="startDate" placeholder="End Date"></date-picker>
                        </b-input-group>
                    </div>
                </div>

            </div>
        </div>
        <div class="filter-block">
            <div class="filer-body">
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
