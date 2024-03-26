<template>
    <div class="form-container">
        <center>
            <h1 v-if="!showSwitch">Venta de paneles</h1>
        </center>
        <form v-if="!showSwitch" @submit.prevent="submitForm" enctype="multipart/form-data">
            <input @click.prevent="changeInput" type="checkbox" id="miInterruptor" class="toggle-input" :checked="toggle2">
            <label for="miInterruptor" class="toggle-label"></label>

            <div class="location-input">
                <label for="ubicacion">Ubicación:</label>
                <input type="text" id="ubicacion" v-model="ubicacion" class="input-field" :class="{ 'error-border': errorMessages.ubicacion !== '' }" />
                <div v-if="errorMessages.ubicacion !== ''" class="error-message">{{ errorMessages.ubicacion }}</div>
            </div>

            <div class="location-input">
                <label for="nombre">Nombre del cliente:</label>
                <input type="text" id="nombre" v-model="nombre" :class="{ 'error-border': errorMessagesGPS.nombre !== '' }" @input="validarSoloLetras" />
                <div v-if="errorMessagesGPS.nombre !== ''" class="error-message">
                    {{ errorMessagesGPS.nombre }}
                </div>
            </div>

            <fieldset>
                <div class="mb-3">
                    <label for="file1" class="form-label">Ine (PDF o imagen):</label>
                    <input type="file" class="form-control" :class="{ 'error-border': errorMessages.file1 !== '' }" id="file1" accept=".pdf, .jpg, .png" @change="handleFileChange($event, 1)" required>
                    <div v-if="errorMessages.file1 !== ''" class="error-message">{{ errorMessages.file1 }}</div>
                </div>
            </fieldset>

            <fieldset>
                <div class="mb-3">
                    <label for="file2" class="form-label">Comprobante de luz (PDF o imagen):</label>
                    <input type="file" class="form-control" :class="{ 'error-border': errorMessages.file2 !== '' }" id="file2" accept=".pdf, .jpg, .png" @change="handleFileChange($event, 2)" required>
                    <div v-if="errorMessages.file2 !== ''" class="error-message">{{ errorMessages.file2 }}</div>
                </div>
            </fieldset>

            <fieldset>
                <div class="mb-3">
                    <label for="file3" class="form-label">Comprobante de pago (PDF o imagen):</label>
                    <input type="file" class="form-control" :class="{ 'error-border': errorMessages.file3 !== '' }" id="file3" accept=".pdf, .jpg, .png" @change="handleFileChange($event, 3)" required>
                    <div v-if="errorMessages.file3 !== ''" class="error-message">{{ errorMessages.file3 }}</div>
                </div>
            </fieldset>

            <button class="btn btn-primary" type="submit" @click.prevent="showConfirmation">Realizar venta</button>
        </form>

        <div v-else>
            <center>
                <h1>Venta de GPS</h1>
            </center>
            <input @click.prevent="changeInput" type="checkbox" id="miInterruptor" class="toggle-input">
            <label for="miInterruptor" class="toggle-label"></label>
            <div class="location-input">
                <label for="nombre">Nombre del cliente:</label>
                <input type="text" id="nombre" v-model="nombre" @input="validarSoloLetras" :class="{ 'error-border': errorMessagesGPS.nombre !== '' }" />
                <div v-if="errorMessagesGPS.nombre !== ''" class="error-message">{{ errorMessagesGPS.nombre }}</div>
            </div>

            <div class="location-input">
                <label for="ubicacion">Ubicación:</label>
                <div class="checkbox-input">
                    <input type="checkbox" id="desactivarUbicacion" v-model="ubicacionDesactivada" />
                    <label for="desactivarUbicacion">{{ ubicacionDesactivada ? 'Sin ubicación' : '' }}</label>
                </div>
                <input type="text" id="ubicacion" v-model="ubicacion" :class="{ 'error-border': errorMessagesGPS.ubicacion !== '' }" :disabled="ubicacionDesactivada" />
                <div v-if="errorMessagesGPS.ubicacion !== ''" class="error-message">{{ errorMessagesGPS.ubicacion }}</div>
            </div>
            <button class="btn btn-primary" type="submit" @click.prevent="showConfirmationGPS">Realizar venta</button>
        </div>
    </div>
