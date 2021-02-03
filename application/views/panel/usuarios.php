<div class="row clearfix">
    <?php echo $navegacion;?>
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
        <div class="card">
            <div class="header">
                <h2>
                    Usuarios
                </h2><br>
                <a href="<?php echo base_url('principal/'.$this->constantes->TAREA_USUARIO_NUEVO); ?>" type="button" class="btn btn-primary  btn-sm waves-effect"><i class="material-icons">add_circle</i> <span>Agregar</span></a>
            </div>
            <div class="body">
                <div class="table-responsive">
                    <table id="usuarios" class="table table-bordered table-striped table-hover js-basic-example dataTable">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Usuario</th>
                                <th>Rol</th>
                                <th>Estatus</th>
                                <th>Eliminar</th>
                                <th>Detalles</th>
                            </tr>
                        </thead>
                        <tbody>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- js-basic-example dataTable -->
<script type="text/javascript">
    window.onload = function(){
        let dataTable = $('#usuarios').DataTable({
            'processing': true,
            "responsive": true,
            'ajax': {
                    url: './usuarios/data_table',
                    type: 'POST',
                },
                "columns": [
                    {"data": "total"},
                    {"data": "usuario"},
                    {"data": "rol"},
                    {"data": "estatus"},
                    {"data": "eliminar"},
                    {"data": "detalles"}
                ],
            "language": {
                "decimal": "",
                "emptyTable": "No hay información",
                "info": "Mostrando _START_ a _END_ de _TOTAL_ registros",
                "infoEmpty": "Mostrando 0 to 0 of 0 registros",
                "infoFiltered": "(Filtrado de _MAX_ total registros)",
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
                }
            },
        });//End DataTable

        //Estatus
        $(document).on('click', '.estatus', function() {
            let elemento = $(this).attr('id');
            let id = elemento.split('_')[0];
            let estatus = elemento.split('_')[1];
            let array = ['./usuarios/estatus', id, estatus, 'este usuario', 'tendrá acceso al sistema'];
            cambiar_estatus(array, dataTable);
        });//End .estatus

        //Eliminar
        $(document).on('click', '.eliminar', function() {
            eliminar("./usuarios/eliminar", $(this).attr('id'), '¿Estás seguro de eliminar este usuario?', 'Esta acción es permanente', dataTable);
        });//End .eliminar
    };//End window
</script>
