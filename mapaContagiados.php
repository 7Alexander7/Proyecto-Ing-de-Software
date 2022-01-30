<br><div class="card">
  <div class="card-header bg-primary" style="color: white;">
    Mapa Contagiados
  </div>
  <div class="card-body">
        <div class="col-md-12">
            <div id="map_canvas" style="width: auto; height: 500px;"></div>
        </div>
  </div>
</div>

<script>

    var marcadores = {}

    function llenarMarcadores(){
        $.ajax({
            url: "./consultas/contagiados.php?ubicacionesObjeto=true",
            data: {},
            type: "POST",
            success: function (data) {
                marcadores = JSON.parse(data)
                initMap()
            }
        });
    }

    function initMap() {
        var map = new google.maps.Map(document.getElementById('map_canvas'), {
            zoom: 14,
            center: { lat: -3.691974, lng: -79.611715 },
            mapTypeId: google.maps.MapTypeId.ROADMAP
        });
        for(x=0; x<marcadores.length; x++){
            var marker = new google.maps.Marker({
                position: {lat: parseFloat(marcadores[x]['latitud']), lng: parseFloat(marcadores[x]['longitud'])},
                map: map,
                icon: './assets/covid.png',
            });
            marker.setMap(map);
        }
    }

    $( document ).ready(function() {
        llenarMarcadores()
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
