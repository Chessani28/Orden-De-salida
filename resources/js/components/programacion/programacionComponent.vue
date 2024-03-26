<template>
    <div>


        <head>
            <meta charset="utf-8" />
            <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

            <!-- Fonts -->
            <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700" rel="stylesheet">
        </head>

        <div class="main-content">
            <DetalleProgramacion v-if="mostrarDetalle" :venta="programacionSeleccionada.venta || {}" @cerrar="cerrarDetalle">
            </DetalleProgramacion>
            <nav>
                <div class="nav nav-tabs" id="nav-tab" role="tablist" style="float: right;">

                    <button @click="resetFilter" class="nav-link active" id="nav-all-tab" data-bs-toggle="tab" data-bs-target="#nav-all" type="button" role="tab" aria-controls="nav-all"
                        aria-selected="true">Mostrar todos</button>
                    <button @click="filterByStatus(0)" class="nav-link" id="nav-docs-tab" data-bs-toggle="tab" data-bs-target="#nav-docs" type="button" role="tab" aria-controls="nav-docs"
                        aria-selected="false">Cancelado</button>
                    <button @click="filterByStatus(1)" class="nav-link" id="nav-done-tab" data-bs-toggle="tab" data-bs-target="#nav-done" type="button" role="tab" aria-controls="nav-done"
                        aria-selected="false">Esperando cambios</button>
                    <button @click="filterByStatus(2)" class="nav-link" id="nav-acere-tab" data-bs-toggle="tab" data-bs-target="#nav-acere" type="button" role="tab" aria-controls="nav-acere"
                        aria-selected="false">Aceptar o reprogramar</button>
                    <button @click="filterByStatus(3)" class="nav-link" id="nav-wait-tab" data-bs-toggle="tab" data-bs-target="#nav-wait" type="button" role="tab" aria-controls="nav-wait"
                        aria-selected="false">Programacion aceptada</button>
                    <button @click="filterByStatus(4)" class="nav-link" id="nav-wait-tab" data-bs-toggle="tab" data-bs-target="#nav-wait" type="button" role="tab" aria-controls="nav-review"
                        aria-selected="false">Esperando fotos</button>
                    <button @click="filterByStatus(5)" class="nav-link" id="nav-insfinish-tab" data-bs-toggle="tab" data-bs-target="#nav-insfinish" type="button" role="tab" aria-controls="nav-review"
                        aria-selected="false">Instalación terminada</button>
                    <button @click="filterByStatus(6)" class="nav-link" id="nav-timeout-tab" data-bs-toggle="tab" data-bs-target="#nav-timeout" type="button" role="tab" aria-controls="nav-review"
                        aria-selected="false">Instalación terminada</button>
                </div>
            </nav>

            <div class="tab-content" id="nav-tabContent">
                <div class="tab-pane fade show active" id="nav-all" role="tabpanel" aria-labelledby="nav-all-tab">Contenido para Mostrar todos...</div>
                <div class="tab-pane fade" id="nav-docs" role="tabpanel" aria-labelledby="nav-docs-tab">Contenido para Cancelado...</div>
                <div class="tab-pane fade" id="nav-done" role="tabpanel" aria-labelledby="nav-done-tab">Contenido para Esperando cambios...</div>
                <div class="tab-pane fade" id="nav-acere" role="tabpanel" aria-labelledby="nav-acere-tab">Contenido para En Aceptar o reprogramar...</div>
                <div class="tab-pane fade" id="nav-wait" role="tabpanel" aria-labelledby="nav-wait-tab">Contenido para En Programacion aceptada...</div>
                <div class="tab-pane fade" id="nav-wait" role="tabpanel" aria-labelledby="nav-wait-tab">Contenido para En Esperando fotos...</div>
                <div class="tab-pane fade" id="nav-insfinish" role="tabpanel" aria-labelledby="nav-insfinish-tab">Contenido para En Instalación terminada...</div>
                <div class="tab-pane fade" id="nav-timeout" role="tabpanel" aria-labelledby="nav-timeout-tab">Contenido para En Tiempo sobrepasado...</div>

            </div>
            <!-- Table -->
            <br>
            <div class="pagination">
                <a @click="prevPage" :disabled="currentPage === 1" class="page-link" href="#" tabindex="-1"><i class="ni ni-bold-left"></i></a>
                <a @click="nextPage" :disabled="currentPage * pageSize >= programacionsOriginal.length" class="page-link" href="#"><i class="ni ni-bold-right"></i></a>
            </div>
            <small>Pagina: <span>{{ currentPage }}</span></small>
            <div class="row">
                <div class="col">
                    <div class="card shadow">
                        <div class="table-responsive">
                            <table class="table align-items-center table-flush">
                                <thead class="thead-light">
                                    <tr>
                                        <th></th>
                                        <th @click="sortTable('id')">ID</th>
                                        <th @click="sortTable('Fecha')">Fecha de inicio</th>
                                        <th @click="sortTable('Fecha')">Fecha de temino</th>
                                        <th @click="sortTable('estado')">Estado</th>
                                        <th @click="sortTable('ubicacion')">Tipo de instalacion</th>
                                        <th @click="sortTable('instalador')">instalador</th>
                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr v-for="(programacion, index) in programacions" :key="index">
                                        <td :class="{
                                            'text-red': programacion.status === 0 || programacion.status === 6,
                                            'text-blue': programacion.status === 1,
                                            'text-yellow': programacion.status === 2,
                                            'text-aqua': programacion.status === 3 || programacion.status === 4,
                                            'text-green': programacion.status === 5

                                        }">
                                            {{ programacion.status === 0 ? '' : programacion.status === 1 ? '' : programacion.status === 2 ? '' : '' }}
                                        </td>

                                        <td>{{ programacion.id }}</td>
                                        <!--<td>{{ programacion.fecha_instalacion }}</td>-->

                                        <td>
                                            <div v-if="programacion.fecha_instalacion">
                                                {{ programacion.fecha_instalacion || 'Esperando...' }}
                                            </div>
                                            <div v-else>
                                                <input type="date" v-model="programacion.fechaSeleccionada" :min="fechaMinima" />
                                                <div v-if="errors.fechaSeleccionada" class="error">{{ errors.fechaSeleccionada }}</div>
                                            </div>
                                        </td>

                                        <td>
                                            <div v-if="programacion.fecha_termino">
                                                {{ programacion.fecha_termino || 'Esperando...' }}
                                            </div>
                                            <div v-else>
                                                <input type="date" v-model="programacion.fechaSeleccionadaTermino" :min="fechaMinima" />
                                                <div v-if="errors.fechaSeleccionadaTermino" class="error">{{ errors.fechaSeleccionadaTermino }}</div>
                                            </div>
                                        </td>
                                        <td
                                            :class="{ '': programacion.status === 0, '': programacion.status === 1, '': programacion.status === 2, '': programacion.status === 3, '': programacion.status === 4, '': programacion.status === 5 }">

                                            <span v-if="programacion.status === 0" class="badge badge-danger">Cancelado por el instalador
                                                <i class="icon-terminal" data-toggle="tooltip" data-placement="top" title="El instalador no pudo instalar en esa fecha..."></i>
                                            </span>
                                            <span v-else-if="programacion.status === 1" class="badge badge-primary">Esperando cambios..
                                                <i class="icon-terminal" data-toggle="tooltip" data-placement="top" title="Esperando fecha y nombre del instalador..."></i>
                                            </span>
                                            <span v-else-if="programacion.status === 2" class="badge badge-warning">Aceptado por el instalador
                                                <i class="icon-terminal" data-toggle="tooltip" data-placement="top" title="Esperando al instalador..."></i>
                                            </span>
                                            <span v-else-if="programacion.status === 3" class="badge badge-info">Programación aceptada
                                                <i class="icon-terminal" data-toggle="tooltip" data-placement="top" title="La instalación fue aceptada"></i>
                                            </span>
                                            <span v-else-if="programacion.status === 4" class="badge badge-info">Esperando fotos
                                                <i class="icon-terminal" data-toggle="tooltip" data-placement="top" title="Esperar a que el instalador suba fotos"></i>
                                            </span>
                                            <span v-else-if="programacion.status === 5" class="badge badge-success">Instalación terminada
                                                <i class="icon-terminal" data-toggle="tooltip" data-placement="top" title="El instalador subio las fotos y completo la instalación"></i>
                                            </span>
                                            <span v-else-if="programacion.status === 6" class="badge badge-danger">Tiempo sobrepasado
                                                <i class="icon-terminal" data-toggle="tooltip" data-placement="top" title="Tiempo de la instalación pasada"></i>
                                            </span>
                                        </td>

                                        <td>{{ mapStatusToTipo(programacion.venta.tipo) }}</td>
                                        <td>
                                            <div v-if="programacion.users">
                                                {{ programacion.users ? programacion.users.name : 'Esperando...' }}
                                            </div>
                                            <div v-else>
                                                <select v-model="programacion.selectedUser" id="id_users">
                                                    <option v-for="user in users" :key="user.id" :value="user.id">{{ user.name }}</option>
                                                </select>
                                                <div v-if="errors.selectedUser" class="error">{{ errors.selectedUser }}</div>
                                            </div>

                                        </td>
                                        <button :disabled="programacion.status === 2 || programacion.status === 3 || programacion.fecha_instalacion" class="btn-action btn-cambios"
                                            @click="guardarFecha(programacion)">
                                            <span class="icon-pencil"></span>Modificar</button>

                                        <button :disabled="programacion.venta.tipo === 2" class="btn-action btn-consultar" @click="handleButton3Click(programacion)">
                                            <i class="icon-book1"></i>Datos
                                        </button>

                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        <div class="card-footer py-4">

                        </div>
                    </div>
                </div>
            </div>
            <Editar-Instalaciones-Form v-if="mostrarFormulario" :articulos="articuloAEditar" @guardar="guardarArticuloEditado" @cancelar="cerrarFormulario"></Editar-Instalaciones-Form>

            <footer class="footer">
                <div class="row align-items-center justify-content-xl-between">

                </div>
            </footer>
        </div>
    </div>
