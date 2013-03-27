<?php

	# THIS IS NOWHERE CLOSE TO BEING COMPLETE
	# (20130327/straup)

	loadlib("api_oauth_onedotfive_access_tokens");
	loadlib("oauth_onedotfive");

	#################################################################

	function api_auth_oauth_onedotfive_has_auth(&$method, $key_row){

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

		$user = users_get_by_id($token_row['user_id']);

		if ((! $user) || ($user['deleted'])){
			return array('ok' => 0, 'error' => 'Not a valid user', 'error_code' => 400);
		}

		return array(
			'ok' => 1,
			'access_token' => $token_row,
			'api_key' => $key_row,
			'user' => $user,
		);
	}

	#################################################################

	# the end
