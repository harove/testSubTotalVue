<template>
  <div class="row">
    <div class="col-lg-4">
      <div class="card">
        <div class="card-body">
          <div class="btn-group m-b-15" role="group" aria-label="Basic example">
            <button type="button" class="btn btn-success">
              <i class="ion ion-md-add-circle"></i> Agregar Live
            </button>
            <button type="submit" class="btn btn-primary dropdown-toggle">Categorias</button>
          </div>
          <table class="table table-sm m-0">
            <thead>
              <tr>
                <th>Tiempo</th>
                <th>Nombre Video</th>
                <th>Agregar</th>
              </tr>
            </thead>
            <tbody>
              <tr v-for="videos in arrayVideo.videos" :key="videos.id">
                <td v-text="videos.id"></td>
                <td v-text="videos.nombre_video"></td>
                <td v-text="videos.lenght"></td>
                <td>
                  <button
                    @click="agregarDetalleVideo(videos)"
                    class="btn btn-success form-control btnagregar"
                  >
                    <i class="icon-plus">+</i>
                  </button>
                </td>
              </tr>
            </tbody>
          </table>
        </div>
      </div>
    </div>

    <div class="col-lg-8">
      <div class="card">
        <div class="card-body">
          <form class action="#">
            <div class="form-group row">
              <label for="example-text-input" class="col-sm-2 col-form-label">Nombre</label>
              <div class="col-sm-10">
                <input
                  class="form-control"
                  type="text"
                  value
                  v-model="nombre_playlist"
                  placeholder="Nombre Lista de Reproducción"
                  id="example-text-input"
                />
              </div>
            </div>

            <div class="form-group row">
              <label for="example-text-input" class="col-sm-2 col-form-label">Usuario</label>
              <div class="col-sm-10">
                <div class="form-group">
                  <select class="form-control" v-model="id_usuario">
                    <option value="0" disabled>Seleccione</option>
                    <option
                      v-for="usuarios in arrayUsers"
                      :key="usuarios.id"
                      :value="usuarios.id"
                      v-text="usuarios.usuario"
                    ></option>
                  </select>
                </div>
              </div>
            </div>

            <div class="form-group row">
              <label for="example-text-input" class="col-sm-2 col-form-label">Canal</label>
              <div class="col-sm-10">
                <select class="form-control" v-model="id_canal">
                  <option value="0" disabled>Seleccione</option>
                  <option
                    v-for="canales in arrayCanales"
                    :key="canales.id"
                    :value="canales.id"
                    v-text="canales.nombre_canal"
                  ></option>
                </select>
              </div>
            </div>

            <div class="form-group row">
              <label for="example-time-input" class="col-sm-2 col-form-label">Hora Inicio</label>
              <div class="col-sm-10">
                <input class="form-control" type="time" step="1" value="13:45:00" v-model= "hora_inicio" id="example-time-input" />
              </div>
            </div>

            <div class="form-group row">
              <label for="example-date-input" class="col-sm-2 col-form-label">Emisión</label>
              <div class="col-sm-10">
                <input class="form-control" type="date" value="2011-08-19" id="example-date-input" />
              </div>
            </div>

            <div class="form-group row col-sm-12">
              <label for="example-time-input" class="col-form-label">Loop</label>

              <input type="checkbox" id="switch7" switch="info" checked />
              <label class="loop" for="switch7" data-on-label="Si" data-off-label="No"></label>

              <label for="example-time-input" class="col-form-label">AutoStart</label>

              <input type="checkbox" id="switch8" switch="info" checked />
              <label class="loop" for="switch8" data-on-label="Si" data-off-label="No"></label>

              <button type="submit" class="btn btn-primary waves-effect waves-light mr-1">Crear</button>
            </div>
          </form>
        </div>
      </div>

      <div class="card">
        <div class="card-body">
          <div class="table-striped">
            <table class="table table-sm m-10 table-striped">
              <thead>
                <tr>
                  <th>Mover</th>
                  <th>Hora de Inicio</th>
                  <th>testinit</th>
                  <th>testduration</th>
                  <th>testsubtotal</th>
                  <th>Borrar</th>
                </tr>
              </thead>
              <draggable
                v-model="arrayDetallePlaylist"
                v-bind="dragOptions"
                @start="drag = true"
                @end="drag = false"
                tag="tbody"
              >
                <tr v-for="(videoDetalle,index) in itemsWithSubTotal" :key="index">
                  <td scope="row">{{videoDetalle.item1.id_video}}</td>
                  <td>{{ videoDetalle.item1.nombre_video }}</td>
                  <td>{{ parseToHour(videoDetalle.subinit) }}</td>
                  <td>{{ parseToHour(videoDetalle.item1.testduration) }}</td>
                  <td>{{ parseToHour(videoDetalle.subtotal) }}</td>

                  <td>
                    <button
                      type="submit"
                      class="btn btn-primary waves-effect waves-light mx-auto"
                      @click="eliminarDetalleVideo(index)"
                    >X</button>
                  </td>
                </tr>
              </draggable>

              <tfoot>
                <tr>
                  <td></td>
                  <td></td>
                  <td></td>
                  <td></td>
                  <td>
                    <i class="ion ion-md-clock"></i>
                    {{ totalParcial = parseToHour(total()) }}
                  </td>
                </tr>
              </tfoot>
            </table>
          </div>

          <button type="submit" class="btn btn-primary waves-effect waves-light mr-1">Guardar Lista</button>
          <button type="submit" class="btn btn-dark waves-effect waves-light mr-1">
            <i class="ti-control-play"></i> Preview
          </button>
        </div>
      </div>
      <div class="card">
        <div class="card-body">
          <div class="form-group">
            <label>Código Embed Iframe</label>
            <div>
              <textarea required class="form-control" rows="3"><iframe></iframe></textarea>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import draggable from "vuedraggable";
