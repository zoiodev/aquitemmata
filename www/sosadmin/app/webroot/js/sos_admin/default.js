$(document).ready(function(){
	tinymce.init({
					selector: "textarea", 
					language: 'pt_BR',
					theme: "modern", 
					width: 680, 
					height: 300, 
					subfolder:"", 
					plugins: [ 
					"advlist autolink link image lists charmap print preview hr anchor pagebreak", 
					"searchreplace wordcount visualblocks visualchars code insertdatetime media nonbreaking", 
					"table contextmenu directionality emoticons paste textcolor" 
					], 
					image_advtab: true, 
					toolbar: "undo redo | bold italic underline | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | styleselect forecolor backcolor | link unlink anchor | image media | print preview code"
				});
});