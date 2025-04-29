<?php
class post{
	var $cms;

	public function __construct($cms){
		$this->cms = $cms;
		$this->db = $this->cms->db;
		$this->posts = !empty($_POST) ? $_POST : '';
		$this->settings = $this->settings();
		//Set the email class
		$this->emailClass = new email();
	}

	public function request($field){
		$val = !empty($_REQUEST[$field]) ? $_REQUEST[$field] : false;
		return $val;
	}

	public function settings(){
		$setting = array();
		$settings = array();

		$this->db->query("SELECT * FROM settings");
		$settings = $this->db->getRowList();

		foreach($settings as $keys){
			$setting[$keys['name']] = $keys['value'];
		}

		return $setting;
	}

	public function login(){
		$this->db->query("SELECT * FROM user_admins WHERE admin_username = ".$this->db->escape($this->request('username'))." AND admin_password = ".$this->db->escape(md5($this->request('password')))." AND admin_status = '1'");
		$admin = $this->db->getSingleRow();

		if($admin){
			$_SESSION[BACKEND_PREFIX.'ADMIN_ID'] = $admin['admin_id'];

			$this->db->query("UPDATE user_admins SET admin_last_activity = NOW() WHERE admin_username = ".$this->db->escape($this->request('username'))." AND admin_password = ".$this->db->escape(md5($this->request('password')))." AND admin_status = '1'");

			$return['error'] = false;
			$return['msg'] = "You have been logged in successfully.";
		}else{
			$return['error'] = true;
			$return['msg'] = "Invalid account.<br>Please try again.";
		}

		return json_encode($return);
	}

	public function delete(){
		$type = $this->request('type');

		$return['error'] = true;
		$return['msg'] =  "Invalid action!";

		if($type == 'admin'){
			if( $this->request('id') == '1' ){
				$return['error'] = true;
				$return['msg'] =  "This accoount cannot be deleted.";

			}else{
				$this->db->table("user_admins");
				$this->db->updateArray(array(
					"admin_status" => '999',
				));
				$this->db->whereArray(array(
					"admin_id" => $this->request('id'),
				));
				$this->db->update();

				$return['error'] = false;
				$return['msg'] =  "Admin successfully deleted.";
			}
		}

		if($type == 'role'){
			$this->db->table("admin_role");
			$this->db->updateArray(array(
				"role_status" => '99',
			));
			$this->db->whereArray(array(
				"role_id" => $this->request('id'),
			));
			$this->db->update();

			$return['error'] = false;
			$return['msg'] =  "Role successfully deleted.";
		}

        if($type == 'borrower'){
            $this->db->table("borrowers");
            $this->db->updateArray(array(
                "borrower_status" => '99',
            ));
            $this->db->whereArray(array(
                "borrower_id" => $this->request('id'),
            ));
            $this->db->update();

            $this->db->table("borrower_updates");
            $this->db->whereArray(array(
                "borrower_id" => $this->request('id'),
            ));
            $this->db->delete();

            $return['error'] = false;
            $return['msg'] =  "Borrower successfully deleted.";
        }

		if($type == 'application'){
			$this->db->table("application");
			$this->db->updateArray(array(
				"app_status" => '999',
			));
			$this->db->whereArray(array(
				"app_id" => $this->request('id'),
			));
			$this->db->update();

			$return['error'] = false;
			$return['msg'] =  "Application successfully deleted.";
		}

		if($type == 'member'){
			$this->db->table("members");
			$this->db->updateArray(array(
				"status" => '999',
			));
			$this->db->whereArray(array(
				"id" => $this->request('id'),
			));
			$this->db->update();

			$return['error'] = false;
			$return['msg'] =  "Member successfully deleted.";
		}

		if($type == 'featured'){
			$this->db->table("photo_featured");
			$this->db->whereArray(array(
				"photo_id" => $this->request('id'),
			));
			$this->db->delete();

			$return['error'] = false;
			$return['msg'] =  "Photo removed from featured list.";
		}

		if($type == 'product'){
			$this->db->table("products");
			$this->db->updateArray(array(
				"status" => '999',
			));
			$this->db->whereArray(array(
				"id" => $this->request('id'),
			));
			$this->db->update();

			$return['error'] = false;
			$return['msg'] =  "Product successfully deleted.";
		}

		if($type == 'rentproduct'){
			$this->db->table("products");
			$this->db->updateArray(array(
				"status" => '999',
			));
			$this->db->whereArray(array(
				"id" => $this->request('id'),
			));
			$this->db->update();

			$return['error'] = false;
			$return['msg'] =  "Product successfully deleted.";
		}

		if($type == 'category'){
			$this->db->table("category");
			$this->db->updateArray(array(
				"status" => '999',
			));
			$this->db->whereArray(array(
				"id" => $this->request('id'),
			));
			$this->db->update();

			$return['error'] = false;
			$return['msg'] =  "Category successfully deleted.";
		}

		if($type == 'brand'){
			$this->db->table("brand");
			$this->db->updateArray(array(
				"status" => '999',
			));
			$this->db->whereArray(array(
				"id" => $this->request('id'),
			));
			$this->db->update();

			$return['error'] = false;
			$return['msg'] =  "Brand successfully deleted.";
		}

		if($type == 'article'){
			$this->db->table("article");
			$this->db->updateArray(array(
				"art_status" => '999',
			));
			$this->db->whereArray(array(
				"art_id" => $this->request('id'),
			));
			$this->db->update();

			$return['error'] = false;
			$return['msg'] =  "Article successfully deleted.";
		}

		if($type == 'gascategory'){
			$this->db->table("gas_category");
			$this->db->updateArray(array(
				"status" => '999',
			));
			$this->db->whereArray(array(
				"id" => $this->request('id'),
			));
			$this->db->update();

			$return['error'] = false;
			$return['msg'] =  "Gas successfully deleted.";
		}

		if($type == 'message'){
			$this->db->table("messages");
			$this->db->updateArray(array(
				"status" => '999',
			));
			$this->db->whereArray(array(
				"id" => $this->request('id'),
			));
			$this->db->update();

			$return['error'] = false;
			$return['msg'] =  "Message successfully deleted.";
		}

		if($type == 'loan'){
            $this->db->query("SELECT * FROM loan WHERE loan_id = " .$this->db->escape($this->request('id')));
            $loan = $this->db->getSingleRow();

			$this->db->table("loan");
			$this->db->updateArray(array(
				"loan_status" => '99',
			));
			$this->db->whereArray(array(
				"loan_id" => $this->request('id'),
			));
			$this->db->update();

            if($loan['loan_status'] == '1'){
                $this->db->table("installment");
                $this->db->updateArray(array(
                    "installment_status" => '99',
                ));
                $this->db->whereArray(array(
                    "loan_id" => $this->request('id'),
                ));
                $this->db->update();

                $this->db->table("recovery");
                $this->db->updateArray(array(
                    "recovery_status" => '99',
                ));
                $this->db->whereArray(array(
                    "loan_id" => $this->request('id'),
                ));
                $this->db->update();
            }

			$return['error'] = false;
			$return['msg'] =  "Loan successfully deleted.";
		}

		/*if($type == 'mortgage'){
			$this->db->table("mortgage");
			$this->db->updateArray(array(
				"mortgage_status" => '999',
			));
			$this->db->whereArray(array(
				"loan_id" => $this->request('id'),
			));
			$this->db->update();

			$this->db->table("loan");
			$this->db->updateArray(array(
				"loan_status" => '1',
			));
			$this->db->whereArray(array(
				"loan_id" => $this->request('id'),
			));
			$this->db->update();

			$return['error'] = false;
			$return['msg'] =  "Customer successfully deleted.";
		}*/


		return json_encode($return);
	}

	public function profile(){

		if(!$this->request('name') || !$this->request('contact') || !$this->request('email')){
			$return['error'] = true;
			$return['msg'] = "
			All the information below required. 
			<ul>
			  <li>Full Name</li>
			  <li>Contact Number</li>
			  <li>Email Address</li>
			</ul>";

		}else if($this->request('Password') != $this->request('ConfirmPassword')){
			$return['error'] = true;
			$return['msg'] = "Password are not match.";

		}else{
			if(!$this->request('Password')){
				$password = $this->cms->admin->info['admin_password'];
			}else{
				$password = md5($this->request('Password'));
			}

			$this->db->table("user_admins");
			$this->db->updateArray(array(
				"admin_name" => $this->request('name'),
				"admin_email" => $this->request('email'),
				"admin_contact" => $this->request('contact'),
				"admin_password" => $password,
			));
			$this->db->whereArray(array(
				"admin_id" => $this->cms->admin->id,
			));
			$this->db->update();

			$return['error'] = false;
			$return['msg'] = "Profile updated";
		}

		return json($return);
	}

	public function admin(){
		$act = $this->request('act');

		if($act == 'delete'){
			if(empty($this->cms->admin->role) || $this->cms->admin->role != '1'){
				$return['error'] = true;
				$return['msg'] = "
				You are not permission to add new administrator account for this system. <br/> 
				It must be done by super admin. <br/> 
				Please contact your super admin to do this.";

			}else{

				$this->db->table("user_admins");
				$this->db->updateArray(array(
					"admin_status" => "999",
				));
				$this->db->whereArray(array(
					"admin_id" => $this->request('id'),
				));
				$this->db->update();

				$return['error'] = false;
				$return['msg'] = "Administrator account deleted from system.";

			}
			return json($return);
		}
	}

	public function adminInsert(){
		$this->db->query("SELECT * FROM user_admins WHERE admin_username = ".$this->db->escape($this->request('username'))."");
		$admin = $this->db->getSingleRow();

		if(empty($this->cms->admin->role) || $this->cms->admin->role != '1'){
			$return['error'] = true;
			$return['msg'] = "Your account does not allow you to create/update an administrator.";

		}else{
			if(!$admin)
				if(!$this->request('username') || !$this->request('name') || !$this->request('password') || !$this->request('confirmPassword') || !$this->request('contact') || !$this->request('email')){
					$return['error'] = true;
					$return['msg'] = "
					All the information below required. 
					<ul>
					  <li>Username</li>
					  <li>Password</li>
					  <li>Confirm Passsword</li>
					  <li>Full Name</li>
					  <li>Contact Number</li>
					  <li>Email Address</li>
					</ul>";

				}else if($this->request('password') != $this->request('confirmPassword')){
					$return['error'] = true;
					$return['msg'] = "Confirm password does not match.";

				}else{
                    $this->db->query("SELECT * FROM admin_role WHERE role_id = ".$this->db->escape($this->request('role'))."");
                    $role_type = $this->db->getSingleRow();
					$this->db->table("user_admins");
					$this->db->insertArray(array(
						"admin_name" => $this->request('name'),
						"admin_email" => $this->request('email'),
						"admin_contact" => $this->request('contact'),
						"admin_username" => $this->request('username'),
						"admin_password" => md5($this->request('password')),
						"admin_status" => "1",
						"admin_role" => $this->request('role'),
						"admin_registered" => "NOW()",
						"admin_last_activity" => "NOW()",
                        "role_type" => $role_type['role_type'],
					));

					$this->db->insert();

					$return['error'] = false;
					$return['msg'] = "New administrator created.";
					$return['url'] = option('base_uri').'/admin/';
				}

			else{
				$return['error'] = true;
				$return['msg'] = "Username <strong>" . $this->request('username') . "</strong> already exists.<br>Please choose another.";
			}
		}
		return json($return);
	}

	public function adminUpdate($id){


		$this->db->query("SELECT * FROM user_admins WHERE admin_id = ".$this->db->escape($id));
		$admin = $this->db->getSingleRow();
		if(empty($this->cms->admin->role) || $this->cms->admin->role != '1'){
			$return['error'] = true;
			$return['msg'] = "Your account does not allow you to create/update an administrator.";

		}else{
			$this->db->query("SELECT * FROM user_admins WHERE admin_id = ".$this->db->escape($id));
			$admin = $this->db->getSingleRow();

			if(!$admin){
				$return['error'] = true;
				$return['msg'] = "Invalid ID!";

			}else if(!$this->request('name') || !$this->request('contact') || !$this->request('email')){
				$return['error'] = true;
				$return['msg'] = "
					All the information below required. 
					<ul>
					  <li>Password</li>
					  <li>Confirm Passsword</li>
					  <li>Full Name</li>
					  <li>Contact Number</li>
					  <li>Email Address</li>
					</ul>";

			}else if($this->request('password') != $this->request('confirmPassword')){
				$return['error'] = true;
				$return['msg'] = "Confirm password does not match.";

			}else{
				if(!$this->request('password')){
					$password = $admin['admin_password'];
				}else{
					$password = md5($this->request('password'));
				}

                $this->db->query("SELECT * FROM admin_role WHERE role_id = ".$this->db->escape($this->request('role'))."");
                $role_type = $this->db->getSingleRow();
				$this->db->table("user_admins");
				$this->db->updateArray(array(
					"admin_name" => $this->request('name'),
					"admin_email" => $this->request('email'),
					"admin_contact" => $this->request('contact'),
					"admin_password" => $password,
					"admin_status" => $this->request('status'),
					"admin_role" => $this->request('role'),
                    "role_type" => $role_type['role_type'],
				));
				$this->db->whereArray(array(
					"admin_id" => $id,
				));
				$this->db->update();

                $this->db->query("SELECT * FROM team_management WHERE officer_id = ".$this->db->escape($id)."");
                $officer = $this->db->getSingleRow();

                if($this->request('head') != 0 && $this->request('head') != isset($officer['head_id'])){
                    $this->db->table("team_management");
                    $this->db->insertArray(array(
                        "officer_id" => $id,
                        "head_id" => $this->request('head'),
                    ));

                    $this->db->insert();
                }

                $this->db->table("team_management");
                $this->db->updateArray(array(
                    "head_id" => $this->request('head'),
                ));
                $this->db->whereArray(array(
                    "officer_id" => $id,
                ));
                $this->db->update();

                $this->db->query("SELECT * FROM installment WHERE admin_id = ".$this->db->escape($id)."");
                $installment = $this->db->getRowList();

                if(!empty($installment)){
                    foreach($installment as $installments){
                        $this->db->table("installment");
                        $this->db->updateArray(array(
                            "head_id" => $this->request('head'),
                        ));
                        $this->db->whereArray(array(
                            "admin_id" => $installments['admin_id'],
                        ));
                        $this->db->update();
                    }
                }

				$return['error'] = false;
				$return['msg'] = "Administrator account updated.";
			}
		}
		return json($return);
	}

	public function site_settings(){

		if(!empty($this->posts)){
			foreach($this->posts as $name => $value){
				$this->db->table("settings");
				$this->db->updateArray(array(
					"value" => $value
				));
				$this->db->whereArray(array(
					"name" => $name,
				));
				$this->db->update();
			}
		}

		$return['error'] = false;
		$return['msg'] = "Website information updated.";

		return json($return);
	}


	// ROLE
	public function roleInsert(){

        if(!$this->request('name')) {
            $return['error'] = true;
            $return['msg'] = "
			All the information below required. 
			<ul>
			  <li>Role Name</li>
			</ul>";
        }

        else{
            $this->db->table("admin_role");
            $this->db->insertArray(array(
                "role_type" => $this->request('optradio'),
                "role_name" => $this->request('name'),
                "view_borrower" => $this->request('vborrower'),
                "view_loan" => $this->request('vloan'),
                "view_loan_approval" => $this->request('vloanapproval'),
                "view_recovery" => $this->request('vrecovery'),
                "view_collection" => $this->request('vcollection'),
                "view_risk" => $this->request('vrisk'),
                "view_approval" => $this->request('vapproval'),
                "view_report_loan" => $this->request('vreportloan'),
                "view_report_payment" => $this->request('vreportpayment'),
                "view_report_collection" => $this->request('vreportcollection'),
                "view_report_collection_schedule" => $this->request('vreportcollectionschedule'),
                "view_report_individual" => $this->request('vreportindividual'),
                "view_report_head" => $this->request('vreporthead'),
                "view_report_summary" => $this->request('vreportsummary'),
                "manage_borrower" => $this->request('mborrower'),
                "manage_loan" => $this->request('mloan'),
                "manage_loan_approval" => $this->request('mloanapproval'),
                "manage_recovery" => $this->request('mrecovery'),
                "manage_risk" => $this->request('mrisk'),
                "manage_approval" => $this->request('mapproval'),
                "delete_borrower" => $this->request('dborrower'),
                "delete_loan" => $this->request('dloan'),
                "new_borrower_d" => $this->request('newborrowerd'),
                "total_loan_d" => $this->request('totalloand'),
                "total_borrower_d" => $this->request('totalborrowerd'),
                "total_recovered_d" => $this->request('totalrecoveredd'),
                "total_collection_d" => $this->request('totalcollectiond'),
                "total_bad_debt_d" => $this->request('totalbaddebtd'),
                "years_of_collection" => $this->request('yearsofcollection'),
                "active_borrower_d" => $this->request('activeborrower'),
                "borrower_statistic_d" => $this->request('borrowerstatistic'),
                "role_status" => 1,
            ));
            $this->db->insert();

            $return['error'] = false;
            $return['msg'] = "New role added.";
            $return['url'] = option('base_uri').'/role/';
        }

		return json($return);
	}

	public function roleUpdate($id){
		if(!empty($id)){

			$this->db->table("admin_role");
			$this->db->updateArray(array(
                "role_type" => $this->request('optradio'),
				"role_name" => $this->request('name'),
				"view_borrower" => $this->request('vborrower'),
				"view_loan" => $this->request('vloan'),
                "view_loan_approval" => $this->request('vloanapproval'),
				"view_recovery" => $this->request('vrecovery'),
                "view_collection" => $this->request('vcollection'),
				"view_risk" => $this->request('vrisk'),
                "view_approval" => $this->request('vapproval'),
                "view_report_loan" => $this->request('vreportloan'),
                "view_report_payment" => $this->request('vreportpayment'),
                "view_report_collection" => $this->request('vreportcollection'),
                "view_report_collection_schedule" => $this->request('vreportcollectionschedule'),
                "view_report_individual" => $this->request('vreportindividual'),
                "view_report_head" => $this->request('vreporthead'),
                "view_report_summary" => $this->request('vreportsummary'),
				"manage_borrower" => $this->request('mborrower'),
                "manage_loan" => $this->request('mloan'),
                "manage_loan_approval" => $this->request('mloanapproval'),
				"manage_recovery" => $this->request('mrecovery'),
				"manage_risk" => $this->request('mrisk'),
                "manage_approval" => $this->request('mapproval'),
				"delete_borrower" => $this->request('dborrower'),
				"delete_loan" => $this->request('dloan'),
				"new_borrower_d" => $this->request('newborrowerd'),
				"total_loan_d" => $this->request('totalloand'),
				"total_borrower_d" => $this->request('totalborrowerd'),
				"total_recovered_d" => $this->request('totalrecoveredd'),
				"total_collection_d" => $this->request('totalcollectiond'),
				"total_bad_debt_d" => $this->request('totalbaddebtd'),
				"years_of_collection" => $this->request('yearsofcollection'),
				"active_borrower_d" => $this->request('activeborrower'),
				"borrower_statistic_d" => $this->request('borrowerstatistic'),
				"role_status" => $this->request('status'),
				"date_updated" => 'NOW()',
			));
			$this->db->whereArray(array(
				"role_id" => $id,
			));
			$this->db->update();

			$return['error'] = false;
			$return['msg'] = "Role updated.";

		}else{
			$return['error'] = true;
			$return['msg'] = "Invalid ID.";
		}

		$return['url'] = option('base_uri').'/role/';

		return json($return);
	}


	// Borrower Insert

	public function borrowerInsert(){

		$date = new DateTime();
		$borrower_id = md5(uniqid(rand(), true));

		$borrower_data = $this->request('race').','.$this->request('owner').','.$this->request('full_name').','.$this->request('officerID').','.$this->request('gender').','.$this->request('dob').','.$this->request('nationality').','.$this->request('nric_new').','.$this->request('nric_old').','.$this->request('resident_address').','.$this->request('nric_address').','.$this->request('resident_address2').','.$this->request('mobile1').','.$this->request('mobile2').','.$this->request('employment_details').','.$this->request('remarks').','.$this->request('marital').','.$this->request('spouse_details').','.$this->request('wanted_remarks').','.$this->request('borrower_remarks');

        if($this->request('officerID') == '-'){
            $return['error'] = true;
            $return['msg'] = "Recovery Officer is required.";
        }
        else {
            $this->db->table("borrowers");
            $this->db->insertArray(array(
                "borrower_id" => $borrower_id,
                "race" => $this->request('race'),
                "owner" => $this->request('owner'),
                "full_name" => $this->request('full_name'),
                "agent_id" => $this->request('officerID'),
                "gender" => $this->request('gender'),
                "dob" => $this->request('dob'),
                "nationality" => $this->request('nationality'),
                "nric_new" => $this->request('nric_new'),
                "nric_old" => $this->request('nric_old'),
                "resident_address" => $this->request('resident_address'),
                "nric_address" => $this->request('nric_address'),
                "resident_address2" => $this->request('resident_address2'),
                "mobile1" => $this->request('mobile1'),
                "mobile2" => $this->request('mobile2'),
                "employment_details" => $this->request('employment_details'),
                "remarks" => $this->request('remarks'),
                "marital" => $this->request('marital'),
                "spouse_details" => $this->request('spouse_details'),
                "wanted_remarks" => $this->request('wanted_remarks'),
                "borrower_remarks" => $this->request('borrower_remarks'),
                "borrower_status" => '99',
                "source" => '1',
                "new" => '1',
                "created" => $date->format('Y-m-d H:i:s')
            ));
            $this->db->insert();

            $this->db->table("borrower_updates");
            $this->db->insertArray(array(
                "borrower_id" => $borrower_id, "label_contacts" => '0', "label_employments" => '0', "label_spouse" => '0', "label_spouse_employments" => '0', "label_guarantor" => '0', "label_references" => '0', "label_remarks" => '0', "race" => '0', "owner" => '0', "full_name" => '0', "agent_id" => '0', "gender" => '0', "dob" => '0', "nationality" => '0', "nric_new" => '0', "nric_old" => '0', "resident_address" => '0', "nric_address" => '0', "resident_address2" => '0', "mobile1" => '0', "mobile2" => '0', "employment_details" => '0', "remarks" => '0', "marital" => '0', "spouse_details" => '0', "wanted_remarks" => '0', "borrower_remarks" => '0', "contactAddress" => '0', "contactMobile_number" => '0', "employmentEmployer_name" => '0', "employmentDesignation" => '0', "employmentSalary_range" => '0', "employmentPay_date" => '0', "employmentAdvance_date" => '0', "employmentStaff_id" => '0', "employmentHired_on" => '0', "employmentDepartment" => '0', "employmentAddress" => '0', "employmentWork_location" => '0', "employmentPhone" => '0', "employmentFax" => '0', "spousedetailsFull_name" => '0', "spousedetailsGender" => '0', "spousedetailsDob" => '0', "spousedetailsNationality" => '0', "spousedetailsNric_new" => '0', "spousedetailsNric_old" => '0', "spousedetailsResident_address" => '0', "spousedetailsNric_address" => '0', "spousedetailsResident_address2" => '0', "spousedetailsRemarks" => '0', "spousedetailsMarital" => '0', "spousedetailsRace" => '0', "spouseMobile1" => '0', "spouseMobile2" => '0', "spousecontactsMobile" => '0', "spouseemploymentsEmployer_name" => '0', "spouseemploymentsDesignation" => '0', "spouseemploymentsSalary_range" => '0', "spouseemploymentsPay_date" => '0', "spouseemploymentsAdvance_date" => '0', "spouseemploymentsStaff_id" => '0', "spouseemploymentsHired_on" => '0', "spouseemploymentsDepartment" => '0', "spouseemploymentsAddress" => '0', "spouseemploymentsWork_location" => '0', "spouseemploymentsPhone" => '0', "spouseemploymentsFax" => '0', "guarantorsFull_name" => '0', "guarantorsNric_new" => '0', "guarantorsNric_old" => '0', "guarantorsRelation" => '0', "guarantorsResidence_address" => '0', "guarantorsOther_address" => '0', "guarantorsMobile1" => '0', "guarantorsMobile2" => '0', "guarantorsEmployer_name" => '0', "guarantorsDesignation" => '0', "guarantorsStaff_id" => '0', "guarantorsHired_on" => '0', "guarantorsDepartment" => '0', "guarantorsEmployer_address" => '0', "guarantorsWork_location" => '0', "guarantorsPhone" => '0', "guarantorsMarital" => '0', "guarantorsFax" => '0', "referencesFull_name" => '0', "referencesEmployer_name" => '0', "referencesRelation" => '0', "referencesDesignation" => '0', "referencesNric_new" => '0', "referencesNric_old" => '0', "referencesStaff_id" => '0', "referencesHired_on" => '0', "referencesDepartment" => '0', "referencesResidence_address" => '0', "referencesEmployer_address" => '0', "referencesOther_address" => '0', "referencesWork_location" => '0', "referencesMarital" => '0', "referencesPhone" => '0', "referencesFax" => '0', "referencesMobile1" => '0', "referencesMobile2" => '0', "remarksRemarks" => '0'
            ));
            $this->db->insert();

            $this->uploadDocument('photo_1', '', true, $borrower_id);
            $this->uploadDocument('photo_2', 'label_photo_1', false, $borrower_id);
            $this->uploadDocument('photo_3', 'label_photo_2', false, $borrower_id);
            $return['error'] = false;
            $return['msg'] = "Borrower Inserted.";
            $return['url'] = $borrower_id;

            // Add Log
            $this->db->table("audittrail");
            $this->db->insertArray(array(
                "action" => 'borrower_insert',
                "record" => $borrower_id,
                "details" => $borrower_data,
                "creator_id" => $this->cms->admin->id,
            ));
            $this->db->insert();
        }

		return json($return);

	}

