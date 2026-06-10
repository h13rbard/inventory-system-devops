<link rel="stylesheet" href="<?=base_url()?>assets/js/keyTable.dataTables.min.css">
<script src="<?=base_url()?>assets/js/dataTables.keyTable.min.js"></script>
<script type="text/javascript">
var save_method; //for save method string
var table;

$(document).ready(function(){


table = $("#dtRegistros").DataTable({
        processing: true,
        serverSide: true,
        keys: true,
		"iDisplayLength": 5,
		"language": {
			"url": "<?=base_url()?>assets/js/Spanish.json",
		},
        ajax: {
            "url": "<?=base_url()?>cobranza/datatable/<?=$cliente_id?>",
            "type": "POST",
        },
        columns: [ 
            { data: "id" },
            { data: "no_referencia" },
			{ data: "fecha" },
			{ data: "estado" },
			{ data: "cliente" },
			{ data: "importe" },
			{ data: "saldo" },
            { data: "acciones", "orderable": false}
        ],
        "columnDefs": [
            { "visible": false, "targets": 0 }
        ],
		"order": [[ 0, "desc" ]],
        "initComplete": function(settings, json) {
			if (table.data().count())
				$(table.row(0).node().cells[0]).focus().click();
            $('div.dataTables_filter input').focus();
        },
		rowCallback: function( row, data, index ) {
			if ( data.estado == "S" ) {
				$(row).addClass('table-info');
			}    
		}
    });


table
	.on( 'key', function ( e, datatable, key, cell, originalEvent ) {
			if (key === 13) {
				 //console.log(table.row(cell.index().row).node().cells[4].childNodes[0]);
				$(table.row(cell.index().row).node().cells[4].childNodes[0]).focus().click();
			} else if (key == 113) {
				$('div.dataTables_filter input', table.table().container()).focus();
			}
	} )
	.on( 'key-focus', function ( e, datatable, cell ) {
			$(table.row(cell.index().row).node()).addClass('bg-light');
			$(table.row(cell.index().row).node().cells[1].childNodes[0]).focus();
  } )
  .on( 'key-blur', function ( e, datatable, cell ) {
			$(table.row(cell.index().row).node()).removeClass('bg-light');
	});

	$('#myModal').on('shown.bs.modal', function () {
    	$('div.dataTables_filter input', tabla.table().container()).focus();
	});


    $('div.dataTables_filter input').focus();


});

</script>
