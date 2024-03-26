<template>
    <div>


        <head>
            <meta charset="utf-8" />
            <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

            <!-- Fonts -->
            <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700" rel="stylesheet">
        </head>

        <div class="main-content">
            <detalle-instalaciones v-if="mostrarDetalle" :articulos="articuloSeleccionado" @cerrar="cerrarDetalle"></detalle-instalaciones>
            <nav>
                <div class="nav nav-tabs" id="nav-tab" role="tablist" style="float: right;">

                    <button @click="resetFilter" class="nav-link active" id="nav-all-tab" data-bs-toggle="tab" data-bs-target="#nav-all" type="button" role="tab" aria-controls="nav-all"
                        aria-selected="true">Mostrar todos</button>
                    <button @click="filterByStatus(0)" class="nav-link" id="nav-docs-tab" data-bs-toggle="tab" data-bs-target="#nav-docs" type="button" role="tab" aria-controls="nav-docs"
                        aria-selected="false">Documentos incorrectos</button>
                    <button @click="filterByStatus(1)" class="nav-link" id="nav-done-tab" data-bs-toggle="tab" data-bs-target="#nav-done" type="button" role="tab" aria-controls="nav-done"
                        aria-selected="false">En revisión</button>
                    <button @click="filterByStatus(2)" class="nav-link" id="nav-review-tab" data-bs-toggle="tab" data-bs-target="#nav-review" type="button" role="tab" aria-controls="nav-review"
                        aria-selected="false">En verificación</button>
                    <button @click="filterByStatus(3)" class="nav-link" id="nav-verify-tab" data-bs-toggle="tab" data-bs-target="#nav-verify" type="button" role="tab" aria-controls="nav-verify"
                        aria-selected="false">En programación</button>
                    <button @click="filterByStatus(4)" class="nav-link" id="nav-inslation-tab" data-bs-toggle="tab" data-bs-target="#nav-inslation" type="button" role="tab" aria-controls="nav-inslation"
                        aria-selected="false">En instalación</button>
                    <button @click="filterByStatus(5)" class="nav-link" id="nav-finish-tab" data-bs-toggle="tab" data-bs-target="#nav-finish" type="button" role="tab" aria-controls="nav-finish"
                        aria-selected="false">Terminado</button>
                </div>
            </nav>

            <div class="tab-content" id="nav-tabContent">
                <div class="tab-pane fade show active" id="nav-all" role="tabpanel" aria-labelledby="nav-all-tab">Contenido para Mostrar todos...</div>
                <div class="tab-pane fade" id="nav-docs" role="tabpanel" aria-labelledby="nav-docs-tab">Contenido para Documentos incorrectos...</div>
                <div class="tab-pane fade" id="nav-done" role="tabpanel" aria-labelledby="nav-done-tab">Contenido para En revisión...</div>
                <div class="tab-pane fade" id="nav-review" role="tabpanel" aria-labelledby="nav-review-tab">Contenido para En verificación...</div>
                <div class="tab-pane fade" id="nav-verify" role="tabpanel" aria-labelledby="nav-verify-tab">Contenido para En programación...</div>
                <div class="tab-pane fade" id="nav-inslation" role="tabpanel" aria-labelledby="nav-inslation-tab">Contenido para En instalación...</div>
                <div class="tab-pane fade" id="nav-finish" role="tabpanel" aria-labelledby="nav-finish-tab">Contenido para terminado...</div>
            </div>
            <!-- Table -->
            <br>
            <div class="pagination">
                <a @click="prevPage" :disabled="currentPage === 1" class="page-link" href="#" tabindex="-1"><i class="ni ni-bold-left"></i></a>
                <a @click="nextPage" :disabled="currentPage * pageSize >= articulosOriginal.length" class="page-link" href="#"><i class="ni ni-bold-right"></i></a>
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
                                        <th>Nombre del cliente</th>
                                        <th>Tipo de instalación</th>
                                        <th>Estatus</th>

                                    </tr>
                                </thead>
                                <tbody>
                                    <tr v-for="(articulo, index) in articulos" :key="index">
                                        <td :class="{
                                            'text-red': articulo.status === 0,

                                            'text-yellow': articulo.status === 1,

                                            'text-greey': articulo.status === 2,

                                            'text-cian': articulo.status === 3,

                                            'text-blue': articulo.status === 4,

                                            'text-green': articulo.status === 5

                                            //'text-black': articulo.status === 6
                                        }">

                                            {{ articulo.status === 0 ? '' : articulo.status === 6 ? '' : '' }}
                                        </td>

                                        <td>{{ articulo.id }}</td>

                                        <td>{{ articulo.nombre || 'Sin nombre' }}</td>

                                        <td>{{ mapStatusToTipo(articulo.tipo) }}</td>
                                        <td
                                            :class="{ '': articulo.status === 0, '': articulo.status === 1, '': articulo.status === 2, '': articulo.status === 3, '': articulo.status === 4, '': articulo.status === 5 }">

                                            <span v-if="articulo.status === 0" class="badge badge-danger">Documentos incorrectos
                                                    <i class="icon-terminal" data-toggle="tooltip" data-placement="top" title="Favor de modificar documentos..."></i>
                                            </span>
                                            <span v-else-if="articulo.status === 1" class="badge badge-warning">En revisión
                                                    <i class="icon-terminal" data-toggle="tooltip" data-placement="top" title="Revisando documentos..."></i>
                                            </span>
                                            <span v-else-if="articulo.status === 2" class="badge badge-dark">En verificación
                                                    <i class="icon-terminal" data-toggle="tooltip" data-placement="top" title="Documentos completos..."></i>
                                            </span>
                                            <span v-else-if="articulo.status === 3" class="badge badge-info">En programación
                                                    <i class="icon-terminal" data-toggle="tooltip" data-placement="top" title="Programando fecha e instalador..."></i>
                                            </span>
                                            <span v-else-if="articulo.status === 4" class="badge badge-primary">En instalación
                                                    <i class="icon-terminal" data-toggle="tooltip" data-placement="top" title="Instalando..."></i>
                                            </span>
                                            <span v-else-if="articulo.status === 5" class="badge badge-success">Instalación Terminada
                                                    <i class="icon-terminal" data-toggle="tooltip" data-placement="top" title="Instalación terminada"></i>
                                            </span>

                                            <button style="float: right;" class="btn-action btn-cambios" @click="handleButton1Click(articulo)"
                                                :disabled="articulo.status === 1 || articulo.status === 2 || articulo.status === 3 || articulo.status === 4 || articulo.status === 5">
                                                <span class="icon-pencil"></span> Modificar
                                            </button>
                                            <button style="float: right;" class="btn-action btn-eliminar" @click="confirmarEliminacion(articulo)"
                                                :disabled="articulo.status === 2 || articulo.status === 3 || articulo.status === 4 || articulo.status === 5">
                                                <span class="icon-bin"></span>
                                                Eliminar
                                            </button>
                                            <button style="float: right;" class="btn-action btn-consultar" @click="handleButton3Click(articulo)">
                                                <i class ="icon-book1"></i>
                                                Datos
                                            </button>
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
            <Editar-Instalaciones-Form v-if="mostrarFormulario" :articulos="articuloAEditar" @guardar="guardarArticuloEditado" @cancelar="cerrarFormulario"></Editar-Instalaciones-Form>
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
import EditarInstalacionesForm from "./EditarVentaForm.vue";
import DetalleInstalaciones from "./DetalleVenta.vue";