</template>

<script>
import axios from 'axios';
export default {
    data() {
        return {
            file1: null,
            file2: null,
            file3: null,
            ubicacion: '',
            selectedUser: '',
            showSwitch: false,
            users: [],
            nombre: '',
            toggle1: false,
            toggle2: true,
            ubicacionDesactivada: false,
            errorMessages: {
                file1: '',
                file2: '',
                file3: '',
                ubicacion: '',
                nombre: '',
            },
            errorMessagesGPS: {
                nombre: '',
                ubicacion: '',
            },
        };
    },

    methods: {
        handleFileChange(event, number) {
            const file = event.target.files[0];
            if (file) {
                switch (number) {
                    case 1:
                        this.errorMessages.file1 = '';
                        this.file1 = file;
                        break;
                    case 2:
                        this.errorMessages.file2 = '';
                        this.file2 = file;
                        break;
                    case 3:
                        this.errorMessages.file3 = '';
                        this.file3 = file;
                        break;
                }
            }
        },
        validarSoloLetras() {
            this.nombre = this.nombre.replace(/[^a-zA-Z]/g, '');
        },
        changeInput() {
            this.showSwitch = !this.showSwitch;

            if (this.showSwitch) {
                this.file1 = null;
                this.file2 = null;
                this.file3 = null;
                this.ubicacion = '';
                this.nombre = '';

            }
        },


        saveCliente(){
            const formData = new FormData();
            formData.append('nombre', this.nombre);
            formData.append('totventas', null);
            formData.append('ventasps', null);
            formData.append('ventagps', null);
            formData.append('calificacion', null);

            axios
                .post('/~max4orsal/public/api/clientes', formData)
                .then(response => {
                })
                .catch(error => {
                    console.error(error);
                });
        },




        showConfirmation() {
            this.errorMessages = {
                file1: '',
                file2: '',
                file3: '',
                nombre: '',
                ubicacion: '',
            };
            if (!this.file1) {
                this.errorMessages.file1 = 'Por favor, selecciona un archivo.';
            }
            if (!this.file2) {
                this.errorMessages.file2 = 'Por favor, selecciona un archivo.';
            }
            if (!this.file3) {
                this.errorMessages.file3 = 'Por favor, selecciona un archivo.';
            }
            if (!this.ubicacion) {
                this.errorMessages.ubicacion = 'Este campo es obligatorio.';
            }
            if (!this.nombre) {
                this.errorMessages.nombre = 'Este campo es obligatorio.';
            }
            if (Object.values(this.errorMessages).some(message => message !== '')) {
                return;
            }

            const confirmation = window.confirm('¿Estás seguro de que quieres subir los archivos?');
            if (confirmation) {
                this.submitForm();
                //this.saveCliente();
            }
        },

        showConfirmationGPS() {
            this.errorMessagesGPS = {
                nombre: '',
                ubicacion: '',
            }

            if (!this.nombre) {
                this.errorMessagesGPS.nombre = 'Este campo es obligatorio.';
            }
            if (!this.nombre) {
                this.errorMessagesGPS.ubicacion = 'Este campo es obligatorio.';
            }

            if (Object.values(this.errorMessagesGPS).some(message => message !== '')) {
                return;
            }

            const confirmation = window.confirm('¿Estás seguro de que quieres subir los archivos?');

            if (confirmation) {
                this.submitGPS();
            }
        },

        submitGPS() {
            const formData = new FormData();
            formData.append('file1', null);
            formData.append('file2', null);
            formData.append('file3', null);
            formData.append('ubicacion', this.ubicacion);
            formData.append('nombre', this.nombre);

            axios
                .post('/~max4orsal/public/api/ventasa', formData)
                .then(response => {
                    const id_venta = response.data.id;

                    this.subirProgramacion(id_venta);
                })
                .catch(error => {
                    console.error(error);
                });
        },

        guardarProgramacion(id_venta) {
            const data = {
                id_venta: id_venta,
                fecha_instalacion: null,
                status: 1,
                id_user: null,
            };
            axios
                .post("/~max4orsal/public/api/programacion", data)
                .then((response) => {
                    console.log("Programación guardada con éxito");
                    articulo.botonVisible = false;
                    this.$forceUpdate();
                })
                .catch((error) => {
                    console.error("Error al guardar la programación:", error);
                });
        },

        subirProgramacion(id_venta) {
            const programacionData = {
                id_venta: id_venta,
                fecha_instalacion: null,
                id_users: null,
                status: 1,
            };

            axios
                .post('/~max4orsal/public/api/programacion', programacionData)
                .then(response => {
                    console.log(response.data);
                    window.alert('Programación guardada exitosamente');
                })
                .catch(error => {
                    console.error(error);
                });
        },

        submitForm() {
            const formData = new FormData();
            formData.append('file1', this.file1);
            formData.append('file2', this.file2);
            formData.append('file3', this.file3);
            formData.append('ubicacion', this.ubicacion);
            formData.append('nombre', this.nombre);

            axios
                .post('/~max4orsal/public/api/ventas', formData)
                .then(response => {
                    console.log(response.data);
                    window.alert('Registro guardado exitosamente');
                    this.file1 = null;
                    this.file2 = null;
                    this.file3 = null;
                    this.ubicacion = '';
                    this.nombre = '';
                })
                .catch(error => {
                    console.error(error);
                });
        },
    },
    computed: {
        filteredUsers() {
            return this.users.filter(user => user.role_id === 2);
        },
    },

};
</script>

