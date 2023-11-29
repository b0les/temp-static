<?php

/**
 * AntiDDOS System
 * FILE: index.php
 * By Sanix Darker
 */
function safe_print($value)
{
	$value .= "";
	return strlen($value) > 1 && (strpos($value, "0") !== false) ? ltrim($value, "0") : (strlen($value) == 0 ? "0" : $value);
}
if (!isset($_SESSION)) {
	session_start();
}
if (isset($_SESSION['standby'])) {

	// There is all your configuration
	$_SESSION['standby'] = $_SESSION['standby'] + 1;

	$ad_ddos_query = 5; // ​​number of requests per second to detect DDOS attacks
	$ad_check_file = 'check.txt'; // file to write the current state during the monitoring
	$ad_all_file = 'all_ip.txt'; // temporary file
	$ad_black_file = 'black_ip.txt'; // will be entered into a zombie machine ip
	$ad_white_file = 'white_ip.txt'; // ip logged visitors
	$ad_temp_file = 'ad_temp_file.txt'; // ip logged visitors
	$ad_dir = 'anti_ddos/files'; // directory with scripts
	$ad_num_query = 0; // ​​current number of requests per second from a file $check_file
	$ad_sec_query = 0; // ​​second from a file $check_file
	$ad_end_defense = 0; // ​​end while protecting the file $check_file
	$ad_sec = date("s"); // current second
	$ad_date = date("is"); // current time
	$ad_defense_time = 100; // ddos ​​attack detection time in seconds at which stops monitoring


	$config_status = "";
	function Create_File($the_path, $ad)
	{
		if (!file_exists($ad)) mkdir($ad, 0755, true);
		$handle = fopen($the_path, 'a+') or die('Cannot create file:  ' . $the_path);
		return "Creating " . $the_path . " .... done";
	}


	// Checking if all files exist before launching the cheking
	$config_status .= (!file_exists("{$ad_dir}/{$ad_check_file}")) ? Create_File("{$ad_dir}/{$ad_check_file}", $ad_dir) : "ERROR: Creating " . "{$ad_dir}/{$ad_check_file}<br>";
	$config_status .= (!file_exists("{$ad_dir}/{$ad_temp_file}")) ? Create_File("{$ad_dir}/{$ad_temp_file}", $ad_dir) : "ERROR: Creating " . "{$ad_dir}/{$ad_temp_file}<br>";
	$config_status .= (!file_exists("{$ad_dir}/{$ad_black_file}")) ? Create_File("{$ad_dir}/{$ad_black_file}", $ad_dir) : "ERROR: Creating " . "{$ad_dir}/{$ad_black_file}<br>";
	$config_status .= (!file_exists("{$ad_dir}/{$ad_white_file}")) ? Create_File("{$ad_dir}/{$ad_white_file}", $ad_dir) : "ERROR: Creating " . "{$ad_dir}/{$ad_white_file}<br>";
	$config_status .= (!file_exists("{$ad_dir}/{$ad_all_file}")) ? Create_File("{$ad_dir}/{$ad_all_file}", $ad_dir) : "ERROR: Creating " . "{$ad_dir}/{$ad_all_file}<br>";

	if (!file_exists("{$ad_dir}/../anti_ddos.php")) {
		$config_status .= "anti_ddos.php doesn't exist!";
	}

	if (
		!file_exists("{$ad_dir}/{$ad_check_file}") or
		!file_exists("{$ad_dir}/{$ad_temp_file}") or
		!file_exists("{$ad_dir}/{$ad_black_file}") or
		!file_exists("{$ad_dir}/{$ad_white_file}") or
		!file_exists("{$ad_dir}/{$ad_all_file}") or
		!file_exists("{$ad_dir}/../anti_ddos.php")
	) {

		$config_status .= "Some files doesn't exist!";
		die($config_status);
	}

	// TO verify the session start or not
	require("{$ad_dir}/{$ad_check_file}");

	if ($ad_end_defense and $ad_end_defense > $ad_date) {
		require("{$ad_dir}/../anti_ddos.php");
	} else {
		$ad_num_query = ($ad_sec == $ad_sec_query) ? $ad_num_query++ : '1 ';
		$ad_file = fopen("{$ad_dir}/{$ad_check_file}", "w");

		$ad_string = ($ad_num_query >= $ad_ddos_query) ? '<?php $ad_end_defense=' . safe_print($ad_date + $ad_defense_time) . '; ?>' : '<?php $ad_num_query=' . safe_print($ad_num_query) . '; $ad_sec_query=' . safe_print($ad_sec) . '; ?>';

		fputs($ad_file, $ad_string);
		fclose($ad_file);
	}
} else {

	$_SESSION['standby'] = 1;

	$actual_link = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
	header("Refresh: 5, " . $actual_link);
?>
	

	<!DOCTYPE html>
<html lang="en" >
<head>
  <meta charset="UTF-8">
  <title>Aspect Systems - Checking</title>
  <link rel="stylesheet" href="../style.css">

</head>
<body>
<div id="main-loader">
      <div class="loader-parent">
        <div class="loader-left">
          <div class="cnt1">
            <div class="cnt2">
              <!-- The loader -->
            
              
              <div id="loader">
                <svg height="200" viewBox="0 0 40 60" width="200">
                  <polygon
                    class="triangle"
                    fill="none"
                    points="16,1 32,32 1,32"
                    stroke="#fff"
                    stroke-width="1"
                  ></polygon>
                  <text class="loading" fill="#fff" x="0" y="45">
                    &nbsp;&nbspLoading
                  </text>
                </svg>
              </div>
              <!-- The loader -->
            </div>
          </div>
        </div>
        <div class="loader-right">
          <div class="cnt1">
            <div class="cnt2">
              <div class="loader-hints">
                <div class="hints">
                  <div class="hint-title">
                    <h3>Hints</h3>
                  </div>
                  <div class="hint-description">
                    <p class="hint-text">
                      In stack-based buffer overflow attacks, attacker places data in the memory buffer of the target system 
					  that exceeds the buffer's boundaries.
					  This excessive writing allows the attacker to gain control over the target system.
                    </p>

                    <p class="hint-text">
                      To avoid SQL injections, utilize prepared statements or parameterized queries with placeholders to separate SQL code from user input. 
					  This helps ensuring that user input is treated as data and not an executable code.
                    </p>

                    <p class="hint-text">
                      Always implement CAPTCHA to verify that the user is human and not an automated bot.
					  This adds an extra layer of security to avoid getting brute force attacks 
					  by requiring users to solve a challenge before submitting the form.
                    </p>

                    <p class="hint-text">
                      Always do server-side checks to ensure that only allowed file types and extensions are accepted. 
					  This prevents attackers from tampering to upload webshells or malicious files with fake extensions.
                    </p>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
<!-- partial -->
  <script src='https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.min.js'></script><script  src="../script.js"></script>
</body>
</html>

<?php exit();
}
?>