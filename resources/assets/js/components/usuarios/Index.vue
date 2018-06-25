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
                                <button type="submit" @click.prevent="getCursos" class="btn btn-default">
                                    <i class="fas fa-search"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                    <div class="form-group col text-right">
                        <a href="/painel/usuarios/create" class="btn btn-success rounded-0">
                            <i class="fas fa-plus"></i> <span class="d-none d-md-inline-block">Novo usuário</span>
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
                        </tr>
                        </thead>
                        <tbody>
                            <tr v-for="(item,index) in courses" @click.prevent="redirectCurso('/painel/usuarios/edit/' + item.id);" style="cursor: pointer">
                                <td>
                                    {{item.name}}
                                </td>
                            </tr>
                            <tr v-if="semCurso" style="cursor: pointer">
                                <td class="text-center" colspan="2">
                                    <i class="fas fa-info-circle fa-lg text-warning" aria-hidden="true"></i> Ainda não existem cadastros de usuários
                                </td>
                            </tr>
                        </tbody>
                    </table>
                    <b-pagination v-if="mostraOcultaPaginacao" align="right" :total-rows="totalRows" v-model="currentPage" :per-page="perPage" class="d-print-none"></b-pagination>
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
                courses: '',
                currentPage: null,
                totalRows: null,
                perPage: null,
                breadcrumb: {
                    items: [{
                        text: 'Dashboard',
                        href: '/painel/dashboard'
                    }, {
                        text: 'Lista usuário',
                        href: ''
                    }]
                },
                semCurso: false,
                mostraOcultaPaginacao: false
            }
        },
        methods: {
            getCursos() {
                self = this;
                axios({
                    method: 'get',
                    url: '/api/usuario?page=' + this.currentPage + '&filtro=' + this.filtro
                })
                .then(function (response) {
                    var courses = response.data;
                    self.courses = courses.data;
                    self.currentPage = courses.current_page;
                    self.totalRows = courses.total;
                    self.perPage = courses.per_page;
                    if(!courses.data.length) {
                        self.semCurso = true;
                    } else {
                        self.mostraOcultaPaginacao = true;
                    }
                })
                .catch(function (error) {
                });
                Vue.nextTick(() =>
                    $('[data-toggle="tooltip"]').tooltip()
                );
            },
            redirectCurso(url) {
                this.$router.push({ path: url });
            }
        },
        watch: {
            currentPage() {
                this.getCursos();
            },
        },
        mounted() {
            this.getCursos();
        }
    }
</script>