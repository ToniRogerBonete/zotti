import Vue from 'vue';
import Router from 'vue-router';
import Dashboard from '../components/dashboard/Index.vue';

//PERMISSÕES
import Usuario from '../components/usuarios/Index.vue';
import UsuarioEdit from '../components/usuarios/Edit.vue';
import UsuarioCreate from '../components/usuarios/Create.vue';

//PAPÉIS
import Papel from '../components/papeis/Index.vue';
import PapelEdit from '../components/papeis/Edit.vue';
import PapelCreate from '../components/papeis/Create.vue';

//PRODUTOS
import Produto from '../components/produtos/Index.vue';
import ProdutoEdit from '../components/produtos/Edit.vue';
import ProdutoCreate from '../components/produtos/Create.vue';

//LISTAS
import Lista from '../components/listas/Index.vue';
import ListaEdit from '../components/listas/Edit.vue';
import ListaCreate from '../components/listas/Create.vue';

//BALCÃO
import Balcao from '../components/balcao/Index.vue';

Vue.use(Router);

export default new Router({
    stor: [],
   routes: [
		{
			path: '*',
			redirect: '/painel/dashboard',
		},
		{//dashboard
			path: '/painel/dashboard',
			name: 'painel.dashboard.index',
			component: Dashboard,
		},

		{//usuários
		   path: '/painel/usuarios',
		   name: 'painel.usuarios.index',
		   component: Usuario,
		},
		{
		   path: '/painel/usuarios/edit/:id',
		   name: 'painel.usuarios.edit',
		   component: UsuarioEdit,
		   props: true,
		},
		{
		   path: '/painel/usuarios/create',
		   name: 'painel.usuarios.create',
		   component: UsuarioCreate,
		   props: true,
		},

		{//papéis
		   path: '/painel/papeis',
		   name: 'painel.papeis.index',
		   component: Papel,
		},
		{
		   path: '/painel/papeis/edit/:id',
		   name: 'painel.papeis.edit',
		   component: PapelEdit,
		   props: true,
		},
		{
			path: '/painel/papeis/create',
			name: 'painel.papeis.create',
			component: PapelCreate,
			props: true,
		},

       {//produtos
           path: '/painel/produtos',
           name: 'painel.produtos.index',
           component: Produto,
       },
       {
           path: '/painel/produtos/edit/:id',
           name: 'painel.produtos.edit',
           component: ProdutoEdit,
           props: true,
       },
       {
           path: '/painel/produtos/create',
           name: 'painel.produtos.create',
           component: ProdutoCreate,
           props: true,
       },

       {//listas
           path: '/painel/listas',
           name: 'painel.listas.index',
           component: Lista,
       },
       {
           path: '/painel/listas/edit/:id',
           name: 'painel.listas.edit',
           component: ListaEdit,
           props: true,
       },
       {
           path: '/painel/listas/create',
           name: 'painel.listas.create',
           component: ListaCreate,
           props: true,
       },

       {//balcão
           path: '/painel/balcao',
           name: 'painel.balcao.index',
           component: Balcao,
       }
   ],
   mode: 'history',
   linkActiveClass: 'active-page',
   linkExactActiveClass: 'current-page'
});
