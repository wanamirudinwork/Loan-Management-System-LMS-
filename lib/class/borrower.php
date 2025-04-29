<?php
class borrower{
	var $db;
	
	public function __construct($db){
		$this->db = $db;
		$this->settings = $this->settings();
		$this->logged = !empty($_SESSION[BACKEND_PREFIX.'ADMIN_ID']) ? true : false;
		$this->no_image = 'assets/img/no_image.jpg';
		
	}
	
	
	
	public function borrowers(){
		$this->db->query("SELECT * FROM borrowers");
		$keys = $this->db->getRowList();
		
		set('keys', $keys);
		
		return render('management/borrowers.php', 'layout/default.php');
	}

	
	
	public function customerInsert(){
		$states = $this->state('129');
		set('countries', $this->countries());
		set('states', $states);
		return render('management/customers-insert.php', 'layout/default.php');
	}
	
	public function customerUpdate($id){
		$this->db->query("SELECT * FROM user_data WHERE cust_id = " . $this->db->escape($id));
		$key = $this->db->getSingleRow();
		
		if($key){
			$key['country'] = !empty($key['country']) ? $key['country'] : 129;
			$states = $this->state($key['country']);

			$this->db->query("SELECT * FROM banking_details WHERE cust_id = " . $this->db->escape($id));
			$key['banking_details']= $this->db->getSingleRow();

			$this->db->query("SELECT * FROM contact_details WHERE cust_id = " . $this->db->escape($id));
			$key['contact_details']= $this->db->getSingleRow();

			$this->db->query("SELECT * FROM cur_debts_commitment WHERE cust_id = " . $this->db->escape($id));
			$key['current_debts']= $this->db->getSingleRow();

			$this->db->query("SELECT * FROM employment_details WHERE cust_id = " . $this->db->escape($id));
			$key['employment_details']= $this->db->getSingleRow();

			$this->db->query("SELECT * FROM documents WHERE cust_id = " . $this->db->escape($id));
			$key['documents']= $this->db->getSingleRow();

			set('key', $key);
			set('countries', $this->countries());
			set('states', $states);
			return render('management/customers-update.php', 'layout/default.php');
		}
	}


}
?>