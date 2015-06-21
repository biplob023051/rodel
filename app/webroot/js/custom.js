$(document).ready(function(){
	$(".dropdown.count > li").each(function(){
		var liconut = $(this).index()+1;
		$(this).prepend("<i>" +liconut+"."+ "</i>");
	});
});