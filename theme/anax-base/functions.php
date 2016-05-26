<?php
/**
 * Theme related functions.
 *
 */

/**
 * Get title for the webpage by concatenating page specific title with site-wide title.
 *
 * @param string $title for this page.
 * @param string $titleAppend a general title to append.
 * @return string/null wether the favicon is defined or not.
 */
/*function get_title($title, $titleAppend = null) {
  return $title . $title_append;
}
*/

function getTimeAgo($timestamp) {
	$date = date("Y-m-d H:i:s", $timestamp);
	$timeAgo = new TimeAgo();
	$time =  $timeAgo->inWords($date);

	return $time;
}

function getLocation($ip) {
	$location = json_decode(file_get_contents('http://freegeoip.net/json/' . $ip));
 	
 	return $location->city . ", " . $location->country_name;
}

function get_gravatar($email, $size=null) {
  return 'http://www.gravatar.com/avatar/' . md5(strtolower(trim($email))) . '.jpg?' . ($size ? "s=$size" : null);
}