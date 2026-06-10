<link rel="stylesheet" href="<?=base_url()?>assets/js/keyTable.dataTables.min.css">
<script src="<?=base_url()?>assets/js/dataTables.keyTable.min.js"></script>
<script>
	var table;
$(document).ready(function() {

	$('#dtRegistros tfoot th').each( function (i) {
        var title = $('#dtRegistros thead th').eq( $(this).index() ).text();
        $(this).html( '<input type="text" placeholder="'+title+'" data-index="'+i+'" class="form-control" />' );
    } );

    table = $('#dtRegistros').DataTable({
		keys: true,
	});

	// Filter event handler
    $( table.table().container() ).on( 'keyup', 'tfoot input', function () {
        table
            .column( $(this).data('index') )
            .search( this.value )
            .draw();
    } );

} );
</script>
