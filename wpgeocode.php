<?php
/*
Plugin Name: WP Geocode
Plugin URI: http://www.wpgeocode.com
Tags: geocode, geotagging, geolocation, geotags, latitude, longitude, city, state, geomarketing, geolocation marketing
Description: Use WPGeocode to customize the content of your blog based on the location of your readers. 
Version: 1.0.13
Author: Michael Lynn
Author URI: http://www.mlynn.org/
*/


if ( ! defined( 'ABSPATH' ) )
        die( "Can't load this file directly" ); 

register_activation_hook(__FILE__, 'wpgc_add_defaults');
register_uninstall_hook(__FILE__, 'wpgc_delete_plugin_options');

add_action('admin_init', 'wpgc_init' );
add_action('admin_menu', 'wpgc_add_options_page');

class logfile{
	// used for writing logs for debugging.  touch error.log; chmod 777 error.log
	function write($the_string ) {
		$fp = @fopen(WP_PLUGIN_DIR."/wpgeocode/error.log", 'a');
		if( $fp ) {
			fputs( $fp, $the_string, strlen($the_string) );
			fclose( $fp );
			return( true );
		} else {
			return( false );
		}
	}
}
$log = new logfile();
//$log->write("test");

function wpgc_shortcode_country_flag($atts, $content="") {
	return do_shortcode(wpgc_conditional_shortcode($atts,$content,'country_flag'));
}
function wpgc_country_list($atts, $content="") {
	return wpgc_list_all_countries();
}
function wpgc_shortcode_env($atts, $content="") {
	return do_shortcode(wpgc_conditional_shortcode($atts, $content, 'env'));
}
function wpgc_shortcode_database_date($atts, $content="") {
	return do_shortcode(wpgc_conditional_shortcode($atts, $content, 'database_date'));
}
function wpgc_shortcode_distance_kilometers($atts, $content="") {
	return do_shortcode(wpgc_conditional_shortcode($atts, $content, 'distance_kilometers'));
}
function wpgc_shortcode_distance_miles($atts, $content="") {
	return do_shortcode(wpgc_conditional_shortcode($atts, $content, 'distance_miles'));
}
function wpgc_shortcode_city($atts, $content="") {
	return do_shortcode(wpgc_conditional_shortcode($atts, $content, 'city'));
}
function wpgc_shortcode_postal_code($atts, $content="") {
	return do_shortcode(wpgc_conditional_shortcode($atts, $content, 'postal_code'));
}
function wpgc_shortcode_longitude($atts, $content="") {
	return do_shortcode(wpgc_conditional_shortcode($atts, $content, 'longitude'));
}
function wpgc_shortcode_latitude($atts, $content="") {
	return do_shortcode(wpgc_conditional_shortcode($atts, $content, 'latitude'));
}
function wpgc_shortcode_ip($atts, $content="") {
	return do_shortcode(wpgc_conditional_shortcode($atts, $content, 'ip'));
}
function wpgc_shortcode_country_name($atts, $content="") {
	return do_shortcode(wpgc_conditional_shortcode($atts, $content, 'country_name'));
}
function wpgc_shortcode_country_code($atts, $content="") {
	return do_shortcode(wpgc_conditional_shortcode($atts, $content, 'country_code'));
}
function wpgc_shortcode_state_code($atts, $content="") {
	return do_shortcode(wpgc_conditional_shortcode($atts, $content, 'state_code'));
}
function wpgc_shortcode_state_name($atts, $content="") {
	return do_shortcode(wpgc_conditional_shortcode($atts, $content, 'state_name'));
}
function wpgc_options_nearby_range($atts, $content="") {
        $options = get_option('wpgc_options');
	return $options['txt_nearby_range'];
}
function wpgc_is_not_ip($atts, $content="") {
	return do_shortcode(wpgc_conditional_shortcode($atts, $content, 'is_not_ip'));
}
function wpgc_is_not_ips($atts, $content="") {
	return do_shortcode(wpgc_conditional_shortcode($atts, $content, 'is_not_ips'));
}
function wpgc_is_not_country_code($atts, $content="") {
	return do_shortcode(wpgc_conditional_shortcode($atts, $content, 'is_not_country_code'));
}
function wpgc_is_not_country_codes($atts, $content="") {
	return do_shortcode(wpgc_conditional_shortcode($atts, $content, 'is_not_country_codes'));
}
function wpgc_is_not_country_name($atts, $content="") {
	return do_shortcode(wpgc_conditional_shortcode($atts, $content, 'is_not_country_name'));
}
function wpgc_is_not_country_names($atts, $content="") {
	return do_shortcode(wpgc_conditional_shortcode($atts, $content, 'is_not_country_names'));
}
function wpgc_is_not_state_codes($atts, $content="") {
	return do_shortcode(wpgc_conditional_shortcode($atts, $content, 'is_not_state_codes'));
}
function wpgc_is_not_state_code($atts, $content="") {
	return do_shortcode(wpgc_conditional_shortcode($atts, $content, 'is_not_state_code'));
}
function wpgc_is_not_state_name($atts, $content="") {
	return do_shortcode(wpgc_conditional_shortcode($atts, $content, 'is_not_state_name'));
}
function wpgc_is_not_postal_codes($atts, $content="") {
	return do_shortcode(wpgc_conditional_shortcode($atts, $content, 'is_not_postal_codes'));
}
function wpgc_is_not_postal_code($atts, $content="") {
	return do_shortcode(wpgc_conditional_shortcode($atts, $content, 'is_not_postal_code'));
}
function wpgc_is_not_city($atts, $content="") {
	return do_shortcode(wpgc_conditional_shortcode($atts, $content, 'is_not_city'));
}
function wpgc_is_not_cities($atts, $content="") {
	return do_shortcode(wpgc_conditional_shortcode($atts, $content, 'is_not_cities'));
}
function wpgc_is_not_city_and_state($atts, $content="") {
	return do_shortcode(wpgc_conditional_shortcode($atts, $content, 'is_not_city_and_state'));
}
function wpgc_is_ip($atts, $content="") {
	return do_shortcode(wpgc_conditional_shortcode($atts, $content, 'is_ip'));
}
function wpgc_is_ips($atts, $content="") {
	return do_shortcode(wpgc_conditional_shortcode($atts, $content, 'is_ips'));
}
function wpgc_is_country_code($atts, $content="") {
	return do_shortcode(wpgc_conditional_shortcode($atts, $content, 'is_country_code'));
}
function wpgc_is_country_codes($atts, $content="") {
	return do_shortcode(wpgc_conditional_shortcode($atts, $content, 'is_country_codes'));
}
function wpgc_is_country_name($atts, $content="") {
	return do_shortcode(wpgc_conditional_shortcode($atts, $content, 'is_country_name'));
}
function wpgc_is_country_names($atts, $content="") {
	return do_shortcode(wpgc_conditional_shortcode($atts, $content, 'is_country_names'));
}
function wpgc_is_state_codes($atts, $content="") {
	return do_shortcode(wpgc_conditional_shortcode($atts, $content, 'is_state_codes'));
}
function wpgc_is_state_code($atts, $content="") {
	return do_shortcode(wpgc_conditional_shortcode($atts, $content, 'is_state_code'));
}
function wpgc_is_state_name($atts, $content="") {
	return do_shortcode(wpgc_conditional_shortcode($atts, $content, 'is_state_name'));
}
function wpgc_is_postal_codes($atts, $content="") {
	return do_shortcode(wpgc_conditional_shortcode($atts, $content, 'is_postal_codes'));
}
function wpgc_is_postal_code($atts, $content="") {
	return do_shortcode(wpgc_conditional_shortcode($atts, $content, 'is_postal_code'));
}
function wpgc_is_city($atts, $content="") {
	return do_shortcode(wpgc_conditional_shortcode($atts, $content, 'is_city'));
}
function wpgc_is_cities($atts, $content="") {
	return do_shortcode(wpgc_conditional_shortcode($atts, $content, 'is_cities'));
}
function wpgc_is_city_and_state_code($atts, $content="") {
	return do_shortcode(wpgc_conditional_shortcode($atts, $content, 'is_city_and_state_code'));
}
function wpgc_is_nearby($atts, $content="") {
	return do_shortcode(wpgc_conditional_shortcode($atts, $content, 'is_nearby'));
}
function wpgc_is_not_nearby($atts, $content="") {
	return do_shortcode(wpgc_conditional_shortcode($atts, $content, 'is_not_nearby'));
}
function wpgc_is_within($atts, $content="") {
	return do_shortcode(wpgc_conditional_shortcode($atts, $content, 'is_within'));
}
function wpgc_is_not_within($atts, $content="") {
	return do_shortcode(wpgc_conditional_shortcode($atts, $content, 'is_not_within'));
}
function wpgc_conditional_shortcode($atts, $content, $condition) {
	$options = get_option('wpgc_options');
	extract(shortcode_atts(array(
                'longitude' => '',
                'latitude' => '',
                'ip' => '',
                'ips' => '',
                'country_name' => '',
                'country_names' => '',
                'country_code' => '',
                'country_codes' => '',
                'state_name' => '',
                'state_code' => '',
                'state_codes' => '',
                'postal_code' => '',
                'postal_codes' => '',
                'cities' => '',
                'city' => '',
                'height' => '',
                'width' => '',
                'miles' => '',
		'kilometers' => ''
        ), $atts));
        $user_ip = wpgc_get_ip_address();
        $loc_arr = wpgc_get_location_info($user_ip);
        if ($user_ip=='' || $loc_arr == FALSE) {
                $user_latitude = '';
                $user_longitude = '';
                $user_state_code = '';
                $user_state_name = '';
                $user_postal_code = '';
                $user_city = '';
                $user_country_name = '';
                $user_country_code = '';
        } else {
                $user_latitude = $loc_arr['latitude'];
                $user_longitude = $loc_arr['longitude'];
                $user_state_code = $loc_arr['state_code'];
                $user_state_name = $loc_arr['state_name'];
                $user_postal_code = $loc_arr['postal_code'];
                $user_city = $loc_arr['city_name'];
                $user_country_name = $loc_arr['country_name'];
                $user_country_code = $loc_arr['country_code'];
        }
	switch( $condition ) {
		case 'env':
			return implode('<br>',$_ENV);
			break;
		case 'database_date' :
			$database=WP_PLUGIN_DIR.'/wpgeocode/database/GeoLiteCity.dat';
			if (is_file($database)) {
				if ($options['chk_enable_plugin']) {
					$dbdate=date($options['sel_date_format'], @filemtime("$database"));
				}
			}
			return $dbdate;
			break;
		case 'city' :
			return wpgc_case_convert($user_city,$options['rdo_case'],$options['txt_filter_cls']);
			break;
		case 'latitude' :
			return wpgc_case_convert($user_latitude,$options['rdo_case'],$options['txt_filter_cls']);
			break;
		case 'longitude' :
			return wpgc_case_convert($user_longitude,$options['rdo_case'],$options['txt_filter_cls']);
			break;
		case 'ip' :
			return wpgc_case_convert($user_ip,$options['rdo_case'],$options['txt_filter_cls']);
			break;
		case 'country_name' :
			return wpgc_case_convert($user_country_name,$options['rdo_case'],$options['txt_filter_cls']);
			break;
		case 'country_code' :
			return wpgc_case_convert($user_country_code,$options['rdo_case'],$options['txt_filter_cls']);
			break;
		case 'state_code' :
			return wpgc_case_convert($user_state_code,$options['rdo_case'],$options['txt_filter_cls']);
			break;				
		case 'state_name' :
			return wpgc_case_convert($user_state_name,$options['rdo_case'],$options['txt_filter_cls']);
			break;
		case 'postal_code' :
			return wpgc_case_convert($user_postal_code,$options['rdo_case'],$options['txt_filter_cls']);
			break;
		case 'distance_miles':
			if ($options['txt_home_latitude'] && $options['txt_home_longitude']) {
				$user_distance_miles=distance($user_latitude,$user_longitude,$options['txt_home_latitude'],$options['txt_home_longitude'],TRUE);
			} else {
				$user_distance_miles=$options['txt_def_distance_miles'];
			}
			return $user_distance_miles;
			break;
		case 'distance_kilometers':
			if ($options['txt_home_latitude'] && $options['txt_home_longitude']) {
				$user_distance_kilometers=distance($user_latitude,$user_longitude,$options['txt_home_latitude'],$options['txt_home_longitude'],FALSE);
			} else {
				$user_distance_kilometers=$options['txt_def_distance_kilometers'];
			}
			return $user_distance_kilometers;
			break;
		case 'is_not_nearby':
			if (!$options['txt_home_latitude'] && !$options['txt_home_longitude'] && !$latitude && !$longitude) {
					return; // don't return content if we haven't specified our home base
			}
			if ($latitude && longitude) {
				$compare_lat=$latitude;
				$compare_lon=$longitude;
			} else {
				if ($options['txt_home_latitude'] && $options['txt_home_longitude']) {
					$compare_lat=$options['txt_home_latitude'];
					$compare_lon=$options['txt_home_longitude'];
				} else {
					return; // invalid
				}
			}
			if ($miles) {
				$distance=distance($user_latitude, $user_longitude, $compare_lat, $compare_lon, TRUE);
				if ($distance >= $miles) {
					return $content;
				}
			} else {
				if ($kilometers) {
					$distance=distance($user_latitude, $user_longitude, $compare_lat, $compare_lon, TRUE);
					if ($distance >= $options['txt_nearby_range']) {
						return $content;
					}
				}
			}
			break;
		case 'is_nearby':
// will assume home lat and lon if no lat and lon are specified in the shortcode atts
			if (!$options['txt_home_latitude'] && !$options['txt_home_longitude'] && !$latitude && !$longitude) {
					return; // don't return content if we haven't specified our home base
			}
			if ($latitude && longitude) {
				$compare_lat=$latitude;
				$compare_lon=$longitude;
			} else {
				if ($options['txt_home_latitude'] && $options['txt_home_longitude']) {
					$compare_lat=$options['txt_home_latitude'];
					$compare_lon=$options['txt_home_longitude'];
				} else {
					return; // invalid
				}
			}
			if ($miles) {
				$distance=distance($user_latitude, $user_longitude, $compare_lat, $compare_lon, TRUE);
				if ($distance <= $miles) {
					return $content;
				}
			} else {
				if ($kilometers) {
					$distance=distance($user_latitude, $user_longitude, $compare_lat, $compare_lon, TRUE);
					if ($distance <= $options['txt_nearby_range']) {
						return $content;
					}
				}
			}
			break;
		case 'country_flag':
			$images_path= plugins_url( 'images' , __FILE__ );
			if ($atts['country']) {
				$country=strtolower($atts['country_code']);
			} else {
				$country=strtolower($user_country_code);
			}
			if ($atts['height'] || $atts['width']) {
				$img = "<img src='$images_path/flags/normal/" . $country  . ".png' height='".$atts['height']. "' width='". $atts['width'] ."'>";
			} else {
				if (!$options['txt_flag_height'] && !$options['txt_flag_width']) {
					$img = ".<img src='$images_path/flags/normal/" . strtolower($user_country_code) . ".png'>";
				} else {
					$img = "<img src='$images_path" . strtolower($user_country_code) . ".png'>";
				}
			}
			return $img;
			break;
		case 'is_within':
			if (!$options['txt_home_latitude'] && !$options['txt_home_longitude']) {
				return; // don't return content if we haven't specified our home base
			}
			if (!$miles && !$kilometers) {
				//return $content;
				// don't return content if we they haven't specified a distance.
			} else {
				if ($miles) {
					$distance=distance($user_latitude, $user_longitude, $options['txt_home_latitude'], $options['txt_home_longitude'], TRUE);
					if ($distance <= $miles) {
						return $content;
					}
				} else {
					$distance=distance($user_latitude, $user_longitude, $options['txt_home_latitude'], $options['txt_home_longitude'], FALSE);
					if ($distance <= $kilometers) {
						return $content;
					}
				}	
			}
			break;
		case 'is_not_cities':
			$is_not_city=wpgc_csv_find($cities,$loc_arr['city_name']);
			if ($is_not_city==false) {
				return $content;
			}
			break;
		case 'is_not_city':
			$is_not_city=wpgc_csv_find($city,$loc_arr['city_name']);
			if ($is_not_city==false) {
				return $content;
			}
			break;
		case 'is_not_state_code':
			if ($state_code!=$loc_arr['state_code']) {
				return $content;
			}
			break;
		case 'is_not_state_name':
			if ($state_code!=$loc_arr['state_name']) {
				return $content;
			}
			break;
		case 'is_not_state_codes':
			$found=wpgc_csv_find($states,$loc_arr['state_code']);
			if ($found==false) {
				return $content;
			}
		case 'is_not_postal_code':
			if ($postal_code!=$loc_arr['postal_code']) {
				return $content;
			}
			break;
		case 'is_not_postal_codes':
			$found=wpgc_csv_find($postals,$loc_arr['postal_code']);
			if ($found==false) {
				return $content;
			}
			break;
		case 'is_not_country_name':
			if ($country_name!=$loc_arr['country_name']) {
				return $content;
			}
			break;
		case 'is_not_country_names':
			$found=wpgc_csv_find($country_names,$loc_arr['country_name']);
			if ($found==false) {
				return $content;
			}
			break;
		case 'is_not_country_code':
			if ($country_code!=$loc_arr['country_code']) {
				return $content;
			}
			break;
		case 'is_not_country_codes':
			$found=wpgc_csv_find($country_codes,$loc_arr['country_code']);
			if ($found==false) {
				return $content;
			}
			break;
		case 'is_city_and_state_code':
			if ($city==$loc_arr['city_name'] && $state_code!=$loc_arr['state_code']) {
				return $content;
			}
			break;
		case 'is_city':
			if ($city==$loc_arr['city_name']) {
				return $content;
			}
			break;
		case 'is_cities':
			$found=wpgc_csv_find($cities,$loc_arr['city_name']);
			if ($found) {
				return $content;
			}
			break;
		case 'is_state_code':
			if ($state_code==$loc_arr['state_code']) {
				return $content;
			}
			break;
		case 'is_state_codes':
			$found=wpgc_csv_find($state_codes,$loc_arr['state_code']);
			if ($state_code==$loc_arr['state_code']) {
				return $content;
			}
		case 'is_postal_code':
			if ($postal_code==$loc_arr['state_code']) {
				return $content;
			}
			break;
		case 'is_postal_codes':
			$found=wpgc_csv_find($postal_codes,$loc_arr['postal_code']);
			if ($postal_code==$loc_arr['postal_code']) {
				return $content;
			}
			break;
		case 'is_country_name':
			if ($country_name==$loc_arr['country_name']) {
				return $content;
			}
			break;
		case 'is_country_names':
			$found=wpgc_csv_find($country_names,$loc_arr['country_name']);
			if ($found) {
				return $content;
			}
			break;
		case 'is_country_code':
			if ($country_code==$loc_arr['country_code']) {
				return $content;
			}
			break;
		case 'is_country_codes':
			$found=wpgc_csv_find($country_codes,$loc_arr['country_code']);
			if ($found) {
				return $content;
			}
			break;
		case 'is_ip':
			if ($ip==$user_ip) {
					return $content;
			}
			break;
		case 'is_ips':
			$found=wpgc_csv_find($ips,$user_ip);
			if ($found) {
				return $content;
			}
			break;
		case 'is_not_ip':
			if ($ip!=$user_ip) {
					return $content;
			}
			break;
		case 'is_not_ip':
			$found=wpgc_csv_find($ips,$user_ip);
			if ($found==false) {
					return $content;
			}
			break;
		default:
	}
}

