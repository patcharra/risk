$(document).ready(function(){
	$('#addBtn').click(function(){
		if(checkFormInput()) {
			$('#form-table').submit();
		}
	});
	$('#editBtn').click(function(){
		if(checkFormInput()) {
			if(confirm('คุณต้องการบันทึกการเปลี่ยนแปลงข้อมูลใช่หรือไม่?')) {
				$('#form-table').submit();
			}
		}
	});
});

function checkFormInput() {
	$('#form-table .select-reference').filter('[require]').each(validateInput);
	return true;
}