<style scoped>
label {
    display: block;
    margin-bottom: 5px;
    color: #2c3e50;
}

.input-field {
    width: 100%;
    padding: 8px;
    border: 1px solid #bdc3c7;
    border-radius: 5px;
    transition: border-color 0.3s ease;
}

.input-field:focus {
    border-color: #3498db;
}

.file-input {
    margin-bottom: 15px;
}

.form-container {
    max-width: 600px;
    margin: 0 auto;
    padding: 20px;
    border: 1px solid #000000;
    border-radius: 10px;
    box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
    background-color: #ecf0f1;
}

.submit-button:hover {
    background-color: #2980b9;
}

h2 {
    color: #333;
    text-align: center;
}


input {
    width: 100%;
    padding: 8px;
    border: 1px solid #ccc;
    border-radius: 3px;
}


button {
    background-color: #4CAF50;
    color: white;
    padding: 10px;
    border: none;
    border-radius: 3px;
    cursor: pointer;
    width: 100%;
}

button:hover {
    background-color: #45a049;
}

.toggle-input {
    display: none;
}

.toggle-label {
    display: flex;
    justify-content: space-between;
    width: 300px;
    margin: 10px;
    width: 50px;
    height: 30px;
    background-color: #ccc;
    border-radius: 15px;
    position: relative;
    cursor: pointer;
    transition: background-color 0.3s;
}

.toggle-input:checked+.toggle-label {
    background-color: #4CAF50;
}

.toggle-label::before {
    content: '';
    width: 25px;
    height: 25px;
    background-color: #fff;
    border-radius: 50%;
    position: absolute;
    top: 2px;
    left: 2px;
    transition: transform 0.3s;
}

.toggle-input:checked+.toggle-label::before {
    transform: translateX(20px);
}

.error-message {
    color: red;
    margin-top: 5px;
}

.error-border {
    border: 1px solid red;
}

.error-border {
    border: 1px solid red;
}
</style>
