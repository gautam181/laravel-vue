<template>
    <div>
        <template v-for="file in files">
            <div class="file-row">
                <div class="thumbnail">
                    <img class="icon" src="../../images/document.svg" alt="thumbnail">
                </div>
                <div class="file-detail">
                    <div class="file-info">
                        <div class="file-name">
                            {{ file.knownas }}
                        </div>
                        <div class="file-meta text-muted">
                            by {{ file.user.name }}, {{ file.updated_at | moment("from", "now") }} - {{ file.size | prettyBytes }}
                        </div>
                    </div>

                </div>
                <div class="file-actions">
                    <button class="btn btn-sm btn-default" @click="previewFile(file.filename)"><i class="fas fa-search"></i> Preview</button>
                    <button class="btn btn-sm btn-default" @click="editFile(file)"><i class="fas fa-pencil-alt"></i> Edit</button>
                    <!--<button class="btn btn-sm btn-default" @click="downloadFile(file.id)"><i class="fas fa-cloud-download-alt"></i> Download</button>-->
                    <button class="btn btn-sm btn-outline btn-danger" @click="deleteFile(file.id)"><i class="fas fa-trash"></i></button>
                </div>
            </div>
        </template>
        <file-form v-if="file_edit" :file="file"></file-form>
    </div>

</template>

<script>
    import FileForm from "../../pages/projects/forms/FileForm";
    export default {
        name: "FileList",
        props: {
            name: {type: String, default(){return 'fileList'}},
            files: {type: Array, required: true}
        },
        components:{
            FileForm
        },
        methods: {
            editFile: function (file) {
                this.file = file;
                this.file_edit = true;
            },
            downloadFile: function (id) {

            },
            previewFile: function (file) {
                window.open('/storage/'+file);
            },
            deleteFile: function (id) {
                this.$swal(
                    {
                        title: 'Are you sure?',
                        text: "You won't be able to revert this!",
                        type: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#3085d6',
                        cancelButtonColor: '#d33',
                        confirmButtonText: 'Yes, delete it!'
                    }).then((result) => {
                        if (result.value) {
                            this.$store.dispatch('files/deleteFile', id)
                                .then(res=>{
                                    this.$root.$emit('fileUpdate', {});
                                    this.$toast.success('File deleted successfully', "Success", {
                                        timout: 1000,
                                        position: 'bottomRight'
                                    });
                                })
                                .catch(exp=>{
                                    this.$root.$emit('handle-exception', exp);
                                })
                        }
                    }
                );
            }
        },
        data() {
            return {
                file_edit: false,
                file: {}
            }
        },
        mounted() {
            this.$root.$on('bv::modal::hidden', (bvEvent, modalId) => {
                if (modalId == 'file-edit'){
                    this.file_edit = false;
                    file: {}
                }
            })
        },
        watch: {}
    }
</script>

<style scoped>

</style>
