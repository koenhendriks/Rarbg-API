<?php

/**
 * filters.php
 * Created by: koen
 * Date: 1/15/16
 * Time: 8:38 PM
 */
class Filters
{
    private $type;
    private $encoding;
    private $quality;
    private $filters = [];

    /**
     * @var array categories as taken from RarBg
     */
    private $categories = [
        'XXX' => 4,
        'Movies/XVID' => 14,
        'Movies/XVID/720' => 48,
        'Movies/x264' => 17,
        'Movies/x264/1080' => 44,
        'Movies/x264/720' => 45,
        'Movies/x264/3D' => 47,
        'Movies/Full_BD' => 42,
        'Movies/BD_Remux' => 46,
        'TV_Episodes' => 18,
        'TV_HD_Episodes' => 41,
        'Music/MP3' => 23,
        'Music/FLAC' => 25,
        'Games/PC_ISO' => 27,
        'Games/PC_RIP' => 28,
        'Games/PS3' => 40,
        'Games/XBOX-360' => 32,
        'Software/PC_ISO' => 33,
        'e-Books' => 35
    ];

    /**
     * Filters constructor
     *
     * @param string $type of the filter
     * @param string $encoding optional encoding of the filter
     * @param string $quality optional quality of the filter
     *
     * @throws Exception
     */
    public function __construct($type,$encoding='',$quality =''){
        if($type != '')
            $this->type = $type;
        else
            throw new Exception("Failed applying filter. No type was set.");

        if($encoding != '')
            $this->encoding = $encoding;

        if($quality != '')
           $this->quality = $quality;

        $this->setCategory();
    }


    /**
     * Sets the given filter to a string
     *
     * @return array with integers of the categories
     * @throws Exception
     */
    public function setCategory(){

        if($this->type == 'Movies' && !isset($this->encoding))
            throw new Exception("Failed applying filter. Movies filter needs an encoding.");

        $filterString = $this->type;

        if(isset($this->encoding))
            $filterString .= '/'.$this->encoding;

        if(isset($this->quality) && $this->type != 'Movies')
            throw new Exception('Failed applying filter. Only Movies suppert quality filter');
        elseif(isset($this->quality))
            $filterString .= '/'.$this->quality;

        array_push($this->filters,$this->categories[$filterString]);

        return $this->filters;
    }



    /*
    |--------------------------------------------------------------------------
    | Getters and Setters
    |--------------------------------------------------------------------------
    |
    | Just basic getters and setters for the properties from here on out that can be
    | used if you want to do some manual calls. The RarBg->run() method will make
    | use of these properties while maintaining anti flood and token handling.
    |
    |
    */

    /**
     * @return mixed
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * @param mixed $type
     */
    public function setType($type)
    {
        $this->type = $type;
    }

    /**
     * @return mixed
     */
    public function getEncoding()
    {
        return $this->encoding;
    }

    /**
     * @param mixed $encoding
     */
    public function setEncoding($encoding)
    {
        $this->encoding = $encoding;
    }

    /**
     * @return mixed
     */
    public function getQuality()
    {
        return $this->quality;
    }

    /**
     * @param mixed $quality
     */
    public function setQuality($quality)
    {
        $this->quality = $quality;
    }

    /**
     * @return mixed
     */
    public function getFilters()
    {
        return $this->filters;
    }

    /**
     * @param mixed $filters
     */
    public function setFilters($filters)
    {
        $this->filters = $filters;
    }
}