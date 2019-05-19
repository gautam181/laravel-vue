<template>
    <div class="error-container">
        <h1><i class="fa fa-warning big-icon"></i>
             404</h1>
        <strong>Page Not Found</strong>
        <p>
            Sorry, but the page you are looking for has note been found. Try checking the URL for error, then hit the refresh button on your browser or try found something else in our app.

        </p>
        <a href="#/" class="btn btn-xs btn-success">Go back to dashboard</a>
    </div>
</template>

<script>
    export default {
        mounted() {
            console.log('Component mounted.')
        }
    }
</script>
