<?php
	require "LIB_http.php";
	class curl_helper {
		public function __construct($data, $action) {
			$this -> data = $data;
			$this -> action = $action;
		}
		
		public function post_feed() {
			//post feed for Facebook
			$facebook_ch = http($this -> action, $ref = "", $method = "POST", $this -> data, EXCL_HEAD);
			
			return $facebook_ch;
		}
		
		public function post_feed_upload() {
			//post feed with uploading the text image for Facebook
			$facebook_ch = upload_file($this -> action, $this -> data);
			
			return $facebook_ch;
		}
		
		public function post_plurk_feed() {
			//post feed for Plurk
			$ch = $this -> plurk_login();
			
			curl_setopt($ch, CURLOPT_URL, $this -> action);
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
			curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 0);
			curl_setopt($ch, CURLOPT_POSTFIELDS, $this -> data);
			
			return $ch;
		}
		
		public function post_plurk_upload() {
			//post feed with uploading the text image for Plurk
			$ch = $this -> plurk_login();
			
			curl_setopt($ch, CURLOPT_URL, $this -> action);
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
			curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 0);
			curl_setopt($ch, CURLOPT_POSTFIELDS, $this -> data);
			
			$response = curl_exec($ch);
			curl_close($ch);
			
			return json_decode($response, true);
		}
		
		private function plurk_login() {
			// Generating cookie is to remember session after logging plurk successfully
			$ch = curl_init();
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
			curl_setopt($ch, CURLOPT_COOKIEJAR, './cookie.txt');
			curl_setopt($ch, CURLOPT_COOKIEFILE, './cookie.txt');

			curl_setopt($ch, CURLOPT_URL, 'http://www.plurk.com/Users/login');
			curl_setopt($ch, CURLOPT_POSTFIELDS, 'nick_name='.PLURK_NAME.'&password='.urlencode(PLURK_PASS).'&logintoken=1');
			curl_exec($ch);
			
			return $ch;
		}
		
		public function curl_multi_req($ch1, $ch2) {
			//create the multiple cURL handle
			$response = array();
			$mh = curl_multi_init();

			//add the two handles
			curl_multi_add_handle($mh, $ch1);
			curl_multi_add_handle($mh, $ch2);

			$active = null;
			//execute the handles
			do {
				$mrc = curl_multi_exec($mh, $active);
				
			} while($mrc == CURLM_CALL_MULTI_PERFORM);

			while ($active && $mrc == CURLM_OK) {
				if (curl_multi_select($mh) == -1) {
					usleep(100);
				}
				
				do {
					$mrc = curl_multi_exec($mh, $active);
				} while ($mrc == CURLM_CALL_MULTI_PERFORM);
			}
			
			$response["fb-response"] = curl_multi_getcontent($ch1);
			$response["plurk-response"] = curl_multi_getcontent($ch2);

			//close the handles
			curl_multi_remove_handle($mh, $ch1);
			curl_multi_remove_handle($mh, $ch2);
			curl_multi_close($mh);
			
			return $response;
		}
	}
?>