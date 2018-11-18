
/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

window.Vue = require('vue');

/**
 * The following block of code may be used to automatically register your
 * Vue components. It will recursively scan this directory for the Vue
 * components and automatically register them with their "basename".
 *
 * Eg. ./components/ExampleComponent.vue -> <example-component></example-component>
 */

Vue.component('cliente-component', require('./components/ClienteComponent.vue'));
Vue.component('oficina-component', require('./components/OficinaComponent.vue'));
Vue.component('paquete-component', require('./components/PaquetesComponent.vue'));
Vue.component('ruta-component', require('./components/RutaComponent.vue'));
Vue.component('paquetes-home-component', require('./components/PaquetesHomeComponent.vue'));
Vue.component('ruta-repartidor-component', require('./components/RutaRepartidorComponent.vue'));

// const files = require.context('./', true, /\.vue$/i)

// files.keys().map(key => {
//     return Vue.component(_.last(key.split('/')).split('.')[0], files(key))
// })

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

const app = new Vue({
    el: '#app',
    data:{
    menu: 0
    }
});
