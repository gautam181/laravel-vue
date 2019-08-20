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
                                <a class="active" id="pills-home-tab" data-toggle="pill" href="#pills-home" role="tab" aria-controls="pills-home" aria-selected="true">Home</a>
                            </li>
                            <li class="nav-item">
                                <a class="" id="pills-profile-tab" data-toggle="pill" href="#pills-profile" role="tab" aria-controls="pills-profile" aria-selected="false">Profile</a>
                            </li>
                            <li class="nav-item">
                                <a class="" id="pills-contact-tab" data-toggle="pill" href="#pills-contact" role="tab" aria-controls="pills-contact" aria-selected="false">Contact</a>
                            </li>
                        </ul>
                        <div class="tab-content" id="pills-tabContent">
                            <div class="tab-pane fade show active" id="pills-home" role="tabpanel" aria-labelledby="pills-home-tab">one</div>
                            <div class="tab-pane fade" id="pills-profile" role="tabpanel" aria-labelledby="pills-profile-tab">two</div>
                            <div class="tab-pane fade" id="pills-contact" role="tabpanel" aria-labelledby="pills-contact-tab">three</div>
                        </div>
                    </div>
                    <!--<div class="row">
                        <div class="col-md-12">
                            <b-tabs content-class="mt-3" nav-class="tabs">
                                <b-tab title="First" active><p>I'm the first tab</p></b-tab>
                                <b-tab title="Second"><p>I'm the second tab</p></b-tab>
                                <b-tab title="Disabled" disabled><p>I'm a disabled tab!</p></b-tab>
                            </b-tabs>
                        </div>

                    </div>-->

                    <ul class="tabs">
                        <li class="active">
                            <a class="">Description</a>
                        </li>
                        <li class="">
                            <a class="">Dates</a>
                        </li>
                        <li class="">
                            <a class="">Dates</a>
                        </li>
                    </ul>

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
            }
        },
        computed: {
            project_info: function () {
                return this.project;
            }
        },
        components: {

        },
        mounted(){
            this.$refs['project-form'].show();
        },
        methods:{
        },
        beforeRouteUpdate (to, from, next) {
            next();
        }
    }
</script>

<style scoped>

</style>
