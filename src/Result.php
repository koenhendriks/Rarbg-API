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
     * @param mixed $filename
     * @return Result
     */
    public function setFilename($filename)
    {
        $this->filename = $filename;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getCategory()
    {
        return $this->category;
    }

    /**
     * @param mixed $category
     * @return Result
     */
    public function setCategory($category)
    {
        $this->category = $category;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getDownload()
    {
        return $this->download;
    }

    /**
     * @param mixed $download
     * @return Result
     */
    public function setDownload($download)
    {
        $this->download = $download;
        return $this;
    }


}