<?php

	# THIS IS NOWHERE CLOSE TO BEING COMPLETE
	# (20130327/straup)

	loadlib("api_oauth_onedotfive_access_tokens");
	loadlib("oauth_onedotfive");

	#################################################################

	function api_auth_oauth_onedotfive_has_auth(&$method, $key_row){

		$user_row = null;
		$token_row = null;

		$requires_signature = (isset($method['requires_signature'])) ? 1 : 0;

		if ($method['requires_auth']){

			$requires_signature = 1;

			$access_token = post_str("access_token");

			if (! $access_token){
				return array('ok' => 0, 'error' => 'Missing access token');
			}

			$token_row = api_oauth_onedotfive_access_tokens_get_by_token($access_token);

			if (! $token_row){
				return array('ok' => 0, 'error' => 'Invalid access token', 'error_code' => 400);
			}
		
			if (($token_row['expires']) && ($token_row['expires'] < time())){
				return array('ok' => 0, 'error' => 'Invalid access token', 'error_code' => 400);
			}

			if (isset($method['requires_perms'])){

				if ($token_row['perms'] < $method['requires_perms']){
					return array('ok' => 0, 'error' => 'Insufficient permissions', 'error_code' => 403);
				}
			}

			$user_row = users_get_by_id($token_row['user_id']);

			if ((! $user_row) || ($user_row['deleted'])){
				return array('ok' => 0, 'error' => 'Not a valid user', 'error_code' => 400);
			}
		}

		if ($requires_signature){

			$request_sig = request_str("api_sig");

			if (! $request_sig){
				return array('ok' => 0, 'error' => 'Missing API signature', 'error_code' => 400);
			}

			$request = $_REQUEST;
			
			$app_secret = $key_row['app_secret'];
			$user_secret = ($token_row) ? $token_row['token_secret'] : null;

			$test_sig = oauth_onedotfive_sign_request($req, $app_secret, $user_secret);

			if (! oauth_onedotfive_compare_signature($request_sig, $test_sig)){
				return array('ok' => 0, 'error' => 'Invalid signature', 'error_code' => 999);
			}
		}

		# Optional: check timestamps

		# Optional: check nonces

		return array(
			'ok' => 1,
			'access_token' => $token_row,
			'api_key' => $key_row,
			'user' => $user_row,
		);
	}

	#################################################################

	# the end
