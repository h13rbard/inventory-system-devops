<script>
valor_inv();
saldo_caja();
doc_cob();
$('#form').submit(function (e) {
    if (e.isDefaultPrevented()) {
    // handle the invalid form...
    } else {
    e.preventDefault();
    compras();
	cobranza();
	ventas();
	flujo();
    }
});

function valor_inv()
{
    var url;
    url = "<?php echo site_url('dashboard/ajax_valor_inventario')?>";

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

function doc_cob()
{
    var url;
    url = "<?php echo site_url('dashboard/ajax_doc_pendientes')?>";

    // ajax adding data to database
    $.ajax({
        url : url,
        type: "POST",
        data: $('#form').serialize(),
        dataType: "HTML",
        success: function(data)
        {
            $('#res-doccob').html(data);
        },
        error: function (jqXHR, textStatus, errorThrown)
        {
            alert('Error adding / update data');
        }
    });    
}

function saldo_caja()
{
    var url;
    url = "<?php echo site_url('dashboard/ajax_saldo_caja')?>";

    // ajax adding data to database
    $.ajax({
        url : url,
        type: "POST",
        data: $('#form').serialize(),
        dataType: "HTML",
        success: function(data)
        {
            $('#res-caja').html(data);
        },
        error: function (jqXHR, textStatus, errorThrown)
        {
            alert('Error adding / update data');
        }
    });    
}


function compras()
{
    var url;
    url = "<?php echo site_url('dashboard/ajax_compras')?>";

    // ajax adding data to database
    $.ajax({
        url : url,
        type: "POST",
        data: $('#form').serialize(),
        dataType: "HTML",
        success: function(data)
        {
            $('#res-compras').html(data);
        },
        error: function (jqXHR, textStatus, errorThrown)
        {
            alert('Error adding / update data');
        }
    });    
}

function cobranza()
{
    var url;
    url = "<?php echo site_url('dashboard/ajax_cobranza')?>";

    // ajax adding data to database
    $.ajax({
        url : url,
        type: "POST",
        data: $('#form').serialize(),
        dataType: "HTML",
        success: function(data)
        {
            $('#res-cobranza').html(data);
        },
        error: function (jqXHR, textStatus, errorThrown)
        {
            alert('Error adding / update data');
        }
    });    
}

function ventas()
{
    var url;
    url = "<?php echo site_url('dashboard/ajax_ventas')?>";

    // ajax adding data to database
    $.ajax({
        url : url,
        type: "POST",
        data: $('#form').serialize(),
        dataType: "HTML",
        success: function(data)
        {
            $('#res-ventas').html(data);
        },
        error: function (jqXHR, textStatus, errorThrown)
        {
            alert('Error adding / update data');
        }
    });    
}

function flujo()
{
    var url;
    url = "<?php echo site_url('dashboard/ajax_flujo')?>";

    // ajax adding data to database
    $.ajax({
        url : url,
        type: "POST",
        data: $('#form').serialize(),
        dataType: "HTML",
        success: function(data)
        {
            $('#res-flujo').html(data);
        },
        error: function (jqXHR, textStatus, errorThrown)
        {
            alert('Error adding / update data');
        }
    });    
}

</script>
