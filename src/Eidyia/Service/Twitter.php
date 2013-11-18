<?php
namespace Eidyia\Service;
class Twitter
{
    public function getList($screenName)
    {
        $url = 'https://api.twitter.com/1.1/lists/memberships.json';
        $getData = '?screen_name=' . $screenName;
        $settings = array (
            'oauth_access_token' => "9594462-rIxJB5PzWm4XwaTl8pH3vShd6lTFUvH2B8ZVwPQvXy",
            'oauth_access_token_secret' => "5wTfRftYkH2k9axuZ28wamPTwi9YrkjvvuHbLlhRTJg",
            'consumer_key' => "oIjXVT3tXags4OjXMJ4eg",
            'consumer_secret' => "qZ27scf9bIOLSW8Lwv2ViYe3x6YVVGZiH4N32Dtro40"
        );
        $requestMethod = 'GET';

        $twitter = new \TwitterAPIExchange($settings);
        $cacheFile = '/tmp/twitterlist-' . $screenName . '.json';
        if (1800 < (\time() - \filemtime($cacheFile))) {
            \unlink($cacheFile);
        }
        if (!file_exists($cacheFile) || false === ($data = file_get_contents($cacheFile))) {
            $cursor = -1;
            $twitterLists = array ();
            while ($cursor !== 0) {
                $data = $twitter->setGetfield($getData . '&cursor=' . $cursor)
                    ->buildOauth($url, $requestMethod)
                    ->performRequest();
                $json = json_decode($data);
                var_dump($json);
                $cursor = $json->next_cursor;
                foreach ($json->lists as $list) {
                    $twitterLists[] = $list;
                }
            }
            file_put_contents($cacheFile, json_encode($twitterLists), FILE_APPEND);
        }

        $lists = json_decode($data);
        $array = array ();
        foreach ($lists as $list) {
            $array[] = strtolower(basename($list->uri));
        }
        $elements = array ();
        foreach ($array as $entry) {
            if (!isset ($elements[$entry])) {
                $elements[$entry] = 1;
            } else {
                $elements[$entry]++;
            }
        }
        \arsort($elements, SORT_NUMERIC);
        return \array_slice($elements, 0, 10);
    }
}