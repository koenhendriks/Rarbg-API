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
    private $mode;
    private $tokenExpireTime;
    private $searchString;
    private $imdbCode;
    private $tvdbCode;
    private $tmdbCode;
    private $categories;
    private $minimalSeeders;
    private $minimalLeechers;
    private $lastApiCall;

    private $debug = false;
    private $limit = 25;
    private $sort = 'last';
    private $ranked = 1;
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
        $paramString .= '&limit='.$this->limit;
        $paramString .= '&ranked='.$this->ranked;

        if(isset($this->searchString))
            $paramString .= '&search_string='.urlencode($this->searchString);

        if(isset($this->imdbCode))
            $paramString .= '&search_imdb='.$this->imdbCode;

        if(isset($this->tvdbCode))
            $paramString .= '&search_tvdb='.$this->tvdbCode;

        if(isset($this->tmdbCode))
            $paramString .= '&search_themoviedb='.$this->tmdbCode;

        if(isset($this->categories))
            $paramString .= '&category='.$this->categories;

        if(isset($this->minimalSeeders))
            $paramString .= '&min_seeders='.$this->minimalSeeders;

        if(isset($this->minimalLeechers))
            $paramString .= '&min_leechers='.$this->minimalLeechers;

        if(!isset($this->mode))
            $this->autoMode(); // Search or list ?

        $paramString .= '&mode='.$this->mode;

        $url .= $paramString;

        if($this->debug)
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
     * Checks if the mode should be set to search or list and sets the property accordingly
     *
     * @return string
     */
    public function autoMode(){
        if(isset($this->searchString) || isset($this->imdbCode) || isset($this->tvdbCode) || isset($this->tmdbCode) || isset($this->categories)){
            $this->setMode('search');
            return 'search';
        }else{
            $this->setMode('list');
            return 'list';
        }
    }

    /**
     * Run API call with set properties
     */
    public function run(){
        return $this->getFromApi();
    }

    /*
    |--------------------------------------------------------------------------
    | Getters and Setters
    |--------------------------------------------------------------------------
    |
    | Just basic getters and setters for the properties from here on out
    |
    */

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
     * @return mixed
     */
    public function getSearchString()
    {
        return $this->searchString;
    }

    /**
     * @param mixed $searchString
     * @return RarBG
     */
    public function setSearchString($searchString)
    {
        $this->searchString = $searchString;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getImdbCode()
    {
        return $this->imdbCode;
    }

    /**
     * @param mixed $imdbCode
     * @return RarBG
     */
    public function setImdbCode($imdbCode)
    {
        $this->imdbCode = $imdbCode;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getTvdbCode()
    {
        return $this->tvdbCode;
    }

    /**
     * @param mixed $tvdbCode
     * @return RarBG
     */
    public function setTvdbCode($tvdbCode)
    {
        $this->tvdbCode = $tvdbCode;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getTmdbCode()
    {
        return $this->tmdbCode;
    }

    /**
     * @param mixed $tmdbCode
     * @return RarBG
     */
    public function setTmdbCode($tmdbCode)
    {
        $this->tmdbCode = $tmdbCode;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getCategories()
    {
        return $this->categories;
    }

    /**
     * @param mixed $categories
     * @return RarBG
     */
    public function setCategories($categories)
    {
        $this->categories = $categories;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getMinimalSeeders()
    {
        return $this->minimalSeeders;
    }

    /**
     * @param mixed $minimalSeeders
     * @return RarBG
     */
    public function setMinimalSeeders($minimalSeeders)
    {
        $this->minimalSeeders = $minimalSeeders;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getMinimalLeechers()
    {
        return $this->minimalLeechers;
    }

    /**
     * @param mixed $minimalLeechers
     * @return RarBG
     */
    public function setMinimalLeechers($minimalLeechers)
    {
        $this->minimalLeechers = $minimalLeechers;
        return $this;
    }

    /**
     * @return int
     */
    public function getLimit()
    {
        return $this->limit;
    }

    /**
     * @param int $limit
     * @return RarBG
     */
    public function setLimit($limit)
    {
        $this->limit = $limit;
        return $this;
    }

    /**
     * @return string
     */
    public function getSort()
    {
        return $this->sort;
    }

    /**
     * @param string $sort
     * @return RarBG
     */
    public function setSort($sort)
    {
        $this->sort = $sort;
        return $this;
    }

    /**
     * @return string
     */
    public function getMode()
    {
        return $this->mode;
    }

    /**
     * @param string $mode
     * @return RarBG
     */
    public function setMode($mode)
    {
        $this->mode = $mode;
        return $this;
    }

    /**
     * @param bool|true $debug
     * @return RarBg
     */
    public function setDebug($debug = true)
    {
        $this->debug = true;
        return $this;
    }

    /**
     * @return bool
     */
    public function getDebug(){
        return $this->debug;
    }

    /**
     * @return int
     */
    public function getRanked()
    {
        return $this->ranked;
    }

    /**
     * @param int $ranked
     * @return RarBg
     */
    public function setRanked($ranked)
    {
        $this->ranked = $ranked;
        return $this;
    }
}
