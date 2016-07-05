# publisher-system
[![Gitter](https://badges.gitter.im/peter279k/publisher-system.svg)](https://gitter.im/peter279k/publisher-system?utm_source=badge&utm_medium=badge&utm_campaign=pr-badge)
# Introduction
  This project is inspired by [facebook-anonymous-publisher](https://github.com/kobeengineer/facebook-anonymous-publisher) and it also provide you to easily manage anonymous Facebook page and Plurk bot.
  
  The general method to provide an anonymous Facebook page for people is:
 > An administrator createss a Facebook page and provides a third-party service for people to post messages to a temeporay database. For example, [anonymous monkey] (http://anonymonkey.com/). 
 > When the administrator received a new message from a user, he or she has to manually review and publish the message to the Facebook page.
 > It is not very convenient for us so I develop this project to make them easily manage their Facebook page.
 
### do less Management, do more freedom of publishing the message.

This project provides some advantages by the following steps for you:

+ Without any unprediectable Facebook API errors and this service will automatically publish the message that someone writes.
+ The service will directly publish the new message from users to your Facebook page and you don't have to manually review and publish the message.
+ If someone wants to publish messages, they don't have to use Facebook account to login Facebook. In other words, everyone has the right to publish new message.
+ You can also edit setting file to filter the sensitive words and customize your HTML pages.
+ The service works 24 hours per day and it does not need to sleep.
+ The service supports Facebook and Plurk. In other words, when someone posts message, it will publish the message the Facebook page and Plurk.

## Demonstration
Please visit this link: [bigsu-life](https://peter279k.com/bigsu-life)

## Usage
This application is based on [Slim2](http://docs.slimframework.com/) (a PHP framework) and it's an open source project on Github.

We provide some approaches that can help you to deploy this project. If you don't have your own server, you can see OpenShift section and I will teach you how to build your own service on OpenShift (using "Free plan"). I also provide Heroku section to let you deploy your own service on Heroku (using "Free plan").

If you have your own server, you can see VPS and Shared hosting section.

I hope you will deploy easily and happily enjoy my service!

****Note: if you have any problems, you should create [issue](https://github.com/peter279k/publisher-system/issue) on this project. 

### Step 1: Create a Facebook page
  + [Please click here to create a new Facebook page](https://www.facebook.com/pages/create/), and select appropriate page type, fill in description and other required fields.
  + In your new Facebook page, switch to `About` tab and scroll down to the bottom of the page then note down the `Facebook Page ID`. You will use the role and previlege of this Facebook page to post messages on this page's wall.

### Step 2: Create Facebook App
  + If you are not a Facebook developer, [plrase click here to register as a developer](http://developers.facebook.com) (You have to verify through mobile.)
  + Go to [Facebook Apps dashboard](https://developers.facebook.com/apps) → Click `Add a New App` → Choose platform of `Website`  Choose a name for your application → Click `Create New Facebook App ID` → Choose Category → Click `Create App ID`
  + Go back to [Apps dashboard](https://developers.facebook.com/apps) → Select your new application → `Settings` → `Basic` → Enter `Contact Email` → `Save`
  + Go to `Status & Review` → `Do you want to make this app and all its live features available to the general public?` toggle the button to `Yes` → `Make App Public?`, click `Yes`
  +  Go back to `Dashboard`, note down `App ID` and `App Secret` (You have to click `Show` next to the field; it will ask you to enter your Facebook password.)

### Step 3: Obtain your page access token
  + Go to [Graph API Explorer](https://developers.facebook.com/tools/explorer/) → In the Application drop-down menu, select the name of your app which created in Step 2 → Click `Get Token` to open drop-down menu and select `Get User Access Token` → In Permissions popup menu, checked `manage_pages`, `publish_actions` and `publish_pages` → Click `Get Access Token`

  + Note down the `short-lived token` which shows in the input field next to the Access Token label.

  + Next, we are going to convert short-lived access token to a long-lived token. Please fill in the corresponding values to the following URL and open this URL in a browser:
```
https://graph.facebook.com/oauth/access_token?
  client_id={APP_ID}&
  client_secret={APP_SECRET}&
  fb_exchange_token={SHORTLIVED_ACCESS_TOKEN}&
  grant_type=fb_exchange_token
```

  + You will see `access_token={...}`. This new access_token is the `long-lived token`, next, we are going to use it to get the page access token which will never expire in the future.

  + Go to [Graph API Explorer](https://developers.facebook.com/tools/explorer/) → Paste the `long-lived token` into the Access Token input field → Type `me/accounts` in the `Graph API` query input field → Click `Submit` button → You will see the information of all your pages, find the Facebook page created in Step 1 and note down the `access_token` of it.

  + According to [Facebook's documentation](https://developers.facebook.com/docs/facebook-login/access-tokens#extendingpagetokens), a page access token obtained from long-lived user token will never expire in the future.

## Deployment
  In this section, we will present some approaches about building the service. 
### Step 4: Register an OpenShift account and deploy Publisher Application on it
  + Log in account and go to the applications web console.
  + Click Add Application button and you will see lots of services that can choose.
  + You will see the PHP section and click the see all link. You can look at this picture.
  ![Alt text](https://i.imgur.com/tcw0vv7.png)
  + Drop down the web page and you will find the application named "PHP5.5-cgi-Apache".
  + Click this application and fill the Public URL field then you can click Create Application button.
  + You have to visit the Public URL which you fill. You have to close this web page until the compiling successfully.
  + When compiling successfully, you will see the web page that present the result of executing phpinfo() function.
  + You can visit this link: [Generating a new SSH key](https://help.github.com/articles/generating-a-new-ssh-key-and-adding-it-to-the-ssh-agent/#generating-a-new-ssh-key) and refer the "Generating a new SSH key" section.
  + Note! If you use Windows, you have to download [Git for Windows](https://git-scm.com/download/win). It can help you successfully create ssh-key. If you use Unix-based operating system, you will easily generate ssh-key and you can skip the Step5.

### Step5: Generating ssh key
  + This step is for Windows user.
  + Before generating ssh-key, you have already the Git for Windows. If not, you have to go back to step4 and find the download link then install it. When installing Git for Windows, using the default settings during installation.
  + Go back to the Windows Desktop and click the right mouse button. You will see the "Git Bash Here" then click it.
  + You will see a bash shell then you can follow the "Generating a new SSH key" link step to create key successfully.
  + When creating ssh key successfully, you have to check this folder: ```C:\Users\your-user-name\.ssh```. In this folder, you will find the public key file ```named id_rsa.pub``` and you can use NotePad++ or other edit editors to open it. Note down the public key.

### Step6: Add New key
  + Go back to the OpenShift web console and click Settings tab.
  + Click "Add a new Key..." button and fill the fields. You have to note that you have to paste your public key in the second field.
  + Click create button.
  + Click Applications tab and click your application name which you create.
  + In this web page, you have to see the text: "Source Code". You will find the command: ```ssh://your-user-name@your-public-url/~/git/your-repo-name.git/```. You can refer following picture:
  ![Alt text](https://i.imgur.com/DOExrP5.png)
  + Go back to Desktop. If you use Windows, you can open the git-bash. If you use Unix-based operating system, you have to install Git package. For instance, I use Ubuntu so I open teriminal and input the command: ```sudo apt-get install git-core```
  + Input the command:```git clone ssh://your-user-name@your-public-url/~/git/your-repo-name.git/```.
  + Check out the repo, you have to copy this publisher system repo to "your-repo-name" repo.
  + Check out the file path: /path/to/your-repo-name/.openshift/action_hooks and create the file name: post_deploy.
  + Input the following contents in post_deploy file.
  
  ```bash
  #!/bin/bash
  #Prerequisites
  #Firstly, you have to upload composer.phar via sftp or scp command to the ~/app-root/runtime/bin

  cp ~/app-root/runtime/bin/composer.phar ~/app-root/repo/www/composer.phar

  cd ~/app-root/repo/www

  ~/app-root/runtime/bin/php composer.phar install
  ```
  
  + Open git-bash (Windows) or terminal (Unix-based) and input the command: ```git add .```
  + Input the command: ```ssh your-username@your-name-uploadspace.rhcloud.com```
  + Using scp command to copy the composer.phar to this file path: ~/app-root/runtime/bin
  + See the next Step7: Settings then go back to this step 
  + Input command: ```git commit -a ``` and input the contents: ```Initial commit.```
  + Input the command: ```git push``` then done.

### Step7: Simple settings
  + Before pushing the project to the repos, It's important for you to edit the setting.php file. you can find the file in this path: /path/to/publisher-system/settings/setting.php
  + Using text editor to edit setting.php file and you can find the following code:
  
  ```PHP
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
  ```
  
  + Replace the your-page-access-token, your-facebook-app-id,your-facebook-app-secret,your-facebook-page-id,your-Plurk-account-name,your-Plurk-password and your-Plurk-user-id with your correct values.
  + You can also customize the texts. For example, you can change the start_title to your title.
  + If you want to know more about customization, you can fill the Plurk key and Facebook key firstly and deploy project to your testing development.
  
# Other Information
  + If you want to have more informations, please check out the [wiki page](https://github.com/peter279k/publisher-system/wiki). There are many informations about deployment,customization and configuration.

# License
  MIT
