<template>
    <!-- Contenido Principal -->
    <main class="main">
        <div class="container-fluid">
            <!-- Ejemplo de tabla Listado -->
            <div class="card">
                <div class="card-header">
                    <i class="fa fa-align-justify"></i> Paquetes a entregar
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
                            <th>Oficina Desde</th>
                            <th>Oficina Hasta</th>
                            <th>Identificador Paquete</th>
                            <th>Nombre Paquete</th>
                            <th>Entregar</th>
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
                                <button v-if="ruta.paqueteEstado != 'Entregado'" type="button" class="btn btn-warning btn-sm" @click="abrirModal('paquete','actualizar',ruta)">
                                  <i class="icon-pencil"></i> Registrar Entrega
                                </button> &nbsp;
                                <p  v-if="ruta.paqueteEstado == 'Entregado'">Entregado</p>
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
    <div :class="{'mostrar':modal }" class="modal fade"  tabindex="-1" role="dialog" aria-labelledby="myModalLabel" style="display: none;" aria-hidden="true">
        <div class="modal-dialog modal-primary modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" v-text="tituloModal"></h4>
                    <button type="button" class="close" @click="cerrarModal()"  aria-label="Close">
                      <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="" method="post" enctype="multipart/form-data" class="form-horizontal">
                        <div class="form-group row">
                            
                            <div class="col-md-6">
                            <label class="col-md-6 form-control-label h6" for="text-input">Descripcion entrega</label>
                                <input   type="text" v-model="descripcionEntrega" class="form-control" placeholder="Descripcion entrega" required>
                            </div>
                        </div>
                         
                        <div v-show="errorPaquete" class="form-group row div-error">
                            <div class="text-center text-error">
                                <div v-for=" error in errorMostrarMensajePaquete" :key="error" v-text="error">
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button @click="cerrarModal()" type="button" class="btn btn-secondary">Cerrar</button>
                    <button @click="registrarHistorial()" v-if="tipoAccion == 3" type="button" class="btn btn-primary">Registrar Entrega</button>
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
                errorPaquete: 0,
                errorMostrarMensajePaquete: [],
                arrayRuta: [],
                repartidorid: '',
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
                oficinahasta: 0,
                descripcionEntrega:''
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
            registrarHistorial(){
                        let me = this;
                        axios.post('/paquete/registrarHistorial',{
                            'descripcion':me.descripcionEntrega,
                            'identificadorPaquete':me.identificador,
                            'idPaquete':me.paquete,
                            'idRepartidor':me.repartidorid,
                            'fecha':''
                        })
                        .then(function (response) {
                         me.entregarPaquete();
                         me.listarRuta(1, '', 'encargado');
                        })
                        .catch(function (error) {
                            // handle error
                            console.log(error);
                        });
                    },
                    entregarPaquete(){
                        
                        let me = this;
                        axios.put('/paquete/entregarPaquete',{
                            'id':this.paquete
                        })
                        .then(function (response) {
                         me.listarRuta(1, '', 'encargado');
                        })
                        .catch(function (error) {
                            // handle error
                            console.log(error);
                        });
                    },
            validarPaqueteRuta() {
                this.errorPaquete = 0;
                this.errorMostrarMensajePaquete = [];
                if (!this.descripcionEntrega) this.errorMostrarMensajePaquete.push('La ruta no puede estar vacia.');
                if (this.errorMostrarMensajePaquete.length) this.errorPaquete = 1;
                return this.errorPaquete;
            },

     cerrarModal() {
                this.modal = 0;
                this.tituloModal = '';
                this.paquete = '';
                this.identificador = '';
                this.repartidorid = '';
                this.descripcionEntrega = '';
            },

            abrirModal(modelo, accion, data = []) {

                console.log(data);

                switch (modelo) {
                    case "paquete": {
                        switch (accion) {
                           
                            case "actualizar": {
                                this.tipoAccion = 3;
                                this.tituloModal = 'Registrar Entrega';
                                this.modal = 1;
                                this.desactivarCampos = 0;
                                this.identificador = data['paqueteIdentificador'];
                                this.paquete = data['paqueteId'];
                                this.repartidorid = data['repartidorId'];
                                
                                break;
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