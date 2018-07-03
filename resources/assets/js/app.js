
/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

window.Vue = require('vue');

global.jQuery = require('jquery');
var $ = global.jQuery;
window.$ = $;

global.jQuery = require('jquery-confirm');
global.jQuery = require('bootstrap-select');

//V-mask
import VueMask from 'v-mask';
Vue.use(VueMask);

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

//Vuex
import Vuex from 'Vuex';
Vue.use(Vuex);


import Autocomplete from 'v-autocomplete';
import 'v-autocomplete/dist/v-autocomplete.css';
Vue.use(Autocomplete);

//Vue money
import money from 'v-money';
Vue.use(money, {
    decimal: ',',
    thousands: '.',
    prefix: '',
    suffix: '',
    precision: 2,
    masked: false
});

const store = new Vuex.Store({
    state:{
        progressBar: {},
        msgErrorSuccess: {},
    },
    mutations:{
        setProgressBar(state,obj){
            state.progressBar = obj;
        },
        setMsgErrorSuccess(state,obj){
            state.msgErrorSuccess = obj;
        }
    }
});

Vue.mixin({
    methods: {
        b64DecodeUnicode: function (str) {
            return decodeURIComponent(atob(str).split('').map(function(c) {
                return '%' + ('00' + c.charCodeAt(0).toString(16)).slice(-2);
            }).join(''));
        },
        verificaPermissao: function(permissao, url) {
            var Permissions = JSON.parse(window.localStorage['permissions']);
            var arr = [];
            var i;
            for (i = 0; i < Permissions.length; i++) {
                if(Permissions[i].name != '') {
                    arr[i] = Permissions[i].name;
                }
            }
            if(!url) {
                if (arr.indexOf(permissao) > -1) {
                    return true;
                } else {
                    return false;
                }
            } else if(arr.indexOf(permissao) == -1) {
                this.$router.push({path: url});
            }
        },
        goBack: function (val) {
            this.$router.go(val);
        },
        progressBar: function(sh) {
            this.$store.commit('setProgressBar', {status: sh});
        },
        setFocus: function (elemento) {
            document.getElementById(elemento).focus();
        },
        msgErrorSuccess: function(status,msg) {
            var self = this;
            this.$store.commit('setMsgErrorSuccess', {status: status, msg: msg});
            $(".form-control").removeClass("is-invalid");
        },
        replaceAll: function replaceAll(str, find, replace) {
            return str.split(find).join(replace);
        },
        classErrorSuccess: function(erro) {
            var self = this;
            $(".form-control").removeClass("is-invalid");
            Object.values(Object.getOwnPropertyNames(erro.response.data.errors)).forEach(function (value) {
                $("#"+value).addClass("is-invalid");
                $("#"+self.replaceAll(value,'.','')).parent('.bootstrap-select').addClass("is-invalid");
            });
        },
        tooltip: function(el) {
            $(function () {
                $(el).tooltip()
            });
        },
        verificaStatusHttp: function(erro) {
            var msgErro;
            if(erro.status!='422') {
                if(erro.status=='401') {
                    msgErro += '<li>401 - Não autorizado.</li>';
                }
                if(erro.status=='403') {
                    msgErro += '<li>403 - O pedido foi realizado, porém não autorizado.</li>';
                }
                if(erro.status=='405') {
                    msgErro += '<li>405 - Foi feita uma solicitação de um recurso usando um método de pedido não é compatível com esse recurso, por exemplo, usando GET em um formulário.</li>';
                }
                if(erro.status=='500') {
                    msgErro += '<li>500 - Erro interno do servidor (Internal Server Error).</li>';
                }
                if(erro.status=='500' && erro.responseJSON.message.indexOf('Foreign key violation') != -1) {
                    msgErro += '<li>Não é possivel excluir, pois esse item contém vínculos.</li>';
                }
                if(erro.status=='419') {
                    msgErro += '<li>419 - Status desconhecido.</li>';
                }
            } else {
                var errom = '';
                Object.values(erro.data.errors).forEach(function (value) {
                    errom += value[0] + '<br>';
                });
                msgErro = '<div class="alert alert-danger rounded-0 mb-0">\
                   <p class="mb-0"><i class="fas fa-exclamation-triangle" aria-hidden="true"></i> ' + errom + ' </p>\
                </div>';
                this.msgErrorSuccess(true, msgErro);
            }
        },
        getUser: function() {
            var self = this;
            axios({
                method: 'POST',
                url: '/api/usuario/getpermission',
            })
            .then(function (response) {
                var data = response.data;
                window.localStorage['token'] = data.token;
                window.localStorage['permissions'] = data.permissions;
                window.localStorage['url'] = data.url;
                window.localStorage['userName'] = data.userName;
            })
            .catch(function (error) {
            });
        },
    }
});

//Sortable
import Sortable from 'sortablejs'

Vue.directive('sortable', {
    inserted: function (el, binding) {
        var sortable = new Sortable(el, binding.value || {});
    }
});

import App from './components/App';
import router from './router';

new Vue({
    el: '#app',
    router,
    store,
    render: h => h(App),
    mounted() {
        var self = this;
        axios.interceptors.request.use(function (config) {
            self.progressBar('block');
            return config;
        },function (error) {
            self.progressBar('none');
            return Promise.reject(error);
        });
        axios.interceptors.response.use(function (response) {
            self.progressBar('none');
            return response;
        },
        function (error) {
            self.progressBar('none');
            self.verificaStatusHttp(error.response);
            return Promise.reject(error);
        });
        this.getUser();
    }
});