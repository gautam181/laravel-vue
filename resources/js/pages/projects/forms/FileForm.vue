<template>
    <b-modal id="file-form" size="lg" top  ref="file_form" :ok-title="btn_ok_label" :title="modal_title" @ok="saveFileDetails">
        <!--<template v-slot:modal-footer="{ ok, cancel, hide }">
            <button type="button" class="btn btn-secondary mr-auto" @click="cancel()">Cancel</button>
            <button type="button" class="btn btn-success" @click="saveFileDetails">{{btn_ok_label}}</button>
        </template>-->

        <div class="row">
            <div class="col-md-12" v-if="file_info">
                <form method="get" class="form-horizontal" @submit="saveFileDetails">
                    <div class="form-group">
                        <label class="control-label">File name:</label>
                        <div class=""><input type="text" name="name" v-model="file_info.knownas" class="form-control form-control-sm">
                            <span class="help-block m-b-none">Known as: {{ file.knownas }}</span>
                        </div>
                    </div>
                    <div>
                        <b-tabs nav-wrapper-class="nav-htabs">
                            <b-tab title="Description">
                                <div class="form-group">
                                    <label  for="file_desc">
                                        Provide a Description
                                    </label>

                                    <div class="">
                                        <textarea tabindex="2" v-model="file_info.description" class="form-control" id="file_desc"></textarea>
                                    </div>
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
    export default {
        name: "file-form",
        props: {
            'file': {type:Object, required: true},
        },
        data(){
            return {
                state:{
                    is_saving: false
                },
                file_info : {}
            }
        },
        watch:{
            file:function (val) {
                this.file_info = Object.assign({}, val);
            }
        },
        computed: {
            modal_title: function(){
                return 'Edit File Details';
            },
            btn_ok_label: function(){
                return 'Save Changes';
            },
        },
        components: {

        },
        mounted(){
            this.$refs['file_form'].show();
            this.file_info = Object.assign({}, this.file);
        },
        methods:{
            saveFileDetails:function (bvModalEvt) {
                this.state.is_saving = true;
                bvModalEvt.preventDefault();
                this.$store.dispatch('files/saveFileDetails', {
                    id: this.file_info.id,
                    body: {
                        id: this.file_info.id,
                        knownas: this.file_info.knownas,
                        description: this.file_info.description
                    }
                })
                    .then(response => {
                        this.state.is_saving = false;
                        //this.$store.commit('projects/setProject', this.project_info);
                        this.$root.$emit('fileUpdate', this.file_info);
                        this.$toast.success('File updated successfully', "Success", {
                            timout: 3000,
                            position: 'bottomRight'
                        });
                        this.$refs.file_form.hide();
                    })
                    .catch(error => {
                        this.state.is_saving = false;
                        let data = error.response.data;
                        this.errors = data.errors;
                        data.type = 'danger';
                        this.$root.$emit('showAlert', data);
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
