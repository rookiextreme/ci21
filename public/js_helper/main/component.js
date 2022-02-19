function checkEmptyFields(fieldArray){
    let passed = 0;
    for(let x = 0; x < fieldArray.length; x ++){
        const className = fieldArray[x][0];
        const classValue = $(fieldArray[x][0]).val();
        const type = fieldArray[x][1];
        const label = fieldArray[x][2];
        const optionalField = fieldArray[x][3] ?  fieldArray[x][3] : [] ;

        if(type !== 'picture'){
            if(classValue === '' || typeof classValue === 'undefined'){
                addInvalid(className, label + ' Cannot Be Empty');
                passed = 1;
            }else{
                if(optionalField.length > 0){
                    var checkOptional = checkOptionalFields(className, classValue, optionalField);
                    if(checkOptional[0] == 1){
                        addInvalid(className, checkOptional[1]);
                        passed = 1;
                    }else{
                        if(checkInput({className: className,label: label,value: classValue,type: type}) == false){
                            passed = 1;
                        }else{
                            clearInvalid(className);
                        }
                    }
                }else{
                    if(checkInput({className: className,label: label,value: classValue,type: type}) == false){

                        passed = 1;
                    }else{
                        clearInvalid(className);
                    }
                }
            }
        }
    }
    if(passed == 1){
        return false;
    }else{
        return true;
    }
}

function checkEmptyFields2(fieldArray){
	var passed = 0;
    for(var x = 0;x<fieldArray.length;x++){
        var classValue = fieldArray[x][0];
    	var inputValue = fieldArray[x][1];
        var type = fieldArray[x][2];
    	var fieldName = fieldArray[x][3];
        if(inputValue === '' || typeof inputValue === 'undefined'){
            if(type === 'picture'){
                if($(classValue + '-preview-link').attr('href') === '#'){
                    if($(classValue)[0].files[0] === '' || typeof $(classValue)[0].files[0] === 'undefined'){
                        $(classValue).addClass('is-invalid').closest('.form-group').find('.invalid-feedback').attr('style', 'display:block').html(fieldName + ' Perlu Dimuat Turun');
                        passed = 1;
                    }else{
                        clearInvalid(classValue);
                    }
                }
            }else{
                $(classValue).addClass('is-invalid').closest('.form-group').find('.invalid-feedback').html(fieldName + ' Perlu Diisi');
                passed = 1;
            }
        }else if(inputValue !== '' || typeof inputValue !== 'undefined'){

        	if(checkInput(classValue, fieldName, inputValue, type) == false){
        		passed = 1;
        	}
        }
    }
    if(passed == 1){
    	return false;
    }else{
    	return true;
    }
}

function addInvalid(className, message){
    $(className).addClass('is-invalid').closest('.form-group').find('.invalid-feedback').html(message).attr('style', 'display:block');
}

function clearInvalid(className){
    $(className).removeClass('is-invalid').closest('.form-group').find('.invalid-feedback').attr('style', 'display:none').html('');
}

function checkEmptyFieldsAppend(fieldArray){
    var passed = 0;
    for(var x = 0;x<fieldArray.length;x++){
        var classValue = fieldArray[x][0];
        var inputValue = fieldArray[x][1];
        var fieldName = fieldArray[x][3];
        var row = fieldArray[x][4];
        var parent_row = fieldArray[x][5];

        if(inputValue == '' || typeof inputValue == 'undefined'){
            $(''+ parent_row +'[data-row='+ row +']').find(classValue).addClass('is-invalid').closest('.form-group').find('.invalid-feedback').html(fieldName + ' Cannot Be Empty');
            passed = 1;
        }else if(inputValue != '' || typeof inputValue != 'undefined'){
            var type = fieldArray[x][2];
            if(checkAppendInput(parent_row, row, classValue, fieldName, inputValue, type) == false){
                passed = 1;
            }
        }
    }
    if(passed == 1){
        return false;
    }else{
        return true;
    }
}

function postEmptyFields(fieldArray){
    for(var x = 0;x<fieldArray.length;x++){
        var inputClass = fieldArray[x][0];
        var inputType = fieldArray[x][1];

        if(inputType == 'text'){
            $(inputClass).val('').closest('.form-group').find('.invalid-feedback').html('');
        }else if(inputType == 'dropdown'){
            $(inputClass).val('').trigger('change').closest('.form-group').find('.invalid-feedback').html('');
        }else if(inputType == 'photo'){
			$(inputClass).attr('style', '');
		}else if(inputType == 'checkbox'){
            $(inputClass).each(function(i, obj) {
                var check = $(this).prop('checked');
                if(check){
                    $(this).prop('checked', false);
                }
            });
        }
    }
}

function checkPicData(data){
    let pass = 0;
    for(let x = 0;x < data.length;x ++){
        let picClassName = data[x][0];
        let picClassSelector = $(data[x][0]);
        const picFile = picClassSelector[0].files[0];
        const picFormat = data[x][1];

        if(picFile == '' || typeof picFile == 'undefined'){
            picClassSelector.addClass('is-invalid').closest('.form-group').find('.invalid-feedback').attr('style', 'display:block').html('Field Must Be Not Be Empty');
            pass = 1;
        }else{
            let picName = picFile.name.toLowerCase();
            let extension = picName.substr( (picName.lastIndexOf('.') +1) );

            if(picFormat.includes(extension)){
                clearInvalid(picClassName);
            }else{
                picClassSelector.addClass('is-invalid').closest('.form-group').find('.invalid-feedback').attr('style', 'display:block').html('Field Must Be In '+ picFormat +' Format');
                pass = 1;
            }
        }
    }

    return pass;
}
