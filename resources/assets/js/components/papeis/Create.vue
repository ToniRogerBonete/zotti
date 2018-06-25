<template>
    <div>
        <div class="bg-white p-3">
            <div class="row d-print-none">
                <div class="col-md-12 border-bottom mb-4">
                    <breadcrumb class="bg-transparent p-0" :items="breadcrumb.items"></breadcrumb>
                </div>
            </div>
            <form-create-edit ref="formularioPapel" action="/api/role" :id="id" method="POST"></form-create-edit>
        </div>
    </div>
</template>

<script>

    import Breadcrumb from "bootstrap-vue/src/components/breadcrumb/breadcrumb";
    import FormCreateEdit from "./FormCreateEdit";

    export default {
        components: {
            FormCreateEdit,
            Breadcrumb
        },
        props:{
            id: {
                default: null,
            }
        },
        data: function() {
            return {
                token: Laravel.token,
                breadcrumb: {
                    items: [{
                        text: 'Dashboard',
                        href: '/painel/dashboard'
                    }, {
                        text: 'Lista papéis',
                        href: '/painel/papeis'
                    }, {
                        text: 'Novo papel',
                        active: true
                    }]
                },
            }
        },
        mounted() {
        },
    }
</script>