	public function borrowerContactInsert($bid){
		$date = new DateTime();
		$contact_id = md5(uniqid(rand(), true));

		$contact_data = $contact_id.','.$bid.','.$this->request('address').','.$this->request('mobile_number');

        $this->db->query("SELECT * FROM borrowers WHERE borrower_id = ".$this->db->escape($bid)."");
        $borrower = $this->db->getSingleRow();

		$this->db->table("borrower_contacts");
		$this->db->insertArray(array(
			"contact_id" => $contact_id,
			"borrower_id" => $bid,
			"address" => $this->request('address'),
			"mobile_number" => $this->request('mobile_number'),
			"created" => $date->format('Y-m-d H:i:s')
		));
		$this->db->insert();

        if($borrower['new'] == '1'){
            $this->db->table("borrower_updates");
            $this->db->insertArray(array(
                "borrower_id" => $bid,"contact_id" => $contact_id,"label_contacts" => '0',"label_employments" => '0',"label_spouse" => '0',"label_spouse_employments" => '0',"label_guarantor" => '0',"label_references" => '0',"label_remarks" => '0',"race" => '0',"owner" => '0',"full_name" => '0',"agent_id" => '0',"gender" => '0',"dob" => '0',"nationality" => '0',"nric_new" => '0',"nric_old" => '0',"resident_address" => '0',"nric_address" => '0',"resident_address2" => '0',"mobile1" => '0',"mobile2" => '0',"employment_details" => '0',"remarks" => '0',"marital" => '0',"spouse_details" => '0',"wanted_remarks" => '0',"borrower_remarks" => '0',"contactAddress" => '0',"contactMobile_number" => '0',"employmentEmployer_name" => '0',"employmentDesignation" => '0',"employmentSalary_range" => '0',"employmentPay_date" => '0',"employmentAdvance_date" => '0',"employmentStaff_id" => '0',"employmentHired_on" => '0',"employmentDepartment" => '0',"employmentAddress" => '0',"employmentWork_location" => '0',"employmentPhone" => '0',"employmentFax" => '0',"spousedetailsFull_name" => '0',"spousedetailsGender" => '0',"spousedetailsDob" => '0',"spousedetailsNationality" => '0',"spousedetailsNric_new" => '0',"spousedetailsNric_old" => '0',"spousedetailsResident_address" => '0',"spousedetailsNric_address" => '0',"spousedetailsResident_address2" => '0',"spousedetailsRemarks" => '0',"spousedetailsMarital" => '0',"spousedetailsRace" => '0',"spouseMobile1" => '0',"spouseMobile2" => '0',"spousecontactsMobile" => '0',"spouseemploymentsEmployer_name" => '0',"spouseemploymentsDesignation" => '0',"spouseemploymentsSalary_range" => '0',"spouseemploymentsPay_date" => '0',"spouseemploymentsAdvance_date" => '0',"spouseemploymentsStaff_id" => '0',"spouseemploymentsHired_on" => '0',"spouseemploymentsDepartment" => '0',"spouseemploymentsAddress" => '0',"spouseemploymentsWork_location" => '0',"spouseemploymentsPhone" => '0',"spouseemploymentsFax" => '0',"guarantorsFull_name" => '0',"guarantorsNric_new" => '0',"guarantorsNric_old" => '0',"guarantorsRelation" => '0',"guarantorsResidence_address" => '0',"guarantorsOther_address" => '0',"guarantorsMobile1" => '0',"guarantorsMobile2" => '0',"guarantorsEmployer_name" => '0',"guarantorsDesignation" => '0',"guarantorsStaff_id" => '0',"guarantorsHired_on" => '0',"guarantorsDepartment" => '0',"guarantorsEmployer_address" => '0',"guarantorsWork_location" => '0',"guarantorsPhone" => '0',"guarantorsMarital" => '0',"guarantorsFax" => '0',"referencesFull_name" => '0',"referencesEmployer_name" => '0',"referencesRelation" => '0',"referencesDesignation" => '0',"referencesNric_new" => '0',"referencesNric_old" => '0',"referencesStaff_id" => '0',"referencesHired_on" => '0',"referencesDepartment" => '0',"referencesResidence_address" => '0',"referencesEmployer_address" => '0',"referencesOther_address" => '0',"referencesWork_location" => '0',"referencesMarital" => '0',"referencesPhone" => '0',"referencesFax" => '0',"referencesMobile1" => '0',"referencesMobile2" => '0',"remarksRemarks" => '0'
            ));
            $this->db->insert();
        } else{
            $this->db->table("borrower_updates");
            $this->db->insertArray(array(
                "borrower_id" => $bid,"contact_id" => $contact_id,"label_contacts" => '1',"label_employments" => '0',"label_spouse" => '0',"label_spouse_employments" => '0',"label_guarantor" => '0',"label_references" => '0',"label_remarks" => '0',"race" => '0',"owner" => '0',"full_name" => '0',"agent_id" => '0',"gender" => '0',"dob" => '0',"nationality" => '0',"nric_new" => '0',"nric_old" => '0',"resident_address" => '0',"nric_address" => '0',"resident_address2" => '0',"mobile1" => '0',"mobile2" => '0',"employment_details" => '0',"remarks" => '0',"marital" => '0',"spouse_details" => '0',"wanted_remarks" => '0',"borrower_remarks" => '0',"contactAddress" => '1',"contactMobile_number" => '1',"employmentEmployer_name" => '0',"employmentDesignation" => '0',"employmentSalary_range" => '0',"employmentPay_date" => '0',"employmentAdvance_date" => '0',"employmentStaff_id" => '0',"employmentHired_on" => '0',"employmentDepartment" => '0',"employmentAddress" => '0',"employmentWork_location" => '0',"employmentPhone" => '0',"employmentFax" => '0',"spousedetailsFull_name" => '0',"spousedetailsGender" => '0',"spousedetailsDob" => '0',"spousedetailsNationality" => '0',"spousedetailsNric_new" => '0',"spousedetailsNric_old" => '0',"spousedetailsResident_address" => '0',"spousedetailsNric_address" => '0',"spousedetailsResident_address2" => '0',"spousedetailsRemarks" => '0',"spousedetailsMarital" => '0',"spousedetailsRace" => '0',"spouseMobile1" => '0',"spouseMobile2" => '0',"spousecontactsMobile" => '0',"spouseemploymentsEmployer_name" => '0',"spouseemploymentsDesignation" => '0',"spouseemploymentsSalary_range" => '0',"spouseemploymentsPay_date" => '0',"spouseemploymentsAdvance_date" => '0',"spouseemploymentsStaff_id" => '0',"spouseemploymentsHired_on" => '0',"spouseemploymentsDepartment" => '0',"spouseemploymentsAddress" => '0',"spouseemploymentsWork_location" => '0',"spouseemploymentsPhone" => '0',"spouseemploymentsFax" => '0',"guarantorsFull_name" => '0',"guarantorsNric_new" => '0',"guarantorsNric_old" => '0',"guarantorsRelation" => '0',"guarantorsResidence_address" => '0',"guarantorsOther_address" => '0',"guarantorsMobile1" => '0',"guarantorsMobile2" => '0',"guarantorsEmployer_name" => '0',"guarantorsDesignation" => '0',"guarantorsStaff_id" => '0',"guarantorsHired_on" => '0',"guarantorsDepartment" => '0',"guarantorsEmployer_address" => '0',"guarantorsWork_location" => '0',"guarantorsPhone" => '0',"guarantorsMarital" => '0',"guarantorsFax" => '0',"referencesFull_name" => '0',"referencesEmployer_name" => '0',"referencesRelation" => '0',"referencesDesignation" => '0',"referencesNric_new" => '0',"referencesNric_old" => '0',"referencesStaff_id" => '0',"referencesHired_on" => '0',"referencesDepartment" => '0',"referencesResidence_address" => '0',"referencesEmployer_address" => '0',"referencesOther_address" => '0',"referencesWork_location" => '0',"referencesMarital" => '0',"referencesPhone" => '0',"referencesFax" => '0',"referencesMobile1" => '0',"referencesMobile2" => '0',"remarksRemarks" => '0'
            ));
            $this->db->insert();

            $this->db->table("borrower_updates");
            $this->db->updateArray(array(
                "label_contacts" => '1',
            ));
            $this->db->whereArray(array(
                "borrower_id" => $bid,
            ));
            $this->db->update();
        }

		$return['error'] = false;
		$return['msg'] = "Borrower Contact Inserted.";
		$return['url'] = option('base_uri').'/borrowers/'.$bid.'#contacts';

        if($borrower['pending_approval'] == '0' && $borrower['borrower_status'] != '99' && $borrower['new'] != '1'){
            $this->db->table("borrowers");
            $this->db->updateArray(array(
                "borrower_status" => '2',
                "pending_approval" => '0'
            ));
            $this->db->whereArray(array(
                "borrower_id" => $bid,
            ));
            $this->db->update();
        }
        else if($borrower['pending_approval'] == '1' || $borrower['pending_approval'] == '2'){
            $this->db->table("borrowers");
            $this->db->updateArray(array(
                "borrower_status" => '2',
                "pending_approval" => '2'
            ));
            $this->db->whereArray(array(
                "borrower_id" => $bid,
            ));
            $this->db->update();
        }

		// Add Log
		$this->db->table("audittrail");
		$this->db->insertArray(array(
			"action" => 'contact_insert',
			"record" => $bid.','.$contact_id,
			"details" => $contact_data,
			"creator_id" => $this->cms->admin->id,
		));

		$this->db->insert();


		return json($return);
	}

	public function borrowerContactUpdate($bid, $id){

		$contact_data = $this->request('address').','.$this->request('mobile_number');

        $this->db->query("SELECT * FROM borrowers WHERE borrower_id = ".$this->db->escape($bid)."");
        $borrower = $this->db->getSingleRow();

        $this->db->query("SELECT * FROM borrower_contacts WHERE borrower_id = ".$this->db->escape($bid)." && contact_id = ".$this->db->escape($id)."");
        $borrower_contact = $this->db->getSingleRow();

        $this->db->query("SELECT * FROM borrower_updates WHERE borrower_id = ".$this->db->escape($bid)." && contact_id = ".$this->db->escape($id)."");
        $borrower_update = $this->db->getSingleRow();

		$this->db->table("borrower_contacts");
		$this->db->updateArray(array(
			"address" => $this->request('address'),
			"mobile_number" => $this->request('mobile_number')
		));
		$this->db->whereArray(array(
			"borrower_id" => $bid,
			"contact_id" => $id
		));
		$this->db->update();

		$return['error'] = false;
		$return['msg'] = "Borrower Contact Updated.";
		$return['url'] = option('base_uri').'/borrowers/'.$bid.'#contacts';

        if($borrower['pending_approval'] == '0'
            && $borrower['new'] != '1'
            && ($this->request('address') != $borrower_contact['address']
            || $this->request('mobile_number') != $borrower_contact['mobile_number'])){
            $this->db->table("borrowers");
            $this->db->updateArray(array(
                "borrower_status" => '2',
                "pending_approval" => '0'
            ));
            $this->db->whereArray(array(
                "borrower_id" => $bid,
            ));
            $this->db->update();

            $this->db->table("borrower_updates");
            $this->db->updateArray(array(
                "label_contacts" => '1',
            ));
            $this->db->whereArray(array(
                "borrower_id" => $bid,
            ));
            $this->db->update();

            //insert updated status into borrower_updates if the data has been edited or is not the same as previous, 1(the label highlight becomes red)
            if($this->request('address') != $borrower_contact['address']){$this->db->table("borrower_updates");$this->db->updateArray(array(
                "contactAddress" => '1',
            ));$this->db->whereArray(array("borrower_id" => $bid,"contact_id" => $id));$this->db->update();}
            if($this->request('mobile_number') != $borrower_contact['mobile_number']){$this->db->table("borrower_updates");$this->db->updateArray(array(
                "contactMobile_number" => '1',
            ));$this->db->whereArray(array("borrower_id" => $bid,"contact_id" => $id));$this->db->update();}
        }
        else if(($borrower['pending_approval'] == '1'
                || $borrower['pending_approval'] == '2')
            && $borrower['new'] != '1'
            && ($this->request('address') != $borrower_contact['address']
                || $this->request('mobile_number') != $borrower_contact['mobile_number'])){
            $this->db->table("borrowers");
            $this->db->updateArray(array(
                "borrower_status" => '2',
                "pending_approval" => '2'
            ));
            $this->db->whereArray(array(
                "borrower_id" => $bid,
            ));
            $this->db->update();

            $this->db->table("borrower_updates");
            $this->db->updateArray(array(
                "label_contacts" => '1',
            ));
            $this->db->whereArray(array(
                "borrower_id" => $bid,
            ));
            $this->db->update();

            //insert updated status into borrower_updates if the data has been edited or is not the same as previous, 1(the label highlight becomes red)
            if($this->request('address') != $borrower_contact['address']){$this->db->table("borrower_updates");$this->db->updateArray(array(
                "contactAddress" => '1',
            ));$this->db->whereArray(array("borrower_id" => $bid,"contact_id" => $id));$this->db->update();}
            if($this->request('mobile_number') != $borrower_contact['mobile_number']){$this->db->table("borrower_updates");$this->db->updateArray(array(
                "contactMobile_number" => '1',
            ));$this->db->whereArray(array("borrower_id" => $bid,"contact_id" => $id));$this->db->update();}
        }

		// Add Log
		$this->db->table("audittrail");
		$this->db->insertArray(array(
			"action" => 'contact_update',
			"record" => $bid.','.$id,
			"details" => $contact_data,
			"creator_id" => $this->cms->admin->id,
		));

		return json($return);
	}

	public function borrowerContactDelete($bid, $id){
		$this->db->table("borrower_contacts");
		$this->db->whereArray(array(
			"borrower_id" => $bid,
			"contact_id" => $id
		));
		$this->db->delete();

        $this->db->table("borrower_updates");
        $this->db->whereArray(array(
            "borrower_id" => $bid,
            "contact_id" => $id
        ));
        $this->db->delete();

		$return['error'] = false;
		$return['msg'] = "Borrower Contact Deleted.";

		// Add Log
		$this->db->table("audittrail");
		$this->db->insertArray(array(
			"action" => 'contact_delete',
			"record" => $bid.','.$id,
			"details" => 'delete',
			"creator_id" => $this->cms->admin->id,
		));

		return json($return);
	}

	public function borrowerEmploymentInsert($bid){
		$date = new DateTime();
		$employment_id = md5(uniqid(rand(), true));

		$employment_data = $employment_id.','.$bid.','.$this->request("employer_name").','.$this->request("designation").','.$this->request("salary_range").','.$this->request("pay_date").','.$this->request("advance_date").','.$this->request("staff_id").','.$this->request("hired_on").','.$this->request("department").','.$this->request("address").','.$this->request("work_location").','.$this->request("phone").','.$this->request("fax");

        $this->db->query("SELECT * FROM borrowers WHERE borrower_id = ".$this->db->escape($bid)."");
        $borrower = $this->db->getSingleRow();

		$this->db->table("borrower_employments");
		$this->db->insertArray(array(
			"employment_id" => $employment_id,
			"borrower_id" => $bid,
			"employer_name" => $this->request("employer_name"),
			"designation" => $this->request("designation"),
			"salary_range" => $this->request("salary_range"),
			"pay_date" => $this->request("pay_date"),
			"advance_date" => $this->request("advance_date"),
			"staff_id" => $this->request("staff_id"),
			"hired_on" => $this->request("hired_on"),
			"department" => $this->request("department"),
			"address" => $this->request("address"),
			"work_location" => $this->request("work_location"),
			"phone" => $this->request("phone"),
			"fax" => $this->request("fax"),
			"created" => $date->format('Y-m-d H:i:s')
		));
		$this->db->insert();

        if($borrower['new'] == '1'){
            $this->db->table("borrower_updates");
            $this->db->insertArray(array(
                "borrower_id" => $bid,"employment_id" => $employment_id,"label_contacts" => '0',"label_employments" => '0',"label_spouse" => '0',"label_spouse_employments" => '0',"label_guarantor" => '0',"label_references" => '0',"label_remarks" => '0',"race" => '0',"owner" => '0',"full_name" => '0',"agent_id" => '0',"gender" => '0',"dob" => '0',"nationality" => '0',"nric_new" => '0',"nric_old" => '0',"resident_address" => '0',"nric_address" => '0',"resident_address2" => '0',"mobile1" => '0',"mobile2" => '0',"employment_details" => '0',"remarks" => '0',"marital" => '0',"spouse_details" => '0',"wanted_remarks" => '0',"borrower_remarks" => '0',"contactAddress" => '0',"contactMobile_number" => '0',"employmentEmployer_name" => '0',"employmentDesignation" => '0',"employmentSalary_range" => '0',"employmentPay_date" => '0',"employmentAdvance_date" => '0',"employmentStaff_id" => '0',"employmentHired_on" => '0',"employmentDepartment" => '0',"employmentAddress" => '0',"employmentWork_location" => '0',"employmentPhone" => '0',"employmentFax" => '0',"spousedetailsFull_name" => '0',"spousedetailsGender" => '0',"spousedetailsDob" => '0',"spousedetailsNationality" => '0',"spousedetailsNric_new" => '0',"spousedetailsNric_old" => '0',"spousedetailsResident_address" => '0',"spousedetailsNric_address" => '0',"spousedetailsResident_address2" => '0',"spousedetailsRemarks" => '0',"spousedetailsMarital" => '0',"spousedetailsRace" => '0',"spouseMobile1" => '0',"spouseMobile2" => '0',"spousecontactsMobile" => '0',"spouseemploymentsEmployer_name" => '0',"spouseemploymentsDesignation" => '0',"spouseemploymentsSalary_range" => '0',"spouseemploymentsPay_date" => '0',"spouseemploymentsAdvance_date" => '0',"spouseemploymentsStaff_id" => '0',"spouseemploymentsHired_on" => '0',"spouseemploymentsDepartment" => '0',"spouseemploymentsAddress" => '0',"spouseemploymentsWork_location" => '0',"spouseemploymentsPhone" => '0',"spouseemploymentsFax" => '0',"guarantorsFull_name" => '0',"guarantorsNric_new" => '0',"guarantorsNric_old" => '0',"guarantorsRelation" => '0',"guarantorsResidence_address" => '0',"guarantorsOther_address" => '0',"guarantorsMobile1" => '0',"guarantorsMobile2" => '0',"guarantorsEmployer_name" => '0',"guarantorsDesignation" => '0',"guarantorsStaff_id" => '0',"guarantorsHired_on" => '0',"guarantorsDepartment" => '0',"guarantorsEmployer_address" => '0',"guarantorsWork_location" => '0',"guarantorsPhone" => '0',"guarantorsMarital" => '0',"guarantorsFax" => '0',"referencesFull_name" => '0',"referencesEmployer_name" => '0',"referencesRelation" => '0',"referencesDesignation" => '0',"referencesNric_new" => '0',"referencesNric_old" => '0',"referencesStaff_id" => '0',"referencesHired_on" => '0',"referencesDepartment" => '0',"referencesResidence_address" => '0',"referencesEmployer_address" => '0',"referencesOther_address" => '0',"referencesWork_location" => '0',"referencesMarital" => '0',"referencesPhone" => '0',"referencesFax" => '0',"referencesMobile1" => '0',"referencesMobile2" => '0',"remarksRemarks" => '0'
            ));
            $this->db->insert();
        } else{
            $this->db->table("borrower_updates");
            $this->db->insertArray(array(
                "borrower_id" => $bid,"employment_id" => $employment_id,"label_contacts" => '0',"label_employments" => '1',"label_spouse" => '0',"label_spouse_employments" => '0',"label_guarantor" => '0',"label_references" => '0',"label_remarks" => '0',"race" => '0',"owner" => '0',"full_name" => '0',"agent_id" => '0',"gender" => '0',"dob" => '0',"nationality" => '0',"nric_new" => '0',"nric_old" => '0',"resident_address" => '0',"nric_address" => '0',"resident_address2" => '0',"mobile1" => '0',"mobile2" => '0',"employment_details" => '0',"remarks" => '0',"marital" => '0',"spouse_details" => '0',"wanted_remarks" => '0',"borrower_remarks" => '0',"contactAddress" => '0',"contactMobile_number" => '0',"employmentEmployer_name" => '1',"employmentDesignation" => '1',"employmentSalary_range" => '1',"employmentPay_date" => '1',"employmentAdvance_date" => '1',"employmentStaff_id" => '1',"employmentHired_on" => '1',"employmentDepartment" => '1',"employmentAddress" => '1',"employmentWork_location" => '1',"employmentPhone" => '1',"employmentFax" => '1',"spousedetailsFull_name" => '0',"spousedetailsGender" => '0',"spousedetailsDob" => '0',"spousedetailsNationality" => '0',"spousedetailsNric_new" => '0',"spousedetailsNric_old" => '0',"spousedetailsResident_address" => '0',"spousedetailsNric_address" => '0',"spousedetailsResident_address2" => '0',"spousedetailsRemarks" => '0',"spousedetailsMarital" => '0',"spousedetailsRace" => '0',"spouseMobile1" => '0',"spouseMobile2" => '0',"spousecontactsMobile" => '0',"spouseemploymentsEmployer_name" => '0',"spouseemploymentsDesignation" => '0',"spouseemploymentsSalary_range" => '0',"spouseemploymentsPay_date" => '0',"spouseemploymentsAdvance_date" => '0',"spouseemploymentsStaff_id" => '0',"spouseemploymentsHired_on" => '0',"spouseemploymentsDepartment" => '0',"spouseemploymentsAddress" => '0',"spouseemploymentsWork_location" => '0',"spouseemploymentsPhone" => '0',"spouseemploymentsFax" => '0',"guarantorsFull_name" => '0',"guarantorsNric_new" => '0',"guarantorsNric_old" => '0',"guarantorsRelation" => '0',"guarantorsResidence_address" => '0',"guarantorsOther_address" => '0',"guarantorsMobile1" => '0',"guarantorsMobile2" => '0',"guarantorsEmployer_name" => '0',"guarantorsDesignation" => '0',"guarantorsStaff_id" => '0',"guarantorsHired_on" => '0',"guarantorsDepartment" => '0',"guarantorsEmployer_address" => '0',"guarantorsWork_location" => '0',"guarantorsPhone" => '0',"guarantorsMarital" => '0',"guarantorsFax" => '0',"referencesFull_name" => '0',"referencesEmployer_name" => '0',"referencesRelation" => '0',"referencesDesignation" => '0',"referencesNric_new" => '0',"referencesNric_old" => '0',"referencesStaff_id" => '0',"referencesHired_on" => '0',"referencesDepartment" => '0',"referencesResidence_address" => '0',"referencesEmployer_address" => '0',"referencesOther_address" => '0',"referencesWork_location" => '0',"referencesMarital" => '0',"referencesPhone" => '0',"referencesFax" => '0',"referencesMobile1" => '0',"referencesMobile2" => '0',"remarksRemarks" => '0'
            ));
            $this->db->insert();

            $this->db->table("borrower_updates");
            $this->db->updateArray(array(
                "label_employments" => '1',
            ));
            $this->db->whereArray(array(
                "borrower_id" => $bid,
            ));
            $this->db->update();
        }

		$return['error'] = false;
		$return['msg'] = "Borrower Contact Inserted.";
		$return['url'] = option('base_uri').'/borrowers/'.$bid.'#employment';

        if($borrower['pending_approval'] == '0' && $borrower['borrower_status'] != '99' && $borrower['new'] != '1'){
            $this->db->table("borrowers");
            $this->db->updateArray(array(
                "borrower_status" => '2',
                "pending_approval" => '0'
            ));
            $this->db->whereArray(array(
                "borrower_id" => $bid,
            ));
            $this->db->update();
        }
        else if($borrower['pending_approval'] == '1' || $borrower['pending_approval'] == '2'){
            $this->db->table("borrowers");
            $this->db->updateArray(array(
                "borrower_status" => '2',
                "pending_approval" => '2'
            ));
            $this->db->whereArray(array(
                "borrower_id" => $bid,
            ));
            $this->db->update();
        }

		// Add Log
		$this->db->table("audittrail");
		$this->db->insertArray(array(
			"action" => 'employment_insert',
			"record" => $employment_id,
			"details" => $employment_data,
			"creator_id" => $this->cms->admin->id,
		));

		return json($return);
	}

	public function borrowerEmploymentUpdate($bid, $id){

		$employment_data = $id.','.$bid.','.$this->request("employer_name").','.$this->request("designation").','.$this->request("salary_range").','.$this->request("pay_date").','.$this->request("advance_date").','.$this->request("staff_id").','.$this->request("hired_on").','.$this->request("department").','.$this->request("address").','.$this->request("work_location").','.$this->request("phone").','.$this->request("fax");

        $this->db->query("SELECT * FROM borrowers WHERE borrower_id = ".$this->db->escape($bid)."");
        $borrower = $this->db->getSingleRow();

        $this->db->query("SELECT * FROM borrower_employments WHERE borrower_id = ".$this->db->escape($bid)." && employment_id = ".$this->db->escape($id)."");
        $borrower_employment = $this->db->getSingleRow();

        $this->db->query("SELECT * FROM borrower_updates WHERE borrower_id = ".$this->db->escape($bid)." && employment_id = ".$this->db->escape($id)."");
        $borrower_update = $this->db->getSingleRow();

        $this->db->table("borrower_employments");
		$this->db->updateArray(array(
			"employer_name" => $this->request("employer_name"),
			"designation" => $this->request("designation"),
			"salary_range" => $this->request("salary_range"),
			"pay_date" => $this->request("pay_date"),
			"advance_date" => $this->request("advance_date"),
			"staff_id" => $this->request("staff_id"),
			"hired_on" => $this->request("hired_on"),
			"department" => $this->request("department"),
			"address" => $this->request("address"),
			"work_location" => $this->request("work_location"),
			"phone" => $this->request("phone"),
			"fax" => $this->request("fax"),
		));
		$this->db->whereArray(array(
			"borrower_id" => $bid,
			"employment_id" => $id
		));
		$this->db->update();

		$return['error'] = false;
		$return['msg'] = "Borrower Employment Updated.";
		$return['url'] = option('base_uri').'/borrowers/'.$bid.'#employment';

        if($borrower['pending_approval'] == '0'
                && $borrower['new'] != '1'
                && ($this->request('employer_name') != $borrower_employment['employer_name']
                || $this->request('designation') != $borrower_employment['designation']
                || $this->request('salary_range') != $borrower_employment['salary_range']
                || $this->request('pay_date') != $borrower_employment['pay_date']
                || $this->request('advance_date') != $borrower_employment['advance_date']
                || $this->request('staff_id') != $borrower_employment['staff_id']
                || $this->request('hired_on') != $borrower_employment['hired_on']
                || $this->request('department') != $borrower_employment['department']
                || $this->request('address') != $borrower_employment['address']
                || $this->request('work_location') != $borrower_employment['work_location']
                || $this->request('phone') != $borrower_employment['phone']
                || $this->request('fax') != $borrower_employment['fax'])){
            $this->db->table("borrowers");
            $this->db->updateArray(array(
                "borrower_status" => '2',
                "pending_approval" => '0'
            ));
            $this->db->whereArray(array(
                "borrower_id" => $bid,
            ));
            $this->db->update();

            $this->db->table("borrower_updates");
            $this->db->updateArray(array(
                "label_employments" => '1',
            ));
            $this->db->whereArray(array(
                "borrower_id" => $bid,
            ));
            $this->db->update();

            //insert updated status into borrower_updates if the data has been edited or is not the same as previous, 1(the label highlight becomes red)
            if($this->request('employer_name') != $borrower_employment['employer_name']){$this->db->table("borrower_updates");$this->db->updateArray(array(
                "employmentEmployer_name" => '1',
            ));$this->db->whereArray(array("borrower_id" => $bid,"employment_id" => $id));$this->db->update();}
            if($this->request('designation') != $borrower_employment['designation']){$this->db->table("borrower_updates");$this->db->updateArray(array(
                "employmentDesignation" => '1',
            ));$this->db->whereArray(array("borrower_id" => $bid,"employment_id" => $id));$this->db->update();}
            if($this->request('salary_range') != $borrower_employment['salary_range']){$this->db->table("borrower_updates");$this->db->updateArray(array(
                "employmentSalary_range" => '1',
            ));$this->db->whereArray(array("borrower_id" => $bid,"employment_id" => $id));$this->db->update();}
            if($this->request('pay_date') != $borrower_employment['pay_date']){$this->db->table("borrower_updates");$this->db->updateArray(array(
                "employmentPay_date" => '1',
            ));$this->db->whereArray(array("borrower_id" => $bid,"employment_id" => $id));$this->db->update();}
            if($this->request('advance_date') != $borrower_employment['advance_date']){$this->db->table("borrower_updates");$this->db->updateArray(array(
                "employmentAdvance_date" => '1',
            ));$this->db->whereArray(array("borrower_id" => $bid,"employment_id" => $id));$this->db->update();}
            if($this->request('staff_id') != $borrower_employment['staff_id']){$this->db->table("borrower_updates");$this->db->updateArray(array(
                "employmentStaff_id" => '1',
            ));$this->db->whereArray(array("borrower_id" => $bid,"employment_id" => $id));$this->db->update();}
            if($this->request('hired_on') != $borrower_employment['hired_on']){$this->db->table("borrower_updates");$this->db->updateArray(array(
                "employmentHired_on" => '1',
            ));$this->db->whereArray(array("borrower_id" => $bid,"employment_id" => $id));$this->db->update();}
            if($this->request('department') != $borrower_employment['department']){$this->db->table("borrower_updates");$this->db->updateArray(array(
                "employmentDepartment" => '1',
            ));$this->db->whereArray(array("borrower_id" => $bid,"employment_id" => $id));$this->db->update();}
            if($this->request('address') != $borrower_employment['address']){$this->db->table("borrower_updates");$this->db->updateArray(array(
                "employmentAddress" => '1',
            ));$this->db->whereArray(array("borrower_id" => $bid,"employment_id" => $id));$this->db->update();}
            if($this->request('work_location') != $borrower_employment['work_location']){$this->db->table("borrower_updates");$this->db->updateArray(array(
                "employmentWork_location" => '1',
            ));$this->db->whereArray(array("borrower_id" => $bid,"employment_id" => $id));$this->db->update();}
            if($this->request('phone') != $borrower_employment['phone']){$this->db->table("borrower_updates");$this->db->updateArray(array(
                "employmentPhone" => '1',
            ));$this->db->whereArray(array("borrower_id" => $bid,"employment_id" => $id));$this->db->update();}
            if($this->request('fax') != $borrower_employment['fax']){$this->db->table("borrower_updates");$this->db->updateArray(array(
                "employmentFax" => '1',
            ));$this->db->whereArray(array("borrower_id" => $bid,"employment_id" => $id));$this->db->update();}
        }
        else if(($borrower['pending_approval'] == '1'
                || $borrower['pending_approval'] == '2')
                && $borrower['new'] != '1'
                && ($this->request('employer_name') != $borrower_employment['employer_name']
                || $this->request('designation') != $borrower_employment['designation']
                || $this->request('salary_range') != $borrower_employment['salary_range']
                || $this->request('pay_date') != $borrower_employment['pay_date']
                || $this->request('advance_date') != $borrower_employment['advance_date']
                || $this->request('staff_id') != $borrower_employment['staff_id']
                || $this->request('hired_on') != $borrower_employment['hired_on']
                || $this->request('department') != $borrower_employment['department']
                || $this->request('address') != $borrower_employment['address']
                || $this->request('work_location') != $borrower_employment['work_location']
                || $this->request('phone') != $borrower_employment['phone']
                || $this->request('fax') != $borrower_employment['fax'])){
            $this->db->table("borrowers");
            $this->db->updateArray(array(
                "borrower_status" => '2',
                "pending_approval" => '2'
            ));
            $this->db->whereArray(array(
                "borrower_id" => $bid,
            ));
            $this->db->update();

            $this->db->table("borrower_updates");
            $this->db->updateArray(array(
                "label_employments" => '1',
            ));
            $this->db->whereArray(array(
                "borrower_id" => $bid,
            ));
            $this->db->update();

            //insert updated status into borrower_updates if the data has been edited or is not the same as previous, 1(the label highlight becomes red)
            if($this->request('employer_name') != $borrower_employment['employer_name']){$this->db->table("borrower_updates");$this->db->updateArray(array(
                "employmentEmployer_name" => '1',
            ));$this->db->whereArray(array("borrower_id" => $bid,"employment_id" => $id));$this->db->update();}
            if($this->request('designation') != $borrower_employment['designation']){$this->db->table("borrower_updates");$this->db->updateArray(array(
                "employmentDesignation" => '1',
            ));$this->db->whereArray(array("borrower_id" => $bid,"employment_id" => $id));$this->db->update();}
            if($this->request('salary_range') != $borrower_employment['salary_range']){$this->db->table("borrower_updates");$this->db->updateArray(array(
                "employmentSalary_range" => '1',
            ));$this->db->whereArray(array("borrower_id" => $bid,"employment_id" => $id));$this->db->update();}
            if($this->request('pay_date') != $borrower_employment['pay_date']){$this->db->table("borrower_updates");$this->db->updateArray(array(
                "employmentPay_date" => '1',
            ));$this->db->whereArray(array("borrower_id" => $bid,"employment_id" => $id));$this->db->update();}
            if($this->request('advance_date') != $borrower_employment['advance_date']){$this->db->table("borrower_updates");$this->db->updateArray(array(
                "employmentAdvance_date" => '1',
            ));$this->db->whereArray(array("borrower_id" => $bid,"employment_id" => $id));$this->db->update();}
            if($this->request('staff_id') != $borrower_employment['staff_id']){$this->db->table("borrower_updates");$this->db->updateArray(array(
                "employmentStaff_id" => '1',
            ));$this->db->whereArray(array("borrower_id" => $bid,"employment_id" => $id));$this->db->update();}
            if($this->request('hired_on') != $borrower_employment['hired_on']){$this->db->table("borrower_updates");$this->db->updateArray(array(
                "employmentHired_on" => '1',
            ));$this->db->whereArray(array("borrower_id" => $bid,"employment_id" => $id));$this->db->update();}
            if($this->request('department') != $borrower_employment['department']){$this->db->table("borrower_updates");$this->db->updateArray(array(
                "employmentDepartment" => '1',
            ));$this->db->whereArray(array("borrower_id" => $bid,"employment_id" => $id));$this->db->update();}
            if($this->request('address') != $borrower_employment['address']){$this->db->table("borrower_updates");$this->db->updateArray(array(
                "employmentAddress" => '1',
            ));$this->db->whereArray(array("borrower_id" => $bid,"employment_id" => $id));$this->db->update();}
            if($this->request('work_location') != $borrower_employment['work_location']){$this->db->table("borrower_updates");$this->db->updateArray(array(
                "employmentWork_location" => '1',
            ));$this->db->whereArray(array("borrower_id" => $bid,"employment_id" => $id));$this->db->update();}
            if($this->request('phone') != $borrower_employment['phone']){$this->db->table("borrower_updates");$this->db->updateArray(array(
                "employmentPhone" => '1',
            ));$this->db->whereArray(array("borrower_id" => $bid,"employment_id" => $id));$this->db->update();}
            if($this->request('fax') != $borrower_employment['fax']){$this->db->table("borrower_updates");$this->db->updateArray(array(
                "employmentFax" => '1',
            ));$this->db->whereArray(array("borrower_id" => $bid,"employment_id" => $id));$this->db->update();}
        }

		// Add Log
		$this->db->table("audittrail");
		$this->db->insertArray(array(
			"action" => 'employment_update',
			"record" => $id,
			"details" => $employment_data,
			"creator_id" => $this->cms->admin->id,
		));

		return json($return);
	}