add_shortcode("wpgc_country_list", "wpgc_country_list");
add_shortcode("wpgc_country_flag", "wpgc_shortcode_country_flag");
add_shortcode("wpgc_env", "wpgc_shortcode_env");
add_shortcode("wpgc_database_date", "wpgc_shortcode_database_date");
add_shortcode("wpgc_distance_kilometers", "wpgc_shortcode_distance_kilometers");
add_shortcode("wpgc_distance_miles", "wpgc_shortcode_distance_miles");
add_shortcode("wpgc_longitude", "wpgc_shortcode_longitude");
add_shortcode("wpgc_latitude", "wpgc_shortcode_latitude");
add_shortcode("wpgc_city", "wpgc_shortcode_city");
add_shortcode("wpgc_postal_code", "wpgc_shortcode_postal_code");
add_shortcode("wpgc_ip", "wpgc_shortcode_ip");
add_shortcode("wpgc_country_name", "wpgc_shortcode_country_name");
add_shortcode("wpgc_country_code", "wpgc_shortcode_country_code");
add_shortcode("wpgc_state_name", "wpgc_shortcode_state_name");
add_shortcode("wpgc_state_code", "wpgc_shortcode_state_code");
add_shortcode("wpgc_options_nearby_range", "wpgc_options_nearby_range");
add_shortcode("wpgc_is_city_and_state_code", "wpgc_is_city_and_state_code");
add_shortcode("wpgc_is_ip", "wpgc_is_ip");
add_shortcode("wpgc_is_ips", "wpgc_is_ips");
add_shortcode("wpgc_is_not_ip", "wpgc_is_not_ip");
add_shortcode("wpgc_is_not_ips", "wpgc_is_not_ips");
add_shortcode("wpgc_is_city", "wpgc_is_city");
add_shortcode("wpgc_is_cities", "wpgc_is_cities");
add_shortcode("wpgc_is_not_cities", "wpgc_is_not_cities");
add_shortcode("wpgc_is_not_city", "wpgc_is_not_city");
add_shortcode("wpgc_is_nearby", "wpgc_is_nearby");
add_shortcode("wpgc_is_not_nearby", "wpgc_is_not_nearby");
add_shortcode("wpgc_is_within", "wpgc_is_within");
add_shortcode("wpgc_is_country_name", "wpgc_is_country_name");
add_shortcode("wpgc_is_country_names", "wpgc_is_country_names");
add_shortcode("wpgc_is_country_code", "wpgc_is_country_code");
add_shortcode("wpgc_is_country_codes", "wpgc_is_country_codes");
add_shortcode("wpgc_is_state_code", "wpgc_is_state_code");
add_shortcode("wpgc_is_state_codes", "wpgc_is_state_codes");
add_shortcode("wpgc_is_postal_code", "wpgc_is_postal_code");
add_shortcode("wpgc_is_postal_codes", "wpgc_is_postal_codes");
add_shortcode("wpgc_is_not_postal_code", "wpgc_is_not_postal_code");
add_shortcode("wpgc_is_not_postal_codes", "wpgc_is_not_postal_codes");
add_shortcode("wpgc_is_not_country_name", "wpgc_is_not_country_name");
add_shortcode("wpgc_is_not_country_names", "wpgc_is_not_country_names");
add_shortcode("wpgc_is_not_country_code", "wpgc_is_not_country_code");
add_shortcode("wpgc_is_not_country_codes", "wpgc_is_not_country_codes");
add_shortcode("wpgc_is_not_state_code", "wpgc_is_not_state_code");
add_shortcode("wpgc_is_not_state_codes", "wpgc_is_not_state_codes");

