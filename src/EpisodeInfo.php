<?php

/**
 * EpisodeInfo.php
 * Created by: koen
 * Date: 1/3/16
 * Time: 5:04 PM
 */
class EpisodeInfo
{

    private $imdb;
    private $tvrage;
    private $tvdb;
    private $themoviedb;


    public function __construct($episodeInfo)
    {
        $this->imdb = $episodeInfo->imdb;
        $this->tvrage = $episodeInfo->tvrage;
        $this->tvdb = $episodeInfo->tvdb;
        $this->themoviedb = $episodeInfo->themoviedb;
    }

    /**
     * @return mixed
     */
    public function getImdb()
    {
        return $this->imdb;
    }

    /**
     * @return mixed
     */
    public function getTvrage()
    {
        return $this->tvrage;
    }

    /**
     * @return mixed
     */
    public function getTvdb()
    {
        return $this->tvdb;
    }

    /**
     * @return mixed
     */
    public function getThemoviedb()
    {
        return $this->themoviedb;
    }
}