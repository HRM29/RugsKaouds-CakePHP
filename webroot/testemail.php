<?php

if( @$send = mail("vipin2vipin@gmail.com", "test gmail", "this is  test message for gmail to see how is gmail emails are working")){
    echo "Email sent";
 }else{
   //do something
   echo "Error sending";
 }

?>