<link rel="stylesheet" href="<?=base_url()?>assets/js/keyTable.dataTables.min.css">
<script src="<?=base_url()?>assets/js/dataTables.keyTable.min.js"></script>
<script type="text/javascript">
var save_method; //for save method string
var table;
var venta_id = <?=$pedido->id?>;
var total = <?=$pedido->total?>;

$(document).ready(function(){

	// $('#dtRegistros tfoot th').each( function () {
    //     var title = $(this).text();
    //     $(this).html( '<input type="text" placeholder="Buscar '+title+'" />' );
    // } );

table = $("#dtRegistros").DataTable({
        processing: true,
        serverSide: false,
		keys: true,
		"iDisplayLength": 5,
		"language": {
			"url": "<?=base_url()?>assets/js/Spanish.json",
		},
        ajax: {
            "url": "<?=base_url()?>devolucion/productos",
            "type": "POST",
        },
        columns: [ 
            { data: "id" },
            { data: "clave_art" },
			{ data: "clave_prov" },
			{ data: "codigo_b" },
			{ data: "descrip" },
			{ data: "precio_venta" },
			{ data: "localizacion" },
            { data: "acciones", "orderable": false}
        ],
        "columnDefs": [
            { "visible": false, "targets": 0 }
        ],
		"initComplete": function(settings, json) {
            // $(table.row(0).node().cells[0]).focus().click();
            // $('div.dataTables_filter input').focus();
        }
    });

	table
	.on( 'key', function ( e, datatable, key, cell, originalEvent ) {
			if (key === 13) {
				// Pendiente al dar enter que se agregue, pero esta duplicando
				// $(table.row(cell.index().row).node().cells[6].childNodes[0]).focus().click();
			} else if (key == 113) {
				$('div.dataTables_filter input', table.table().container()).focus();
			}
	} )
	.on( 'key-focus', function ( e, datatable, cell ) {
			$(table.row(cell.index().row).node()).addClass('bg-light');
			$(table.row(cell.index().row).node().cells[1].childNodes[0]).focus();
			var r = table.rows( cell.index().row ).data();
			// console.log( r[0] );
			$('#exis_id').text( r[0].existencias+'  '+r[0].localizacion );
			$('#pvta_id').text( "$ "+ parseFloat(r[0].precio_venta).toFixed(2) );
  } )
  .on( 'key-blur', function ( e, datatable, cell ) {
			$(table.row(cell.index().row).node()).removeClass('bg-light');
	});

// $('div.dataTables_filter input').focus();

// Apply the search
// table.columns().every( function () {
//         var that = this;
 
//         $( 'input', this.footer() ).on( 'keyup change clear', function () {
//             if ( that.search() !== this.value ) {
//                 that
//                     .search( this.value )
//                     .draw();
//             }
//         } );
//     } );

$('#barcode').focus();

});

$('#form').submit(function (e) {
    if (e.isDefaultPrevented()) {
    // handle the invalid form...
    } else {
    e.preventDefault();
    save();
    }
});

$('#form_confirmar').submit(function (e) {
    if (e.isDefaultPrevented()) {
    // handle the invalid form...
    } else {
    e.preventDefault();
    confirmar();
    }
});

function add()
{
	if (total == 0) {
		toastr.error("La venta debe ser mayor a 0.");
		return;
	}
	
    save_method = 'add';
    if ($('#pago').val() == 'CON') {
		// $('#form')[0].reset(); // reset form on modals
		$('#modal_form').on('shown.bs.modal', function() {
			$('#total_pago').focus();
			$('#total_pago').select();
		});
		$('#modal_form').modal('show'); // show bootstrap modal
		$('.modal-title').text('Venta'); // Set Title to Bootstrap modal title
		$('#total_doc').val(total);
		$('#cambio_doc').val(0);
		$('#total_pago').val(total);
	} else {
		confirmar();
	}
}

$('#total_pago').keyup(function(event){
	var total_pago = parseFloat( $('#total_pago').val());
	$('#cambio_doc').val(total_pago - total);
	console.log(total);
	console.log(total_pago);
});

function confirmar()
{
	// $.ajax({
    // url : "<?php echo site_url('devolucion/checar_exis/')?>" + venta_id,
    // type: "GET",
    // dataType: "JSON",
    // success: function(data)
    // {
    //     if (data.resultado) {
			window.open('<?=base_url()?>devolucion/confirmar/'+venta_id,"_self");
			window.open('<?=base_url()?>devolucion/ticket/'+venta_id,'_blank');
	// 	} else {
	// 		toastr.error(data.salida, "Existencias insuficientes");
	// 	}

    // },
    // error: function (jqXHR, textStatus, errorThrown)
    // {
    //     alert('Error get data from ajax');
    // }
	// });
	
}

