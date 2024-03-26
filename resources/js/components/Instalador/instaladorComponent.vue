<template>
    <div>

        <head>
            <meta charset="utf-8" />
            <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

            <!-- Fonts -->
            <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700" rel="stylesheet">
        </head>

        <div class="main-content">

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
                        aria-selected="false">Fecha pasada</button>
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
                                        <th @click="sortTable('id')">Numero de identificación
                                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-arrow-down-up" viewBox="0 0 16 16">
                                                <path fill-rule="evenodd"
                                                    d="M11.5 15a.5.5 0 0 0 .5-.5V2.707l3.146 3.147a.5.5 0 0 0 .708-.708l-4-4a.5.5 0 0 0-.708 0l-4 4a.5.5 0 1 0 .708.708L11 2.707V14.5a.5.5 0 0 0 .5.5m-7-14a.5.5 0 0 1 .5.5v11.793l3.146-3.147a.5.5 0 0 1 .708.708l-4 4a.5.5 0 0 1-.708 0l-4-4a.5.5 0 0 1 .708-.708L4 13.293V1.5a.5.5 0 0 1 .5-.5" />
                                            </svg>
                                        </th>
                                        <th @click="sortTable('estado')">Estatus</th>
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
                                            {{ programacion.status === 0 ? '' : programacion.status === 1 ? '' : programacion.status === 2 ? ''
                                                : '' }}
                                        </td>
                                        <td>{{ programacion.id }}</td>

                                        <!--{{ mapStatusToText(programacion.status) }}-->
                                        <td
                                            :class="{ '': programacion.status === 0, '': programacion.status === 1, '': programacion.status === 2, '': programacion.status === 3, '': programacion.status === 4, '': programacion.status === 5 }">

                                            <span v-if="programacion.status === 0" class="badge badge-danger">Cancelado
                                                <i class="ni ni-collection" data-toggle="tooltip" data-placement="top" title="Fecha cancelada, esperando a reprogramar..."></i>
                                            </span>
                                            <span v-else-if="programacion.status === 1" class="badge badge-primary">Esperando cambios..
                                                <i class="ni ni-collection" data-toggle="tooltip" data-placement="top" title="Esperando fecha y nombre del instalador..."></i>
                                            </span>
                                            <span v-else-if="programacion.status === 2" class="badge badge-success">Aceptar o Reprogramar instalación...
                                                <i class="ni ni-collection" data-toggle="tooltip" data-placement="top" title="ceptar o Reprogramar instalación..."></i>
                                            </span>
                                            <span v-else-if="programacion.status === 3" class="badge badge-info">Esperando fotos
                                                <i class="ni ni-collection" data-toggle="tooltip" data-placement="top" title="Subir fotos..."></i>
                                            </span>
                                            <span v-else-if="programacion.status === 4" class="badge badge-info">Esperando mas fotos o terminar
                                                <i class="ni ni-collection" data-toggle="tooltip" data-placement="top" title="Fotos subidas, esperando mas fotos o terminar instalación"></i>
                                            </span>
                                            <span v-else-if="programacion.status === 5" class="badge badge-success">Instalación terminada
                                                <i class="ni ni-collection" data-toggle="tooltip" data-placement="top" title="Terminación instalada"></i>
                                            </span>
                                            <span v-else-if="programacion.status === 6" class="badge badge-danger">Fecha pasada
                                                <i class="ni ni-collection" data-toggle="tooltip" data-placement="top" title="Instalación cancelada porque paso la fecha"></i>
                                            </span>
                                        </td>

                                        <td>{{ programacion.users ? programacion.users.name || 'Modificando el usuario...' : 'Modificando el usuario...' }}</td>

                                        <td>
                                            <button @click="confirmAceptarProgramacion(programacion)"
                                                :disabled="programacion.status === 0 || programacion.status === 1 || programacion.status === 3 || programacion.status === 4 || programacion.fecha_instalacion === null || programacion.status === 5 || programacion.status === 6"
                                                class="btn-aceptar">
                                                <span class="icon-checkmark"></span>Aceptar</button>

                                            <button @click="confirmCancelarProgramacion(programacion)"
                                                :disabled="programacion.status === 0 || programacion.status === 1 || programacion.status === 4 || programacion.fecha_instalacion === null || programacion.status === 5 || programacion.status === 6"
                                                class="btn-cancelar">
                                                <span class="icon-cross"></span>Reprogramar</button>

                                            <button @click="mostrarDetalles(programacion)"
                                                :disabled="programacion.status === 0 || programacion.status === 1 || programacion.status === 2 || programacion.status === 5 || programacion.status === 6"
                                                class="btn-fotos">
                                                <span class="icon-images"></span>Subir fotos</button>
                                            <!--<button @click="mostrarDetalles(programacion)">Mostrar Detalles</button>-->
                                            <button @click="confirmTerminarInstalacion(programacion)"
                                                :disabled="programacion.status === 0 || programacion.status === 3 || programacion.status === 1 || programacion.status === 2 || programacion.status === 5 || programacion.status === 6"
                                                class="btn-fotos">
                                                <span class="icon-podcast"></span>Terminar instalación</button>

                                            <button class="btn-action btn-consultar" @click="handleButton3Click(programacion)">
                                                <i class="icon-book1"></i>Datos</button>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>

                        </div>
                        <div class="card-footer py-4">

                        </div>
                    </div>
                </div>
            </div>
            <Editar-Instalaciones-Form v-if="mostrarEditarPopup" :programacions="programacionAEditar" @guardar="guardarArticuloEditado" @cancelar="cerrarFormulario"></Editar-Instalaciones-Form>

            <instalacion-popup v-if="mostrarPopup" :instalacion="instalacionSeleccionada" @cerrar="cerrarPopup"></instalacion-popup>

            <DatosInstalacionPopup v-if="mostrarDatosPopup" :instalacionSeleccionada="instalacionSeleccionada" :mostrarDatosPopup="mostrarDatosPopup" @cerrarDatosPopup="cerrarDatosPopup">
            </DatosInstalacionPopup>

            <!-- Footer -->
            <footer class="footer">
                <div class="row align-items-center justify-content-xl-between">

                </div>
            </footer>
        </div>
    </div>