export default {
    data() {
        return {
            articulos: [],
            usuarios: [],
            articulosOriginal: [],
            sortOrder: "asc",
            sortedColumn: "",
            searchText: "",
            mostrarFormulario: false,
            articuloAEditar: null,
            mostrarDetalle: false,
            articuloSeleccionado: null,
            currentPage: 1,
            pageSize: 10,
        };
    },

    mounted() {
        axios
            .get("/~max4orsal/public/api/ventas")
            .then((response) => {
                this.articulosOriginal = response.data;
                this.updateArticulos();
            })
            .catch((error) => {
                console.error("Error al obtener los artículos:", error);
                axios
                    .get("/~max4orsal/public/api/user")
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
    created() {
    },
    methods: {
        sortTable(column) {
            if (this.sortOrder === "asc") {
                this.articulos.sort((a, b) => (a[column] < b[column] ? -1 : 1));
                this.sortOrder = "desc";
            } else {
                this.articulos.sort((a, b) => (a[column] > b[column] ? -1 : 1));
                this.sortOrder = "asc";
            }
            this.sortedColumn = column;
        },
        updateArticulos() {
            const start = (this.currentPage - 1) * this.pageSize;
            const end = start + this.pageSize;
            this.articulos = this.articulosOriginal.slice(start, end);
        },
        getPDFUrl(filename) {
            return `/~max4orsal/public/download-pdf/${filename}`;
        },
        handleButton1Click(articulo) {
            console.log(articulo);
            this.articuloAEditar = articulo;
            this.mostrarFormulario = true;
        },
        guardarArticuloEditado(articuloEditado) { },
        cerrarFormulario() {
            this.mostrarFormulario = false;
        },
        prevPage() {
            if (this.currentPage > 1) {
                this.currentPage -= 1;
                this.updateArticulos();
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
        nextPage() {
            const totalPages = Math.ceil(this.articulosOriginal.length / this.pageSize);
            if (this.currentPage < totalPages) {
                this.currentPage += 1;
                this.updateArticulos();
            }
        },
        filterByStatus(status) {
            this.articulos = this.articulosOriginal.filter(articulo => articulo.status === status);
        },
        toggleSort(column) {
            if (this.sortOrder === 'asc') {
                this.articulos.sort((a, b) => (a[column] < b[column] ? -1 : 1));
                this.sortOrder = 'desc';
            } else {
                this.articulos.sort((a, b) => (a[column] > b[column] ? -1 : 1));
                this.sortOrder = 'asc';
            }
            this.sortedColumn = column;
            this.iconoSeleccionado = this.sortOrder;
        },
        resetFilter() {
            this.articulos = this.articulosOriginal;
        },
        filterTable() {
            const lowerCaseSearch = this.searchText.toLowerCase();
            this.articulos = this.articulosOriginal.filter((articulo) => {
                const statusString = articulo.status === 0 ? "Documentos incorrectos" :
                    articulo.status === 1 ? "En revisión" :
                        articulo.status === 2 ? "En programación" : "";

                return (
                    articulo.id.toString().includes(lowerCaseSearch) ||
                    articulo.ine.toLowerCase().includes(lowerCaseSearch) ||
                    articulo.luz.toLowerCase().includes(lowerCaseSearch) ||
                    articulo.ubicacion.toLowerCase().includes(lowerCaseSearch) ||
                    articulo.pago.toString().includes(lowerCaseSearch) ||
                    articulo.user.name.toLowerCase().includes(lowerCaseSearch) ||
                    statusString.includes(lowerCaseSearch)
                );
            });
        }
        ,
        eliminarArticulo(articulo) {
            axios
                .delete(`/~max4orsal/public/api/ventas/${articulo.id}`)
                .then((response) => {
                    this.articulos = this.articulos.filter((item) => item.id !== articulo.id);
                })
                .catch((error) => {
                    console.error("Error al eliminar el artículo:", error);
                });
        },

        confirmarEliminacion(articulo) {
            if (confirm("¿Estás seguro de que deseas eliminar este artículo?")) {
                this.eliminarArticulo(articulo);
            }
        },
        confirmarEliminacion(articulo) {
            if (confirm("¿Estás seguro de que deseas eliminar este artículo?")) {
                this.eliminarArticulo(articulo);
            }
        },
        handleButton3Click(articulo) {
            this.mostrarDetalle = true;
            this.articuloSeleccionado = articulo;

        },
        cerrarDetalle() {
            this.mostrarDetalle = false;
            this.articuloSeleccionado = null;
        },
    },
    components: {
        EditarInstalacionesForm,
        DetalleInstalaciones,
    },
};
</script>
<style>
@import 'css/tablaVComponent.css'
</style>
