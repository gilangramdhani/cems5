<?php
$waktu = '2021-11-29 22:01';
$newwaktu = new Datetime($waktu);
$newwaktuunix = $newwaktu->format('U');
echo 'waktu unix'.$newwaktuunix;

$now = new Datetime();
$nowunix = $now->format('U');
echo 'waktu now unix'.$nowunix;

$timediff = $nowunix-$newwaktuunix;
echo 'timediff'.$timediff;
