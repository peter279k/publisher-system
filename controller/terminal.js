(function() {

	var app = Sammy.apps.body;

	app.get('#/user', function(context) {
		console.log("You're in the User route");
	});

})();