	public function borrowerEmploymentDelete($bid, $id){
		$this->db->table("borrower_employments");
		$this->db->whereArray(array(
			"borrower_id" => $bid,
			"employment_id" => $id
		));
		$this->db->delete();

        $this->db->table("borrower_updates");
        $this->db->whereArray(array(
            "borrower_id" => $bid,
            "employment_id" => $id
        ));
        $this->db->delete();

		$return['error'] = false;
		$return['msg'] = "Borrower Employment Deleted.";


		// Add Log
		$this->db->table("audittrail");
		$this->db->insertArray(array(
			"action" => 'employment_delete',
			"record" => $id,
			"details" => 'delete',
			"creator_id" => $this->cms->admin->id,
		));

		return json($return);
	}


	public function borrowerSpouseInsert($bid){
		$date = new DateTime();
		$spouse_id = md5(uniqid(rand(), true));

		$spouse_data = $spouse_id.','.$bid.','.$this->request("race").','.$this->request("full_name").','.$this->request("gender").','.$this->request("dob").','.$this->request("nationality").','.$this->request("nric_new").','.$this->request("nric_old").','.$this->request("resident_address").','.$this->request("nric_address").','.$this->request("resident_address2").','.$this->request("remarks").','.$this->request("marital");

        $this->db->query("SELECT * FROM borrowers WHERE borrower_id = ".$this->db->escape($bid)."");
        $borrower = $this->db->getSingleRow();

		$this->db->table("borrowers_spouse_details");
		$this->db->insertArray(array(
			"spouse_id" => $spouse_id,
			"borrower_id" => $bid,
			"race" => $this->request("race"),
			"full_name" => $this->request("full_name"),
			"gender" => $this->request("gender"),
			"dob" => $this->request("dob"),
			"nationality" => $this->request("nationality"),
			"nric_new" => $this->request("nric_new"),
			"nric_old" => $this->request("nric_old"),
			"resident_address" => $this->request("resident_address"),
			"nric_address" => $this->request("nric_address"),
			"resident_address2" => $this->request("resident_address2"),
			// "mobile1" => $this->request("mobile1"),
			// "mobile2" => $this->request("mobile2"),
			"remarks" => $this->request("remarks"),
			"marital" => $this->request("marital"),
			"created" => $date->format('Y-m-d H:i:s')
		));
		$this->db->insert();

		if(!$this->request("mobile")){
			$spouse_contact_id = md5(uniqid(rand(), true));
			$this->db->table("borrower_spouse_contacts");
			$this->db->insertArray(array(
				"spouse_contact_id" => $spouse_contact_id,
				"borrower_id" => $bid,
				"spouse_id" => $spouse_id,
				"mobile" => $this->request("mobile_input"),
				"created" => $date->format('Y-m-d H:i:s')
			));
			$this->db->insert();
		}else{
			foreach($this->request("mobile") as $mobile){
				$spouse_contact_id = md5(uniqid(rand(), true));
				$this->db->table("borrower_spouse_contacts");
				$this->db->insertArray(array(
					"spouse_contact_id" => $spouse_contact_id,
					"borrower_id" => $bid,
					"spouse_id" => $spouse_id,
					"mobile" => $mobile,
					"created" => $date->format('Y-m-d H:i:s')
				));
				$this->db->insert();
			}
        }

        if($borrower['new'] == '1'){
            $this->db->table("borrower_updates");
            $this->db->insertArray(array(
                "borrower_id" => $bid,"spouse_id" => $spouse_id,"label_contacts" => '0',"label_employments" => '0',"label_spouse" => '0',"label_spouse_employments" => '0',"label_guarantor" => '0',"label_references" => '0',"label_remarks" => '0',"race" => '0',"owner" => '0',"full_name" => '0',"agent_id" => '0',"gender" => '0',"dob" => '0',"nationality" => '0',"nric_new" => '0',"nric_old" => '0',"resident_address" => '0',"nric_address" => '0',"resident_address2" => '0',"mobile1" => '0',"mobile2" => '0',"employment_details" => '0',"remarks" => '0',"marital" => '0',"spouse_details" => '0',"wanted_remarks" => '0',"borrower_remarks" => '0',"contactAddress" => '0',"contactMobile_number" => '0',"employmentEmployer_name" => '0',"employmentDesignation" => '0',"employmentSalary_range" => '0',"employmentPay_date" => '0',"employmentAdvance_date" => '0',"employmentStaff_id" => '0',"employmentHired_on" => '0',"employmentDepartment" => '0',"employmentAddress" => '0',"employmentWork_location" => '0',"employmentPhone" => '0',"employmentFax" => '0',"spousedetailsFull_name" => '0',"spousedetailsGender" => '0',"spousedetailsDob" => '0',"spousedetailsNationality" => '0',"spousedetailsNric_new" => '0',"spousedetailsNric_old" => '0',"spousedetailsResident_address" => '0',"spousedetailsNric_address" => '0',"spousedetailsResident_address2" => '0',"spousedetailsRemarks" => '0',"spousedetailsMarital" => '0',"spousedetailsRace" => '0',"spouseMobile1" => '0',"spouseMobile2" => '0',"spousecontactsMobile" => '0',"spouseemploymentsEmployer_name" => '0',"spouseemploymentsDesignation" => '0',"spouseemploymentsSalary_range" => '0',"spouseemploymentsPay_date" => '0',"spouseemploymentsAdvance_date" => '0',"spouseemploymentsStaff_id" => '0',"spouseemploymentsHired_on" => '0',"spouseemploymentsDepartment" => '0',"spouseemploymentsAddress" => '0',"spouseemploymentsWork_location" => '0',"spouseemploymentsPhone" => '0',"spouseemploymentsFax" => '0',"guarantorsFull_name" => '0',"guarantorsNric_new" => '0',"guarantorsNric_old" => '0',"guarantorsRelation" => '0',"guarantorsResidence_address" => '0',"guarantorsOther_address" => '0',"guarantorsMobile1" => '0',"guarantorsMobile2" => '0',"guarantorsEmployer_name" => '0',"guarantorsDesignation" => '0',"guarantorsStaff_id" => '0',"guarantorsHired_on" => '0',"guarantorsDepartment" => '0',"guarantorsEmployer_address" => '0',"guarantorsWork_location" => '0',"guarantorsPhone" => '0',"guarantorsMarital" => '0',"guarantorsFax" => '0',"referencesFull_name" => '0',"referencesEmployer_name" => '0',"referencesRelation" => '0',"referencesDesignation" => '0',"referencesNric_new" => '0',"referencesNric_old" => '0',"referencesStaff_id" => '0',"referencesHired_on" => '0',"referencesDepartment" => '0',"referencesResidence_address" => '0',"referencesEmployer_address" => '0',"referencesOther_address" => '0',"referencesWork_location" => '0',"referencesMarital" => '0',"referencesPhone" => '0',"referencesFax" => '0',"referencesMobile1" => '0',"referencesMobile2" => '0',"remarksRemarks" => '0'
            ));
            $this->db->insert();
        } else{
            $this->db->table("borrower_updates");
            $this->db->insertArray(array(
                "borrower_id" => $bid,"spouse_id" => $spouse_id,"label_contacts" => '0',"label_employments" => '0',"label_spouse" => '1',"label_spouse_employments" => '0',"label_guarantor" => '0',"label_references" => '0',"label_remarks" => '0',"race" => '0',"owner" => '0',"full_name" => '0',"agent_id" => '0',"gender" => '0',"dob" => '0',"nationality" => '0',"nric_new" => '0',"nric_old" => '0',"resident_address" => '0',"nric_address" => '0',"resident_address2" => '0',"mobile1" => '0',"mobile2" => '0',"employment_details" => '0',"remarks" => '0',"marital" => '0',"spouse_details" => '0',"wanted_remarks" => '0',"borrower_remarks" => '0',"contactAddress" => '0',"contactMobile_number" => '0',"employmentEmployer_name" => '0',"employmentDesignation" => '0',"employmentSalary_range" => '0',"employmentPay_date" => '0',"employmentAdvance_date" => '0',"employmentStaff_id" => '0',"employmentHired_on" => '0',"employmentDepartment" => '0',"employmentAddress" => '0',"employmentWork_location" => '0',"employmentPhone" => '0',"employmentFax" => '0',"spousedetailsFull_name" => '1',"spousedetailsGender" => '1',"spousedetailsDob" => '1',"spousedetailsNationality" => '1',"spousedetailsNric_new" => '1',"spousedetailsNric_old" => '1',"spousedetailsResident_address" => '1',"spousedetailsNric_address" => '1',"spousedetailsResident_address2" => '1',"spousedetailsRemarks" => '1',"spousedetailsMarital" => '1',"spousedetailsRace" => '1',"spouseMobile1" => '1',"spouseMobile2" => '1',"spousecontactsMobile" => '1',"spouseemploymentsEmployer_name" => '0',"spouseemploymentsDesignation" => '0',"spouseemploymentsSalary_range" => '0',"spouseemploymentsPay_date" => '0',"spouseemploymentsAdvance_date" => '0',"spouseemploymentsStaff_id" => '0',"spouseemploymentsHired_on" => '0',"spouseemploymentsDepartment" => '0',"spouseemploymentsAddress" => '0',"spouseemploymentsWork_location" => '0',"spouseemploymentsPhone" => '0',"spouseemploymentsFax" => '0',"guarantorsFull_name" => '0',"guarantorsNric_new" => '0',"guarantorsNric_old" => '0',"guarantorsRelation" => '0',"guarantorsResidence_address" => '0',"guarantorsOther_address" => '0',"guarantorsMobile1" => '0',"guarantorsMobile2" => '0',"guarantorsEmployer_name" => '0',"guarantorsDesignation" => '0',"guarantorsStaff_id" => '0',"guarantorsHired_on" => '0',"guarantorsDepartment" => '0',"guarantorsEmployer_address" => '0',"guarantorsWork_location" => '0',"guarantorsPhone" => '0',"guarantorsMarital" => '0',"guarantorsFax" => '0',"referencesFull_name" => '0',"referencesEmployer_name" => '0',"referencesRelation" => '0',"referencesDesignation" => '0',"referencesNric_new" => '0',"referencesNric_old" => '0',"referencesStaff_id" => '0',"referencesHired_on" => '0',"referencesDepartment" => '0',"referencesResidence_address" => '0',"referencesEmployer_address" => '0',"referencesOther_address" => '0',"referencesWork_location" => '0',"referencesMarital" => '0',"referencesPhone" => '0',"referencesFax" => '0',"referencesMobile1" => '0',"referencesMobile2" => '0',"remarksRemarks" => '0'
            ));
            $this->db->insert();

            $this->db->table("borrower_updates");
            $this->db->updateArray(array(
                "label_spouse" => '1',
            ));
            $this->db->whereArray(array(
                "borrower_id" => $bid,
            ));
            $this->db->update();
        }

		$return['error'] = false;
		$return['msg'] = "Borrower Spouse Inserted.";
		$return['url'] = option('base_uri').'/borrowers/'.$bid.'#spouse';

        if($borrower['pending_approval'] == '0' && $borrower['borrower_status'] != '99' && $borrower['new'] != '1'){
            $this->db->table("borrowers");
            $this->db->updateArray(array(
                "borrower_status" => '2',
                "pending_approval" => '0'
            ));
            $this->db->whereArray(array(
                "borrower_id" => $bid,
            ));
            $this->db->update();
        }
        else if($borrower['pending_approval'] == '1' || $borrower['pending_approval'] == '2'){
            $this->db->table("borrowers");
            $this->db->updateArray(array(
                "borrower_status" => '2',
                "pending_approval" => '2'
            ));
            $this->db->whereArray(array(
                "borrower_id" => $bid,
            ));
            $this->db->update();
        }

		// Add Log
		$this->db->table("audittrail");
		$this->db->insertArray(array(
			"action" => 'spouse_insert',
			"record" => $bid.','.$spouse_id,
			"details" => $spouse_data,
			"creator_id" => $this->cms->admin->id,
		));



		return json($return);
	}


	public function borrowerSpouseUpdate($bid, $id){
		$date = new DateTime();
        $spouse_id = md5(uniqid(rand(), true));

		$spouse_data = $spouse_id.','.$bid.','.$this->request("race").','.$this->request("full_name").','.$this->request("gender").','.$this->request("dob").','.$this->request("nationality").','.$this->request("nric_new").','.$this->request("nric_old").','.$this->request("resident_address").','.$this->request("nric_address").','.$this->request("resident_address2").','.$this->request("remarks").','.$this->request("marital");

        $this->db->query("SELECT * FROM borrowers WHERE borrower_id = ".$this->db->escape($bid)."");
        $borrower = $this->db->getSingleRow();

        $this->db->query("SELECT * FROM borrowers_spouse_details WHERE borrower_id = ".$this->db->escape($bid)." && spouse_id = ".$this->db->escape($id)."");
        $borrower_spouse = $this->db->getSingleRow();

        $this->db->query("SELECT * FROM borrower_updates WHERE borrower_id = ".$this->db->escape($bid)." && spouse_id = ".$this->db->escape($id)."");
        $borrower_update = $this->db->getSingleRow();

		$this->db->table("borrowers_spouse_details");
		$this->db->updateArray(array(
			"race" => $this->request("race"),
			"full_name" => $this->request("full_name"),
			"gender" => $this->request("gender"),
			"dob" => $this->request("dob"),
			"nationality" => $this->request("nationality"),
			"nric_new" => $this->request("nric_new"),
			"nric_old" => $this->request("nric_old"),
			"resident_address" => $this->request("resident_address"),
			"nric_address" => $this->request("nric_address"),
			"resident_address2" => $this->request("resident_address2"),
			"mobile1" => $this->request("mobile1"),
			"mobile2" => $this->request("mobile2"),
			"remarks" => $this->request("remarks"),
			"marital" => $this->request("marital")
		));
		$this->db->whereArray(array(
			"borrower_id" => $bid,
			"spouse_id" => $id
		));
		$this->db->update();

		$this->db->table("borrower_spouse_contacts");
		$this->db->whereArray(array(
			"borrower_id" => $bid,
			"spouse_id" => $id
		));
		$this->db->delete();

		if(!$this->request("mobile")){
			$spouse_contact_id = md5(uniqid(rand(), true));
			$this->db->table("borrower_spouse_contacts");
			$this->db->insertArray(array(
				"spouse_contact_id" => $spouse_contact_id,
				"borrower_id" => $bid,
				"spouse_id" => $id,
				"mobile" => $this->request("mobile_input"),
				"created" => $date->format('Y-m-d H:i:s')
			));
			$this->db->insert();
		}else{
			foreach($this->request("mobile") as $mobile){
				$spouse_contact_id = md5(uniqid(rand(), true));
				$this->db->table("borrower_spouse_contacts");
				$this->db->insertArray(array(
					"spouse_contact_id" => $spouse_contact_id,
					"borrower_id" => $bid,
					"spouse_id" => $id,
					"mobile" => $mobile,
					"created" => $date->format('Y-m-d H:i:s')
				));
				$this->db->insert();
			}
        }

		$return['error'] = false;
		$return['msg'] = "Borrower Spouse Updated.";
		$return['url'] = option('base_uri').'/borrowers/'.$bid.'#spouse';

        if($borrower['pending_approval'] == '0'
                && $borrower['new'] != '1'
                && ($this->request('race') != $borrower_spouse['race']
                || $this->request('full_name') != $borrower_spouse['full_name']
                || $this->request('gender') != $borrower_spouse['gender']
                || $this->request('dob') != $borrower_spouse['dob']
                || $this->request('nationality') != $borrower_spouse['nationality']
                || $this->request('nric_new') != $borrower_spouse['nric_new']
                || $this->request('nric_old') != $borrower_spouse['nric_old']
                || $this->request('resident_address') != $borrower_spouse['resident_address']
                || $this->request('nric_address') != $borrower_spouse['nric_address']
                || $this->request('resident_address2') != $borrower_spouse['resident_address2']
                || $this->request('mobile1') != $borrower_spouse['mobile1']
                || $this->request('mobile2') != $borrower_spouse['mobile2']
                || $this->request('remarks') != $borrower_spouse['remarks']
                || $this->request('marital') != $borrower_spouse['marital'])){
            $this->db->table("borrowers");
            $this->db->updateArray(array(
                "borrower_status" => '2',
                "pending_approval" => '0'
            ));
            $this->db->whereArray(array(
                "borrower_id" => $bid,
            ));
            $this->db->update();

            $this->db->table("borrower_updates");
            $this->db->updateArray(array(
                "label_spouse" => '1',
            ));
            $this->db->whereArray(array(
                "borrower_id" => $bid,
            ));
            $this->db->update();

            //insert updated status into borrower_updates if the data has been edited or is not the same as previous, 1(the label highlight becomes red)
            if($this->request('race') != $borrower_spouse['race']){$this->db->table("borrower_updates");$this->db->updateArray(array(
                "spousedetailsRace" => '1',
            ));$this->db->whereArray(array("borrower_id" => $bid,"spouse_id" => $id));$this->db->update();}
            if($this->request('full_name') != $borrower_spouse['full_name']){$this->db->table("borrower_updates");$this->db->updateArray(array(
                "spousedetailsFull_name" => '1',
            ));$this->db->whereArray(array("borrower_id" => $bid,"spouse_id" => $id));$this->db->update();}
            if($this->request('gender') != $borrower_spouse['gender']){$this->db->table("borrower_updates");$this->db->updateArray(array(
                "spousedetailsGender" => '1',
            ));$this->db->whereArray(array("borrower_id" => $bid,"spouse_id" => $id));$this->db->update();}
            if($this->request('dob') != $borrower_spouse['dob']){$this->db->table("borrower_updates");$this->db->updateArray(array(
                "spousedetailsDob" => '1',
            ));$this->db->whereArray(array("borrower_id" => $bid,"spouse_id" => $id));$this->db->update();}
            if($this->request('nationality') != $borrower_spouse['nationality']){$this->db->table("borrower_updates");$this->db->updateArray(array(
                "spousedetailsNationality" => '1',
            ));$this->db->whereArray(array("borrower_id" => $bid,"spouse_id" => $id));$this->db->update();}
            if($this->request('nric_new') != $borrower_spouse['nric_new']){$this->db->table("borrower_updates");$this->db->updateArray(array(
                "spousedetailsNric_new" => '1',
            ));$this->db->whereArray(array("borrower_id" => $bid,"spouse_id" => $id));$this->db->update();}
            if($this->request('nric_old') != $borrower_spouse['nric_old']){$this->db->table("borrower_updates");$this->db->updateArray(array(
                "spousedetailsNric_old" => '1',
            ));$this->db->whereArray(array("borrower_id" => $bid,"spouse_id" => $id));$this->db->update();}
            if($this->request('resident_address') != $borrower_spouse['resident_address']){$this->db->table("borrower_updates");$this->db->updateArray(array(
                "spousedetailsResident_address" => '1',
            ));$this->db->whereArray(array("borrower_id" => $bid,"spouse_id" => $id));$this->db->update();}
            if($this->request('nric_address') != $borrower_spouse['nric_address']){$this->db->table("borrower_updates");$this->db->updateArray(array(
                "spousedetailsNric_address" => '1',
            ));$this->db->whereArray(array("borrower_id" => $bid,"spouse_id" => $id));$this->db->update();}
            if($this->request('resident_address2') != $borrower_spouse['resident_address2']){$this->db->table("borrower_updates");$this->db->updateArray(array(
                "spousedetailsResident_address2" => '1',
            ));$this->db->whereArray(array("borrower_id" => $bid,"spouse_id" => $id));$this->db->update();}
            if($this->request('mobile1') != $borrower_spouse['mobile1']){$this->db->table("borrower_updates");$this->db->updateArray(array(
                "spouseMobile1" => '1',
            ));$this->db->whereArray(array("borrower_id" => $bid,"spouse_id" => $id));$this->db->update();}
            if($this->request('mobile2') != $borrower_spouse['mobile2']){$this->db->table("borrower_updates");$this->db->updateArray(array(
                "spouseMobile2" => '1',
            ));$this->db->whereArray(array("borrower_id" => $bid,"spouse_id" => $id));$this->db->update();}
            if($this->request('remarks') != $borrower_spouse['remarks']){$this->db->table("borrower_updates");$this->db->updateArray(array(
                "spousedetailsRemarks" => '1',
            ));$this->db->whereArray(array("borrower_id" => $bid,"spouse_id" => $id));$this->db->update();}
            if($this->request('marital') != $borrower_spouse['marital']){$this->db->table("borrower_updates");$this->db->updateArray(array(
                "spousedetailsMarital" => '1',
            ));$this->db->whereArray(array("borrower_id" => $bid,"spouse_id" => $id));$this->db->update();}
        }
        else if(($borrower['pending_approval'] == '1'
                || $borrower['pending_approval'] == '2')
                && $borrower['new'] != '1'
                && ($this->request('race') != $borrower_spouse['race']
                || $this->request('full_name') != $borrower_spouse['full_name']
                || $this->request('gender') != $borrower_spouse['gender']
                || $this->request('dob') != $borrower_spouse['dob']
                || $this->request('nationality') != $borrower_spouse['nationality']
                || $this->request('nric_new') != $borrower_spouse['nric_new']
                || $this->request('nric_old') != $borrower_spouse['nric_old']
                || $this->request('resident_address') != $borrower_spouse['resident_address']
                || $this->request('nric_address') != $borrower_spouse['nric_address']
                || $this->request('resident_address2') != $borrower_spouse['resident_address2']
                || $this->request('mobile1') != $borrower_spouse['mobile1']
                || $this->request('mobile2') != $borrower_spouse['mobile2']
                || $this->request('remarks') != $borrower_spouse['remarks']
                || $this->request('marital') != $borrower_spouse['marital'])){
            $this->db->table("borrowers");
            $this->db->updateArray(array(
                "borrower_status" => '2',
                "pending_approval" => '2'
            ));
            $this->db->whereArray(array(
                "borrower_id" => $bid,
            ));
            $this->db->update();

            $this->db->table("borrower_updates");
            $this->db->updateArray(array(
                "label_spouse" => '1',
            ));
            $this->db->whereArray(array(
                "borrower_id" => $bid,
            ));
            $this->db->update();

            //insert updated status into borrower_updates if the data has been edited or is not the same as previous, 1(the label highlight becomes red)
            if($this->request('race') != $borrower_spouse['race']){$this->db->table("borrower_updates");$this->db->updateArray(array(
                "spousedetailsRace" => '1',
            ));$this->db->whereArray(array("borrower_id" => $bid,"spouse_id" => $id));$this->db->update();}
            if($this->request('full_name') != $borrower_spouse['full_name']){$this->db->table("borrower_updates");$this->db->updateArray(array(
                "spousedetailsFull_name" => '1',
            ));$this->db->whereArray(array("borrower_id" => $bid,"spouse_id" => $id));$this->db->update();}
            if($this->request('gender') != $borrower_spouse['gender']){$this->db->table("borrower_updates");$this->db->updateArray(array(
                "spousedetailsGender" => '1',
            ));$this->db->whereArray(array("borrower_id" => $bid,"spouse_id" => $id));$this->db->update();}
            if($this->request('dob') != $borrower_spouse['dob']){$this->db->table("borrower_updates");$this->db->updateArray(array(
                "spousedetailsDob" => '1',
            ));$this->db->whereArray(array("borrower_id" => $bid,"spouse_id" => $id));$this->db->update();}
            if($this->request('nationality') != $borrower_spouse['nationality']){$this->db->table("borrower_updates");$this->db->updateArray(array(
                "spousedetailsNationality" => '1',
            ));$this->db->whereArray(array("borrower_id" => $bid,"spouse_id" => $id));$this->db->update();}
            if($this->request('nric_new') != $borrower_spouse['nric_new']){$this->db->table("borrower_updates");$this->db->updateArray(array(
                "spousedetailsNric_new" => '1',
            ));$this->db->whereArray(array("borrower_id" => $bid,"spouse_id" => $id));$this->db->update();}
            if($this->request('nric_old') != $borrower_spouse['nric_old']){$this->db->table("borrower_updates");$this->db->updateArray(array(
                "spousedetailsNric_old" => '1',
            ));$this->db->whereArray(array("borrower_id" => $bid,"spouse_id" => $id));$this->db->update();}
            if($this->request('resident_address') != $borrower_spouse['resident_address']){$this->db->table("borrower_updates");$this->db->updateArray(array(
                "spousedetailsResident_address" => '1',
            ));$this->db->whereArray(array("borrower_id" => $bid,"spouse_id" => $id));$this->db->update();}
            if($this->request('nric_address') != $borrower_spouse['nric_address']){$this->db->table("borrower_updates");$this->db->updateArray(array(
                "spousedetailsNric_address" => '1',
            ));$this->db->whereArray(array("borrower_id" => $bid,"spouse_id" => $id));$this->db->update();}
            if($this->request('resident_address2') != $borrower_spouse['resident_address2']){$this->db->table("borrower_updates");$this->db->updateArray(array(
                "spousedetailsResident_address2" => '1',
            ));$this->db->whereArray(array("borrower_id" => $bid,"spouse_id" => $id));$this->db->update();}
            if($this->request('mobile1') != $borrower_spouse['mobile1']){$this->db->table("borrower_updates");$this->db->updateArray(array(
                "spouseMobile1" => '1',
            ));$this->db->whereArray(array("borrower_id" => $bid,"spouse_id" => $id));$this->db->update();}
            if($this->request('mobile2') != $borrower_spouse['mobile2']){$this->db->table("borrower_updates");$this->db->updateArray(array(
                "spouseMobile2" => '1',
            ));$this->db->whereArray(array("borrower_id" => $bid,"spouse_id" => $id));$this->db->update();}
            if($this->request('remarks') != $borrower_spouse['remarks']){$this->db->table("borrower_updates");$this->db->updateArray(array(
                "spousedetailsRemarks" => '1',
            ));$this->db->whereArray(array("borrower_id" => $bid,"spouse_id" => $id));$this->db->update();}
            if($this->request('marital') != $borrower_spouse['marital']){$this->db->table("borrower_updates");$this->db->updateArray(array(
                "spousedetailsMarital" => '1',
            ));$this->db->whereArray(array("borrower_id" => $bid,"spouse_id" => $id));$this->db->update();}
        }

		// Add Log
		$this->db->table("audittrail");
		$this->db->insertArray(array(
			"action" => 'spouse_update',
			"record" => $bid.','.$spouse_id,
			"details" => $spouse_data,
			"creator_id" => $this->cms->admin->id,
		));



		return json($return);
	}

	public function borrowerSpouseDelete($bid, $id){
		$this->db->table("borrowers_spouse_details");
		$this->db->whereArray(array(
			"borrower_id" => $bid,
			"spouse_id" => $id
		));
		$this->db->delete();

        $this->db->table("borrower_updates");
        $this->db->whereArray(array(
            "borrower_id" => $bid,
            "spouse_id" => $id
        ));
        $this->db->delete();

		$return['error'] = false;
		$return['msg'] = "Borrower Spouse Deleted.";
		return json($return);
	}

