<br><div class="card">
  <div class="card-header bg-primary" style="color: white;">
    Lista de Usuarios
  </div>
  <div class="card-body">
    <table class="display responsive nowrap" style="width:100%; cursor: pointer;" id="tblusuarios" border="1">
        <thead>
            <tr class="text-center">                    
                <th>Id</th>
                <th>Cédula</th>
                <th>Clave</th>                            
                <th>Privilegio</th> 
            </tr>
        </thead>
        <tbody>
        </tbody>
    </table>
  </div>
</div>

<!-- Modal -->
<div class="modal fade" id="modalUsuarios" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">información del Usuario</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">        
        <div class="input-group mb-3">
            <div class="input-group-prepend">
                <span class="input-group-text" id="basic-addon1">Cédula de Identidad</span>
            </div>
            <input id="cedula" type="number" class="form-control" aria-describedby="basic-addon1">
        </div>
        <div class="input-group mb-3">
            <div class="input-group-prepend">
                <span class="input-group-text" id="basic-addon1">Clave</span>
            </div>
            <input id="clave" type="password" class="form-control" aria-describedby="basic-addon1">
            <div class="input-group-append">
                <button onclick="cambiar()" class="btn btn-outline-secondary" type="button" id="button-addon2">Ver</button>
            </div>
        </div>
        <div class="form-group">
            <label for="exampleFormControlSelect1">Seleccione el nivel de privilegio</label>
            <select class="form-control" id="privilegio">
                <option value="1">Administrador</option>
                <option value="2">Empleado</option>
            </select>
        </div>         
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-danger" onclick="eliminarUsuario()">Eliminar Usuario</button>
        <button type="button" class="btn btn-success" onclick="modificarUsuario()">Guardar Cambios</button>
        <button id="cerrarModal" type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
      </div>
    </div>
  </div>
</div>

<button id="abrirModal" class="btn btn-primary hidden" data-toggle="modal" data-target="#modalUsuarios"></button>

<script>

    var tblusuarios
    var id
    var bandera = 0

    $(document).ready(function () {
        tblusuarios = $('#tblusuarios').DataTable({
            "ajax": "consultas/usuarios.php?listaUsuarios=true",            
            "columns": [                
                {"data": "id", visible: false},
                {"data": "cedula"},
                {"data": "clave"},
                {"data": "privilegio"}
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
        $('#tblusuarios tbody').on('click', 'td', function () {
            var data = tblusuarios.row($(this).parents('tr')).data();
            $('#abrirModal').click();
            id = data['id'];
            document.getElementById('cedula').value = data['cedula'];
            document.getElementById('clave').value = data['clave'];
            if(data['privilegio']=="Administrador"){
                document.getElementById('privilegio').value = 1;
            }else if(data['privilegio']=="Empleado"){
                document.getElementById('privilegio').value = 2;
            }            
        });
    });

    function eliminarUsuario(){
        Swal.fire({
            title: 'Está seguro que desea eliminar el usuario?',
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
                    url: "./consultas/usuarios.php?eliminarUsuario=true",
                    data: { id:id },
                    type: "POST",
                    success: function (data) {                
                        if (data == "exito") {
                            mensajeExito("Gestión de Usuarios","Usuario eliminado correctamente")
                            $('#cerrarModal').click()
                            $('#tblusuarios').DataTable().ajax.reload()
                        } else {
                            mensajeError("Gestión de Usuarios","Ha ocurrido un error en el sistema, porfavor intente más tarde")
                        }
                    }
                });
            } else {
            
            }
        });
    }

    function modificarUsuario(){
        var cedula = document.getElementById('cedula').value
        var clave = document.getElementById('clave').value
        var privilegio = document.getElementById('privilegio').value
        if(validarCedula()){
            $.ajax({
                url: "./consultas/usuarios.php?modificarUsuario=true",
                data: { cedula:cedula,  clave:clave, privilegio:privilegio, id:id },
                type: "POST",
                success: function (data) {                
                    if (data == "exito") {
                        mensajeExito("Gestión de Usuarios","Usuario modificado con éxito")
                        $('#cerrarModal').click()
                        $('#tblusuarios').DataTable().ajax.reload()
                    } else {
                        mensajeError("Gestión de Usuarios","Ha ocurrido un error en el sistema, porfavor intente más tarde")
                    }
                }
            });
        }else{
            mensajeError("El número de cédula es incorrecto","porfavor ingrese una cédula válida")
        }
    }

    function cambiar(){
        if(bandera == 0){
            $("#clave").prop("type", "text");
            bandera++
        }else if(bandera == 1){
            $("#clave").prop("type", "password");
            bandera = 0
        }
    }

</script>