<template>
    <!-- Contenido Principal -->
    <main class="main">
        <div class="container-fluid">
            <!-- Ejemplo de tabla Listado -->
            <div class="card">
                <div class="card-header">
                    <i class="fa fa-align-justify"></i> Paquetes en Ruta
                    <button type="button" class="btn btn-secondary" @click="abrirModal('ruta','registrar')">
                        <i class="icon-plus"></i>&nbsp;Nueva Ruta
                    </button>
                    <button type="button" class="btn btn-secondary" @click="abrirModal('ruta','ver')">
                        <i class="icon-plus"></i>&nbsp;Ver Rutas Sin Paquete
                    </button>
                    <button type="button" class="btn btn-secondary" @click="abrirModal('ruta','paquete')">
                        <i class="icon-plus"></i>&nbsp;Asignar Paquete
                    </button>
                </div>
                <div class="card-body">
                    <div class="form-group row">
                        <div class="col-md-6">
                            <div class="input-group">
                                <select class="form-control col-md-3" v-model="criterio">
                                    <option value="encargado">Encargado</option>
                                    <option value="idpaquete">Id Paquete</option>
                                    <option value="nombrepaquete">Nombre Paquete</option>
                                </select>
                                <input @keyup.enter="listarRuta(1,buscar,criterio)" type="text" v-model="buscar"
                                       v-text="buscar" class="form-control" placeholder="Texto a buscar">
                                <button @click="listarRuta(1,buscar,criterio)" type="submit" class="btn btn-primary"><i
                                        class="fa fa-search"></i> Buscar
                                </button>
                            </div>
                        </div>
                    </div>
                    <table class="table table-bordered table-striped table-sm">
                        <thead>
                        <tr>
                            <th>Encargado</th>
                            <th>Ruta</th>
                            <th>Desde</th>
                            <th>Hasta</th>
                            <th>Identificador Paquete</th>
                            <th>Nombre Paquete</th>

                            <th>Eliminar</th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr v-for="ruta in arrayRuta" :key="ruta.id">

                            <td v-text="ruta.repartidorNombre"></td>
                            <td v-text="ruta.rutaTipo + ' ' + ruta.nombre"></td>
                            <td v-text="ruta.desdeNombre"></td>
                            <td v-text="ruta.hastaNombre"></td>
                            <td v-text="ruta.paqueteIdentificador"></td>
                            <td v-text="ruta.paqueteDescripcion"></td>
                            <td>
                                <button @click="eliminarRuta(ruta.id)" type="button" class="btn btn-danger btn-sm">
                                    <i class="icon-trash"></i>
                                </button> &nbsp;
                            </td>
                        </tr>
                        </tbody>
                    </table>
                    <nav>
                        <ul class="pagination">
                            <li class="page-item" v-if="pagination.current_page > 1">
                                <a class="page-link" href="#"
                                   @click.prevent="cambiarPagina(arrayRuta.current_page - 1, buscar, criterio)">Ant</a>
                            </li>
                            <li class="page-item active" v-for="page in pageNumber" :key="page"
                                :class="[page == isActive ? 'active' : '']">
                                <a class="page-link" href="#" @click.prevent="cambiarPagina(page, buscar, criterio)"
                                   v-text="page"></a>
                            </li>
                            <li class="page-item" v-if="pagination.current_page < pagination.last_page">
                                <a class="page-link" href="#"
                                   @click.prevent="cambiarPagina(arrayRuta.current_page + 1, buscar, criterio)">Sig</a>
                            </li>
                        </ul>
                    </nav>
                </div>
            </div>
            <!-- Fin ejemplo de tabla Listado -->
        </div>
        <!--Inicio del modal agregar/actualizar-->
        <div :class="{'mostrar':modal }" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
             style="display: none;" aria-hidden="true">
            <div class="modal-dialog modal-primary modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title" v-text="tituloModal"></h4>
                        <button type="button" class="close" @click="cerrarModal()" aria-label="Close">
                            <span aria-hidden="true">×</span>
                        </button>
                    </div>

                    <div class="modal-body" v-if="tipoAccion == 4">

                        <form action="" method="post" enctype="multipart/form-data" class="form-horizontal">
                            <div class="form-group row">

                                <div class="col-md-6">
                                    <label class="col-md-6 form-control-label h6" for="text-input">Ruta</label>
                                    <select class="form-control col-md-6" :disabled="desactivarCampos == 1"
                                            v-model="rutaId" v-bind:value="rutaId">
                                        <option v-for="ruta in arrayRutaSola" :key="ruta.id"
                                                v-text="ruta.nombre" v-bind:value="ruta.id"></option>
                                    </select>
                                </div>

                                <div class="col-md-6">
                                    <label class="col-md-6 form-control-label h6" for="text-input">Paquete</label>
                                    <select class="form-control col-md-6" :disabled="desactivarCampos == 1"
                                            v-model="paquete" v-bind:value="paquete">
                                        <option v-for="paquete in arrayPaquetes" :key="paquete.id"
                                                v-text="paquete.descripcion" v-bind:value="paquete.id"></option>
                                    </select>
                                </div>

                                <div class="col-md-6">
                                    <label class="col-md-6 form-control-label h6" for="text-input">Oficina Desde</label>
                                    <select class="form-control col-md-6" :disabled="desactivarCampos == 1"
                                            v-model="oficinadesde" v-bind:value="oficinadesde">
                                        <option v-for="oficina in arrayOficinas" :key="oficina.id"
                                                v-text="oficina.nombreOficina" v-bind:value="oficina.id"></option>
                                    </select>
                                </div>

                                <div class="col-md-6">
                                    <label class="col-md-6 form-control-label h6" for="text-input">Oficina Hasta</label>
                                    <select class="form-control col-md-6" :disabled="desactivarCampos == 1"
                                            v-model="oficinahasta" v-bind:value="oficinahasta">
                                        <option v-for="oficina in arrayOficinas" :key="oficina.id"
                                                v-text="oficina.nombreOficina" v-bind:value="oficina.id"></option>
                                    </select>
                                </div>

                            </div>
                            <div v-show="errorRuta" class="form-group row div-error">
                                <div class="text-center text-error">
                                    <div v-for=" error in errorMostrarMensajeRuta" :key="error" v-text="error">
                                    </div>
                                </div>
                            </div>
                        </form>

                    </div>

                    <div v-else>

                        <div class="modal-body" v-if="tipoAccion == 1">
                            <table class="table table-bordered table-striped table-sm">
                                <thead>
                                <tr>
                                    <th>Encargado</th>
                                    <th>Id</th>
                                    <th>Nombre</th>
                                    <th>Tipo</th>

                                    <th>Editar</th>
                                    <th>Eliminar</th>
                                </tr>
                                </thead>
                                <tbody>
                                <tr v-for="ruta in arrayRutaSola" :key="ruta.id">

                                    <td v-text="ruta.repartidorNombre"></td>
                                    <td v-text="ruta.id"></td>
                                    <td v-text="ruta.nombre"></td>
                                    <td v-text="ruta.rutaTipo"></td>
                                    <td>
                                        <button type="button" class="btn btn-warning btn-sm"
                                                @click="abrirModal('ruta','actualizar',ruta)">
                                            <i class="icon-pencil"></i>
                                        </button> &nbsp;
                                    </td>
                                    <td>
                                        <button @click="eliminarRuta(ruta.id)" type="button" class="btn btn-danger btn-sm">
                                            <i class="icon-trash"></i>
                                        </button> &nbsp;
                                    </td>
                                </tr>
                                </tbody>
                            </table>
                        </div>

                        <div class="modal-body" v-else>
                            <form action="" method="post" enctype="multipart/form-data" class="form-horizontal">
                                <div class="form-group row">

                                    <div class="col-md-6">
                                        <label class="col-md-6 form-control-label h6" for="text-input">Encargado</label>
                                        <select class="form-control col-md-6" :disabled="desactivarCampos == 1"
                                                v-model="repartidorid" v-bind:value="repartidorid">
                                            <option v-for="repartidor in arrayRepartidores" :key="repartidor.id"
                                                    v-text="repartidor.nombre" v-bind:value="repartidor.id"></option>
                                        </select>
                                    </div>

                                    <div class="col-md-6">
                                        <label class="col-md-6 form-control-label h6" for="text-input">Ruta</label>
                                        <input :disabled="desactivarCampos == 1" type="text" v-model="ruta"
                                               class="form-control" placeholder="Nombre de la Ruta" required>
                                    </div>

                                    <div class="col-md-6">
                                        <label class="col-md-6 form-control-label h6" for="text-input">Tipo</label>
                                        <select class="form-control col-md-6" :disabled="desactivarCampos == 1"
                                                v-model="tiporuta" v-bind:value="tiporuta">
                                            <option v-for="tipo in arrayRutasTipos" :key="tipo.id"
                                                    v-text="tipo.tipo" v-bind:value="tipo.id"></option>
                                        </select>
                                    </div>

                                </div>
                                <div v-show="errorRuta" class="form-group row div-error">
                                    <div class="text-center text-error">
                                        <div v-for=" error in errorMostrarMensajeRuta" :key="error" v-text="error">
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>

                    </div>

                    <div class="modal-footer">
                        <button @click="cerrarModal()" type="button" class="btn btn-secondary">Cerrar</button>
                        <button @click="registrarRuta()" v-if="tipoAccion == 2" type="button" class="btn btn-primary">
                            Guardar
                        </button>
                        <button @click="registrarPaquete()" v-if="tipoAccion == 4" type="button" class="btn btn-primary">
                            Guardar
                        </button>
                        <button @click="actualizarRuta()" v-if="tipoAccion == 3" type="button" class="btn btn-primary">
                            Actualizar
                        </button>
                    </div>
                </div>
                <!-- /.modal-content -->
            </div>
            <!-- /.modal-dialog -->
        </div>
        <!--Fin del modal-->

    </main>
    <!-- /Fin del contenido principal -->