// delete options table entries ONLY when plugin deactivated AND deleted
function wpgc_delete_plugin_options() {
	delete_option('wpgc_options');
}

// Define default option settings
function wpgc_add_defaults() {
    $tmp = get_option('wpgc_options');
    if(($tmp['chk_default_options_db']=='1')||(!is_array($tmp))) {
		delete_option('wpgc_options'); 
		$arr = array("sel_date_format" => 'D, M d Y H:i:s',"txt_def_distance_miles" => "A Lot of Miles","txt_def_distance_kilometers" => "A Lot of Kilometers","txt_def_home" => 'Your home or address', "txt_def_latitude" => 'Your Latitude', "txt_def_longitude" => 'Your Longitude', "txt_def_ip" => 'Your IP', "txt_def_city" => 'Your City', "txt_def_state_code" => 'Your State Code', "txt_def_country_code" => 'Your Country', "txt_def_country_name" => 'Your Country', "chk_post_content" => "1", "chk_comments" => "1", "txt_filter_cls" => "", "rdo_units" => "miles", "rdo_case" => "off", "chk_default_options_db" => "");
		update_option('wpgc_options', $arr);
	}
}

// Init plugin options to white list our options
function wpgc_init(){
	$tmp = get_option('wpgc_options');
	register_setting( 'wpgc_plugin_options', 'wpgc_options', 'wpgc_validate_options' );
}

