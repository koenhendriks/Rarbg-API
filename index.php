<?php
/**
 * index.php
 * Created by: koen
 * Date: 12/5/15
 * Time: 12:46 AM
 */

include('src/RarBG.php');

$rar = new RarBG('MyRarBGApp');

$data = $rar->run();

foreach($data as $result){
    /**
     * @var $result Result
     */
    echo '<a href="'.$result->getDownload().'">'.$result->getFilename().'</a><br/>';
}