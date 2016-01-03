<?php
/**
 * index.php
 * Created by: koen
 * Date: 12/5/15
 * Time: 12:46 AM
 */

include('src/RarBG.php');

$rar = new RarBG('MyRarBGApp');

$rar->setDebug()->setCategories('Movies/x264/1080');
$results = $rar->run();

foreach($results as $result){
    /**
     * @var $result Result
     */
    echo '<a href="'.$result->getDownload().'">'.$result->getFilename().'</a><br/>';
    if($result->isExtended())
        echo round($result->getSize() * pow(10,-9),2 ).' Gb <br/>';
}