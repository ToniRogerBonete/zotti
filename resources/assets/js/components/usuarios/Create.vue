<template>
    <div>
        <div class="card bg-white">
            <div class="card-header ml-0 d-print-none">
                <breadcrumb class="bg-transparent p-0 mb-0" :items="breadcrumb.items"></breadcrumb>
            </div>
            <div class="card-body">
                <form-create-edit ref="formularioContato" action="/api/usuario" :id="id" method="POST"></form-create-edit>
            </div>
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
                        to: { name: 'painel.dashboard.index' },
                    }, {
                        text: 'Lista usuários',
                        to: { name: 'painel.usuarios.index' },
                    }, {
                        text: 'Novo usuário',
                        active: true
                    }]
                },
            }
        },
        mounted() {
            this.verificaPermissao('usuario-create','/painel/balcao');
        },
    }
</script>