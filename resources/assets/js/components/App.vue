<template>
    <div class="container">
        <router-view class="mb-8"></router-view>
        <progress-bar ref="progressBar"></progress-bar>
        <msg-error-success></msg-error-success>
    </div>
</template>

<script>
    import MsgErrorSuccess from "./MsgErrorSuccess";
    import ProgressBar from "./ProgressBar";

    export default {
        components: {
            ProgressBar,
            MsgErrorSuccess
        }
    }
</script>

<style scoped>

</style>