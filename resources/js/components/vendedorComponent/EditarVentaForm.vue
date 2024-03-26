<template>
    <div>

        <table class="mini-edit-table">
            <tr>
                <th>Numero de identificación</th>
                <th>Valores</th>
            </tr>
            <tr>
                <td>ID:</td>
                <td><input type="text" v-model="articulos.id" disabled /></td>
            </tr>
            <tr>
            <tr>
                <td>Ine:</td>
                <td>
                    <input type="file" id="ine" accept=".pdf, .jpg, .png" @change="handleFileChange($event, 1)" />
                    <a :href="getPDFUrl(articulos.ine)" target="_blank">Comprobar ine</a>
                    <span class="error" v-if="errors.ine">{{ errors.ine }}</span>
                </td>
            </tr>
            <tr>
                <td>Recibo de luz:</td>
                <td>
                    <input type="file" id="luz" accept=".pdf, .jpg, .png" @change="handleFileChange($event, 2)" />
                    <a :href="getPDFUrl(articulos.luz)" target="_blank">Comprobar recibo de luz</a>
                    <span class="error" v-if="errors.luz">{{ errors.luz }}</span>
                </td>
            </tr>
            <td>Ubicación:</td>
            <input type="text" v-model="articuloActual.ubicacion" />
            <span class="error" v-if="errors.ubicacion">{{ errors.ubicacion }}</span>
            </tr>
            <tr>
                <td>Nombre del cliente:</td>
                <input type="text" v-model="articuloActual.nombre" />
                <span class="error" v-if="errors.nombre">{{ errors.nombre }}</span>
            <tr>
                <td>Recibo de pago:</td>
                <td>
                    <input type="file" id="pago" accept=".pdf, .jpg, .png" @change="handleFileChange($event, 3)" />
                    <a :href="getPDFUrl(articulos.pago)" target="_blank">Comprobar comprobante de pago</a>
                    <span class="error" v-if="errors.pago">{{ errors.pago }}</span>
                </td>
            </tr>
            </tr>
        </table>

        <div class="button-container">
            <button @click="guardarEdicion" class="btn-guardar">Guardar</button>
            <button @click="cancelarEdicion" class="btn-cancelar">Cancelar</button>
        </div>
    </div>
</template>

<script>
import axios from 'axios';

export default {
    props: {
        articulos: Object,
    },
    data() {
        return {
            archivos: {
                ine: null,
                luz: null,
                pago: null,
            },
            articuloActual: { ...this.articulos },
            ubicacion: null,
            nombre: null,

            status: null,
            errors: {
                ubicacion: null,
                nombre: null,
                ine: null,
                luz: null,
                pago: null,
            },
        };
    },

    methods: {
        guardarEdicion() {
            if (!this.validarCampos()) {
                return;
            }

            const formData = new FormData();
            formData.append('status', 1);
            formData.append('ubicacion', this.articuloActual.ubicacion);
            formData.append('nombre', this.articuloActual.nombre);
            formData.append('ine', this.archivos.ine);
            formData.append('luz', this.archivos.luz);
            formData.append('pago', this.archivos.pago);

            window.alert('Registro guardado exitosamente');
            axios
                .post(`/~max4orsal/public/api/ventase/${this.articulos.id}`, formData, {
                    headers: {
                        'Content-Type': 'multipart/form-data'
                    }
                })
                .then(response => {
                    this.$emit('guardar', response.data);
                    this.cancelarEdicion();
                })
                .catch(error => {
                    console.error('Error al guardar los cambios:', error);
                });
        },
        validarCampos() {
            this.errors = {};
            let valido = true;
            if (!this.articuloActual.ubicacion) {
                this.errors.ubicacion = 'Campo Ubicación es obligatorio';
                valido = false;
            }

            if (!this.articuloActual.nombre) {
                this.errors.nombre = 'Campo Nombre del cliente es obligatorio';
                valido = false;
            }

            if (!this.archivos.ine) {
                this.errors.ine = 'Campo Ine es obligatorio';
                valido = false;
            }

            if (!this.archivos.luz) {
                this.errors.luz = 'Campo Recibo de luz es obligatorio';
                valido = false;
            }

            if (!this.archivos.pago) {
                this.errors.pago = 'Campo Recibo de pago es obligatorio';
                valido = false;
            }

            return valido;
        },
        getPDFUrl(filename) {
            return `/~max4orsal/public/download-pdf/${filename}`;
        },
        cancelarEdicion() {
            this.$emit('cancelar');
        },
        handleFileChange(event, number) {
            const file = event.target.files[0];
            if (file) {
                switch (number) {
                    case 1:
                        this.archivos.ine = file;
                        break;
                    case 2:
                        this.archivos.luz = file;
                        break;
                    case 3:
                        this.archivos.pago = file;
                        break;
                }
            }
        }
    }
};
</script>

<style scoped>
.mini-edit-fields {
    margin-bottom: 10px;
}

.mini-edit-table {
    width: 10%;
    margin: 0 auto;
    background-color: #fff;
    border-radius: 5px;
    box-shadow: 0 0 5px rgba(0, 0, 0, 0.1);
    border-collapse: collapse;
    margin-top: 10px;
}

.mini-edit-table th,
.mini-edit-table td {
    padding: 3px;
    text-align: left;
    border-bottom: 1px solid #ddd;
}

.mini-edit-table th {
    background-color: #007bff;
    color: #fff;
    font-weight: bold;
    padding: 3px;
    font-size: 12px;
}

.mini-edit-table td.input input {
    width: 100%;
    font-size: 11px;
}

.button-container {
    text-align: center;
    margin-top: 5px;
    display: center;
}

.btn-guardar {
    background-color: green;
    color: #fff;
}

.btn-cancelar {
    background-color: red;
    color: #fff;
}

.btn-guardar:hover,
.btn-cancelar:hover {
    background-color: #0056b3;
}

.btn-guardar {
    background-color: green;
    color: #fff;
}

.btn-cancelar {
    background-color: red;
    color: #fff;
}

.error {
    color: red;
    font-size: 12px;
    margin-top: 5px;
}
</style>
