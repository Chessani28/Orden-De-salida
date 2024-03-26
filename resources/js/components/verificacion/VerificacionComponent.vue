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
                    <button @click="filterByStatus([0])" class="nav-link" id="nav-docs-tab" data-bs-toggle="tab" data-bs-target="#nav-docs" type="button" role="tab" aria-controls="nav-docs"
                        aria-selected="false">Error en los documentos</button>
                    <button @click="filterByStatus([1])" class="nav-link" id="nav-done-tab" data-bs-toggle="tab" data-bs-target="#nav-done" type="button" role="tab" aria-controls="nav-done"
                        aria-selected="false">En revisión</button>
                        <button @click="filterByStatus([2, 3, 4, 5])" class="nav-link" id="nav-review-tab" data-bs-toggle="tab" data-bs-target="#nav-review" type="button" role="tab" aria-controls="nav-review" aria-selected="false">Documentos completos</button>

                </div>
            </nav>

            <div class="tab-content" id="nav-tabContent">
                <div class="tab-pane fade show active" id="nav-all" role="tabpanel" aria-labelledby="nav-all-tab">Contenido para Mostrar todos...</div>
                <div class="tab-pane fade" id="nav-docs" role="tabpanel" aria-labelledby="nav-docs-tab">Contenido para Documentos incorrectos...</div>
                <div class="tab-pane fade" id="nav-done" role="tabpanel" aria-labelledby="nav-done-tab">Contenido para Terminado...</div>
                <div class="tab-pane fade" id="nav-review" role="tabpanel" aria-labelledby="nav-review-tab">Contenido para En revisión...</div>
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
                                        <th @click="sortTable('id')">Numero de identificación</th>
                                        <th @click="sortTable('Ine')">Nombre del cliente</th>
                                        <th @click="sortTable('Ine')">Tipo de instalación</th>
                                        <th @click="sortTable('Luz')">Cambiar estatus</th>
                                        <th></th>
                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr v-for="(articulo, index) in articulos" :key="index">
                                        <td :class="{
                                            'text-red': articulo.status === 0,

                                            'text-green': articulo.status === 5 || articulo.status === 2 || articulo.status === 3 || articulo.status === 4,

                                            'text-yellow': articulo.status === 1

                                            //'text-black': articulo.status === 6
                                        }">
                                            {{ articulo.status === 0 ? '' : articulo.status === 1 ? '' : articulo.status === 2 ? '' : '' }}
                                        </td>
                                        <td>{{ articulo.id }}</td>

                                        <td>{{ articulo.nombre }}</td>

                                        <td>{{ mapStatusToTipo(articulo.tipo) }}</td>

                                        <td>
                                            <div v-if="articulo.status === 0">
                                                <span class="badge badge-danger">Error en los documentos
                                                    <i class="ni ni-collection" data-toggle="tooltip" data-placement="top" title="Documentos  revisados correctamente"></i>
                                            </span>
                                            </div>
                                            <div v-else-if="articulo.status === 2 || articulo.status === 3 || articulo.status === 4 || articulo.status === 5">
                                                <span class="badge badge-success">Documentos completos
                                                    <i class="ni ni-collection" data-toggle="tooltip" data-placement="top" title="Documentos  revisados correctamente"></i>
                                            </span>
                                            </div>
                                            <div v-else>

                                                <select v-model="articulo.status">
                                                    <option value="0">Error en los documentos</option>
                                                    <option value="2">Documentos completos</option>
                                                </select>
                                            </div>
                                        <td>
                                            <button class="btn-action btn-cambios" @click="confirmarModificar(articulo)" :disabled="articulo.status === 2 || articulo.status === 1 || articulo.status === 0 || articulo.status === 4">
                                                <span class="icon-pencil"></span>Modificar</button>
                                            <button class="btn-action btn-consultar" @click="handleButton3Click(articulo)" :disabled="articulo.tipo === 2">
                                                <i class ="icon-book1"></i>Datos</button>
                                        </td>
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
import DetalleInstalaciones from "./DetalleArticulos.vue";

