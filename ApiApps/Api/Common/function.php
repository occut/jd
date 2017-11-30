<?php

function decodeUnicode($str)
{
    return preg_replace_callback('/\\\\u([0-9a-f]{4})/i',
        create_function(
            '$matches',
            'return mb_convert_encoding(pack("H*", $matches[1]), "UTF-8", "UCS-2BE");'
        ),
        $str);
}

function get($url, $data_type = 'text', $USERPWD = null)
{
    $cl = curl_init();
    if (stripos($url, 'https://') !== FALSE) {
        curl_setopt($cl, CURLOPT_SSL_VERIFYPEER, FALSE);
        curl_setopt($cl, CURLOPT_SSL_VERIFYHOST, FALSE);
        curl_setopt($cl, CURLOPT_SSLVERSION, 1);
    }
    curl_setopt($cl, CURLOPT_URL, $url);
    curl_setopt($cl, CURLOPT_RETURNTRANSFER, 1);
    if ($USERPWD !== null) {
        curl_setopt($cl, CURLOPT_USERPWD, $USERPWD);
    }
    $content = curl_exec($cl);
    $status = curl_getinfo($cl);
    curl_close($cl);
    if (isset($status['http_code']) && $status['http_code'] == 200) {
        if ($data_type == 'json') {
            $content = json_decode($content);
        }
        if ($data_type == 'array') {
            $content = json_decode($content, true);
        }
        return $content;
    } else {
        return FALSE;
    }
}