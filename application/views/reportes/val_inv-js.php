<link rel="stylesheet" href="<?=base_url()?>assets/js/keyTable.dataTables.min.css">
<script src="<?=base_url()?>assets/js/dataTables.keyTable.min.js"></script>
<script>
$(document).ready(function() {
    $('#dtRegistros').DataTable({
		keys: true,
	});
} );
</script>
