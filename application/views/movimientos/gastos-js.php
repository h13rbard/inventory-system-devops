<script type="text/javascript">

$(document).ready(function(){
	loadmovimientos();
});

$('#form').submit(function (e) {
    if (e.isDefaultPrevented()) {
    // handle the invalid form...
    } else {
    e.preventDefault();
    save();
    }
});

function add()
{
    $('#form')[0].reset(); // reset form on modals
    $('#modal_form').modal('show'); // show bootstrap modal
    $('.modal-title').text('Agregar'); // Set Title to Bootstrap modal title
}

function save()
{
    var url;
    url = "<?php echo site_url('movimientos/ajax_add_gasto')?>";

    // ajax adding data to database
    $.ajax({
        url : url,
        type: "POST",
        data: $('#form').serialize(),
        dataType: "JSON",
        success: function(data)
        {
            if (data.status)
            { 
                toastr.success(data.mensaje);
				loadmovimientos();
				$('[name="observacion"]').val('');
				$('[name="total"]').val('');
            }
            else
            {
                toastr.error(data.mensaje);
            }
        },
        error: function (jqXHR, textStatus, errorThrown)
        {
            alert('Error adding / update data');
        }
    });    
}

function loadmovimientos() {
	$.post( "<?php echo site_url('movimientos/gastos_por_dia')?>", { fecha: $('#fecha').val() }, function( data ) {

	$('#fecha-mov').text($('#fecha').val());
	var salida="";
	var total = 0;
	data.registros.forEach(function(element) {
		salida += '<tr><td>'+element.fecha+'</td><td>'+element.nombre+'</td><td>'+element.observacion+'</td><td>'+element.total+'</td><td class="text-right"><button class="btn btn-secondary btn-sm" onclick="eliminar('+element.id+')"><i class="icon-close"></i></button></td></tr>';
		total += parseFloat(element.total);
	});
	txt = document.getElementById("registros");
	txt.innerHTML = salida;

	resultado = document.getElementById("resultado");
	resultado.innerHTML = total;

	}, "json");
}

function eliminar(id) {
	if (!confirm("¿Estas seguro de eliminar el movimiento?") ) return;
	$.post( "<?php echo site_url('movimientos/eliminar')?>", { id: id }, function( data ) {

		toastr.success('Moviminento eliminado correctamente.');
		loadmovimientos();

	}, "json");
}

</script>
