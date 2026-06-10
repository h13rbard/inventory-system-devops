<link rel="stylesheet" href="<?=base_url()?>assets/js/keyTable.dataTables.min.css">
<script src="<?=base_url()?>assets/js/dataTables.keyTable.min.js"></script>
<script src="<?=base_url()?>assets/vendor/chart.js/Chart.min.js"></script>
<script>
var table1;
var table2;
var table3;
$(document).ready(function(){

table1 = $("#dtRegistrosClasif").DataTable({
        keys: true,
        "iDisplayLength": 10,
		"language": {
			"url": "http://localhost/alternativa/assets/js/Spanish.json",
		},
    });

	table2 = $("#dtRegistrosGrupos").DataTable({
        keys: true,
        "iDisplayLength": 10,
		"language": {
			"url": "http://localhost/alternativa/assets/js/Spanish.json",
		},
        "columnDefs": [
            { "visible": false, "targets": 0 }
        ],
    });

	table3 = $("#dtRegistrosProveedores").DataTable({
        keys: true,
        "iDisplayLength": 10,
		"language": {
			"url": "http://localhost/alternativa/assets/js/Spanish.json",
		},
    });

});

var ctx1 = document.getElementById("grupo-productos").getContext('2d');
var ctx2 = document.getElementById("grupo-importe").getContext('2d');
var ctx3 = document.getElementById("clasif-productos").getContext('2d');
var ctx4 = document.getElementById("clasif-importe").getContext('2d');
var ctx5 = document.getElementById("proveedores-productos").getContext('2d');
var ctx6 = document.getElementById("proveedores-importe").getContext('2d');

<?php $colores1 = '';
foreach($data as $item):
	if($item->baja==0) { $colores1 .= "'rgba(".rand(0, 255).", ".rand(0, 255).", ".rand(200, 255).",1)',"; }
endforeach;?>
var myChart1 = new Chart(ctx1, {
    type: 'pie',
    data: {
        labels: [<?php foreach($data as $item):?> <?php if($item->baja==0) { echo "'$item->nombre',"; }?> <?php endforeach;?>],
        datasets: [{
            label: '# of Votes',
            data: [<?php foreach($data as $item):?> <?php if($item->baja==0) { echo round($item->productos).","; }?> <?php endforeach;?>],
            backgroundColor: [
				<?=$colores1?>
            ],
            borderWidth: 1
        }]
    },
    options: {
		legend: {
			display: false
		}
    },
	responsive: true
});

var myChart2 = new Chart(ctx2, {
    type: 'pie',
    data: {
        labels: [<?php foreach($data as $item):?> <?php if($item->baja==0) { echo "'$item->nombre',"; }?> <?php endforeach;?>],
        datasets: [{
            label: '# of Votes',
            data: [<?php foreach($data as $item):?> <?php if($item->baja==0) { echo round($item->importe).","; }?> <?php endforeach;?>],
            backgroundColor: [
				<?=$colores1?>
            ],
            borderWidth: 1
        }]
    },
    options: {
		legend: {
			display: false
		}
    },
	responsive: true
});

<?php $colores2 = '';
foreach($data_clasif as $item):
	if($item->baja==0) { $colores2 .= "'rgba(".rand(0, 255).", ".rand(200, 255).", ".rand(0, 255).",1)',"; }
endforeach;?>
var myChart3 = new Chart(ctx3, {
    type: 'pie',
    data: {
        labels: [<?php foreach($data_clasif as $item):?> <?php if($item->baja==0) { echo "'$item->clasif',"; }?> <?php endforeach;?>],
        datasets: [{
            label: '# of Votes',
            data: [<?php foreach($data_clasif as $item):?> <?php if($item->baja==0) { echo round($item->productos).","; }?> <?php endforeach;?>],
            backgroundColor: [
				<?=$colores2?>
            ],
            borderWidth: 1
        }]
    },
    options: {
		legend: {
			display: false
		}
    },
	responsive: true
});

var myChart4 = new Chart(ctx4, {
    type: 'pie',
    data: {
        labels: [<?php foreach($data_clasif as $item):?> <?php if($item->baja==0) { echo "'$item->clasif',"; }?> <?php endforeach;?>],
        datasets: [{
            label: '# of Votes',
            data: [<?php foreach($data_clasif as $item):?> <?php if($item->baja==0) { echo round($item->importe).","; }?> <?php endforeach;?>],
            backgroundColor: [
				<?=$colores2?>
            ],
            borderWidth: 1
        }]
    },
    options: {
		legend: {
			display: false
		}
    },
	responsive: true
});

<?php $colores3 = '';
foreach($data_proveedores as $item):
	if($item->baja==0) { $colores3 .= "'rgba(".rand(200, 255).", ".rand(0, 255).", ".rand(0, 255).",1)',"; }
endforeach;?>
var myChart5 = new Chart(ctx5, {
    type: 'pie',
    data: {
        labels: [<?php foreach($data_proveedores as $item):?> <?php if($item->baja==0) { echo "'$item->nombre',"; }?> <?php endforeach;?>],
        datasets: [{
            label: '# of Votes',
            data: [<?php foreach($data_proveedores as $item):?> <?php if($item->baja==0) { echo round($item->productos).","; }?> <?php endforeach;?>],
            backgroundColor: [
				<?=$colores3?>
            ],
            borderWidth: 1
        }]
    },
    options: {
		legend: {
			display: false
		}
    },
	responsive: true
});

var myChart6 = new Chart(ctx6, {
    type: 'pie',
    data: {
        labels: [<?php foreach($data_proveedores as $item):?> <?php if($item->baja==0) { echo "'$item->nombre',"; }?> <?php endforeach;?>],
        datasets: [{
            label: '# of Votes',
            data: [<?php foreach($data_proveedores as $item):?> <?php if($item->baja==0) { echo round($item->importe).","; }?> <?php endforeach;?>],
            backgroundColor: [
				<?=$colores3?>
            ],
            borderWidth: 1
        }]
    },
    options: {
		legend: {
			display: false
		}
    },
	responsive: true
});
</script>