	public function borrowerSpouseEmploymentInsert($bid){
		$date = new DateTime();
		$spouse_employment_id = md5(uniqid(rand(), true));

        $this->db->query("SELECT * FROM borrowers WHERE borrower_id = ".$this->db->escape($bid)."");
        $borrower = $this->db->getSingleRow();

		$this->db->table("borrower_spouse_employments");
		$this->db->insertArray(array(
			"employment_id" => $spouse_employment_id,
			"borrower_id" => $bid,
			"employer_name" => $this->request("employer_name"),
			"designation" => $this->request("designation"),
			"salary_range" => $this->request("salary_range"),
			"pay_date" => $this->request("pay_date"),
			"advance_date" => $this->request("advance_date"),
			"staff_id" => $this->request("staff_id"),
			"hired_on" => $this->request("hired_on"),
			"department" => $this->request("department"),
			"address" => $this->request("address"),
			"work_location" => $this->request("work_location"),
			"phone" => $this->request("phone"),
			"fax" => $this->request("fax"),
			"created" => $date->format('Y-m-d H:i:s')
		));
		$this->db->insert();

        if($borrower['new'] == '1'){
            $this->db->table("borrower_updates");
            $this->db->insertArray(array(
                "borrower_id" => $bid,"spouse_employment_id" => $spouse_employment_id,"label_contacts" => '0',"label_employments" => '0',"label_spouse" => '0',"label_spouse_employments" => '0',"label_guarantor" => '0',"label_references" => '0',"label_remarks" => '0',"race" => '0',"owner" => '0',"full_name" => '0',"agent_id" => '0',"gender" => '0',"dob" => '0',"nationality" => '0',"nric_new" => '0',"nric_old" => '0',"resident_address" => '0',"nric_address" => '0',"resident_address2" => '0',"mobile1" => '0',"mobile2" => '0',"employment_details" => '0',"remarks" => '0',"marital" => '0',"spouse_details" => '0',"wanted_remarks" => '0',"borrower_remarks" => '0',"contactAddress" => '0',"contactMobile_number" => '0',"employmentEmployer_name" => '0',"employmentDesignation" => '0',"employmentSalary_range" => '0',"employmentPay_date" => '0',"employmentAdvance_date" => '0',"employmentStaff_id" => '0',"employmentHired_on" => '0',"employmentDepartment" => '0',"employmentAddress" => '0',"employmentWork_location" => '0',"employmentPhone" => '0',"employmentFax" => '0',"spousedetailsFull_name" => '0',"spousedetailsGender" => '0',"spousedetailsDob" => '0',"spousedetailsNationality" => '0',"spousedetailsNric_new" => '0',"spousedetailsNric_old" => '0',"spousedetailsResident_address" => '0',"spousedetailsNric_address" => '0',"spousedetailsResident_address2" => '0',"spousedetailsRemarks" => '0',"spousedetailsMarital" => '0',"spousedetailsRace" => '0',"spouseMobile1" => '0',"spouseMobile2" => '0',"spousecontactsMobile" => '0',"spouseemploymentsEmployer_name" => '0',"spouseemploymentsDesignation" => '0',"spouseemploymentsSalary_range" => '0',"spouseemploymentsPay_date" => '0',"spouseemploymentsAdvance_date" => '0',"spouseemploymentsStaff_id" => '0',"spouseemploymentsHired_on" => '0',"spouseemploymentsDepartment" => '0',"spouseemploymentsAddress" => '0',"spouseemploymentsWork_location" => '0',"spouseemploymentsPhone" => '0',"spouseemploymentsFax" => '0',"guarantorsFull_name" => '0',"guarantorsNric_new" => '0',"guarantorsNric_old" => '0',"guarantorsRelation" => '0',"guarantorsResidence_address" => '0',"guarantorsOther_address" => '0',"guarantorsMobile1" => '0',"guarantorsMobile2" => '0',"guarantorsEmployer_name" => '0',"guarantorsDesignation" => '0',"guarantorsStaff_id" => '0',"guarantorsHired_on" => '0',"guarantorsDepartment" => '0',"guarantorsEmployer_address" => '0',"guarantorsWork_location" => '0',"guarantorsPhone" => '0',"guarantorsMarital" => '0',"guarantorsFax" => '0',"referencesFull_name" => '0',"referencesEmployer_name" => '0',"referencesRelation" => '0',"referencesDesignation" => '0',"referencesNric_new" => '0',"referencesNric_old" => '0',"referencesStaff_id" => '0',"referencesHired_on" => '0',"referencesDepartment" => '0',"referencesResidence_address" => '0',"referencesEmployer_address" => '0',"referencesOther_address" => '0',"referencesWork_location" => '0',"referencesMarital" => '0',"referencesPhone" => '0',"referencesFax" => '0',"referencesMobile1" => '0',"referencesMobile2" => '0',"remarksRemarks" => '0'
            ));
            $this->db->insert();
        } else{
            $this->db->table("borrower_updates");
            $this->db->insertArray(array(
                "borrower_id" => $bid,"spouse_employment_id" => $spouse_employment_id,"label_contacts" => '0',"label_employments" => '0',"label_spouse" => '0',"label_spouse_employments" => '1',"label_guarantor" => '0',"label_references" => '0',"label_remarks" => '0',"race" => '0',"owner" => '0',"full_name" => '0',"agent_id" => '0',"gender" => '0',"dob" => '0',"nationality" => '0',"nric_new" => '0',"nric_old" => '0',"resident_address" => '0',"nric_address" => '0',"resident_address2" => '0',"mobile1" => '0',"mobile2" => '0',"employment_details" => '0',"remarks" => '0',"marital" => '0',"spouse_details" => '0',"wanted_remarks" => '0',"borrower_remarks" => '0',"contactAddress" => '0',"contactMobile_number" => '0',"employmentEmployer_name" => '0',"employmentDesignation" => '0',"employmentSalary_range" => '0',"employmentPay_date" => '0',"employmentAdvance_date" => '0',"employmentStaff_id" => '0',"employmentHired_on" => '0',"employmentDepartment" => '0',"employmentAddress" => '0',"employmentWork_location" => '0',"employmentPhone" => '0',"employmentFax" => '0',"spousedetailsFull_name" => '0',"spousedetailsGender" => '0',"spousedetailsDob" => '0',"spousedetailsNationality" => '0',"spousedetailsNric_new" => '0',"spousedetailsNric_old" => '0',"spousedetailsResident_address" => '0',"spousedetailsNric_address" => '0',"spousedetailsResident_address2" => '0',"spousedetailsRemarks" => '0',"spousedetailsMarital" => '0',"spousedetailsRace" => '0',"spouseMobile1" => '0',"spouseMobile2" => '0',"spousecontactsMobile" => '0',"spouseemploymentsEmployer_name" => '1',"spouseemploymentsDesignation" => '1',"spouseemploymentsSalary_range" => '1',"spouseemploymentsPay_date" => '1',"spouseemploymentsAdvance_date" => '1',"spouseemploymentsStaff_id" => '1',"spouseemploymentsHired_on" => '1',"spouseemploymentsDepartment" => '1',"spouseemploymentsAddress" => '1',"spouseemploymentsWork_location" => '1',"spouseemploymentsPhone" => '1',"spouseemploymentsFax" => '1',"guarantorsFull_name" => '0',"guarantorsNric_new" => '0',"guarantorsNric_old" => '0',"guarantorsRelation" => '0',"guarantorsResidence_address" => '0',"guarantorsOther_address" => '0',"guarantorsMobile1" => '0',"guarantorsMobile2" => '0',"guarantorsEmployer_name" => '0',"guarantorsDesignation" => '0',"guarantorsStaff_id" => '0',"guarantorsHired_on" => '0',"guarantorsDepartment" => '0',"guarantorsEmployer_address" => '0',"guarantorsWork_location" => '0',"guarantorsPhone" => '0',"guarantorsMarital" => '0',"guarantorsFax" => '0',"referencesFull_name" => '0',"referencesEmployer_name" => '0',"referencesRelation" => '0',"referencesDesignation" => '0',"referencesNric_new" => '0',"referencesNric_old" => '0',"referencesStaff_id" => '0',"referencesHired_on" => '0',"referencesDepartment" => '0',"referencesResidence_address" => '0',"referencesEmployer_address" => '0',"referencesOther_address" => '0',"referencesWork_location" => '0',"referencesMarital" => '0',"referencesPhone" => '0',"referencesFax" => '0',"referencesMobile1" => '0',"referencesMobile2" => '0',"remarksRemarks" => '0'
            ));
            $this->db->insert();

            $this->db->table("borrower_updates");
            $this->db->updateArray(array(
                "label_spouse_employments" => '1',
            ));
            $this->db->whereArray(array(
                "borrower_id" => $bid,
            ));
            $this->db->update();
        }

		$return['error'] = false;
		$return['msg'] = "Borrower Spouse Employment Inserted.";
		$return['url'] = option('base_uri').'/borrowers/'.$bid.'#spouse_employment';

        if($borrower['pending_approval'] == '0' && $borrower['borrower_status'] != '99' && $borrower['new'] != '1'){
            $this->db->table("borrowers");
            $this->db->updateArray(array(
                "borrower_status" => '2',
                "pending_approval" => '0'
            ));
            $this->db->whereArray(array(
                "borrower_id" => $bid,
            ));
            $this->db->update();
        }
        else if($borrower['pending_approval'] == '1' || $borrower['pending_approval'] == '2'){
            $this->db->table("borrowers");
            $this->db->updateArray(array(
                "borrower_status" => '2',
                "pending_approval" => '2'
            ));
            $this->db->whereArray(array(
                "borrower_id" => $bid,
            ));
            $this->db->update();
        }

		return json($return);
	}

	public function borrowerSpouseEmploymentUpdate($bid, $id){

        $this->db->query("SELECT * FROM borrowers WHERE borrower_id = ".$this->db->escape($bid)."");
        $borrower = $this->db->getSingleRow();

        $this->db->query("SELECT * FROM borrower_spouse_employments WHERE borrower_id = ".$this->db->escape($bid)." && employment_id = ".$this->db->escape($id)."");
        $borrower_spouse_employment = $this->db->getSingleRow();

        $this->db->query("SELECT * FROM borrower_updates WHERE borrower_id = ".$this->db->escape($bid)." && spouse_employment_id = ".$this->db->escape($id)."");
        $borrower_update = $this->db->getSingleRow();

		$this->db->table("borrower_spouse_employments");
		$this->db->updateArray(array(
			"employer_name" => $this->request("employer_name"),
			"designation" => $this->request("designation"),
			"salary_range" => $this->request("salary_range"),
			"pay_date" => $this->request("pay_date"),
			"advance_date" => $this->request("advance_date"),
			"staff_id" => $this->request("staff_id"),
			"hired_on" => $this->request("hired_on"),
			"department" => $this->request("department"),
			"address" => $this->request("address"),
			"work_location" => $this->request("work_location"),
			"phone" => $this->request("phone"),
			"fax" => $this->request("fax")
		));
		$this->db->whereArray(array(
			"borrower_id" => $bid,
			"employment_id" => $id
		));
		$this->db->update();

		$return['error'] = false;
		$return['msg'] = "Borrower Spouse Employment Updated.";
		$return['url'] = option('base_uri').'/borrowers/'.$bid.'#spouse_employment';

        if($borrower['pending_approval'] == '0'
                && $borrower['new'] != '1'
                && ($this->request('employer_name') != $borrower_spouse_employment['employer_name']
                || $this->request('designation') != $borrower_spouse_employment['designation']
                || $this->request('salary_range') != $borrower_spouse_employment['salary_range']
                || $this->request('pay_date') != $borrower_spouse_employment['pay_date']
                || $this->request('advance_date') != $borrower_spouse_employment['advance_date']
                || $this->request('staff_id') != $borrower_spouse_employment['staff_id']
                || $this->request('hired_on') != $borrower_spouse_employment['hired_on']
                || $this->request('department') != $borrower_spouse_employment['department']
                || $this->request('address') != $borrower_spouse_employment['address']
                || $this->request('work_location') != $borrower_spouse_employment['work_location']
                || $this->request('phone') != $borrower_spouse_employment['phone']
                || $this->request('fax') != $borrower_spouse_employment['fax'])){
            $this->db->table("borrowers");
            $this->db->updateArray(array(
                "borrower_status" => '2',
                "pending_approval" => '0'
            ));
            $this->db->whereArray(array(
                "borrower_id" => $bid,
            ));
            $this->db->update();

            $this->db->table("borrower_updates");
            $this->db->updateArray(array(
                "label_spouse_employments" => '1',
            ));
            $this->db->whereArray(array(
                "borrower_id" => $bid,
            ));
            $this->db->update();

            //insert updated status into borrower_updates if the data has been edited or is not the same as previous, 1(the label highlight becomes red)
            if($this->request('employer_name') != $borrower_spouse_employment['employer_name']){$this->db->table("borrower_updates");$this->db->updateArray(array(
                "spouseemploymentsEmployer_name" => '1',
            ));$this->db->whereArray(array("borrower_id" => $bid,"spouse_employment_id" => $id));$this->db->update();}
            if($this->request('designation') != $borrower_spouse_employment['designation']){$this->db->table("borrower_updates");$this->db->updateArray(array(
                "spouseemploymentsDesignation" => '1',
            ));$this->db->whereArray(array("borrower_id" => $bid,"spouse_employment_id" => $id));$this->db->update();}
            if($this->request('salary_range') != $borrower_spouse_employment['salary_range']){$this->db->table("borrower_updates");$this->db->updateArray(array(
                "spouseemploymentsSalary_range" => '1',
            ));$this->db->whereArray(array("borrower_id" => $bid,"spouse_employment_id" => $id));$this->db->update();}
            if($this->request('pay_date') != $borrower_spouse_employment['pay_date']){$this->db->table("borrower_updates");$this->db->updateArray(array(
                "spouseemploymentsPay_date" => '1',
            ));$this->db->whereArray(array("borrower_id" => $bid,"spouse_employment_id" => $id));$this->db->update();}
            if($this->request('advance_date') != $borrower_spouse_employment['advance_date']){$this->db->table("borrower_updates");$this->db->updateArray(array(
                "spouseemploymentsAdvance_date" => '1',
            ));$this->db->whereArray(array("borrower_id" => $bid,"spouse_employment_id" => $id));$this->db->update();}
            if($this->request('staff_id') != $borrower_spouse_employment['staff_id']){$this->db->table("borrower_updates");$this->db->updateArray(array(
                "spouseemploymentsStaff_id" => '1',
            ));$this->db->whereArray(array("borrower_id" => $bid,"spouse_employment_id" => $id));$this->db->update();}
            if($this->request('hired_on') != $borrower_spouse_employment['hired_on']){$this->db->table("borrower_updates");$this->db->updateArray(array(
                "spouseemploymentsHired_on" => '1',
            ));$this->db->whereArray(array("borrower_id" => $bid,"spouse_employment_id" => $id));$this->db->update();}
            if($this->request('department') != $borrower_spouse_employment['department']){$this->db->table("borrower_updates");$this->db->updateArray(array(
                "spouseemploymentsDepartment" => '1',
            ));$this->db->whereArray(array("borrower_id" => $bid,"spouse_employment_id" => $id));$this->db->update();}
            if($this->request('address') != $borrower_spouse_employment['address']){$this->db->table("borrower_updates");$this->db->updateArray(array(
                "spouseemploymentsAddress" => '1',
            ));$this->db->whereArray(array("borrower_id" => $bid,"spouse_employment_id" => $id));$this->db->update();}
            if($this->request('work_location') != $borrower_spouse_employment['work_location']){$this->db->table("borrower_updates");$this->db->updateArray(array(
                "spouseemploymentsWork_location" => '1',
            ));$this->db->whereArray(array("borrower_id" => $bid,"spouse_employment_id" => $id));$this->db->update();}
            if($this->request('phone') != $borrower_spouse_employment['phone']){$this->db->table("borrower_updates");$this->db->updateArray(array(
                "spouseemploymentsPhone" => '1',
            ));$this->db->whereArray(array("borrower_id" => $bid,"spouse_employment_id" => $id));$this->db->update();}
            if($this->request('fax') != $borrower_spouse_employment['fax']){$this->db->table("borrower_updates");$this->db->updateArray(array(
                "spouseemploymentsFax" => '1',
            ));$this->db->whereArray(array("borrower_id" => $bid,"spouse_employment_id" => $id));$this->db->update();}
        }
        else if(($borrower['pending_approval'] == '1'
                || $borrower['pending_approval'] == '2')
                && $borrower['new'] != '1'
                && ($this->request('employer_name') != $borrower_spouse_employment['employer_name']
                || $this->request('designation') != $borrower_spouse_employment['designation']
                || $this->request('salary_range') != $borrower_spouse_employment['salary_range']
                || $this->request('pay_date') != $borrower_spouse_employment['pay_date']
                || $this->request('advance_date') != $borrower_spouse_employment['advance_date']
                || $this->request('staff_id') != $borrower_spouse_employment['staff_id']
                || $this->request('hired_on') != $borrower_spouse_employment['hired_on']
                || $this->request('department') != $borrower_spouse_employment['department']
                || $this->request('address') != $borrower_spouse_employment['address']
                || $this->request('work_location') != $borrower_spouse_employment['work_location']
                || $this->request('phone') != $borrower_spouse_employment['phone']
                || $this->request('fax') != $borrower_spouse_employment['fax'])){
            $this->db->table("borrowers");
            $this->db->updateArray(array(
                "borrower_status" => '2',
                "pending_approval" => '2'
            ));
            $this->db->whereArray(array(
                "borrower_id" => $bid,
            ));
            $this->db->update();

            $this->db->table("borrower_updates");
            $this->db->updateArray(array(
                "label_spouse_employments" => '1',
            ));
            $this->db->whereArray(array(
                "borrower_id" => $bid,
            ));
            $this->db->update();

            //insert updated status into borrower_updates if the data has been edited or is not the same as previous, 1(the label highlight becomes red)
            if($this->request('employer_name') != $borrower_spouse_employment['employer_name']){$this->db->table("borrower_updates");$this->db->updateArray(array(
                "spouseemploymentsEmployer_name" => '1',
            ));$this->db->whereArray(array("borrower_id" => $bid,"spouse_employment_id" => $id));$this->db->update();}
            if($this->request('designation') != $borrower_spouse_employment['designation']){$this->db->table("borrower_updates");$this->db->updateArray(array(
                "spouseemploymentsDesignation" => '1',
            ));$this->db->whereArray(array("borrower_id" => $bid,"spouse_employment_id" => $id));$this->db->update();}
            if($this->request('salary_range') != $borrower_spouse_employment['salary_range']){$this->db->table("borrower_updates");$this->db->updateArray(array(
                "spouseemploymentsSalary_range" => '1',
            ));$this->db->whereArray(array("borrower_id" => $bid,"spouse_employment_id" => $id));$this->db->update();}
            if($this->request('pay_date') != $borrower_spouse_employment['pay_date']){$this->db->table("borrower_updates");$this->db->updateArray(array(
                "spouseemploymentsPay_date" => '1',
            ));$this->db->whereArray(array("borrower_id" => $bid,"spouse_employment_id" => $id));$this->db->update();}
            if($this->request('advance_date') != $borrower_spouse_employment['advance_date']){$this->db->table("borrower_updates");$this->db->updateArray(array(
                "spouseemploymentsAdvance_date" => '1',
            ));$this->db->whereArray(array("borrower_id" => $bid,"spouse_employment_id" => $id));$this->db->update();}
            if($this->request('staff_id') != $borrower_spouse_employment['staff_id']){$this->db->table("borrower_updates");$this->db->updateArray(array(
                "spouseemploymentsStaff_id" => '1',
            ));$this->db->whereArray(array("borrower_id" => $bid,"spouse_employment_id" => $id));$this->db->update();}
            if($this->request('hired_on') != $borrower_spouse_employment['hired_on']){$this->db->table("borrower_updates");$this->db->updateArray(array(
                "spouseemploymentsHired_on" => '1',
            ));$this->db->whereArray(array("borrower_id" => $bid,"spouse_employment_id" => $id));$this->db->update();}
            if($this->request('department') != $borrower_spouse_employment['department']){$this->db->table("borrower_updates");$this->db->updateArray(array(
                "spouseemploymentsDepartment" => '1',
            ));$this->db->whereArray(array("borrower_id" => $bid,"spouse_employment_id" => $id));$this->db->update();}
            if($this->request('address') != $borrower_spouse_employment['address']){$this->db->table("borrower_updates");$this->db->updateArray(array(
                "spouseemploymentsAddress" => '1',
            ));$this->db->whereArray(array("borrower_id" => $bid,"spouse_employment_id" => $id));$this->db->update();}
            if($this->request('work_location') != $borrower_spouse_employment['work_location']){$this->db->table("borrower_updates");$this->db->updateArray(array(
                "spouseemploymentsWork_location" => '1',
            ));$this->db->whereArray(array("borrower_id" => $bid,"spouse_employment_id" => $id));$this->db->update();}
            if($this->request('phone') != $borrower_spouse_employment['phone']){$this->db->table("borrower_updates");$this->db->updateArray(array(
                "spouseemploymentsPhone" => '1',
            ));$this->db->whereArray(array("borrower_id" => $bid,"spouse_employment_id" => $id));$this->db->update();}
            if($this->request('fax') != $borrower_spouse_employment['fax']){$this->db->table("borrower_updates");$this->db->updateArray(array(
                "spouseemploymentsFax" => '1',
            ));$this->db->whereArray(array("borrower_id" => $bid,"spouse_employment_id" => $id));$this->db->update();}
        }

		return json($return);
	}

	public function borrowerSpouseEmploymentDelete($bid, $id){
		$this->db->table("borrower_spouse_employments");
		$this->db->whereArray(array(
			"borrower_id" => $bid,
			"employment_id" => $id
		));
		$this->db->delete();

        $this->db->table("borrower_updates");
        $this->db->whereArray(array(
            "borrower_id" => $bid,
            "spouse_employment_id" => $id
        ));
        $this->db->delete();

		$return['error'] = false;
		$return['msg'] = "Borrower Spouse Employment Deleted.";
		return json($return);
	}

	public function borrowerGuarantorInsert($bid){
		$date = new DateTime();
		$guarantor_id = md5(uniqid(rand(), true));

        $this->db->query("SELECT * FROM borrowers WHERE borrower_id = ".$this->db->escape($bid)."");
        $borrower = $this->db->getSingleRow();

		$this->db->table("borrower_guarantors");
		$this->db->insertArray(array(
			"guarantor_id" => $guarantor_id,
			"borrower_id" => $bid,
			"full_name" => $this->request("full_name"),
			"nric_new" => $this->request("nric_new"),
			"nric_old" => $this->request("nric_old"),
			"relation" => $this->request("relation"),
			"residence_address" => $this->request("residence_address"),
			"other_address" => $this->request("other_address"),
			"mobile1" => $this->request("mobile1"),
			"mobile2" => $this->request("mobile2"),
			"employer_name" => $this->request("employer_name"),
			"designation" => $this->request("designation"),
			"staff_id" => $this->request("staff_id"),
			"hired_on" => $this->request("hired_on"),
			"department" => $this->request("department"),
			"employer_address" => $this->request("employer_address"),
			"work_location" => $this->request("work_location"),
			"phone" => $this->request("phone"),
			"marital" => $this->request("marital"),
			"fax" => $this->request("fax"),
			"created" => $date->format('Y-m-d H:i:s')
		));
		$this->db->insert();

        if($borrower['new'] == '1'){
            $this->db->table("borrower_updates");
            $this->db->insertArray(array(
                "borrower_id" => $bid,"guarantor_id" => $guarantor_id,"label_contacts" => '0',"label_employments" => '0',"label_spouse" => '0',"label_spouse_employments" => '0',"label_guarantor" => '0',"label_references" => '0',"label_remarks" => '0',"race" => '0',"owner" => '0',"full_name" => '0',"agent_id" => '0',"gender" => '0',"dob" => '0',"nationality" => '0',"nric_new" => '0',"nric_old" => '0',"resident_address" => '0',"nric_address" => '0',"resident_address2" => '0',"mobile1" => '0',"mobile2" => '0',"employment_details" => '0',"remarks" => '0',"marital" => '0',"spouse_details" => '0',"wanted_remarks" => '0',"borrower_remarks" => '0',"contactAddress" => '0',"contactMobile_number" => '0',"employmentEmployer_name" => '0',"employmentDesignation" => '0',"employmentSalary_range" => '0',"employmentPay_date" => '0',"employmentAdvance_date" => '0',"employmentStaff_id" => '0',"employmentHired_on" => '0',"employmentDepartment" => '0',"employmentAddress" => '0',"employmentWork_location" => '0',"employmentPhone" => '0',"employmentFax" => '0',"spousedetailsFull_name" => '0',"spousedetailsGender" => '0',"spousedetailsDob" => '0',"spousedetailsNationality" => '0',"spousedetailsNric_new" => '0',"spousedetailsNric_old" => '0',"spousedetailsResident_address" => '0',"spousedetailsNric_address" => '0',"spousedetailsResident_address2" => '0',"spousedetailsRemarks" => '0',"spousedetailsMarital" => '0',"spousedetailsRace" => '0',"spouseMobile1" => '0',"spouseMobile2" => '0',"spousecontactsMobile" => '0',"spouseemploymentsEmployer_name" => '0',"spouseemploymentsDesignation" => '0',"spouseemploymentsSalary_range" => '0',"spouseemploymentsPay_date" => '0',"spouseemploymentsAdvance_date" => '0',"spouseemploymentsStaff_id" => '0',"spouseemploymentsHired_on" => '0',"spouseemploymentsDepartment" => '0',"spouseemploymentsAddress" => '0',"spouseemploymentsWork_location" => '0',"spouseemploymentsPhone" => '0',"spouseemploymentsFax" => '0',"guarantorsFull_name" => '0',"guarantorsNric_new" => '0',"guarantorsNric_old" => '0',"guarantorsRelation" => '0',"guarantorsResidence_address" => '0',"guarantorsOther_address" => '0',"guarantorsMobile1" => '0',"guarantorsMobile2" => '0',"guarantorsEmployer_name" => '0',"guarantorsDesignation" => '0',"guarantorsStaff_id" => '0',"guarantorsHired_on" => '0',"guarantorsDepartment" => '0',"guarantorsEmployer_address" => '0',"guarantorsWork_location" => '0',"guarantorsPhone" => '0',"guarantorsMarital" => '0',"guarantorsFax" => '0',"referencesFull_name" => '0',"referencesEmployer_name" => '0',"referencesRelation" => '0',"referencesDesignation" => '0',"referencesNric_new" => '0',"referencesNric_old" => '0',"referencesStaff_id" => '0',"referencesHired_on" => '0',"referencesDepartment" => '0',"referencesResidence_address" => '0',"referencesEmployer_address" => '0',"referencesOther_address" => '0',"referencesWork_location" => '0',"referencesMarital" => '0',"referencesPhone" => '0',"referencesFax" => '0',"referencesMobile1" => '0',"referencesMobile2" => '0',"remarksRemarks" => '0'
            ));
            $this->db->insert();
        } else{
            $this->db->table("borrower_updates");
            $this->db->insertArray(array(
                "borrower_id" => $bid,"guarantor_id" => $guarantor_id,"label_contacts" => '0',"label_employments" => '0',"label_spouse" => '0',"label_spouse_employments" => '0',"label_guarantor" => '1',"label_references" => '0',"label_remarks" => '0',"race" => '0',"owner" => '0',"full_name" => '0',"agent_id" => '0',"gender" => '0',"dob" => '0',"nationality" => '0',"nric_new" => '0',"nric_old" => '0',"resident_address" => '0',"nric_address" => '0',"resident_address2" => '0',"mobile1" => '0',"mobile2" => '0',"employment_details" => '0',"remarks" => '0',"marital" => '0',"spouse_details" => '0',"wanted_remarks" => '0',"borrower_remarks" => '0',"contactAddress" => '0',"contactMobile_number" => '0',"employmentEmployer_name" => '0',"employmentDesignation" => '0',"employmentSalary_range" => '0',"employmentPay_date" => '0',"employmentAdvance_date" => '0',"employmentStaff_id" => '0',"employmentHired_on" => '0',"employmentDepartment" => '0',"employmentAddress" => '0',"employmentWork_location" => '0',"employmentPhone" => '0',"employmentFax" => '0',"spousedetailsFull_name" => '0',"spousedetailsGender" => '0',"spousedetailsDob" => '0',"spousedetailsNationality" => '0',"spousedetailsNric_new" => '0',"spousedetailsNric_old" => '0',"spousedetailsResident_address" => '0',"spousedetailsNric_address" => '0',"spousedetailsResident_address2" => '0',"spousedetailsRemarks" => '0',"spousedetailsMarital" => '0',"spousedetailsRace" => '0',"spouseMobile1" => '0',"spouseMobile2" => '0',"spousecontactsMobile" => '0',"spouseemploymentsEmployer_name" => '0',"spouseemploymentsDesignation" => '0',"spouseemploymentsSalary_range" => '0',"spouseemploymentsPay_date" => '0',"spouseemploymentsAdvance_date" => '0',"spouseemploymentsStaff_id" => '0',"spouseemploymentsHired_on" => '0',"spouseemploymentsDepartment" => '0',"spouseemploymentsAddress" => '0',"spouseemploymentsWork_location" => '0',"spouseemploymentsPhone" => '0',"spouseemploymentsFax" => '0',"guarantorsFull_name" => '1',"guarantorsNric_new" => '1',"guarantorsNric_old" => '1',"guarantorsRelation" => '1',"guarantorsResidence_address" => '1',"guarantorsOther_address" => '1',"guarantorsMobile1" => '1',"guarantorsMobile2" => '1',"guarantorsEmployer_name" => '1',"guarantorsDesignation" => '1',"guarantorsStaff_id" => '1',"guarantorsHired_on" => '1',"guarantorsDepartment" => '1',"guarantorsEmployer_address" => '1',"guarantorsWork_location" => '1',"guarantorsPhone" => '1',"guarantorsMarital" => '1',"guarantorsFax" => '1',"referencesFull_name" => '0',"referencesEmployer_name" => '0',"referencesRelation" => '0',"referencesDesignation" => '0',"referencesNric_new" => '0',"referencesNric_old" => '0',"referencesStaff_id" => '0',"referencesHired_on" => '0',"referencesDepartment" => '0',"referencesResidence_address" => '0',"referencesEmployer_address" => '0',"referencesOther_address" => '0',"referencesWork_location" => '0',"referencesMarital" => '0',"referencesPhone" => '0',"referencesFax" => '0',"referencesMobile1" => '0',"referencesMobile2" => '0',"remarksRemarks" => '0'
            ));
            $this->db->insert();

            $this->db->table("borrower_updates");
            $this->db->updateArray(array(
                "label_guarantor" => '1',
            ));
            $this->db->whereArray(array(
                "borrower_id" => $bid,
            ));
            $this->db->update();
        }

		$this->uploadDocument('photo_1', '', true, $guarantor_id);
		$this->uploadDocument('photo_2', 'label_photo_1', false, $guarantor_id);
		$this->uploadDocument('photo_3', 'label_photo_2', false, $guarantor_id);

		$return['error'] = false;
		$return['msg'] = "Borrower Guarantor Inserted.";
		$return['url'] = option('base_uri').'/borrowers/'.$bid.'#guarantor';

        if($borrower['pending_approval'] == '0' && $borrower['borrower_status'] != '99' && $borrower['new'] != '1'){
            $this->db->table("borrowers");
            $this->db->updateArray(array(
                "borrower_status" => '2',
                "pending_approval" => '0'
            ));
            $this->db->whereArray(array(
                "borrower_id" => $bid,
            ));
            $this->db->update();
        }
        else if($borrower['pending_approval'] == '1' || $borrower['pending_approval'] == '2'){
            $this->db->table("borrowers");
            $this->db->updateArray(array(
                "borrower_status" => '2',
                "pending_approval" => '2'
            ));
            $this->db->whereArray(array(
                "borrower_id" => $bid,
            ));
            $this->db->update();
        }

		return json($return);
	}