export default {
    data() {
        return {
            articulos: [],
            botonVisible: true,
            usuarios: [],
            articulosOriginal: [],
            sortOrder: "asc",
            sortedColumn: "",
            searchText: "",
            mostrarFormulario: false,
            articuloAEditar: null,
            mostrarDetalle: false,
            articuloSeleccionado: null,
            selectedStatus: 0,
            currentPage: 1,
            pageSize: 10,
        };
    },

    mounted() {
        axios
        axios.get("/~max4orsal/public/api/ventas").then((response) => {
            this.articulos = response.data;
            this.articulosOriginal = response.data;

            const start = 0;
                const end = this.pageSize;
                this.articulos = this.articulosOriginal.slice(start, end);
                this.articulos.forEach(programacion => {
                });

            for (const articulo of this.articulos) {
                articulo.status = parseInt(articulo.status);
                articulo.botonVisible = true;
            }

            if (this.articulos.length > 0) {
                this.selectedStatus = this.articulos[0].status;
            }
        })
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

        handleSelectChange() {
            if (this.selectedStatus === 0) {
            } else if (this.selectedStatus === 1) {
            } else if (this.selectedStatus === 2) {
            }
        },
        confirmarModificar(articulo) {
            const confirmacion = window.confirm("¿Deseas modificar este artículo?");

            if (confirmacion) {
                this.guardarProgramacion(articulo);
                this.updateStatus(articulo);
            }
        },
        prevPage() {
            if (this.currentPage > 1) {
                this.currentPage -= 1;
                this.updateArticulos();
            }
        },

        nextPage() {
            const totalPages = Math.ceil(this.articulosOriginal.length / this.pageSize);
            if (this.currentPage < totalPages) {
                this.currentPage += 1;
                this.updateArticulos();
            }
        },

        updateArticulos() {
            const start = (this.currentPage - 1) * this.pageSize;
            const end = start + this.pageSize;
            this.articulos = this.articulosOriginal.slice(start, end);
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
        updateStatus(articulo, nuevoStatus) {
            nuevoStatus = articulo.status;
            console.log(articulo.nuevoStatus);

            axios
                .post(`/~max4orsal/public/api/ventas/${articulo.id}/update-status`, { status: nuevoStatus })
                .then((response) => {
                    console.log("Estado actualizado con éxito");
                    if (nuevoStatus === 2) {
                        this.guardarProgramacion(articulo);
                    }
                })
                .catch((error) => {
                    console.error("Error al actualizar el estatus:", error);
                });
        },
        guardarProgramacion(articulo) {
            if (articulo.status == 2) {
                const data = {
                    id_venta: articulo.id,
                    fecha_instalacion: null,
                    status: articulo.status,
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
            }
        },
        resetFilter() {
            this.articulos = this.articulosOriginal;
        },
        filterByStatus(status) {
            this.articulos = this.articulosOriginal.filter(articulo => status.includes(articulo.status));

        },
        UpdateStatusGuarModi(articulo) {
            this.guardarProgramacion(articulo);
            this.updateStatus(articulo);
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
        filterTable() {
            const lowerCaseSearch = this.searchText.toLowerCase();
            this.articulos = this.articulosOriginal.filter((articulo) => {
                return (
                    articulo.id.toString().includes(lowerCaseSearch) ||
                    articulo.ine.toLowerCase().includes(lowerCaseSearch) ||
                    articulo.luz.toLowerCase().includes(lowerCaseSearch) ||
                    articulo.ubicacion.toLowerCase().includes(lowerCaseSearch) ||
                    articulo.pago.toString().includes(lowerCaseSearch) ||
                    articulo.user.name.toLowerCase().includes(lowerCaseSearch) ||
                    (articulo.status === 0 && "sin terminar".includes(lowerCaseSearch)) ||
                    (articulo.status === 1 && "terminado".includes(lowerCaseSearch)) ||
                    (articulo.status === 2 && "En proceso".includes(lowerCaseSearch))
                );
            });
        },
        eliminarArticulo(articulo) {
            axios.put(`/~max4orsal/public/api/ventas/${articulo.id}`, { status: articulo.status })
                .then((response) => {
                    this.articulos = this.articulos.filter((item) => item.id !== articulo.id);
                })
                .catch((error) => {
                    console.error("Error al eliminar el artículo:", error);
                });
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
        DetalleInstalaciones,
    },
};
</script>
