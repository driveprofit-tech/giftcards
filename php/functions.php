<?
/**
 * trims text to a space then adds ellipses if desired
 * @param string $input text to trim
 * @param int $length in characters to trim to
 * @param bool $ellipses if ellipses (...) are to be added
 * @param bool $strip_html if html tags are to be stripped
 * @return string
 */
function trim_text($input, $length, $ellipses = true, $strip_html = true) {
    //strip tags, if desired
    if ($strip_html) {
        $input = strip_tags($input);
    }
  
    //no need to trim, already shorter than trim length
    if (strlen($input) <= $length) {
        return $input;
    }
  
    //find last space within length
    $last_space = strrpos(substr($input, 0, $length), ' ');
    $trimmed_text = substr($input, 0, $last_space);
  
    //add ellipses (...)
    if ($ellipses) {
        $trimmed_text .= '...';
    }
  
    return $trimmed_text;
}

function sluggify($url)
{
    # Prep string with some basic normalization
    $url = strtolower($url);
    $url = strip_tags($url);
    $url = stripslashes($url);
    $url = html_entity_decode($url);

    # Remove quotes (can't, etc.)
    $url = str_replace('\'', '', $url);

    # Replace non-alpha numeric with hyphens
    $match = '/[^a-z0-9]+/';
    $replace = '-';
    $url = preg_replace($match, $replace, $url);

    $url = trim($url, '-');

    return $url;
}

function sanitizeFilename($filename){
    
    $filename = str_ireplace(" ", "-", $filename);
    $filename = str_ireplace("%20", "-", $filename);
    
    return $filename;
    
}

function escape_js($var){
        
    // Array
    if (is_array($var) && sizeof($var)) {
        foreach ($var as $i=>$v) {
            $var[$i] = escape_js($var[$i]);
        }
    }
    // String
    elseif (is_string($var)) {
        $var = preg_replace(
            array("/'/", "/\"/", "/\\t/", "/\\n/", "/\\r/"),
            array("\\x" . dechex(ord("'")), "\\x" . dechex(ord("\"")), "\x09", "\\x0A", "\\x0D"),
            $var
        );
    }

    return $var;
}


/**
 * Lightens/darkens a given colour (hex format), returning the altered colour in hex format.7
 * @param str $hex Colour as hexadecimal (with or without hash);
 * @percent float $percent Decimal ( 0.2 = lighten by 20%(), -0.4 = darken by 40%() )
 * @return str Lightened/Darkend colour as hexadecimal (with hash);
 */
function color_luminance( $hex, $percent ) {
    
    // validate hex string
    
    $hex = preg_replace( '/[^0-9a-f]/i', '', $hex );
    $new_hex = '#';
    
    if ( strlen( $hex ) < 6 ) {
        $hex = $hex[0] + $hex[0] + $hex[1] + $hex[1] + $hex[2] + $hex[2];
    }
    
    // convert to decimal and change luminosity
    for ($i = 0; $i < 3; $i++) {
        $dec = hexdec( substr( $hex, $i*2, 2 ) );
        $dec = min( max( 0, $dec + $dec * $percent ), 255 ); 
        $new_hex .= str_pad( dechex( $dec ) , 2, 0, STR_PAD_LEFT );
    }       
    
    return $new_hex;
}

// Process ajax listing request and return params to use it in queries
function process_ajax_request($request)
{

    $params = array();
    
    // Search params - use only searchable columns
    if (isset($request['search']['value']) && ($request['search']['value'] != "") && isset($request['columns']) && !empty($request['columns']))
    {
        foreach($request['columns'] as $column)
        {
            if ($column['searchable'] == "true")
            {
                $params['search'][$column['name']] = $request['search']['value'];
            }
        }
    }
    if (isset($request['columns']) && !empty($request['columns']))
    {
        foreach($request['columns'] as $column)
        {
            if ($column['searchable'] == "true" && $column['search']['value'] != '')
            {
                $params['search'][$column['name']] = $column['search']['value'];
            }
        }
    }
    
    // Pagination
    if ( isset( $request['start'] ) && $request['length'] != '-1' )
    {
        $params['start'] = intval($request['start']);
        $params['length'] = intval($request['length']); 
    }

    // Order
    if (isset($request['order']) && is_array($request['order']) && sizeof($request['order']) > 0)
    {
        foreach($request['order'] as $column)
        {
            if ($request['columns'][$column['column']]['orderable'] == "true")
            {
                $params['order_by'][$request['columns'][$column['column']]['name']] = $request['columns'][$column['column']]['name'] . ' ' . ($column['dir'] == "desc" ? "DESC" : "ASC");
            }
        }
    }
    
    return $params;
}

