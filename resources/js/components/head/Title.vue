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
                    if (this.title != undefined)
                        document.title = this.title + TITLE_SEP + TITLE;
                    else if(this.$route.meta.title)
                        document.title = this.$route.meta.title;
                    else
                        document.title = TITLE;
                }
            }
        },
        render () {
        },
    }
</script>
