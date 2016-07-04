(function() {

	var app = Sammy('body', function() {
		//override not found
		this.notFound = function() {
			location.href = "/bigsu-life/404";
		}
	});
	
	app.use(Sammy.Template);

	$(document).ready(function() {
		app.run("#/");
	});

})();