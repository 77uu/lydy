<?php
 namespace imwpf\modules; class HTTP { protected static $responseHeader; public static function get($url, $timeout = 30, $header = '') { $contextOpt = array( 'http' => array( 'method' => 'GET', 'header' => $header, 'timeout' => $timeout, ) ); if (strpos($url, 'https://') !== false) { $contextOpt['ssl'] = array( 'verify_peer' => false, 'verify_peer_name' => false, ); } $context = stream_context_create($contextOpt); $result = file_get_contents($url, null, $context); self::$responseHeader = $http_response_header; return $result; } public static function post($url, array $args, $timeout = 30, $header = "") { $body = http_build_query($args); if ($header) { $header = rtrim($header, "\r\n"); $header .= "\r\n"; } $header .= "Content-Type: application/x-www-form-urlencoded"; return self::request($url, $body, $header, $timeout); } public static function json($url, array $json, $timeout = 30, $header = "") { $body = json_encode($json, JSON_UNESCAPED_UNICODE); if ($header) { $header = rtrim($header, "\r\n"); $header .= "\r\n"; } $header .= "Content-Type: application/json"; return self::request($url, $body, $header, $timeout); } public static function text($url, $text, $timeout = 30, $header = "") { if ($header) { $header = rtrim($header, "\r\n"); $header .= "\r\n"; } $header .= "Content-Type: text/plain"; return self::request($url, $text, $header, $timeout); } public static function request($url, $body, $header, $timeout = 30) { $params = array( 'http' => array( 'method' => 'POST', 'timeout' => $timeout, 'header' => $header, 'content' => $body, ) ); if (strpos($url, 'https://') !== false) { $params['ssl'] = array( 'verify_peer' => false, 'verify_peer_name' => false, ); } $context = stream_context_create($params); $result = file_get_contents($url, null, $context); self::$responseHeader = $http_response_header; return $result; } public static function getRawHeader() { return self::$responseHeader; } public static function getHeader() { $header = array(); foreach (self::$responseHeader as $k=>$v) { $t = explode(':', $v, 2); if (isset($t[1])) { $header[strtolower(trim($t[0]))] = trim($t[1]); } else { $header[] = $v; if(preg_match("#HTTP/[0-9\.]+\s+([0-9]+)\s+((\w|\s)+)#",$v, $out)) { $header['code'] = intval($out[1]); $header['msg'] = $out[2]; } } } if (isset($header['content-type']) && strpos($header['content-type'], 'charset') !== false) { $charset = substr($header['content-type'], strpos($header['content-type'], 'charset') + 8); $header['charset'] = $charset; } return $header; } } 