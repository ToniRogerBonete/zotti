<template>
    <div>
        <div class="bg-white p-3">
            <div class="row d-print-none">
                <div class="col-md-12 border-bottom mb-4">
                    <breadcrumb class="bg-transparent p-0" :items="breadcrumb.items"></breadcrumb>
                </div>
            </div>
            <form-create-edit ref="formularioContato" :action="'/api/lista/' + id" :id="id" method="PUT"></form-create-edit>
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
                breadcrumb: {
                    items: [{
                        text: 'Dashboard',
                        to: { name: 'painel.dashboard.index' },
                    }, {
                        text: 'Lista listas',
                        to: { name: 'painel.listas.index' },
                    }, {
                        text: 'Editar lista',
                        active: true
                    }]
                },
            }
        },
        mounted() {
        },
    }
</script>