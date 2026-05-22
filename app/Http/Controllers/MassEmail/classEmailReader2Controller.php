<?php
class Email_reader
{

	// imap server connection
	public $conn;

	// inbox storage and inbox message count
	private $inbox;
	private $msg_cnt;

	// email login credentials
	private $server;
	private $user;
	private $pass;
	private $port; // adjust according to server settings

	// connect to the server and get the inbox emails
	function __construct($server, $user, $pass, $port = 993) 
	{
	    $this->server = $server;
        $this->user = $user;
        $this->pass = $pass;
        $this->port = $port;
        
		$this->connect();
		// $this->inbox();
	}

	// close the server connection
	function close() {
		$this->inbox = array();
		$this->msg_cnt = 0;

		imap_close($this->conn);
	}

	// open the server connection
	// the imap_open function parameters will need to be changed for the particular server
	// these are laid out to connect to a Dreamhost IMAP server
	function connect()
	{
		//notls
		$this->conn = imap_open('{'.$this->server.'/ssl}', $this->user, $this->pass);
		if (!$this->conn) {
            die('IMAP connection failed: ' . imap_last_error());
        }
	}

	// move the message to a new folder
	function move($msg_index, $folder='INBOX.Processed') {
		// move on server
		imap_mail_move($this->conn, $msg_index, $folder);
		imap_expunge($this->conn);

		// re-read the inbox
		$this->inbox();
	}

	// get a specific message (1 = first email, 2 = second email, etc.)
	function get($msg_index=NULL) {
		if (count($this->inbox) <= 0) {
			return array();
		}
            elseif ( ! is_null($msg_index) && isset($this->inbox[$msg_index])) {
			return $this->inbox[$msg_index];
		}

		return $this->inbox[0];
	}

	// read the inbox
	function inbox($start,$limit)
	{
		$this->msg_cnt = imap_num_msg($this->conn);

		$in = array();
		for($i = $start; $i <= $limit; $i++) {
			$in[] = array(
				'index'     => $i,
				'header'    => imap_headerinfo($this->conn, $i),
				'body'      => imap_body($this->conn, $i),
				'structure' => imap_fetchstructure($this->conn, $i)
			);
		}

		return $this->inbox = $in;
	}

	function sent_emails($toEmail)
	{
		$emails = array();
// 		$date = date("j F Y",strtotime("-1 Day"));
		$date = date("j F Y");
// 		$toEmail = 'recipient@example.com';
        // $searchCriteria = ' ON "'.$date.'" SUBJECT "Axon Clinical Research Patient Mail" ';
        // $searchCriteria = ' ON "'.$date.'"  FROM "' . $toEmail . '"';
        // $searchCriteria = ' SUBJECT "Testing Email on Axon CRM With Reply | Axon Clinical Research Patient Mail"  ';
        
        // $searchCriteria = ' ON "'.$date.'"  TO "' . $toEmail . '"';
        $searchCriteria = '  TO "' . $toEmail . '"';

		$MailList=imap_search($this->conn,$searchCriteria);
		// $SUBJECT1 = imap_search($this->conn, 'SUBJECT "JOB #"');
		// $SUBJECT2 = imap_search($this->conn, 'SUBJECT "created"');
		// $MailList = array_merge($SUBJECT1, $SUBJECT2);
		$MailList = (array) $MailList; 
		if(count($MailList)>0 && $MailList[0]!='')
		{ 
		    for ($i = 0; $i < count($MailList); $i++) {
    			$ci = $MailList[$i];
    			$emails[] = array(
    				'index'     => $ci,
    				'overview'    => imap_fetch_overview($this->conn, $ci),
    				'header'    => imap_headerinfo($this->conn, $ci),
    				'body'      => imap_body($this->conn, $ci),
    				'structure' => imap_fetchstructure($this->conn, $ci)
    			);
    			
    			
    		}    
		}
		
		return $emails;
	}
	function received_reply_emails($toEmail,$subject)
	{
		$emails = array();
		// 		$date = date("j F Y",strtotime("-1 Day"));
		$date = date("j F Y");
// 		$toEmail = 'recipient@example.com';
        // $searchCriteria = ' ON "'.$date.'" SUBJECT "Axon Clinical Research Patient Mail" ';
        $searchCriteria = ' FROM "' . $toEmail . '"  SUBJECT "Re: ' . $subject . '" ';
        // $searchCriteria = ' ON "'.$date.'"  FROM "' . $toEmail . '"  SUBJECT "Re: ' . $subject . '" ';
        // $searchCriteria = ' SUBJECT "Testing Email on Axon CRM With Reply | Axon Clinical Research Patient Mail"  ';
        
        // $searchCriteria = ' ON "'.$date.'"  TO "' . $toEmail . '"';

		$MailList=imap_search($this->conn,$searchCriteria);
		// $SUBJECT1 = imap_search($this->conn, 'SUBJECT "JOB #"');
		// $SUBJECT2 = imap_search($this->conn, 'SUBJECT "created"');
		// $MailList = array_merge($SUBJECT1, $SUBJECT2);
		$MailList = (array) $MailList;
		if(count($MailList)>0 && $MailList[0]!='')
		{ 
		    for ($i = 0; $i < count($MailList); $i++) {
    			$ci = $MailList[$i];
    			$emails[] = array(
    				'index'     => $ci,
    				'overview'    => imap_fetch_overview($this->conn, $ci),
    				'header'    => imap_headerinfo($this->conn, $ci),
    				'body'      => imap_body($this->conn, $ci),
    				'structure' => imap_fetchstructure($this->conn, $ci)
    			);
    			
    			
    		}    
		}
		
		return $emails;
	}

	function GetMailCount()
	{
		return $this->msg_cnt = imap_num_msg($this->conn);
	}
	
	function invoice_emails()
	{
		$emails = array();
		$MailList=imap_search($this->conn,'SUBJECT "Invoice with number INV-"');
		$MailList = (array) $MailList;
		for ($i = 0; $i < count($MailList); $i++) {
			$ci = $MailList[$i];
			$emails[] = array(
				'index'     => $ci,
				'header'    => imap_headerinfo($this->conn, $ci),
				'body'      => imap_body($this->conn, $ci),
				'structure' => imap_fetchstructure($this->conn, $ci)
			);
		}
		return $emails;
	}
}

?>