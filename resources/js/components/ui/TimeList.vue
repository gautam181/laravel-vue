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
                        <td>{{ row.user.name }}</td>
                        <td>{{ row.description }}</td>
                        <td>{{ row.time | time }}</td>
                        <td>{{ getEndTime(row.time, row.hours,  row.minutes) }}</td>
                        <td>
                            <span v-if="row.hours">{{ row.hours }} hrs</span>
                            <span v-if="row.minutes">{{ row.minutes }} mins</span>
                        </td>
                        <td>{{ getHours(row.hours,  row.minutes) }}</td>
                        <td class="actions"><i class="fa fa-pen"></i></td>
                    </tr>
                </template>
                </tbody>

            </table>
        </div>
    </div>
</template>

<script>
    export default {
        name: "TimeList",
        props: {
            time_entries: {type: Array, required: true},
            ticket_id: {type: Number},
            project_id: {type: Number}
        },
        methods: {
            getEndTime: function(t, h, m){
                return this.$moment(t,  'HH:mm:ss').add(h,  'hours').add(m,  'minutes').format(this.$settings.TIMEFROMAT);
            },
            getHours: function(h, m){
                return ((h*60 + m)/60).toFixed(2);
            },
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
