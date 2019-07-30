<script>
    const TITLE = 'Laravel Vue App';
    const TITLE_SEP = ' - ';
    export default {
        name: "Title",
        props: ['title'],
        watch: {
            title: {
                immediate: true,
                handler() {
                    document.title = this.title + TITLE_SEP + TITLE;
                }
            }
        },
        render () {
        },
    }
</script>
