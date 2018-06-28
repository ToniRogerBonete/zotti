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
                                <button type="submit" @click.prevent="getItem" class="btn btn-default" data-toggle="tooltip" data-placement="top" title="Digiite algo que deseja encontrar">
                                    <i class="fas fa-search"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                    <div class="form-group col text-right">
                        <router-link v-if="this.verificaPermissao('usuario-create')" :to="{ name: 'painel.usuarios.create' }" class="btn btn-success" data-toggle="tooltip" data-placement="top" title="Adicionar novo usuário">
                            <i class="fas fa-plus"></i> <span class="d-none d-md-inline-block">Novo usuário</span>
                        </router-link>
                    </div>
                </div>
            </form>
            <div class="row">
                <div class="col-md-12">
                    <table v-if="itens.length>0" class="table table-hover table-light table-bordered small">
                        <thead>
                        <tr>
                            <th scope="col">Nome</th>
                        </tr>
                        </thead>
                        <tbody>
                            <tr v-for="(item,index) in itens" @click.prevent="redirectItem('/painel/usuarios/edit/' + item.id)" style="cursor: pointer">
                                <td>
                                    {{item.name}}
                                </td>
                            </tr>
                        </tbody>
                    </table>
                    <div v-if="itens.length<1" class="alert alert-warning mt-3">
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
                itens: {},
                currentPage: null,
                totalRows: null,
                perPage: null,
                lastPage: null,
                breadcrumb: {
                    items: [{
                        text: 'Dashboard',
                        to: { name: 'painel.dashboard.index' },
                    }, {
                        text: 'Lista usuários',
                        active: true
                    }]
                }
            }
        },
        methods: {
            getItem() {
                self = this;
                axios({
                    method: 'get',
                    url: '/api/usuario?page=' + this.currentPage + '&filtro=' + this.filtro
                })
                .then(function (response) {
                    var item = response.data;
                    self.itens = item.data;
                    self.currentPage = item.current_page;
                    self.totalRows = item.total;
                    self.perPage = item.per_page;
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
                if(this.verificaPermissao('usuario-edit')) {
                    this.$router.push({ path: url });
                }
            }
        },
        watch: {
            currentPage() {
                this.getItem();
            },
        },
        mounted() {
            this.getItem();
        }
    }
</script>