</template>

<script>
import axios from 'axios';
import DetalleProgramacion from "./DetalleProgramacion.vue";

export default {
    data() {
        return {
            currentPage: 1,
            pageSize: 10,
            errors: {
                fechaSeleccionada: null,
                fechaSeleccionadaTermino: null,
                selectedUser: null,
            },
            programacions: [],
            programacionsOriginal: [],
            sortOrder: "asc",
            sortedColumn: "",
            searchText: "",
            mostrarFormulario: false,
            programacionAEditar: null,
            mostrarDetalle: false,
            programacionSeleccionada: null,
            articulos: [],
            fechaSeleccionada: null,
            fechaSeleccionadaTermino: null,
            userName: null,
            programaciones: [],
            listaDeUsuarios: [],
            users: [],
            selectedUser: null,
            programacion: {
                fechaSeleccionadaTermino: '',

            }
        };

    },
    mounted() {
        this.fetchUsers();
        axios.get("/~max4orsal/public/api/programaciones")
            .then((response) => {
                this.listaDeUsuarios = response.data.filter(user => user.role_id === 2);
                console.log(this.listaDeUsuarios);
            })
            .catch((error) => {
                console.error("Error al obtener los usuarios:", error);
            });
        axios.get('/~max4orsal/public/api/getUsers2')
            .then(response => {
                if (Array.isArray(response.data.users)) {
                    this.users = response.data.users;
                } else {
                }
            })
            .catch(error => {
                console.error('Error al obtener los usuarios:', error);
            });
        axios
            .get("/~max4orsal/public/api/programacion")
            .then((response) => {
                this.programacions = response.data.programaciones;
                this.programacionsOriginal = response.data.programaciones;
                const start = 0;
                const end = this.pageSize;
                this.programacions = this.programacionsOriginal.slice(start, end);
                this.programacions.forEach(programacion => {
                });
                this.programacions.forEach(programacion => {
                    this.fetchProgramaciones();
                });
            })
            .catch((error) => {
                console.error("Error al obtener las programaciones:", error);
                this.errorMessage = "Error al cargar los datos. Por favor, inténtalo de nuevo más tarde.";
            })
            .catch((error) => {
                console.error("Error al obtener los artículos:", error);
                axios
                    .get("/~max4orsal/public/api/ventas")
                    .then((response) => {
                        this.usuarios = response.data;
                    })
                    .catch((error) => {
                        console.error("Error al obtener los usuarios:", error);
                    });
            })
            .catch((error) => {
                console.error("Error al obtener los artículos:", error);
            });
    },
    computed: {
        filteredUsers() {
            return this.listaDeUsuarios.filter(user => user.role_id === 2);
        },
        fechaMinima() {
            const hoy = new Date().toISOString().split('T')[0];
            return hoy;
        },
    },
    methods: {
        sortTable(column) {
            if (this.sortOrder === "asc") {
                this.programacions.sort((a, b) => (a[column] < b[column] ? -1 : 1));
                this.sortOrder = "desc";
            } else {
                this.programacions.sort((a, b) => (a[column] > b[column] ? -1 : 1));
                this.sortOrder = "asc";
            }
            this.sortedColumn = column;
        },
        prevPage() {
            if (this.currentPage > 1) {
                this.currentPage -= 1;
                this.updateArticulos();
            }
        },

        nextPage() {
            const totalPages = Math.ceil(this.programacionsOriginal.length / this.pageSize);
            if (this.currentPage < totalPages) {
                this.currentPage += 1;
                this.updateArticulos();
            }
        },

        updateArticulos() {
            const start = (this.currentPage - 1) * this.pageSize;
            const end = start + this.pageSize;
            this.programacions = this.programacionsOriginal.slice(start, end);
        },
        fetchProgramaciones() {
            axios.get('/~max4orsal/public/api/programaciones')
                .then(response => {
                    this.programaciones = response.data;
                })
                .catch(error => {
                    console.error('Error al obtener programaciones', error);
                });
        },
        guardarFecha(programacion) {
            this.errors = {};
            let valido = true;

            if (!programacion.fechaSeleccionada) {
                this.errors.fechaSeleccionada = 'Campo Fecha de inicio es obligatorio';
                valido = false;
            }

            if (!programacion.fechaSeleccionadaTermino) {
                this.errors.fechaSeleccionadaTermino = 'Campo Fecha de termino es obligatorio';
                valido = false;
            }

            if (!programacion.selectedUser) {
                this.errors.selectedUser = 'Campo Instalador es obligatorio';
                valido = false;
            }

            if (valido) {
                if (programacion) {
                    if (programacion.fechaSeleccionada && programacion.selectedUser) {
                        programacion.fecha_instalacion = programacion.fechaSeleccionada;
                        programacion.fecha_termino = programacion.fechaSeleccionadaTermino;


                        axios.put(`/~max4orsal/public/api/programacionee/${programacion.id}`, {
                            fecha_instalacion: programacion.fechaSeleccionada,
                            fecha_termino: programacion.fechaSeleccionadaTermino,
                            id_users: programacion.selectedUser,
                        })
                            .then(response => {
                                console.log("Modificado con éxito", response);
                                programacion.editing = false;
                                alert("Registro modificado con éxito");
                            })
                        axios.post(`/~max4orsal/public/api/actualizar-venta/${programacion.venta.id}`, {
                        })
                            .then(response => {
                                console.log("Venta actualizada con éxito", response);
                                alert("Registro modificado con éxito");
                            })
                            .catch(error => {
                                console.error("Error al actualizar la venta:", error);
                            })
                            .catch(error => {
                                console.error("Error al guardar la programación:", error);
                            });
                    } else {
                    }
                }
            } else {
            }

        },

        mapStatusToTipo(status) {
            if (status === 1) {
                return "Paneles solares";
            } else if (status === 2) {
                return "GPS";
            }
            else {
                return "Desconocido"
            }
        },

        async fetchUsers() {
            axios.get('/~max4orsal/public/api/getUsers2')
                .then(response => {
                    if (Array.isArray(response.data)) {
                        this.users = response.data;
                    } else {
                        console.error('La respuesta de la API no contiene un array de usuarios:', response);
                    }
                })
                .catch(error => {
                    console.error('Error al obtener los usuarios:', error);
                });
        },
        resetFilter() {
            this.programacions = this.programacionsOriginal;
        },
        filterByStatus(status) {
            this.programacions = this.programacionsOriginal.filter(programacion => programacion.status === status);
        },

        getPDFUrl(filename) {
            return `/~max4orsal/public/download-pdf/${filename}`;
        },
        handleButton1Click(programacion) {
            this.programacionAEditar = programacion;
            this.mostrarFormulario = true;
        },
        guardarprogramacionEditada(programacionEditada) { },
        cerrarFormulario() {
            this.mostrarFormulario = false;
        },
        filterTable() {
            const lowerCaseSearch = this.searchText.toLowerCase();
            this.programacions = this.programacionsOriginal.filter((programacion) => {
                return (
                    programacion.id.toString().includes(lowerCaseSearch) ||
                    programacion.nombre_cliente
                        .toLowerCase()
                        .includes(lowerCaseSearch) ||
                    (programacion.articulos_id &&
                        this.articulos[programacion.articulos_id] &&
                        this.articulos[programacion.articulos_id].name
                            .toLowerCase()
                            .includes(lowerCaseSearch)) ||
                    programacion.cantidad.toString().includes(lowerCaseSearch) ||
                    programacion.estado.toString().includes(lowerCaseSearch) ||
                    programacion.id_users.toString().includes(lowerCaseSearch)
                );
            });
            console.log("programacions filtradas:", this.programacions);
        },

        handleButton3Click(programacion) {
            this.mostrarDetalle = true;
            this.programacionSeleccionada = programacion;
        },
        cerrarDetalle() {
            this.mostrarDetalle = false;
            this.programacionSeleccionada = null;
        },
    },
    components: {
        DetalleProgramacion,
    },
};
</script>
<style></style>
