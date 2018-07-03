<template>
    <div>
        <formulario id="formCurso" :action="action" :method="method" enctype="" :token="token" css="">
            <input v-model="form.id" type="hidden" name="id">
            <div class="form-row">
                <div class="form-group col-md-2">
                    <label>Código Zotti</label>
                    <input v-model="form.codigo" ref="codigo" type="text" maxlength="5" pattern="[0-9]{10}" class="form-control" id="codigo">
                </div>
                <div class="form-group col-md-4">
                    <label>Código original</label>
                    <input v-model="form.codigo_original" type="text" maxlength="30" pattern="[0-9]{10}" class="form-control" id="codigo_original" >
                </div>
            </div>
            <div class="form-row">
                <div class="form-group col-md-10">
                    <label>Descrição</label>
                    <input v-model="form.nome" type="text" maxlength="255" class="form-control" id="nome">
                </div>
            </div>
            <div class="form-row">
                <div class="form-group col-md-2">
                    <label>Unidade de estoque</label>
                    <input v-model="form.unidade_estoque" type="text" maxlength="3" class="form-control" id="unidade_estoque">
                </div>
                <div class="form-group col-md-2">
                    <label>Prateleira</label>
                    <input v-model="form.prateleira" type="text" maxlength="15" class="form-control" id="prateleira">
                </div>
                <div class="form-group col-md-2">
                    <label>Gaveta</label>
                    <input v-model="form.gaveta" type="text" maxlength="15" class="form-control" id="gaveta">
                </div>
            </div>
            <div class="form-row">
                <div class="form-group col-md-3">
                    <label>Grupo natureza de operação</label>
                    <input v-model="form.natureza_operacao" type="text" maxlength="20" class="form-control" id="natureza_operacao">
                </div>
                <div class="form-group col-md-3">
                    <label>Classificação fiscal(NCM)</label>
                    <input v-model="form.ncm" type="text" maxlength="8" class="form-control" id="ncm">
                </div>
                <div class="form-group col-md-4">
                    <label>Origem</label>
                    <select v-model="form.origem" class="form-control" id="origem">
                        <option value="0">0 - Nacional, exceto as indicadas nos códigos 3, 4, 5 e 8</option>
                        <option value="1">1 - Estrangeira - Importação direta, exceto a indicada no código 6</option>
                        <option value="2">2 - Estrangeira - Adquirida no mercado interno, exceto a indicada no código 7</option>
                        <option value="3">3 - Nacional, mercadoria ou bem com Conteúdo de Importação superior a 40% e inferior ou igual a 70%</option>
                        <option value="4">4 - Nacional, cuja produção tenha sido feita em conformidade com os processos produtivos básicos de que tratam as legislações citadas nos Ajustes</option>
                        <option value="5">5 - Nacional, mercadoria ou bem com Conteúdo de Importação inferior ou igual a 40%</option>
                        <option value="6">6 - Estrangeira - Importação direta, sem similar nacional, constante em lista da CAMEX</option>
                        <option value="7">7 - Estrangeira - Adquirida no mercado interno, sem similar nacional, constante em lista da CAMEX</option>
                        <option value="8">8 - Nacional, mercadoria ou bem com Conteúdo de Importação superior a 70%</option>
                    </select>
                </div>
                <div class="form-group col-md-2">
                    <label>Cest</label>
                    <input v-model="form.cest" type="text" maxlength="7" class="form-control" id="cest">
                </div>
            </div>
            <div class="form-row">
                <div class="form-group col-md-12">
                    <label>Observações</label>
                    <textarea v-model="form.observacao" row="4" class="form-control"></textarea>
                </div>
            </div>
            <div class="form-row mt-3">
                <div class="form-group col-md-12">
                    <div class="card">
                        <h6 class="card-header text-muted position-relative">
                            Lista de preços <button @click.prevent="addPreco" type="button" class="btn btn-success btn-sm float-right" style="position: absolute; top: 7px; right: 7px;" data-toggle="tooltip" data-placement="top" title="Adicionar novo item"><i class="fas fa-plus"></i> Novo item</button>
                        </h6>
                        <div class="card-body p-0">
                            <table class="table table-bordered table-hover mb-0 small">
                                <thead v-if="form.precos.length>0">
                                    <tr>
                                        <th scope="col" class="text-left" style="width:20%">Lista</th>
                                        <th scope="col" class="text-center" style="width:9%">Indice de venda</th>
                                        <th scope="col" class="text-center" style="width:10%">Preço</th>
                                        <th scope="col" class="text-center" style="width:5%">Tipo</th>
                                        <th scope="col" class="text-center" style="width:9%">Indice de compra</th>
                                        <th scope="col" class="text-center" style="width:12%">Código material</th>
                                        <th scope="col" class="text-center" style="width:3%"></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr v-for="(item,index) in form.precos">
                                        <td class="p-0">
                                            <select :id="'precos'+index+'lista_id'" v-model="item.lista_id" lista-description class="form-control rounded-0 border-0" data-live-search="true">
                                                <option value="">selecione uma lista</option>
                                                <option v-for="(itenl,index) in listas" :selected="item.lista_id == itenl.id ? true : false" :value="itenl.id">{{itenl.descricao}}</option>
                                            </select>
                                        </td>
                                        <td class="p-0"><money v-model="item.indice_venda" class="form-control rounded-0 border-0 text-center"></money></td>
                                        <td class="p-0"><money v-model="item.preco" class="form-control rounded-0 border-0 text-center"></money></td>
                                        <td class="p-0"><input v-model="item.tipo" type="text" maxlength="3" class="form-control rounded-0 border-0 text-center"></td>
                                        <td class="p-0"><money v-model="item.indice_compra" class="form-control rounded-0 border-0 text-center"></money></td>
                                        <td class="p-0"><input v-model="item.codigo_material" type="text" maxlength="20" class="form-control rounded-0 border-0 text-center"></td>
                                        <td class="p-0 text-center position-relative">
                                            <button @click.prevent="removeListaPreco(item.id,index)" type="button" class="btn btn-danger btn-sm" style="margin-top: 4px;" data-toggle="tooltip" data-placement="top" title="Excluir item">
                                                <i class="fas fa-times"></i>
                                            </button>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <hr class="mb-3">
            <div class="form-group text-right mb-0">
                <router-link :to="{ name: 'painel.produtos.index' }" class="btn btn-link rounded-0">Cancelar</router-link>
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
                    nome: '',
                    codigo: '',
                    codigo_original: '',
                    unidade_estoque: '',
                    prateleira: '',
                    gaveta: '',
                    natureza_operacao: '',
                    ncm: '',
                    origem: '',
                    cest: '',
                    observacao: '',
                    precos: []
                },
                token: Laravel.token,
                listas: []
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
                    self.getProduto();
                    self.$router.push('/painel/produtos');
                })
                .catch(function (error) {
                    self.classErrorSuccess(error);
                });
            },
            getProduto() {
                var self = this;
                axios({
                    method: 'get',
                    url: '/api/produto/' + this.id + '/edit',
                })
                .then(function (response) {
                    self.form.id = response.data.id;
                    self.form.nome = response.data.nome;
                    self.form.codigo = response.data.codigo;
                    self.form.codigo_original = response.data.codigo_original;
                    self.form.unidade_estoque = response.data.unidade_estoque;
                    self.form.prateleira = response.data.prateleira;
                    self.form.gaveta = response.data.gaveta;
                    self.form.natureza_operacao = response.data.natureza_operacao;
                    self.form.ncm = response.data.ncm;
                    self.form.origem = response.data.origem;
                    self.form.cest = response.data.cest;
                    self.form.observacao = response.data.observacao;
                    self.form.precos = response.data.lista_precos;
                    self.tooltip('[data-toggle="tooltip"]');
                })
                .catch(function (error) {
                });
            },
            getListas() {
                var self = this;
                axios({
                    method: 'get',
                    url: '/api/lista',
                })
                .then(function (response) {
                    self.listas = response.data;
                })
                .catch(function (error) {
                });
            },
            addPreco() {
                var preco = {
                   'id': '',
                   'lista_id': '',
                   'indice_venda': '',
                   'preco': '',
                   'tipo': '',
                   'indice_compra': '',
                   'codigo_material': ''
                };
                this.form.precos.push(preco);
            },
            removeListaPreco(id,index) {
                var self = this;
                $.confirm({
                    animation: 'none',
                    closeAnimation: 'scale',
                    title: 'Confirme!',
                    content: 'Você deseja confirmar a exclusão do item?',
                    buttons: {
                        Confirmar: {
                            btnClass: 'btn-blue',
                            action: function () {
                                self.form.precos.splice(index,1);
                                axios({
                                    method: 'DELETE',
                                    url: '/api/listapreco/' + id
                                })
                                .then(function (response) {
                                    self.msgError = '<div class="alert alert-success pb-0" style="margin-bottom: 0;">\
                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>\
                                    <p><i class="fa fa-check" aria-hidden="true"></i> ' + response.data + '</p>\
                                    </div>';
                                    self.msgErrorSuccess(true, self.msgError);
                                })
                                .catch(function (error) {
                                });
                            }
                        },
                        Cancelar: function () {
                        },
                    }
                });
            }
        },
        updated () {
            $('[lista-description]').selectpicker('refresh');
            $('[lista-description]').selectpicker({
                style: 'btn-select rounded-0 border-0'
            });
            this.tooltip('[data-toggle="tooltip"]');
        },
        mounted() {
            if(this.id) {
                this.getProduto();
            }
            this.getListas();
            this.$refs.codigo.focus();
            this.tooltip('[data-toggle="tooltip"]');
        },
    }
</script>