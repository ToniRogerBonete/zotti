<template>
    <div>
        <formulario id="formCurso" :action="action" :method="method" enctype="" :token="token" css="">
            <input v-model="form.id" type="hidden" name="id">
            <div class="form-row">
                <div class="form-group col-md-12">
                    <label>Nome do usuário</label>
                    <input v-model="form.name" ref="name" type="text" class="form-control form-control-lg" id="name" placeholder="digite um nome">
                </div>
            </div>
            <h5>Dados de acesso</h5>
            <div class="form-row">
                <div class="form-group col-md-3">
                    <label>E-mail</label>
                    <input v-model="form.email" type="text" class="form-control" id="email" placeholder="digite um e-mail">
                </div>
                <div class="form-group col-md-3">
                    <label>Senha</label>
                    <input v-model="form.password" type="password" class="form-control" id="password" placeholder="">
                </div>
                <div class="form-group col-md-3">
                    <label>Confirmar senha</label>
                    <input v-model="form.password_confirmation" type="password" class="form-control" id="password_confirmation" placeholder="">
                </div>
            </div>
            <h5>Administração de papéis</h5>
            <div class="form-row">
                <div class="form-group col-md-12">
                    <div class="col-lg-12">
                        <div class="row">
                            <div v-for="(item,index) in roles" class="col-2 mt-2 p-0">
                                <div class="custom-control custom-radio custom-control-inline">
                                    <input v-model="form.role" type="radio" :id="'customRadio' + index" name="role" :value="item.id" class="custom-control-input">
                                    <label class="custom-control-label" :for="'customRadio' + index">{{item.name}}</label>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <hr class="mb-3">
            <div class="form-group text-right mb-0">
                <router-link :to="{ name: 'painel.usuarios.index' }" class="btn btn-link rounded-0">Cancelar</router-link>
                <button type="submit" class="btn btn-success rounded-0" @click.prevent="submitForm('1')"><i class="fas fa-save"></i> Salvar</button>
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
                    email: '',
                    password: '',
                    password_confirmation: '',
                    role: ''
                },
                breadcrumb: {
                    items: [{
                        text: 'Dashboard',
                        href: '/dashboard'
                    }, {
                        text: 'Lista usuário',
                        href: '/usuarios'
                    }, {
                        text: 'Novo usuário',
                        active: true
                    }]
                },
                token: Laravel.token,
                roles: {}
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
                        <p class="mb-0"><i class="fa fa-check" aria-hidden="true"></i> ' + response.data.data + '</p>\
                    </div>';
                    self.msgErrorSuccess(true, self.msgError);
                })
                .catch(function (error) {
                    self.classErrorSuccess(error);
                });
            },
            getUsuario() {
                var self = this;
                axios({
                    method: 'get',
                    url: '/api/usuario/' + this.id + '/edit',
                })
                .then(function (response) {
                    self.form.id = response.data.id;
                    self.form.name = response.data.name;
                    self.form.email = response.data.email;
                    self.form.role = response.data.roles[0].id;
                })
                .catch(function (error) {
                });
            },
            getRoles() {
                var self = this;
                axios({
                    method: 'get',
                    url: '/api/role',
                })
                .then(function (response) {
                    self.roles = response.data;
                })
                .catch(function (error) {
                });
            }
        },
        mounted() {
            if(this.id) {
                this.getUsuario();
            }
            this.getRoles();
            Vue.nextTick(() => this.$refs.name.focus());
        },
    }
</script>