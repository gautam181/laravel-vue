<template>
    <div :id="id" :class="['hpanel', panel_style ? panel_style : 'panel-default']">

        <div  class="panel-heading hbuilt" v-show="title">
            {{ title }}
            <div class="panel-tools" v-show="tools">
                <a class="showhide" v-on:click="togglePanel()"><i class="fa fa-chevron-up"></i></a>
            </div>
        </div>
        <div class="panel-body">
            <slot></slot>
        </div>
        <div class="panel-footer" v-if="footer">
            {{ footer }}
        </div>

    </div>
</template>

<script>
    export default {
        name: "Panel",
        props: ['title', 'footer', 'panel_style', 'tools'],
        methods: {
            togglePanel(){
                let elem = $('#'+this.id);
                elem.find(".showhide i").toggleClass('fa-chevron-up').toggleClass('fa-chevron-down');
                elem.find(".panel-body").slideToggle(300);
                elem.find(".panel-footer").slideToggle(200);
                console.log(this.id);
            }
        },
        data() {
            return {
                id:null
            }
        },
        mounted() {
            this.id = this._uid
        },
        watch: {}
    }
</script>

<style scoped>

</style>