	public function borrowerGuarantorUpdate($bid, $id){

        $this->db->query("SELECT * FROM borrowers WHERE borrower_id = ".$this->db->escape($bid)."");
        $borrower = $this->db->getSingleRow();

        $this->db->query("SELECT * FROM borrower_guarantors WHERE borrower_id = ".$this->db->escape($bid)." && guarantor_id = ".$this->db->escape($id)."");
        $borrower_guarantor = $this->db->getSingleRow();

        $this->db->query("SELECT * FROM borrower_updates WHERE borrower_id = ".$this->db->escape($bid)." && guarantor_id = ".$this->db->escape($id)."");
        $borrower_update = $this->db->getSingleRow();

		$this->db->table("borrower_guarantors");
		$this->db->updateArray(array(
			"full_name" => $this->request("full_name"),
			"nric_new" => $this->request("nric_new"),
			"nric_old" => $this->request("nric_old"),
			"relation" => $this->request("relation"),
			"residence_address" => $this->request("residence_address"),
			"other_address" => $this->request("other_address"),
			"mobile1" => $this->request("mobile1"),
			"mobile2" => $this->request("mobile2"),
			"employer_name" => $this->request("employer_name"),
			"designation" => $this->request("designation"),
			"staff_id" => $this->request("staff_id"),
			"hired_on" => $this->request("hired_on"),
			"department" => $this->request("department"),
			"employer_address" => $this->request("employer_address"),
			"work_location" => $this->request("work_location"),
			"phone" => $this->request("phone"),
			"marital" => $this->request("marital"),
			"fax" => $this->request("fax"),
		));
		$this->db->whereArray(array(
			"borrower_id" => $bid,
			"guarantor_id" => $id
		));
		$this->db->update();

		$this->uploadDocument('photo_1', '', true, $id);
		$this->uploadDocument('photo_2', 'label_photo_1', false, $id);
		$this->uploadDocument('photo_3', 'label_photo_2', false, $id);

		$return['error'] = false;
		$return['msg'] = "Borrower Guarantor Updated.";
		$return['url'] = option('base_uri').'/borrowers/'.$bid.'#guarantor';

        if($borrower['pending_approval'] == '0'
                && $borrower['new'] != '1'
                && ($this->request('full_name') != $borrower_guarantor['full_name']
                || $this->request('nric_new') != $borrower_guarantor['nric_new']
                || $this->request('nric_old') != $borrower_guarantor['nric_old']
                || $this->request('relation') != $borrower_guarantor['relation']
                || $this->request('residence_address') != $borrower_guarantor['residence_address']
                || $this->request('other_address') != $borrower_guarantor['other_address']
                || $this->request('mobile1') != $borrower_guarantor['mobile1']
                || $this->request('mobile2') != $borrower_guarantor['mobile2']
                || $this->request('employer_name') != $borrower_guarantor['employer_name']
                || $this->request('designation') != $borrower_guarantor['designation']
                || $this->request('staff_id') != $borrower_guarantor['staff_id']
                || $this->request('hired_on') != $borrower_guarantor['hired_on']
                || $this->request('department') != $borrower_guarantor['department']
                || $this->request('employer_address') != $borrower_guarantor['employer_address']
                || $this->request('work_location') != $borrower_guarantor['work_location']
                || $this->request('phone') != $borrower_guarantor['phone']
                || $this->request('marital') != $borrower_guarantor['marital']
                || $this->request('fax') != $borrower_guarantor['fax'])){
            $this->db->table("borrowers");
            $this->db->updateArray(array(
                "borrower_status" => '2',
                "pending_approval" => '0'
            ));
            $this->db->whereArray(array(
                "borrower_id" => $bid,
            ));
            $this->db->update();

            $this->db->table("borrower_updates");
            $this->db->updateArray(array(
                "label_guarantor" => '1',
            ));
            $this->db->whereArray(array(
                "borrower_id" => $bid,
            ));
            $this->db->update();

            //insert updated status into borrower_updates if the data has been edited or is not the same as previous, 1(the label highlight becomes red)
            if($this->request('full_name') != $borrower_guarantor['full_name']){$this->db->table("borrower_updates");$this->db->updateArray(array(
                "guarantorsFull_name" => '1',
            ));$this->db->whereArray(array("borrower_id" => $bid,"guarantor_id" => $id));$this->db->update();}
            if($this->request('nric_new') != $borrower_guarantor['nric_new']){$this->db->table("borrower_updates");$this->db->updateArray(array(
                "guarantorsNric_new" => '1',
            ));$this->db->whereArray(array("borrower_id" => $bid,"guarantor_id" => $id));$this->db->update();}
            if($this->request('nric_old') != $borrower_guarantor['nric_old']){$this->db->table("borrower_updates");$this->db->updateArray(array(
                "guarantorsNric_old" => '1',
            ));$this->db->whereArray(array("borrower_id" => $bid,"guarantor_id" => $id));$this->db->update();}
            if($this->request('relation') != $borrower_guarantor['relation']){$this->db->table("borrower_updates");$this->db->updateArray(array(
                "guarantorsRelation" => '1',
            ));$this->db->whereArray(array("borrower_id" => $bid,"guarantor_id" => $id));$this->db->update();}
            if($this->request('residence_address') != $borrower_guarantor['residence_address']){$this->db->table("borrower_updates");$this->db->updateArray(array(
                "guarantorsResidence_address" => '1',
            ));$this->db->whereArray(array("borrower_id" => $bid,"guarantor_id" => $id));$this->db->update();}
            if($this->request('other_address') != $borrower_guarantor['other_address']){$this->db->table("borrower_updates");$this->db->updateArray(array(
                "guarantorsOther_address" => '1',
            ));$this->db->whereArray(array("borrower_id" => $bid,"guarantor_id" => $id));$this->db->update();}
            if($this->request('mobile1') != $borrower_guarantor['mobile1']){$this->db->table("borrower_updates");$this->db->updateArray(array(
                "guarantorsMobile1" => '1',
            ));$this->db->whereArray(array("borrower_id" => $bid,"guarantor_id" => $id));$this->db->update();}
            if($this->request('mobile2') != $borrower_guarantor['mobile2']){$this->db->table("borrower_updates");$this->db->updateArray(array(
                "guarantorsMobile2" => '1',
            ));$this->db->whereArray(array("borrower_id" => $bid,"guarantor_id" => $id));$this->db->update();}
            if($this->request('employer_name') != $borrower_guarantor['employer_name']){$this->db->table("borrower_updates");$this->db->updateArray(array(
                "guarantorsEmployer_name" => '1',
            ));$this->db->whereArray(array("borrower_id" => $bid,"guarantor_id" => $id));$this->db->update();}
            if($this->request('designation') != $borrower_guarantor['designation']){$this->db->table("borrower_updates");$this->db->updateArray(array(
                "guarantorsDesignation" => '1',
            ));$this->db->whereArray(array("borrower_id" => $bid,"guarantor_id" => $id));$this->db->update();}
            if($this->request('staff_id') != $borrower_guarantor['staff_id']){$this->db->table("borrower_updates");$this->db->updateArray(array(
                "guarantorsStaff_id" => '1',
            ));$this->db->whereArray(array("borrower_id" => $bid,"guarantor_id" => $id));$this->db->update();}
            if($this->request('hired_on') != $borrower_guarantor['hired_on']){$this->db->table("borrower_updates");$this->db->updateArray(array(
                "guarantorsHired_on" => '1',
            ));$this->db->whereArray(array("borrower_id" => $bid,"guarantor_id" => $id));$this->db->update();}
            if($this->request('department') != $borrower_guarantor['department']){$this->db->table("borrower_updates");$this->db->updateArray(array(
                "guarantorsDepartment" => '1',
            ));$this->db->whereArray(array("borrower_id" => $bid,"guarantor_id" => $id));$this->db->update();}
            if($this->request('employer_address') != $borrower_guarantor['employer_address']){$this->db->table("borrower_updates");$this->db->updateArray(array(
                "guarantorsEmployer_address" => '1',
            ));$this->db->whereArray(array("borrower_id" => $bid,"guarantor_id" => $id));$this->db->update();}
            if($this->request('work_location') != $borrower_guarantor['work_location']){$this->db->table("borrower_updates");$this->db->updateArray(array(
                "guarantorsWork_location" => '1',
            ));$this->db->whereArray(array("borrower_id" => $bid,"guarantor_id" => $id));$this->db->update();}
            if($this->request('phone') != $borrower_guarantor['phone']){$this->db->table("borrower_updates");$this->db->updateArray(array(
                "guarantorsPhone" => '1',
            ));$this->db->whereArray(array("borrower_id" => $bid,"guarantor_id" => $id));$this->db->update();}
            if($this->request('marital') != $borrower_guarantor['marital']){$this->db->table("borrower_updates");$this->db->updateArray(array(
                "guarantorsMarital" => '1',
            ));$this->db->whereArray(array("borrower_id" => $bid,"guarantor_id" => $id));$this->db->update();}
            if($this->request('fax') != $borrower_guarantor['fax']){$this->db->table("borrower_updates");$this->db->updateArray(array(
                "guarantorsFax" => '1',
            ));$this->db->whereArray(array("borrower_id" => $bid,"guarantor_id" => $id));$this->db->update();}
        }
        else if(($borrower['pending_approval'] == '1'
                || $borrower['pending_approval'] == '2')
                && $borrower['new'] != '1'
                && ($this->request('full_name') != $borrower_guarantor['full_name']
                || $this->request('nric_new') != $borrower_guarantor['nric_new']
                || $this->request('nric_old') != $borrower_guarantor['nric_old']
                || $this->request('relation') != $borrower_guarantor['relation']
                || $this->request('residence_address') != $borrower_guarantor['residence_address']
                || $this->request('other_address') != $borrower_guarantor['other_address']
                || $this->request('mobile1') != $borrower_guarantor['mobile1']
                || $this->request('mobile2') != $borrower_guarantor['mobile2']
                || $this->request('employer_name') != $borrower_guarantor['employer_name']
                || $this->request('designation') != $borrower_guarantor['designation']
                || $this->request('staff_id') != $borrower_guarantor['staff_id']
                || $this->request('hired_on') != $borrower_guarantor['hired_on']
                || $this->request('department') != $borrower_guarantor['department']
                || $this->request('employer_address') != $borrower_guarantor['employer_address']
                || $this->request('work_location') != $borrower_guarantor['work_location']
                || $this->request('phone') != $borrower_guarantor['phone']
                || $this->request('marital') != $borrower_guarantor['marital']
                || $this->request('fax') != $borrower_guarantor['fax'])){
            $this->db->table("borrowers");
            $this->db->updateArray(array(
                "borrower_status" => '2',
                "pending_approval" => '2'
            ));
            $this->db->whereArray(array(
                "borrower_id" => $bid,
            ));
            $this->db->update();

            $this->db->table("borrower_updates");
            $this->db->updateArray(array(
                "label_guarantor" => '1',
            ));
            $this->db->whereArray(array(
                "borrower_id" => $bid,
            ));
            $this->db->update();

            //insert updated status into borrower_updates if the data has been edited or is not the same as previous, 1(the label highlight becomes red)
            if($this->request('full_name') != $borrower_guarantor['full_name']){$this->db->table("borrower_updates");$this->db->updateArray(array(
                "guarantorsFull_name" => '1',
            ));$this->db->whereArray(array("borrower_id" => $bid,"guarantor_id" => $id));$this->db->update();}
            if($this->request('nric_new') != $borrower_guarantor['nric_new']){$this->db->table("borrower_updates");$this->db->updateArray(array(
                "guarantorsNric_new" => '1',
            ));$this->db->whereArray(array("borrower_id" => $bid,"guarantor_id" => $id));$this->db->update();}
            if($this->request('nric_old') != $borrower_guarantor['nric_old']){$this->db->table("borrower_updates");$this->db->updateArray(array(
                "guarantorsNric_old" => '1',
            ));$this->db->whereArray(array("borrower_id" => $bid,"guarantor_id" => $id));$this->db->update();}
            if($this->request('relation') != $borrower_guarantor['relation']){$this->db->table("borrower_updates");$this->db->updateArray(array(
                "guarantorsRelation" => '1',
            ));$this->db->whereArray(array("borrower_id" => $bid,"guarantor_id" => $id));$this->db->update();}
            if($this->request('residence_address') != $borrower_guarantor['residence_address']){$this->db->table("borrower_updates");$this->db->updateArray(array(
                "guarantorsResidence_address" => '1',
            ));$this->db->whereArray(array("borrower_id" => $bid,"guarantor_id" => $id));$this->db->update();}
            if($this->request('other_address') != $borrower_guarantor['other_address']){$this->db->table("borrower_updates");$this->db->updateArray(array(
                "guarantorsOther_address" => '1',
            ));$this->db->whereArray(array("borrower_id" => $bid,"guarantor_id" => $id));$this->db->update();}
            if($this->request('mobile1') != $borrower_guarantor['mobile1']){$this->db->table("borrower_updates");$this->db->updateArray(array(
                "guarantorsMobile1" => '1',
            ));$this->db->whereArray(array("borrower_id" => $bid,"guarantor_id" => $id));$this->db->update();}
            if($this->request('mobile2') != $borrower_guarantor['mobile2']){$this->db->table("borrower_updates");$this->db->updateArray(array(
                "guarantorsMobile2" => '1',
            ));$this->db->whereArray(array("borrower_id" => $bid,"guarantor_id" => $id));$this->db->update();}
            if($this->request('employer_name') != $borrower_guarantor['employer_name']){$this->db->table("borrower_updates");$this->db->updateArray(array(
                "guarantorsEmployer_name" => '1',
            ));$this->db->whereArray(array("borrower_id" => $bid,"guarantor_id" => $id));$this->db->update();}
            if($this->request('designation') != $borrower_guarantor['designation']){$this->db->table("borrower_updates");$this->db->updateArray(array(
                "guarantorsDesignation" => '1',
            ));$this->db->whereArray(array("borrower_id" => $bid,"guarantor_id" => $id));$this->db->update();}
            if($this->request('staff_id') != $borrower_guarantor['staff_id']){$this->db->table("borrower_updates");$this->db->updateArray(array(
                "guarantorsStaff_id" => '1',
            ));$this->db->whereArray(array("borrower_id" => $bid,"guarantor_id" => $id));$this->db->update();}
            if($this->request('hired_on') != $borrower_guarantor['hired_on']){$this->db->table("borrower_updates");$this->db->updateArray(array(
                "guarantorsHired_on" => '1',
            ));$this->db->whereArray(array("borrower_id" => $bid,"guarantor_id" => $id));$this->db->update();}
            if($this->request('department') != $borrower_guarantor['department']){$this->db->table("borrower_updates");$this->db->updateArray(array(
                "guarantorsDepartment" => '1',
            ));$this->db->whereArray(array("borrower_id" => $bid,"guarantor_id" => $id));$this->db->update();}
            if($this->request('employer_address') != $borrower_guarantor['employer_address']){$this->db->table("borrower_updates");$this->db->updateArray(array(
                "guarantorsEmployer_address" => '1',
            ));$this->db->whereArray(array("borrower_id" => $bid,"guarantor_id" => $id));$this->db->update();}
            if($this->request('work_location') != $borrower_guarantor['work_location']){$this->db->table("borrower_updates");$this->db->updateArray(array(
                "guarantorsWork_location" => '1',
            ));$this->db->whereArray(array("borrower_id" => $bid,"guarantor_id" => $id));$this->db->update();}
            if($this->request('phone') != $borrower_guarantor['phone']){$this->db->table("borrower_updates");$this->db->updateArray(array(
                "guarantorsPhone" => '1',
            ));$this->db->whereArray(array("borrower_id" => $bid,"guarantor_id" => $id));$this->db->update();}
            if($this->request('marital') != $borrower_guarantor['marital']){$this->db->table("borrower_updates");$this->db->updateArray(array(
                "guarantorsMarital" => '1',
            ));$this->db->whereArray(array("borrower_id" => $bid,"guarantor_id" => $id));$this->db->update();}
            if($this->request('fax') != $borrower_guarantor['fax']){$this->db->table("borrower_updates");$this->db->updateArray(array(
                "guarantorsFax" => '1',
            ));$this->db->whereArray(array("borrower_id" => $bid,"guarantor_id" => $id));$this->db->update();}
        }

		return json($return);
	}

	public function borrowerGuarantorDelete($bid, $id){
		$this->db->table("borrower_guarantors");
		$this->db->whereArray(array(
			"borrower_id" => $bid,
			"guarantor_id" => $id
		));
		$this->db->delete();

        $this->db->table("borrower_updates");
        $this->db->whereArray(array(
            "borrower_id" => $bid,
            "guarantor_id" => $id
        ));
        $this->db->delete();

		$return['error'] = false;
		$return['msg'] = "Borrower Guarantor Deleted.";
		return json($return);
	}

	public function borrowerReferenceInsert($bid){
		$date = new DateTime();
		$reference_id = md5(uniqid(rand(), true));

        $this->db->query("SELECT * FROM borrowers WHERE borrower_id = ".$this->db->escape($bid)."");
        $borrower = $this->db->getSingleRow();

		$this->db->table("borrower_references");
		$this->db->insertArray(array(
			"reference_id" => $reference_id,
			"borrower_id" => $bid,
			"full_name" => $this->request("full_name"),
			"employer_name" => $this->request("employer_name"),
			"relation" => $this->request("relation"),
			"designation" => $this->request("designation"),
			"nric_new" => $this->request("nric_new"),
			"nric_old" => $this->request("nric_old"),
			"staff_id" => $this->request("staff_id"),
			"hired_on" => $this->request("hired_on"),
			"department" => $this->request("department"),
			"residence_address" => $this->request("residence_address"),
			"employer_address" => $this->request("employer_address"),
			"other_address" => $this->request("other_address"),
			"work_location" => $this->request("work_location"),
			"marital" => $this->request("marital"),
			"phone" => $this->request("phone"),
			"fax" => $this->request("fax"),
			"mobile1" => $this->request("mobile1"),
			"mobile2" => $this->request("mobile2"),
			"created" => $date->format('Y-m-d H:i:s')
		));
		$this->db->insert();

        if($borrower['new'] == '1'){
            $this->db->table("borrower_updates");
            $this->db->insertArray(array(
                "borrower_id" => $bid,"reference_id" => $reference_id,"label_contacts" => '0',"label_employments" => '0',"label_spouse" => '0',"label_spouse_employments" => '0',"label_guarantor" => '0',"label_references" => '0',"label_remarks" => '0',"race" => '0',"owner" => '0',"full_name" => '0',"agent_id" => '0',"gender" => '0',"dob" => '0',"nationality" => '0',"nric_new" => '0',"nric_old" => '0',"resident_address" => '0',"nric_address" => '0',"resident_address2" => '0',"mobile1" => '0',"mobile2" => '0',"employment_details" => '0',"remarks" => '0',"marital" => '0',"spouse_details" => '0',"wanted_remarks" => '0',"borrower_remarks" => '0',"contactAddress" => '0',"contactMobile_number" => '0',"employmentEmployer_name" => '0',"employmentDesignation" => '0',"employmentSalary_range" => '0',"employmentPay_date" => '0',"employmentAdvance_date" => '0',"employmentStaff_id" => '0',"employmentHired_on" => '0',"employmentDepartment" => '0',"employmentAddress" => '0',"employmentWork_location" => '0',"employmentPhone" => '0',"employmentFax" => '0',"spousedetailsFull_name" => '0',"spousedetailsGender" => '0',"spousedetailsDob" => '0',"spousedetailsNationality" => '0',"spousedetailsNric_new" => '0',"spousedetailsNric_old" => '0',"spousedetailsResident_address" => '0',"spousedetailsNric_address" => '0',"spousedetailsResident_address2" => '0',"spousedetailsRemarks" => '0',"spousedetailsMarital" => '0',"spousedetailsRace" => '0',"spouseMobile1" => '0',"spouseMobile2" => '0',"spousecontactsMobile" => '0',"spouseemploymentsEmployer_name" => '0',"spouseemploymentsDesignation" => '0',"spouseemploymentsSalary_range" => '0',"spouseemploymentsPay_date" => '0',"spouseemploymentsAdvance_date" => '0',"spouseemploymentsStaff_id" => '0',"spouseemploymentsHired_on" => '0',"spouseemploymentsDepartment" => '0',"spouseemploymentsAddress" => '0',"spouseemploymentsWork_location" => '0',"spouseemploymentsPhone" => '0',"spouseemploymentsFax" => '0',"guarantorsFull_name" => '0',"guarantorsNric_new" => '0',"guarantorsNric_old" => '0',"guarantorsRelation" => '0',"guarantorsResidence_address" => '0',"guarantorsOther_address" => '0',"guarantorsMobile1" => '0',"guarantorsMobile2" => '0',"guarantorsEmployer_name" => '0',"guarantorsDesignation" => '0',"guarantorsStaff_id" => '0',"guarantorsHired_on" => '0',"guarantorsDepartment" => '0',"guarantorsEmployer_address" => '0',"guarantorsWork_location" => '0',"guarantorsPhone" => '0',"guarantorsMarital" => '0',"guarantorsFax" => '0',"referencesFull_name" => '0',"referencesEmployer_name" => '0',"referencesRelation" => '0',"referencesDesignation" => '0',"referencesNric_new" => '0',"referencesNric_old" => '0',"referencesStaff_id" => '0',"referencesHired_on" => '0',"referencesDepartment" => '0',"referencesResidence_address" => '0',"referencesEmployer_address" => '0',"referencesOther_address" => '0',"referencesWork_location" => '0',"referencesMarital" => '0',"referencesPhone" => '0',"referencesFax" => '0',"referencesMobile1" => '0',"referencesMobile2" => '0',"remarksRemarks" => '0'
            ));
            $this->db->insert();
        } else{
            $this->db->table("borrower_updates");
            $this->db->insertArray(array(
                "borrower_id" => $bid,"reference_id" => $reference_id,"label_contacts" => '0',"label_employments" => '0',"label_spouse" => '0',"label_spouse_employments" => '0',"label_guarantor" => '0',"label_references" => '1',"label_remarks" => '0',"race" => '0',"owner" => '0',"full_name" => '0',"agent_id" => '0',"gender" => '0',"dob" => '0',"nationality" => '0',"nric_new" => '0',"nric_old" => '0',"resident_address" => '0',"nric_address" => '0',"resident_address2" => '0',"mobile1" => '0',"mobile2" => '0',"employment_details" => '0',"remarks" => '0',"marital" => '0',"spouse_details" => '0',"wanted_remarks" => '0',"borrower_remarks" => '0',"contactAddress" => '0',"contactMobile_number" => '0',"employmentEmployer_name" => '0',"employmentDesignation" => '0',"employmentSalary_range" => '0',"employmentPay_date" => '0',"employmentAdvance_date" => '0',"employmentStaff_id" => '0',"employmentHired_on" => '0',"employmentDepartment" => '0',"employmentAddress" => '0',"employmentWork_location" => '0',"employmentPhone" => '0',"employmentFax" => '0',"spousedetailsFull_name" => '0',"spousedetailsGender" => '0',"spousedetailsDob" => '0',"spousedetailsNationality" => '0',"spousedetailsNric_new" => '0',"spousedetailsNric_old" => '0',"spousedetailsResident_address" => '0',"spousedetailsNric_address" => '0',"spousedetailsResident_address2" => '0',"spousedetailsRemarks" => '0',"spousedetailsMarital" => '0',"spousedetailsRace" => '0',"spouseMobile1" => '0',"spouseMobile2" => '0',"spousecontactsMobile" => '0',"spouseemploymentsEmployer_name" => '0',"spouseemploymentsDesignation" => '0',"spouseemploymentsSalary_range" => '0',"spouseemploymentsPay_date" => '0',"spouseemploymentsAdvance_date" => '0',"spouseemploymentsStaff_id" => '0',"spouseemploymentsHired_on" => '0',"spouseemploymentsDepartment" => '0',"spouseemploymentsAddress" => '0',"spouseemploymentsWork_location" => '0',"spouseemploymentsPhone" => '0',"spouseemploymentsFax" => '0',"guarantorsFull_name" => '0',"guarantorsNric_new" => '0',"guarantorsNric_old" => '0',"guarantorsRelation" => '0',"guarantorsResidence_address" => '0',"guarantorsOther_address" => '0',"guarantorsMobile1" => '0',"guarantorsMobile2" => '0',"guarantorsEmployer_name" => '0',"guarantorsDesignation" => '0',"guarantorsStaff_id" => '0',"guarantorsHired_on" => '0',"guarantorsDepartment" => '0',"guarantorsEmployer_address" => '0',"guarantorsWork_location" => '0',"guarantorsPhone" => '0',"guarantorsMarital" => '0',"guarantorsFax" => '0',"referencesFull_name" => '1',"referencesEmployer_name" => '1',"referencesRelation" => '1',"referencesDesignation" => '1',"referencesNric_new" => '1',"referencesNric_old" => '1',"referencesStaff_id" => '1',"referencesHired_on" => '1',"referencesDepartment" => '1',"referencesResidence_address" => '1',"referencesEmployer_address" => '1',"referencesOther_address" => '1',"referencesWork_location" => '1',"referencesMarital" => '1',"referencesPhone" => '1',"referencesFax" => '1',"referencesMobile1" => '1',"referencesMobile2" => '1',"remarksRemarks" => '0'
            ));
            $this->db->insert();

            $this->db->table("borrower_updates");
            $this->db->updateArray(array(
                "label_references" => '1',
            ));
            $this->db->whereArray(array(
                "borrower_id" => $bid,
            ));
            $this->db->update();
        }

		$return['error'] = false;
		$return['msg'] = "Borrower Reference Inserted.";
		$return['url'] = option('base_uri').'/borrowers/'.$bid.'#references';

        if($borrower['pending_approval'] == '0' && $borrower['borrower_status'] != '99' && $borrower['new'] != '1'){
            $this->db->table("borrowers");
            $this->db->updateArray(array(
                "borrower_status" => '2',
                "pending_approval" => '0'
            ));
            $this->db->whereArray(array(
                "borrower_id" => $bid,
            ));
            $this->db->update();
        }
        else if($borrower['pending_approval'] == '1' || $borrower['pending_approval'] == '2'){
            $this->db->table("borrowers");
            $this->db->updateArray(array(
                "borrower_status" => '2',
                "pending_approval" => '2'
            ));
            $this->db->whereArray(array(
                "borrower_id" => $bid,
            ));
            $this->db->update();
        }

		return json($return);
	}

