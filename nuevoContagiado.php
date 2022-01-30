<br><div class="card">
  <div class="card-header bg-primary" style="color: white;">
    Nuevo Contagiado
  </div>
  <div class="card-body">
      <form id="infectado" onsubmit="return guardarContagiado()">
        <label for="exampleFormControlSelect1">Información General</label>
        <div class="input-group mb-3">
            <div class="input-group-prepend">
                <span class="input-group-text" id="basic-addon1">Nombres del Contagiado</span>
            </div>
            <input id="primerNombre" type="text" class="form-control" placeholder="Primer Nombre" required>
            <input id="segundoNombre" type="text" class="form-control" placeholder="Segundo Nombre" required>
        </div>
        <div class="input-group mb-3">
            <div class="input-group-prepend">
                <span class="input-group-text" id="basic-addon1">Apellidos del Contagiado</span>
            </div>
            <input id="primerApellido" type="text" class="form-control" placeholder="Apellido Paterno" required>
            <input id="segundoApellido" type="text" class="form-control" placeholder="Apellido Materno" required>
        </div>
        <div class="input-group mb-3">
            <div class="input-group-prepend">
                <span class="input-group-text" id="basic-addon1">Cédula de Identidad</span>
            </div>
            <input id="cedula" type="number" class="form-control" aria-describedby="basic-addon1" required>
        </div>
        <div class="input-group mb-3">
            <div class="input-group-prepend">
                <span class="input-group-text" id="basic-addon1">Fecha de Nacimiento</span>
            </div>
            <input id="fechaNacimiento" type="date" class="form-control" aria-describedby="basic-addon1" required>
        </div>
        <div class="input-group mb-3">
            <div class="input-group-prepend">
                <span class="input-group-text" id="basic-addon1">Ciudad</span>
            </div>
            <input id="ciudad" type="text" class="form-control" aria-describedby="basic-addon1" required>
        </div>
        <div class="input-group mb-3">
            <div class="input-group-prepend">
                <span class="input-group-text" id="basic-addon1">Dirección de domicilio</span>
            </div>
            <input id="direccion" type="text" class="form-control" aria-describedby="basic-addon1" required>
        </div>
        <label for="exampleFormControlSelect1">Información de la enfermedad</label>
        <div class="input-group mb-3">
            <div class="input-group-prepend">
                <span class="input-group-text" id="basic-addon1">Fecha del inicio de la enfermedad</span>
            </div>
            <input id="fechaInicio" type="date" class="form-control" required>
        </div>
        <div class="input-group mb-3">
            <div class="input-group-prepend">
                <span class="input-group-text" id="basic-addon1">Días de reposo</span>
            </div>
            <input id="diasReposo" type="number" class="form-control" required>
        </div>
        <label for="exampleFormControlSelect1">Ubicación del paciente</label>
        <div class="input-group mb-3">
            <div class="input-group-prepend">
                <span class="input-group-text" id="basic-addon1">Latitud</span>
            </div>
            <input id="latitud" type="text" class="form-control" value="-0.233752" readonly required>
            <div class="input-group-prepend">
                <span class="input-group-text" id="basic-addon1">Longitud</span>
            </div>
            <input id="longitud" type="text" class="form-control" value="-78.482805" readonly required>
        </div>
        <div class="col-md-12">
            <div id="map_canvas" style="width: auto; height: 350px;"></div>
        </div>
        <br>
        <center>
            <button type="submit" form="infectado" class="btn btn-success">Guardar Contagiado</button>
            <button id="limpiar" type="reset" form="infectado" class="btn btn-warning">Limpiar</button>
        </center>
      </form>
  </div>
</div>

<script>

    let map;

    function initMap() {
        var myLatLng = {lat: -3.691974, lng: -79.611715};
        map = new google.maps.Map(document.getElementById("map_canvas"), {
            center: { lat: -3.691974, lng: -79.611715 },
            zoom: 15,
        });
        var marker = new google.maps.Marker({
            position: myLatLng,
            map: map,
            title: "Aqui estoy",
            draggable:true,
        });
        google.maps.event.addListener(marker, 'dragend', function(marker){
            var latLng = marker.latLng;
            $("#latitud").val(latLng.lat().toFixed(6));
            $("#longitud").val(latLng.lng().toFixed(6));
            map.panTo(latLng);
        });
        map.setCenter(marker.position);
        marker.setMap(map);
    }

    $( document ).ready(function() {
        initMap()
    })

    function guardarContagiado(){
        var cedula = document.getElementById('cedula').value
        var nombres = document.getElementById('primerNombre').value + " " + document.getElementById('segundoNombre').value
        var apellidos = document.getElementById('primerApellido').value + " " + document.getElementById('segundoApellido').value
        var fechaNacimiento = document.getElementById('fechaNacimiento').value
        var ciudad = document.getElementById('ciudad').value
        var direccion = document.getElementById('direccion').value
        var fechaInicio = document.getElementById('fechaInicio').value
        var dias = document.getElementById('diasReposo').value
        var latitud = document.getElementById('latitud').value
        var longitud = document.getElementById('longitud').value
        if(validarCedula()){
            $.ajax({
                url: "./consultas/contagiados.php?nuevoContagiado=true",
                data: { cedula:cedula,  nombres:nombres, apellidos:apellidos, fechaNacimiento:fechaNacimiento, ciudad:ciudad, direccion:direccion, fechaInicio:fechaInicio, dias: dias, latitud:latitud, longitud:longitud },
                type: "POST",
                success: function (data) {
                    if (data == "exito") {
                        mensajeExito("Gestión de Contagiados","Contagiado registrado con éxito")
                        $('#limpiar').click()
                    } else {
                        mensajeError("Gestión de Contagiados","Ha ocurrido un error en el sistema, porfavor intente más tarde")
                    }
                }
            });
        }else{
            mensajeError("El número de cédula es incorrecto","porfavor ingrese una cédula válida")
        }

        return false
    }
</script>
