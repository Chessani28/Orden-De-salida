<template>
    <div class="popup-wrapper">
        <div class="popup">
            <div class="popup-header">
                <h2 class="popup-title">Detalles de la Venta</h2>
                <button @click="cerrarPopup" class="btn-cerrar">Cerrar</button>
            </div>
            <div class="popup-content">
                <table class="table">
                    <tr>
                        <td class="table-label">Ine:</td>
                        <td><a :href="getPDFUrl(venta.ine)" target="_blank">Ver ine</a></td>
                    </tr>
                    <tr>
                        <td class="table-label">Comprobante de pago:</td>
                        <td><a :href="getPDFUrl(venta.pago)" target="_blank">Ver comprobante de pago</a></td>
                    </tr>
                    <tr>
                        <td class="table-label">Ubicación:</td>
                        <td>{{ venta.ubicacion }}</td>
                    </tr>
                </table>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    props: {
        venta: Object,
    },
    methods: {
        cerrarPopup() {
            this.$emit("cerrar");
        },
        getPDFUrl(filename) {
            return `/~max4orsal/public/download-pdf/${filename}`;
        },
    },
};
</script>
