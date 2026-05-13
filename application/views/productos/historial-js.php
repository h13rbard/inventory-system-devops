<link rel="stylesheet" href="<?=base_url()?>assets/js/keyTable.dataTables.min.css">
<script src="<?=base_url()?>assets/js/dataTables.keyTable.min.js"></script>
<script type="text/javascript">
var save_method; //for save method string
var table;
var indexRow = 0;

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
		stateSave: true,
		"language": {
			"url": "<?=base_url()?>assets/js/Spanish.json",
		},
        ajax: {
            "url": "<?=base_url()?>historialproductos/datatable",
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
            $(table.row(0).node().cells[0]).focus().click();
            $('div.dataTables_filter input').focus();
        }
    });
    
    
    table
	.on( 'key', function ( e, datatable, key, cell, originalEvent ) {
			if (key === 13) {
				 //console.log(table.row(cell.index().row).node().cells[4].childNodes[0]);
				$(table.row(cell.index().row).node().cells[6].childNodes[0]).focus();
			} else if (key == 113) {
				$('div.dataTables_filter input', table.table().container()).focus();
			}
	} )
	.on( 'key-focus', function ( e, datatable, cell ) {
			$(table.row(cell.index().row).node()).addClass('bg-light');
			$(table.row(cell.index().row).node().cells[1].childNodes[0]).focus();
			indexRow=cell.index().row;
  } )
  .on( 'key-blur', function ( e, datatable, cell ) {
			$(table.row(cell.index().row).node()).removeClass('bg-light');
	});

	$('#myModal').on('shown.bs.modal', function () {
    	$('div.dataTables_filter input', tabla.table().container()).focus();
	});
    

$('div.dataTables_filter input').focus();

});


function ver(id)
{
    //Ajax Load data from ajax
    $.ajax({
    url : "<?php echo site_url('historialproductos/ver/')?>" + id,
    type: "GET",
    // dataType: "JSON",
    success: function(data)
    {
        $('#modal_form').modal('show'); // show bootstrap modal when complete loaded
        // $('.modal-title').text('Editar'); // Set title to Bootstrap modal title
		$('#resultado').html(data);
    },
    error: function (jqXHR, textStatus, errorThrown)
    {
        alert('Error get data from ajax');
    }
});
}

</script>