	public function borrowerReferenceUpdate($bid, $id){

        $this->db->query("SELECT * FROM borrowers WHERE borrower_id = ".$this->db->escape($bid)."");
        $borrower = $this->db->getSingleRow();

        $this->db->query("SELECT * FROM borrower_references WHERE borrower_id = ".$this->db->escape($bid)." && reference_id = ".$this->db->escape($id)."");
        $borrower_reference = $this->db->getSingleRow();

        $this->db->query("SELECT * FROM borrower_updates WHERE borrower_id = ".$this->db->escape($bid)." && reference_id = ".$this->db->escape($id)."");
        $borrower_update = $this->db->getSingleRow();

		$this->db->table("borrower_references");
		$this->db->updateArray(array(
			"full_name" => $this->request("full_name"),
			"employer_name" => $this->request("employer_name"),
			"relation" => $this->request("relation"),
			"designation" => $this->request("designation"),
			"nric_new" => $this->request("nric_new"),
			"nric_old" => $this->request("nric_old"),
			"staff_id" => $this->request("staff_id"),
			"hired_on" => $this->request("hired_on"),
			"department" => $this->request("department"),
			"residence_address" => $this->request("residence_address"),
			"employer_address" => $this->request("employer_address"),
			"other_address" => $this->request("other_address"),
			"work_location" => $this->request("work_location"),
			"marital" => $this->request("marital"),
			"phone" => $this->request("phone"),
			"fax" => $this->request("fax"),
			"mobile1" => $this->request("mobile1"),
			"mobile2" => $this->request("mobile2"),
		));
		$this->db->whereArray(array(
			"borrower_id" => $bid,
			"reference_id" => $id
		));
		$this->db->update();

		$return['error'] = false;
		$return['msg'] = "Borrower Reference Updated.";
		$return['url'] = option('base_uri').'/borrowers/'.$bid.'#references';

        if($borrower['pending_approval'] == '0'
                && $borrower['new'] != '1'
                && ($this->request('full_name') != $borrower_reference['full_name']
                || $this->request('employer_name') != $borrower_reference['employer_name']
                || $this->request('relation') != $borrower_reference['relation']
                || $this->request('designation') != $borrower_reference['designation']
                || $this->request('nric_new') != $borrower_reference['nric_new']
                || $this->request('nric_old') != $borrower_reference['nric_old']
                || $this->request('staff_id') != $borrower_reference['staff_id']
                || $this->request('hired_on') != $borrower_reference['hired_on']
                || $this->request('department') != $borrower_reference['department']
                || $this->request('residence_address') != $borrower_reference['residence_address']
                || $this->request('employer_address') != $borrower_reference['employer_address']
                || $this->request('other_address') != $borrower_reference['other_address']
                || $this->request('work_location') != $borrower_reference['work_location']
                || $this->request('marital') != $borrower_reference['marital']
                || $this->request('phone') != $borrower_reference['phone']
                || $this->request('fax') != $borrower_reference['fax']
                || $this->request('mobile1') != $borrower_reference['mobile1']
                || $this->request('mobile2') != $borrower_reference['mobile2'])){
            $this->db->table("borrowers");
            $this->db->updateArray(array(
                "borrower_status" => '2',
                "pending_approval" => '0'
            ));
            $this->db->whereArray(array(
                "borrower_id" => $bid,
            ));
            $this->db->update();

            $this->db->table("borrower_updates");
            $this->db->updateArray(array(
                "label_references" => '1',
            ));
            $this->db->whereArray(array(
                "borrower_id" => $bid,
            ));
            $this->db->update();

            //insert updated status into borrower_updates if the data has been edited or is not the same as previous, 1(the label highlight becomes red)
            if($this->request('full_name') != $borrower_reference['full_name']){$this->db->table("borrower_updates");$this->db->updateArray(array(
                "referencesFull_name" => '1',
            ));$this->db->whereArray(array("borrower_id" => $bid,"reference_id" => $id));$this->db->update();}
            if($this->request('employer_name') != $borrower_reference['employer_name']){$this->db->table("borrower_updates");$this->db->updateArray(array(
                "referencesEmployer_name" => '1',
            ));$this->db->whereArray(array("borrower_id" => $bid,"reference_id" => $id));$this->db->update();}
            if($this->request('relation') != $borrower_reference['relation']){$this->db->table("borrower_updates");$this->db->updateArray(array(
                "referencesRelation" => '1',
            ));$this->db->whereArray(array("borrower_id" => $bid,"reference_id" => $id));$this->db->update();}
            if($this->request('designation') != $borrower_reference['designation']){$this->db->table("borrower_updates");$this->db->updateArray(array(
                "referencesDesignation" => '1',
            ));$this->db->whereArray(array("borrower_id" => $bid,"reference_id" => $id));$this->db->update();}
            if($this->request('nric_new') != $borrower_reference['nric_new']){$this->db->table("borrower_updates");$this->db->updateArray(array(
                "referencesNric_new" => '1',
            ));$this->db->whereArray(array("borrower_id" => $bid,"reference_id" => $id));$this->db->update();}
            if($this->request('nric_old') != $borrower_reference['nric_old']){$this->db->table("borrower_updates");$this->db->updateArray(array(
                "referencesNric_old" => '1',
            ));$this->db->whereArray(array("borrower_id" => $bid,"reference_id" => $id));$this->db->update();}
            if($this->request('staff_id') != $borrower_reference['staff_id']){$this->db->table("borrower_updates");$this->db->updateArray(array(
                "referencesStaff_id" => '1',
            ));$this->db->whereArray(array("borrower_id" => $bid,"reference_id" => $id));$this->db->update();}
            if($this->request('hired_on') != $borrower_reference['hired_on']){$this->db->table("borrower_updates");$this->db->updateArray(array(
                "referencesHired_on" => '1',
            ));$this->db->whereArray(array("borrower_id" => $bid,"reference_id" => $id));$this->db->update();}
            if($this->request('department') != $borrower_reference['department']){$this->db->table("borrower_updates");$this->db->updateArray(array(
                "referencesDepartment" => '1',
            ));$this->db->whereArray(array("borrower_id" => $bid,"reference_id" => $id));$this->db->update();}
            if($this->request('residence_address') != $borrower_reference['residence_address']){$this->db->table("borrower_updates");$this->db->updateArray(array(
                "referencesResidence_address" => '1',
            ));$this->db->whereArray(array("borrower_id" => $bid,"reference_id" => $id));$this->db->update();}
            if($this->request('employer_address') != $borrower_reference['employer_address']){$this->db->table("borrower_updates");$this->db->updateArray(array(
                "referencesEmployer_address" => '1',
            ));$this->db->whereArray(array("borrower_id" => $bid,"reference_id" => $id));$this->db->update();}
            if($this->request('other_address') != $borrower_reference['other_address']){$this->db->table("borrower_updates");$this->db->updateArray(array(
                "referencesOther_address" => '1',
            ));$this->db->whereArray(array("borrower_id" => $bid,"reference_id" => $id));$this->db->update();}
            if($this->request('work_location') != $borrower_reference['work_location']){$this->db->table("borrower_updates");$this->db->updateArray(array(
                "referencesWork_location" => '1',
            ));$this->db->whereArray(array("borrower_id" => $bid,"reference_id" => $id));$this->db->update();}
            if($this->request('marital') != $borrower_reference['marital']){$this->db->table("borrower_updates");$this->db->updateArray(array(
                "referencesMarital" => '1',
            ));$this->db->whereArray(array("borrower_id" => $bid,"reference_id" => $id));$this->db->update();}
            if($this->request('phone') != $borrower_reference['phone']){$this->db->table("borrower_updates");$this->db->updateArray(array(
                "referencesPhone" => '1',
            ));$this->db->whereArray(array("borrower_id" => $bid,"reference_id" => $id));$this->db->update();}
            if($this->request('fax') != $borrower_reference['fax']){$this->db->table("borrower_updates");$this->db->updateArray(array(
                "referencesFax" => '1',
            ));$this->db->whereArray(array("borrower_id" => $bid,"reference_id" => $id));$this->db->update();}
            if($this->request('mobile1') != $borrower_reference['mobile1']){$this->db->table("borrower_updates");$this->db->updateArray(array(
                "referencesMobile1" => '1',
            ));$this->db->whereArray(array("borrower_id" => $bid,"reference_id" => $id));$this->db->update();}
            if($this->request('mobile2') != $borrower_reference['mobile2']){$this->db->table("borrower_updates");$this->db->updateArray(array(
                "referencesMobile2" => '1',
            ));$this->db->whereArray(array("borrower_id" => $bid,"reference_id" => $id));$this->db->update();}
        }
        else if(($borrower['pending_approval'] == '1'
                || $borrower['pending_approval'] == '2')
                && $borrower['new'] != '1'
                && ($this->request('full_name') != $borrower_reference['full_name']
                || $this->request('employer_name') != $borrower_reference['employer_name']
                || $this->request('relation') != $borrower_reference['relation']
                || $this->request('designation') != $borrower_reference['designation']
                || $this->request('nric_new') != $borrower_reference['nric_new']
                || $this->request('nric_old') != $borrower_reference['nric_old']
                || $this->request('staff_id') != $borrower_reference['staff_id']
                || $this->request('hired_on') != $borrower_reference['hired_on']
                || $this->request('department') != $borrower_reference['department']
                || $this->request('residence_address') != $borrower_reference['residence_address']
                || $this->request('employer_address') != $borrower_reference['employer_address']
                || $this->request('other_address') != $borrower_reference['other_address']
                || $this->request('work_location') != $borrower_reference['work_location']
                || $this->request('marital') != $borrower_reference['marital']
                || $this->request('phone') != $borrower_reference['phone']
                || $this->request('fax') != $borrower_reference['fax']
                || $this->request('mobile1') != $borrower_reference['mobile1']
                || $this->request('mobile2') != $borrower_reference['mobile2'])){
            $this->db->table("borrowers");
            $this->db->updateArray(array(
                "borrower_status" => '2',
                "pending_approval" => '2'
            ));
            $this->db->whereArray(array(
                "borrower_id" => $bid,
            ));
            $this->db->update();

            $this->db->table("borrower_updates");
            $this->db->updateArray(array(
                "label_references" => '1',
            ));
            $this->db->whereArray(array(
                "borrower_id" => $bid,
            ));
            $this->db->update();

            //insert updated status into borrower_updates if the data has been edited or is not the same as previous, 1(the label highlight becomes red)
            if($this->request('full_name') != $borrower_reference['full_name']){$this->db->table("borrower_updates");$this->db->updateArray(array(
                "referencesFull_name" => '1',
            ));$this->db->whereArray(array("borrower_id" => $bid,"reference_id" => $id));$this->db->update();}
            if($this->request('employer_name') != $borrower_reference['employer_name']){$this->db->table("borrower_updates");$this->db->updateArray(array(
                "referencesEmployer_name" => '1',
            ));$this->db->whereArray(array("borrower_id" => $bid,"reference_id" => $id));$this->db->update();}
            if($this->request('relation') != $borrower_reference['relation']){$this->db->table("borrower_updates");$this->db->updateArray(array(
                "referencesRelation" => '1',
            ));$this->db->whereArray(array("borrower_id" => $bid,"reference_id" => $id));$this->db->update();}
            if($this->request('designation') != $borrower_reference['designation']){$this->db->table("borrower_updates");$this->db->updateArray(array(
                "referencesDesignation" => '1',
            ));$this->db->whereArray(array("borrower_id" => $bid,"reference_id" => $id));$this->db->update();}
            if($this->request('nric_new') != $borrower_reference['nric_new']){$this->db->table("borrower_updates");$this->db->updateArray(array(
                "referencesNric_new" => '1',
            ));$this->db->whereArray(array("borrower_id" => $bid,"reference_id" => $id));$this->db->update();}
            if($this->request('nric_old') != $borrower_reference['nric_old']){$this->db->table("borrower_updates");$this->db->updateArray(array(
                "referencesNric_old" => '1',
            ));$this->db->whereArray(array("borrower_id" => $bid,"reference_id" => $id));$this->db->update();}
            if($this->request('staff_id') != $borrower_reference['staff_id']){$this->db->table("borrower_updates");$this->db->updateArray(array(
                "referencesStaff_id" => '1',
            ));$this->db->whereArray(array("borrower_id" => $bid,"reference_id" => $id));$this->db->update();}
            if($this->request('hired_on') != $borrower_reference['hired_on']){$this->db->table("borrower_updates");$this->db->updateArray(array(
                "referencesHired_on" => '1',
            ));$this->db->whereArray(array("borrower_id" => $bid,"reference_id" => $id));$this->db->update();}
            if($this->request('department') != $borrower_reference['department']){$this->db->table("borrower_updates");$this->db->updateArray(array(
                "referencesDepartment" => '1',
            ));$this->db->whereArray(array("borrower_id" => $bid,"reference_id" => $id));$this->db->update();}
            if($this->request('residence_address') != $borrower_reference['residence_address']){$this->db->table("borrower_updates");$this->db->updateArray(array(
                "referencesResidence_address" => '1',
            ));$this->db->whereArray(array("borrower_id" => $bid,"reference_id" => $id));$this->db->update();}
            if($this->request('employer_address') != $borrower_reference['employer_address']){$this->db->table("borrower_updates");$this->db->updateArray(array(
                "referencesEmployer_address" => '1',
            ));$this->db->whereArray(array("borrower_id" => $bid,"reference_id" => $id));$this->db->update();}
            if($this->request('other_address') != $borrower_reference['other_address']){$this->db->table("borrower_updates");$this->db->updateArray(array(
                "referencesOther_address" => '1',
            ));$this->db->whereArray(array("borrower_id" => $bid,"reference_id" => $id));$this->db->update();}
            if($this->request('work_location') != $borrower_reference['work_location']){$this->db->table("borrower_updates");$this->db->updateArray(array(
                "referencesWork_location" => '1',
            ));$this->db->whereArray(array("borrower_id" => $bid,"reference_id" => $id));$this->db->update();}
            if($this->request('marital') != $borrower_reference['marital']){$this->db->table("borrower_updates");$this->db->updateArray(array(
                "referencesMarital" => '1',
            ));$this->db->whereArray(array("borrower_id" => $bid,"reference_id" => $id));$this->db->update();}
            if($this->request('phone') != $borrower_reference['phone']){$this->db->table("borrower_updates");$this->db->updateArray(array(
                "referencesPhone" => '1',
            ));$this->db->whereArray(array("borrower_id" => $bid,"reference_id" => $id));$this->db->update();}
            if($this->request('fax') != $borrower_reference['fax']){$this->db->table("borrower_updates");$this->db->updateArray(array(
                "referencesFax" => '1',
            ));$this->db->whereArray(array("borrower_id" => $bid,"reference_id" => $id));$this->db->update();}
            if($this->request('mobile1') != $borrower_reference['mobile1']){$this->db->table("borrower_updates");$this->db->updateArray(array(
                "referencesMobile1" => '1',
            ));$this->db->whereArray(array("borrower_id" => $bid,"reference_id" => $id));$this->db->update();}
            if($this->request('mobile2') != $borrower_reference['mobile2']){$this->db->table("borrower_updates");$this->db->updateArray(array(
                "referencesMobile2" => '1',
            ));$this->db->whereArray(array("borrower_id" => $bid,"reference_id" => $id));$this->db->update();}
        }

		return json($return);
	}

	public function borrowerReferenceDelete($bid, $id){
		$this->db->table("borrower_references");
		$this->db->whereArray(array(
			"borrower_id" => $bid,
			"reference_id" => $id
		));
		$this->db->delete();

        $this->db->table("borrower_updates");
        $this->db->whereArray(array(
            "borrower_id" => $bid,
            "reference_id" => $id
        ));
        $this->db->delete();

		$return['error'] = false;
		$return['msg'] = "Borrower Reference Deleted.";
		return json($return);
	}

	public function borrowerRemarkInsert($bid){
		$date = new DateTime();
		$reference_id = md5(uniqid(rand(), true));

		$this->db->table("borrower_remarks");
		$this->db->insertArray(array(
			"borrower_id" => $bid,
			"case_id" => $this->request("case_id"),
			"remarks" => $this->request("remarks"),
			"created" => $date->format('Y-m-d H:i:s')
		));
		$this->db->insert();

		$return['error'] = false;
		$return['msg'] = "Borrower Remark Inserted.";
		$return['url'] = option('base_uri').'/borrowers/'.$bid.'#remarks';

		return json($return);
	}

	// public function borrowerRemarkUpdate($bid){
	// 	$this->db->table("borrower_remarks");
	// 	$this->db->updateArray(array(
	// 		"case_id" => $this->request("case_id"),
	// 		"remarks" => $this->request("remarks"),
	// 	));
	// 	$this->db->whereArray(array(
	// 		"borrower_id" => $bid,
	// 	));
	// 	$this->db->update();
	// 	$return['error'] = false;
	// 	$return['msg'] = "Borrower Remark Updated.";
	// 	return json($return);
	// }

	// public function borrowerRemarkDelete($bid, $id){
	// 	$this->db->table("borrower_remarks");
	// 	$this->db->whereArray(array(
	// 		"borrower_id" => $bid
	// 	));
	// 	$this->db->delete();
	// 	$return['error'] = false;
	// 	$return['msg'] = "Borrower Remark Deleted.";
	// 	return json($return);
	// }


	// Borrower Update

