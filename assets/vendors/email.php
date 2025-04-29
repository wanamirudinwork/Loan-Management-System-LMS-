<?php
/* 
------------------------------------------------------------------
NOTE TO KEVIN CHEW AND DANNIES
------------------------------------------------------------------

--------------------------------------------------------
Change the sender email (Customer email)				|
--------------------------------------------------------
"public function __construct()"

$this->emailName 		-> The email name 
$this->email 			-> The email address 
														|
---------------------------------------------------------

--------------------------------------------------------
Send email function (SMTP/ POP) Setting					|
--------------------------------------------------------
Refer to private function eSend()

comment "$mailer->IsSMTP();" to enable POP  
if using "$mailer->IsSMTP();" you need to set the smtp
login info, refer to the commented part

$mailer->Host
$mailer->SMTPSecure
$mailer->Port
$mailer->SMTPAuth 
$mailer->Username
$mailer->Password
														|
---------------------------------------------------------

--------------------------------------------------------
NOTES													|
--------------------------------------------------------
private function css() 	->	CSS of the email template
private function eHeader() -> Email template header
private function eFooter() -> Email template footer

3 aboves no need to do the change. Is the template for
all emails.

Others public function will be the email body
														|
---------------------------------------------------------

--------------------------------------------------------
HOW TO USE												|
--------------------------------------------------------
Both files required
require_once 'assets/vendors/phpmailer/autoload.php';
require_once 'assets/vendors/email.php';

Refer to 
index.php
lib/class/post.php
lib/class/cms.php

post.php or cms.php

Example:
$data = array(); -> set the data which you want to bring
or use in the email.

//Call email call and the email you want to send.
$emailclass = new email()
$emailclass->forgotpassword($data)
														|
---------------------------------------------------------
*/	
class email{
	private $emailName, $receivers, $email;
	private $mailer;
	
	public function __construct(){
		// $this->emailName = "Inventory";
		 $this->email = "admin@cambrexhenkel.com"; 
	}
	
	private function eHeader(){
		return '<html>
			<body>
    			<div class="container">
					
					<br>';									
	}
	
	
	private function eFooter(){
		return '<br>
			<div class="footer">
			
			</div>
			</div>
    		<br>
    		<br>
		</body>
		</html>';
	}
	
	private function eSend($subject, $html, $from, $fromName, $toArray = "", $reply = "", $cc = ""){
		$mailer = new PHPMailer();
		//$mailer->IsSMTP(); // enable SMTP
		//$mailer->SMTPDebug = 1; // debugging: 1 = errors and messages, 2 = messages only
		$mailer->From = $from;
		$mailer->FromName = $fromName;
		/*
		$mailer->Host = "smtp.gmail.com";
		$mailer->SMTPSecure = 'ssl'; // secure transfer enabled REQUIRED for Gmail
		$mailer->Port = 465; // or 587
		$mailer->SMTPAuth = true; // authentication enabled
		$mailer->Username = "";
		$mailer->Password = "";
		*/
		
		if($toArray){
			foreach($toArray as $to){
				$mailer->AddAddress($to);
			}
		}
		$mailer->AddReplyTo($reply);
		if($cc){
			$mailer->AddCC($cc);
		}
		$mailer->IsHTML(true);                                  // set email format to HTML
		$mailer->Subject = $subject;
		$mailer->Body    = $html;
		$mailer->Send();
	}
	
	//Rent product status update
	public function statusUpdate($data){
		$subject = "A Rent Product Has Been Updated, Check It Out Now";
		$html = $this->eHeader();
		$html.= $data['title'].' has been updated on '.$data['date_updated'].'<br>
		Here is updated details: <br>
		Title: '.$data['title'].'<br>
		Gas Type: '.$data['gas_type'].'<br>
		Status: '.$data['status'].'<br>
		Due Date: '.$data['due_date'].'<br>
		<strong>Update by</strong> '.$data['admin'];
		
		$this->eSend($subject, $html, $this->email, $this->emailName, array($data['email']), $this->email);
	}
	
}

?>