function edit(id)
{
    save_method = 'update';
    $('#form')[0].reset(); // reset form on modals

    //Ajax Load data from ajax
    $.ajax({
    url : "<?php echo site_url('productos/ajax_edit/')?>" + id,
    type: "GET",
    dataType: "JSON",
    success: function(data)
    {
        $('[name="id"]').val(data.id);
        $('[name="clave_art"]').val(data.clave_art);
		$('[name="descrip"]').val(data.descrip);
		$('[name="localizacion"]').val(data.localizacion);
		$('[name="codigo_b"]').val(data.codigo_b);
		$('[name="existencias"]').val(data.existencias);
		$('[name="cantidad"]').val(data.cantidad);
		$('[name="precio_venta_aux"]').val(data.precio_venta_aux);
		$('[name="precio_venta"]').val(data.precio_venta);
		$('[name="precio_compra"]').val(data.precio_compra);

        $('#modal_form').modal('show'); // show bootstrap modal when complete loaded
        $('.modal-title').text('Editar'); // Set title to Bootstrap modal title

    },
    error: function (jqXHR, textStatus, errorThrown)
    {
        alert('Error get data from ajax');
    }
});
}

function reload_table()
{
    table.ajax.reload(null,false);
    $('div.dataTables_filter input').focus();
}