	public function borrowerUpdate($bid){

        $this->db->query("SELECT * FROM borrowers WHERE borrower_id = ".$this->db->escape($bid)."");
        $borrower = $this->db->getSingleRow();

        $this->db->query("SELECT * FROM loan WHERE borrower_id = ".$this->db->escape($bid)."");
        $loan = $this->db->getSingleRow();

        //return error if not select recovery officer
        if($this->request('officerID') == '-'){
            $return['error'] = true;
            $return['msg'] = "Recovery Officer is required.";
        }
		else{
            $this->db->table("borrowers");
            $this->db->updateArray(array(
                "race" => $this->request('race'),
                "owner" => $this->request('owner'),
                "full_name" => $this->request('full_name'),
                "agent_id" => $this->request('officerID'),
                "gender" => $this->request('gender'),
                "dob" => $this->request('dob'),
                "nationality" => $this->request('nationality'),
                "nric_new" => $this->request('nric_new'),
                "nric_old" => $this->request('nric_old'),
                "resident_address" => $this->request('resident_address'),
                "nric_address" => $this->request('nric_address'),
                "resident_address2" => $this->request('resident_address2'),
                "mobile1" => $this->request('mobile1'),
                "mobile2" => $this->request('mobile2'),
                "employment_details" => $this->request('employment_details'),
                "remarks" => $this->request('remarks'),
                "marital" => $this->request('marital'),
                "borrower_status" => $this->request('status'),
                "spouse_details" => $this->request('spouse_details'),
                "wanted_remarks" => $this->request('wanted_remarks'),
                "rejection" => $this->request('rejection'),
                "borrower_remarks" => $this->request('borrower_remarks')
            ));
            $this->db->whereArray(array(
                "borrower_id" => $bid,
            ));
            $this->db->update();
            if(!empty($borrower['agent_id'])){
                
                $this->db->table("installment");
                $this->db->updateArray(array(
                    "admin_id" => $borrower['agent_id'],
                    // "officer_id" => $check_status[0]['agent_id'],
                ));
                $this->db->whereArray(array(
                    "borrower_id" => $bid,
                ));
                $this->db->update();
                $this->db->table("recovery");
                $this->db->updateArray(array(
                    "admin_id" => $borrower['agent_id'],
                    // "officer_id" => $check_status[0]['agent_id'],
                ));
                $this->db->whereArray(array(
                    "borrower_id" => $bid,
                ));
                $this->db->update();
            }

            //erase previous borrower rejection reason if select other than "rejected" status
            if($this->request('status') != '3'){
                $this->db->table("borrowers");
                $this->db->updateArray(array(
                    "rejection" => '',
                ));
                $this->db->whereArray(array(
                    "borrower_id" => $bid,
                ));
                $this->db->update();
            }

            //condition if the data has been updated and if select "rejected" status
            if(($borrower['borrower_status'] == '3' || $borrower['borrower_status'] == '2') && $borrower['new'] != '1' && ($this->request('status') != '1' || $this->request('status') != '2')){
                $this->db->table("borrowers");
                $this->db->updateArray(array(
                    "pending_approval" => '0',
                ));
                $this->db->whereArray(array(
                    "borrower_id" => $bid,
                ));
                $this->db->update();

                //insert updated status into borrower_updates if the data has been edited or is not the same as previous, 1(the label highlight becomes red)
                if($this->request('race') != $borrower['race']){$this->db->table("borrower_updates");$this->db->updateArray(array(
                    "race" => '1',
                    ));$this->db->whereArray(array("borrower_id" => $bid,));$this->db->update();}
                if($this->request('owner') != $borrower['owner']){$this->db->table("borrower_updates");$this->db->updateArray(array(
                    "owner" => '1',
                ));$this->db->whereArray(array("borrower_id" => $bid,));$this->db->update();}
                if($this->request('full_name') != $borrower['full_name']){$this->db->table("borrower_updates");$this->db->updateArray(array(
                    "full_name" => '1',
                ));$this->db->whereArray(array("borrower_id" => $bid,));$this->db->update();}
                if($this->request('officerID') != $borrower['agent_id']){$this->db->table("borrower_updates");$this->db->updateArray(array(
                    "agent_id" => '1',
                ));$this->db->whereArray(array("borrower_id" => $bid,));$this->db->update();}
                if($this->request('gender') != $borrower['gender']){$this->db->table("borrower_updates");$this->db->updateArray(array(
                    "gender" => '1',
                ));$this->db->whereArray(array("borrower_id" => $bid,));$this->db->update();}
                if($this->request('dob') != $borrower['dob']){$this->db->table("borrower_updates");$this->db->updateArray(array(
                    "dob" => '1',
                ));$this->db->whereArray(array("borrower_id" => $bid,));$this->db->update();}
                if($this->request('nationality') != $borrower['nationality']){$this->db->table("borrower_updates");$this->db->updateArray(array(
                    "nationality" => '1',
                ));$this->db->whereArray(array("borrower_id" => $bid,));$this->db->update();}
                if($this->request('nric_new') != $borrower['nric_new']){$this->db->table("borrower_updates");$this->db->updateArray(array(
                    "nric_new" => '1',
                ));$this->db->whereArray(array("borrower_id" => $bid,));$this->db->update();}
                if($this->request('nric_old') != $borrower['nric_old']){$this->db->table("borrower_updates");$this->db->updateArray(array(
                    "nric_old" => '1',
                ));$this->db->whereArray(array("borrower_id" => $bid,));$this->db->update();}
                if($this->request('resident_address') != $borrower['resident_address']){$this->db->table("borrower_updates");$this->db->updateArray(array(
                    "resident_address" => '1',
                ));$this->db->whereArray(array("borrower_id" => $bid,));$this->db->update();}
                if($this->request('nric_address') != $borrower['nric_address']){$this->db->table("borrower_updates");$this->db->updateArray(array(
                    "nric_address" => '1',
                ));$this->db->whereArray(array("borrower_id" => $bid,));$this->db->update();}
                if($this->request('resident_address2') != $borrower['resident_address2']){$this->db->table("borrower_updates");$this->db->updateArray(array(
                    "resident_address2" => '1',
                ));$this->db->whereArray(array("borrower_id" => $bid,));$this->db->update();}
                if($this->request('mobile1') != $borrower['mobile1']){$this->db->table("borrower_updates");$this->db->updateArray(array(
                    "mobile1" => '1',
                ));$this->db->whereArray(array("borrower_id" => $bid,));$this->db->update();}
                if($this->request('mobile2') != $borrower['mobile2']){$this->db->table("borrower_updates");$this->db->updateArray(array(
                    "mobile2" => '1',
                ));$this->db->whereArray(array("borrower_id" => $bid,));$this->db->update();}
                if($this->request('employment_details') != $borrower['employment_details']){$this->db->table("borrower_updates");$this->db->updateArray(array(
                    "employment_details" => '1',
                ));$this->db->whereArray(array("borrower_id" => $bid,));$this->db->update();}
                if($this->request('remarks') != $borrower['remarks']){$this->db->table("borrower_updates");$this->db->updateArray(array(
                    "remarks" => '1',
                ));$this->db->whereArray(array("borrower_id" => $bid,));$this->db->update();}
                if($this->request('marital') != $borrower['marital']){$this->db->table("borrower_updates");$this->db->updateArray(array(
                    "marital" => '1',
                ));$this->db->whereArray(array("borrower_id" => $bid,));$this->db->update();}
                if($this->request('spouse_details') != $borrower['spouse_details']){$this->db->table("borrower_updates");$this->db->updateArray(array(
                    "spouse_details" => '1',
                ));$this->db->whereArray(array("borrower_id" => $bid,));$this->db->update();}
                if($this->request('wanted_remarks') != $borrower['wanted_remarks']){$this->db->table("borrower_updates");$this->db->updateArray(array(
                    "wanted_remarks" => '1',
                ));$this->db->whereArray(array("borrower_id" => $bid,));$this->db->update();}
                if($this->request('borrower_remarks') != $borrower['borrower_remarks']){$this->db->table("borrower_updates");$this->db->updateArray(array(
                    "borrower_remarks" => '1',
                ));$this->db->whereArray(array("borrower_id" => $bid,));$this->db->update();}
            }

            //condition if rejected for the second time
            if($this->request('status') == '3' && $borrower['pending_approval'] == '2'){
                $this->db->table("borrowers");
                $this->db->updateArray(array(
                    "pending_approval" => '1',
                ));
                $this->db->whereArray(array(
                    "borrower_id" => $bid,
                ));
                $this->db->update();

                //update the updated status in borrower_updates to 0(the label highlight back to normal)
                $this->db->table("borrower_updates");
                $this->db->updateArray(array(
                    "label_contacts" => '0',"label_employments" => '0',"label_spouse" => '0',"label_spouse_employments" => '0',"label_guarantor" => '0',"label_references" => '0',"label_remarks" => '0',"race" => '0',"owner" => '0',"full_name" => '0',"agent_id" => '0',"gender" => '0',"dob" => '0',"nationality" => '0',"nric_new" => '0',"nric_old" => '0',"resident_address" => '0',"nric_address" => '0',"resident_address2" => '0',"mobile1" => '0',"mobile2" => '0',"employment_details" => '0',"remarks" => '0',"marital" => '0',"spouse_details" => '0',"wanted_remarks" => '0',"borrower_remarks" => '0',"contactAddress" => '0',"contactMobile_number" => '0',"employmentEmployer_name" => '0',"employmentDesignation" => '0',"employmentSalary_range" => '0',"employmentPay_date" => '0',"employmentAdvance_date" => '0',"employmentStaff_id" => '0',"employmentHired_on" => '0',"employmentDepartment" => '0',"employmentAddress" => '0',"employmentWork_location" => '0',"employmentPhone" => '0',"employmentFax" => '0',"spousedetailsFull_name" => '0',"spousedetailsGender" => '0',"spousedetailsDob" => '0',"spousedetailsNationality" => '0',"spousedetailsNric_new" => '0',"spousedetailsNric_old" => '0',"spousedetailsResident_address" => '0',"spousedetailsNric_address" => '0',"spousedetailsResident_address2" => '0',"spousedetailsRemarks" => '0',"spousedetailsMarital" => '0',"spousedetailsRace" => '0',"spouseMobile1" => '0',"spouseMobile2" => '0',"spousecontactsMobile" => '0',"spouseemploymentsEmployer_name" => '0',"spouseemploymentsDesignation" => '0',"spouseemploymentsSalary_range" => '0',"spouseemploymentsPay_date" => '0',"spouseemploymentsAdvance_date" => '0',"spouseemploymentsStaff_id" => '0',"spouseemploymentsHired_on" => '0',"spouseemploymentsDepartment" => '0',"spouseemploymentsAddress" => '0',"spouseemploymentsWork_location" => '0',"spouseemploymentsPhone" => '0',"spouseemploymentsFax" => '0',"guarantorsFull_name" => '0',"guarantorsNric_new" => '0',"guarantorsNric_old" => '0',"guarantorsRelation" => '0',"guarantorsResidence_address" => '0',"guarantorsOther_address" => '0',"guarantorsMobile1" => '0',"guarantorsMobile2" => '0',"guarantorsEmployer_name" => '0',"guarantorsDesignation" => '0',"guarantorsStaff_id" => '0',"guarantorsHired_on" => '0',"guarantorsDepartment" => '0',"guarantorsEmployer_address" => '0',"guarantorsWork_location" => '0',"guarantorsPhone" => '0',"guarantorsMarital" => '0',"guarantorsFax" => '0',"referencesFull_name" => '0',"referencesEmployer_name" => '0',"referencesRelation" => '0',"referencesDesignation" => '0',"referencesNric_new" => '0',"referencesNric_old" => '0',"referencesStaff_id" => '0',"referencesHired_on" => '0',"referencesDepartment" => '0',"referencesResidence_address" => '0',"referencesEmployer_address" => '0',"referencesOther_address" => '0',"referencesWork_location" => '0',"referencesMarital" => '0',"referencesPhone" => '0',"referencesFax" => '0',"referencesMobile1" => '0',"referencesMobile2" => '0',"remarksRemarks" => '0'
                ));
                $this->db->whereArray(array(
                    "borrower_id" => $bid,
                ));
                $this->db->update();
            }
            //condition if rejected for the first time
            else if($this->request('status') == '3'){
                $this->db->table("borrowers");
                $this->db->updateArray(array(
                    "pending_approval" => '1',
                    "new" => '0',
                ));
                $this->db->whereArray(array(
                    "borrower_id" => $bid,
                ));
                $this->db->update();

                //update the updated status in borrower_updates to 0(the label highlight back to normal)
                $this->db->table("borrower_updates");
                $this->db->updateArray(array(
                    "label_contacts" => '0',"label_employments" => '0',"label_spouse" => '0',"label_spouse_employments" => '0',"label_guarantor" => '0',"label_references" => '0',"label_remarks" => '0',"race" => '0',"owner" => '0',"full_name" => '0',"agent_id" => '0',"gender" => '0',"dob" => '0',"nationality" => '0',"nric_new" => '0',"nric_old" => '0',"resident_address" => '0',"nric_address" => '0',"resident_address2" => '0',"mobile1" => '0',"mobile2" => '0',"employment_details" => '0',"remarks" => '0',"marital" => '0',"spouse_details" => '0',"wanted_remarks" => '0',"borrower_remarks" => '0',"contactAddress" => '0',"contactMobile_number" => '0',"employmentEmployer_name" => '0',"employmentDesignation" => '0',"employmentSalary_range" => '0',"employmentPay_date" => '0',"employmentAdvance_date" => '0',"employmentStaff_id" => '0',"employmentHired_on" => '0',"employmentDepartment" => '0',"employmentAddress" => '0',"employmentWork_location" => '0',"employmentPhone" => '0',"employmentFax" => '0',"spousedetailsFull_name" => '0',"spousedetailsGender" => '0',"spousedetailsDob" => '0',"spousedetailsNationality" => '0',"spousedetailsNric_new" => '0',"spousedetailsNric_old" => '0',"spousedetailsResident_address" => '0',"spousedetailsNric_address" => '0',"spousedetailsResident_address2" => '0',"spousedetailsRemarks" => '0',"spousedetailsMarital" => '0',"spousedetailsRace" => '0',"spouseMobile1" => '0',"spouseMobile2" => '0',"spousecontactsMobile" => '0',"spouseemploymentsEmployer_name" => '0',"spouseemploymentsDesignation" => '0',"spouseemploymentsSalary_range" => '0',"spouseemploymentsPay_date" => '0',"spouseemploymentsAdvance_date" => '0',"spouseemploymentsStaff_id" => '0',"spouseemploymentsHired_on" => '0',"spouseemploymentsDepartment" => '0',"spouseemploymentsAddress" => '0',"spouseemploymentsWork_location" => '0',"spouseemploymentsPhone" => '0',"spouseemploymentsFax" => '0',"guarantorsFull_name" => '0',"guarantorsNric_new" => '0',"guarantorsNric_old" => '0',"guarantorsRelation" => '0',"guarantorsResidence_address" => '0',"guarantorsOther_address" => '0',"guarantorsMobile1" => '0',"guarantorsMobile2" => '0',"guarantorsEmployer_name" => '0',"guarantorsDesignation" => '0',"guarantorsStaff_id" => '0',"guarantorsHired_on" => '0',"guarantorsDepartment" => '0',"guarantorsEmployer_address" => '0',"guarantorsWork_location" => '0',"guarantorsPhone" => '0',"guarantorsMarital" => '0',"guarantorsFax" => '0',"referencesFull_name" => '0',"referencesEmployer_name" => '0',"referencesRelation" => '0',"referencesDesignation" => '0',"referencesNric_new" => '0',"referencesNric_old" => '0',"referencesStaff_id" => '0',"referencesHired_on" => '0',"referencesDepartment" => '0',"referencesResidence_address" => '0',"referencesEmployer_address" => '0',"referencesOther_address" => '0',"referencesWork_location" => '0',"referencesMarital" => '0',"referencesPhone" => '0',"referencesFax" => '0',"referencesMobile1" => '0',"referencesMobile2" => '0',"remarksRemarks" => '0'
                ));
                $this->db->whereArray(array(
                    "borrower_id" => $bid,
                ));
                $this->db->update();
            }
            //condition if approved after rejected
            else if($this->request('status') == '1' && $borrower['pending_approval'] == '2'){
                $this->db->table("borrowers");
                $this->db->updateArray(array(
                    "pending_approval" => '0',
                ));
                $this->db->whereArray(array(
                    "borrower_id" => $bid,
                ));
                $this->db->update();

                //update the updated status in borrower_updates to 0(the label highlight back to normal)
                $this->db->table("borrower_updates");
                $this->db->updateArray(array(
                    "label_contacts" => '0',"label_employments" => '0',"label_spouse" => '0',"label_spouse_employments" => '0',"label_guarantor" => '0',"label_references" => '0',"label_remarks" => '0',"race" => '0',"owner" => '0',"full_name" => '0',"agent_id" => '0',"gender" => '0',"dob" => '0',"nationality" => '0',"nric_new" => '0',"nric_old" => '0',"resident_address" => '0',"nric_address" => '0',"resident_address2" => '0',"mobile1" => '0',"mobile2" => '0',"employment_details" => '0',"remarks" => '0',"marital" => '0',"spouse_details" => '0',"wanted_remarks" => '0',"borrower_remarks" => '0',"contactAddress" => '0',"contactMobile_number" => '0',"employmentEmployer_name" => '0',"employmentDesignation" => '0',"employmentSalary_range" => '0',"employmentPay_date" => '0',"employmentAdvance_date" => '0',"employmentStaff_id" => '0',"employmentHired_on" => '0',"employmentDepartment" => '0',"employmentAddress" => '0',"employmentWork_location" => '0',"employmentPhone" => '0',"employmentFax" => '0',"spousedetailsFull_name" => '0',"spousedetailsGender" => '0',"spousedetailsDob" => '0',"spousedetailsNationality" => '0',"spousedetailsNric_new" => '0',"spousedetailsNric_old" => '0',"spousedetailsResident_address" => '0',"spousedetailsNric_address" => '0',"spousedetailsResident_address2" => '0',"spousedetailsRemarks" => '0',"spousedetailsMarital" => '0',"spousedetailsRace" => '0',"spouseMobile1" => '0',"spouseMobile2" => '0',"spousecontactsMobile" => '0',"spouseemploymentsEmployer_name" => '0',"spouseemploymentsDesignation" => '0',"spouseemploymentsSalary_range" => '0',"spouseemploymentsPay_date" => '0',"spouseemploymentsAdvance_date" => '0',"spouseemploymentsStaff_id" => '0',"spouseemploymentsHired_on" => '0',"spouseemploymentsDepartment" => '0',"spouseemploymentsAddress" => '0',"spouseemploymentsWork_location" => '0',"spouseemploymentsPhone" => '0',"spouseemploymentsFax" => '0',"guarantorsFull_name" => '0',"guarantorsNric_new" => '0',"guarantorsNric_old" => '0',"guarantorsRelation" => '0',"guarantorsResidence_address" => '0',"guarantorsOther_address" => '0',"guarantorsMobile1" => '0',"guarantorsMobile2" => '0',"guarantorsEmployer_name" => '0',"guarantorsDesignation" => '0',"guarantorsStaff_id" => '0',"guarantorsHired_on" => '0',"guarantorsDepartment" => '0',"guarantorsEmployer_address" => '0',"guarantorsWork_location" => '0',"guarantorsPhone" => '0',"guarantorsMarital" => '0',"guarantorsFax" => '0',"referencesFull_name" => '0',"referencesEmployer_name" => '0',"referencesRelation" => '0',"referencesDesignation" => '0',"referencesNric_new" => '0',"referencesNric_old" => '0',"referencesStaff_id" => '0',"referencesHired_on" => '0',"referencesDepartment" => '0',"referencesResidence_address" => '0',"referencesEmployer_address" => '0',"referencesOther_address" => '0',"referencesWork_location" => '0',"referencesMarital" => '0',"referencesPhone" => '0',"referencesFax" => '0',"referencesMobile1" => '0',"referencesMobile2" => '0',"remarksRemarks" => '0'
                ));
                $this->db->whereArray(array(
                    "borrower_id" => $bid,
                ));
                $this->db->update();
            }
            //condition if the borrower is approved without getting rejected
            else if($this->request('status') == '1'){
                $this->db->table("borrowers");
                $this->db->updateArray(array(
                    "pending_approval" => '0',
                    "new" => '0',
                ));
                $this->db->whereArray(array(
                    "borrower_id" => $bid,
                ));
                $this->db->update();

                //update the updated status in borrower_updates to 0(the label highlight back to normal)
                $this->db->table("borrower_updates");
                $this->db->updateArray(array(
                    "label_contacts" => '0',"label_employments" => '0',"label_spouse" => '0',"label_spouse_employments" => '0',"label_guarantor" => '0',"label_references" => '0',"label_remarks" => '0',"race" => '0',"owner" => '0',"full_name" => '0',"agent_id" => '0',"gender" => '0',"dob" => '0',"nationality" => '0',"nric_new" => '0',"nric_old" => '0',"resident_address" => '0',"nric_address" => '0',"resident_address2" => '0',"mobile1" => '0',"mobile2" => '0',"employment_details" => '0',"remarks" => '0',"marital" => '0',"spouse_details" => '0',"wanted_remarks" => '0',"borrower_remarks" => '0',"contactAddress" => '0',"contactMobile_number" => '0',"employmentEmployer_name" => '0',"employmentDesignation" => '0',"employmentSalary_range" => '0',"employmentPay_date" => '0',"employmentAdvance_date" => '0',"employmentStaff_id" => '0',"employmentHired_on" => '0',"employmentDepartment" => '0',"employmentAddress" => '0',"employmentWork_location" => '0',"employmentPhone" => '0',"employmentFax" => '0',"spousedetailsFull_name" => '0',"spousedetailsGender" => '0',"spousedetailsDob" => '0',"spousedetailsNationality" => '0',"spousedetailsNric_new" => '0',"spousedetailsNric_old" => '0',"spousedetailsResident_address" => '0',"spousedetailsNric_address" => '0',"spousedetailsResident_address2" => '0',"spousedetailsRemarks" => '0',"spousedetailsMarital" => '0',"spousedetailsRace" => '0',"spouseMobile1" => '0',"spouseMobile2" => '0',"spousecontactsMobile" => '0',"spouseemploymentsEmployer_name" => '0',"spouseemploymentsDesignation" => '0',"spouseemploymentsSalary_range" => '0',"spouseemploymentsPay_date" => '0',"spouseemploymentsAdvance_date" => '0',"spouseemploymentsStaff_id" => '0',"spouseemploymentsHired_on" => '0',"spouseemploymentsDepartment" => '0',"spouseemploymentsAddress" => '0',"spouseemploymentsWork_location" => '0',"spouseemploymentsPhone" => '0',"spouseemploymentsFax" => '0',"guarantorsFull_name" => '0',"guarantorsNric_new" => '0',"guarantorsNric_old" => '0',"guarantorsRelation" => '0',"guarantorsResidence_address" => '0',"guarantorsOther_address" => '0',"guarantorsMobile1" => '0',"guarantorsMobile2" => '0',"guarantorsEmployer_name" => '0',"guarantorsDesignation" => '0',"guarantorsStaff_id" => '0',"guarantorsHired_on" => '0',"guarantorsDepartment" => '0',"guarantorsEmployer_address" => '0',"guarantorsWork_location" => '0',"guarantorsPhone" => '0',"guarantorsMarital" => '0',"guarantorsFax" => '0',"referencesFull_name" => '0',"referencesEmployer_name" => '0',"referencesRelation" => '0',"referencesDesignation" => '0',"referencesNric_new" => '0',"referencesNric_old" => '0',"referencesStaff_id" => '0',"referencesHired_on" => '0',"referencesDepartment" => '0',"referencesResidence_address" => '0',"referencesEmployer_address" => '0',"referencesOther_address" => '0',"referencesWork_location" => '0',"referencesMarital" => '0',"referencesPhone" => '0',"referencesFax" => '0',"referencesMobile1" => '0',"referencesMobile2" => '0',"remarksRemarks" => '0'
                ));
                $this->db->whereArray(array(
                    "borrower_id" => $bid,
                ));
                $this->db->update();
            }
            //condition if rejected for the first time and select the "pending approval" status
            else if($this->request('status') == '2'
                && $borrower['pending_approval'] == '1'
                || $borrower['pending_approval'] == '2'){
                $this->db->table("borrowers");
                $this->db->updateArray(array(
                    "pending_approval" => '2',
                    "rejection" => '',
                ));
                $this->db->whereArray(array(
                    "borrower_id" => $bid,
                ));
                $this->db->update();
            }
            //if not related to rejection, change the pending approval status to normal
            else {
                $this->db->table("borrowers");
                $this->db->updateArray(array(
                    "pending_approval" => '0',
                ));
                $this->db->whereArray(array(
                    "borrower_id" => $bid,
                ));
                $this->db->update();
            }

            //if the data has been edited while the borrower status is "approved", the borrower status changed to pending
            if($borrower['pending_approval'] == '0'
                && $borrower['new'] != '1'
                && $this->request('status') == $borrower['borrower_status']
                && ($this->request('race') != $borrower['race']
                    || $this->request('owner') != $borrower['owner']
                    || $this->request('full_name') != $borrower['full_name']
                    || $this->request('officerID') != $borrower['agent_id']
                    || $this->request('gender') != $borrower['gender']
                    || $this->request('dob') != $borrower['dob']
                    || $this->request('nationality') != $borrower['nationality']
                    || $this->request('nric_new') != $borrower['nric_new']
                    || $this->request('nric_old') != $borrower['nric_old']
                    || $this->request('resident_address') != $borrower['resident_address']
                    || $this->request('nric_address') != $borrower['nric_address']
                    || $this->request('resident_address2') != $borrower['resident_address2']
                    || $this->request('mobile1') != $borrower['mobile1']
                    || $this->request('mobile2') != $borrower['mobile2']
                    || $this->request('employment_details') != $borrower['employment_details']
                    || $this->request('remarks') != $borrower['remarks']
                    || $this->request('marital') != $borrower['marital']
                    || $this->request('spouse_details') != $borrower['spouse_details']
                    || $this->request('wanted_remarks') != $borrower['wanted_remarks']
                    || $this->request('borrower_remarks') != $borrower['borrower_remarks'])){
                $this->db->table("borrowers");
                $this->db->updateArray(array(
                    "borrower_status" => '2',
                    "rejection" => '',
                    "pending_approval" => '0'
                ));
                $this->db->whereArray(array(
                    "borrower_id" => $bid,
                ));
                $this->db->update();

                //insert updated status into borrower_updates if the data has been edited or is not the same as previous, 1(the label highlight becomes red)
                if($this->request('race') != $borrower['race']){$this->db->table("borrower_updates");$this->db->updateArray(array(
                    "race" => '1',
                ));$this->db->whereArray(array("borrower_id" => $bid,));$this->db->update();}
                if($this->request('owner') != $borrower['owner']){$this->db->table("borrower_updates");$this->db->updateArray(array(
                    "owner" => '1',
                ));$this->db->whereArray(array("borrower_id" => $bid,));$this->db->update();}
                if($this->request('full_name') != $borrower['full_name']){$this->db->table("borrower_updates");$this->db->updateArray(array(
                    "full_name" => '1',
                ));$this->db->whereArray(array("borrower_id" => $bid,));$this->db->update();}
                if($this->request('officerID') != $borrower['agent_id']){$this->db->table("borrower_updates");$this->db->updateArray(array(
                    "agent_id" => '1',
                ));$this->db->whereArray(array("borrower_id" => $bid,));$this->db->update();}
                if($this->request('gender') != $borrower['gender']){$this->db->table("borrower_updates");$this->db->updateArray(array(
                    "gender" => '1',
                ));$this->db->whereArray(array("borrower_id" => $bid,));$this->db->update();}
                if($this->request('dob') != $borrower['dob']){$this->db->table("borrower_updates");$this->db->updateArray(array(
                    "dob" => '1',
                ));$this->db->whereArray(array("borrower_id" => $bid,));$this->db->update();}
                if($this->request('nationality') != $borrower['nationality']){$this->db->table("borrower_updates");$this->db->updateArray(array(
                    "nationality" => '1',
                ));$this->db->whereArray(array("borrower_id" => $bid,));$this->db->update();}
                if($this->request('nric_new') != $borrower['nric_new']){$this->db->table("borrower_updates");$this->db->updateArray(array(
                    "nric_new" => '1',
                ));$this->db->whereArray(array("borrower_id" => $bid,));$this->db->update();}
                if($this->request('nric_old') != $borrower['nric_old']){$this->db->table("borrower_updates");$this->db->updateArray(array(
                    "nric_old" => '1',
                ));$this->db->whereArray(array("borrower_id" => $bid,));$this->db->update();}
                if($this->request('resident_address') != $borrower['resident_address']){$this->db->table("borrower_updates");$this->db->updateArray(array(
                    "resident_address" => '1',
                ));$this->db->whereArray(array("borrower_id" => $bid,));$this->db->update();}
                if($this->request('nric_address') != $borrower['nric_address']){$this->db->table("borrower_updates");$this->db->updateArray(array(
                    "nric_address" => '1',
                ));$this->db->whereArray(array("borrower_id" => $bid,));$this->db->update();}
                if($this->request('resident_address2') != $borrower['resident_address2']){$this->db->table("borrower_updates");$this->db->updateArray(array(
                    "resident_address2" => '1',
                ));$this->db->whereArray(array("borrower_id" => $bid,));$this->db->update();}
                if($this->request('mobile1') != $borrower['mobile1']){$this->db->table("borrower_updates");$this->db->updateArray(array(
                    "mobile1" => '1',
                ));$this->db->whereArray(array("borrower_id" => $bid,));$this->db->update();}
                if($this->request('mobile2') != $borrower['mobile2']){$this->db->table("borrower_updates");$this->db->updateArray(array(
                    "mobile2" => '1',
                ));$this->db->whereArray(array("borrower_id" => $bid,));$this->db->update();}
                if($this->request('employment_details') != $borrower['employment_details']){$this->db->table("borrower_updates");$this->db->updateArray(array(
                    "employment_details" => '1',
                ));$this->db->whereArray(array("borrower_id" => $bid,));$this->db->update();}
                if($this->request('remarks') != $borrower['remarks']){$this->db->table("borrower_updates");$this->db->updateArray(array(
                    "remarks" => '1',
                ));$this->db->whereArray(array("borrower_id" => $bid,));$this->db->update();}
                if($this->request('marital') != $borrower['marital']){$this->db->table("borrower_updates");$this->db->updateArray(array(
                    "marital" => '1',
                ));$this->db->whereArray(array("borrower_id" => $bid,));$this->db->update();}
                if($this->request('spouse_details') != $borrower['spouse_details']){$this->db->table("borrower_updates");$this->db->updateArray(array(
                    "spouse_details" => '1',
                ));$this->db->whereArray(array("borrower_id" => $bid,));$this->db->update();}
                if($this->request('wanted_remarks') != $borrower['wanted_remarks']){$this->db->table("borrower_updates");$this->db->updateArray(array(
                    "wanted_remarks" => '1',
                ));$this->db->whereArray(array("borrower_id" => $bid,));$this->db->update();}
                if($this->request('borrower_remarks') != $borrower['borrower_remarks']){$this->db->table("borrower_updates");$this->db->updateArray(array(
                    "borrower_remarks" => '1',
                ));$this->db->whereArray(array("borrower_id" => $bid,));$this->db->update();}
            }
            //if the data has been edited while the borrower status is "rejected", the borrower status changed to pending
            else if(($borrower['pending_approval'] == '1'
                    || $borrower['pending_approval'] == '2')
                && $borrower['new'] != '1'
                && $this->request('status') == $borrower['borrower_status']
                && ($this->request('race') != $borrower['race']
                    || $this->request('owner') != $borrower['owner']
                    || $this->request('full_name') != $borrower['full_name']
                    || $this->request('officerID') != $borrower['agent_id']
                    || $this->request('gender') != $borrower['gender']
                    || $this->request('dob') != $borrower['dob']
                    || $this->request('nationality') != $borrower['nationality']
                    || $this->request('nric_new') != $borrower['nric_new']
                    || $this->request('nric_old') != $borrower['nric_old']
                    || $this->request('resident_address') != $borrower['resident_address']
                    || $this->request('nric_address') != $borrower['nric_address']
                    || $this->request('resident_address2') != $borrower['resident_address2']
                    || $this->request('mobile1') != $borrower['mobile1']
                    || $this->request('mobile2') != $borrower['mobile2']
                    || $this->request('employment_details') != $borrower['employment_details']
                    || $this->request('remarks') != $borrower['remarks']
                    || $this->request('marital') != $borrower['marital']
                    || $this->request('spouse_details') != $borrower['spouse_details']
                    || $this->request('wanted_remarks') != $borrower['wanted_remarks']
                    || $this->request('borrower_remarks') != $borrower['borrower_remarks'])){
                $this->db->table("borrowers");
                $this->db->updateArray(array(
                    "borrower_status" => '2',
                    "rejection" => '',
                    "pending_approval" => '2'
                ));
                $this->db->whereArray(array(
                    "borrower_id" => $bid,
                ));
                $this->db->update();

                //insert updated status into borrower_updates if the data has been edited or is not the same as previous, 1(the label highlight becomes red)
                if($this->request('race') != $borrower['race']){$this->db->table("borrower_updates");$this->db->updateArray(array(
                    "race" => '1',
                ));$this->db->whereArray(array("borrower_id" => $bid,));$this->db->update();}
                if($this->request('owner') != $borrower['owner']){$this->db->table("borrower_updates");$this->db->updateArray(array(
                    "owner" => '1',
                ));$this->db->whereArray(array("borrower_id" => $bid,));$this->db->update();}
                if($this->request('full_name') != $borrower['full_name']){$this->db->table("borrower_updates");$this->db->updateArray(array(
                    "full_name" => '1',
                ));$this->db->whereArray(array("borrower_id" => $bid,));$this->db->update();}
                if($this->request('officerID') != $borrower['agent_id']){$this->db->table("borrower_updates");$this->db->updateArray(array(
                    "agent_id" => '1',
                ));$this->db->whereArray(array("borrower_id" => $bid,));$this->db->update();}
                if($this->request('gender') != $borrower['gender']){$this->db->table("borrower_updates");$this->db->updateArray(array(
                    "gender" => '1',
                ));$this->db->whereArray(array("borrower_id" => $bid,));$this->db->update();}
                if($this->request('dob') != $borrower['dob']){$this->db->table("borrower_updates");$this->db->updateArray(array(
                    "dob" => '1',
                ));$this->db->whereArray(array("borrower_id" => $bid,));$this->db->update();}
                if($this->request('nationality') != $borrower['nationality']){$this->db->table("borrower_updates");$this->db->updateArray(array(
                    "nationality" => '1',
                ));$this->db->whereArray(array("borrower_id" => $bid,));$this->db->update();}
                if($this->request('nric_new') != $borrower['nric_new']){$this->db->table("borrower_updates");$this->db->updateArray(array(
                    "nric_new" => '1',
                ));$this->db->whereArray(array("borrower_id" => $bid,));$this->db->update();}
                if($this->request('nric_old') != $borrower['nric_old']){$this->db->table("borrower_updates");$this->db->updateArray(array(
                    "nric_old" => '1',
                ));$this->db->whereArray(array("borrower_id" => $bid,));$this->db->update();}
                if($this->request('resident_address') != $borrower['resident_address']){$this->db->table("borrower_updates");$this->db->updateArray(array(
                    "resident_address" => '1',
                ));$this->db->whereArray(array("borrower_id" => $bid,));$this->db->update();}
                if($this->request('nric_address') != $borrower['nric_address']){$this->db->table("borrower_updates");$this->db->updateArray(array(
                    "nric_address" => '1',
                ));$this->db->whereArray(array("borrower_id" => $bid,));$this->db->update();}
                if($this->request('resident_address2') != $borrower['resident_address2']){$this->db->table("borrower_updates");$this->db->updateArray(array(
                    "resident_address2" => '1',
                ));$this->db->whereArray(array("borrower_id" => $bid,));$this->db->update();}
                if($this->request('mobile1') != $borrower['mobile1']){$this->db->table("borrower_updates");$this->db->updateArray(array(
                    "mobile1" => '1',
                ));$this->db->whereArray(array("borrower_id" => $bid,));$this->db->update();}
                if($this->request('mobile2') != $borrower['mobile2']){$this->db->table("borrower_updates");$this->db->updateArray(array(
                    "mobile2" => '1',
                ));$this->db->whereArray(array("borrower_id" => $bid,));$this->db->update();}
                if($this->request('employment_details') != $borrower['employment_details']){$this->db->table("borrower_updates");$this->db->updateArray(array(
                    "employment_details" => '1',
                ));$this->db->whereArray(array("borrower_id" => $bid,));$this->db->update();}
                if($this->request('remarks') != $borrower['remarks']){$this->db->table("borrower_updates");$this->db->updateArray(array(
                    "remarks" => '1',
                ));$this->db->whereArray(array("borrower_id" => $bid,));$this->db->update();}
                if($this->request('marital') != $borrower['marital']){$this->db->table("borrower_updates");$this->db->updateArray(array(
                    "marital" => '1',
                ));$this->db->whereArray(array("borrower_id" => $bid,));$this->db->update();}
                if($this->request('spouse_details') != $borrower['spouse_details']){$this->db->table("borrower_updates");$this->db->updateArray(array(
                    "spouse_details" => '1',
                ));$this->db->whereArray(array("borrower_id" => $bid,));$this->db->update();}
                if($this->request('wanted_remarks') != $borrower['wanted_remarks']){$this->db->table("borrower_updates");$this->db->updateArray(array(
                    "wanted_remarks" => '1',
                ));$this->db->whereArray(array("borrower_id" => $bid,));$this->db->update();}
                if($this->request('borrower_remarks') != $borrower['borrower_remarks']){$this->db->table("borrower_updates");$this->db->updateArray(array(
                    "borrower_remarks" => '1',
                ));$this->db->whereArray(array("borrower_id" => $bid,));$this->db->update();}
            }

            if(!empty($loan['loan_status'])){
                if($this->request('status') == '1' && $loan['loan_status'] == '991'){
                    $this->db->table("loan");
                    $this->db->updateArray(array(
                        "loan_status" => '2',
                        "officer_id" => $this->request('officerID')
                    ));
                    $this->db->whereArray(array(
                        "borrower_id" => $bid,
                        // "loan_id" => $loan['loan_id'],
                    ));
                    $this->db->update();
                }
            }

            $this->uploadDocument('photo_1', '', true, $bid);
            $this->uploadDocument('photo_2', 'label_photo_1', false, $bid);
            $this->uploadDocument('photo_3', 'label_photo_2', false, $bid);

            $return['error'] = false;
            $return['msg'] = "Borrower Updated.";
            $return['url'] = option('base_uri').'/borrowers/'.$bid;
        }

		return json($return);
	}

//	public function borrowerDelete($bid){
//		$this->db->table("borrowers");
//		$this->db->whereArray(array(
//			"borrower_id" => $bid
//		));
//		$this->db->delete();
//		$return['error'] = false;
//		$return['msg'] = "Borrower Deleted.";
//		return json($return);
//	}





	// public function loanUpdate($id){
	// 	$loanAmount =$this->request('loanAmount');
	// 	$terms=	$this->request('termsYears');
	// 	$interest = $this->request('interest')/100;
	// 	$installment = (($loanAmount*($interest/12))) / (1-pow((1+($interest/12)),(-1*$terms*12)));
	// 	$installment= number_format($installment,2,'.','');

	// 	if(!empty($id)){
	// 		$this->db->table("loan");
	// 			$this->db->updateArray(array(
	// 				"loan_amt" => $this->request('loanAmount'),
	// 				"loan_term" => $this->request('termsYears'),
	// 				"loan_interest" => $this->request('interest'),
	// 				"loan_installment" => $installment,
	// 				"loan_status" => $this->request('loanStatus'),

	// 			));
	// 			$this->db->whereArray(array(
	// 				"cust_id" => $id,
	// 			));
	// 			$this->db->update();


	// 			$return['error'] = false;
	// 			$return['msg'] = "Loan Details updated.";

	// 	}else{
	// 		$return['error'] = true;
	// 		$return['msg'] = "Invalid ID.";
	// 	}

	// 	return json($return);
	// }





	public function loanInsert(){

		/* loan calculation
		$loanAmount =$application['app_amount'];
		$terms=	$application['app_years'];
		$interest = $application['app_interest_return']/100;
		$installment = (($loanAmount*($interest/12))) / (1-pow((1+($interest/12)),(-1*$terms*12)));
		$installment= number_format($installment,2,'.','');
		*/

        if($this->cms->admin->mapproval == '1'){
            $this->db->table("loan");
            $this->db->insertArray(array(

                "borrower_id" => $this->request('borrowerID'),
                "recommended_by" => $this->request('recommended_by'),
                "commission" => $this->request('commission'),
                "loan_amt" => $this->request('amount'),
                "loan_date" => $this->request('loan_date'),
                "cash_by_hand" => $this->request('cash'),
                "loan_term" => $this->request('loan_term'),
                //"loan_interest_year" => $this->request('loan_interest_year'),
                "loan_interest_month" => $this->request('loan_interest_month'),
                "principal_paid" => $this->request('principal'),
                "principal_paid_date" => $this->request('principal_date'),
                "stamp_duty_fees" => $this->request('stamp'),
                "created_by" => $this->cms->admin->id,
                "loan_status" => '4',
                "date_created" => 'NOW()'
            ));
            $this->db->insert();
        }
        else{
            $this->db->table("loan");
            $this->db->insertArray(array(

                "borrower_id" => $this->request('borrowerID'),
                "recommended_by" => $this->request('recommended_by'),
                "commission" => $this->request('commission'),
                "loan_amt" => $this->request('amount'),
                "loan_date" => $this->request('loan_date'),
                "cash_by_hand" => $this->request('cash'),
                "loan_term" => $this->request('loan_term'),
                //"loan_interest_year" => $this->request('loan_interest_year'),
                "loan_interest_month" => $this->request('loan_interest_month'),
                "principal_paid" => $this->request('principal'),
                "principal_paid_date" => $this->request('principal_date'),
                "stamp_duty_fees" => $this->request('stamp'),
                "created_by" => $this->cms->admin->id,
                "loan_status" => '2',
                "date_created" => 'NOW()'
            ));
            $this->db->insert();
        }

		$return['error'] = false;
		$return['msg'] = "New Loan created.";
		$return['url'] = option('base_uri').'/loan';

		return json($return);

	}