var moment = require('moment');

const message = [
  "vue.draggable",
  "draggable",
  "component",
  "for",
  "vue.js 2.0",
  "based",
  "on",
  "Sortablejs"
];
export default {
  name: "transition-example-2",
  display: "Transitions",
  order: 7,
  data() {
    return {
      playlist_id: 0,
      id_video: 0,
      id_usuario: 0,
      id_canal: 0,
      nombre_video: "",
      lenght: 0,
      testduration: 0,
      testinit: 0,
      usuario_id: 0,
      hora_inicio: 0,
      nombre_playlist: "",
      fecha_emision: 0,
      loop: 0,
      auto_start: 0,
      arrayPlaylist: [],
      arrayDetallePlaylist: [],
      arrayCanales: [],
      arrayUsers: [],
      arrayVideo: [],
      totalParcial: 0,
      list: message.map((name, index) => {
        return { name, order: index + 1 };
      }),
      drag: false,
      itemsx: [],
      subTotalAcum: 0,
      subInitAcum: 0
    };
  },
  components: {
    draggable
  },
  methods: {
    listarVideo() {
      let esto = this;
      var url = "/videos/listarVideos";
      axios
        .get(url)
        .then(function(response) {
          esto.arrayVideo = response.data;
          console.log(response);
        })
        .catch(function(error) {
          console.log(error);
        });
    },
    registrarPlaylist() {
      let esto = this;
      axios
        .post("/playlist/registrar", {
          id_usuario: esto.id_usuario,
          nombre_playlist: esto.nombre_playlist,
          hora_inicio: esto.hora_inicio,
          fecha_emision: esto.fecha_emision,
          loop: esto.loop,
          auto_start: esto.auto_start,
          data: esto.arrayDetallePlaylist
        })
        .then(function(response) {
          console.log(response);
          console.log("ingresado correctamente");
        })
        .catch(function(error) {
          console.log(error);
        });
    },
    agregarDetalleVideo(data = []) {
      this.arrayDetallePlaylist.push({
        id_video: data["id"],
        nombre_video: data["nombre_video"],
        lenght: data["lenght"],
        testinit: 55,
        testduration: Math.floor(Math.random() * 6) + 10,
      });
    },
    eliminarDetalleVideo(index) {
      let esto = this;
      esto.arrayDetallePlaylist.splice(index, 1);
    },
    selectUsuarios() {
      let esto = this;
      var url = "/usuarios/selectUsuarios";
      axios
        .get(url)
        .then(function(response) {
          console.log(response);
          let respuesta = response.data;
          esto.arrayUsers = respuesta.usuarios;
        })
        .catch(function(error) {
          console.log(error);
        });
    },
    selectCanales() {
      let esto = this;
      var url = "/canales/selectCanales";
      axios
        .get(url)
        .then(function(response) {
          console.log(response);
          let respuesta = response.data;
          esto.arrayCanales = respuesta.canales;
        })
        .catch(function(error) {
          console.log(error);
        });
    },
    getCanales(val1) {
      let me = this;
      me.loading = true;
      me.id_canal = val1.id;
    },
    sort() {
      this.list = this.list.sort((a, b) => a.order - b.order);
    },

    computeSubTotal: function(item) {
      //formatPrice is removed here because its not defined in the question

      this.subTotalAcum = this.subTotalAcum + item.testduration;
      return this.subTotalAcum;
    },

    parseToHour(seconds){
             
             return moment().startOf('day').seconds(seconds).format('H:mm:ss');
    },

    total(){
      return this.subTotalAcum
    },


  },

  computed: {
    calcularParcialLengthVideo: function() {
      var resultado = 0;
      for (var i = 0; i < this.arrayDetallePlaylist.length; i++) {
        resultado = resultado + parseInt(this.arrayDetallePlaylist[i].lenght);
      }
      return resultado;
    },

    itemsWithSubTotal() {
      //var itemsx = [];
      
      //  console.log(this.hora_inicio); 
      //  console.log(moment(this.hora_inicio, 'HH:mm:ss: A').diff(moment().startOf('day'), 'seconds'));
      
      this.subTotalAcum = moment(this.hora_inicio, 'HH:mm:ss: A').diff(moment().startOf('day'), 'seconds')

      //this.subTotalAcum = moment(this.hora_inicio, 'HH:mm:ss A').diff(moment().startOf('day'), 'seconds');
      //this.subTotalAcum=this.hora_inicio;
      //console.log(this.arrayDetallePlaylist)
      //itemsx = this.arrayDetallePlaylist.map(item1 => ({item1,subtotal: this.computeSubTotal(item1),subinit: this.computeInit(item1)}))
      //this.arrayDetallePlaylist.testinit = 22;
      //console.log(itemsx)
      return this.arrayDetallePlaylist.map(item1 => ({
        item1,
        subinit: this.subTotalAcum,
        subtotal: this.computeSubTotal(item1)
        
      }));

    },

    dragOptions() {
      return {
        animation: 200,
        group: "description",
        disabled: false,
        ghostClass: "ghost"
      };
    }
  },

  mounted() {
    this.listarVideo();
    this.selectUsuarios();
  }
};
</script>