function save()
{
    var url;
    if(save_method == 'add')
    {
    url = "<?php echo site_url('productos/ajax_add')?>";
    }
    else
    {
    url = "<?php echo site_url('productos/ajax_update')?>";
    }

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
                //if success close modal and reload ajax table
                $('#modal_form').modal('hide');
                reload_table();
                toastr.success(data.mensaje);
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

function agregar(id)
{
	// alert(id);

	$.ajax({
		url : "<?php echo site_url('devolucion/add_partida/')?>" + venta_id + "/" + id,
		type: "GET",
		dataType: "JSON",
		success: function(data)
		{
			// console.log(data);
			if (!data.status) {
				location.reload();
			}
			if (data.nuevo) {
				var url_= '<?=base_url()?>';
				var row = '<tr>'+
				'<td>'+data.producto.clave_art+'</td>'+
				'<td>'+data.producto.descrip+'</td>'+
				'<td>'+data.producto.precio_venta+'</td>'+
				'<td>'+
				'<input type="number" name="cantidad_'+data.partida_id+'" id="cantidad_'+data.partida_id+'" min="0" lang="en" step="0.01" required class="form-control form-control-sm cantidad" value="1" data-partida="'+data.partida_id+'" data-cantidad="1" data-precio="'+data.producto.precio_venta+'">'+
				'</td>'+
				'<td id="importe_'+data.partida_id+'">'+(data.importe)+'</td>'+
				'<td><a href="'+url_+'devolucion/del_partida/'+venta_id+'/'+data.partida_id+'" class="btn btn-sm btn-danger">Eliminar</a></td>'+
				'</tr>';
				$('#partidas tbody').append(row);
			} else {
				$('#importe_'+data.partida_id).text(""+ data.importe);
				$('#cantidad_'+data.partida_id).val(data.cantidad);
				$('#cantidad_'+data.partida_id).data('cantidad', data.cantidad);
			}
			total = data.total;
			$('#total_venta').text("$ "+ data.total);
			$('div.dataTables_filter input').focus();
		},
		error: function (jqXHR, textStatus, errorThrown)
		{
			alert('Error get data from ajax');
		}
	});

}

$('#partidas').on('focusout', $('.cantidad'),function(event){
	if($.trim(event.target.value) == ''){
		var cant_ant = $('#'+event.target.id).attr('data-cantidad');
		$('#'+event.target.id).val(cant_ant);
		return;
    } 

	var cant_ant = $('#'+event.target.id).attr('data-cantidad');
	var cant =$.trim(event.target.value);
	if (parseFloat(cant) != parseFloat(cant_ant)) {
		alert("Modifico la cantidad debe de dar enter para continuar.");
		// $('#'+event.target.id).focus();
		$('#'+event.target.id).val(cant_ant);
	}
});

$('#partidas').on('keypress', $('.cantidad'), function(event){
    var keycode = (event.keyCode ? event.keyCode : event.which);
    if(keycode == '13'){
		if($.trim(event.target.value) == ''){
			toastr.error("Agregar cantidad");
			var cant_ant = $('#'+event.target.id).attr('data-cantidad');
			$('#'+event.target.id).val(cant_ant);
		}
        else {
			var valor=parseFloat(event.target.value);
			if (valor == 0)
			{
				toastr.error("La cantidad debe ser mayor a cero.");
				var cant_ant = $('#'+event.target.id).attr('data-cantidad');
				$('#'+event.target.id).val(cant_ant);
				return;
			}

		// console.log(event.target);
		// alert($('#'+event.target.id).data('partida'))
			var id_partida = $('#'+event.target.id).data('partida');
			$.ajax({
				url : "<?php echo site_url('devolucion/update_partida')?>",
				type: "POST",
				data: {venta_id: venta_id, partida_id: $('#'+event.target.id).data('partida'), cantidad: valor },
				dataType: "JSON",
				success: function(data)
				{
					if (!data.status) {
						location.reload();
					}
					var precio = $('#'+event.target.id).data('precio');
					// console.log( $('#'+id_partida).data() );
					console.log(valor );
					console.log(precio );
					$('#importe_'+id_partida).text(valor * precio);
					// set nueva cantidad
					$('#'+event.target.id).attr('data-cantidad', valor);
					// console.log(data);
					// if (data.status)
					// {              
					// 	//if success close modal and reload ajax table
					// 	$('#modal_form').modal('hide');
					// 	reload_table();
						toastr.success("Cantidad actualizada");
						total = data.total;
						$('#total_venta').text("$ "+ data.total);
					// }
					// else
					// {
					// 	toastr.error(data.mensaje);
					// }
				},
				error: function (jqXHR, textStatus, errorThrown)
				{
					alert('Error adding / update data');
				}
			});    

		}
    }
});

// CLIENTE
$('#encabezado #cliente').on('keypress', $('#cliente'), function(event){
    var keycode = (event.keyCode ? event.keyCode : event.which);
    if(keycode == '13'){
		$.ajax({
			url : "<?php echo site_url('devolucion/update_cliente')?>",
			type: "POST",
			data: {venta_id: venta_id, cliente: $('#cliente').val() },
			dataType: "JSON",
			success: function(data)
			{
				if (!data.status) {
					location.reload();
				}
				toastr.success("Cliente actualizado.");
			},
			error: function (jqXHR, textStatus, errorThrown)
			{
				alert('Error adding / update data');
			}
		});
    }
});

$('#encabezado #barcode').on('keypress', $('#barcode'), function(event){
    var keycode = (event.keyCode ? event.keyCode : event.which);
    if(keycode == '13'){
		$( "#barcode" ).prop( "disabled", true );
		$.ajax({
		url : "<?php echo site_url('devolucion/add_codigo')?>",
		type: "POST",
		data: {venta_id: venta_id, codigo_b: $('#barcode').val() },
		dataType: "JSON",
		success: function(data)
		{
			console.log(data);
			if (!data.status) {
				toastr.error("El producto no fue encontrado.");
				$( "#barcode" ).prop( "disabled", false );
				$('#barcode').val('');
				$('#barcode').focus();
				return;
			}
			if (data.nuevo) {
				var url_= '<?=base_url()?>';
				var row = '<tr>'+
				'<td>'+data.producto.clave_art+'</td>'+
				'<td>'+data.producto.descrip+'</td>'+
				'<td>'+data.producto.precio_venta+'</td>'+
				'<td>'+
				'<input type="number" name="cantidad_'+data.partida_id+'" id="cantidad_'+data.partida_id+'" min="0" lang="en" step="0.01" required class="form-control form-control-sm cantidad" value="1" data-partida="'+data.partida_id+'" data-cantidad="1" data-precio="'+data.producto.precio_venta+'">'+
				'</td>'+
				'<td id="importe_'+data.partida_id+'">'+(data.importe)+'</td>'+
				'<td><a href="'+url_+'devolucion/del_partida/'+venta_id+'/'+data.partida_id+'" class="btn btn-sm btn-danger">Eliminar</a></td>'+
				'</tr>';
				$('#partidas tbody').append(row);
			} else {
				$('#importe_'+data.partida_id).text(""+ data.importe);
				$('#cantidad_'+data.partida_id).val(data.cantidad);
				$('#cantidad_'+data.partida_id).data('cantidad', data.cantidad);
			}
			total = data.total;
			$('#total_venta').text("$ "+ data.total);
			// $('div.dataTables_filter input').focus();
			$( "#barcode" ).prop( "disabled", false );
			$('#barcode').val('');
			$('#barcode').focus();
		},
		error: function (jqXHR, textStatus, errorThrown)
		{
			alert('Error get data from ajax');
		}
	});
    }
});

// TIPO DE PAGO
$('#encabezado #pago').on('change', $('#pago'), function(event){
	$.ajax({
		url : "<?php echo site_url('devolucion/update_pago')?>",
		type: "POST",
		data: {venta_id: venta_id, pago: $('#pago').val() },
		dataType: "JSON",
		success: function(data)
		{
			if (!data.status) {
				location.reload();
			}
			toastr.success("Tipo de pago actualizado.");
		},
		error: function (jqXHR, textStatus, errorThrown)
		{
			alert('Error adding / update data');
		}
	});
});

</script>
