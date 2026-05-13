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
            "url": "<?=base_url()?>relacionados/datatable",
            "type": "POST",
        },
        columns: [ 
            { data: "id" },
            { data: "clave_art1" },
			{ data: "descrip1" },
			{ data: "existencias1" },
			{ data: "clave_art2" },
			{ data: "descrip2" },
			{ data: "existencias2" },
            { data: "acciones", "orderable": false}
        ],
        "columnDefs": [
            { "visible": false, "targets": 0 }
        ],
    });

$('div.dataTables_filter input').focus();

});

$('#form').submit(function (e) {
    if (e.isDefaultPrevented()) {
    // handle the invalid form...
    } else {
    e.preventDefault();
    save();
    }
});

$('#form-agregar').submit(function (e) {
    if (e.isDefaultPrevented()) {
    // handle the invalid form...
    } else {
    e.preventDefault();
    add();
    }
});

function add()
{
    var url;
    url = "<?php echo site_url('relacionados/ajax_add')?>";

    // ajax adding data to database
    $.ajax({
        url : url,
        type: "POST",
        data: $('#form-agregar').serialize(),
        dataType: "JSON",
        success: function(data)
        {
            if (data.status)
            {
                $('#modal_form').modal('hide');
                reload_table();
                toastr.success(data.mensaje);
				document.getElementById("form-agregar").reset(); 
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

function edit(id)
{
    save_method = 'update';
    $('#form')[0].reset(); // reset form on modals

    //Ajax Load data from ajax
    $.ajax({
    url : "<?php echo site_url('relacionados/ajax_edit/')?>" + id,
    type: "GET",
    dataType: "JSON",
    success: function(data)
    {
        $('[name="id"]').val(data.id);
		$('[name="prod1"]').val(data.clave1 + " - " +data.prod1);
        $('[name="prod2"]').val(data.clave2 + " - " +data.prod2);
		$('[name="comentario"]').val(data.comentario);

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
    table.ajax.reload(function(settings, json) {
            // $(table.row(indexRow).node().cells[0]).focus().click();
            $('div.dataTables_filter input').focus();
        },false);
}

function save()
{
    var url;
    url = "<?php echo site_url('relacionados/ajax_update')?>";
    
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

function eliminar(id)
{
	if(!confirm("¿Estas seguro de eliminar el registro?")) return;
    var url;
    url = "<?php echo site_url('relacionados/ajax_delete')?>";
    
    // ajax adding data to database
        $.ajax({
        url : url,
        type: "POST",
        data: {id: id},
        dataType: "JSON",
        success: function(data)
        {
            if (data.status)
            {
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

</script>
