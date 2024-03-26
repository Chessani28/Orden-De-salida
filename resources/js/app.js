//const { VueGoodTable } = require('vue-good-table');

require('./bootstrap');



window.Vue = require('vue').default;


Vue.component('tablaven-component', require('./components/vendedorComponent/tablaVcomponent.vue').default);

Vue.component('clientesD-component', require('./components/vendedorComponent/clientesDetalles.vue').default);

Vue.component('editar-venta-form', require('./components/vendedorComponent/EditarVentaForm.vue').default);

Vue.component('detalle-venta', require('./components/vendedorComponent/DetalleVenta.vue').default);

Vue.component('form-venta', require('./components/vendedorComponent/FormComponent.vue').default);

Vue.component('tabla-instalaciones', require('./components/vendedorComponent/TablaInstalaciones.vue').default);





Vue.component('instalador-component', require('./components/Instalador/instaladorComponent.vue').default);


Vue.component('instalacion-popup', require('./components/Instalador/InstalacionPopup.vue').default);



Vue.component('programacion-component', require('./components/programacion/programacionComponent.vue').default);



Vue.component('verificacion-component', require('./components/verificacion/VerificacionComponent.vue').default);



const app = new Vue({
    el: '#app',
});