	public function loanInsertID(){

        $this->db->table("loan");
        $this->db->insertArray(array(

            "borrower_id" => $this->request('borrowerID'),
            "recommended_by" => $this->request('recommended_by'),
            "commission" => $this->request('commission'),
            "loan_amt" => $this->request('amount'),
            "loan_date" => $this->request('loan_date'),
            "cash_by_hand" => $this->request('cash'),
            "loan_term" => $this->request('loan_term'),
            //"loan_interest_year" => $this->request('loan_interest_year'),
            "loan_interest_month" => $this->request('loan_interest_month'),
            "principal_paid" => $this->request('principal'),
            "principal_paid_date" => $this->request('principal_date'),
            "stamp_duty_fees" => $this->request('stamp'),
            "created_by" => $this->cms->admin->id,
            "loan_status" => '2',
            "date_created" => 'NOW()'

        ));

        $this->db->insert();

        $return['error'] = false;
        $return['msg'] = "New Loan created.";
        $return['url'] = option('base_uri').'/loan';

		return json($return);

	}


	public function loanUpdate($id){
        $this->db->query("SELECT * FROM loan WHERE loan_id = ".$this->db->escape($id)."");
        $loan = $this->db->getSingleRow();

        //print_r($_REQUEST); exit();

        (int)$borrower_id = $this->request('borrowerID');
        (int)$terms = $this->request('loan_term');
        (int)$amount = $this->request('amount');
        (int)$interest = $this->request('loan_interest_month');

        $payment_day = substr($this->request('principal_date'),-2);

        $year = substr($this->request('loan_date'),0,4);
        $month = substr($this->request('loan_date'),5,2);
        $loan_day = substr($this->request('loan_date'),-2);

        $loan_date = $year.'-'.$month.'-'.$loan_day;


        if($month == 12){
            $month = 1;
            $year = $year+1;
        }else{
            $month = $month+1;
        }

		$this->db->table("loan");
		$this->db->updateArray(array(

			"borrower_id" => $borrower_id,
			"recommended_by" => $this->request('recommended_by'),
			"commission" => $this->request('commission'),
			"loan_amt" => $amount,
			"loan_date" => $loan_date,
			"cash_by_hand" => $this->request('cash'),
			"loan_term" => $terms,
			//"loan_interest_year" => $this->request('loan_interest_year'),
			"loan_interest_month" => $interest,
			"principal_paid" => $this->request('principal'),
			"principal_paid_date" => $this->request('principal_date'),
			"stamp_duty_fees" => $this->request('stamp'),
            "rejection" => $this->request('rejection'),
			"loan_status" => $this->request('status'),
			"updated_date" => 'NOW()'
		));
		$this->db->whereArray(array(
			"loan_id" => $id,
		));
		$this->db->update();

        // Inactive the rescheduled loan because its rejected
        if($this->request('status') == 3 && $loan['reschedule'] == '1'){
            $this->db->query("SELECT * FROM loan WHERE reschedule_id = ".$this->db->escape($loan['reschedule_id'])." AND reschedule = 1");
            $loan_old_res = $this->db->getSingleRow();

            $this->db->table("loan");
            $this->db->updateArray(array(
                "loan_status" => '99',
                "reschedule" => '0',
                "reschedule_id" => '0',
            ));
            $this->db->whereArray(array(
                "loan_id" => $id,
            ));
            $this->db->update();

            $this->db->table("loan");
            $this->db->updateArray(array(
                "reschedule" => '0',
                "reschedule_id" => '0',
            ));
            $this->db->whereArray(array(
                "loan_id" => $loan_old_res['loan_id'],
            ));
            $this->db->update();
        }

        if($this->request('status') != '3' && $this->request('status') != '7'){
            $this->db->table("loan");
            $this->db->updateArray(array(
                "rejection" => '',
            ));
            $this->db->whereArray(array(
                "loan_id" => $id,
            ));
            $this->db->update();
        }

		$return['error'] = false;
		$return['msg'] = "Account updated";
		$return['url'] = option('base_uri').'/loan';

		return json($return);
	}

    public function loanApprovalUpdate($id){
        $this->db->query("SELECT * FROM loan WHERE loan_id = ".$this->db->escape($id)."");
        $loan = $this->db->getSingleRow();

        //print_r($_REQUEST); exit();

        (int)$borrower_id = $this->request('borrowerID');
        (int)$terms = $this->request('loan_term');
        (int)$amount = $this->request('amount');
        (int)$interest = $this->request('loan_interest_month');

        $payment_day = substr($this->request('loan_date'),-2);

        $year = substr($this->request('loan_date'),0,4);
        $month = substr($this->request('loan_date'),5,2);
        $loan_day = substr($this->request('loan_date'),-2);

        $loan_date = $year.'-'.$month.'-'.$loan_day;


        if($month == 12){
            $month = 1;
            $year = $year+1;
        }else{
            $month = $month+1;
        }

        $this->db->table("loan");
        $this->db->updateArray(array(

            "borrower_id" => $borrower_id,
            "recommended_by" => $this->request('recommended_by'),
            "commission" => $this->request('commission'),
            "loan_amt" => $amount,
            "loan_date" => $loan_date,
            "cash_by_hand" => $this->request('cash'),
            "loan_term" => $terms,
            //"loan_interest_year" => $this->request('loan_interest_year'),
            "loan_interest_month" => $interest,
            "principal_paid" => $this->request('principal'),
            "principal_paid_date" => $this->request('principal_date'),
            "stamp_duty_fees" => $this->request('stamp'),
            "rejection" => $this->request('rejection'),
            "loan_status" => $this->request('status'),
            "updated_date" => 'NOW()'
        ));

        $this->db->whereArray(array(
            "loan_id" => $id,
        ));

        $this->db->update();

        // Inactive the rescheduled loan because its rejected
        if($this->request('status') == 7 && $loan['reschedule'] == '1'){
            $this->db->query("SELECT * FROM loan WHERE reschedule_id = ".$this->db->escape($loan['reschedule_id'])." AND reschedule = 1");
            $loan_old_res = $this->db->getSingleRow();

            $this->db->table("loan");
            $this->db->updateArray(array(
                "loan_status" => '99',
                "reschedule" => '0',
                "reschedule_id" => '0',
            ));
            $this->db->whereArray(array(
                "loan_id" => $id,
            ));
            $this->db->update();

            $this->db->table("loan");
            $this->db->updateArray(array(
                "reschedule" => '0',
                "reschedule_id" => '0',
            ));
            $this->db->whereArray(array(
                "loan_id" => $loan_old_res['loan_id'],
            ));
            $this->db->update();
        }

        // Insert into installments table
        if($this->request('status') == 1 || $this->request('status') == 8){
            $this->db->table("loan");
            $this->db->updateArray(array(
                "reschedule" => '2',
            ));
            $this->db->whereArray(array(
                "loan_id" => $id,
            ));
            $this->db->update();

            $this->db->query("SELECT * FROM loan WHERE reschedule_id = ".$this->db->escape($loan['reschedule_id'])." AND reschedule = 1");
            $loan_old_res = $this->db->getSingleRow();

            if(!empty($loan_old_res['reschedule']) == '1'){
                $this->db->table("loan");
                $this->db->updateArray(array(
                    "loan_status" => '992',
                ));
                $this->db->whereArray(array(
                    "loan_id" => $loan_old_res['loan_id'],
                ));
                $this->db->update();

                $this->db->table("loan");
                $this->db->updateArray(array(
                    "reschedule" => '0',
                    "reschedule_id" => '0',
                ));
                $this->db->whereArray(array(
                    "loan_id" => $id,
                ));
                $this->db->update();

                $this->db->table("installment");
                $this->db->updateArray(array(
                    "installment_status" => '99',
                ));
                $this->db->whereArray(array(
                    "loan_id" => $loan_old_res['loan_id'],
                ));
                $this->db->update();

                $this->db->table("recovery");
                $this->db->updateArray(array(
                    "recovery_status" => '99',
                ));
                $this->db->whereArray(array(
                    "loan_id" => $loan_old_res['loan_id'],
                ));
                $this->db->update();
            }

            $interest_percent = $interest/100;

            $monthly_interest = $amount * $interest_percent;
            if($terms == 0 || $terms == ""){
                $monthly_principal = 0;
                $terms = 1;
            }else{
                $monthly_principal = $amount / $terms;
                $monthly_principal = ceil($monthly_principal / 10) * 10;
            }
            $installment_amount = $monthly_interest + $monthly_principal;

            // Initial values
            $balance_bf_gross = ($monthly_interest * $terms) + $amount;
            $balance_bf_principal = $amount;
            $balance_cf_gross = $balance_bf_gross - $installment_amount;
            $balance_cf_principal = $balance_bf_principal - $monthly_principal;

            if($terms == 1){ $terms = 40; }
            for( $i = 0; $i < $terms ; $i++){

                if($month < 10){
                    $month = '0'.$month;
                }

                $payment_date = $payment_day.'-'.$month.'-'.$year;

                $loan_date = $year.'-'.$month.'-'.$loan_day;

                $this->db->query("SELECT * FROM borrowers WHERE borrower_id = ".$this->db->escape($borrower_id)."");
                $borrower = $this->db->getSingleRow();

                $this->db->query("SELECT * FROM team_management WHERE officer_id = ".$this->db->escape($borrower['agent_id'])."");
                $head = $this->db->getSingleRow();

                $this->db->table("installment");
                $this->db->insertArray(array(

                    "borrower_id" => $borrower_id,
                    "admin_id" => $borrower['agent_id'],
                    "head_id" => $head['head_id'],
                    "loan_id" => $id,
                    "terms" => $this->request('loan_term'),
                    "installment_amt" => $installment_amount,
                    "interest" => $monthly_interest,
                    "principal" => $monthly_principal,
                    "balance_bf_gross" => $balance_bf_gross,
                    "balance_bf_principal" => $balance_bf_principal,
                    "balance_cf_gross" => $balance_cf_gross,
                    "balance_cf_principal" => $balance_cf_principal,
                    "installment_status" => 1,
                    "payment_date" => $payment_date,
                    "loan_date" => $loan_date,
                    "date_created" => 'NOW()',
                    "Months" => $month,
                    "Year" => $year
                ));

                $this->db->insert();


                $balance_bf_gross = $balance_bf_gross - $installment_amount;
                $balance_bf_principal = $balance_bf_principal - $monthly_principal;
                $balance_cf_gross = $balance_bf_gross - $installment_amount;
                $balance_cf_principal = $balance_bf_principal - $monthly_principal;


                if($month==12){
                    $month = 1;
                    $year++;
                }else{
                    $month ++;

                }
            }
            /*
            if($terms != 40){
                //Insert into dummy repayment schedule
                $termsInMonths = $terms;
                $installmentAmount = $amount;

                $interestRatePerMonth = $year_interest/12/100;
                $interestRatePerMonth= number_format($interestRatePerMonth,10,'.','');
                $beginningBalance = $amount;
                for( $i = 0; $i < $termsInMonths ; $i++){
                    $interestAmount = $beginningBalance * $interestRatePerMonth;
                    $interestAmount= number_format($interestAmount,2,'.','');

                    $principal = $installmentAmount - $interestAmount;
                    $principal= number_format($principal,2,'.','');

                    $endingBalance = $beginningBalance - $principal;
                    $endingBalance= number_format($endingBalance,2,'.','');

                    if($endingBalance < 0){
                        $installmentAmount = $installmentAmount + $endingBalance;
                        $endingBalance = 0;

                    }

                    if($month < 10){
                        $month = '0'.$month;
                    }


                    $balance_bf_principal = $amount;
                    $balance_cf_gross = $balance_bf_gross - $installment_amount;
                    $balance_cf_principal = $balance_bf_principal - $monthly_principal;

                    $this->db->table("repayment");
                    $this->db->insertArray(array(
                        "borrower_id" => $borrower_id,
                        "loan_id" => $id,
                        "terms" => $terms,
                        "repayment_amt" => $installmentAmount,
                        "interest" => $interestAmount,
                        "principal" => $principal,
                        "balance_bf_gross" => $beginningBalance,
                        "balance_bf_principal" => $balance_bf_principal,
                        "balance_cf_gross" => $endingBalance,
                        "balance_cf_principal" => $balance_cf_principal,
                        "repayment_status" => 1,
                        "payment_date" => $payment_date,
                        "loan_date" => $loan_date,
                        "date_created" => 'NOW()',
                        "Months" => $month,
                        "Year" => $year
                    ));
                    $this->db->insert();



                    $balance_bf_gross = $balance_bf_gross - $installment_amount;
                    $balance_bf_principal = $balance_bf_principal - $monthly_principal;
                    $balance_cf_gross = $balance_bf_gross - $installment_amount;
                    $balance_cf_principal = $balance_bf_principal - $monthly_principal;


                    if($month==12){
                        $month = 1;
                        $year++;
                    }else{
                        $month ++;

                    }
                }
            }*/
        }



        $return['error'] = false;
        $return['msg'] = "Account updated";
        $return['url'] = option('base_uri').'/loanApproval';

        return json($return);
    }

	public function recoveryUpdate($id){

        $this->db->query("SELECT * FROM installment WHERE installment_id = ".$this->db->escape($id));
        $recovery = $this->db->getSingleRow();

        $this->db->query("SELECT * FROM loan WHERE loan_id = ".$this->request('loan_id')."");
        $loan = $this->db->getSingleRow();

        if($this->request('paid_for') == 6 && ($this->request('amount_show') < $recovery['balance_bf_principal'])){
            $return['error'] = true;
            $return['msg'] = "Full Settlement Amount must be <br>Equal or Greater than <br>Total Principal Due.";
        }
        else if($loan['reschedule'] == '1'){
            $return['error'] = true;
            $return['msg'] = "The Rescheduling for this Loan is Already in progress.";
        }
        else if($this->request('paid_for') == 0){
            $return['error'] = true;
            $return['msg'] = "Please select a Payment Method.";
        }
        else if($this->request('paid_for') == 2 && $this->request('interest') <= 0){
            $return['error'] = true;
            $return['msg'] = "Interest Amount required.";
        }
        else if($this->request('paid_for') == 4 && ($this->request('amount_show') > $recovery['installment_amt'])){
            $return['error'] = true;
            $return['msg'] = "Partial Payment must be <br>Equal or Less than <br>Amount Due.";
        }
        else{
            // upload attachment
            $images = $this->request('images') ? array_filter($this->request('images')) : array();

            //If both - "1"
            if($this->request('paid_for') == 1){

                $actual_paid = $this->request('actual_amount');

                // Update installment table
                $this->db->table("installment");
                $this->db->updateArray(array(
                    "paid_for" => 1,
                    "installment_status" => 4,
                    "updated_date" => 'NOW()'
                ));

                $this->db->whereArray(array(
                    "installment_id" => $id,
                ));

                $this->db->update();
            }

            //If interest - "2", creates another month of loan
            if($this->request('paid_for') == 2){
                $actual_paid = $this->request('interest');

//                // Update installment table
//                $this->db->table("installment");
//                $this->db->updateArray(array(
//                    "paid_for" => 2,
//                    "installment_status" => 2,
//                    "updated_date" => 'NOW()'
//                ));
//
//                $this->db->whereArray(array(
//                    "installment_id" => $id,
//                ));
//
//                $this->db->update();
//
//                // Select last row of installment
//                $this->db->query("SELECT * FROM installment WHERE loan_id = ".$this->request('loan_id')." ORDER BY installment_id DESC LIMIT 1");
//                $last_installment = $this->db->getSingleRow();
//
//                $month = $last_installment['Months'];
//                $year = $last_installment['Year'];
//
//                if($month == 12){
//                    $month = 1;
//                    $year++;
//                }else{
//                    $month ++;
//
//                }
//
//                if($month < 10){
//                    $month = '0'.$month;
//                }
//
//                $pay_day = substr($last_installment['payment_date'],0,2);
//                $loan_day = substr($last_installment['loan_date'],0,2);
//
//                $pay_date = $pay_day.'-'.$month.'-'.$year;
//                $loan_date = $year.'-'.$month.'-'.$loan_day;
//
//                // Create new installment record
//                $this->db->table("installment");
//                $this->db->insertArray(array(
//
//                    "borrower_id" => $this->request('borrower_id'),
//                    "loan_id" => $this->request('loan_id'),
//                    "terms" => $last_installment['terms'],
//                    "installment_amt" => $last_installment['installment_amt'],
//                    "interest" => $last_installment['interest'],
//                    "principal" => $last_installment['principal'],
//                    "balance_bf_gross" => "-",
//                    "balance_bf_principal" => $this->request('balance_bf_principal'),
//                    "balance_cf_gross" => "-",
//                    "balance_cf_principal" => "-",
//                    "installment_status" => 1,
//                    "payment_date" => $pay_date,
//                    "loan_date" => $loan_date,
//                    "date_created" => 'NOW()',
//                    "Months" => $month,
//                    "Year" => $year
//                ));
//                $this->db->insert();
            }

            //if Principal Payment
            if($this->request('paid_for') == 3){
                $this->db->table("loan");
                $this->db->insertArray(array(
                    "borrower_id" => $loan['borrower_id'],
                    "recommended_by" => $loan['recommended_by'],
                    "commission" => $loan['commission'],
                    "loan_amt" => $this->request('amount_show_res'),
                    "loan_date" => $this->request('new_loan_date'),
                    "cash_by_hand" => $loan['cash_by_hand'],
                    "loan_term" => $this->request('new_terms'),
                    //"loan_interest_year" => $this->request('loan_interest_year'),
                    "loan_interest_month" => $this->request('new_interest'),
                    "principal_paid" => $loan['principal_paid'],
                    "principal_paid_date" => $loan['principal_paid_date'],
                    "stamp_duty_fees" => $loan['stamp_duty_fees'],
                    "created_by" => $loan['created_by'],
                    "loan_status" => '6',
                    "reschedule_id" => $this->request('loan_id'),
                    "reschedule" => '1',
                    "date_created" => 'NOW()'
                ));
                $this->db->insert();

                $this->db->table("loan");
                $this->db->updateArray(array(
                    "reschedule_id" => $this->request('loan_id'),
                    "reschedule" => '1',
                ));
                $this->db->whereArray(array(
                    "loan_id" => $this->request('loan_id'),
                ));
                $this->db->update();

//			$actual_paid = $this->request('amount_show');
//
//			// Update installment table
//			$this->db->table("installment");
//			$this->db->updateArray(array(
//				"paid_for" => 2,
//				"installment_status" => 2,
//				"updated_date" => 'NOW()'
//			));
//
//			$this->db->whereArray(array(
//				"installment_id" => $id,
//			));
//
//			$this->db->update();
//
//			//create new installments based on the remainder of principal & remainder of months
//
//
//			// get number of months that installments paid & remainder of principal
//			$this->db->query("SELECT COUNT(installment_id) AS numbers, terms, payment_date, Months, Year FROM installment WHERE loan_id = ".$this->request('loan_id')." AND installment_status = 1 AND balance_bf_gross > 1");
//			$unpaid_installments = $this->db->getSingleRow();
//
//			//get balance of loan
//			$current_balance_principal = $this->request('balance_bf_principal');
//			//$current_balance_gross = $this->request('balance_bf_gross');
//
//			$terms = $this->request('new_terms');
//			$total_terms = $terms;
//
//			$interest_percent = $this->request('new_interest')/100;
//
//			$last_interest = $actual_paid * $interest_percent;
//			//$last_interest = $this->request('new_interest');
//
//			$balance_principal = $current_balance_principal - $actual_paid;
//
//			$monthly_principal = $balance_principal / $total_terms;
//			$monthly_principal = ceil($monthly_principal / 10) * 10;
//			$installment_amount = $last_interest + $monthly_principal;
//
//			// Initial values
//			//$balance_bf_gross = $current_balance_gross;
//			$balance_bf_gross = ($last_interest * $total_terms) + $installment_amount;
//			$balance_bf_principal = $balance_principal;
//			$balance_cf_gross = $balance_bf_gross - $installment_amount;
//			$balance_cf_principal = $balance_bf_principal - $monthly_principal;
//
//
//			$pay_day = substr($unpaid_installments['payment_date'],0,2);
//			$loan_day = date('d');
//			$month = $unpaid_installments['Months'];
//			$year = $unpaid_installments['Year'];
//
//			$month = $month++;
//
//
//			//update the rest of the installments to Deleted
//			$this->db->table("installment");
//			$this->db->updateArray(array(
//				"installment_status" => 99,
//				"updated_date" => 'NOW()'
//			));
//
//			$this->db->whereArray(array(
//				"loan_id" => $this->request('loan_id'),
//				"installment_status" => 1,
//			));
//			$this->db->update();
//
//
//			// Insert new set of installments
//			for( $i = 0; $i < $terms ; $i++){
//
//
//				$payment_date = $pay_day.'-'.$month.'-'.$year;
//
//				$loan_date = $year.'-'.$month.'-'.$loan_day;
//
//
//				$this->db->table("installment");
//				$this->db->insertArray(array(
//
//					"borrower_id" => $borrower_id,
//					"loan_id" => $id,
//					"terms" => $total_terms,
//					"installment_amt" => $installment_amount,
//					"interest" => $last_interest,
//					"principal" => $monthly_principal,
//					"balance_bf_gross" => $balance_bf_gross,
//					"balance_bf_principal" => $balance_bf_principal,
//					"balance_cf_gross" => $balance_cf_gross,
//					"balance_cf_principal" => $balance_cf_principal,
//					"installment_status" => 1,
//					"payment_date" => $payment_date,
//					"loan_date" => $loan_date,
//					"date_created" => 'NOW()',
//					"Months" => $month,
//					"Year" => $year
//				));
//
//				$this->db->insert();
//
//
//				$balance_bf_gross = $balance_bf_gross - $installment_amount;
//				$balance_bf_principal = $balance_bf_principal - $monthly_principal;
//				$balance_cf_gross = $balance_bf_gross - $installment_amount;
//				$balance_cf_principal = $balance_bf_principal - $monthly_principal;
//
//
//				if($month==12){
//					$month = 1;
//					$year++;
//				}else{
//					$month ++;
//
//				}
//			}
            }


            //if Partial Repayment
            if($this->request('paid_for') == 4){
                $actual_paid = $this->request('amount_show');

                // Update installment table
                $this->db->table("installment");
                $this->db->updateArray(array(
                    "paid_for" => 4,
                    "installment_status" => 4,
                    "updated_date" => 'NOW()'
                ));
                $this->db->whereArray(array(
                    "installment_id" => $id,
                ));
                $this->db->update();
            }


            //if Late Payment
            if($this->request('paid_for') == 5){
                $actual_paid = $this->request('amount_show');
            }

            //if Full Settlement
            if($this->request('paid_for') == 6){
                $actual_paid = $this->request('amount_show');

                // Update installment table
                $this->db->table("installment");
                $this->db->updateArray(array(
                    "paid_for" => 6,
                    "installment_status" => 4,
                    "updated_date" => 'NOW()'
                ));
                $this->db->whereArray(array(
                    "loan_id" => $this->request('loan_id'),
                    "installment_status" => 1,
                ));
                $this->db->update();

                $this->db->table("installment");
                $this->db->updateArray(array(
                    "paid_for" => 6,
                    "installment_status" => 4,
                    "updated_date" => 'NOW()'
                ));
                $this->db->whereArray(array(
                    "loan_id" => $this->request('loan_id'),
                    "installment_status" => 3,
                ));
                $this->db->update();
            }

            // upload receipt attachment
            //$this->uploadDocument('receipt', '', true, $id);

            if($this->request('paid_for') != 3){
                //insert recovery table
                $this->db->table("recovery");
                $this->db->insertArray(array(
                    "borrower_id" => $this->request('borrower_id'),
                    "loan_id" => $this->request('loan_id'),
                    "installment_id" => $this->request('installment_id'),
                    "amount_paid" => $actual_paid,
                    "actual_amount" => $this->request('actual_amount'),
                    "receipts" => serialize($images),
                    "pay_type" => $this->request('paid_for'),
                    "recovery_status" => 4,
                    "remarks" => $this->request('remarks'),
                    "paid_date" => 'NOW()',
                    "date_created" => 'NOW()'
                ));
                $this->db->insert();
            }

            $return['error'] = false;
            $return['msg'] = "Collection done.";
            $return['url'] = option('base_uri').'/recovery';
        }
		return json_encode($return);
	}

	public function uploadDocument($var_name, $label, $is_profile = false, $borrower_id = false){
		//if(isset($var_name) && $this->request($var_name) != ""){
		$labelName = basename($this->request($var_name));
		if(isset($label)  &&  $this->request($label) != ""){
			$labelName = $this->request($label);
		}
		if($this->request($var_name.'_file_id')){
			$this->updateBorrowerFileRecord($this->request($var_name.'_file_id'), $labelName, basename($this->request($var_name)), $borrower_id);
		}else{
			$this->addBorrowerFileRecord($labelName, basename($this->request($var_name)), $is_profile, $borrower_id);
		}
		return $this->request($var_name);
		//}
		return "";
	}

	public function addBorrowerFileRecord($filename, $originalFileName, $is_profile, $borrower_id){
		$file_id = str_replace('.', '-', uniqid(rand(), true));
		$this->db->table("files");
		$insert_data = array(
			"file_id" => $file_id,
			"parent_id" => $borrower_id,
			"label" => $filename,
			"filename" => $originalFileName,
		);
		if ($is_profile){
			$insert_data["profile_photo"] = "y";
		}
		$this->db->insertArray($insert_data);
		$this->db->insert();
	}

	public function updateBorrowerFileRecord($file_id, $filename, $originalFileName, $borrower_id){
		$this->db->table("files");
		$this->db->updateArray(array(
			"label" => $filename,
			"filename" => $originalFileName,
		));

		$this->db->whereArray(array(
			"file_id" => $file_id,
			"parent_id" => $borrower_id
		));
		$this->db->update();
	}

    public function riskUpdate($id){
        $this->db->query("SELECT * FROM recovery WHERE recovery_id = ".$this->db->escape($id));
        $recovery = $this->db->getSingleRow();

        $this->db->table("recovery");
        $this->db->updateArray(array(
            "recovery_status" => $this->request('status'),
            "remarks" => $this->request('remarks'),

        ));
        $this->db->whereArray(array(
            "recovery_id" => $id,
        ));
        $this->db->update();

        if($this->request('pay_type') != 5 && $this->request('pay_type') != 2){
            $this->db->table("loan");
            $this->db->updateArray(array(
                "updated_date" => 'NOW()'
            ));
            $this->db->whereArray(array(
                "loan_id" => $this->request('loan_id'),
            ));
            $this->db->update();

            if($this->request('installment_id')){
                $this->db->table("installment");
                $this->db->updateArray(array(
                    "installment_status" => $this->request('status'),
                    "rejection" => $this->request('rejection'),
                    "updated_date" => 'NOW()'
                ));
                $this->db->whereArray(array(
                    "installment_id" => $this->request('installment_id'),
                ));
                $this->db->update();
            }
        }

        //if Partial Repayment
        if($this->request('pay_type') == 4){
            $actual_paid = $recovery['amount_paid'];

            if($this->request('status') == 2){
                //Select current installment details
                $this->db->query("SELECT * FROM installment WHERE installment_id = ".$this->db->escape($this->request('installment_id')));
                $current_installment = $this->db->getSingleRow();

                $installment_amt = $current_installment['installment_amt'] - $actual_paid;

                if($installment_amt != '0'){
                    $this->db->table("installment");
                    $this->db->updateArray(array(
                        "installment_status" => 1,
                        "installment_amt" => $installment_amt,
                    ));
                    $this->db->whereArray(array(
                        "installment_id" => $this->request('installment_id'),
                    ));
                    $this->db->update();
                }
                else{
                    $this->db->table("installment");
                    $this->db->updateArray(array(
                        "installment_status" => 2,
                        "installment_amt" => $current_installment['interest'] + $current_installment['principal'],
                    ));
                    $this->db->whereArray(array(
                        "installment_id" => $this->request('installment_id'),
                    ));
                    $this->db->update();
                }
            }
        }

        //if Both Principal + Interest from Partial Repayment
        if($this->request('pay_type') == 1){
            $actual_paid = $recovery['amount_paid'];

            if($this->request('status') == 2){
                //Select current installment details
                $this->db->query("SELECT * FROM installment WHERE installment_id = ".$this->db->escape($this->request('installment_id')));
                $current_installment = $this->db->getSingleRow();

                if($actual_paid != $current_installment['interest'] + $current_installment['principal']){

                    $this->db->table("installment");
                    $this->db->updateArray(array(
                        "installment_status" => 2,
                        "installment_amt" => $current_installment['interest'] + $current_installment['principal'],
                    ));
                    $this->db->whereArray(array(
                        "installment_id" => $this->request('installment_id'),
                    ));
                    $this->db->update();
                }
            }
        }

        //if Full Settlement
        if($this->request('pay_type') == 6){

            if($this->request('status') == 2){
                //Set all installment records as Paid
                // Update installment table
                $this->db->table("installment");
                $this->db->updateArray(array(
                    "paid_for" => 6,
                    "installment_status" => 2,
                    "updated_date" => 'NOW()'
                ));
                $this->db->whereArray(array(
                    "loan_id" => $this->request('loan_id'),
                ));
                $this->db->update();

                // Update loan table
                $this->db->table("loan");
                $this->db->updateArray(array(
                    "loan_status" => 990,
                    "updated_date" => 'NOW()'
                ));
                $this->db->whereArray(array(
                    "loan_id" => $this->request('loan_id'),
                ));
                $this->db->update();
            }
            if($this->request('status') == 3){
                //Set all installment records as Paid
                // Update installment table
                $this->db->table("installment");
                $this->db->updateArray(array(
                    "installment_status" => 1,
                ));
                $this->db->whereArray(array(
                    "loan_id" => $this->request('loan_id'),
                    "installment_status" => 4,
                ));
                $this->db->update();
            }
        }

        $return['error'] = false;
        $return['msg'] = "Payment Confirmed.";
        $return['url'] = option('base_uri').'/risk';

        return json($return);

    }
}
?>