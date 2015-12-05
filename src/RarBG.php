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
    private $appId;
    private $tokenExpireTime;
    private $searchString;
    private $imdbCode;
    private $tvdbCode;
    private $tmdbCode;
    private $categories;
    private $minimalSeeders;
    private $minimalLeechers;

    private $limit = 25;
    private $sort = 'last';
    private $mode = 'list';
    private $url = 'https://torrentapi.org/pubapi_v2.php';

    /**
     * Constructor for the API
     */
    public function __construct()
    {
        $this->token = $this->getNewToken();
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
    private function getNewToken()
    {
        $url = $this->url .'?get_token=get_token';

        if (!$data = file_get_contents($url)) {
            $error = error_get_last();
            throw new Exception("HTTP request failed. Error was: " . $error['message']);
        } else {
            $data = json_decode($data);

            if(isset($data->error)){
                throw new ErrorException($data->error,$data->error_code);
            }elseif (isset($data->token)){
                $this->tokenExpireTime = time()+900; // token expires 15 minutes
                $this->token = $data->token;
                return $data->token;
            }

            return false;
        }
    }

    /**
     * @return mixed
     */
    public function getToken()
    {
        return $this->token;
    }

    /**
     * @param mixed $token
     * @return RarBG
     */
    public function setToken($token)
    {
        $this->token = $token;
        return $this;
    }


}
