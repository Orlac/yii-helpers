<?php
namespace application\helpers;

class Video{

    public static function  getVideoUrl ($data) {
        if (preg_match("/<iframe.*?src=\"([^\"]+)\".*?><\/iframe>/i", $data, $matches)) {
            return $matches[1];
        }
        if (preg_match("/<object.*?>.*?<param name=\"movie\" value=\"([^\"]+)\"( \/>|><\/param>).*?<\/object>/i", $data, $matches)) {
            return $matches[1];
        }
    }

    public static function withOutVideo( $data ){
        $data = preg_replace("/<iframe.*?src=\"([^\"]+)\".*?><\/iframe>/i", '', $data);
        $data = preg_replace("/<object.*?>.*?<param name=\"movie\" value=\"([^\"]+)\"( \/>|><\/param>).*?<\/object>/i", '', $data);
        return $data;
    }

    public static function getVideoId($url){
        if (!is_string($url) || empty($url)) return false;
        $url = str_replace("&amp;", "&", $url);
        $arr = parse_url($url);
        $arr['host'] = str_replace('www.', '', $arr['host']);
        $url = "";
        switch ($arr['host']) {
            case 'rutube.ru':
                if (preg_match("/\/tracks\/(.+)\.html/i", $arr[path], $matches)) {
                    return $matches[1];
                }
                break;
            case 'video.rutube.ru':
                if (preg_match("/\/(.+)/i", $arr['path'], $matches)) {
                    return $matches[1];
                }
                //$url = "http://img-1.rutube.ru/thumbs/".$link[0].$link[1]."/".$link[2].$link[3]."/".$link."-2.jpg";
                break;
            case 'youtube.com':
                if (preg_match("/\/(embed|v)\/(.+)\/?/i", $arr['path'], $matches)) {
                    return $matches[2];
                }
                break;
            case 'player.vimeo.com':
                if (preg_match("/\/video\/(.+)\/?/i", $arr['path'], $matches)) {
                    return  $matches[1];
                }
                break;
            case 'vimeo.com':
                parse_str($arr['query'], $query);
                return $query['clip_id'];
                break;
        }
    }

    public static function getVideoThumbUrl ($url) {
        if (!is_string($url) || empty($url)) return false;
        $url = str_replace("&amp;", "&", $url);
        $arr = parse_url($url);
        $arr[host] = str_replace('www.', '', $arr[host]);
        $url = "";
        switch ($arr[host]) {
            case 'rutube.ru':
                if (preg_match("/\/tracks\/(.+)\.html/i", $arr[path], $matches)) {
                    $xml = simplexml_load_file("http://rutube.ru/cgi-bin/xmlapi.cgi?rt_mode=movie&rt_movie_id=".$matches[1]."&utf=1");
                    if ($xml) {
                        $url = (string) $xml->response->movie->thumbnailLink;
                    }
                }
                break;
            case 'video.rutube.ru':
                if (preg_match("/\/(.+)/i", $arr[path], $matches)) {
                    $s[0] = substr($arr[path], 1, 2);
                    $s[1] = substr($arr[path], 3, 2);
                    $url = "http://tub.rutube.ru/thumbs/".$s[0]."/".$s[1]."/".$matches[1]."-1-1.jpg";
                }
                //$url = "http://img-1.rutube.ru/thumbs/".$link[0].$link[1]."/".$link[2].$link[3]."/".$link."-2.jpg";
                break;
            case 'youtube.com':
                if (preg_match("/\/(embed|v)\/(.+)\/?/i", $arr[path], $matches)) {
                    $url = "http://img.youtube.com/vi/".$matches[2]."/0.jpg";
                }
                break;
            case 'player.vimeo.com':
                if (preg_match("/\/video\/(.+)\/?/i", $arr[path], $matches)) {
                    $clip_id = $matches[1];
                }
                $xml = simplexml_load_file('http://vimeo.com/api/v2/video/'.$clip_id.'.xml');
                if ($xml) {
                    $url = (string) $xml->video->thumbnail_medium;
                }
                break;
            case 'vimeo.com':
                parse_str($arr[query], $query);
                $clip_id = $query['clip_id'];
                $xml = simplexml_load_file('http://vimeo.com/api/v2/video/'.$clip_id.'.xml');
                if ($xml) {
                    $url = (string) $xml->video->thumbnail_medium;
                }
                break;
            default:
                $url = "";
                break;
        }
        return $url;
    }

    public static function autoPlayUrl($url){
        $data = parse_url($url);
        $q = (string) \CArray::element('query', $data);
        (array) parse_str($q, $qdata);
        $qdata['autoplay'] = 1;
        return \CArray::element('scheme', $data).'://'.
            \CArray::element('host', $data).
            \CArray::element('path', $data).'?'.
            http_build_query($qdata);
    }
}
