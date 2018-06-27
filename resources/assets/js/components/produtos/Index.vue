<template>
    <div>
        <div class="bg-white p-3 mb-5">
            <div class="row d-print-none">
                <div class="col-md-12 border-bottom mb-3">
                    <breadcrumb class="bg-transparent p-0" :items="breadcrumb.items"></breadcrumb>
                </div>
            </div>
            <form>
                <div class="row d-print-none">
                    <div class="form-group col-9 col-sm-7 col-lg-4">
                        <div class="input-group">
                            <input v-model="filtro" type="text" class="form-control" placeholder="procure por...">
                            <div class="input-group-append">
                                <button type="submit" @click.prevent="getItens" class="btn btn-default" data-toggle="tooltip" data-placement="top" title="Digiite algo que deseja encontrar">
                                    <i class="fas fa-search"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                    <div class="form-group col text-right">
                        <router-link v-if="this.verificaPermissao('produto-create')" :to="{ name: 'painel.produtos.create' }" class="btn btn-success" data-toggle="tooltip" data-placement="top" title="Adicionar novo produto">
                            <i class="fas fa-plus"></i> <span class="d-none d-md-inline-block">Novo produto</span>
                        </router-link>
                    </div>
                </div>
            </form>
            <div class="row">
                <div class="col-md-12">
                    <table v-if="produtos.length>0" class="table table-hover border-left-0 border-right-0 border-bottom-0">
                        <tbody v-for="(item,index) in produtos">
                        <tr class="border-left border-right tab-pane" style="cursor: pointer">
                            <td @click.prevent="redirectItem('/painel/produtos/edit/' + item.id)" style="width: 40%;"><strong>{{item.nome}}</strong></td>
                            <td @click.prevent="redirectItem('/painel/produtos/edit/' + item.id)" class="text-center">Cód. <strong>{{item.codigo}}</strong></td>
                            <td @click.prevent="redirectItem('/painel/produtos/edit/' + item.id)" class="text-center">Unid. <strong>{{item.unidade_estoque}}</strong></td>
                            <td @click.prevent="redirectItem('/painel/produtos/edit/' + item.id)" class="text-center">Prateleira <strong>{{item.prateleira}}</strong></td>
                            <td @click.prevent="redirectItem('/painel/produtos/edit/' + item.id)" class="text-center">Gaveta <strong>{{item.gaveta}}</strong></td>
                            <td class="text-center" style="width: 5%;">
                                <button @click.prevent="removeProduto(item.id,index)" v-if="permission('produto-create')" class="btn bg-transparent btn-sm" data-toggle="tooltip" data-placement="top" title="Excluir produto">
                                    <i class="fas fa-times-circle fa-lg text-danger"></i>
                                </button>
                            </td>
                        </tr>
                        <tr v-if="item.lista_precos.length>0" @click.prevent="redirectItem('/painel/produtos/edit/' + item.id)" class="border-left border-right" style="cursor: pointer">
                            <td colspan="6" class="p-0">
                                <table class="table table-bordered small m-0">
                                    <tr>
                                        <td class="p-2">Descrição</td>
                                        <td class="p-2 text-center">Preço</td>
                                        <td class="p-2 text-center">Indice venda</td>
                                        <td class="p-2 text-center">Tipo</td>
                                        <td class="p-2 text-center">Indice compra</td>
                                        <td class="p-2 text-center">Cód. material</td>
                                        <td class="p-2 text-center" style="width: 15%">Preço venda</td>
                                    </tr>
                                    <tr v-for="(itenl,index) in item.lista_precos" @click.prevent="redirectItem('/painel/produtos/edit/' + item.id)" style="cursor: pointer">
                                        <td class="pl-2 pt-2 pb-2" style="width: 20%"><h6 class="mb-0">{{itenl.lista.descricao}}</h6></td>
                                        <td class="pl-2 pt-2 pb-2 text-center"><h6 class="mb-0">{{itenl.preco}}</h6></td>
                                        <td class="pl-2 pt-2 pb-2 text-center"><h6 class="mb-0">{{itenl.indice_venda}}</h6></td>
                                        <td class="pl-2 pt-2 pb-2 text-center"><h6 class="mb-0">{{itenl.tipo}}</h6></td>
                                        <td class="pl-2 pt-2 pb-2 text-center"><h6 class="mb-0">{{itenl.indice_compra}}</h6></td>
                                        <td class="pl-2 pt-2 pb-2 text-center"><h6 class="mb-0">{{itenl.codigo_material}}</h6></td>
                                        <td class="pl-2 pt-2 pb-2 text-center" style="width: 10%"><h6 class="mb-0"> {{itenl.preco*itenl.indice_venda/100}}</h6></td>
                                    </tr>
                                </table>
                            </td>
                        </tr>
                        <tr class="border-left-0 border-right-0">
                            <td colspan="6" class="p-1 border-left-0 border-right-0 border-bottom-0">
                            </td>
                        </tr>
                        </tbody>
                    </table>
                    <div v-if="produtos.length<1" class="alert alert-warning mt-3">
                        <span v-if="filtro"><i class="fas fa-info-circle fa-lg text-warning" aria-hidden="true"></i> Não foram encontrado produtos com <strong>{{filtro}}</strong></span>
                        <span v-if="!filtro"><i class="fas fa-info-circle fa-lg text-warning" aria-hidden="true"></i> Ainda não existem cadastros de produtos</span>
                    </div>
                    <b-pagination v-if="lastPage>1" align="right" :total-rows="totalRows" v-model="currentPage" :per-page="perPage" class="d-print-none"></b-pagination>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    import Breadcrumb from "bootstrap-vue/src/components/breadcrumb/breadcrumb";
    import bPagination from 'bootstrap-vue/es/components/pagination/pagination';

    export default {
        components: {
            bPagination,
            Breadcrumb
        },
        data: function() {
            return {
                filtro: '',
                currentPage: null,
                totalRows: null,
                perPage: null,
                lastPage: null,
                breadcrumb: {
                    items: [{
                        text: 'Dashboard',
                        href: '/painel/dashboard'
                    }, {
                        text: 'Lista produtos',
                        href: ''
                    }]
                },
                mostraOcultaPaginacao: false,
                produtos: {}
            }
        },
        methods: {
            getItens() {
                self = this;
                axios({
                    method: 'get',
                    url: '/api/produto/filtro?page=' + this.currentPage + '&filtro=' + this.filtro
                })
                .then(function (response) {
                    self.produtos = response.data.data;
                    self.currentPage = response.data.current_page;
                    self.totalRows = response.data.total;
                    self.perPage = response.data.per_page;
                    self.lastPage = response.data.last_page;
                    $(function () {
                        $('[data-toggle="tooltip"]').tooltip()
                    });
                })
                .catch(function (error) {
                });
                Vue.nextTick(() =>
                    $('[data-toggle="tooltip"]').tooltip()
                );
            },
            redirectItem(url) {
                if(this.verificaPermissao('produto-edit')) {
                    this.$router.push({path: url});
                }
            },
            permission(perm) {
                return this.verificaPermissao(perm);
            },
            removeProduto(id,index) {
                var self = this;
                $.confirm({
                    title: 'Confirme!',
                    content: 'Você deseja confirmar a exclusão do produto?',
                    buttons: {
                        confirmar: {
                            btnClass: 'btn-blue',
                            action: function () {
                                self.produtos.splice(index,1);
                                axios({
                                    method: 'DELETE',
                                    url: '/api/produto/' + id
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
                        cancelar: function () {
                        },
                    }
                });
            }
        },
        watch: {
            currentPage() {
                this.getItens();
            },
        },
        mounted() {
            this.getItens();
        }
    }
</script>