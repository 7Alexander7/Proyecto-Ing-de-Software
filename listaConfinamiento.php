<br><div class="card">
  <div class="card-header bg-primary" style="color: white;">
    Control de días de confinamiento
  </div>
  <div class="card-body">
    <table class="display responsive nowrap" style="width:100%; cursor: pointer;" id="tblcontrol" border="1">
        <thead>
            <tr class="text-center">
                <th>Paciente</th>
                <th>Fecha de inicio</th> 
                <th>Fecha de fin</th>                            
                <th>Dias restantes</th> 
            </tr>
        </thead>
        <tbody>
        </tbody>
    </table>
  </div>
</div>

<script>

    var tblcontrol

    $(document).ready(function () {
        tblcontrol = $('#tblcontrol').DataTable({
            "ajax": "consultas/contagiados.php?listaControldias=true",            
            "columns": [                
                {"data": "paciente"},
                {"data": "fechaInicio"},
                {"data": "fechaFin"},
                {"data": "dias"}
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
    });   

</script>