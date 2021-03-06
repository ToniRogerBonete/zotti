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
                                        <input v-model="filtro" ref="filtro" type="text" class="form-control" placeholder="procure por...">
                                        <div class="input-group-append">
                                            <button type="submit" @click.prevent="getItens" class="btn btn-default" data-toggle="tooltip" data-placement="top" title="Digiite algo que deseja encontrar">
                                                <i class="fas fa-search"></i>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="form-group col text-right mb-0">
                            <router-link v-if="this.verificaPermissao('produto-create')" :to="{ name: 'painel.produtos.create' }" class="btn btn-success" data-toggle="tooltip" data-placement="top" title="Adicionar novo produto">
                                <i class="fas fa-plus"></i> <span class="d-none d-md-inline-block">Novo produto</span>
                            </router-link>
                        </div>
                    </div>
                </form>
                <div class="row">
                    <div class="col-md-12">
                        <table v-if="produtos.length>0" class="table table-hover table-bordered table-striped small mb-0">
                            <thead>
                            <tr>
                                <th style="width: 8%;">Cód. Zotti</th>
                                <th class="text-left" style="width: 40%;">Descrição</strong></th>
                                <th class="text-center">Unidade</strong></th>
                                <th class="text-center">Prateleira</th>
                                <th class="text-center">Gaveta</th>
                                <th class="text-center" style="width: 5%;">
                                </th>
                            </tr>
                            </thead>
                            <tbody>
                            <tr v-for="(item,index) in produtos" style="cursor: pointer">
                                <td @click.prevent="redirectItem('/painel/produtos/edit/' + item.id)">{{item.codigo}}</td>
                                <td @click.prevent="redirectItem('/painel/produtos/edit/' + item.id)" class="text-left">{{item.nome}}</td>
                                <td @click.prevent="redirectItem('/painel/produtos/edit/' + item.id)" class="text-center">{{item.unidade_estoque}}</td>
                                <td @click.prevent="redirectItem('/painel/produtos/edit/' + item.id)" class="text-center">{{item.prateleira}}</td>
                                <td @click.prevent="redirectItem('/painel/produtos/edit/' + item.id)" class="text-center">{{item.gaveta}}</td>
                                <td class="text-center pt-2 pb-1" style="width: 5%;">
                                    <button @click.prevent="removeProduto(item.id,index)" v-if="permission('produto-create')" class="btn btn-danger btn-sm" data-toggle="tooltip" data-placement="top" title="Excluir produto">
                                        <i class="fas fa-times"></i>
                                    </button>
                                </td>
                            </tr>
                            </tbody>
                        </table>
                        <div v-if="produtos.length<1" class="alert alert-warning mt-3">
                            <span v-if="filtro"><i class="fas fa-info-circle fa-lg text-warning" aria-hidden="true"></i> Não foram encontrado produtos com <strong>{{filtro}}</strong></span>
                            <span v-if="!filtro"><i class="fas fa-info-circle fa-lg text-warning" aria-hidden="true"></i> Ainda não existem cadastros de produtos</span>
                        </div>
                        <b-pagination v-if="lastPage>1" align="right" :total-rows="totalRows" v-model="currentPage" :per-page="perPage" class="d-print-none pt-3"></b-pagination>
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
        data: function () {
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
                        to: {name: 'painel.dashboard.index'},
                    }, {
                        text: 'Lista produtos',
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
                if (this.verificaPermissao('produto-edit')) {
                    this.$router.push({path: url});
                }
            },
            permission(perm) {
                return this.verificaPermissao(perm);
            },
            removeProduto(id, index) {
                var self = this;
                $.confirm({
                    animation: 'none',
                    closeAnimation: 'scale',
                    title: 'Confirme!',
                    content: 'Você deseja confirmar a exclusão do produto?',
                    buttons: {
                        Confirmar: {
                            btnClass: 'btn-blue',
                            action: function () {
                                self.produtos.splice(index, 1);
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
                        Cancelar: function () {
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
            this.$refs.filtro.focus();
            this.verificaPermissao('produto-edit','/painel/balcao');
        }
    }
</script>