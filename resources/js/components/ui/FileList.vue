<template>
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
            <button class="btn btn-sm btn-default"><i class="fas fa-search"></i> Preview</button>
            <button class="btn btn-sm btn-default"><i class="fas fa-pencil-alt"></i> Edit</button>
            <button class="btn btn-sm btn-default"><i class="fas fa-cloud-download-alt"></i> Download</button>
        </div>
    </div>
</template>

<script>
    export default {
        name: "FileList",
        props: {
            name: {type: String, default(){return 'fileList'}},
            file: {type: Object, required: true}
        },
        methods: {

        },
        data() {
            return {}
        },
        mounted() {
        },
        watch: {}
    }
</script>

<style scoped>

</style>