// Validate certain date formats
function validateDate($date, $format = "Y-m-d")
{
    $d = DateTime::createFromFormat($format, $date);
    return $d && $d->format($format) == $date;
}

// Cleans a file name for upload
function clean_file_name($file_name)
{
   
    $file_parts = explode('-', $file_name);
    $final_parts = array();
    if (!empty($file_parts))
    {
        foreach ($file_parts as $part) {
           if (!preg_match('/^[0-9]{1,}$/', $part))
           {
               $final_parts[] = str_replace("_", " ", $part);
           }
        }
    }
    return implode(" ", $final_parts);

}

// Google captcha validation
function g_recaptcha_validate($g_recaptcha_response)
{
    
    if (strpos(dirname(__FILE__),'www') !== false)
    {
        return true;
    }

    $post = array(
        "secret"=>RECAPTCHA_SECRET_KEY, 
        "response"=>$g_recaptcha_response, 
        "remoteip"=>$_SERVER['REMOTE_ADDR'], 
    );
    $data = http_build_query($post);
    
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, "https://www.google.com/recaptcha/api/siteverify");
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
    $result = curl_exec($ch);
    curl_close($ch);
    
    $json_result = json_decode($result);

    return $json_result->success;
    
}

// Generate a list of available timezones
function tz_list() {

    $zones_array = array();
    $timestamp = time();
    foreach(timezone_identifiers_list() as $key => $zone) 
    {
        date_default_timezone_set($zone);
        $zones_array[$key]['zone'] = $zone;
        $zones_array[$key]['diff_from_GMT'] = 'UTC/GMT ' . date('P', $timestamp);
    }

    return $zones_array;
}

// Apply timezone setting to time
function account_tz_time($time, $account_tz) {

    
    if ($account_tz == "")
    {
        return $time;
    }

    $tz_data = explode(" - ", $account_tz);
    $tz = trim($tz_data[1]);

    $date = new DateTime($time, new DateTimeZone('America/New_York'));
    $date->setTimezone(new DateTimeZone($tz));
    return $date->format('Y-m-d H:i:s');

}

// Ganerates the AuthorizeNet fp hash
function hmac($key, $data)
{
    $b = 64;
    if (strlen($key) > $b)
    {
        $key = pack("H*", md5($key));
    }
    $key  = str_pad($key, $b, chr(0x00));
    $ipad = str_pad('', $b, chr(0x36));
    $opad = str_pad('', $b, chr(0x5c));
    $k_ipad = $key ^ $ipad;
    $k_opad = $key ^ $opad;

    return md5($k_opad . pack("H*", md5($k_ipad . $data)));
}

function hightlight($str, $keywords = '')
{
    $keywords = preg_replace('/\s\s+/', ' ', strip_tags(trim($keywords)));

    $style = 'highlight';
    $style_i = 'highlight_important';
    $var = '';

    foreach(explode(' ', $keywords) as $keyword)
    {
        $replacement = "<span class='".$style."'>".$keyword."</span>";
        $var .= $replacement." ";

        $str = str_ireplace($keyword, $replacement, $str);
    }

    $str = str_ireplace(rtrim($var), "<span class='".$style_i."'>".$keywords."</span>", $str);

    return $str;
}


