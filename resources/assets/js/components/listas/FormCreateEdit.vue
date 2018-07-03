<template>
    <div>
        <formulario id="formCurso" :action="action" :method="method" enctype="" :token="token" css="">
            <input v-model="form.id" type="hidden" name="id">
            <div class="form-row">
                <div class="form-group col-md-12">
                    <label>Descrição</label>
                    <input v-model="form.descricao" ref="descricao" type="text" class="form-control" id="descricao" placeholder="digite uma descrição">
                </div>
            </div>
            <div class="form-row">
                <div class="form-group col-md-9">
                    <label>Contato</label>
                    <input v-model="form.contato" type="text" class="form-control" id="contato" placeholder="digite um contato">
                </div>
                <div class="form-group col-md-3">
                    <label>Telefone</label>
                    <input v-model="form.telefone" type="text" class="form-control" id="telefone" placeholder="digite um telefone" v-mask="'(##)#####-####'">
                </div>
            </div>
            <div class="form-row">
                <div class="form-group col-md-12">
                    <label>Observações</label>
                    <textarea v-model="form.observacao" rows="3" class="form-control" id="observacao" placeholder="digite uma observação"></textarea>
                </div>
            </div>
            <hr class="mb-3">
            <div class="form-group text-right mb-0">
                <router-link :to="{ name: 'painel.listas.index' }" class="btn btn-link rounded-0">Cancelar</router-link>
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
                    descricao: '',
                    contato: '',
                    telefone: '',
                    observacao: '',
                },
                token: Laravel.token,
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
                    self.msgErrorSuccess(true, self.msgError);
                    self.$router.push('/painel/listas');
                })
                .catch(function (error) {
                    self.classErrorSuccess(error);
                });
            },
            getLista() {
                var self = this;
                axios({
                    method: 'get',
                    url: '/api/lista/' + this.id + '/edit',
                })
                .then(function (response) {
                    self.form.id = response.data.id;
                    self.form.descricao = response.data.descricao;
                    self.form.contato = response.data.contato;
                    self.form.telefone = response.data.telefone;
                    self.form.observacao = response.data.observacao;
                })
                .catch(function (error) {
                });
            },
        },
        mounted() {
            if(this.id) {
                this.getLista();
            }
            this.$refs.descricao.focus();
        },
    }
</script>