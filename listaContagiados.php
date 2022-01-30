<br><div class="card">
  <div class="card-header bg-primary" style="color: white;">
    Lista de Contagiados
  </div>
  <div class="card-body">
    <table class="display responsive nowrap" style="width:100%; cursor: pointer;" id="tblcontagiados" border="1">
        <thead>
            <tr class="text-center">                    
                <th>Id</th>
                <th>Nombres</th>
                <th>Apellidos</th>
                <th>Cédula</th>
                <th>Edad</th>
                <th>FechaNacimiento</th>
                <th>Ciudad</th>
                <th>Dirección</th>
                <th>Inicio de Enfermedad</th>                            
                <th>Días de reposo</th> 
                <th>Latitud</th>                            
                <th>Longitud</th> 
            </tr>
        </thead>
        <tbody>
        </tbody>
    </table>
  </div>
</div>

<!-- Modal -->
<div class="modal fade" id="modalUsuarios" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Información del Contagiado</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">        
        <div class="input-group mb-3">
            <div class="input-group-prepend">
                <span class="input-group-text" id="basic-addon1">Nombres del Contagiado</span>
            </div>
            <input id="nombres" type="text" class="form-control" placeholder="Primer Nombre" required>
        </div>
        <div class="input-group mb-3">
            <div class="input-group-prepend">
                <span class="input-group-text" id="basic-addon1">Apellidos del Contagiado</span>
            </div>
            <input id="apellidos" type="text" class="form-control" placeholder="Apellido Paterno" required>
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
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-danger" onclick="eliminarContagiado()">Eliminar Contagiado</button>
        <button type="button" class="btn btn-success" onclick="modificarContagiado()">Guardar Cambios</button>
        <button id="cerrarModal" type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
      </div>
    </div>
  </div>
</div>

<button id="abrirModal" class="btn btn-primary hidden" data-toggle="modal" data-target="#modalUsuarios"></button>

<script>

    var tblcontagiados
    var id
    let map

    function initMap(latitud,longitud) {
        var myLatLng = {lat: latitud, lng: longitud};
        map = new google.maps.Map(document.getElementById("map_canvas"), {
            center: { lat: latitud, lng: longitud },
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

    $(document).ready(function () {
        tblcontagiados = $('#tblcontagiados').DataTable({
            "ajax": "consultas/contagiados.php?listaContagiados=true",            
            "columns": [                
                {"data": "id", visible: false},
                {"data": "nombres"},
                {"data": "apellidos"},
                {"data": "cedula"},
                {"data": "edad"},
                {"data": "fechaNacimiento", visible: false},
                {"data": "ciudad"},
                {"data": "direccion"},
                {"data": "fechaInicio"},
                {"data": "dias"},
                {"data": "latitud", visible: false},
                {"data": "longitud", visible: false}
            ],
            "language": {
                "emptyTable": "No hay información",
                "info": "Mostrando _START_ a _END_ de _TOTAL_ Entradas",
                "infoEmpty": "Mostrando 0 to 0 of 0 Entradas",
                "infoFiltered": "(Filtrado de _MAX_ total entradas)",
                "infoPostFix": "",
                "thousands": ",",
                "lengthMenu": "Mostrar _MENU_ Entradas",
                "loadingRecords": "Cargando...",
                "processing": "Procesando...",
                "search": "Buscar:",
                "zeroRecords": "Sin resultados encontrados",
                "paginate": {
                    "first": "Primero",
                    "last": "Ultimo",
                    "next": "Siguiente",
                    "previous": "Anterior"
                },
            }
        });
        $('#tblcontagiados tbody').on('click', 'td', function () {
            var data = tblcontagiados.row($(this).parents('tr')).data();
            $('#abrirModal').click();
            id = data['id']
            initMap(Number(data['latitud']),Number(data['longitud']))
            document.getElementById('cedula').value = data['cedula']
            document.getElementById('nombres').value = data['nombres']
            document.getElementById('apellidos').value = data['apellidos']
            document.getElementById('fechaNacimiento').value = data['fechaNacimiento']
            document.getElementById('ciudad').value = data['ciudad']
            document.getElementById('direccion').value = data['direccion']
            document.getElementById('fechaInicio').value = data['fechaInicio']
            document.getElementById('diasReposo').value = data['dias']
            document.getElementById('latitud').value = data['latitud']
            document.getElementById('longitud').value = data['longitud']           
        });
    });

    function eliminarContagiado(){
        Swal.fire({
            title: 'Está seguro que desea eliminar el contagiado?',
            text: "",
            type: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Si',
            cancelButtonText: 'No'
        }).then((result) => {
            if (result.value) {
                $.ajax({
                    url: "./consultas/contagiados.php?eliminarContagiado=true",
                    data: { id:id },
                    type: "POST",
                    success: function (data) {                
                        if (data == "exito") {
                            mensajeExito("Gestión de Contagiados","Contagiado eliminado correctamente")
                            $('#cerrarModal').click()
                            $('#tblcontagiados').DataTable().ajax.reload()
                        } else {
                            mensajeError("Gestión de Contagiados","Ha ocurrido un error en el sistema, porfavor intente más tarde")
                        }
                    }
                });
            } else {
            
            }
        });
    }

    function modificarContagiado(){
        var cedula = document.getElementById('cedula').value
        var nombres = document.getElementById('nombres').value
        var apellidos = document.getElementById('apellidos').value
        var fechaNacimiento = document.getElementById('fechaNacimiento').value
        var ciudad = document.getElementById('ciudad').value
        var direccion = document.getElementById('direccion').value
        var fechaInicio = document.getElementById('fechaInicio').value
        var dias = document.getElementById('diasReposo').value
        var latitud = document.getElementById('latitud').value
        var longitud = document.getElementById('longitud').value
        if(validarCedula()){
            $.ajax({
                url: "./consultas/contagiados.php?modificarContagiado=true",
                data: { cedula:cedula,  nombres:nombres, apellidos:apellidos, fechaNacimiento:fechaNacimiento, ciudad:ciudad, direccion:direccion, fechaInicio:fechaInicio, dias: dias, latitud:latitud, longitud:longitud, id:id },
                type: "POST",
                success: function (data) {                
                    if (data == "exito") {
                        mensajeExito("Gestión de Contagiados","Contagiado modificado con éxito")
                        $('#cerrarModal').click()
                        $('#tblcontagiados').DataTable().ajax.reload()
                    } else {
                        mensajeError("Gestión de Contagiados","Ha ocurrido un error en el sistema, porfavor intente más tarde")
                    }
                }
            });
        }else{
            mensajeError("El número de cédula es incorrecto","porfavor ingrese una cédula válida")
        }
    }
</script>