<template>
<!-- Contenido Principal -->
<main class="main">
    <div class="container-fluid">
        <!-- Ejemplo de tabla Listado -->
        <div class="card">
            <div class="card-header">
                <i class="fa fa-align-justify"></i> Rastrear Paquetes
            </div>
            <div class="card-body">
                <div class="form-group row">
                    <div class="col-md-12">
                        <div class="input-group">
                            <select class="form-control col-md-3" v-model="criterio">
                              <option value="identificador" selected>Identificador</option>
                            </select>
                            <input @keyup.enter="listarPaquete(1,buscar,criterio)" type="text" v-model="buscar" v-text="buscar" class="form-control" placeholder="Texto a buscar">
                            <button @click="listarPaquete(1,buscar,criterio)" type="submit" class="btn btn-primary"><i class="fa fa-search"></i> Buscar</button>
                        </div>
                    </div>
                </div>
                <table class="table table-bordered table-striped table-sm" v-if="arrayPaquete.length > 0">
                    <thead>
                        <tr>
                            <th>Zona</th>
                            <th>Descripcion</th>
                            <th>Remitente</th>
                            <th>Destinatario</th>
                            <th>Identificador</th>
                            <th>Direccion</th>
                            <th>Peso</th>
                            <th>Estado</th>
                            <th>Monto a Cancelar</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="paquete in arrayPaquete" :key="paquete.id">
                            
                            <td v-text="paquete.zona"></td>
                            <td v-text="paquete.descripcion"></td>
                            <td v-text="paquete.remitente"></td>
                            <td v-text="paquete.destinatario"></td>
                            <td v-text="paquete.identificador"></td>
                            <td v-text="paquete.direccion"></td>
                            <td v-text="paquete.peso"></td>
                            <td v-text="paquete.estado"></td>
                            <td v-text="paquete.montoACancelar"></td>
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
                 <table class="table table-bordered table-striped table-sm" v-if="arrayPaquete.length > 0">
                    <thead>
                        <tr>
                            <th>Encargado</th>
                            <th>Fecha</th>
                            <th>Descripcion</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="historial in arrayHistorial" :key="historial.id">
                            
                            <td v-text="historial.nombre"></td>
                            <td v-text="historial.fecha"></td>
                            <td v-text="historial.descripcion"></td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
        <!-- Fin ejemplo de tabla Listado -->
    </div>
</main>
<!-- /Fin del contenido principal -->
</template>

<script>
import Datepicker from 'vuejs-datepicker';
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
              repartidorid:'',
              paquete_id:'',
              identificador:'',
              arrayPaquete:[],
              arrayZona:[],
              arrayOficina:[],
              arrayEstado:[],
              arrayHistorial:[],
              arrayRepartidores:[],
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
              criterio: 'identificador',
              buscar: '',
              accion:'',
              state: {
                date: new Date()
             },
             fechaHistorial:'',
             descripcionHistorial:''
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

        obtenerHistorial(id){
        
            let me = this;
            var url = '/paquete/historial?id='+id;
            // Make a request for a user with a given ID
            axios.get(url)
            .then(function (response) {
                var respuesta = response.data;
                me.arrayHistorial= respuesta.historial;
            })
            .catch(function (error) {
            });
        },

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
                me.arrayRepartidores = respuesta.repartidores;
                me.pagination= respuesta.pagination;
                me.paquete_id = respuesta.paquetes.data[0].id;
                me.obtenerHistorial(respuesta.paquetes.data[0].id);
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


        },
        mounted() {
            this.listarPaquete(1,'*',this.criterio);
        },
        components: {
            Datepicker
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

.main{
    min-width: 920px !important;
}
</style>