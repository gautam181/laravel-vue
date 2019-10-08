<template>
    <li :class="color_class" >
        <i :class="icon"></i>
        <label>{{ label }}</label> <span>({{ value }})</span>
    </li>
</template>

<script>
    export default {
        name: "SummaryLegend",
        props: {
            'label': {type: String, default: '...', required: true},
            'color': {type: String, default: '', required: true},
            'value': {type: String },
            'type' : {type: String, default : 'fa-circle'}
        },
        methods: {},
        data() {
            return {
                icon: 'fa '+this.type
            }
        },
        computed: {
            color_class(){
                return this.color +(this.value > 0 ? '': ' empty');
            }
        },
        mounted() {
        },
        watch: {}
    }
</script>
