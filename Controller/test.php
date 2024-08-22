<?php
function authSendEmail($from, $namefrom, $to, $nameto, $subject, $headers, $message)
{


    $smtpServer = "mail.yourhostname.com";
    $port = "25"; //Or whatever the default port on your server is
    $timeout = "30";
    $username = "origin@yourdomain.com";
    $password = "myemailpassword";
    $localhost = "yourhostname.com";
    $newLine = "\r\n";
    $date = date('r', time());


    //Connect to the host on the specified port
    $smtpConnect = fsockopen($smtpServer, $port, $errno, $errstr, $timeout);
    $smtpResponse = fgets($smtpConnect, 515);
    if (empty($smtpConnect)) {
        $output = "Failed to connect: $smtpResponse";
        return $output;
    } else {
        $logArray['connection'] = "Connected: $smtpResponse";
    }

    //Request Auth Login
    fputs($smtpConnect, "AUTH LOGIN" . $newLine);
    $smtpResponse = fgets($smtpConnect, 515);
    $logArray['authrequest'] = "$smtpResponse";

    //Send username
    fputs($smtpConnect, base64_encode($username) . $newLine);
    $smtpResponse = fgets($smtpConnect, 515);
    $logArray['authusername'] = "$smtpResponse";

    //Send password
    fputs($smtpConnect, base64_encode($password) . $newLine);
    $smtpResponse = fgets($smtpConnect, 515);
    $logArray['authpassword'] = "$smtpResponse";

    //Say Hello to SMTP
    fputs($smtpConnect, "HELO $localhost" . $newLine);
    $smtpResponse = fgets($smtpConnect, 515);
    $logArray['heloresponse'] = "$smtpResponse";

    //Email From
    fputs($smtpConnect, "MAIL FROM: $from" . $newLine);
    $smtpResponse = fgets($smtpConnect, 515);
    $logArray['mailfromresponse'] = "$smtpResponse";

    //Email To
    fputs($smtpConnect, "RCPT TO: $to" . $newLine);
    $smtpResponse = fgets($smtpConnect, 515);
    $logArray['mailtoresponse'] = "$smtpResponse";

    //The Email
    fputs($smtpConnect, "DATA" . $newLine);
    $smtpResponse = fgets($smtpConnect, 515);
    $logArray['data1response'] = "$smtpResponse";

    fputs($smtpConnect, "To: $to\nFrom: $from\nSubject: $subject\n$headers\n\n$message\n.\n");
    $smtpResponse = fgets($smtpConnect, 515);
    $logArray['data2response'] = "$smtpResponse";

    // Say Bye to SMTP
    fputs($smtpConnect, "QUIT" . $newLine);
    $smtpResponse = fgets($smtpConnect, 515);
    $logArray['quitresponse'] = "$smtpResponse";

    //Show log
    //  echo "<pre>$to<br/>";
    //  print_r ($logArray);
    //  echo "</pre><hr />";
    $output = $logArray;
    return $output;
}
$result=authSendEmail($from,$fname,$to,$nameto,$subject,$headers,$message) ; //Use SMTP
var_dump($result);
?>