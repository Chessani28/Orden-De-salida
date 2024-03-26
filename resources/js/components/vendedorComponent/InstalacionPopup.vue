<template>
    <div class="popup">
        <h2 class="popup-title sticky-title">Fotos sobre la instalación</h2>
        <div class="popup-content">
            <div v-if="instalacion">
                <p>Estado: {{ instalacion.status }}</p>

                <div v-if="instalacion && typeof instalacion.img === 'string'">
                    <p>Imágenes:</p>
                    <ul class="image-list">
                        <li v-for="(image, index) in instalacion.img.split(',')" :key="index">
                            <img v-if="image" :src="image" class="thumbnail" @click="mostrarImagenAmpliada(image)" />
                        </li>
                    </ul>
                </div>
            </div>
        </div>
        <button @click="cerrarPopup" class="close-button">Cerrar</button>
        <div v-if="imagenAmpliada" class="imagen-ampliada" @click="ocultarImagenAmpliada">
            <img :src="imagenAmpliada" @click.stop />
        </div>

    </div>
</template>

<script>
import axios from 'axios';
export default {
    props: {
        instalacion: Object,
        urlImagenes: Array,
    },
    data() {
        return {
            nuevasImagenes: [],
            imagenAmpliada: null,

        };
    },
    mounted() {
        document.body.addEventListener("click", this.cerrarPopupFuera);
    },

    beforeDestroy() {
        document.body.removeEventListener("click", this.cerrarPopupFuera);
    },
    methods: {
        cerrarPopup() {
            this.$emit("cerrar");
        },
        abrirPopup() {
            this.$emit("abrir");
        },
        cargarImagenes(event) {
            this.nuevasImagenes = event.target.files;
        },
        cerrarPopupFuera(event) {
            const targetElement = event.target;
            if (
                !this.$el.contains(targetElement) &&
                targetElement !== this.$el
            ) {
                this.cerrarPopup();
            }
        },
        guardarImagenes() {
            if (this.nuevasImagenes.length > 0) {
                const formData = new FormData();
                formData.append('id', this.instalacion.id);
                for (let i = 0; i < this.nuevasImagenes.length; i++) {
                    formData.append('img[]', this.nuevasImagenes[i]);
                }

                axios.post('/~max4orsal/public/api/instalaciones/' + this.instalacion.id + '/actualizar-imagenes', formData, {
                    headers: {
                        'Content-Type': 'multipart/form-data',
                    },
                })
                    .then((response) => {
                        this.cerrarPopup();

                        setTimeout(() => {
                            this.abrirPopup();
                            this.cambiarStatus4(this.instalacion, 4);
                        }, 1000);
                    })
                    .catch((error) => {
                        console.error("Error al guardar imágenes:", error);
                    });
            }
        },

        cambiarStatus4(instalacion, status) {
            axios.put(`/~max4orsal/public/api/programacioneeee/${instalacion.id_programacion}`, {
                status: 4
            })
                .then(response => {
                    console.log("Actualizada con exito", response);
                    instalacion.status = 4;
                })
                .catch(error => {
                    console.error("Error al en la actualización:", error);
                });
        },


        eliminarImagen(index) {
            const imageId = this.instalacion.id;
            const imageIndex = index;
            const confirmDelete = window.confirm("¿Estás seguro de que deseas eliminar esta imagen?");

            if (confirmDelete) {
                axios.delete(`/~max4orsal/public/api/instalaciones/${imageId}/eliminar-imagen/${imageIndex}`)
                    .then((response) => {
                        this.instalacion.img = response.data.nuevasImagenes.join(',');
                        this.$set(this.instalacion, "img", this.instalacion.img);

                        this.cerrarPopup();

                        setTimeout(() => {
                            this.abrirPopup();
                        }, 1000);
                    })
                    .catch((error) => {
                    });
            } else {
                console.log("Eliminación cancelada");
            }
        },


        mostrarImagenAmpliada(image) {
            this.imagenAmpliada = image;
        },
        ocultarImagenAmpliada() {
            this.imagenAmpliada = null;
        },
    },
};
</script>

<style scoped>
</style>
