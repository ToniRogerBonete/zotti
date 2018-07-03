<template>
    <div>
        <div class="card bg-white">
            <div class="card-header ml-0 d-print-none">
                <breadcrumb class="bg-transparent p-0 mb-0" :items="breadcrumb.items"></breadcrumb>
            </div>
            <div class="card-body">
            </div>
        </div>
    </div>
</template>

<script>
    import Breadcrumb from "bootstrap-vue/src/components/breadcrumb/breadcrumb";

    export default {
        components: {
            Breadcrumb
        },
        data: function() {
            return {
                breadcrumb: {
                    items: [{
                        text: 'Dashboard',
                        href: ''
                    }]
                }
            }
        },
        methods: {
            index: function() {
            },
        },
        mounted() {
        }
    }
</script>