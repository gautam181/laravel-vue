<template>
    <div>
        <div :class="{
        'component-loader': true,
        'fade': true,
        'in': show }" v-if="show">
            <div class="spinner-container">
                <span class="spinner-small"></span>
                <span class="loading-label">{{ label }}</span>
            </div>

        </div>
    </div>
</template>

<script>
    export default {
        name: "LoadingSpinner",
        props: {
            'label': {type: Text, default: 'Loading ...'},
            'show': {type: Boolean, default: false, required: true},
        },
        methods: {},
        data() {
            return {}
        },
        mounted() {
        },
        watch: {}
    }
</script>

<style scoped>
    @-webkit-keyframes rotation {
        from {-webkit-transform: rotate(0deg);}
        to {-webkit-transform: rotate(359deg);}
    }
    @keyframes rotation {
        from {transform: rotate(0deg);}
        to {transform: rotate(359deg);}
    }
.component-loader{
    position: absolute;
    left: 0;
    right: 0;
    top: 0;
    bottom: 0;
    background: #fff;
    opacity: .9;
    -webkit-animation: fadeIn .2s;
    animation: fadeIn .2s;
    z-index: 1020;
    border-radius: 0 0 4px 4px;
    min-height: 300px;
}
.spinner-container{
    position: absolute;
    top: 50%;
    left: 50%;
    margin: -40px -100px;
    text-align: center;
    width: 200px;
    height: 80px;
}
.spinner,
.spinner-small {
    height: 40px;
    width: 40px;
    margin: 0px auto;
    border: 2px solid rgba(0,0,0,0.5);
    border-top: 2px solid #fff;
    border-radius: 100%;
    display: block;
}
.fade.in .spinner,
.fade.in .spinner-small,
.fade.show .spinner,
.fade.show .spinner-small {
    -webkit-animation: rotation .6s infinite linear;
    animation: rotation .6s infinite linear;
}
.spinner-small {
    border: 2px solid rgba(0,0,0,0.05);
    border-top: 2px solid #34495E;
    height: 30px;
    width: 30px;
    margin: 0px auto 10px;
}

</style>
