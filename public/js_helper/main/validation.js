function checkOptionalFields(className, classValue, optionalArray) {
	let passed = 0;
	let message = '';
	for (let x = 0; x < optionalArray.length; x++) {
		const optionType = optionalArray[x][0];
		const optionSet = optionalArray[x][1];

		if (optionType == 'limit') {
			if (classValue.length > optionSet) {
				message += 'Value Is Limited To ' + optionSet + ' Characters/Numbers';
				passed = 1;
			}
		}
	}
	return [
		passed,
		message
	];
}

function checkInput({className, label, value, type}){
	const regexInfo = getValRegex({type, value: value, className:className});
	let passed = 0;
	switch (type) {
		case 'mix':
			clearInvalid(className);
			return true;
		default:
			if(!regexInfo.regex.test(value)){
				addInvalid(className, label + regexInfo.label);
				passed = 1;
			}else{
				clearInvalid(className);
			}
			break;
	}
	return passed == 0;
}

function getValRegex({type, value, className}){
	let reObject;
	switch (type) {
		case 'mix':
			clearInvalid(className);
			break;
		case 'string':
			reObject = {
				regex: /^([a-zA-Z]+\s)*[a-zA-Z]+$/,
				label: ' Must Only Contain Characters And Alphabets Only',
			};
			break;
		case 'int':
			reObject = {
				regex: /^\d+$/,
				label: ' Must Only Contain Digits',
			};
			break;
		case 'double':
			reObject = {
				regex: /[^\.].+/,
				label: ' Must Only Be In Double Format. Eg: 10.0',
			};
			break;
		case 'email':
			reObject = {
				regex: /^([a-zA-Z0-9_\.\-\+])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/,
				label: ' Must Be In Corrent Email Format. Eg: aaa@aaa.com',
			};
			break;
		case 'datedash':
			reObject = {
				regex: /^\d{4}-\d{2}-\d{2}$/,
				label: ' Must Be In The Correct Date Format DD-MM-YYYY',
			};
			break;
		case 'intdoublemix':
			reObject = {
				regex: /^[+-]?\d+(\.\d+)?$/,
				label: ' Must Only Be In Double Format Or Integer',
			};
			break;
	}
	return reObject;
}
function checkInput2(classValue, fieldName, value, type) {
	if (type == 'picture') {
		if ($(value).attr('href') == '#') {
			if ($(classValue)[0].files[0] == '' || typeof $(classValue)[0].files[0] == 'undefined') {
				$(classValue).addClass('is-invalid').closest('.form-group').find('.invalid-feedback').attr('style', 'display:block').html(fieldName + ' Harus Diisi');
				return false;
			} else {
				clearInvalid(classValue);
			}
		} else {
			clearInvalid(classValue);
		}
	}
	return true;
}

function clearAppendInvalid(parent_row, row, classValue) {
	$('' + parent_row + '[data-row=' + row + ']').find(classValue).closest('.form-group').find('.is-invalid').removeClass('is-invalid').find('.invalid-feedback').html('');
}


function validateImageSize(file, fixedwidth, fixedheight) {
	data = new FormData();
	data.append('image', file);
	$.ajax({
		type: 'POST',
		url: window.location.origin + '/accreditation/validation/imagesize',
		data: data,
		dataType: 'json',
		processData: false,
		contentType: false,
		context: this,
		async: false,
		success: function (data) {
			if (data['width'] >= fixedwidth && data['height'] >= fixedheight) {
				formtoast_danger('Image Must Be in ' + fixedwidth + 'px by ' + fixedheight + 'px');
				return false;
			} else {
				return true;
			}
		}
	});
	// return response;
}