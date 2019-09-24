<template>
    <div>
        <div class="table-responsive">
            <table class="table table-condensed table-bordered table-striped table-hover">
                <thead>
                <tr>
                    <th width="80">Date</th>
                    <th width="130">Person</th>
                    <th>Description</th>
                    <th width="80">Start</th>
                    <th width="80">End</th>
                    <th width="120">Time</th>
                    <th width="40">Hours</th>
                    <th width="30"></th>
                </tr>
                </thead>
                <tbody>
                <template v-for="row in time_entries">
                    <tr>
                        <td>{{ row.date | formDate }}</td>
                        <td>{{ getUserName(row) }}</td>
                        <td>{{ row.description }}</td>
                        <td>{{ row.time | time }}</td>
                        <td>{{ getEndTime(row.time, row.hours,  row.minutes) }}</td>
                        <td>
                            <span v-if="row.hours">{{ row.hours }} hrs</span>
                            <span v-if="row.minutes">{{ row.minutes }} mins</span>
                        </td>
                        <td>{{ getHours(row.hours,  row.minutes) }}</td>
                        <td class="actions"><a href="javascript:void(0);" @click="editTimeLog(row)"><i class="fa fa-pen"></i></a></td>
                    </tr>
                </template>
                </tbody>
            </table>
            <time-form :id="ticket_id" v-if="time_form" :project_id="project_id" :ticket="ticket" :time_log="time_log"></time-form>
        </div>
    </div>
</template>

<script>
    import TimeForm from "../../pages/projects/forms/TimeForm";

    export default {
        name: "TimeList",
        props: {
            time_entries: {type: Array, required: true},
            ticket: {type: Object}
        },
        components: {
            TimeForm
        },
        methods: {
            getEndTime: function(t, h, m){
                return this.$moment(t,  'HH:mm:ss').add(h,  'hours').add(m,  'minutes').format(this.$settings.TIMEFROMAT);
            },
            getHours: function(h, m){
                return ((h*60 + m)/60).toFixed(2);
            },
            getUserName: function(row){
                if (row.user_name != undefined)
                    return row.user_name
                else
                    return row.user.name
            },
            editTimeLog: function (data) {
                this.time_form = true;
                this.project_id = data.project_id;
                this.ticket_id = data.ticket_id;
                data.start_time = this.$moment(data.time, 'HH:mm:ss').format(this.$settings.TIMEFROMAT);
                data.start_date = this.$moment(data.date, 'YYYY-MM-DD').format(this.$settings.FORMDATEFROMAT);
                this.time_log = data;
            }
        },
        data() {
            return {
                time_form: false,
                ticket_id: 0,
                project_id: 0,
                time_log: {}
            }
        },
        mounted() {
            this.$root.$on('bv::modal::hidden', (bvEvent, modalId) => {
                if (modalId == 'time-form'){
                    this.time_form = false;
                    time_log: {}
                }
            })
        },
        watch: {}
    }
</script>

<style scoped>

</style>
