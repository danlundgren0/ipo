$(function() {
	if($('.shieldQRcodeClass').length>0) {
		$('.shieldQRcodeClass').each(function() {
			var id = $(this).attr('id');			
			var qrUrl = $(this).attr('data-qrUrl');
			var parentPage = $(this).attr('data-parentPage');
			var subPage = $(this).attr('data-subPage');
			console.log($(this));
			console.log(id);
			console.log(qrUrl);
			console.log(parentPage);
			console.log(subPage);
            $('#'+id).shieldQRcode({
                mode: "byte",
                size: 215,
                value: qrUrl,
                //style: {
                //    color: "#4D952F"
                //}
            });
		});
	}
});