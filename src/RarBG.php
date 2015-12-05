<?php

require_once('Result.php');
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
    private $lastApiCall;

    private $limit = 25;
    private $sort = 'last';
    private $mode = 'list';
    private $url = 'https://torrentapi.org/pubapi_v2.php';

    /**
     * Constructor for the API
     * @param $appId string to constrcut the class with an app id.
     * @throws Exception
     */
    public function __construct($appId)
    {
        if(!isset($appId))
            throw new Exception('No app Id set. When querying the api please use the appId parameter with your app name so we can generate statistics for it.');

        $this->appId = $appId;
    }

    /**
     * GetFromApi
     * Does the requests to the rarbg api
     *
     * @return mixed $data object with the data from the API
     * @throws Exception
     * @internal param string $url the url that will be called
     */
    private function getFromApi(){

        if($this->tokenExpireTime <= time())
            $this->token = $this->getNewToken();

        $url = $this->url;

        // Set parameters for call
        $paramString = '?token='.$this->token;
        $paramString .= '&sort='.$this->sort;
        $paramString .= '&mode='.$this->mode;
        $paramString .= '&limit='.$this->limit;

        if(isset($this->searchString))
            $paramString .= '&searchString='.$this->searchString;

        if(isset($this->imdbCode))
            $paramString .= '&imdbCode='.$this->imdbCode;

        if(isset($this->tvdbCode))
            $paramString .= '&tvdbCode='.$this->tvdbCode;

        if(isset($this->tmdbCode))
            $paramString .= '&tmdbCode='.$this->tmdbCode;

        if(isset($this->categories))
            $paramString .= '&categories='.$this->categories;

        if(isset($this->minimalSeeders))
            $paramString .= '&minimalSeeders='.$this->minimalSeeders;

        if(isset($this->minimalLeechers))
            $paramString .= '&minimalLeechers='.$this->minimalLeechers;


        $url .= $paramString;
        echo $url.'<br/>';
        if (!$data = file_get_contents($url)) {
            $error = error_get_last();
            throw new Exception("HTTP request failed. Error was: " . $error['message']);
        } else {

            if((time() - $this->lastApiCall) < 2)
                throw new Exception('The api has a 1 request per 2s limit.');

            $this->lastApiCall = time();
            $data = json_decode($data);

            if(isset($data->error)){
                throw new ErrorException($data->error,$data->error_code);
            }else{
                $results = [];
                foreach($data->torrent_results as $result){
                    array_push($results, new Result($result));
                }
                return $results;
            }
        }
    }

    public function getList(){
        $this->mode = 'list';
        return $this->getFromApi();
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

    /**
     * Run API call with set properties
     */
    public function run(){
        return $this->getFromApi();
    }
}
