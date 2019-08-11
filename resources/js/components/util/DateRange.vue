<template>
    <date-range-picker
        opens="center"
        :locale-data="locale"
        :singleDatePicker="singleDatePicker"
        :autoApply="autoapply"
        :linkedCalendars="linkedCalendars"
        v-model="dateRange"
    >
       <div slot="input" slot-scope="ticket">
            <i class="glyphicon glyphicon-calendar fa fa-calendar"></i> &nbsp;
            {{ getDateText }}
        </div>
    </date-range-picker>
</template>

<script>

    export default {
        name: "DateRange",
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
            },
            getDateText: function(){
                let txt='';
                let start = this.dateRange.startDate;
                let end = this.dateRange.endDate;
                if(start){
                    txt += 'Start ';
                    txt += this.$options.filters.date(start) ;
                }

                if (start && end)
                    txt += ' - ';

                if(end){
                    txt += 'End ';
                    txt += this.$options.filters.date(end) ;
                }

                return txt;
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
