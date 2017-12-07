<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
$wachtwoord1 = "Pass";
$wachtwoord2 = "pass";

$hash1 = md5($wachtwoord1);
$hash2 = md5($wachtwoord2);

print($hash1);
print("<br />");
print($hash2);

