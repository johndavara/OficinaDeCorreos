<template>
<!-- Contenido Principal -->
<main class="main">
    <div class="container-fluid">
        <!-- Ejemplo de tabla Listado -->
        <div class="card">
            <div class="card-header">
                <i class="fa fa-align-justify"></i> Oficinas
                <button type="button" class="btn btn-secondary" @click="abrirModal('oficina','registrar')">
                    <i class="icon-plus"></i>&nbsp;Nuevo
                </button>
            </div>
            <div class="card-body">
                <div class="form-group row">
                    <div class="col-md-6">
                        <div class="input-group">
                            <select class="form-control col-md-3" v-model="criterio">
                              <option value="zona">Zona</option>
                              <option value="supervisor">Supervisor</option>
                              <option value="telefono">Telefono</option>
                              <option value="nombreOficina">Oficina</option>
                            </select>
                            <input @keyup.enter="listarOficina(1,buscar,criterio)" type="text" v-model="buscar" v-text="buscar" class="form-control" placeholder="Texto a buscar">
                            <button @click="listarOficina(1,buscar,criterio)" type="submit" class="btn btn-primary"><i class="fa fa-search"></i> Buscar</button>
                        </div>
                    </div>
                </div>
                <table class="table table-bordered table-striped table-sm">
                    <thead>
                        <tr>
                            <th>Zona</th>
                            <th>Supervisor</th>
                            <th>Telefono</th>
                            <th>Oficina</th>
                            <th>Detalles</th>
                            <th>Editar</th>
                            <th>Eliminar</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="oficina in arrayOficina" :key="oficina.id">
                            
                            <td v-text="oficina.zona"></td>
                            <td v-text="oficina.supervisor"></td>
                            <td v-text="oficina.telefono"></td>
                            <td v-text="oficina.nombreOficina"></td>
                            <td>
                                <button type="button" class="btn btn-info btn-sm" @click="abrirModal('oficina','ver',oficina)">
                                  <i class="icon-list"></i>
                                </button>
                            </td>
                            <td>
                                <button type="button" class="btn btn-warning btn-sm" @click="abrirModal('oficina','actualizar',oficina)">
                                  <i class="icon-pencil"></i>
                                </button> &nbsp;
                            </td>
                            <td>
                                <button @click="eliminarOficina(oficina.id)" type="button" class="btn btn-danger btn-sm">
                                  <i class="icon-trash"></i>
                                </button> &nbsp;
                            </td>
                        </tr>
                    </tbody>
                </table>
                <nav>
                    <ul class="pagination">
                        <li class="page-item" v-if="pagination.current_page > 1">
                            <a class="page-link" href="#" @click.prevent="cambiarPagina(arrayOficina.current_page - 1, buscar, criterio)">Ant</a>
                        </li>
                        <li class="page-item active" v-for="page in pageNumber" :key="page" :class="[page == isActive ? 'active' : '']">
                            <a class="page-link" href="#" @click.prevent="cambiarPagina(page, buscar, criterio)" v-text="page"></a>
                        </li>
                        <li class="page-item" v-if="pagination.current_page < pagination.last_page">
                            <a class="page-link" href="#" @click.prevent="cambiarPagina(arrayOficina.current_page + 1, buscar, criterio)">Sig</a>
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
                            <label class="col-md-6 form-control-label h6" for="text-input">Nombre Supervisor</label>
                                <input :disabled="desactivarCampos == 1"  type="text" v-model="supervisor" class="form-control" placeholder="Nombre del supervisor" required>
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-md-6">
                            <label class="col-md-6 form-control-label h6" for="text-input">Telefono</label>
                                <input :disabled="desactivarCampos == 1"  type="text" v-model="telefono" class="form-control" placeholder="Telefono" required>
                            </div>
                            <div class="col-md-6">
                            <label class="col-md-6 form-control-label h6" for="text-input">Oficina</label>
                                <input :disabled="desactivarCampos == 1"  type="text" v-model="nombreOficina" class="form-control" placeholder="Nombre de la Oficina" required>
                            </div>
                        </div>
                        <div v-show="errorOficina" class="form-group row div-error">
                            <div class="text-center text-error">
                                <div v-for=" error in errorMostrarMensajeOficina" :key="error" v-text="error">
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button @click="cerrarModal()" type="button" class="btn btn-secondary">Cerrar</button>
                    <button @click="registrarOficina()" v-if="tipoAccion == 2" type="button" class="btn btn-primary">Guardar</button>
                    <button @click="actualizarOficina()" v-if="tipoAccion == 3" type="button" class="btn btn-primary">Actualizar</button>
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
              supervisor:'',
              telefono:'',
              nombreOficina:'',
              arrayOficina:[],
              arrayZona:[],
              modal: 0, // Indica si muestra u oculta el modal
              tituloModal: '', // Titulo del Modal
              tipoAccion: 0,
              errorOficina: 0,
              errorMostrarMensajeOficina:[],
              desactivarCampos:0,
              oficina_id: 0,
              pagination:{
                  'total':0,
                  'current_page':0,
                  'per_page':0,
                  'last_page':0,
                  'from':0,
                  'to':0
              },
              offset: 0,
              criterio: 'nombreOficina',
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

        listarOficina(page,buscar,criterio){
            let me = this;
            var url = '/oficina?page=' + page + '&buscar=' + buscar + '&criterio=' + criterio;
            // Make a request for a user with a given ID
            axios.get(url)
            .then(function (response) {
                var respuesta = response.data;
                me.arrayOficina= respuesta.oficinas.data;
                me.arrayZona = respuesta.zonas;
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
        me.listarOficina(page, buscar, criterio);
        },

        registrarOficina(){
            if(this.validarOficina() == 1){
                return;
            }
             let me = this;
             axios.post('/oficina/registrar',{
                 'zona':me.zona,
                 'zonaid':me.zonaid,
                 'supervisor':me.supervisor,
                 'telefono':me.telefono,
                 'nombreOficina':me.nombreOficina,
             })
            .then(function (response) {
                me.cerrarModal();
                me.listarOficina(1,'','nombreOficina');
            })
            .catch(function (error) {
                // handle error
                console.log(error);
            });
        },

        actualizarOficina(){
            if(this.validarOficina() == 1){
                return;
            }
             let me = this;
             axios.put('/oficina/actualizar',{
                 'id':this.oficina_id,
                 'zona':this.zona,
                 'zonaid':this.zonaid,
                 'supervisor':this.supervisor,
                 'telefono':this.telefono,
                 'nombreOficina':this.nombreOficina
             })
            .then(function (response) {
                me.cerrarModal();
                me.listarOficina(1,'','nombreOficina');
            })
            .catch(function (error) {
                // handle error
                console.log(error);
            });
        },

        eliminarOficina(id){
            const swalWithBootstrapButtons = swal.mixin({
            confirmButtonClass: 'btn btn-success',
            cancelButtonClass: 'btn btn-danger',
            buttonsStyling: false,
            })

            swalWithBootstrapButtons({
            title: 'Deseas eliminar esta Oficina?',
            text: "No podras revertir esto!",
            type: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Si, eliminala!',
            cancelButtonText: 'No, cancelelo!',
            reverseButtons: true
            }).then((result) => {
                let me = this;
            if (result.value) {
                 axios.post('/oficina/eliminar',{
                 'id': id
                })
                .then(function (response) {
                    swalWithBootstrapButtons(
                    'Eliminado!',
                    'El registro ha sido eliminado.',
                    'success'
                    )
                    me.cerrarModal();
                    me.listarOficina(1,'','nombreOficina');
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
        validarOficina(){
         this.errorOficina= 0;
         this.errorMostrarMensajeOficina = [];
         if(!this.zonaid) this.errorMostrarMensajeOficina.push('La zona no puede estar vacia.');
         if(!this.supervisor) this.errorMostrarMensajeOficina.push('El nombre del supervisor no puede estar vacio.');
         if(!this.nombreOficina) this.errorMostrarMensajeOficina.push('El nombre de la oficina no puede estar vacia.');
         if(!this.telefono) this.errorMostrarMensajeOficina.push('El telefono no puede estar vacio.');

         if(this.errorMostrarMensajeOficina.length) this.errorOficina = 1;
         return this.errorOficina;
        },

        cerrarModal(){
          this.modal = 0;
          this.tituloModal = '';
          this.zona = '';
          this.zonaid = 0;
          this.supervisor = '';
          this.nombreOficina = '';
          this.telefono = '';
        },

        abrirModal(modelo,accion,data=[]){
            switch(modelo){
                case "oficina": {
                    switch(accion){
                        case "ver": {
                            this.tipoAccion = 1;
                            this.tituloModal = 'Información de la Oficina';
                            this.modal = 1;
                            this.desactivarCampos = 1;
                            this.zona = data['zona'];
                            this.zonaid = data['zonaid'];
                            this.supervisor = data['supervisor'];
                            this.telefono = data['telefono'];
                            this.nombreOficina = data['nombreOficina'];
                            break;
                         }
                        case "registrar": { 
                            this.tipoAccion = 2;
                            this.tituloModal = 'Registrar Oficina';
                            this.modal = 1;
                            this.desactivarCampos = 0;
                            this.zona = '';
                            this.zonaid = 0;
                            this.supervisor = '';
                            this.nombreOficina = '';
                            this.telefono = '';
                            break;
                        }
                        case "actualizar": {
                            this.tipoAccion = 3;
                            this.tituloModal = 'Actualizar Oficina';
                            this.modal = 1; 
                            this.desactivarCampos = 0;
                            this.oficina_id = data['id'];
                            this.zona = data['zona'];
                            this.zonaid = data['zonaid'];
                            this.supervisor = data['supervisor'];
                            this.telefono = data['telefono'];
                            this.nombreOficina = data['nombreOficina'];
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
            this.listarOficina(1,this.buscar,this.criterio);
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