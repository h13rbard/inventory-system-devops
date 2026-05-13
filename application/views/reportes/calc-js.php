<script>
function calcular1() {
	var num1 = parseFloat($("#txt11").val());
	var num2 = parseFloat($("#txt12").val());
	var num3 = parseFloat($("#txt13").val());
	var res = ( num1 * num3 ) / num2;
	$("#res1").val(res); 
}

function calcular2() {
	var num1 = parseFloat($("#txt21").val());
	var num2 = parseFloat($("#txt22").val());
	var num3 = parseFloat($("#txt23").val());
	var res = ( num1 * num3 ) / num2;
	$("#res2").val(res); 
}
</script>
