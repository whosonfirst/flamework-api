<?php

	# This is still wet-paint. Specifically it is designed to be used as a way
	# to generate "site tokens" for logged-out users with some minimal amount
	# of scoping such that logging and throttling is at least possible if not
	# perfect. As of this writing it still requires figuring out how to convert
	# a fingerprint (below) in to a non-zero user ID as expected by the rest
	# of the code. (20160229/thisisaaronland)

	# Also, browser fingerprinting is basically creepy. So don't do that...
	# 
        # https://w3c.github.io/fingerprinting-guidance/
        # https://github.com/Valve/fingerprintjs2

	########################################################################

	function fingerprint_generate(){

		$defaults = array(
			'Remote-Addr' => 'REMOTE_ADDR',
		);

		$extras	= array_merge($defaults, $extras);

		$headers = apache_request_headers();

		foreach ($extras as $k => $v){
			$headers[$k] = $_SERVER[$v];
		}

		ksort($headers);

		$fp_secret = $GLOBALS['crypto_fingerprint_secret'];

		$fp = json_encode($headers);
		$fp = hash_hmac('sha256', $fp, $fp_secret);

		return $fp;
	}

	########################################################################

	# the end
