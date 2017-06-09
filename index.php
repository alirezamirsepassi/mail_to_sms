<?php
/*
***###***
written by Alireza Mirsepassy ::: http://alirezamirsepasy.ir
***###***
*/

ini_set("soap.wsdl_cache_enabled", "0");
###################################
####### SETUP EMAIL ACCOUNT #######
###################################
$imap_server = "imap.gmail.com"; // Gmail impap server : imap.gmail.com
$imap_port = "993"; // imap port + ssl - gmail impap port : 993
$imap_user = "##########@gmail.com"; // Your email account with @***.com
$imap_pass = "##########"; // Your email password

###################################
######## SETUP SMS ACCOUNT ########
###################################
$parameters['username'] = "esms####"; // SMS account username
$parameters['password'] = "########";// SMS account password
$parameters['mobileno'] = "YOUR_PHONE_NUMBER"; // Number to send message to - (your phone number)
$parameters['pnlno'] = "YOUR_PANEL_NUMBER"; // Your SMS panel number
$parameters['isflash'] =false; // Don't send message as FLASH

###################################
############ MAIN BODY ############
###################################
$mbox = imap_open("{" . $imap_server . ":" . $imap_port . "/imap/ssl/novalidate-cert}INBOX", $imap_user, $imap_pass); // connect to the mail server
$sms_client = new SoapClient('http://webservice.0098sms.com/service.asmx?wsdl', array('encoding'=>'UTF-8')); // connect to the SMS server

$mc = imap_check($mbox); // check the mail server's inbox inorder to get total number of emails
	
$lastmailNumber = $mc->Nmsgs ; // All emails which recevied in the inbox = last email
$mailNumber = $lastmailNumber - 10 ; // Check only last 10 emails
	
$result = imap_fetch_overview($mbox,"$lastmailNumber:$mailNumber",0); // Save emails in $result variable

$result = array_reverse($result); // Reorder the array of emails inorder to read new emails first

$last_mail_timestamp = file_get_contents('lastMail'); // Get the last mail time stamp

// Run a loop reading emails from array
foreach ($result as $v)
{
	// Only read newer emails than timestamp in "lastMail"
	if (strtotime($v->date) > $last_mail_timestamp)
	{
		$from =  mb_decode_mimeheader($v->from);
		$subject = mb_decode_mimeheader($v->subject);
		
		$parameters['text'] = "شما ایمیل جدیدی از \"$from\" با عنوان \"$subject\" دارید";
		
		echo $sms_client->SendSMS($parameters)->SendSMSResult;
	}
}

// write last message timestamp
$data_to_be_written = strtotime($result[0]->date);
file_put_contents('lastMail',$data_to_be_written);

?>
