<template>
    <div>
        <formulario id="formCurso" :action="action" :method="method" enctype="" :token="token" css="">
            <input v-model="form.id" type="hidden" name="id">
            <div class="form-row">
                <div class="form-group col-md-3">
                    <label>Nome da permissão</label>
                    <input v-model="form.name" ref="name" type="text" class="form-control" id="name" placeholder="digite um nome">
                </div>
                <div class="form-group col-md-6">
                    <label>Descrição</label>
                    <input v-model="form.description" type="text" class="form-control" id="description" placeholder="digite uma descrição">
                </div>
            </div>
            <h5>Administração de permissões</h5>
            <div class="form-row">
                <div class="form-group col-md-12">
                    <div class="col-lg-12">
                        <div class="row">
                            <div v-for="(item,index) in permissions" class="col-3 mt-2 p-0">
                                <div class="custom-control custom-checkbox custom-control-inline">
                                    <input v-model="form.permission" type="checkbox" :id="'customCheck' + index" :value="item.id" class="custom-control-input">
                                    <label class="custom-control-label" :for="'customCheck' + index">{{item.name}}</label>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <hr class="mb-3">
            <div class="form-group text-right mb-0">
                <router-link :to="{ name: 'painel.papeis.index' }" class="btn btn-link">Cancelar</router-link>
                <button type="submit" class="btn btn-success" @click.prevent="submitForm('1')"><i class="fas fa-save"></i> Salvar</button>
            </div>
        </formulario>
    </div>
</template>

<script>

    import Breadcrumb from "bootstrap-vue/src/components/breadcrumb/breadcrumb";
    import Formulario from "../Formulario";

    export default {
        components: {
            Formulario,
            Breadcrumb
        },
        props: ['id','action','method'],
        data: function() {
            return {
                form: {
                    id: '',
                    name: '',
                    description: '',
                    permission: []
                },
                token: Laravel.token,
                permissions: []
            }
        },
        methods: {
            submitForm() {
                var self = this;
                axios({
                    method: this.method,
                    url: this.action,
                    data: this.form,
                })
                .then(function (response) {
                    self.msgError = '<div class="alert alert-success " style="margin-bottom: 0;">\
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>\
                        <p class="mb-0"><i class="fa fa-check" aria-hidden="true"></i> ' + response.data + '</p>\
                    </div>';
                    self.$router.push('/painel/papeis');
                    self.msgErrorSuccess(true, self.msgError);
                })
                .catch(function (error) {
                    self.classErrorSuccess(error);
                });
            },
            getPapel() {
                var self = this;
                axios({
                    method: 'get',
                    url: '/api/role/' + this.id + '/edit',
                })
                .then(function (response) {
                    self.form.id = response.data.id;
                    self.form.name = response.data.name;
                    self.form.description = response.data.description;
                    $.each(response.data.permissions, function (index, value) {
                        self.form.permission[index] = value['id'];
                    });
                })
                .catch(function (error) {
                });
            },
            getPermissoes() {
                var self = this;
                axios({
                    method: 'get',
                    url: '/api/permission',
                })
                .then(function (response) {
                    self.permissions = response.data;
                })
                .catch(function (error) {
                });
            }
        },
        mounted() {
            if(this.id) {
                this.getPapel();
            }
            this.getPermissoes();
            Vue.nextTick(() => this.$refs.name.focus());
        },
    }
</script>