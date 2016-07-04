(function() {

	var app = Sammy.apps.body;
	var base_name = "publisher-system";
	var page_name = "";
	
	$("#background-img").hide();
	$("#preview-img-txt").hide();
	$("#select-fonts").hide();
	$("#select-font-color").hide();
	$("#select-watermark").hide();
	
	$("#someone-comment").hide();
	$("#term-feed").hide();
	$("#curl-cmd").hide();
	
	app.get('#/', function(context) {
		$(document).ajaxStart(function() {
			NProgress.configure({ showSpinner: false });
			NProgress.configure({ easing: 'ease', speed: 5000 });
			NProgress.start();
		});
		$.get("/" + base_name + "/setting", function(response) {
			//loading youtube-style progreebar
			if(response === "setting file missing.") {
				alert("setting.php missing！");
			}
			else {
				var json = JSON.parse(response);
				$("#start-title").text(json["start-title"]);
				$("#header-title").text(json["header-title"]);
				$("#user-guide").attr("href", json["user-guide"]);
				$("#facebook-page-link").attr("href", json["facebook-page-link"]);
				if(json["plurk-page-link"] != "")
					$("#plurk-page-link").attr("href", json["plurk-page-link"]);
				else
					$("#plurk-page-link").hide();
				$("#title-en").text(json["title-en"]);
				$("#title-msg").text(json["title-msg"]);
				$("#title-description").text(json["title-description"]);
				page_name = json["page-name"];
				
				$("#user-guide").text(json["user-guide-text"]);
				$("#someone-comment").text(json["someone-comment"]);
				$("#term-feed").text(json["term-feed"]);
				$("#curl-feed").text(json["curl-feed"]);
				$("#input-msg").text(json["input-msg"]);
				$("#feed-contents").attr("placeholder", json["feed-contents-placeholder"]);
				$("#input-post-mode").text(json["input-post-mode"]);
				
				$("#limit-txt").append(json["limit-txt"]);
				$("#limit-img-txt").append(json["limit-img-txt"]);
				$("#preview-img-txt").text(json["preview-img-txt"]);
				
				$("#fonts-name-select").text(json["fonts-name-select"]);
				$("#fonts-name").text("");
				$("#fonts-name").html(json["kaiu"] + json["SourceHan"] + json["SourceHanBold"]);
				
				$("#fonts-color-select").text(json["fonts-color-select"]);
				$("#fonts-color").text("");
				$("#fonts-color").html(json["red-color"] + json["black-color"] + json["yellow-color"] + 
					json["green-color"] + json["white-color"]);
				
				$("#yes-no-watermark").text(json["yes-no-watermark"]);
				$("#watermark-optradio-yes").append(json["watermark-optradio-yes"]);
				$("#watermark-optradio-no").append(json["watermark-optradio-no"]);
				
				$("#private-policy").html(json["private-policy"]);
				$("#scroll-view").html(json["scroll-view"]);
				$("#agree-policy-area").html(json["agree-policy-area"]);
				$("#submit-btn").text(json["submit-btn"]);
				
				$("div[name='description-usage']").html(json["description-usage"]);
				$("div[name='post-support']").text(json["post-support"]);
				$("div[name='post-policy']").html(json["post-policy"]);
				$("span[name='policy-rule']").html(json["policy-rule"]);
				$("div[name='tutorial']").html(json["tutorial"]);
				
			}
			NProgress.done();
		}).done(function() {
			$("div.form-group").find("#page-name").text(page_name);
		});
		
		$(document).ajaxStop(function() {
			NProgress.done();
		});
	});
	
	$("#curl-feed").click(function(e) {
		e.preventDefault();
		$("#curl-cmd").slideDown("slow");
	});
	
	$("input[name='optradio']").click(function() {
		var val = $("input[name='optradio']:checked").val();
		if(val === "image-txt") {
			//ouput preview
			$("#background-img").show();
			$("#preview-img-txt").show();
			$("#select-fonts").show();
			$("#select-font-color").show();
			$("#select-watermark").show();
			img_generator();
		}
		else {
			$("#background-img").hide();
			$("#preview-img-txt").hide();
			$("#select-fonts").hide();
			$("#select-font-color").hide();
			$("#select-watermark").hide();
		}
		
	});
	
	$("input[name='watermark-optradio']").click(function() {
		var val = $("input[name='watermark-optradio']:checked").val();
		process_watermark(val);
	});
	
	$("#feed-contents").bind("input propertychange", img_generator);
	
	$("#fonts-name,#fonts-color").change(img_generator);
	
	$(document).delegate("#agree-policy", "change", function() {
		var agree = $("#agree-policy").is(":checked");
		if(agree)
			$("#agree-policy").val("agree-policy");
		else
			$("#agree-policy").val("");
	});
	
	$("#submit-btn").click(function(e) {
		e.preventDefault();
		var agree = $("#agree-policy").val();
		
		if(agree !== "agree-policy") {
			alert("please read the policy！");
		}
		else {
			var check_post = false;
			var feed_contents = $("#feed-contents").val();
			var check_img_show = $("#background-img").attr("style");
			
			if(feed_contents.length === 0) {
				alert("please input feed contents！");
				return false;
			}
			
			if(check_img_show !== "display: none;") {
				if(feed_contents.length > 300) {
					alert("the contents are not more than 300 words");
				}
				else {
					check_post = true;
				}
			}
			else {
				if(feed_contents.length > 1024) {
					alert("the contents are not more than 1024 words");
				}
				else {
					check_post = true;
				}
			}
			
			if(check_post) {
				var val = $("input[name='optradio']:checked").val();
				var data = {};
				
				switch(val) {
					case "image-txt":
						data.images = $("#background-img").attr("src");
						data.feed_contents = feed_contents;
						break;
					case "plain-txt":
						data.feed_contents = feed_contents;
						break;
					default:
						alert("please select the post mode！");
						return false;
				}
				
				post_feed(data);
			}
		}
	});
	
	function img_generator() {
		var check_img_show = $("#background-img").attr("style");
		if(check_img_show !== "display: none;") {
			var feed_contents = $("#feed-contents").val();
			var fonts_name = $("#fonts-name").val();
			var fonts_color = $("#fonts-color").val();
			var watermark_str = $("input[name='watermark-optradio']:checked").val();
			
			$.post("/" + base_name + "/api/img", {feed_contents:feed_contents,fonts_name:fonts_name,fonts_color:fonts_color,watermark_str:watermark_str}, function(response) {
				$("#background-img").attr("src", "data:image/jpg;base64," + response);
			});
		}
	}
	
	function process_watermark(watermark_str) {
		var feed_contents = $("#feed-contents").val();
		var fonts_name = $("#fonts-name").val();
		var fonts_color = $("#fonts-color").val();
		
		$.post("/" + base_name + "/api/img", {feed_contents:feed_contents,fonts_name:fonts_name,fonts_color:fonts_color,watermark_str:watermark_str}, function(response) {
			$("#background-img").attr("src", "data:image/jpg;base64," + response);
		});
	}
	
	function post_feed(data) {
		$.post("/" + base_name +"/api/post", data, function(response) {
			if(response === "Not supported image format or image too big") {
				alert("Plurk: " + response);
				return false;
			}
			
			response = JSON.parse(response);
			
			if(response["fb-response"]["message"] == "Error validating access token: The session has been invalidated because the user has changed the password.") {
				//if you got this reason, you have to regenerate the page access token.
				alert("Token is expired, the possible reason that the user has changed the password.");
				return false;
			}
			
			if(response["plurk-response"] == "anti-flood-same-content") {
				alert("reason: anti-flood-same-content, post on plurk is failed！");
			}
			
			var response_fb = response["fb-response"]["id"];
			var response_plurk = response["plurk-response"]["id"];
			
			if(response_fb != "undefined" && response_plurk != "undefined") {
				alert("Your post feed is successful to send！");
			}
			else {
				alert("Your post feed is failed to send！");
			}
			
		});
	}

})();