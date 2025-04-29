<?php
/* sendMail Class - by André Cupini - andre@neobiz.com.br */
class sendMail
{
    var $to;
    var $cc;
    var $bcc;
    var $subject;
    var $from;
    var $headers;
    var $html;

    function _sendMail($from, $to, $cc, $bcc, $subject) 
    {
        $this->to       = $to;
        $this->cc       = $cc;
        $this->bcc      = $bcc;
        $this->subject  = $subject;
        $this->from     = $from;
        $this->headers  = NULL;  
        $this->html     = FALSE;
    }

    function setHeaders() 
    {
        //$this->headers = "From: $this->from\r\n";
		$this->headers = "From: $this->from" . PHP_EOL;
        if($this->html === TRUE) {
            //$this->headers.= "MIME-Version: 1.0\r\n";
			$this->headers.= 'MIME-Version: 1.0' . PHP_EOL;
			
            //$this->headers.= "Content-type: text/html; charset=iso-8859-1\r\n";
			$this->headers .= 'Content-Type: text/html; charset=ISO-8859-1' . PHP_EOL;
        }
        //if(!empty($this->cc))  $this->headers.= "Cc: $this->cc\r\n";
        //if(!empty($this->bcc)) $this->headers.= "Bcc: $this->bcc\r\n";
		if(!empty($this->cc))  $this->headers.= "Cc: $this->cc" . PHP_EOL;
        if(!empty($this->bcc)) $this->headers.= "Bcc: $this->bcc" . PHP_EOL;
    }

    function parseBody($content) 
    {
        $this->body = $content;
    }

    function send() 
    {
        if(mail($this->to, $this->subject, $this->body, $this->headers)) return TRUE;
        else return FALSE;
    }

    function set($key, $value) 
    {
        if($value) $this->$key = $value;
        else unset($this->$key);
    }
}
?>