<?php
/**
 * index.php
 * Created by: koen
 * Date: 12/5/15
 * Time: 12:46 AM
 */

include('src/RarBG.php');

$rar = new RarBG('MyRarBGApp');

$rar->setDebug()->setCategories(44);
$results = $rar->run();

foreach($results as $result){
    /**
     * @var $result Result
     */
    echo '<a href="'.$result->getDownload().'">'.$result->getFilename().'</a> ';
    if($result->isExtended())
        echo 'Size: '.round($result->getSize() * pow(10,-9),2 ).' Gb, Imdb: '. $result->getEpisodeInfo()->getImdb();

    echo '<br/>';
}