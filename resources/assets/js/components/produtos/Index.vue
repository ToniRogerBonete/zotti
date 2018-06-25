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
                        <a href="/painel/papeis/create" class="btn btn-success rounded-0">
                            <i class="fas fa-plus"></i> <span class="d-none d-md-inline-block">Novo papel</span>
                        </a>
                    </div>
                </div>
            </form>
            <div class="row">
                <div class="col-md-12">
                    <table class="table table-hover table-light table-bordered small">
                        <thead>
                        <tr>
                            <th scope="col">Nome</th>
                            <th scope="col">Descrição</th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr v-for="(item,index) in papeis" @click.prevent="redirectItem('/painel/papeis/edit/' + item.id);" style="cursor: pointer">
                            <td>
                                {{item.name}}
                            </td>
                            <td>
                                {{item.description}}
                            </td>
                        </tr>
                        <tr v-if="totalRows==0" style="cursor: pointer">
                            <td class="text-center" colspan="2">
                                <i class="fas fa-info-circle fa-lg text-warning" aria-hidden="true"></i> Ainda não existem cadastros de papéis
                            </td>
                        </tr>
                        </tbody>
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
                papeis: {}
            }
        },
        methods: {
            getItens() {
                self = this;
                axios({
                    method: 'get',
                    url: '/api/role/filtro?page=' + this.currentPage + '&filtro=' + this.filtro
                })
                    .then(function (response) {
                        self.papeis = response.data.data;
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
                this.$router.push({ path: url });
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