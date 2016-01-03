<?php

/**
 * Results.php
 * Created by: koen
 * Date: 12/5/15
 * Time: 1:01 PM
 */
class Result
{
    private $filename;
    private $category;
    private $download;
    private $seeders;
    private $leechers;
    private $size;
    private $pubdate;
    private $ranked;
    private $info_page;

    /**
     * @var EpisodeInfo
     */
    private $episode_info;

    /**
     * Result constructor.
     * @param $result object from API
     * @param $format string to tell which format
     */
    public function __construct($result,$format)
    {
        if($format == 'json') {
            $this->filename = $result->filename;
        }else{
            $this->filename = $result->title;
            $this->seeders = $result->seeders;
            $this->leechers = $result->leechers;
            $this->size = $result->size;
            $this->pubdate = $result->pubdate;
            $this->ranked = $result->ranked;
            $this->info_page = $result->info_page;
            $this->episode_info = $result->episode_info;
        }

        $this->category = $result->category;
        $this->download = $result->download;

    }

    /**
     * @return mixed
     */
    public function getFilename()
    {
        return $this->filename;
    }

    /**
     * @return mixed
     */
    public function getCategory()
    {
        return $this->category;
    }

    /**
     * @return mixed
     */
    public function getDownload()
    {
        return $this->download;
    }

    /**
     * @return mixed
     */
    public function getSeeders()
    {
        return $this->seeders;
    }

    /**
     * @return mixed
     */
    public function getLeechers()
    {
        return $this->leechers;
    }

    /**
     * @return mixed
     */
    public function getSize()
    {
        return $this->size;
    }

    /**
     * @return mixed
     */
    public function getPubdate()
    {
        return $this->pubdate;
    }

    /**
     * @return mixed
     */
    public function getRanked()
    {
        return $this->ranked;
    }

    /**
     * @return mixed
     */
    public function getInfoPage()
    {
        return $this->info_page;
    }

    /**
     * @return EpisodeInfo
     */
    public function getEpisodeInfo()
    {
        return $this->episode_info;
    }


}