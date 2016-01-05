<?php

function IsNullOrEmptyString($string)
{
    return (!isset($string) || trim($string) == '');
}

?>