// Add menu page
function wpgc_add_options_page() {
	add_options_page('WP Geocode Options Page', 'WP Geocode', 'manage_options', __FILE__, 'wpgc_render_form');
}

// Draw the menu page itself
function wpgc_render_form() {
	?>
	<?php settings_fields('wpgc_plugin_options'); ?>
	<?php $options = get_option('wpgc_options'); ?>
<script type="text/javascript">
    function toggleVisibility(hs,co) {
        var h = document.getElementById(hs);
        var c = document.getElementById(co);
        if(c.style.display == 'block') { 
          c.style.display = 'none';
	  h.innerHTML = '[+]';
        } else {
          c.style.display = 'block';
	  h.innerHTML = '[-]';
	}
    }
</script>
<div class="wrap">
	<table><tr><td><img src="<?php echo WP_PLUGIN_URL; ?>/wpgeocode/images/whatiswpgeocode.png" alt="WP Geocode" /></td>
	<td><h2>WP Geocode Options</h2></td></tr>
<?php
if (!$options['chk_donated']) {
?>
<tr><td>
<div style="text-align:left; " id='wpgc_donate'>
<form action="https://www.paypal.com/cgi-bin/webscr" method="post">
<input type="hidden" name="cmd" value="_s-xclick">
<input type="hidden" name="hosted_button_id" value="GDQD948MQ3G3G">
<input type="image" src="https://www.paypal.com/en_US/i/btn/btn_donate_SM.gif" border="0" name="submit" alt="PayPal - The safer, easier way to pay online!">
<img alt="" border="0" src="https://www.paypal.com/en_US/i/scr/pixel.gif" width="1" height="1">
</form>
</div>
</td><td>Like this plugin?  Please rate it highly and maybe even consider donating to help keep this plugin alive and free.</td></tr>
<?php
}
?>
</table>
<form method="post" action="options.php">
<?php settings_fields('wpgc_plugin_options'); ?>
<input name="wpn-update_settings" type="hidden" value="<?php echo wp_create_nonce('wpn-update_setting'); ?>" />
<input name="wpgc_options[chk_donated]" id="chk_donated" type="checkbox" <?php if( $options['chk_donated'] ) echo 'checked="checked"'; ?> />
<label for="wpgc_options[chk_donated]">I have donated to help contribute for the development of this plugin.</label>
<br />
<h3>Usage</h3>
Available shortcodes <a id='hide_shortcodes' style='text-decoration:none;' href='#' onclick="javascript:toggleVisibility('hide_shortcodes','shortcodes');">[+]</a>
<p>
<div id='shortcodes' style='display: none'>
Use these shortcodes to incorporate reader geolocation data into your blog posts
<h4>Shortcodes</h4>
Use these shortcodes to incorporate reader geolocation data into your blog posts
<ul STYLE="list-style-type: square; list-style-position: inside">
<li> [wpgc_ip] - IP Address of the reader</li>
<li> [wpgc_city] - City of the reader
<li> [wpgc_postal_code] - Postal Code (zip) of the reader
<li> [wpgc_state_code] - Two letter State code of the reader
<li> [wpgc_country_name] - Country name of the reader
<li> [wpgc_country_code] - Two letter Country code of the reader
<li> [wpgc_country_flag] - Image of the flag for the reader's country
<li> [wpgc_latitude] - Latitude of the reader
<li> [wpgc_longitude] - Latitude of the reader
</ul>

<h4>Conditional Shortcodes - Only available in the body of the post</h4>
Use these shortcodes to display customized content in your blog posts to readers
<ul STYLE="list-style-type: square; list-style-position: inside">
<li> [wpgc_is_city_and_state city="Yardley" state_code="PA"]
<li> [wpgc_is_postal_code postal_code="90120"]
<li> [wpgc_is_postal_codes postal_code="90120,19067"]
<li> [wpgc_is_not_postal_code postal_codes="90120"]
<li> [wpgc_is_not_postal_codes postal_codes="90120,19067"]
<li> [wpgc_is_ip ip="xx.xx.xx.xx"]
<li> [wpgc_is_ips ip="xx.xx.xx.xx"]
<li> [wpgc_is_ips ips="xx.xx.xx.xx,aa.bb.cc.dd"]
<li> [wpgc_is_not_ip ip="xx.xx.xx.xx"]
<li> [wpgc_is_city city=""]
<li> [wpgc_is_not_cities" city="cityone,citytwo,citythree"]
<li> [wpgc_is_not_city" city=""]
<li> [wpgc_is_nearby"] - Uses the value you specify in the Nearby Range setting from the administrative panel
<li> [wpgc_is_not_nearby"]
<li> [wpgc_is_within miles="10"]
<li> [wpgc_is_within kilometers="12"]
<li> [wpgc_is_country_name country_name=""]
<li> [wpgc_is_country_code country_code=""]
<li> [wpgc_is_state_code state_code=""]
<li> [wpgc_is_not_country_name country_name=""]
<li> [wpgc_is_not_country_code country_code=""]
<li> [wpgc_is_not_country_codes country_codes=""]
<li> [wpgc_is_not_state_code state_code=""]
</ul>

<h4>Examples</h4>
<ul STYLE="list-style-type: square; list-style-position: inside">
<li> [wpgc_is_nearby] Hi Neighbor! [/wpgc_is_nearby] - Will display "Hi Neighbor!" to readers within a configurable distance from your home base.
<li> [wpgc_is_within miles=10] Stop on over, since you're in the area.[/wpgc_is_within] - Will display "Come on over!" in the post body if the user is viewing the post from within 10 miles.
<li> [wpgc_is_ip ip=123.123.123.123] I used to own this IP Address [/wpgc_is_ip] - Will display the message only if the user has that specific IP Address.
<li> [wpgc_is_city city="Yardley"] Hello Fellow Yardlian [/wpgc_is_city] - Will display the message only if the user has that specific IP Address.
</ul>
</div>
<br>
</div>
<h3>Options</h3>

			<table class="form-table">
				<tr>
					<th scope="row">Plugin Status</th>
					<td>
					      <input name="wpgc_options[chk_enable_plugin]" id="chk_enable_plugin" type="checkbox" <?php if( $options['chk_enable_plugin'] ) echo 'checked="checked"'; ?> />
					      <label for="chk_enable_plugin">Enable WP Geocode Plugin</label>

					</td>
				</tr>
				<tr>
					<th scope="row">Your Google Maps API Key</th>
					<td>
						<label><input size=40 name="wpgc_options[txt_gmaps_key]" value="<?php echo $options['txt_gmaps_key'];?>">
						<span style="color:#666666;margin-left:2px;">This is used when displaying Google Maps.  See <a href=https://developers.google.com/maps/signup>https://developers.google.com/maps/signup</a> for more information.</span>
					</td>
				</tr>
				<tr>
					<th scope="row">Your Latitude</th>
					<td>
						<label><input size=40 name="wpgc_options[txt_home_latitude]" value="<?php echo $options['txt_home_latitude'];?>">
						<span style="color:#666666;margin-left:2px;">This is used for calculating distance - used by the conditional shortcodes [wpgc_is_within]</span>
					</td>
				</tr>
				<tr>
					<th scope="row">Your Longitude</th>
					<td>
						<label><input size=40 name="wpgc_options[txt_home_longitude]" value="<?php echo $options['txt_home_longitude'];?>">
						<span style="color:#666666;margin-left:2px;">This is used for calculating distance - used by the conditional shortcodes [wpgc_is_within]</span>
					</td>
				</tr>
				<tr>
					<th scope="row">Nearby Range</th>
					<td>
						<label><input size=10 name="wpgc_options[txt_nearby_range]" value="<?php echo $options['txt_nearby_range'];?>">
						<span style="color:#666666;margin-left:2px;">In Miles or Kilometers (see unit setting) if less than this distance will be considered nearby.  Used by [wpgc_is_nearby]</span>
					</td>
				</tr>
				<tr>
					<th scope="row">Default Distance in Kilometers Phrase</th>
					<td>
						<label><input name="wpgc_options[txt_def_distance_kilometers]" value="<?php echo $options['txt_def_distance_kilometers'];?>">
						<span style="color:#666666;margin-left:2px;">Use this phrase for distance in kilometers if we can't geolocate the reader (shortcode [wpg_city])</span><br />
					</td>
				</tr>
				<tr>
					<th scope="row">Default Distance in Miles Phrase</th>
					<td>
						<label><input name="wpgc_options[txt_def_distance_miles]" value="<?php echo $options['txt_def_distance_miles'];?>">
						<span style="color:#666666;margin-left:2px;">Use this phrase for distance in miles if we can't geolocate the reader (shortcode [wpg_city])</span><br />
					</td>
				</tr>
				<tr>
					<th scope="row">Default City Phrase</th>
					<td>
						<label><input name="wpgc_options[txt_def_city]" value="<?php echo $options['txt_def_city'];?>">
						<span style="color:#666666;margin-left:2px;">Use this word in the city context if we can't geolocate the reader (shortcode [wpg_city])</span><br />
					</td>
				</tr>
				<tr>
					<th scope="row">Default State Code Phrase</th>
					<td>
						<label><input name="wpgc_options[txt_def_state_code]" value="<?php echo $options['txt_def_state'];?>">
						<span style="color:#666666;margin-left:2px;">Use this phrase for the state code if we can't geolocate the reader (shortcode [wpgc_state_code])</span><br />
					</td>
				</tr>
				<tr>
					<th scope="row">Default Postal Code Phrase</th>
					<td>
						<label><input name="wpgc_options[txt_def_postal_code]" value="<?php echo $options['txt_def_postal'];?>">
						<span style="color:#666666;margin-left:2px;">Use this phrase for the postal code if we can't geolocate the reader (shortcode [wpgc_postal_code])</span><br />
					</td>
				</tr>
				<tr>
					<th scope="row">Default Country Name Phrase</th>
					<td>
						<label><input name="wpgc_options[txt_def_country_name]" value="<?php echo $options['txt_def_country_name'];?>">
						<span style="color:#666666;margin-left:2px;">Use this word for the country name if we can't geolocate the reader (shortcode [wpgc_country])</span><br />
					</td>
				</tr>
				<tr>
					<th scope="row">Default Country Code Phrase</th>
					<td>
						<label><input name="wpgc_options[txt_def_country_code]" value="<?php echo $options['txt_def_country_code'];?>">
						<span style="color:#666666;margin-left:2px;">Use this phrase for the country code if we can't geolocate the reader (shortcode [wpgc_country])</span><br />
					</td>
				</tr>
				<tr>
					<th scope="row">Default Latitude Phrase</th>
					<td>
						<label><input name="wpgc_options[txt_def_latitude]" value="<?php echo $options['txt_def_latitude'];?>">
						<span style="color:#666666;margin-left:2px;">Use this word in the latitude context if we can't geolocate the reader (shortcode [wpgc_latitude"])</span><br />
					</td>
				</tr>
				<tr>
					<th scope="row">Default Longitude Phrase</th>
					<td>
						<label><input name="wpgc_options[txt_def_longitude]" value="<?php echo $options['txt_def_longitude'];?>">
						<span style="color:#666666;margin-left:2px;">Use this word in the longitude context if we can't geolocate the reader (shortcode [wpgc_longitude])</span><br />
					</td>
				</tr>
				<tr>
					<th scope="row">Default IP Address Phrase</th>
					<td>
						<label><input name="wpgc_options[txt_def_ip]" value="<?php echo $options['txt_def_ip'];?>">
						<span style="color:#666666;margin-left:2px;">Use this word in the ip address context if we can't geolocate the reader (shortcode [wpgc_ip address])</span><br />
					</td>
				</tr>
				<tr valign="top">
					<th scope="row">Content to be filtered</th>
					<td>
						<label><input name="wpgc_options[chk_post_content]" type="checkbox" value="1" <?php checked('1', $options['chk_post_content']); ?> /> Blog Posts</label><br />
						<label><input name="wpgc_options[chk_post_title]" type="checkbox" value="1" <?php checked('1', $options['chk_post_title']); ?> /> Post Title <em>(also filters recent posts sidebar widget)</em></label><br />
						<label><input name="wpgc_options[chk_comments]" type="checkbox" value="1" <?php checked('1', $options['chk_comments']); ?> /> Comments <em>(filters comment author names too)</em></label><br />
					</td>
				</tr>
				<tr>
					<th scope="row">Filter Class</th>
					<td>
						<input name='wpgc_options[txt_filter_cls]' value="<?php echo $options['txt_filter_cls'];?>">
						<span style="color:#666666;margin-left:2px;">Renders filtered content using this style/class id. eg: &lt;span class="yourclass"&gt;Your City&lt;/span&gt;</span>
					</td>
				</tr>
				<tr>
					<th scope="row">Date Format</th>
					<td>
						<select name='wpgc_options[sel_date_format]'>
							<option <?php if ($options['sel_date_format']=='F j, Y, g:i a') { print "SELECTED"; };?> value='F j, Y, g:i a'><?php print date('F j, Y, g:i a');?></option>

							<option <?php if ($options['sel_date_format']=='m/d/Y') { print "SELECTED"; };?> value='m/d/Y'><?php print date('m/d/Y');?></option>
							<option <?php if ($options['sel_date_format']=='d/m/Y') { print "SELECTED"; };?> value='d/m/Y'><?php print date('d/m/Y');?></option>
							<option <?php if ($options['sel_date_format']=='D M j H:m:s') { print "SELECTED"; };?> value='D M j H:m:s'><?php print date('D M j H:m:s');?></option>
						</select>
						<span style="color:#666666;margin-left:2px;">Format to render date in - used by [wpgc_database_date] Eg:'D, M d Y H:i:s' </span>
					</td>
				</tr>
				<tr valign="top">
					<th scope="row">Default Units</th>
					<td>
						<label><input name="wpgc_options[rdo_units]" type="radio" value="miles" <?php checked('miles', $options['rdo_units']); ?> /> Miles </label><span style="color:#666666;">Use miles</span><br>
						<label><input name="wpgc_options[rdo_units]" type="radio" value="kilometers" <?php checked('lower', $options['rdo_units']); ?> /> Kilometers </label><span style="color:#666666;">Use Kilometers</span><br>
					</td>
				</tr>
				<tr valign="top">
					<th scope="row">Case Conversion</th>
					<td>
						<label><input name="wpgc_options[rdo_case]" type="radio" value="upper" <?php checked('upper', $options['rdo_case']); ?> /> UPPER CASE </label><span style="color:#666666;">- Converts filtered content to UPPER CASE geolocation tags</span><br />
						<label><input name="wpgc_options[rdo_case]" type="radio" value="lower" <?php checked('lower', $options['rdo_case']); ?> /> lower </label><span style="color:#666666;">- Converts filtered content to lower case geolocation tags</span><br />
						<label><input name="wpgc_options[rdo_case]" type="radio" value="ucfirst" <?php checked('ucfirst', $options['rdo_case']); ?> /> Upper case first letter</label><span style="color:#666666;">- Converts filtered content to upper case first letter</span><br />
						<label><input name="wpgc_options[rdo_case]" type="radio" value="off" <?php checked('off', $options['rdo_case']); ?> /> off </label><span style="color:#666666;">- Will not convert the case of filtered content</span>
					</td>
				</tr>
				<tr><td colspan="2"><div style="margin-top:10px;"></div></td></tr>
				<tr valign="top" style="border-top:#dddddd 1px solid;">
					<th scope="row">Database Options</th>
					<td>
						<label><input name="wpgc_options[chk_default_options_db]" type="checkbox" value="1" <?php checked('1', $options['chk_default_options_db']); ?> /> Restore defaults upon plugin deactivation/reactivation</label>
						<br /><span style="color:#666666;margin-left:2px;">Only check this if you want to reset plugin settings upon reactivation</span>
					</td>
				</tr>
			</table>
			<p class="submit">
			<input type="submit" class="button-primary" value="Save Changes" />
			</p>
		</form>
<h3>Database</h3>
This product includes GeoLite data created by MaxMind, available from http://www.maxmind.com/.
<p>
As IP and geolocation data change over time, you should consider updating this database.  To update this database, download the latest version of the database from <a href=http://geolite.maxmind.com/download/geoip/database/GeoLiteCity.dat.gz>this link</a> and place it in the WP Geocode Plugin database folder on your server.
<p>
Installation Instructions <a id='hide_installation' style='text-decoration:none;' href='#' onclick="javascript:toggleVisibility('hide_installation','installation');">[+]</a>
<p>
<div id='installation' style='display: none'>
<strong>Step 1</strong> - Download database from <a href=http://geolite.maxmind.com/download/geoip/database/GeoLiteCity.dat.gz>this link</a>.
<p>
If you are using the wget program to download the GeoLite file, please use the -N option to only download if the file has been updated:
<p>
<pre>wget -N -q http://geolite.maxmind.com/download/geoip/database/GeoLiteCity.dat.gz</pre>
<p>
<strong>Step 2</strong> - Install database. Once you have uploaded the database, you will want to uncompress it. To uncompress the binary format, you will need to unzip the file. For example, to uncompress the GeoIP City binary database on Linux or Unix, you could run:
<pre>$ tar xvfz GeoIP-133_20051201.tar.gz</pre>
<p>
Then you will need to install the .dat file into a data directory. For example, on Linux/Unix, you could run:
$ mv GeoIP-133_20051201/GeoIP-133_20051201.dat /usr/local/share/GeoIP/GeoIPCity.dat
<p>
To uncompress the CSV format, you can use any zip program, like WinZip for Windows, or unzip on Linux. Then you can load the CSV database into a SQL database.
<p>
Alternatively, I will install the plugin for you:
<form action="https://www.paypal.com/cgi-bin/webscr" method="post">
<input type="hidden" name="cmd" value="_s-xclick">
<input type="hidden" name="hosted_button_id" value="447NPQRYQ8XFS">
<table>
<tr><td><input type="hidden" name="on0" value="Plugin installed by Author">Plugin installed by Author</td></tr><tr><td><input type="text" name="os0" maxlength="60"></td></tr>
</table>
<input type="image" src="https://www.paypal.com/en_US/i/btn/btn_buynowCC_LG.gif" border="0" name="submit" alt="PayPal - The safer, easier way to pay online!">
<img alt="" border="0" src="https://www.paypal.com/en_US/i/scr/pixel.gif" width="1" height="1">
</form>

</div>
<table>
<tr>
<th width='20%'>Latest Available from MaxMind</th>
<th width='20%'>Installed Database</th>
<th width='35%'>Database Path</th>
<th width='15%'>Actions</th>
</tr>
<tr>
<?php 
$lmoddate=last_mod("http://geolite.maxmind.com/download/geoip/database/GeoLiteCity.dat.gz");
echo "<td>$lmoddate</td>";
$database=WP_PLUGIN_DIR.'/wpgeocode/database/GeoLiteCity.dat';
if (is_file($database)) {
	if ($options['chk_enable_plugin']) {
		$dbdate=date("D, M d Y H:i:s", @filemtime("$database"));
		$dbstate='<td style="background-color:#99cc99; padding:4px;"><strong>MaxMind Database is installed and dated '.$dbdate.' </td>';
		$install='Update';
	} else {
		$dbstate='<td style="background-color:#FFE991; padding:4px;"><strong>MaxMind Database is installed but this plugin is disabled. </td>';
		$install='Update';
	}
} else {
        $dbstate='<td style="background-color:#FFE991; padding:4px;"><strong>MaxMind Database not installed. </td>';
	$install='Install';
}
echo $dbstate;
?>

<td>
<?php echo dirname(__FILE__)."/database";?>
</td>
<td>
<?php
        echo $install.' Now (Coming Soon)';
?>

</td>
</tr>
</table>
<p>
<?php
}// end render form

function wpgc_validate_options($input) {
	$input['txt_gmap_key'] =  wp_filter_nohtml_kses($input['txt_gmap_key']);
	$input['txt_def_city'] =  wp_filter_nohtml_kses($input['txt_def_city']);
	$input['txt_def_state_code'] = wp_filter_nohtml_kses($input['txt_def_state_code']);
	$input['txt_def_country_name'] = wp_filter_nohtml_kses($input['txt_def_country_name']);
	$input['txt_def_country_code'] = wp_filter_nohtml_kses($input['txt_def_country_code']);
	$input['txt_def_ip'] = wp_filter_nohtml_kses($input['txt_def_ip']);
	$input['txt_def_latitude'] = wp_filter_nohtml_kses($input['txt_def_latitude']);
	$input['txt_def_longitude'] = wp_filter_nohtml_kses($input['txt_def_longitude']);
	$input['txt_flag_height'] = wp_filter_nohtml_kses($input['txt_flag_height']);
	$input['txt_flag_width'] = wp_filter_nohtml_kses($input['txt_flag_width']);
	return $input;
}

// ***************************************
// *** END - Create Admin Options    ***
// ***************************************

// ---------------------------------------------------------------------------------

// ***************************************
// *** START - Plugin Core Functions   ***
// ***************************************

function wpgc_case_convert($word,$opt,$cls) {
        if ($cls=='') {
                $wpgc_class_on='';
                $wpgc_class_off='';
        } else {
                $wpgc_class_on='<span class="'.$cls.'">';
                $wpgc_class_off='</span>';
        }
	if($opt=='upper'){
		$word=strtoupper($word);
	} else if ($opt=='lower') {
		$word=strtolower($word);
	} else if ($opt=='ucfirst') {
		$word=ucfirst($word);
	}
	return $wpgc_class_on.$word.$wpgc_class_off;
}//end function wpgc_case_convert

function wpgc_get_location_info($user_ip) {
$state_list= array( 'AL' => 'Alabama', 'AK' => 'Alaska', 'AZ' => 'Arizona', 'AR' => 'Arkansas', 'CA' => 'California', 'CO' => 'Colorado', 'CT' => 'Connecticut', 'DE' => 'Delaware', 'FL' => 'Florida', 'GA' => 'Georgia', 'HI' => 'Hawaii', 'ID' => 'Idaho', 'IL' => 'Illinois', 'IN' => 'Indiana', 'IA' => 'Iowa', 'KS' => 'Kansas', 'KY' => 'Kentucky', 'LA' => 'Louisiana', 'ME' => 'Maine', 'MD' => 'Maryland', 'MA' => 'Massachusetts', 'MI' => 'Michigan', 'MN' => 'Minnesota', 'MS' => 'Mississippi', 'MO' => 'Missouri', 'MT' => 'Montana', 'NE' => 'Nebraska', 'NV' => 'Nevada', 'NH' => 'New Hampshire', 'NJ' => 'New Jersey', 'NM' => 'New Mexico', 'NY' => 'New York', 'NC' => 'North Carolina', 'ND' => 'North Dakota', 'OH' => 'Ohio', 'OK' => 'Oklahoma', 'OR' => 'Oregon', 'PA' => 'Pennsylvania', 'RI' => 'Rhode Island', 'SC' => 'South Carolina', 'SD' => 'South Dakota', 'TN' => 'Tennessee', 'TX' => 'Texas', 'UT' => 'Utah', 'VT' => 'Vermont', 'VA' => 'Virginia', 'WA' => 'Washington', 'WV' => 'West Virginia', 'WI' => 'Wisconsin', 'WY' => 'Wyoming',);
	$tmp = get_option('wpgc_options');
	$wpgc_path = WP_PLUGIN_DIR . '/wpgeocode/';
	$database = WP_PLUGIN_DIR . '/wpgeocode/database/GeoLiteCity.dat';
	$fp = @fopen($database, 'r');
	if ($fp==FALSE) {
	return FALSE;
	}
	require_once($wpgc_path.'includes/geocity.php');
	require_once($wpgc_path.'includes/geoip.php');

	$gi = geoip_open($wpgc_path.'database/GeoLiteCity.dat', GEOIP_STANDARD);

	$record = geoip_record_by_addr($gi, "$user_ip");
	geoip_close($gi);

	$location_info = array(); 

	$location_info['city_name']    = (isset($record->city)) ? $record->city : '~';
	$location_info['state_code']   = (isset($record->region)) ? strtoupper($record->region) : '~';
	$location_info['state_name']   = (isset($record->region)) ? $state_list[$record->region] : '~' ;
	$location_info['postal_code']   = (isset($record->postal_code)) ? strtoupper($record->postal_code) : '~';
	$location_info['country_name'] = (isset($record->country_name)) ? $record->country_name : '~';
	$location_info['country_code'] = (isset($record->country_code)) ? strtoupper($record->country_code) : '~';
	$location_info['latitude']     = (isset($record->latitude)) ? $record->latitude : '~';
	$location_info['longitude']    = (isset($record->longitude)) ? $record->longitude : '~';

	return $location_info;

}// end function get_location_info

function wpgc_get_ip_address() {
   //if (getenv('REMOTE_ADDR')) {
        //$ip = getenv('REMOTE_ADDR');
   //} else if (isset($_SERVER['REMOTE_ADDR'])) {
        //$ip = $_SERVER['REMOTE_ADDR'];
   //} else {
        //$ip = 'unknown';
   //}
if (getenv("HTTP_CLIENT_IP")) 
	$ip = getenv("HTTP_CLIENT_IP"); 
else if(getenv("HTTP_X_FORWARDED_FOR")) 
	$ip = getenv("HTTP_X_FORWARDED_FOR"); 
else if(getenv("REMOTE_ADDR")) 
	$ip = getenv("REMOTE_ADDR"); 
else 
	$ip = "UNKNOWN";
   return $ip;
}// end function get_ip_address

function read_header($ch, $header) 
{ 
    global $modified; 
    $length = strlen($header); 
    if(strstr($header, "Last-Modified:")) 
    { 
        $modified = substr($header, 15); 
    } 
    return $length; 
}//end function read_header 

function last_mod($remote_file) 
{ 
    global $modified; 
    $ch = curl_init(); 
    curl_setopt($ch, CURLOPT_URL, $remote_file); 
    curl_setopt($ch, CURLOPT_HEADER, 1); 
    curl_setopt($ch, CURLOPT_NOBODY, 1); 
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); 
    curl_setopt($ch, CURLOPT_HEADERFUNCTION, 'read_header'); 

    $headers = curl_exec ($ch); 
    curl_close ($ch); 
    return $modified; 
}//end function last_mod

function distance($lat1, $lng1, $lat2, $lng2, $miles = true)
{
	$pi80 = M_PI / 180;
	$lat1 *= $pi80;
	$lng1 *= $pi80;
	$lat2 *= $pi80;
	$lng2 *= $pi80;
 
	$r = 6372.797; // mean radius of Earth in km
	$dlat = $lat2 - $lat1;
	$dlng = $lng2 - $lng1;
	$a = sin($dlat / 2) * sin($dlat / 2) + cos($lat1) * cos($lat2) * sin($dlng / 2) * sin($dlng / 2);
	$c = 2 * atan2(sqrt($a), sqrt(1 - $a));
	$km = $r * $c;
 
	return ($miles ? ($km * 0.621371192) : $km);
}//end function distance

function wpgc_csv_find($string1,$string2) {
// string1 is a csv list eg: one,two,three
// string2 is a static value

	$strarr = explode(',',$string1);
	foreach($strarr as $ii) {
		if(trim(strtolower($ii)) == trim(strtolower($string2))) {
			return true;
		}
	}
	return false;
} // end function wpgc_find_string_in_array
function wpgc_list_all_countries() {

$country_list = array(
		"Afghanistan",
		"Albania",
		"Algeria",
		"Andorra",
		"Angola",
		"Antigua and Barbuda",
		"Argentina",
		"Armenia",
		"Australia",
		"Austria",
		"Azerbaijan",
		"Bahamas",
		"Bahrain",
		"Bangladesh",
		"Barbados",
		"Belarus",
		"Belgium",
		"Belize",
		"Benin",
		"Bhutan",
		"Bolivia",
		"Bosnia and Herzegovina",
		"Botswana",
		"Brazil",
		"Brunei",
		"Bulgaria",
		"Burkina Faso",
		"Burundi",
		"Cambodia",
		"Cameroon",
		"Canada",
		"Cape Verde",
		"Central African Republic",
		"Chad",
		"Chile",
		"China",
		"Colombi",
		"Comoros",
		"Congo (Brazzaville)",
		"Congo",
		"Costa Rica",
		"Cote d'Ivoire",
		"Croatia",
		"Cuba",
		"Cyprus",
		"Czech Republic",
		"Denmark",
		"Djibouti",
		"Dominica",
		"Dominican Republic",
		"East Timor (Timor Timur)",
		"Ecuador",
		"Egypt",
		"El Salvador",
		"Equatorial Guinea",
		"Eritrea",
		"Estonia",
		"Ethiopia",
		"Fiji",
		"Finland",
		"France",
		"Gabon",
		"Gambia, The",
		"Georgia",
		"Germany",
		"Ghana",
		"Greece",
		"Grenada",
		"Guatemala",
		"Guinea",
		"Guinea-Bissau",
		"Guyana",
		"Haiti",
		"Honduras",
		"Hungary",
		"Iceland",
		"India",
		"Indonesia",
		"Iran",
		"Iraq",
		"Ireland",
		"Israel",
		"Italy",
		"Jamaica",
		"Japan",
		"Jordan",
		"Kazakhstan",
		"Kenya",
		"Kiribati",
		"Korea, North",
		"Korea, South",
		"Kuwait",
		"Kyrgyzstan",
		"Laos",
		"Latvia",
		"Lebanon",
		"Lesotho",
		"Liberia",
		"Libya",
		"Liechtenstein",
		"Lithuania",
		"Luxembourg",
		"Macedonia",
		"Madagascar",
		"Malawi",
		"Malaysia",
		"Maldives",
		"Mali",
		"Malta",
		"Marshall Islands",
		"Mauritania",
		"Mauritius",
		"Mexico",
		"Micronesia",
		"Moldova",
		"Monaco",
		"Mongolia",
		"Morocco",
		"Mozambique",
		"Myanmar",
		"Namibia",
		"Nauru",
		"Nepa",
		"Netherlands",
		"New Zealand",
		"Nicaragua",
		"Niger",
		"Nigeria",
		"Norway",
		"Oman",
		"Pakistan",
		"Palau",
		"Panama",
		"Papua New Guinea",
		"Paraguay",
		"Peru",
		"Philippines",
		"Poland",
		"Portugal",
		"Qatar",
		"Romania",
		"Russia",
		"Rwanda",
		"Saint Kitts and Nevis",
		"Saint Lucia",
		"Saint Vincent",
		"Samoa",
		"San Marino",
		"Sao Tome and Principe",
		"Saudi Arabia",
		"Senegal",
		"Serbia and Montenegro",
		"Seychelles",
		"Sierra Leone",
		"Singapore",
		"Slovakia",
		"Slovenia",
		"Solomon Islands",
		"Somalia",
		"South Africa",
		"Spain",
		"Sri Lanka",
		"Sudan",
		"Suriname",
		"Swaziland",
		"Sweden",
		"Switzerland",
		"Syria",
		"Taiwan",
		"Tajikistan",
		"Tanzania",
		"Thailand",
		"Togo",
		"Tonga",
		"Trinidad and Tobago",
		"Tunisia",
		"Turkey",
		"Turkmenistan",
		"Tuvalu",
		"Uganda",
		"Ukraine",
		"United Arab Emirates",
		"United Kingdom",
		"United States",
		"Uruguay",
		"Uzbekistan",
		"Vanuatu",
		"Vatican City",
		"Venezuela",
		"Vietnam",
		"Yemen",
		"Zambia",
		"Zimbabwe"
	);
return implode("<BR>",$country_list);
}
