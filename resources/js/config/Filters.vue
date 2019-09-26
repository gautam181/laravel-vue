<script>
    const filters = {
        project_list: {
            'keyword': '',
            'start_date': '',
            'end_date': '',
            'created_range':{id: '0', value: 'Any Time'},
            'due_start_date': '',
            'due_end_date': '',
            'due_date_range':{id: '0', value: 'Any Time'},
            'owner':[],
        },
        project_tickets: {
            'keyword': '',
            'start_date': '',
            'end_date': '',
            'created_range':{id: '0', value: 'Any Time'},
            'due_start_date': '',
            'due_end_date': '',
            'due_date_range':{id: '0', value: 'Any Time'},
            'assigned_to':[],
        },
        project_time: {
            'keyword': '',
            'start_date': '',
            'end_date': '',
            'created_range':{id: '0', value: 'Any Time'},
            'logged_by':[],
        },
        project_files: {
            'keyword': '',
            'start_date': '',
            'end_date': '',
            'created_range':{id: '0', value: 'Any Time'},
            'uploaded_by':[],
        }
    }

    export default filters
</script>
