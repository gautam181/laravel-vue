<template>
    <div class="file-row">
        <div class="thumbnail">
            <img src="../../images/thumb_projectFile.png" alt="thumbnail">
        </div>
        <div class="file-detail">
            <div class="file-info">
                <div class="file-name">
                    team-access.png
                </div>
                <div class="file-meta text-muted">
                    by abdul khan, 40 minutes ago - 120 KB
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
            'name': {type: String}
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
