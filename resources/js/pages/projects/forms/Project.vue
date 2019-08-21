<template>
    <b-modal id="project-form" size="lg" top  ref="project-form" title="Edit Project">
        <div class="row">
            <div class="col-md-12">
                <form method="get" class="form-horizontal">
                    <div class="form-group">
                        <label class="control-label">Project title is:</label>
                        <div class=""><input type="text" name="title" v-model="project_info.name" class="form-control form-control-sm"></div>
                    </div>
                    <div>
                        <ul class="tabs mb-3" id="pills-tab">
                            <li class="">
                                <a class="active" id="pills-home-tab" data-toggle="pill" href="#pills-desc" role="tab" aria-controls="pills-home" aria-selected="true">Description</a>
                            </li>
                            <li class="nav-item">
                                <a class="" id="pills-profile-tab" data-toggle="pill" href="#pills-dates" role="tab" aria-controls="pills-profile" aria-selected="false">Dates</a>
                            </li>
                            <li class="nav-item">
                                <a class="" id="pills-contact-tab" data-toggle="pill" href="#pills-owner" role="tab" aria-controls="pills-contact" aria-selected="false">Owner</a>
                            </li>
                        </ul>
                        <div class="tab-content" id="pills-tabContent">
                            <div class="tab-pane fade show active" id="pills-desc" role="tabpanel" aria-labelledby="pills-home-tab">
                                <div cvlass="form-group">
                                    <label  for="project_desc">
                                        Provide a Description
                                    </label>

                                    <div class="">
                                        <textarea tabindex="2" name="projectDescription" type="text" class="form-control" id="project_desc"></textarea>
                                    </div>
                                </div>
                            </div>
                            <div class="tab-pane fade" id="pills-dates" role="tabpanel" aria-labelledby="pills-profile-tab">
                                <div cvlass="form-group">
                                    <div class="row row-space-10">
                                        <div class="col-xs-6">

                                        </div>
                                        <div class="col-xs-6">

                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6">

                                            <label>
                                                Start Date
                                            </label>
                                            <div class="input-group mb-3">
                                                <date-picker v-model="project_info.start_date"  :config="configs.start" ref="startDate" v-on:dp-change="onStartChange" placeholder="Start Date"></date-picker>
                                                <div class="input-group-append">
                                                    <span class="input-group-text"><i class="fa fa-calendar"></i></span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <label>
                                                End Date
                                            </label>

                                            <div class="input-group mb-3">
                                                <date-picker v-model="project_info.end_date"  :config="configs.end" ref="endDate" v-on:dp-change="onEndChange" placeholder="End Date"></date-picker>
                                                <div class="input-group-append">
                                                    <span class="input-group-text"><i class="fa fa-calendar"></i></span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="tab-pane fade" id="pills-owner" role="tabpanel" aria-labelledby="pills-contact-tab">
                                <div cvlass="form-group">
                                    <label>Project Owner</label>
                                    <v-select
                                        v-model="project_info.owner"
                                        label="name"
                                        :options="users"
                                    ></v-select>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>

        </div>
    </b-modal>
</template>

<script>
    export default {
        name: "project-form",
        props: {
            'project': {type:Object, required: true},
            'add' : {type: Boolean, default: true}
        },
        data(){
            return {
                myRoute : {},
                configs: {
                    timePicker: {
                        format: 'LT',
                        useCurrent: false
                    },
                    start: {
                        format: 'DD/MM/YYYY',
                        useCurrent: false,
                        showClear: true,
                        showClose: true,
                        minDate: new Date(),
                        //maxDate: false
                    },
                    end: {
                        format: 'DD/MM/YYYY',
                        useCurrent: false,
                        showClear: true,
                        showClose: true,
                        //minDate: new Date()
                    }
                }
            }
        },
        computed: {
            project_info: function () {
                return this.project;
            },
            users(){
                return this.$store.getters['users/getUsersList'];
            }
        },
        components: {

        },
        mounted(){
            this.$refs['project-form'].show();
        },
        methods:{
            onStartChange(e) {
                //this.$set(this.configs.end, 'minDate', e.date || null);
            },
            onEndChange(e) {
                //this.$set(this.configs.start, 'maxDate', e.date || null);
            }
        },
        beforeRouteUpdate (to, from, next) {
            next();
        },

    }
</script>

<style scoped>

</style>
