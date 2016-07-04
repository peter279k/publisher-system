<?php
	
	//defining index html file path
	define("index_file_path", "./index.html");
	
	//post template file
	define("post_template_file", "view/post.template");
	
	//customizing some texts in index.html
	if(index_file_path === "./index.html") {
		//id
		define("start_title", "大蘇的日常");
		define("header_title", "大蘇的日常");
		define("well_title", "大蘇的日常");
		define("user_guide", "https://peterweb_uploadspace.rhcloud.com/?p=474");
		define("user_guide_text", "新手教學");
		define("user_guide_link", "https://peterweb_uploadspace.rhcloud.com/?p=474");
		define("facebook_page_link", "https://www.facebook.com/bigsulife/");
		define("plurk_page_link", "https://www.plurk.com/bigsulife");
		define("title_en", "Bigsu-life");
		define("title_msg", "你今天大蘇了嘛？");
		define("title_description", "匿名發文說說大蘇又做了什麼「事情」");
		define("page_name", "大蘇的日常");
		
		define("someone_comment_text", "匿名回覆");
		define("term_feed_text", "「終端機」發文");
		define("curl_feed_text", "cURL指令發文");
		define("input_msg_text", "請輸入你想要發的文：");
		define("feed_contents_placeholder", "你想發什麼文呢？");
		define("input_post_mode", "請選擇發文模式：");
		define("limit_txt", "純文字或連結發文 (字數限制: 1024)");
		define("limit_img_txt", "文字圖發文 (字數限制：300)");
		define("preview_img_txt", "文字圖預覽：");
		define("fonts_name_select", "請選擇字體：");
		define("fonts_color_select", "請選擇字體顏色：");
		define("yes_no_watermark", "請選擇要不要有浮水印：");
		define("watermark_optradio_yes", "要");
		define("watermark_optradio_no", "不要");
		define("private_policy", "<p>隱私權政策</p>");
		define("scroll_view", '非常歡迎您光臨 <span id="page-name"></span> (以下簡稱本網站)，為了讓您能夠安心的使用本網站的各項服務與資訊，特此向您說明本網站的隱私權保護政策，以保障您的權益，請您詳閱下列內容： 一、隱私權保護政策的適用範圍 隱私權保護政策內容，包括本網站如何處理在您使用網站服務時收集到的個人識別資料。隱私權保護政策不適用於本網站以外的相關連結網站，也不適用於非本網站所委託或參與管理的人員。 二、資料的蒐集與使用方式 為了在本網站上提供您最佳的互動性服務，可能會請您提供相關個人的資料，其範圍如下：於使用發文服務時，伺服器會自行記錄相關行徑，包括您使用連線設備的去識別性的IP位址、使用時間，做為我們增進網站服務的參考依據。於使用檢舉系統時，伺服器會自行記錄相關行徑，包括您提交檢舉時使用之臉書帳號ID、檢舉時間，做為系統自動判斷發文下架之依據。以上之記錄皆為內部應用，決不對外公布。除非取得您的同意或其他法令之特別規定，本網站絕不會將您的個人資料揭露予第三人或使用於蒐集目的以外之其他用途。 三、資料之保護 本網站主機均設有防火牆、防毒系統等相關的各項資訊安全設備及必要的安全防護措施，加以保護網站及您的個人資料採用嚴格的保護措施。 四、網站對外的相關連結 本網站的網頁提供其他網站的網路連結，您也可經由本網站所提供的連結，點選進入其他網站。但該連結網站不適用本網站的隱私權保護政策，您必須參考該連結網站中的隱私權保護政策。 五、隱私權保護政策之修正 本網站隱私權保護政策將因應需求隨時進行修正，修正後的條款將刊登於網站上。');
		define("agree_policy_area", '<label>
			<input id="agree-policy" class="checkbox-size" type="checkbox" value="">
			我同意並已經詳細閱讀發文守則與隱私權政策
			</label>');
		define("submit_btn", "送出匿名發文");
		
		//select drop menu
		//fonts-name
		define("kaiu", "<option value='kaiu'>標楷體</option>");
		define("SourceHan", "<option value='SourceHan'>思源黑體</option>");
		define("SourceHanBold", "<option value='SourceHanBold'>思源黑體(粗體)</option>");
		
		//fonts-color
		define("red_color", "<option value='red-color'>紅色</option>");
		define("black_color", "<option value='black-color'>黑色</option>");
		define("yellow_color", "<option value='yellow-color'>黃色</option>");
		define("green_color", "<option value='green-color'>綠色</option>");
		define("white_color", "<option value='white-color'>白色</option>");
		
		
		//name
		define("description_usage", "<p>請寫下發文內容，按下送出按鈕，就會自動發文</p><p>請勿透漏任何個資或隱私資訊</p>");
		define("post_support", "目前僅支援發佈到Facebook與噗浪");
		define("post_policy", "<p>發文守則</p>");
		define("policy_rule", "
			<p>0.當你勾選後，即代表您同意遵守『Facebook 社群』使用規則。</p>
			<p>1.嚴禁發表任何霸凌內容、或有相關意圖之內容，違反將被刪除。</p>
			<p>2.透漏任何個資或隱私資訊，或在文中直接提到任何公司、機構、學校名稱，違反者一律刪文。</p>
			<p>3.嚴禁發表任何情色、暴力之相關內容，或有相關意圖之內容，違反將被刪除。</p>
			<p>4.與本版主題無關、或發文內容明顯為測試意圖、或無關之推薦文、廣告文、職缺文，將被刪除。</p>
			<p>5.本系統會自動使用「*」來取代敏感字詞。
			<p>6.「寶寶」文格殺勿論。</p>");
		define("tutorial", "第一次發文嘛？請閱讀我們的<a class='link-hover' href='" . user_guide . "'>新手教學</a>！");
		
	}
	
	//facebook page access token, facebook app id and facebook app secret
	define("page_access_token", "your-page-access-token");
	define("facebook_app_id", "your-facebook-app-id");
	define("facebook_app_secret", "your-facebook-app-secret");
	define("facebook_page_id", "your-facebook-page-id");
	
	//plurk key and secret
	if(plurk_page_link !== "") {
		define('PLURK_NAME', 'your-Plurk-account-name');
		define('PLURK_PASS', 'your-Plurk-password');
		define('USER_ID', 'your-Plurk-user-id');
	}
	
	//Anonymous comment
	define("anonymous_comment", "off");
	
	//Terminal feed
	define("term_feed", "off");
	
	//cURL feed
	define("curl_feed", "off");
?>