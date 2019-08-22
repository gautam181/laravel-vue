<template>
    <div class="small-header" v-if="headerData.label" >
        <div class="panel dark">
            <div class="panel-heading">
                <span v-if="type == 'project'">
                    {{ project.name }}
                </span>
                <template v-else >
                    {{ this.title }}
                </template>

                <div class="panel-tools" v-if="headerData.tools">
                    <template v-for="row in headerData.tools">
                        <a class="edit" v-on:click="row.event(row.id)"><i :class="'fa '+row.icon" ></i></a>
                    </template>

                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        name: "Header",
        props: ['headerData'],
        data(){
            return {
                title: '',
                project_id: 0,
                type: ''
            }
        },
        computed: {
            project:function () {
                return this.$store.getters['projects/getProject'](this.project_id);
            }
        },
        watch:{
            headerData:  function (val) {
                if (val.type == 'project') {
                    this.project_id = val.id;
                    this.type = 'project';
                }
                else {
                    this.type = '';
                    this.title = val.label
                }

                console.log("header updated");
            }
        }
    }
</script>

<style scoped>

</style>
