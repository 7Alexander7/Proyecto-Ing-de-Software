<br><div class="card">
  <div class="card-header bg-primary" style="color: white;">
    Nuevo Usuario
  </div>
  <div class="card-body">
      <form id="user" onsubmit="return guardarUsuario()">
        <div class="input-group mb-3">
            <div class="input-group-prepend">
                <span class="input-group-text" id="basic-addon1">Cédula de Identidad</span>
            </div>
            <input id="cedula" type="number" class="form-control" aria-describedby="basic-addon1" required>
        </div>
        <div class="input-group mb-3">
            <div class="input-group-prepend">
                <span class="input-group-text" id="basic-addon1">Clave</span>
            </div>
            <input id="clave" type="password" class="form-control" aria-describedby="basic-addon1" required>
            <div class="input-group-append">
                <button onclick="cambiar()" class="btn btn-outline-secondary" type="button" id="button-addon2">Ver</button>
            </div>
        </div>
        <div class="form-group">
            <label for="exampleFormControlSelect1">Seleccione el nivel de privilegio</label>
            <select class="form-control" id="estado">
                <option value="1">Administrador</option>
                <option value="2">Empleado</option>
            </select>
        </div><br>
        <center>
            <button type="submit" form="user" class="btn btn-success">Guardar Usuario</button>
            <button id="limpiar" type="reset" form="user" class="btn btn-warning">Limpiar</button>            
        </center>
      </form>    
  </div>
</div>


<script>

    var bandera=0

    function guardarUsuario(){
        var cedula = document.getElementById('cedula').value
        var clave = document.getElementById('clave').value
        var estado = document.getElementById('estado').value
        if(validarCedula()){
            $.ajax({
                url: "./consultas/usuarios.php?nuevoUsuario=true",
                data: { cedula:cedula,  clave:clave, estado:estado },
                type: "POST",
                success: function (data) {                
                    if (data == "exito") {
                        mensajeExito("Gestión de Usuarios","Usuario registrado con éxito")
                        $('#limpiar').click()
                    } else {
                        mensajeError("Gestión de Usuarios","Ha ocurrido un error en el sistema, porfavor intente más tarde")
                    }
                }
            });
        }else{
            mensajeError("El número de cédula es incorrecto","porfavor ingrese una cédula válida")
        }
        
        return false
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