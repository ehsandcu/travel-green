<?php

function getInitialNameWordImage($name=null)
{
    return "https://eu.ui-avatars.com/api/?name=". $name ."";
}

function carbonEmission($tansportMode, $workDays, $distance, $weeksPerYear=48)
{
    return $tansportMode * $distance * 2 * $workDays * $weeksPerYear;
}