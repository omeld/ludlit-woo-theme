$(document).ready(function() {
	var mainContainer = $('#main-container');
	var proceedingsList = $('#list-of-proceedings');

	$('#show-list').click(function() {
		var pseudo = window.getComputedStyle(
				document.querySelector('body'), ':after'
			).getPropertyValue('content');
		if (pseudo == "'720'") {
			if (proceedingsList.is(':hidden')) {
				proceedingsList.slideDown();
			} else {
				proceedingsList.slideUp();
			}
		} else {
			mainContainer.animate({
				marginLeft: (parseInt(mainContainer.css('marginLeft'),10) == 0 ?  "25%" : 0)
			});
		}
	});	
});
