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
                                <button type="submit" @click.prevent="getItens" class="btn btn-default">
                                    <i class="fas fa-search"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                    <div class="form-group col text-right">
                        <router-link v-if="this.verificaPermissao('produto-create')" :to="{ name: 'painel.produtos.create' }" class="btn btn-success">
                            <i class="fas fa-plus"></i> <span class="d-none d-md-inline-block">NOVO PRODUTO</span>
                        </router-link>
                    </div>
                </div>
            </form>
            <div class="row">
                <div class="col-md-12">
                    <table class="table table-hover table-light border-left-0 border-right-0 border-bottom-0">
                        <tbody v-for="(item,index) in produtos">
                        <tr @click.prevent="redirectItem('/painel/produtos/edit/' + item.id)" class="table-secondary" style="cursor: pointer">
                            <td style="width: 40%;"><strong>{{item.nome}}</strong></td>
                            <td class="text-center">Cód. <strong>{{item.codigo}}</strong></td>
                            <td class="text-center">Unid. <strong>{{item.unidade_estoque}}</strong></td>
                            <td class="text-center">Prateleira <strong>{{item.prateleira}}</strong></td>
                            <td class="text-center">Gaveta <strong>{{item.gaveta}}</strong></td>
                        </tr>
                        <tr @click.prevent="redirectItem('/painel/produtos/edit/' + item.id)" style="cursor: pointer">
                            <td colspan="5" class="p-0">
                                <table class="table table-hover table-bordered small m-0">
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
                                        <td class="pl-2 pt-1 pb-1" style="width: 20%"><h6>{{itenl.lista.descricao}}</h6></td>
                                        <td class="pl-2 pt-1 pb-1 text-center"><h6>{{itenl.preco}}</h6></td>
                                        <td class="pl-2 pt-1 pb-1 text-center"><h6>{{itenl.indice_venda}}</h6></td>
                                        <td class="pl-2 pt-1 pb-1 text-center"><h6>{{itenl.tipo}}</h6></td>
                                        <td class="pl-2 pt-1 pb-1 text-center"><h6>{{itenl.indice_compra}}</h6></td>
                                        <td class="pl-2 pt-1 pb-1 text-center"><h6>{{itenl.codigo_material}}</h6></td>
                                        <td class="pl-2 pt-1 pb-1 text-center" style="width: 10%"><h5 class="mb-0"> {{itenl.preco*itenl.indice_venda/100}}</h5></td>
                                    </tr>
                                </table>
                            </td>
                        </tr>
                        <tr class="border-left-0 border-right-0">
                            <td colspan="5" class="p-1 border-left-0 border-right-0 border-bottom-0">
                            </td>
                        </tr>
                        </tbody>
                        <tfoot>
                        <tr v-if="totalRows==0" style="cursor: pointer">
                            <td class="text-center" colspan="5">
                                <i class="fas fa-info-circle fa-lg text-warning" aria-hidden="true"></i> Ainda não existem cadastros de produtos
                            </td>
                        </tr>
                        </tfoot>
                    </table>
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