function destacarItemDeMenu(id){
	$(".nav.navbar-nav li.active").removeClass('active');
	$('.nav.navbar-nav li#' + id).addClass('active');
}

function loadCidades(urlListarCidades, cidadeSelectElement, cidadeDefault) {
	$.ajax({
		url : urlListarCidades,
		dataType : 'json',
		success : function(data) {
			cidadeSelectElement.append('<option value="">Selecione uma cidade...</option>');
			for ( var i in data) {
				var selected = '';
				if (cidadeDefault != null && cidadeDefault == i){
					selected = ' selected="selected"';
				}
				cidadeSelectElement.append('<option value="' + i + '"'+selected+'>'	+ data[i] + '</option>');
			}

		}
	});
}

function changeSelectedOption(select, option){
	select.children("option").removeAttr('selected');
	select.find("option[value="+option+"]").attr('selected', 'selected');
}