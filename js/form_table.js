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
	var pass = true;
	alert('enter');
	if($('#editBtn').length > 0) {
		alert('edit');
		if(!confirm('คุณต้องการบันทึกการเปลี่ยนแปลงข้อมูลใช่หรือไม่?')) {
			pass = false;
		}
	}

	return pass;
}