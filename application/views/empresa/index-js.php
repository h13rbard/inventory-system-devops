<script type="text/javascript">
var save_method; //for save method string
var table;
var indexRow = 0;

$(document).ready(function(){

});

$('#form').submit(function (e) {
    if (e.isDefaultPrevented()) {
    // handle the invalid form...
    } else {
    e.preventDefault();
    save();
    }
});

function save()
{
    var url = "<?php echo site_url('empresa/ajax_update')?>";

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
