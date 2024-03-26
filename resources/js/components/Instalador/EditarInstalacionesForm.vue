<template>
    <div>
        <table class="mini-edit-table">
            <tr>
                <th>Numero de identificación</th>
                <th>Valores</th>
            </tr>
            <tr>
                <td>ID:</td>
                <td><input type="text" v-model="venta.id" disabled /></td>
            </tr>
            <tr>
                <td>Nombre del Cliente:</td>
                <td><input type="text" v-model="venta.nombre_cliente" /></td>
            </tr>
            <tr>
                <td>Producto:</td>
                <td><input type="text" v-model="venta.producto" /></td>
            </tr>
            <tr>
                <td>Cantidad:</td>
                <td><input type="text" v-model="venta.cantidad" /></td>
            </tr>
            <tr>
                <td>Estado:</td>
                <td><input type="text" v-model="venta.estado" /></td>
            </tr>
            <tr>
                <td>ID del Instalador:</td>
                <td><input type="text" v-model="venta.id_users" /></td>
            </tr>
        </table>

        <div class="button-container">
            <button @click="guardarEdicion" class="btn-guardar">Guardar</button>
            <button @click="cancelarEdicion" class="btn-cancelar">
                Cancelar
            </button>
        </div>
    </div>
</template>

<script>
import axios from "axios";

export default {
    props: {
        venta: Object,
    },
    methods: {
        guardarEdicion() {
            axios
                .put(`/~max4orsal/public/api/instalaciones/${this.venta.id}`, this.venta)
                .then((response) => {
                    this.$emit("guardar", response.data);
                    this.cancelarEdicion();
                })
                .catch((error) => {
                    console.error("Error al guardar los cambios:", error);
                });
        },
        cancelarEdicion() {
            this.$emit("cancelar");
        },
    },
};
</script>

<style scoped>
@import 'css/EditarInstalacionesForm.css'
</style>
