<?php

	# THIS IS NOWHERE CLOSE TO BEING COMPLETE
	# (20130327/straup)

	#################################################################

	function oauth_onedotfive_sign_request($args, $app_secret, $user_secret=null){

		# lower case all the args?

		ksort($args);

		$sig = http_build_query($args);

		$sig = hash_hmac('sha512', $sig, $app_secret, true);

		if ($user_secret){
			$sig = hash_hmac('sha512', $sig, $user_secret, true);
		}

		$enc = base64_encode($sig);
		return $enc;
	}

	#################################################################

	function oauth_onedotfive_generate_timestamp(){
		return time();
	}

	#################################################################

	function oauth_onedotfive_generate_nonce(){
		$mt = microtime();
		$rand = mt_rand();
		return md5($mt . $rand); // md5s look nicer than numbers
	}

	#################################################################

	function oauth_onedotfive_compare_signature($this_sig, $that_sig){

		if ((! is_string($this_sig)) || (! is_string($this_sig))){
			return false;
		}

		$this_len = strlen($this_sig);
		$that_len = strlen($that_sig);

		if ((! $this_len) || (! $that_len)){
			return false;
		}

		if ($this_len !== $that_len){
			return false;
		}

		$match = true;

		# No timing attacks for you

		for ($i = 0; $i < $this_len; $i++){
			$match = $match && ((ord($this_sig[$i]) ^ ord($that_sig[$i])) === 0); 
        	}

		return $match;
	}

	#################################################################

	# the end
