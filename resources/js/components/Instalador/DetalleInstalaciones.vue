<template>
    <div v-if="mostrarDatosPopup" class="datos-popup">
      <div class="popup-header">
        <h2>Datos del Registro</h2>
        <button @click="cerrarDatosPopup" class="close-button">×</button>
      </div>
      <div class="popup-content">
        <div class="info-row">
          <span class="info-label">ID:</span>
          <span class="info-value">{{ instalacionSeleccionada.id }}</span>
        </div>
        <div class="info-row">
          <span class="info-label">Fecha de inicio:</span>
          <span class="info-value" v-if="instalacionSeleccionada.fecha_instalacion">
            {{ formatFecha(instalacionSeleccionada.fecha_instalacion) }}
          </span>
          <span class="info-value" v-else>Espera cambios</span>
        </div>
        <div class="info-row">
          <span class="info-label">Fecha de término:</span>
          <span class="info-value" v-if="instalacionSeleccionada.fecha_termino">
            {{ formatFecha(instalacionSeleccionada.fecha_termino) }}
          </span>
          <span class="info-value" v-else>Espera cambios</span>
        </div>
        <div class="info-row">
          <span class="info-label">Tipo de instalación:</span>
          <span class="info-value tipo-instalacion">{{ mapStatusToTipo(instalacionSeleccionada.venta.tipo) }}</span>
        </div>
      </div>
    </div>
  </template>

  <script>
  export default {
    props: {
      instalacionSeleccionada: Object,
      mostrarDatosPopup: Boolean,
    },
    methods: {
      cerrarDatosPopup() {
        this.$emit("cerrarDatosPopup");
      },
      mapStatusToTipo(status) {
        switch (status) {
          case 1:
            return "Paneles solares";
          case 2:
            return "GPS";
          default:
            return "Desconocido";
        }
      },
      formatFecha(fecha) {
  const opcionesFecha = {
    day: 'numeric',
    month: 'long',
    year: 'numeric',
  };
  return new Date(fecha).toLocaleDateString("es-ES", opcionesFecha);
},
    },
  };
  </script>

<style>
@import 'css/detalleInstalacion.css'
</style>
