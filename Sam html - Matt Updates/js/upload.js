$(document).ready(function(){

	var thumb = $('#thumb');	

	new AjaxUpload('imageUpload', {
		action: $('#newHotnessForm').attr('action'),
		name: 'image',
		onSubmit: function(file, extension) {
			$('#preview').addClass('loading');
		},
		onComplete: function(file, response) {
			thumb.load(function(){
				$('#preview').removeClass('loading');
				thumb.unbind();
			});
			thumb.attr('src', response);
		}
	});
});