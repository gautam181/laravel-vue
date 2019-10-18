<template>
    <b-modal id="project-form" size="lg" top  ref="project_form" :ok-title="btn_ok_label" :title="modal_title" @ok="handleOK">
        <div class="row">
            <div class="col-md-12">
                <form method="get" class="form-horizontal">
                    <div :class="{ 'form-group': true, 'has-error': errors.name }" ref="name">
                        <label class="control-label">Project title is:</label>
                        <div class=""><input type="text" name="title" v-model="project_info.name" class="form-control form-control-sm"></div>
                    </div>
                    <div>
                        <b-tabs nav-wrapper-class="nav-htabs">
                            <b-tab title="Description" :active="tab == 'description'">
                                <div :class="{'form-group': true, 'has-error': errors.description }" ref="description">
                                    <label  for="project_desc">
                                        Provide a Description
                                    </label>

                                    <div class="">
                                        <textarea tabindex="2" v-model="project_info.description" class="form-control" id="project_desc"></textarea>
                                    </div>
                                </div>
                            </b-tab>
                            <b-tab title="Dates"  :active="tab == 'dates'">
                                <div class="form-group">

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
                            </b-tab>
                            <b-tab title="Owner"  :active="tab == 'owner'">
                                <div class="form-group">
                                    <label>Project Owner</label>
                                    <v-select
                                        v-model="project_info.owner"
                                        label="name"
                                        :options="users"
                                    ></v-select>
                                </div>
                            </b-tab>
                            <b-tab title="Progress"  :active="tab == 'progress'">
                                <div class="form-group">
                                    <label>Project Progress</label>
                                    <vue-slider v-model="project_info.progress" :interval="5" :height="'6px'" :tooltip="'focus'" :marks="true"></vue-slider>
                                </div>
                            </b-tab>
                        </b-tabs>
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
            'add' : {type: Boolean, default: true},
            'tab': {default: 'description'}
        },
        data(){
            return {
                myRoute : {},
                project: {
                    'id': '', 'name':'', 'description':'', 'owner': {}, 'start_date': '', 'end_date': ''
                },
                project_info: {'id': '', 'name':'', 'description':'', 'owner': {}, 'start_date': '', 'end_date': ''},
                errors: {},
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
                    this.project_info.start_date=  val? this.$options.filters.sqlDate(val): '';
                }
            } ,
            end_date: {
                get: function(){
                    return this.project_info.end_date? this.$options.filters.formDate(this.project_info.end_date): '';
                },
                set: function (val) {
                    this.project_info.end_date=  val? this.$options.filters.sqlDate(val): '';
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
            this.$refs.project_form.show();
        },
        methods:{
            onStartChange(e) {
                this.$set(this.configs.end, 'minDate', e.date || null);
            },
            onEndChange(e) {
                this.$set(this.configs.start, 'maxDate', e.date || null);
            },
            handleOK: function(bvModalEvt){
                bvModalEvt.preventDefault();
                this.saveProject();
            },
            saveProject:function () {
                this.$store.dispatch('projects/saveProject', {
                    id: this.project_info.id,
                    body: {
                        id: this.project_info.id,
                        name: this.project_info.name,
                        description: this.project_info.description,
                        start_date: this.project_info.start_date,
                        end_date: this.project_info.end_date,
                        owner: this.project_info.owner? this.project_info.owner.id : '',
                        progress: this.project_info.progress? this.project_info.progress : 0,
                    }
                })
                    .then(response => {
                        this.errors = {};
                        if (this.id < 1){
                            let project = response.data;
                            this.$router.push({'name': 'project-detail', params: {'id': project.id }});
                        } else {
                            this.$store.commit('projects/setProject', this.project_info);
                        }
                        this.$root.$emit('projectUpdate', this.project_info);
                        this.$toast.success('Project updated successfully', "Success", {
                            timout: 3000,
                            position: 'bottomRight'
                        });
                        this.$refs.project_form.hide();
                    })
                    .catch((error) => {
                        let data = error.response.data;
                        this.errors = data.errors;
                        /*this.$toast.error(data.message, "Warning", {
                            timout: 3000,
                            position: 'bottomRight'
                        });*/
                        this.$root.$emit('showToast', data);
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