</template>

<script>
    export default {
        data() {
            return {
                zona: '',
                zonaid: 0,
                remitente: '',
                destinatario: '',
                nombreOficina: '',
                oficinaid: '',
                estadoid: '',
                identificador: '',
                direccion: '',
                descripcion: '',
                peso: 0,
                montoACancelar: 0,
                modal: 0, // Indica si muestra u oculta el modal
                tituloModal: '', // Titulo del Modal
                tipoAccion: 0,
                errorRuta: 0,
                errorMostrarMensajeRuta: [],

                arrayRuta: [],
                arrayPaquetes: [],
                arrayOficinas: [],
                arrayRutaSola: [],
                arrayRepartidores: [],
                arrayRutasTipos: [],
                repartidorid: 1,
                ruta: '',
                fecharuta: '',
                tiporuta: 1,
                desactivarCampos: 0,
                pagination: {
                    'total': 0,
                    'current_page': 0,
                    'per_page': 0,
                    'last_page': 0,
                    'from': 0,
                    'to': 0
                },
                offset: 0,
                criterio: 'encargado',
                buscar: '',
                rutaId: 0,
                paquete: 0,
                oficinadesde: 0,
                oficinahasta: 0
            }
        },
        computed: {
            isActive: function () {
                return this.pagination.current_page;
            },
            pageNumber: function () {
                if (!this.pagination.to) {
                    return [];
                }

                var from = this.pagination.current_page - this.offset;
                if (from < 1) {
                    from = 1;
                }
                var to = from + (this.offset * 2);
                if (to >= this.pagination.last_page) {
                    to = this.pagination.last_page;
                }

                var pagesArray = [];
                while (from <= to) {
                    pagesArray.push(from);
                    from++;
                }
                return pagesArray;
            }

        },
        methods: {

            listarRuta(page, buscar, criterio) {
                let me = this;
                var url = '/ruta?page=' + page + '&buscar=' + buscar + '&criterio=' + criterio;
                // Make a request for a user with a given ID
                axios.get(url)
                    .then(function (response) {
                        var respuesta = response.data;
                        me.arrayRuta = respuesta.rutas.data;
                        me.arrayRepartidores = respuesta.repartidores;
                        me.arrayRutasTipos = respuesta.rutasTipos;
                        me.arrayRutaSola = respuesta.rutaSola.data;
                        me.arrayPaquetes = respuesta.paquetes;
                        me.arrayOficinas = respuesta.oficinas;
                        me.pagination = respuesta.pagination;
                    })
                    .catch(function (error) {
                        // handle error
                        console.log(error);
                    });
            },

            cambiarPagina(page, buscar, criterio) {
                let me = this;
                me.pagination.current_page = page;
                me.listarRuta(page, buscar, criterio);
            },

            registrarRuta() {
                if (this.validarRuta() == 1) {
                    return;
                }

                let me = this;
                axios.post('/ruta/registrar', {
                    'repartidorid': me.repartidorid,
                    'ruta': me.ruta,
                    'fecharuta': me.fecharuta,
                    'tiporuta': me.tiporuta,
                })
                    .then(function (response) {
                        me.cerrarModal();
                        me.listarRuta(1, '', '');
                    })
                    .catch(function (error) {
                        // handle error
                        console.log(error);
                    });
            },

            registrarPaquete() {
                if (this.validarPaqueteRuta() == 1) {
                    return;
                }

                let me = this;
                axios.post('/ruta/registrarpaquete', {
                    'ruta': me.rutaId,
                    'paquete': me.paquete,
                    'desde': me.oficinadesde,
                    'hasta': me.oficinahasta,
                })
                    .then(function (response) {
                        me.cerrarModal();
                        me.listarRuta(1, '', '');
                    })
                    .catch(function (error) {
                        // handle error
                        console.log(error);
                    });
            },

            actualizarRuta() {
                if (this.validarRuta() == 1) {
                    return;
                }
                let me = this;

                console.log('test');
                console.log(me);

                axios.put('/ruta/actualizar', {
                    'id': me.rutaId,
                    'repartidorid': me.repartidorid,
                    'ruta': me.ruta,
                    'fecharuta': me.fecharuta,
                    'tiporuta': me.tiporuta,
                })
                    .then(function (response) {
                        me.cerrarModal();
                        me.listarRuta(1, '', 'remitente');
                    })
                    .catch(function (error) {
                        // handle error
                        console.log(error);
                    });
            },

            eliminarRuta(id) {
                const swalWithBootstrapButtons = swal.mixin({
                    confirmButtonClass: 'btn btn-success',
                    cancelButtonClass: 'btn btn-danger',
                    buttonsStyling: false,
                })

                swalWithBootstrapButtons({
                    title: 'Deseas eliminar este Ruta?',
                    text: "No podras revertir esto!",
                    type: 'warning',
                    showCancelButton: true,
                    confirmButtonText: 'Si, eliminalo!',
                    cancelButtonText: 'No, cancelelo!',
                    reverseButtons: true
                }).then((result) => {
                    let me = this;
                    if (result.value) {
                        axios.post('/ruta/eliminar', {
                            'id': id
                        })
                            .then(function (response) {
                                swalWithBootstrapButtons(
                                    'Eliminado!',
                                    'El registro ha sido eliminado.',
                                    'success'
                                )
                                me.cerrarModal();
                                me.listarRuta(1, '', 'remitente');
                            })
                            .catch(function (error) {
                                // handle error
                                console.log(error);
                            });
                    } else if (
                        // Read more about handling dismissals
                    result.dismiss === swal.DismissReason.cancel
                    ) {
                        swalWithBootstrapButtons(
                            'Cancelled',
                            'La eliminacion ha sido cancelada',
                            'error'
                        )
                    }
                })
            },
            validarRuta() {
                this.errorRuta = 0;
                this.errorMostrarMensajeRuta = [];
                if (!this.repartidorid) this.errorMostrarMensajeRuta.push('La repartidor no puede estar vacia.');
                if (!this.ruta) this.errorMostrarMensajeRuta.push('El nombre de la ruta no puede estar vacio.');
                if (!this.tiporuta) this.errorMostrarMensajeRuta.push('El tipo no puede estar vacia.');
                if (this.errorMostrarMensajeRuta.length) this.errorRuta = 1;
                return this.errorRuta;
            },

            validarPaqueteRuta() {
                this.errorRuta = 0;
                this.errorMostrarMensajeRuta = [];
                if (!this.rutaId) this.errorMostrarMensajeRuta.push('La ruta no puede estar vacia.');
                if (!this.paquete) this.errorMostrarMensajeRuta.push('Paquete no puede estar vacio.');
                if (!this.oficinadesde) this.errorMostrarMensajeRuta.push('Oficina desde no puede estar vacia.');
                if (!this.oficinahasta) this.errorMostrarMensajeRuta.push('Oficina hasta no puede estar vacia.');
                if (this.errorMostrarMensajeRuta.length) this.errorRuta = 1;
                return this.errorRuta;
            },

            cerrarModal() {
                this.modal = 0;
                this.tituloModal = '';
                this.zona = '';
                this.zonaid = 0;
                this.remitente = '';
                this.destinatario = '';
                this.direccion = '';
                this.peso = '';
                this.montoACancelar = '';
                this.oficinaid = '';
                this.estadoid = '';
                this.descripcion = '';
                this.identificador = '';

                this.repartidorid = 1;
                this.ruta = '';
                this.fecharuta = '';
                this.tiporuta = 1;
            },

            abrirModal(modelo, accion, data = []) {

                console.log(data);

                switch (modelo) {
                    case "ruta": {
                        switch (accion) {
                            case "ver": {
                                this.tipoAccion = 1;
                                this.tituloModal = 'Rutas sin Paquete';
                                this.modal = 1;
                                this.desactivarCampos = 1;
                                this.zona = data['zona'];
                                this.zonaid = data['zonaid'];
                                this.remitente = data['remitente'];
                                this.destinatario = data['destinatario'];
                                this.descripcion = data['descripcion'];
                                this.direccion = data['direccion'];
                                this.peso = data['peso'];
                                this.montoACancelar = data['montoACancelar'];
                                this.estadoid = data['idestado'];
                                this.identificador = data['identificador'];
                                this.oficinaid = data['idoficina'];
                                break;
                            }
                            case "registrar": {
                                this.tipoAccion = 2;
                                this.tituloModal = 'Registrar Ruta';
                                this.modal = 1;
                                this.desactivarCampos = 0;
                                this.repartidorid = 1;
                                this.ruta = '';
                                this.fecharuta = '';
                                this.tiporuta = 1;
                                break;
                            }
                            case "actualizar": {
                                this.tipoAccion = 3;
                                this.tituloModal = 'Actualizar Ruta';
                                this.modal = 1;
                                this.desactivarCampos = 0;
                                this.repartidorid = data['repartidorId'];
                                this.ruta = data['nombre'];
                                this.fecharuta = data['id'];
                                this.tiporuta = data['rutaId'];
                                this.rutaId = data['id'];
                                break;
                            }
                            case "eliminar": {
                                break;
                            }
                            case "paquete": {
                                this.tipoAccion = 4;
                                this.tituloModal = 'Asignar Paquete a Ruta';
                                this.modal = 1;
                                this.desactivarCampos = 0;
                                this.rutaId = 0;
                                this.paquete = 0;
                                this.oficinadesde = 0;
                                this.oficinahasta = 0;
                            }
                        }
                        break;
                    }
                }
            }

        },
        mounted() {
            this.listarRuta(1, this.buscar, this.criterio);
        }
    }
</script>
<style>
    .modal-header {
        padding: 25px;
    }

    .modal-content {
        width: 100% !important;
        max-height: 500px !important;
        position: absolute !important;
        overflow-y: scroll;
        padding: 20px;
    }

    .mostrar {
        display: list-item !important;
        opacity: 1;
        position: absolute !important;
        background-color: #3c29297a !important;
    }

    .div-error {
        display: flex;
        justify-content: center;
    }

    .text-error {
        color: red !important;
        font-weight: bold;
    }
</style>