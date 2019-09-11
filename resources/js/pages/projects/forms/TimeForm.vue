<template>
    <b-modal id="time-form" size="lg" top  ref="time-form" :ok-title="btn_ok_label" :title="modal_title" @ok="saveProject">
        <div class="modal-info-bar" v-if="ticket">
            <span class="modal-info-bar-label">Ticket</span>
            <span class="modal-info-bar-content">{{ ticket.title }}</span>
        </div>
        <div class="row mt-3">
            <div class="col-md-12">
                <form method="get" class="form-horizontal">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="flex-row">
                                <div class="form-group">
                                    <label>Who</label>
                                    <div class="who-select">
                                        <v-select
                                            v-model="project_info.owner"
                                            label="name"
                                            :options="users"
                                            :clearable="false"
                                        ></v-select>
                                    </div>

                                </div>
                                <div class="">
                                    <div class="form-group">
                                        <label class="control-label">Date</label>
                                        <div class="input-group">
                                            <date-picker v-model="start_date" class="form-control form-control-sm date-input"  :config="configs.start" ref="startDate"></date-picker>
                                            <div class="input-group-append">
                                                <span class="input-group-text"><i class="fa fa-calendar"></i></span>
                                            </div>
                                        </div>

                                    </div>
                                </div>
                                <div class="">
                                    <div class="form-group">
                                        <label class="control-label">Start Time</label>
                                        <div class="input-group">
                                            <date-picker value="" class="form-control form-control-sm time-input" :config="configs.time" ref="startDate"></date-picker>
                                            <div class="input-group-append">
                                                <span class="input-group-text"><i class="fa fa-clock"></i></span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="">
                                    <div class="form-group">
                                        <label class="control-label">End Time</label>
                                        <div class="input-group">
                                            <date-picker value="" class="form-control form-control-sm time-input" :config="configs.time" ref="startDate"></date-picker>
                                            <div class="input-group-append">
                                                <span class="input-group-text"><i class="fa fa-clock"></i></span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="">
                                    <div class="">
                                        <label class="control-label">Duration</label>
                                        <div class="form-content">
                                            <div class="form-group">
                                                <input type="text" name="title" value="0" class="form-control form-control-sm hour-input">
                                                <small>hours</small>
                                            </div>
                                            <div class="form-group">
                                                <input type="text" name="title" value="0" class="form-control form-control-sm minute-input">
                                                <small>minutes</small>
                                            </div>
                                        </div>

                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label">Project title is:</label>
                        <div class=""><input type="text" name="title" v-model="project_info.name" class="form-control form-control-sm"></div>
                    </div>
                    <div>
                        <b-tabs nav-wrapper-class="nav-htabs">
                            <b-tab title="Description" :active="tab == 'description'">
                                <div class="form-group">
                                    <label  for="project_desc">
                                        Provide a Description
                                    </label>

                                    <div class="">
                                        <textarea tabindex="2" v-model="project_info.description" class="form-control" id="project_desc"></textarea>
                                    </div>
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
        name: "time-form",
        props: {
            'ticket': {type:Object, default: {}},
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
                    time: {
                        format: 'hh:mm a',
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
                return this.project_info.id ? 'Edit Logged Time': 'Log Time';
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
            this.$refs['time-form'].show();
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
                        owner: this.project_info.owner? this.project_info.owner.id : '',
                        progress: this.project_info.progress? this.project_info.progress : 0,
                    }
                })
                    .then(response => {
                        console.log(response);
                        if (this.id < 1){
                            let project = response.data;
                            this.$router.push({'name': 'project-detail', params: {'id': project.id }});
                        } else {
                            this.$store.commit('projects/setProject', this.project_info);
                        }
                        this.$eventBus.$emit('projectUpdate', this.project_info);
                        this.$toast.success('Project updated successfully', "Success", {
                            timout: 3000,
                            position: 'bottomRight'
                        });
                    })
                    .catch(error => {
                        this.$toast.warning('Error while updating the data!', "Warning", {
                            timout: 3000,
                            position: 'bottomRight'
                        });
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
