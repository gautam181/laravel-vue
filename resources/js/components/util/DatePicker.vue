<template>
    <date-range-picker
        opens="center"
        :locale-data="locale"
        :singleDatePicker="singleDatePicker"
        :autoApply="autoapply"
        :linkedCalendars="linkedCalendars"
        v-model="dateRange"
    >
        <!--<div slot="input" slot-scope="ticket">
            {{ dateRange.startDate | date }} - {{ dateRange.endDate | date }}
        </div>-->
    </date-range-picker>
</template>

<script>

    export default {
        name: "DatePicker",
        props: {
            range:{ type:Boolean, default: false },
            autoapply: {type: Boolean, default: false},
            dates:{
                default: {startDate: null,  endDate: null}
            }
        },
        component:{},
        methods: {
            updated (values) {
                //this.$emit('update', values);
            },
        },
        data() {
            return {
                locale: {firstDay: 1, format: this.$settings.DATEFROMAT},
                singleDatePicker: this.range ? true : false,
                linkedCalendars: true,
            }
        },
        computed:{
            dateRange:{
                get:function(){return this.dates; },
                set:function (val){
                    this.$emit('update', val);
                }
            }
        },
        mounted() {
        },
        watch: {

        }
    }
</script>

<style scoped>

</style>
