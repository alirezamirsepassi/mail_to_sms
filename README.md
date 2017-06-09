PHP Mail to SMS function
===================

This code was written **specially** to work with [0098sms.com](https://www.0098sms.com/default.aspx) website ,but you can change the parameters to work with any other.

The connection between SMS server and your server is by PHP SOAP extension, so make sure to install or activate it before you run the script.If you had any problem using the SOAP extension ,you can use the *rest client* instead ,too.

----------


<i class="icon-pencil"></i> First run
-------------

If you wanted to run this script and you didn't want to receive 10 last messages in your phone just open index.php with your editor and comment **line 48** and run the code once ,then remove the comment you just did on line 48.

```
// Line 48
echo $sms_client->SendSMS($parameters)->SendSMSResult;
```
