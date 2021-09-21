 var isRtl = $('html').attr('data-textdirection') === 'rtl',
	 clearToastObj;

function toasting(messsage, toastType){
	toastr[toastType](messsage, {
	  	showMethod: 'slideDown',
	  	hideMethod: 'slideUp',
	  	timeOut: 2000,
	  	rtl: isRtl
	});
}