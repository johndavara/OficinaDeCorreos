<template>
<!-- Contenido Principal -->
<main class="main">
    <div class="container-fluid">
        <!-- Ejemplo de tabla Listado -->
        <div class="card">
            <div class="card-header">
                <i class="fa fa-align-justify"></i> Paquetes
                <button type="button" class="btn btn-secondary" @click="abrirModal('paquete','registrar')">
                    <i class="icon-plus"></i>&nbsp;Nuevo
                </button>
            </div>
            <div class="card-body">
                <div class="form-group row">
                    <div class="col-md-6">
                        <div class="input-group">
                            <select class="form-control col-md-3" v-model="criterio">
                              <option value="remitente">Remitente</option>
                              <option value="destinatario">Destinatario</option>
                              <option value="identificador">Identificador</option>
                              <option value="zona">Zona</option>
                            </select>
                            <input @keyup.enter="listarPaquete(1,buscar,criterio)" type="text" v-model="buscar" v-text="buscar" class="form-control" placeholder="Texto a buscar">
                            <button @click="listarPaquete(1,buscar,criterio)" type="submit" class="btn btn-primary"><i class="fa fa-search"></i> Buscar</button>
                        </div>
                    </div>
                </div>
                <table class="table table-bordered table-striped table-sm">
                    <thead>
                        <tr>
                            <th>Zona</th>
                            <th>Descripcion</th>
                            <th>Remitente</th>
                            <th>Destinatario</th>
                            <th>Identificador</th>
                            <th>Detalles</th>
                            <th>Editar</th>
                            <th>Eliminar</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="paquete in arrayPaquete" :key="paquete.id">
                            
                            <td v-text="paquete.zona"></td>
                            <td v-text="paquete.descripcion"></td>
                            <td v-text="paquete.remitente"></td>
                            <td v-text="paquete.destinatario"></td>
                            <td v-text="paquete.identificador"></td>
                            <td>
                                <button type="button" class="btn btn-info btn-sm" @click="abrirModal('paquete','ver',paquete)">
                                  <i class="icon-list"></i>
                                </button>
                            </td>
                            <td>
                                <button type="button" class="btn btn-warning btn-sm" @click="abrirModal('paquete','actualizar',paquete)">
                                  <i class="icon-pencil"></i>
                                </button> &nbsp;
                            </td>
                            <td>
                                <button @click="eliminarPaquete(paquete.id)" type="button" class="btn btn-danger btn-sm">
                                  <i class="icon-trash"></i>
                                </button> &nbsp;
                            </td>
                        </tr>
                    </tbody>
                </table>
                <nav>
                    <ul class="pagination">
                        <li class="page-item" v-if="pagination.current_page > 1">
                            <a class="page-link" href="#" @click.prevent="cambiarPagina(arrayPaquete.current_page - 1, buscar, criterio)">Ant</a>
                        </li>
                        <li class="page-item active" v-for="page in pageNumber" :key="page" :class="[page == isActive ? 'active' : '']">
                            <a class="page-link" href="#" @click.prevent="cambiarPagina(page, buscar, criterio)" v-text="page"></a>
                        </li>
                        <li class="page-item" v-if="pagination.current_page < pagination.last_page">
                            <a class="page-link" href="#" @click.prevent="cambiarPagina(arrayPaquete.current_page + 1, buscar, criterio)">Sig</a>
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
                            <label class="col-md-6 form-control-label h6" for="text-input">Zona</label>
                            <select class="form-control col-md-6" :disabled="desactivarCampos == 1" v-model="zonaid" v-bind:value="zonaid">
                                <option v-for="itemZona in arrayZona" :key="itemZona.id" v-text="itemZona.nombre" v-bind:value="itemZona.id"></option>
                            </select>
                            </div>
                            <div class="col-md-6">
                            <label class="col-md-6 form-control-label h6" for="text-input">Remitente</label>
                                <input :disabled="desactivarCampos == 1"  type="text" v-model="remitente" class="form-control" placeholder="Nombre del remitente" required>
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-md-6">
                            <label class="col-md-6 form-control-label h6" for="text-input">Destinatario</label>
                                <input :disabled="desactivarCampos == 1"  type="text" v-model="destinatario" class="form-control" placeholder="Destinatario" required>
                            </div>
                            <div class="col-md-6">
                            <label class="col-md-6 form-control-label h6" for="text-input">Dirección de Entrega</label>
                                <input :disabled="desactivarCampos == 1"  type="text" v-model="direccion" class="form-control" placeholder="Dirección de Entrega" required>
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-md-6">
                            <label class="col-md-6 form-control-label h6" for="text-input">Peso</label>
                                <input :disabled="desactivarCampos == 1"  type="text" v-model="peso" class="form-control" placeholder="Peso" required>
                            </div>
                            <div class="col-md-6">
                            <label class="col-md-6 form-control-label h6" for="text-input">Estado</label>
                            <select class="form-control col-md-6" :disabled="desactivarCampos == 1" v-model="estadoid" v-bind:value="estadoid">
                                <option v-for="itemEstado in arrayEstado" :key="itemEstado.id" v-text="itemEstado.descripcion" v-bind:value="itemEstado.id"></option>
                            </select>
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-md-6">
                            <label class="col-md-6 form-control-label h6" for="text-input">Monto a Cancelar</label>
                                <input :disabled="desactivarCampos == 1"  type="text" v-model="montoACancelar" class="form-control" placeholder="Monto a Cancelar" required>
                            </div>
                            <div class="col-md-6">
                            <label class="col-md-6 form-control-label h6" for="text-input">Oficina Donde Se Recibio el Paquete</label>
                            <select class="form-control col-md-6" :disabled="desactivarCampos == 1" v-model="oficinaid" v-bind:value="oficinaid">
                                <option v-for="itemOficina in arrayOficina" :key="itemOficina.id" v-text="itemOficina.nombreOficina" v-bind:value="itemOficina.id"></option>
                            </select>
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-md-6">
                            <label class="col-md-6 form-control-label h6" for="text-input">Descripcion</label>
                                <input :disabled="desactivarCampos == 1"  type="text" v-model="descripcion" class="form-control" placeholder="Descripcion" required>
                            </div>
                            <div class="col-md-6">
                            <label class="col-md-6 form-control-label h6" for="text-input">Identificador</label>
                                <input :disabled="desactivarCampos == 1"  type="text" v-model="identificador" class="form-control" placeholder="Identificador" required>
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
                    <button @click="registrarPaquete()" v-if="tipoAccion == 2" type="button" class="btn btn-primary">Guardar</button>
                    <button @click="actualizarPaquete()" v-if="tipoAccion == 3" type="button" class="btn btn-primary">Actualizar</button>
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
        data(){
          return {
              zona:'',
              zonaid:0,
              remitente:'',
              destinatario:'',
              nombreOficina:'',
              oficinaid:'',
              estadoid:'',
              identificador:'',
              arrayPaquete:[],
              arrayZona:[],
              arrayOficina:[],
              arrayEstado:[],
              direccion:'',
              descripcion:'',
              peso: 0,
              montoACancelar: 0,
              modal: 0, // Indica si muestra u oculta el modal
              tituloModal: '', // Titulo del Modal
              tipoAccion: 0,
              errorPaquete: 0,
              errorMostrarMensajePaquete:[],
              desactivarCampos:0,
              pagination:{
                  'total':0,
                  'current_page':0,
                  'per_page':0,
                  'last_page':0,
                  'from':0,
                  'to':0
              },
              offset: 0,
              criterio: 'remitente',
              buscar: ''
          }
        },
        computed:{
         isActive:function(){
             return this.pagination.current_page;
         },
         pageNumber: function(){
             if(!this.pagination.to){
                 return [];
             }

             var from = this.pagination.current_page - this.offset;
             if(from < 1){
                 from = 1;
             }
             var to = from + (this.offset * 2);
             if(to >= this.pagination.last_page){
                 to = this.pagination.last_page;
             }

             var pagesArray = [];
             while(from <= to){
                 pagesArray.push(from);
                 from++;
             }
             return pagesArray;
         }

        },
        methods:{

        listarPaquete(page,buscar,criterio){
            let me = this;
            var url = '/paquete?page=' + page + '&buscar=' + buscar + '&criterio=' + criterio;
            // Make a request for a user with a given ID
            axios.get(url)
            .then(function (response) {
                var respuesta = response.data;
                me.arrayPaquete= respuesta.paquetes.data;
                me.arrayZona = respuesta.zonas;
                me.arrayEstado = respuesta.estados;
                me.arrayOficina = respuesta.oficinas;
                me.pagination= respuesta.pagination;
            })
            .catch(function (error) {
                // handle error
                console.log(error);
            });
        },

        cambiarPagina(page, buscar, criterio){
        let me = this;
        me.pagination.current_page = page;
        me.listarPaquete(page, buscar, criterio);
        },

        registrarPaquete(){
            if(this.validarPaquete() == 1){
                return;
            }
             let me = this;
             axios.post('/paquete/registrar',{
                 'idzona':me.zonaid,
                 'remitente':me.remitente,
                 'destinatario':me.destinatario,
                 'direccion':me.direccion,
                 'peso':me.peso,
                 'idestado':me.estadoid,
                 'montoACancelar':me.montoACancelar,
                 'descripcion':me.descripcion,
                 'identificador':me.identificador,
                 'idoficina':me.oficinaid
             })
            .then(function (response) {
                me.cerrarModal();
                me.listarPaquete(1,'','remitente');
            })
            .catch(function (error) {
                // handle error
                console.log(error);
            });
        },

        actualizarPaquete(){
            if(this.validarPaquete() == 1){
                return;
            }
             let me = this;
             axios.put('/paquete/actualizar',{
                 'id':this.paquete_id,
                 'idzona':this.zonaid,
                 'remitente':this.remitente,
                 'destinatario':this.destinatario,
                 'direccion':this.direccion,
                 'peso':this.peso,
                 'idestado':this.estadoid,
                 'montoACancelar':this.montoACancelar,
                 'descripcion':this.descripcion,
                 'identificador':this.identificador,
                 'idoficina':this.oficinaid
             })
            .then(function (response) {
                me.cerrarModal();
                me.listarPaquete(1,'','remitente');
            })
            .catch(function (error) {
                // handle error
                console.log(error);
            });
        },

        eliminarPaquete(id){
            const swalWithBootstrapButtons = swal.mixin({
            confirmButtonClass: 'btn btn-success',
            cancelButtonClass: 'btn btn-danger',
            buttonsStyling: false,
            })

            swalWithBootstrapButtons({
            title: 'Deseas eliminar este Paquete?',
            text: "No podras revertir esto!",
            type: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Si, eliminalo!',
            cancelButtonText: 'No, cancelelo!',
            reverseButtons: true
            }).then((result) => {
                let me = this;
            if (result.value) {
                 axios.post('/paquete/eliminar',{
                 'id': id
                })
                .then(function (response) {
                    swalWithBootstrapButtons(
                    'Eliminado!',
                    'El registro ha sido eliminado.',
                    'success'
                    )
                    me.cerrarModal();
                    me.listarPaquete(1,'','remitente');
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
        validarPaquete(){
         this.errorPaquete= 0;
         this.errorMostrarMensajePaquete = [];
         if(!this.zonaid) this.errorMostrarMensajePaquete.push('La zona no puede estar vacia.');
         if(!this.remitente) this.errorMostrarMensajePaquete.push('El remitente del paquete no puede estar vacio.');
         if(!this.destinatario) this.errorMostrarMensajePaquete.push('El destinatario del paquete no puede estar vacia.');
         if(!this.oficinaid) this.errorMostrarMensajePaquete.push('La oficina de origen no puede estar vacia.');
         if(!this.estadoid) this.errorMostrarMensajePaquete.push('El Estado no puede estar vacio.');
         if(!this.peso) this.errorMostrarMensajePaquete.push('El peso no puede estar vacio.');
         if(!this.montoACancelar) this.errorMostrarMensajePaquete.push('El monto a cancelar no puede estar vacio.');
         if(!this.direccion) this.errorMostrarMensajePaquete.push('La direccion no puede estar vacia.');
         if(!this.descripcion) this.errorMostrarMensajePaquete.push('La descripcion no puede estar vacia.');
         if(!this.identificador) this.errorMostrarMensajePaquete.push('El identificador no puede estar vacio.');

         if(this.errorMostrarMensajePaquete.length) this.errorPaquete = 1;
         return this.errorPaquete;
        },

        cerrarModal(){
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
        },

        abrirModal(modelo,accion,data=[]){
            switch(modelo){
                case "paquete": {
                    switch(accion){
                        case "ver": {
                            this.tipoAccion = 1;
                            this.tituloModal = 'Información del Paquete';
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
                            this.tituloModal = 'Registrar Paquete';
                            this.modal = 1;
                            this.desactivarCampos = 0;
                            this.zona = '';
                            this.zonaid = 0;
                            this.remitente = '';
                            this.destinatario = '';
                            this.peso = '';
                            this.estadoid = '';
                            this.descripcion = '';
                            this.oficinaid = '';
                            this.direccion = '';
                            this.montoACancelar = '';
                            this.identificador = '';
                            break;
                        }
                        case "actualizar": {
                            this.tipoAccion = 3;
                            this.tituloModal = 'Actualizar Paquete';
                            this.modal = 1; 
                            this.desactivarCampos = 0;
                            this.paquete_id = data['id'];
                            this.zona = data['zona'];
                            this.zonaid = data['zonaid'];
                            this.remitente = data['remitente'];
                            this.destinatario = data['destinatario'];
                            this.peso = data['peso'];
                            this.montoACancelar = data['montoACancelar'];
                            this.direccion = data['direccion'];
                            this.descripcion = data['descripcion'];
                            this.oficinaid = data['oficinaid'];
                            this.estadoid = data['idestado'];
                            this.oficinaid = data['idoficina'];
                            this.identificador = data['identificador'];
                            break;
                        }
                        case "eliminar": { 
                            break;
                        }
                    }
                    break;
                }
            }
        }

        },
        mounted() {
            this.listarPaquete(1,this.buscar,this.criterio);
        }
    }
</script>
<style>
.modal-header{
    padding: 25px;
}
.modal-content{
    width: 100% !important;
    max-height: 500px !important;
    position: absolute !important;
    overflow-y: scroll;
    padding: 20px;
}
.mostrar{
    display: list-item !important;
    opacity: 1;
    position: absolute !important;
    background-color: #3c29297a !important;
}

.div-error{
    display: flex;
    justify-content: center;
}

.text-error{
    color:red !important;
    font-weight: bold;
}
</style>