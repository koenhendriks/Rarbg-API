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

    public function __construct($result)
    {
        $this->filename = $result->filename;
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
}