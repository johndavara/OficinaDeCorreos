<template>
<!-- Contenido Principal -->
<main class="main">
    <div class="container-fluid">
        <!-- Ejemplo de tabla Listado -->
        <div class="card">
            <div class="card-header">
                <i class="fa fa-align-justify"></i> Clientes
                <button type="button" class="btn btn-secondary" @click="abrirModal('cliente','registrar')">
                    <i class="icon-plus"></i>&nbsp;Nuevo
                </button>
            </div>
            <div class="card-body">
                <div class="form-group row">
                    <div class="col-md-6">
                        <div class="input-group">
                            <select class="form-control col-md-3" v-model="criterio">
                              <option value="nombre">Nombre</option>
                              <option value="telefono">Telefono</option>
                            </select>
                            <input @keyup.enter="listarCliente(1,buscar,criterio)" type="text" v-model="buscar" v-text="buscar" class="form-control" placeholder="Texto a buscar">
                            <button @click="listarCliente(1,buscar,criterio)" type="submit" class="btn btn-primary"><i class="fa fa-search"></i> Buscar</button>
                        </div>
                    </div>
                </div>
                <table class="table table-bordered table-striped table-sm">
                    <thead>
                        <tr>
                            <th>Zona</th>
                            <th>Nombre</th>
                            <th>Detalles</th>
                            <th>Editar</th>
                            <th>Eliminar</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="cliente in arrayCliente" :key="cliente.id">
                            
                            <td v-text="cliente.zona"></td>
                            <td v-text="cliente.nombre"></td>
                            <td>
                                <button type="button" class="btn btn-info btn-sm" @click="abrirModal('cliente','ver',cliente)">
                                  <i class="icon-list"></i>
                                </button>
                            </td>
                            <td>
                                <button type="button" class="btn btn-warning btn-sm" @click="abrirModal('cliente','actualizar',cliente)">
                                  <i class="icon-pencil"></i>
                                </button> &nbsp;
                            </td>
                            <td>
                                <button @click="eliminarCliente(cliente.id)" type="button" class="btn btn-danger btn-sm">
                                  <i class="icon-trash"></i>
                                </button> &nbsp;
                            </td>
                        </tr>
                    </tbody>
                </table>
                <nav>
                    <ul class="pagination">
                        <li class="page-item" v-if="pagination.current_page > 1">
                            <a class="page-link" href="#" @click.prevent="cambiarPagina(arrayCliente.current_page - 1, buscar, criterio)">Ant</a>
                        </li>
                        <li class="page-item active" v-for="page in pageNumber" :key="page" :class="[page == isActive ? 'active' : '']">
                            <a class="page-link" href="#" @click.prevent="cambiarPagina(page, buscar, criterio)" v-text="page"></a>
                        </li>
                        <li class="page-item" v-if="pagination.current_page < pagination.last_page">
                            <a class="page-link" href="#" @click.prevent="cambiarPagina(arrayCliente.current_page + 1, buscar, criterio)">Sig</a>
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
                                <input :disabled="desactivarCampos == 1"  type="text" v-model="zona" class="form-control" placeholder="Nombre de la zona" required>
                            </div>
                            <div class="col-md-6">
                            <label class="col-md-6 form-control-label h6" for="text-input">Nombre Cliente</label>
                                <input :disabled="desactivarCampos == 1"  type="text" v-model="nombreCliente" class="form-control" placeholder="Nombre del cliente" required>
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-md-6">
                            <label class="col-md-6 form-control-label h6" for="text-input">Calle</label>
                                <input :disabled="desactivarCampos == 1"  type="text" v-model="calle" class="form-control" placeholder="Nombre de la calle" required>
                            </div>
                            <div class="col-md-6">
                            <label class="col-md-6 form-control-label h6" for="text-input">Telefono Cliente</label>
                                <input :disabled="desactivarCampos == 1"  type="text" v-model="telefonoCliente" class="form-control" placeholder="Telefono del Cliente" required>
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-md-6">
                            <label class="col-md-6 form-control-label h6" for="text-input">Avenida</label>
                                <input :disabled="desactivarCampos == 1"  type="text" v-model="avenida" class="form-control" placeholder="Nombre de la avenida">
                            </div>
                            <div class="col-md-6">
                            <label class="col-md-6 form-control-label h6" for="text-input">Observacion</label>
                             <textarea :disabled="desactivarCampos == 1"  class="form-control" v-model="observacion"  rows="3"></textarea>
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-md-6">
                            <label class="col-md-6 form-control-label h6" for="text-input">Pisos</label>
                                <input :disabled="desactivarCampos == 1"  type="text" v-model="pisos" class="form-control" placeholder="Cantidad de pisos del edificio" required>
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-md-6">
                            <label class="col-md-6 form-control-label h6" for="text-input">Latitud</label>
                                <input :disabled="desactivarCampos == 1"  type="text" v-model="latitud" class="form-control" placeholder="Latitud">
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-md-6">
                            <label class="col-md-6 form-control-label h6" for="text-input">Longitud</label>
                                <input :disabled="desactivarCampos == 1"  type="text" v-model="longitud" class="form-control" placeholder="Longitud">
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-md-6">
                            <label class="col-md-6 form-control-label h6" for="text-input">Razon Social</label>
                                <input :disabled="desactivarCampos == 1"  type="text" v-model="razonSocial" class="form-control" placeholder="Razon Social" required>
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-md-6">
                            <label class="col-md-6 form-control-label h6" for="text-input">Cantidad</label>
                                <input :disabled="desactivarCampos == 1"  type="text" v-model="cantidad" class="form-control" placeholder="Cantidad">
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-md-6">
                            <label class="col-md-6 form-control-label h6" for="text-input">Distancia</label>
                                <input :disabled="desactivarCampos == 1" type="text" v-model="distancia" class="form-control" placeholder="Distancia" required>
                            </div>
                        </div>
                        <div v-show="errorCliente" class="form-group row div-error">
                            <div class="text-center text-error">
                                <div v-for=" error in errorMostrarMensajeCliente" :key="error" v-text="error">
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button @click="cerrarModal()" type="button" class="btn btn-secondary">Cerrar</button>
                    <button @click="registrarCliente()" v-if="tipoAccion == 2" type="button" class="btn btn-primary">Guardar</button>
                    <button @click="actualizarCliente()" v-if="tipoAccion == 3" type="button" class="btn btn-primary">Actualizar</button>
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
              calle:'',
              avenida:'',
              pisos:'',
              distancia:'',
              cantidad:'',
              latitud:'',
              longitud:'',
              razonSocial:'',
              nombreCliente:'',
              telefonoCliente:'',
              observacion:'',
              arrayCliente:[],
              modal: 0, // Indica si muestra u oculta el modal
              tituloModal: '', // Titulo del Modal
              tipoAccion: 0,
              errorCliente: 0,
              errorMostrarMensajeCliente:[],
              desactivarCampos:0,
              cliente_id: 0,
              pagination:{
                  'total':0,
                  'current_page':0,
                  'per_page':0,
                  'last_page':0,
                  'from':0,
                  'to':0
              },
              offset: 0,
              criterio: 'nombre',
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

        listarCliente(page,buscar,criterio){
            let me = this;
            var url = '/cliente?page=' + page + '&buscar=' + buscar + '&criterio=' + criterio;
            // Make a request for a user with a given ID
            axios.get(url)
            .then(function (response) {
                var respuesta = response.data;
                me.arrayCliente = respuesta.clientes.data;
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
        me.listarCliente(page, buscar, criterio);
        },

        registrarCliente(){
            if(this.validarCliente() == 1){
                return;
            }
             let me = this;
             axios.post('/cliente/registrar',{
                 'zona':me.zona,
                 'calle':me.calle,
                 'avenida':me.avenida,
                 'pisos':me.pisos,
                 'cantidad':me.cantidad,
                 'distancia':me.distancia,
                 'latitud':me.latitud,
                 'longitud':me.longitud,
                 'razonSocial':me.razonSocial,
                 'nombre':me.nombreCliente,
                 'telefono':me.telefonoCliente,
                 'observacion':me.observacion
             })
            .then(function (response) {
                me.cerrarModal();
                me.listarCliente(1,'','nombre');
            })
            .catch(function (error) {
                // handle error
                console.log(error);
            });
        },

        actualizarCliente(){
            if(this.validarCliente() == 1){
                return;
            }
             let me = this;
             axios.put('/cliente/actualizar',{
                 'id':this.cliente_id,
                 'zona':this.zona,
                 'calle':this.calle,
                 'avenida':this.avenida,
                 'pisos':this.pisos,
                 'cantidad':this.cantidad,
                 'distancia':this.distancia,
                 'latitud':this.latitud,
                 'longitud':this.longitud,
                 'razonSocial':this.razonSocial,
                 'nombre':this.nombreCliente,
                 'telefono':this.telefonoCliente,
                 'observacion':this.observacion
             })
            .then(function (response) {
                me.cerrarModal();
                me.listarCliente(1,'','nombre');
            })
            .catch(function (error) {
                // handle error
                console.log(error);
            });
        },

        eliminarCliente(id){
            const swalWithBootstrapButtons = swal.mixin({
            confirmButtonClass: 'btn btn-success',
            cancelButtonClass: 'btn btn-danger',
            buttonsStyling: false,
            })

            swalWithBootstrapButtons({
            title: 'Deseas eliminar este cliente?',
            text: "No podras revertir esto!",
            type: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Si, eliminalo!',
            cancelButtonText: 'No, cancelelo!',
            reverseButtons: true
            }).then((result) => {
                let me = this;
            if (result.value) {
                 axios.post('/cliente/eliminar',{
                 'id': id
                })
                .then(function (response) {
                    swalWithBootstrapButtons(
                    'Eliminado!',
                    'El registro ha sido eliminado.',
                    'success'
                    )
                    me.cerrarModal();
                    me.listarCliente(1,'','nombre');
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
        validarCliente(){
         this.errorCliente = 0;
         this.errorMostrarMensajeCliente = [];
         if(!this.zona) this.errorMostrarMensajeCliente.push('La zona no puede estar vacia.');
         if(!this.calle) this.errorMostrarMensajeCliente.push('El nombre de la calle no puede estar vacia.');
         if(!this.distancia) this.errorMostrarMensajeCliente.push('La distancia no puede estar vacia.');
         if(!this.razonSocial) this.errorMostrarMensajeCliente.push('La razon social no puede estar vacia.');
         if(!this.nombreCliente) this.errorMostrarMensajeCliente.push('La nombre del cliente no puede estar vacio.');
         if(!this.telefonoCliente) this.errorMostrarMensajeCliente.push('La telefono del cliente no puede estar vacio.');
         if(!this.pisos) this.errorMostrarMensajeCliente.push('La cantidad de pisos del cliente no puede estar vacia.');

         if(this.errorMostrarMensajeCliente.length) this.errorCliente = 1;
         return this.errorCliente;
        },

        cerrarModal(){
          this.modal = 0;
          this.tituloModal = '';
          this.zona = '';
          this.calle = '';
          this.avenida = '';
          this.pisos = '';
          this.distancia = '';
          this.cantidad = '';
          this.latitud = '';
          this.longitud = '';
          this.razonSocial = '';
          this.nombreCliente = '';
          this.telefonoCliente = '';
          this.observacion = '';
        },

        abrirModal(modelo,accion,data=[]){
            switch(modelo){
                case "cliente": {
                    switch(accion){
                        case "ver": {
                            this.tipoAccion = 1;
                            this.tituloModal = 'Información del Cliente';
                            this.modal = 1;
                            this.desactivarCampos = 1;
                            this.zona = data['zona'];
                            this.calle = data['calle'];
                            this.avenida = data['avenida'];
                            this.pisos = data['pisos'];
                            this.distancia = data['distancia'];
                            this.cantidad = data['cantidad'];
                            this.latitud = data['latitud'];
                            this.longitud = data['longitud'];
                            this.razonSocial = data['razonSocial'];
                            this.nombreCliente = data['nombre'];
                            this.telefonoCliente = data['telefono'];
                            this.observacion = data['observacion'];
                            break;
                         }
                        case "registrar": { 
                            this.tipoAccion = 2;
                            this.tituloModal = 'Registrar Cliente';
                            this.modal = 1;
                            this.desactivarCampos = 0;
                            this.zona = '';
                            this.calle = '';
                            this.avenida = '';
                            this.pisos = '';
                            this.distancia = '';
                            this.cantidad = '';
                            this.latitud = '';
                            this.longitud = '';
                            this.razonSocial = '';
                            this.nombreCliente = '';
                            this.telefonoCliente = '';
                            this.observacion = '';
                            break;
                        }
                        case "actualizar": {
                            this.tipoAccion = 3;
                            this.tituloModal = 'Actualizar Cliente';
                            this.modal = 1; 
                            this.desactivarCampos = 0;
                            this.cliente_id = data['id'];
                            this.zona = data['zona'];
                            this.calle = data['calle'];
                            this.avenida = data['avenida'];
                            this.pisos = data['pisos'];
                            this.distancia = data['distancia'];
                            this.cantidad = data['cantidad'];
                            this.latitud = data['latitud'];
                            this.longitud = data['longitud'];
                            this.razonSocial = data['razonSocial'];
                            this.nombreCliente = data['nombre'];
                            this.telefonoCliente = data['telefono'];
                            this.observacion = data['observacion'];
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
            this.listarCliente(1,this.buscar,this.criterio);
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