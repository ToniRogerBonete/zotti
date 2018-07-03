<template>
    <div>
        <div class="card bg-white">
            <div class="card-header ml-0 d-print-none">
                <breadcrumb class="bg-transparent p-0 mb-0" :items="breadcrumb.items"></breadcrumb>
            </div>
            <div class="card-body">
                <form class="mb-3">
                    <div class="row d-print-none">
                        <div class="col-9 col-sm-7 col-lg-8">
                            <div class="row d-print-none">
                               <div class="col-9 col-sm-7 col-lg-4">
                                    <div class="input-group">
                                        <select v-model="tipo" class="form-control">
                                            <option value="1">Tudo</option>
                                            <option value="2">Código Zotti</option>
                                            <option value="3">Descrição</option>
                                            <option value="4">Código material</option>
                                            <option value="5">Código original</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-9 col-sm-7 col-lg-6">
                                    <div class="input-group">
                                        <input v-model="filtro" ref="filtro"  type="text" class="form-control" placeholder="procure por...">
                                        <div class="input-group-append">
                                            <button type="submit" @click.prevent="getItens" class="btn btn-default" data-toggle="tooltip" data-placement="top" title="Digiite algo que deseja encontrar">
                                                <i class="fas fa-search"></i>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
                <div class="row">
                    <div class="col-md-12">
                        <table v-if="produtos.length>0" class="table table-hover table-bordered table-striped small mb-0 border-0">
                            <tbody v-for="(item,index) in produtos">
                            <tr>
                                <td style="width: 10%;">Cod. Zotti <strong>{{item.codigo}}</strong></td>
                                <td class="text-left"><h6 class="mb-0">{{item.nome}}</h6></td>
                                <td class="text-center" style="width: 12%;">Unidade <strong>{{item.unidade_estoque}}</strong></td>
                                <td class="text-center" style="width: 12%;">Prateleira <strong>{{item.prateleira}}</strong></td>
                                <td class="text-center" style="width: 10%;">Gaveta <strong>{{item.gaveta}}</strong></td>
                                <td v-if="permission('produto-edit')" class="text-center pt-2 pb-1" style="width: 5%;">
                                    <button @click.prevent="redirectItem('/painel/produtos/edit/' + item.id)" class="btn btn-success btn-sm" data-toggle="tooltip" data-placement="top" title="Editar produto">
                                        <i class="fas fa-edit"></i>
                                    </button>
                                </td>
                            </tr>
                            <tr>
                                <td colspan="6">
                                    <div class="row">
                                        <div v-for="(itemp,indexp) in item.lista_precos" class="col-lg-4">
                                            {{itemp.lista.descricao}}
                                            <strong>{{itemp.codigo_material}}</strong> <i class="fas fa-long-arrow-alt-right"></i>
                                            <strong>{{itemp.preco * itemp.indice_venda / 100}}</strong>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td colspan="6" class="bg-white border-0 p-1">
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
                tipo: 1,
                currentPage: null,
                totalRows: null,
                perPage: null,
                lastPage: null,
                breadcrumb: {
                    items: [{
                        text: 'Dashboard',
                        to: { name: 'painel.dashboard.index' },
                    }, {
                        text: 'Balcão',
                        to: '',
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
                    url: '/api/produto/filtro?page=' + this.currentPage + '&filtro=' + this.filtro + '&tipo=' + this.tipo
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
        },
        watch: {
            currentPage() {
                this.getItens();
            },
        },
        mounted() {
            this.getItens();
            this.$refs.filtro.focus();
        }
    }
</script>