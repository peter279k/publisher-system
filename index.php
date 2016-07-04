<?php
	use Sinergi\Token\StringGenerator;
	require 'settings/setting.php';
	require 'helper/curl_helper.php';
	require 'Slim/Slim.php';
	require 'vendor/autoload.php';
	\Slim\Slim::registerAutoloader();
	
	$app = new \Slim\Slim();
	
	//customize 404 not found
	$app -> notFound(function () use ($app) {
		$contents = file_get_contents("view/404.html");
		$app -> halt(404, $contents);
	});
	
	$app -> get('/', function () {
		$contents = file_get_contents("./index.html");
		echo $contents;
	});
	
	$app -> get('/:name', function ($name) use ($app) {
		$name = htmlentities($name);
		
		if($name === "setting") {
			header("Content-Type: Application/json");
			
			$arr = array();
			$arr["start-title"] = start_title;
			$arr["header-title"] = header_title;
			$arr["well-title"] = well_title;
			$arr["user-guide"] = user_guide;
			$arr["user-guide-text"] = user_guide_text;
			$arr["user-guide-link"] = user_guide_link;
			$arr["facebook-page-link"] = facebook_page_link;
			$arr["plurk-page-link"] = plurk_page_link;
			$arr["title-en"] = title_en;
			$arr["title-msg"] = title_msg;
			$arr["title-description"] = title_description;
			$arr["page-name"] = page_name;
			$arr["someone-comment"] = someone_comment_text;
			$arr["term-feed"] = term_feed_text;
			$arr["curl-feed"] = curl_feed_text;
			$arr["input-msg"] = input_msg_text;
			$arr["feed-contents-placeholder"] = feed_contents_placeholder;
			$arr["input-post-mode"] = input_post_mode;
			$arr["limit-txt"] = limit_txt;
			$arr["limit-img-txt"] = limit_img_txt;
			$arr["preview-img-txt"] = preview_img_txt;
			$arr["fonts-name-select"] = fonts_name_select;
			$arr["fonts-color-select"] = fonts_color_select;
			$arr["yes-no-watermark"] = yes_no_watermark;
			$arr["watermark-optradio-yes"] = watermark_optradio_yes;
			$arr["watermark-optradio-no"] = watermark_optradio_no;
			$arr["private-policy"] = private_policy;
			$arr["scroll-view"] = scroll_view;
			$arr["agree-policy-area"] = agree_policy_area;
			$arr["submit-btn"] = submit_btn;
			$arr["kaiu"] = kaiu;
			$arr["SourceHan"] = SourceHan;
			$arr["SourceHanBold"] = SourceHanBold;
			$arr["red-color"] = red_color;
			$arr["black-color"] = black_color;
			$arr["yellow-color"] = yellow_color;
			$arr["green-color"] = green_color;
			$arr["white-color"] = white_color;
			$arr["description-usage"] = description_usage;
			$arr["post-support"] = post_support;
			$arr["post-policy"] = post_policy;
			$arr["policy-rule"] = policy_rule;
			$arr["tutorial"] = tutorial;
			
			echo json_encode($arr);
		}
		else {
			$app -> notFound();
		}
	});
	
	$app -> post('/api/:name', function($name) use ($app) {
		//find url
		
		$name = htmlentities($name);
		if($name === "img") {
			header("Content-Type: image/jpg");
			//generate image-text
			// Create image
			$image = new \NMC\ImageWithText\Image('images/black.jpg');
			
			$str = filter_input(INPUT_POST, "feed_contents");
			$fonts = filter_input(INPUT_POST, "fonts_name");
			$color = filter_input(INPUT_POST, "fonts_color");
			$watermark_str = filter_input(INPUT_POST, "watermark_str");
			
			switch($fonts) {
				case "kaiu":
				default:
					$fonts = "kaiu.ttf";
					break;
				case "SourceHan":
					$fonts = "SourceHanSansHWTC-Regular.otf";
					break;
				case "SourceHanBold":
					$fonts = "SourceHanSansHWTC-Bold.otf";
					break;
			}
			
			switch($color) {
				case "red-color":
					$color = "990000";
					break;
				case "yellow-color":
					$color = "ffff00";
					break;
				case "black-color":
					$color = "000000";
					break;
				case "white-color":
					$color = "ffffff";
					break;
				case "green-color":
				default:
					$color = "00ff00";
					break;
			}
			
			//remove some dirty texts
			$str = str_replace(array("\r","\n"), " ", $str);
			$str = str_replace(array("幹", "你娘"), "*", $str);
			$str = str_replace(array("Fuck", "fuck", "FUCK"), "*", $str);
			$str = str_replace(array("Shit", "shit", "SHIT"), "*", $str);
			$start = 1;
			$startY = 10;
			$mb_len = mb_strlen($str);
			
			for($index=0;$index<$mb_len;$index+=19) {
				if($mb_len < 19)
					$write_str = mb_substr($str, $index, $mb_len, "utf-8");
				else	
					$write_str = mb_substr($str, $index, 19, "utf-8");
				
				$contents = new \NMC\ImageWithText\Text($write_str, $start, strlen($str));
				$contents -> align = 'left';
				$contents -> color = $color;
				$contents -> font = 'fonts/' . $fonts;
				$contents -> lineHeight = 20;
				$contents -> size = 25;
				$contents -> startX = 10;
				$contents -> startY = $startY;
				$image -> addText($contents);
	
				$start += 1;
				$startY += 30;
			}
			
			//間距(watermark)
			if($watermark_str === "watermark") {
				$distance = 35;
				$initial = 620;
	
				$watermark = new \NMC\ImageWithText\Text(start_title, $start, mb_strlen(start_title));
				$watermark -> align = 'left';
				$watermark -> color = 'ffff00';
				$watermark -> font = 'fonts/' . $fonts;
				$watermark -> lineHeight = 20;
				$watermark -> size = 25;
				$watermark -> startX = $initial - $distance * ((int)mb_strlen(start_title, "utf-8") - 1);
				$watermark -> startY = 595;
				$image -> addText($watermark);
			}
			// Render image (save image)
			$img_path = dirname(__FILE__) . "/" . StringGenerator::randomAlnum(5) . '.jpg';
			$image -> render($img_path);
			echo base64_encode($image -> image -> response());
			@unlink($img_path);
			
		}
		else if($name === "post") {
			//post feed
			header("Content-Type: application/json");
			
			$img = filter_input(INPUT_POST, "images");
			$feed_contents = filter_input(INPUT_POST, "feed_contents");
			$post_template = file_get_contents(post_template_file);
			
			if($img == "" && $feed_contents == "") {
				header('HTTP/1.1 400 Bad Request');
				echo json_encode(array(
					"message" => "missing-arguments"
				));
				exit();
			}
			
			$data = array();
			$plurk_data = array();
			
			//using curl to post feed
			if($img != "") {
				//find url in $feed_contents
				$reg_exUrl = "/(http|https|ftp|ftps)\:\/\/[a-zA-Z0-9\-\.]+\.[a-zA-Z]{2,3}(\/\S*)?/";
				$links = "";
				if(preg_match($reg_exUrl, $feed_contents, $url)) {
					$links = $url[0];
				}
				
				//creating temp image file
				$img_path = StringGenerator::randomAlnum(5) . '.jpg';
				$img = str_replace("data:image/jpg;base64,", "", $img);
				file_put_contents($img_path, base64_decode($img));
				$data["message"] = $post_template . "\r\n" . $links;
				$message = $links;
				
				//if PHP 5.5+ then new CurlFile(realpath($img_path), "image/jpg")
				//if before PHP 5.5 then @realpath($img_path)
				
				if(version_compare(PHP_VERSION, '5.5.0', '<'))
					$data["source"] = "@" . realpath($img_path);
				else
					$data["source"] = new CurlFile(realpath($img_path), "image/jpeg");
				
				$data["access_token"] = page_access_token;
				
				$action = "https://graph.facebook.com/" . facebook_page_id . "/photos";
				
				try {
					$curl_fb = new curl_helper($data, $action);
					
					$plurk_data["image"] = $data["source"];
					
					date_default_timezone_set('Asia/Taipei');
					
					//Math.round((new Date()).getTime() / 1000)
					$plurk_data["file_id"] = (string)time();
					$plurk_data["mini"] = "false";

					$action = "http://www.plurk.com/Shares/uploadImageGetUrl";
				
				
					$curl_plurk = new curl_helper($plurk_data, $action);
					
					$fb_curl = $curl_fb -> post_feed_upload();
					$url = $curl_plurk -> post_plurk_upload();
			
					if($url["error"] == "") {
					
						$action = 'http://www.plurk.com/TimeLine/addPlurk';
				
						$plurk_data = 'qualifier=says&amp;content=' . urlencode($message . "\r\n" . $url["filename"] . "\r\n post-md5: " . md5((string)microtime())) . '&amp;lang=tr_ch&amp;no_comments=0&amp;uid=' . USER_ID;
				
						$curl_plurk = new curl_helper($plurk_data, $action);

						$plurk_curl = $curl_plurk -> post_plurk_feed();
						
						$curl_mul = new curl_helper(null, null);
						
						$response = $curl_mul -> curl_multi_req($fb_curl, $plurk_curl);
						
						echo json_encode($response);
						
						//deleting temp image file
						@unlink($img_path);
					}
					else {
						echo $url["error"];
					}
				}
				catch(Exception $e) {
					echo $e -> getMessage();
				}
				
			}
			else if($feed_contents != "") {
				$plurk_data = "";
				
				try {
					$data["access_token"] = page_access_token;
					$data["message"] = $post_template . "\r\n" . $feed_contents;
					$message = $feed_contents;
				
					$action = 'http://www.plurk.com/TimeLine/addPlurk';
				
					$plurk_data = 'qualifier=says&amp;content=' . urlencode($message . "\r\n post-md5: " . md5((string)microtime())) . '&amp;lang=tr_ch&amp;no_comments=0&amp;uid=' . USER_ID;
				
					$curl_plurk = new curl_helper($plurk_data, $action);
					$plurk_curl = $curl_plurk -> post_plurk_feed();
				
					$action = "https://graph.facebook.com/" . facebook_page_id . "/feed";
				
					$curl_fb = new curl_helper($data, $action);
					$fb_curl = $curl_fb -> post_feed_upload();

					$curl_mul = new curl_helper(null, null);
	
					$response = $curl_mul -> curl_multi_req($fb_curl, $plurk_curl);
						
					echo json_encode($response);
				}
				catch(Exception $e) {
					print_r($e);
				}
			}
			else {
				echo "no feed contents";
			}
		}
		else {
			$app -> notFound();
		}
	});
	
	$app->run();
	
?>