function daterangepicker_data($selected_period = "", $selected_daterange = "") {

    $cr_date = new DateTime("today");
    $cr_day = $cr_date->format('d');

    // Some predefined ranges
    $predefined_ranges = array(
        "last7days"=>array("display"=>"Last 7 days"),
        "currentmonth"=>array("display"=>"Current month"),
        "lastmonth"=>array("display"=>"Last month"),
        "last6months"=>array("display"=>"Last 6 months"),
        "currentyear"=>array("display"=>"Current year"),
        "lastyear"=>array("display"=>"Last year"),
    );

    // Calculate details for predefined ranges
    foreach ($predefined_ranges as $key => $range)
    {

        $intervals = array();
        if ($key == "today")
        {
            $date_format_db = "%m-%d-%Y";
            $start_interval = $end_interval = date("Y-m-d", strtotime(account_tz_time(date("Y-m-d H:i:s", time()), $account_tz)));
            $intervals[$start_interval] = $start_interval;
        }
        elseif ($key == "yesterday")
        {
            $date_format_db = "%m-%d-%Y";
            $start_interval = $end_interval = date("Y-m-d", strtotime(account_tz_time(date("Y-m-d H:i:s", time() - 60 * 60 * 24), $account_tz)));
            $intervals[$start_interval] = $start_interval;
        }
        elseif ($key == "currentmonth")
        {
            $date_format_db = "%m-%d-%Y";
            $first_day = new DateTime('first day of this month');
            $start_interval = $first_day->format('Y-m-d');
            $intervals[$first_day->format('m-d-Y')] = $first_day->format('m-d-Y');
            for($i = 2; $i<=$cr_day; $i++)
            {
                 $first_day->modify('+1 day');
                 $intervals[$first_day->format('m-d-Y')] = $first_day->format('m-d-Y');      
            }
            $todaysdate = date("Y-m-d", strtotime(account_tz_time(date("Y-m-d H:i:s", time()), $account_tz)));
            $last_day = new DateTime($todaysdate);
            $end_interval = $last_day->format('Y-m-d');
        }
        elseif ($key == "lastmonth")
        {
            $date_format_db = "%m-%d-%Y";
            $first_day = new DateTime('first day of this month');
            $first_day->modify('-1 month');
            $start_interval = $first_day->format('Y-m-d');
            $intervals[$first_day->format('m-d-Y')] = $first_day->format('m-d-Y');
            for($i = 2; $i<=$first_day->format('t'); $i++)
            {
                 $first_day->modify('+1 day');
                 $intervals[$first_day->format('m-d-Y')] = $first_day->format('m-d-Y');      
            }
            $end_interval = $first_day->format('Y-m-d');
        }
        elseif ($key == "last6months")
        {
            $date_format_db = "%Y-%m";
            $first_day = new DateTime('first day of this month');
            $first_day->modify('-6 month');
            $start_interval = $first_day->format('Y-m-d');
            $intervals[$first_day->format('Y-m')] = $first_day->format('M Y');
            for($i = 2; $i<=6; $i++)
            {
                 $first_day->modify('+1 month');
                 $intervals[$first_day->format('Y-m')] = $first_day->format('M Y');      
            }
            $first_day->modify('last day of this month');
            $end_interval = $first_day->format('Y-m-d');
        }
        elseif ($key == "currentyear")
        {
            $date_format_db = "%Y-%m";
            $first_day = new DateTime('first day of january ' . date("Y"));
            $start_interval = $first_day->format('Y-m-d');
            $intervals[$first_day->format('Y-m')] = $first_day->format('M Y');
            for($i = 2; $i<=$cr_date->format('m'); $i++)
            {
                 $first_day->modify('+1 month');
                 $intervals[$first_day->format('Y-m')] = $first_day->format('M Y');  
            }
            $todaysdate = date("Y-m-d", strtotime(account_tz_time(date("Y-m-d H:i:s", time()), $account_tz)));
            $last_day = new DateTime($todaysdate);
            $end_interval = $last_day->format('Y-m-d');
        }
        elseif ($key == "lastyear")
        {
            $date_format_db = "%Y-%m";
            $first_day = new DateTime('first day of january ' . date("Y"));
            $first_day->modify('-1 year');
            $start_interval = $first_day->format('Y-m-d');
            $intervals[$first_day->format('Y-m')] = $first_day->format('M Y');
            for($i = 2; $i<=12; $i++)
            {
                 $first_day->modify('+1 month');
                 $intervals[$first_day->format('Y-m')] = $first_day->format('M Y');  
            }
            $first_day->modify('last day of this month');
            $end_interval = $first_day->format('Y-m-d');
        }        
        elseif ($key == "last7days")
        {
            $date_format_db = "%m-%d-%Y";
            $first_day = $cr_date->modify('-6 day');
            $start_interval = $first_day->format('Y-m-d');
            $intervals[$first_day->format('m-d-Y')] = $first_day->format('m-d-Y');
            for($i = 0; $i<=5; $i++)
            {
                 $first_day->modify('+1 day');
                 $intervals[$first_day->format('m-d-Y')] = $first_day->format('m-d-Y');      
            }
            $todaysdate = date("Y-m-d", strtotime(account_tz_time(date("Y-m-d H:i:s", time()), $account_tz)));
            $last_day = new DateTime($todaysdate);
            $end_interval = $last_day->format('Y-m-d');
        }
        $predefined_ranges[$key] = array_merge(
                                    $predefined_ranges[$key], 
                                    array("start_interval"=>$start_interval, "end_interval"=>$end_interval, "date_format_db"=>$date_format_db, "intervals"=>$intervals)
                                );
    }

    $start_interval = $end_interval = "";
    // Predefined period selected
    if (isset($selected_period) && ($selected_period != "") && isset($predefined_ranges[$selected_period]))
    {
        $start_interval = $predefined_ranges[$selected_period]['start_interval'];
        $end_interval = $predefined_ranges[$selected_period]['end_interval'];
    }
    // Custom period selected
    elseif(isset($selected_daterange) && ($selected_daterange != ""))
    {
        $date_parts = explode("-", $selected_daterange);
        if (date_create_from_format('m/d/Y', trim($date_parts[0])))
        {
            $first_day = date_create_from_format('m/d/Y', trim($date_parts[0]));
            $start_interval = $first_day->format('Y-m-d');
        }
        if (date_create_from_format('m/d/Y', trim($date_parts[1])))
        {
            $last_day = date_create_from_format('m/d/Y', trim($date_parts[1]));
            $end_interval = $last_day->format('Y-m-d');
        }
    }
    else
    {
        $start_interval = $predefined_ranges['currentmonth']['start_interval'];
        $end_interval = $predefined_ranges['currentmonth']['end_interval'];
    }

    return array("predefined_ranges"=>$predefined_ranges, "start_interval"=>$start_interval, "end_interval"=>$end_interval);
}

// Function for utf-8 encoding any object
function utf8_encode_deep(&$input) {

    if (is_string($input)) {
        $input = utf8_encode($input);
    } 
    else if (is_array($input)) {
        foreach ($input as &$value) {
            utf8_encode_deep($value);
        }
        unset($value);
    } 
    else if (is_object($input)) {
       
        $vars = array_keys(get_object_vars($input));

        foreach ($vars as $var) {
            utf8_encode_deep($input->$var);
        }
    }
}


function validate_date($date, $format)
{
    $d = DateTime::createFromFormat($format, $date);
    return $d && $d->format($format) == $date;
}

function display_number($number) {

    return $number + 0;
}

function gen_uuid($len = 8) {

    $hex = md5(uniqid("", true));

    $pack = pack('H*', $hex);
    $tmp =  base64_encode($pack);
    $uid = preg_replace("#(*UTF8)[^A-Za-z0-9]#", "", $tmp);
    $len = max(4, min(128, $len));
    while (strlen($uid) < $len)
    {
        $uid .= gen_uuid(22);
    }

    return substr($uid, 0, $len);
}


?>