<script>
Highcharts.chart('chr-ventas', {

	chart: {
		type: 'line'
	},
	title: {
		text: 'Ventas 2018',
	},
	xAxis: {
		categories: ['Ene', 'Feb', 'Mar', 'Abr', 'May', 'Jun','Jul', 'Ago', 'Sep', 'Oct', 'Nov', 'Dic']
	},
	plotOptions: {
		column: {
			pointPadding: 0.2,
			borderWidth: 0
		}
	},
	series: [{
		name: 'Ventas',
		data: [<?=$ventasMes?>]
	}, {
		name: 'Promedio',
		data: [<?=$ventaMensualPromedio?>,<?=$ventaMensualPromedio?>,<?=$ventaMensualPromedio?>,<?=$ventaMensualPromedio?>,<?=$ventaMensualPromedio?>,<?=$ventaMensualPromedio?>,<?=$ventaMensualPromedio?>,<?=$ventaMensualPromedio?>,<?=$ventaMensualPromedio?>,<?=$ventaMensualPromedio?>,<?=$ventaMensualPromedio?>,<?=$ventaMensualPromedio?>]
	}
	],
	responsive: {
		rules: [{
			condition: {
				maxWidth: 500
			},
			chartOptions: {
				legend: {
					layout: 'horizontal',
					align: 'center',
					verticalAlign: 'bottom'
				}
			}
		}]
	}

});

// Chart Vendedores
Highcharts.chart('chr-vendedores', {
    chart: {
        plotBackgroundColor: null,
        plotBorderWidth: null,
        plotShadow: false,
        type: 'pie'
    },
    title: {
        text: 'Diciembre 2018'
    },
    tooltip: {
        pointFormat: '{series.name}: <b>{point.percentage:.1f}%</b>'
    },
    plotOptions: {
        pie: {
            allowPointSelect: true,
            cursor: 'pointer',
            dataLabels: {
                enabled: true,
                format: '<b>{point.name}</b>: {point.percentage:.1f} %',
                style: {
                    color: (Highcharts.theme && Highcharts.theme.contrastTextColor) || 'black'
                }
            }
        }
    },
    series: [{
        name: 'Brands',
        colorByPoint: true,
        data: [<?=$vchrPie?>]
    }]
});
</script>
