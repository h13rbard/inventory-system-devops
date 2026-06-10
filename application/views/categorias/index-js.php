<script type="text/javascript">
var save_method; //for save method string
var table;

$(document).ready(function(){
table = $("#dtRegistros").DataTable({
        processing: true,
        serverSide: false,
        ajax: {
            "url": "<?=base_url()?>categorias/datatable",
            "type": "POST",
        },
        columns: [
            { data: "id" },
            { data: "nombre" },
			{ data: "tipo" },
            { data: "acciones", "orderable": false}
        ],
        "columnDefs": [
            { "visible": false, "targets": 0 }
        ]
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

function add()
{
    save_method = 'add';
    $('#form')[0].reset(); // reset form on modals
    $('#modal_form').modal('show'); // show bootstrap modal
    $('.modal-title').text('Agregar'); // Set Title to Bootstrap modal title
}

function edit(id)
{
    save_method = 'update';
    $('#form')[0].reset(); // reset form on modals

    //Ajax Load data from ajax
    $.ajax({
    url : "<?php echo site_url('categorias/ajax_edit/')?>" + id,
    type: "GET",
    dataType: "JSON",
    success: function(data)
    {
        $('[name="id"]').val(data.id);
        $('[name="nombre"]').val(data.nombre);
		$('[name="tipo"]').val(data.tipo);
        $('[name="nombre"]').focus();

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
    url = "<?php echo site_url('categorias/ajax_add')?>";
    }
    else
    {
    url = "<?php echo site_url('categorias/ajax_update')?>";
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

</script>
