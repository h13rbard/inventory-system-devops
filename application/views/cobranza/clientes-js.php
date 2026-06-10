<link rel="stylesheet" href="<?=base_url()?>assets/js/keyTable.dataTables.min.css">
<script src="<?=base_url()?>assets/js/dataTables.keyTable.min.js"></script>
<script type="text/javascript">
var save_method; //for save method string
var table;
var indexRow = 0;

$(document).ready(function(){

table = $("#dtRegistros").DataTable({
        processing: true,
        serverSide: false,
        keys: true,
        "iDisplayLength": 5,
		// stateSave: true,
		"language": {
			"url": "<?=base_url()?>assets/js/Spanish.json",
		},
        ajax: {
            "url": "<?=base_url()?>cobranza/dt_clientes",
            "type": "POST",
        },
        columns: [ 
            { data: "id" },
            { data: "clave" },
			{ data: "nombre" },
            { data: "acciones", "orderable": false}
        ],
        "columnDefs": [
            { "visible": false, "targets": 0 }
        ],
    });

$('div.dataTables_filter input').focus();

});

</script>
