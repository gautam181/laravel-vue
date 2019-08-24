<template>
    <b-modal id="project-form" size="lg" top  ref="project-form" :ok-title="btn_ok_label" :title="modal_title" @ok="saveProject">
        <div class="row">
            <div class="col-md-12">
                <form method="get" class="form-horizontal">
                    <div class="form-group">
                        <label class="control-label">Project title is:</label>
                        <div class=""><input type="text" name="title" v-model="project_info.name" class="form-control form-control-sm"></div>
                    </div>
                    <div>
                        <ul class="tabs mb-3" id="tabs-tab">
                            <li class="">
                                <a class="active" id="tabs-home-tab" data-toggle="pill" href="#tabs-desc" role="tab" aria-controls="tabs-home" aria-selected="true">Description</a>
                            </li>
                            <li class="nav-item">
                                <a class="" id="tabs-profile-tab" data-toggle="pill" href="#tabs-dates" role="tab" aria-controls="tabs-profile" aria-selected="false">Dates</a>
                            </li>
                            <li class="nav-item">
                                <a class="" id="tabs-contact-tab" data-toggle="pill" href="#tabs-owner" role="tab" aria-controls="tabs-contact" aria-selected="false">Owner</a>
                            </li>
                        </ul>
                        <div class="tab-content" id="tabs-tabContent">
                            <div class="tab-pane fade show active" id="tabs-desc" role="tabpanel" aria-labelledby="tabs-home-tab">
                                <div cvlass="form-group">
                                    <label  for="project_desc">
                                        Provide a Description
                                    </label>

                                    <div class="">
                                        <textarea tabindex="2" v-model="project_info.description" class="form-control" id="project_desc"></textarea>
                                    </div>
                                </div>
                            </div>
                            <div class="tab-pane fade" id="tabs-dates" role="tabpanel" aria-labelledby="tabs-profile-tab">
                                <div cvlass="form-group">

                                    <div class="row">
                                        <div class="col-md-6">

                                            <label>
                                                Start Date
                                            </label>
                                            <div class="input-group mb-3">
                                                <date-picker v-model="start_date"  :config="configs.start" ref="startDate" v-on:dp-change="onStartChange" placeholder="Start Date"></date-picker>
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
                                                <date-picker v-model="end_date"  :config="configs.end" ref="endDate" v-on:dp-change="onEndChange" placeholder="End Date"></date-picker>
                                                <div class="input-group-append">
                                                    <span class="input-group-text"><i class="fa fa-calendar"></i></span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="tab-pane fade" id="tabs-owner" role="tabpanel" aria-labelledby="tabs-contact-tab">
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
    import { cloneDeep } from 'lodash';
    export default {
        name: "project-form",
        props: {
            //'project': {type:Object, required: true},
            'id': {type: Number, default: 0},
            'add' : {type: Boolean, default: true}
        },
        data(){
            return {
                myRoute : {},
                project: {
                    'id': '', 'name':'', 'description':'', 'owner': {}, 'start_date': '', 'end_date': ''
                },
                project_info: {'id': '', 'name':'', 'description':'', 'owner': {}, 'start_date': '', 'end_date': ''},
                configs: {
                    timePicker: {
                        format: 'LT',
                        useCurrent: false
                    },
                    start: {
                        format: this.$settings.FORMDATEFROMAT,
                        useCurrent: false,
                        showClear: true,
                        showClose: true,
                        //minDate: new Date(),
                        //maxDate: false
                    },
                    end: {
                        format: this.$settings.FORMDATEFROMAT,
                        useCurrent: false,
                        showClear: true,
                        showClose: true,
                        //minDate: new Date()
                    }
                }
            }
        },
        watch:{
            project:function (val) {
                this.project_info = Object.assign({}, val);
            }
        },
        computed: {
            modal_title: function(){
                return this.project_info.id ? 'Edit Project': 'Add Project';
            },
            btn_ok_label: function(){
                return this.project_info.id ? 'Save Changes': 'Add Project';
            },

            start_date:{
                get: function(){
                    return this.project_info.start_date? this.$options.filters.formDate(this.project_info.start_date): '';
                },
                set: function (val) {
                    this.project_info.start_date=  val;
                }
            } ,
            end_date: {
                get: function(){
                    return this.project_info.end_date? this.$options.filters.formDate(this.project_info.end_date): '';
                },
                set: function (val) {
                    this.project_info.end_date=  val;
                }
            },
            users(){
                return this.$store.getters['users/getUsersList'];
            }
        },
        components: {

        },
        mounted(){
            if(this.id)
                this.$store.dispatch('projects/getProject', this.id)
                    .then(response => {
                        this.project = this.$store.getters['projects/getProject'](this.id);
                    })
            this.$store.dispatch('users/getUsersList');
            this.$refs['project-form'].show();
        },
        methods:{
            onStartChange(e) {
                this.$set(this.configs.end, 'minDate', e.date || null);
            },
            onEndChange(e) {
                this.$set(this.configs.start, 'maxDate', e.date || null);
            },
            saveProject:function () {
                //bvModalEvt.preventDefault();
                this.$store.dispatch('projects/saveProject', {
                    id: this.project_info.id,
                    body: {
                        id: this.project_info.id,
                        name: this.project_info.name,
                        description: this.project_info.description,
                        start_date: this.project_info.start_date,
                        end_date: this.project_info.end_date,
                        owner: this.project_info.owner.id,
                    }
                })
                    .then(response => {
                        this.$store.commit('projects/setProject', this.project_info);
                        this.$emit('projectUpdate', this.project_info);
                    })
                    .catch(error => {
                        console.log(error);
                    });
            }
        },
        beforeRouteUpdate (to, from, next) {
            next();
        },

    }
</script>

<style scoped>

</style>
