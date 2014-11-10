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

	// Check Input required and pattern
    $('#form-table input').filter('[require],[valuepattern]').focusout(validateInput);
    $('#form-table textarea').filter('[require],[valuepattern]').focusout(validateInput);
});

function checkFormInput() {
	var pass = true;

	$('#form-table input').filter('[require],[valuepattern]').each(validateInput);
	$('#form-table textarea').filter('[require],[valuepattern]').each(validateInput);

	// Do someting before save
	if(typeof beforeSaveRecord == 'function') {
		if(!beforeSaveRecord()) {
			pass = false;
		}
	}

	var inputErr 		= $('#form-table input.required').length;
	var txtAreaErr 		= $('#form-table textarea.required').length;
	var allErr 			= inputErr + txtAreaErr;
	if(allErr > 0) {
		pass = false;
	}

	return pass;
}

function validateInput() {
	var id = $(this).attr('id');

	// Clear error
	$(this).removeClass('required');
	$('.err-' + id).css('display', 'none');
	
	var value = '';
	value = $(this).val();

	if (value == '') {
        var attrRequire = $(this).attr('require');
    	if (typeof attrRequire !== typeof undefined && attrRequire !== false) {
    		// Check require
    		$(this).addClass('required');
    		$('#err-' + id + '-require').css('display', 'block');
		}
    } else {
    	var attrPattern = $(this).attr('valuepattern');
    	if (typeof attrPattern !== typeof undefined && attrPattern !== false) {
    		// Validate value pattern
    		if(attrPattern == 'money') {
    			if(!validateMoney(value)) {
					$('#err-' + id + '-money').css('display', 'block');
					$(this).addClass('required');
				}
    		} else if(attrPattern == 'email') {
    			if(!validateEmail(value)) {
					$('#err-' + id + '-email').css('display', 'block');
					$(this).addClass('required');
				}
    		} else if(attrPattern == 'number') {
    			if(!validateNumber(value)) {
					$('#err-' + id + '-number').css('display', 'block');
					$(this).addClass('required');
				}
    		} else if(attrPattern == 'character') {
    			if(!validateCharacter(value)) {
					$('#err-' + id + '-character').css('display', 'block');
					$(this).addClass('required');
				}
    		} else if(attrPattern == 'tel') {
    			if(!validateTel(value)) {
					$('#err-' + id + '-tel').css('display', 'block');
					$(this).addClass('required');
				}
    		} else if(attrPattern == 'minute') {
    			if(!validateMinute(value)) {
					$('#err-' + id + '-minute').css('display', 'block');
					$(this).addClass('required');
				}
    		} else if(attrPattern == 'numberMoreThanZero') {
    			if(!validateNumberMoreThanZero(value)) {
					$('#err-' + id + '-numberMoreThanZero').css('display', 'block');
					$(this).addClass('required');
				}
    		} else if(attrPattern == 'username') {
    			if(!validateUsername(value)) {
					$('#err-' + id + '-username').css('display', 'block');
					$(this).addClass('required');
				}
    		}
		}
    }
}

function validateEmail(email) { 
    var re = /^(([^<>()[\]\\.,;:\s@\"]+(\.[^<>()[\]\\.,;:\s@\"]+)*)|(\".+\"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
    return re.test(email);
}

function validateMoney(money) {
	var re = /^[0-9]*(\.[0-9]{1,2})?$/;
	return re.test(money);
}

function validateNumber(number) {
	var re = /^[0-9]*$/;
	return re.test(number);
}

function validateCharacter(character) {
	var re = /^[a-zA-Zก-๙\s]+$/;
	return re.test(character);
}

function validateTel(tel) {
	var re = /^[0-9]{10}$/;
	return re.test(tel);
}

function validateMinute(min) {
	var pass = true;
	var re 	 = /^[0-9]{1,2}$/;
	if(re.test(min)) {
		if(parseInt(min) > 59) {
			pass = false;
		}
	} else {
		pass = false;
	}

	return pass;
}

function validateNumberMoreThanZero(number) {
	var pass = true;
	var re 	 = /^[0-9]+$/;
	if(re.test(number)) {
		if(parseInt(number) <= 0) {
			pass = false;
		}
	} else {
		pass = false;
	}

	return pass;
}

function validateUsername(strUsername) {
	var pass = true;
	var re = /^[a-zA-Z]+[a-zA-Z0-9]*$/;
	if(re.test(strUsername)) {
		if(strUsername.length < 6) {
			pass = false;
		}
	} else {
		pass = false;
	}

	return pass;
}