</template>
<script>
import axios from "axios";
import EditarInstalacionesForm from "./EditarInstalacionesForm.vue";
import InstalacionPopup from './InstalacionPopup.vue';
import DatosInstalacionPopup from './DetalleInstalaciones.vue';



export default {
    data() {
        return {
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
            userName: null,
            articuloAEditar: null,
            programacionId: null,
            mostrarPopup: false,
            instalacionSeleccionada: {},
            instalacionPopup: null,
            mostrarEditarPopup: false,
            mostrarDatosPopup: false,
            currentPage: 1,
            pageSize: 10,
        };
    },
    props: {
        instalacion: Object,
    },
    mounted() {
        this.programacions.forEach(programacion => {
            this.fetchUserName(programacion);

        });

        axios
            .get("/~max4orsal/public/api/programacion")
            .then((response) => {
                this.programacions = response.data.programaciones;
                this.programacionsOriginal = response.data.programaciones;
                this.programacions.forEach(programacion => {
                });
                const start = 0;
                const end = this.pageSize;
                this.programacions = this.programacionsOriginal.slice(start, end);
                this.programacions.forEach(programacion => {
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
        normalizeString(value) {
            return value ? value.toString().toLowerCase() : '';
        },
        resetFilter() {
            this.programacions = this.programacionsOriginal;
        },
        filterByStatus(status) {
            this.programacions = this.programacionsOriginal.filter(programacion => Number(programacion.status) === status);
        },
        guardarArticuloEditado(articuloEditado) { },
        cerrarFormulario() {
            this.mostrarEditarPopup = false;
        },
        fetchUserName(programacion) {
            console.log('Fetching username for programacion', programacion.id);
            axios.get(`/~max4orsal/public/api/programacion/${programacion.id}/getUserName`)
                .then(response => {
                    if (response.data.name) {
                        this.$set(programacion, 'userName', response.data.name);
                        console.log(`Nombre de usuario asignado para programacion ${programacion.id}: ${programacion.userName}`);
                    } else {
                        this.$set(programacion, 'userName', 'Sin nombre');
                        console.log(`Nombre de usuario predeterminado asignado para programacion ${programacion.id}`);
                    }
                })
                .catch(error => {
                    console.error('Error al obtener el nombre del usuario', error);
                });
        },
        cerrarPopup() {
            this.mostrarPopup = false;
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
        guardarFecha(programacion) {
            if (programacion) {
                if (this.fechaSeleccionada) {
                    programacion.fecha_instalacion = this.fechaSeleccionada;

                    axios.put(`/~max4orsal/public/api/programacion/${programacion.id}`, {
                        fecha_instalacion: this.fechaSeleccionada,
                    })
                        .then(response => {
                            console.log("Modificado con éxito", response);
                            programacion.editing = false;
                            alert("Registro modificado con éxito");
                        })
                        .catch(error => {
                            console.error("Error al guardar la programación:", error);
                        });
                }
            }
        },
        mapStatusToText(status) {
            if (status === 1) {
                return "A modificar";
            } else if (status === 2) {
                return "En proceso";
            } else if (status === 0) {
                return "En espera a cambios";
            } else if (status === 3) {
                return "Instalación terminada";
            } else if (status === 4) {
                return "Fotos en proceso";
            } else {
                return "En proceso";
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
        getPDFUrl(filename) {
            return `/~max4orsal/public/download-pdf/${filename}`;
        },
        handleButton1Click(programacion) {
            this.programacionId = programacion.id;
            this.articuloAEditar = programacion;
            this.mostrarFormulario = true;
        },
        guardarprogramacionEditada(programacionEditada) { },
        obtenerNombreArticulo(articuloId) {
            const articulo = this.articulos.find((a) => a.id === articuloId);
            return articulo ? articulo.nombre : "N/A";
        },
        filterTable() {
            const lowerCaseSearch = this.normalizeString(this.searchText);

            this.programacions = this.programacionsOriginal.filter((programacion) => {
                return Object.values(programacion).some((value) => {
                    const normalizedValue = this.normalizeString(value);
                    return normalizedValue.includes(lowerCaseSearch);
                });
            });
        },
        cancelarProgramacion(programacion, status) {  //Con este se cancela
            axios.put(`/~max4orsal/public/api/programacione/${programacion.id}`, {
                fecha_instalacion: null,
                status: 0
            })
                .then(response => {
                    console.log("Programación cancelada con éxito", response);
                    programacion.fecha_instalacion = null;
                    programacion.status = 0;
                })
                .catch(error => {
                    console.error("Error al cancelar la programación:", error);
                });
        },
        confirmCancelarProgramacion(programacion) {
            const confirmMessage = "¿Estás seguro de que deseas cancelar esta programación?";
            if (window.confirm(confirmMessage)) {
                this.cancelarProgramacion(programacion);
            } else {
            }
        },

        cancelarProgramacion(programacion) {
            axios.put(`/~max4orsal/public/api/programacione/${programacion.id}`, {
                fecha_instalacion: null,
                status: 0
            })
                .then(response => {
                    console.log("Programación cancelada con éxito", response);
                    programacion.fecha_instalacion = null;
                    programacion.fecha_termino = null;
                    programacion.id_users = null;

                    programacion.status = 0;
                })
                .catch(error => {
                    console.error("Error al cancelar la programación:", error);
                });
        },
        aceptaProgramacion2(programacion, status) { //Con este se acepta
            axios.put(`/~max4orsal/public/api/programacion/${programacion.id}`, {
                status: 3
            })
                .then(response => {
                    console.log("Status modificado con éxito", response);
                    programacion.status = 3;
                })
                .catch(error => {
                    console.error("Error al aceptar la programación 2:", error);
                });
        },
        aceptarProgramacion(programacion) {
            axios.put(`/~max4orsal/public/api/programacion/${programacion.id}`, {
                status: 2
            })
                .then(response => {
                    console.log("Programación aceptada con éxito", response);
                    programacion.status = 2;
                })
                .catch(error => {
                    console.error("Error al aceptar la programación 1:", error);
                });
        },

        guardarInstalacion(programacion) {
            const instalacionData = {
                id_programacion: programacion.id,
                img: null,
                status: 2,
                id_venta: programacion.id_venta,

            };
            axios.post('/~max4orsal/public/api/instalacion', instalacionData)
                .then(response => {
                    console.log("Guardado en instalación correctamente", response);
                })
                .catch(error => {
                    console.error("Error al aceptar la programación 3:", error);
                    console.log("Detalles del error:", error.response.data);

                });
        },
        aceptarProgramacion2(programacion) {
            this.aceptaProgramacion2(programacion);
            this.guardarInstalacion(programacion);
            this.modificarStatus4(programacion);


        },
        confirmAceptarProgramacion(programacion) {
            const confirmMessage = "¿Estás seguro de que deseas aceptar esta programación?";
            if (window.confirm(confirmMessage)) {
                this.aceptarProgramacion2(programacion);
            } else {
            }
        },

        modificarStatus4(programacion) {

            axios.post(`/~max4orsal/public/api/actualizar-venta4/${programacion.venta.id}`, {
            })
                .then(response => {
                    console.log("Venta actualizada con éxito", response);
                    alert("Registro modificado con éxito");
                })
                .catch(error => {
                    console.error("Error al actualizar la venta:", error);
                });
        },

        modificarStatus5(programacion) {

            axios.post(`/~max4orsal/public/api/actualizar-venta5/${programacion.venta.id}`, {
            })
                .then(response => {
                    console.log("Venta actualizada con éxito", response);
                    alert("Registro modificado con éxito");
                })
                .catch(error => {
                    console.error("Error al actualizar la venta:", error);
                });
        },
        handleButton3Click(programacion) {
            this.instalacionSeleccionada = programacion;
            this.mostrarDatosPopup = true;
        },


        cerrarDatosPopup() {
            this.mostrarDatosPopup = false;
        },
        cambiarStatus3(programacion, status) {
            axios.put(`/~max4orsal/public/api/programacioneee/${programacion.id}`, {
                status: 3
            })
                .then(response => {
                    console.log("Actualizada con exito", response);
                    programacion.status = 3;
                })
                .catch(error => {
                    console.error("Error al en la actualización:", error);
                });
        },
        confirmTerminarInstalacion(programacion) {
            const confirmMessage = "¿Estás seguro de que deseas terminar la instalación?";
            if (window.confirm(confirmMessage)) {
                this.terminarInstalacion(programacion);
                this.modificarStatus5(programacion);
            } else {
            }
        },

        terminarInstalacion(programacion) {
            axios.put(`/~max4orsal/public/api/programacioneeeee/${programacion.id}`, {
                status: 5
            })
                .then(response => {
                    console.log("Programación terminada con éxito", response);
                    programacion.status = 5;
                })
                .catch(error => {
                    console.error("Error al terminar la instalación:", error);
                });
        },

        mostrarDetalles(programacion) {
            if (programacion && typeof programacion === 'object') {
                axios
                    .get(`/~max4orsal/public/api/programacion/${programacion.id}/instalaciones`)
                    .then((response) => {
                        if (response.data.length > 0) {
                            const instalacionData = response.data[0];
                            this.instalacionSeleccionada = {
                                id: instalacionData.id,
                                id_programacion: instalacionData.id_programacion,
                                img: instalacionData.img,
                                status: instalacionData.status,
                                created_at: instalacionData.created_at,
                                updated_at: instalacionData.updated_at,
                            };

                            this.mostrarPopup = true;
                        } else {
                            console.error("No se encontraron datos de instalación en la respuesta.");
                        }
                    })
                    .catch((error) => {
                        console.error("Error al obtener los detalles de la instalación:", error);
                    });
            } else {
            }
        },
    },
    components: {
        InstalacionPopup,
        EditarInstalacionesForm,
        DatosInstalacionPopup,
    },
};
</script>
