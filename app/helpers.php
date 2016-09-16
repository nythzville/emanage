<?php

// My common functions
function seconds_to_words( $seconds )
{
    /*** return value ***/
    $ret = "";

    /*** get the hours ***/
    $hours = intval(intval($seconds) / 3600);
    if($hours > 0)
    {
        $ret .= "$hours hours ";
    }
    /*** get the minutes ***/
    $minutes = bcmod((intval($seconds) / 60),60);
    if($hours > 0 || $minutes > 0)
    {
        $ret .= "$minutes mins ";
    }
  
    /*** get the seconds ***/
    $seconds = bcmod(intval($seconds),60);
    $ret .= "$seconds secs";

    return $ret;
}