<link rel="stylesheet" href="<?=base_url()?>assets/js/keyTable.dataTables.min.css">
<script src="<?=base_url()?>assets/js/dataTables.keyTable.min.js"></script>
<script>

$('#form-filtrar').submit(function (e) {
    if (e.isDefaultPrevented()) {
    // handle the invalid form...
    } else {
    e.preventDefault();
    filtrar();
    }
});

function valor_inv()
{
    var url;
    url = "<?php echo site_url('dashinv/ajax_valor_inventario')?>";

    // ajax adding data to database
    $.ajax({
        url : url,
        type: "POST",
        data: $('#form').serialize(),
        dataType: "HTML",
        success: function(data)
        {
            $('#res-valinv').html(data);
        },
        error: function (jqXHR, textStatus, errorThrown)
        {
            alert('Error adding / update data');
        }
    });    
}

function clasificacion()
{
    var url;
    url = "<?php echo site_url('dashinv/ajax_clasificacion')?>";

    // ajax adding data to database
    $.ajax({
        url : url,
        type: "POST",
        data: $('#form').serialize(),
        dataType: "HTML",
        success: function(data)
        {
            $('#res-clas').html(data);
			$('#table-clasif').DataTable({
				keys: true,
        		"iDisplayLength": 5,
			});
        },
        error: function (jqXHR, textStatus, errorThrown)
        {
            alert('Error adding / update data');
        }
    });    
}

function grupos()
{
    var url;
    url = "<?php echo site_url('dashinv/ajax_grupos')?>";

    // ajax adding data to database
    $.ajax({
        url : url,
        type: "POST",
        // data: $('#form').serialize(),
        dataType: "HTML",
        success: function(data)
        {
            $('#res-grupos').html(data);
			$('#table-grupos').DataTable({
				keys: true,
        		"iDisplayLength": 5,
			});
        },
        error: function (jqXHR, textStatus, errorThrown)
        {
            alert('Error adding / update data');
        }
    });    
}

function filtrar()
{
    var url;
    url = "<?php echo site_url('dashinv/ajax_filtrar')?>";

    // ajax adding data to database
    $.ajax({
        url : url,
        type: "POST",
        data: $('#form-filtrar').serialize(),
        dataType: "HTML",
        success: function(data)
        {
            $('#res-filtrar').html(data);
			$('#table-filtrar').DataTable({
				keys: true,
        		"iDisplayLength": 5,
			});
        },
        error: function (jqXHR, textStatus, errorThrown)
        {
            alert('Error adding / update data');
        }
    });    
}

</script>
