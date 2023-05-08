<?php
include_once("action.php");
include_once("password_recovery.php");

function envoi_mail($email,$code){

    $header = [
        "From" => "no-reply@shootmania-tournament.com",
        "Content-Type" => "text/html; charset=utf-8"
    ];

    $message = '
    <html>
        <div>
            clic on the link to recover your password : 
            <a href="http://testsite/view/password_recover.php?section=code&amp;code='.$code.'&amp;mail='.$email.'">here</a> <br/>
            here is the code : '.$code.'
        </div>
    </html>
    ';
    $to = "iraeshootmania@gmail.com";
    $email = $to;
    $subject = "password recover";
    if(mail($email,$subject,$message,$header)){
        return true;
    } else {
        return false;
    }
}
