<?php
  $firstname=$_POST['fname'];
  $lastname=$_POST['lname'];
  $ident_number=$_POST['idnumber'];
  $mobile_phone=$_POST['mphone'];
  $email=$_POST['email'];
  $password = MD5($_POST['pswd']);
 
  echo"<br> . $firstname";
  echo"<br> . $lastname";
  echo"<br> . $ident_number";
    echo"<br> . $mobile_phone";
    echo"<br> . $email";
    echo"<br> . $password";
