<?php

/**
 * RarBG.php
 * Created by: koen
 * Date: 12/5/15
 * Time: 12:33 AM
 */
class RarBG
{
    private $token;
    private $url = 'https://torrentapi.org/pubapi_v2.php';

    /**
     * Constructor for the API
     */
    public function __construct()
    {
        $this->token = $this->getToken();
    }

    /**
     * GetFromApi
     * Does the requests to the rarbg api
     *
     * @param array $params
     * @return mixed $data object with the data from the API
     * @throws Exception
     * @internal param string $url the url that will be called
     */
    private function getFromApi($params = []){

        $url = $this->url;

        if(count($params) > 0){
            $paramString = '?';
            foreach($params as $key => $value)
                $paramString .= $key .'='.$value.'&';

            $url .= $paramString;
        }else{
            die('Invalid Parameters');
        }

        if (!$data = file_get_contents($url)) {
                die("HTTP API request failed.");
        } else {
            $data = json_decode($data);
            if(isset($data->error)){
                die("Code ".$data->error_code.", ".$data->error);
            }else{
                return $data;
            }
//            if($data->status != 'ok')
//                throw new Exception("API request failed. Error was: " . $data->status_message);
//            return $data->data;
        }
    }

    /**
     * Get a (new) token from rarbg api
     *
     * @return mixed
     * @throws Exception
     */
    private function getToken()
    {
        return $this->getFromApi([
            'get_token' => 'get_token'
        ])->token;
    }
}