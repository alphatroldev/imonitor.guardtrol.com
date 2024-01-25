<?php
global $api;

class Api {
    public function curlQueryPost($url, $post_data) {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $post_data);
        $output = curl_exec($ch);
        if ($output === FALSE) {
            return "cURL Error: " . curl_error($ch);
        }
        curl_close($ch);

        $arr = json_decode($output);
        return $arr;
    }

    public function curlQueryGet($url) {
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_HEADER, false);
        $data = curl_exec($curl);
        curl_close($curl);

        $arr = json_decode($data);
        return $arr;
    }
}


$api = new Api();
?>
