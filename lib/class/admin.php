<?php
class admin{
	var $db;
	
	public function __construct($db){
		$this->db = $db;
		$this->id = !empty($_SESSION[BACKEND_PREFIX.'ADMIN_ID']) ? $_SESSION[BACKEND_PREFIX.'ADMIN_ID'] : 0;
		$this->logged = !empty($this->id) ? 1 : 0;
		$this->info = $this->info();
		$this->role = $this->info['admin_role'];
        $this->role_type = $this->info['role_type'];
        $this->name = $this->info['admin_name'];
//DEFINE PERMISSION
        $this->permission = $this->permission();
//VIEW PERMISSION
        $this->vborrower = $this->permission['view_borrower'];
        $this->vloan = $this->permission['view_loan'];
        $this->vloanapproval = $this->permission['view_loan_approval'];
        $this->vrecovery = $this->permission['view_recovery'];
        $this->vrisk = $this->permission['view_risk'];
        $this->vapproval = $this->permission['view_approval'];
        $this->vreportloan = $this->permission['view_report_loan'];
        $this->vreportpayment = $this->permission['view_report_payment'];
        $this->vreportcollection = $this->permission['view_report_collection'];
        $this->vreportcollectionschedule = $this->permission['view_report_collection_schedule'];
        $this->vreportindividual = $this->permission['view_report_individual'];
        $this->vreporthead = $this->permission['view_report_head'];
        $this->vreportsummary = $this->permission['view_report_summary'];
        $this->vcollection = $this->permission['view_collection'];
//DASHBOARD PERMISSION
        $this->newborrowerd = $this->permission['new_borrower_d'];
        $this->totalloand = $this->permission['total_loan_d'];
        $this->totalborrowerd = $this->permission['total_borrower_d'];
        $this->totalrecoveredd = $this->permission['total_recovered_d'];
        $this->totalcollectiond = $this->permission['total_collection_d'];
        $this->totalbaddebtd = $this->permission['total_bad_debt_d'];
        $this->yearsofcollection = $this->permission['years_of_collection'];
        $this->activeborrower = $this->permission['active_borrower_d'];
        $this->borrowerstatistic = $this->permission['borrower_statistic_d'];
//MANAGE PERMISSION
        $this->mborrower = $this->permission['manage_borrower'];
        $this->mloan = $this->permission['manage_loan'];
        $this->mloanapproval = $this->permission['manage_loan_approval'];
        $this->mrecovery = $this->permission['manage_recovery'];
        $this->mrisk = $this->permission['manage_risk'];
        $this->mapproval = $this->permission['manage_approval'];
//DELETE PERMISSION
        $this->dborrower = $this->permission['delete_borrower'];
        $this->dloan = $this->permission['delete_loan'];

	}
	
	private function info(){
		$this->db->query("SELECT * FROM user_admins WHERE admin_id = " . $this->db->escape($this->id));
		$info = $this->db->getSingleRow();
		
		return $info;
	}

    private function permission(){
        $this->db->query("SELECT * FROM admin_role WHERE role_id = " . $this->db->escape($this->role));
        $permission = $this->db->getSingleRow();

        return $permission;
    }
}
?>