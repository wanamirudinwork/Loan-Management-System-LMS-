<?php
class cms{
	var $db;
	var $admin;

	public function __construct($db, $admin){
		$this->db = $db;
		$this->admin = $admin;
		$this->settings = $this->settings();
		$this->no_image = 'assets/img/no_image.jpg';
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

	public function request($field){
		$val = !empty($_REQUEST[$field]) ? $_REQUEST[$field] : (!empty($_REQUEST[$field]) && $_REQUEST[$field] == '0' ? '0' : false);
		return $val;
	}

	public function price($price = ''){
		$negative = $price < 0 ? true : false;
		if($price < 0) $price = abs($price);

		$currency = 'RM ';
		$return = $currency . '' . number_format($price, 2, '.', ',');
		if($negative) $return = '-' . $return;
		return $return;
	}

	public function countries(){
		$this->db->query("SELECT * FROM country WHERE status = '1' ORDER BY name");
		return $this->db->getRowList();
	}

	public function country($id){
		$this->db->query("SELECT * FROM country WHERE id = " . $this->db->escape($id));
		return $this->db->getSingleRow();
	}

	public function state($country){
		$this->db->query("SELECT * FROM state WHERE status = '1' AND country_id = " . $this->db->escape($country));
		return $this->db->getRowList();
	}

	public function getState($country){
		$states = $this->state($country);
		$stateList = '';

		if($states){
			foreach($states as $keys){
				$stateList .= '<option value="' . $keys['id'] . '">' . $keys['name'] . '</option>';
			}
		}

		$return['states'] = $stateList;
		$return['error'] = false;
		$return['msg'] = "Request success.";

		return json($return);
	}

	public function login(){
		return render('login.php', '');
	}

	public function logout(){
		session_destroy();
		return '<meta http-equiv="refresh" content="0; URL=' . url_for('/') . '">';
	}

	public function home(){
		$total['total_borrowers'] = $this->db->getValue("SELECT COUNT(*) FROM borrowers");
		$total['total_active_borrowers'] = $this->db->getValue("SELECT COUNT(*) FROM borrowers WHERE borrower_id IN (SELECT borrower_id FROM loan WHERE loan_status IN (1,8))");

		$this->db->query("SELECT COUNT(borrower_id) AS total FROM borrowers WHERE borrower_status <> 99");
		$total_borrowers = $this->db->getSingleRow();

		$total['borrowers'] = $total_borrowers['total'];

		$this->db->query("SELECT COUNT(borrower_id) AS total FROM borrowers WHERE agent_id = '' AND borrower_status <> 99");
		$new_borrower = $this->db->getSingleRow();

		$total['new_borrowers'] = $new_borrower['total'];

		$this->db->query("SELECT COUNT(loan_id) AS total FROM loan WHERE loan_status <> 99 AND loan_status <> 991");
		$loan = $this->db->getSingleRow();

		$total['total_loan'] = $loan['total'];

		$this->db->query("SELECT SUM(amount_paid) AS total,COUNT(recovery_id) AS count_recovery FROM recovery WHERE recovery_status = 2");
		$recovery = $this->db->getSingleRow();

		if($recovery['total']){
			$total['total_recovered'] = $recovery['total'];
		}else{
			$total['total_recovered'] = 0;
		}

		$total['count_recovered'] = $recovery['count_recovery'];

		$this->db->query("SELECT SUM(amount_paid) AS total, COUNT(recovery_id) AS count_recovery FROM recovery");
		$recovery_count = $this->db->getSingleRow();

		$total['sum_recovery'] = $recovery_count['total'];
		$total['count_recovery'] = $recovery_count['count_recovery'];

		$this->db->query("SELECT SUM(amount_paid) AS total, COUNT(recovery_id) AS count_recovery FROM recovery WHERE recovery_status = 1");
		$recovery_count = $this->db->getSingleRow();

		$total['sum_unclaimed'] = $recovery_count['total'];
		$total['count_unclaimed'] = $recovery_count['count_recovery'];

		// Installments - total pending recovery
		$this->db->query("SELECT SUM(installment_amt) AS total, COUNT(installment_id) AS count_recovery FROM installment WHERE installment_status = 1 AND payment_date < NOW()");
		$recovery_pending = $this->db->getSingleRow();

		// Second row
			$this->db->query("SELECT * FROM loan WHERE loan_status = '1' OR loan_status = '8'");
			$loans = $this->db->getRowList();

			$my_loan_ids = array(0);
			$my_pending_installment_loan_ids = array();

			$count_installment_this_month = 0;
			$count_installment_paid_this_month = 0;
			$count_partial_paid_this_month = 0;

			$total_installment_this_month = 0;
			$total_installment_paid_this_month = 0;
			$total_partial_paid_this_month = 0;

			$count_installment_until_this_month = 0;
			$count_installment_paid_until_this_month = 0;
			$count_partial_paid = 0;

			$total_installment_until_this_month = 0;
			$total_installment_paid_until_this_month = 0;
			$total_partial_paid = 0;

			$condition = " AND YEAR(loan_date) <= " . date('Y') . ' AND MONTH(loan_date) <= ' . date('m');
			$condition2 = " AND YEAR(loan_date) = " . date('Y') . ' AND MONTH(loan_date) = ' . date('m');

			if($loans){
				foreach($loans as $loan){
					array_push($my_loan_ids, $loan['loan_id']);

					$count_installment_this_month += $this->db->getValue("SELECT COUNT(*) FROM installment WHERE loan_id = " . $this->db->escape($loan['loan_id']) . $condition2);
					$count_installment_paid_this_month += $this->db->getValue("SELECT COUNT(*) FROM installment WHERE loan_id = " . $this->db->escape($loan['loan_id']) . " AND installment_status = '2'" . $condition2);
					$count_partial_paid_this_month += $this->db->getValue("SELECT COUNT(*) FROM recovery WHERE recovery_status = '2' AND installment_id IN (SELECT installment_id FROM installment WHERE installment_status = '1' AND loan_id IN (" . implode(',', $my_loan_ids) . ") " . $condition2  . ")");

					$total_installment_this_month += $this->db->getValue("SELECT SUM(installment_amt) FROM installment WHERE loan_id = " . $this->db->escape($loan['loan_id']) . $condition);
					$total_installment_paid_this_month += $this->db->getValue("SELECT SUM(installment_amt) FROM installment WHERE loan_id = " . $this->db->escape($loan['loan_id']) . " AND installment_status = '2'" . $condition);

					$total_partial_paid_this_month += $this->db->getValue("SELECT SUM(amount_paid) FROM recovery WHERE recovery_status = '2' AND installment_id IN (SELECT installment_id FROM installment WHERE installment_status = '1' AND loan_id IN (" . implode(',', $my_loan_ids) . ") " . $condition2  . ")");

					$count_installment_until_this_month += $this->db->getValue("SELECT COUNT(*) FROM installment WHERE loan_id = " . $this->db->escape($loan['loan_id']) . $condition);
					$count_installment_paid_until_this_month += $this->db->getValue("SELECT COUNT(*) FROM installment WHERE loan_id = " . $this->db->escape($loan['loan_id']) . " AND installment_status = '2'" . $condition);
					$count_partial_paid += $this->db->getValue("SELECT COUNT(*) FROM recovery WHERE recovery_status = '2' AND installment_id IN (SELECT installment_id FROM installment WHERE installment_status = '1' AND loan_id IN (" . implode(',', $my_loan_ids) . ") " . $condition  . ")");

					$total_installment_until_this_month += $this->db->getValue("SELECT SUM(installment_amt) FROM installment WHERE loan_id = " . $this->db->escape($loan['loan_id']) . $condition2);
					$total_installment_paid_until_this_month += $this->db->getValue("SELECT SUM(installment_amt) FROM installment WHERE loan_id = " . $this->db->escape($loan['loan_id']) . " AND installment_status = '2'" . $condition2);

					$total_partial_paid += $this->db->getValue("SELECT SUM(amount_paid) FROM recovery WHERE recovery_status = '2' AND installment_id IN (SELECT installment_id FROM installment WHERE installment_status = '1' AND loan_id IN (" . implode(',', $my_loan_ids) . ") " . $condition  . ")");
				}
			}

			$total['count_installment_this_month'] = $count_installment_this_month + $count_partial_paid_this_month;
			$total['count_installment_paid_this_month'] = $count_installment_paid_this_month;

			$total['total_installment_paid_this_month'] = $total_installment_paid_this_month;
			$total['total_installment_this_month'] = $total_installment_this_month;
			$total['total_installment_paid_this_month_percent'] = $total_installment_this_month <= 0 ? 0 : round($total['total_installment_paid_this_month'] / $total_installment_this_month * 100);

			$total['count_installment_until_this_month'] = $count_installment_until_this_month + $count_partial_paid;
			$total['count_installment_paid_until_this_month'] = $count_installment_until_this_month;

			$total['total_installment_paid_until_this_month'] = $total_installment_paid_until_this_month + $total_partial_paid;
			$total['total_installment_until_this_month'] = $total_installment_until_this_month;
			$total['total_installment_paid_until_this_month_percent'] = $total_installment_until_this_month <= 0 ? 0 : round($total['total_installment_paid_until_this_month'] / $total_installment_until_this_month * 100);

			$total_installment_until_this_month = 0;
			$total_installment_paid_until_this_month = 0;

			$total_installment_until_this_month_rehead = 0;
			$total_installment_paid_until_this_month_rehead = 0;

			$total_installment_until_this_month_reoffice = 0;
			$total_installment_paid_until_this_month_reoffice = 0;

			$condition = " AND YEAR(loan_date) <= " . date('Y') . ' AND MONTH(loan_date) <= ' . date('m');

			if($loans){
				foreach($loans as $loan){
					$total_installment_until_this_month += $this->db->getValue("SELECT SUM(installment_amt) FROM installment WHERE loan_id = " . $this->db->escape($loan['loan_id']) . $condition);
					$total_installment_paid_until_this_month += $this->db->getValue("SELECT SUM(installment_amt) FROM installment WHERE loan_id = " . $this->db->escape($loan['loan_id']) . " AND installment_status = '2'" . $condition);

					$total_installment_until_this_month_rehead += $this->db->getValue("SELECT SUM(installment_amt) FROM installment WHERE loan_id = " . $this->db->escape($loan['loan_id']) . " AND head_id = " . $this->db->escape($this->admin->id) . $condition);
					$total_installment_paid_until_this_month_rehead += $this->db->getValue("SELECT SUM(installment_amt) FROM installment WHERE loan_id = " . $this->db->escape($loan['loan_id']) . " AND head_id = " . $this->db->escape($this->admin->id) . " AND installment_status = '2'" . $condition);

					$total_installment_until_this_month_reoffice += $this->db->getValue("SELECT SUM(installment_amt) FROM installment WHERE loan_id = " . $this->db->escape($loan['loan_id']) . " AND admin_id = " . $this->db->escape($this->admin->id) . $condition);
					$total_installment_paid_until_this_month_reoffice += $this->db->getValue("SELECT SUM(installment_amt) FROM installment WHERE loan_id = " . $this->db->escape($loan['loan_id']) . " AND admin_id = " . $this->db->escape($this->admin->id) . " AND installment_status = '2'" . $condition);
				}
			}
			//BAD DEBT ALL
			$total['total_bad_debt_amount'] = $total_installment_until_this_month - $total_installment_paid_until_this_month;
			$total['total_bad_debt'] = $total_installment_until_this_month <= 0 ? 0 : round($total['total_bad_debt_amount'] / $total_installment_until_this_month * 100);;
			$total['total_installment_until_this_month'] = $total_installment_until_this_month;

			//BAD DEBT RECOVERY HEAD
			$total['total_bad_debt_amount_rehead'] = $total_installment_until_this_month_rehead - $total_installment_paid_until_this_month_rehead;
			$total['total_bad_debt_rehead'] = $total_installment_until_this_month_rehead <= 0 ? 0 : round($total['total_bad_debt_amount_rehead'] / $total_installment_until_this_month_rehead * 100);;
			$total['total_installment_until_this_month_rehead'] = $total_installment_until_this_month_rehead;

			//BAD DEBT RECOVERY OFFICER
			$total['total_bad_debt_amount_reoffice'] = $total_installment_until_this_month_reoffice - $total_installment_paid_until_this_month_reoffice;
			$total['total_bad_debt_reoffice'] = $total_installment_until_this_month_reoffice <= 0 ? 0 : round($total['total_bad_debt_amount_reoffice'] / $total_installment_until_this_month_reoffice * 100);;
			$total['total_installment_until_this_month_reoffice'] = $total_installment_until_this_month_reoffice;

			$year_of_collection = $this->db->getValue("SELECT SUM(installment_amt) FROM installment WHERE installment_status = '2' AND loan_id IN (" . implode(',', $my_loan_ids) . ") AND YEAR(loan_date) = '" . date('Y') . "'");
			$year_of_collection_count = $this->db->getValue("SELECT COUNT(*) FROM installment WHERE installment_status = '2' AND loan_id IN (" . implode(',', $my_loan_ids) . ") AND YEAR(loan_date) = '" . date('Y') . "'");

			$total['year_of_collection'] = $year_of_collection;
			$total['year_of_collection_count'] = $year_of_collection_count;

		$total['recovery_sum'] = $recovery_pending['total'];
		$total['recovery_count'] = $recovery_pending['count_recovery'];
		$total['visitors'] = "100";
		$total['applicationtoday'] = "200";
		$total['inquirytoday'] = "10";
		$total['pledge'] = "30";
		$total['signup'] = "10";
		$total['signupborrower'] = "10";
		$total['signuplender'] = "10";
		$total['signupweek'] = "10";
		$total['signupborrowerweek'] = "10";
		$total['signuplenderweek'] = "10";
		$total['application'] = "50"; //total application
		$total['applicationweek'] = "100";
		$total['pledge'] = "2000";
		$total['pledgeweek'] = "50"; //total pledges this week
		$total['pledge'] = "25";
		$total['pledgeweek'] = "10";
		$total['visitorsweek'] = "20";

		$chart_data = array();
		foreach(range(1, 12) as $m){
			$new_borrower = $this->db->getValue("SELECT COUNT(*) FROM borrowers WHERE created LIKE '" . date('Y-m', mktime(0, 0, 0, $m, 10)) . "%'");
			$total_borrower = $this->db->getValue("SELECT COUNT(*) FROM borrowers WHERE DATE(created) <= '" . date('Y-m-t', mktime(0, 0, 0, $m, 10)) . "'");
			$chart_data[] = array(
				"year" =>  date('Y'),
				"month" =>  date('Y-m', mktime(0, 0, 0, $m, 10)),
				"new" => $new_borrower ? $new_borrower : 0,
				"total" => $total_borrower ? $total_borrower : 0,
			);
		}

		foreach($total as $i => $val){
			if(!$val) $total[$i] = 0;
		}

		set('total', $total);
		set('chart_data', $chart_data);
		return render('home.php', 'layout/default.php');
	}

	//Dashboard - Links
	public function dashboardBadDebt(){
		$this->db->query("SELECT distinct i.admin_id,r.recovery_status,a.admin_name,i.head_id
	FROM installment i,recovery r, user_admins a
	 WHERE i.installment_id=r.installment_id 
	 AND r.recovery_status=2 
	 AND a.admin_id=i.admin_id
	 ORDER BY a.admin_name ASC
		
");
		$selectofficername = $this->db->getRowList();
		$admin_id = $this->request('adminID');
		if($admin_id){
			
			$this->db->query("SELECT a.*,b.loan_id,b.date_created,b.loan_status,c.admin_name,d.full_name FROM installment a, loan b, user_admins c, borrowers d
			WHERE a.installment_status IN ('1','3','4')
			AND (a.Months = DATE_FORMAT(CURRENT_DATE + INTERVAL 1 MONTH, '%m') AND a.Year = DATE_FORMAT(CURRENT_DATE, '%Y') OR a.loan_date < CURRENT_DATE + INTERVAL 1 MONTH)
			AND a.loan_id = b.loan_id
			AND b.loan_status <> 99
			AND b.loan_status <> 0
			AND a.borrower_id=d.borrower_id
			AND a.admin_id = c.admin_id			
			AND YEAR(a.loan_date) <= ". date('Y') ." AND MONTH(a.loan_date) <= ". date('m') ." AND a.admin_id = '" . $admin_id . "' 
			ORDER BY a.loan_date ASC
		
			");
			$recovery = $this->db->getRowList();
			if($recovery){
				foreach($recovery as $i => $key){
					$this->db->query("SELECT full_name,agent_id FROM borrowers WHERE borrower_id = " .$this->db->escape($recovery[$i]['borrower_id']));
					$borrower = $this->db->getSingleRow();
	
					$recovery[$i]['borrower'] = $borrower['full_name'];
	
					$this->db->query("SELECT admin_name FROM user_admins WHERE admin_id = " .$this->db->escape($recovery[$i]['admin_id']));
					$officer = $this->db->getSingleRow();
	
					if(isset($officer['admin_name'])){
						$recovery[$i]['officer'] = $officer['admin_name'];
					}
				}
			}
		}
		else{
		$this->db->query("SELECT a.*,b.loan_id,b.date_created,b.loan_status,c.admin_name,d.full_name FROM installment a, loan b, user_admins c,borrowers d
							WHERE a.installment_status IN ('1','3','4')
							AND (a.Months = DATE_FORMAT(CURRENT_DATE + INTERVAL 1 MONTH, '%m') AND a.Year = DATE_FORMAT(CURRENT_DATE, '%Y') OR a.loan_date < CURRENT_DATE + INTERVAL 1 MONTH)
							AND a.loan_id = b.loan_id
							AND b.loan_status <> 99
							AND b.loan_status <> 0
							AND a.admin_id = c.admin_id
							AND a.borrower_id=d.borrower_id
							AND YEAR(a.loan_date) <= ". date('Y') ." AND MONTH(a.loan_date) <= ". date('m') ."
							ORDER BY a.loan_date ASC
						");
		$recovery = $this->db->getRowList();

		if($recovery){
			foreach($recovery as $i => $key){
				$this->db->query("SELECT full_name,agent_id FROM borrowers WHERE borrower_id = " .$this->db->escape($recovery[$i]['borrower_id']));
				$borrower = $this->db->getSingleRow();

				$recovery[$i]['borrower'] = $borrower['full_name'];

				$this->db->query("SELECT admin_name FROM user_admins WHERE admin_id = " .$this->db->escape($recovery[$i]['admin_id']));
				$officer = $this->db->getSingleRow();

				if(isset($officer['admin_name'])){
					$recovery[$i]['officer'] = $officer['admin_name'];
				}
			}
		}
		}
		if($this->request('exportofficer'))
		{


			$content[] = array(
				'No.',
				'Borrower Name',
				'Loan ID',
				'Payment Date',
				'Month',
				'Recovery Officer',
				'Collection Amount'

			);

			foreach($recovery as $i => $key){
				
				$officername=$key['admin_name'];
				$this->db->query("SELECT * FROM borrowers WHERE borrower_id = " .$this->db->escape($key['borrower_id']). "");
				$borrower = $this->db->getSingleRow();

				$borrower_name = $borrower['full_name'];

				if($key['admin_id'] == $this->admin->id){
					if($key['paid_for'] == '1'){
						$key['paid_for'] = "Both (Principal + Interest)";
					}
					if($key['paid_for'] == '2'){
						$key['paid_for'] = "Interest Amount";
					}
					if($key['paid_for'] == '3'){
						$key['paid_for'] = "Rescheduling";
					}
					if($key['paid_for'] == '4'){
						$key['paid_for'] = "Partial Payment";
					}
					if($key['paid_for'] == '5'){
						$key['paid_for'] = "Late Charges";
					}
					if($key['paid_for'] == '6'){
						$key['paid_for'] = "Full Settlement";
					}
					if($key['admin_id'] == '346'){
						$key['admin_id'] = "Recovery Officer 1";
					}
					if($key['admin_id'] == '347'){
						$key['admin_id'] = "Recovery Officer 2";
					}
					if($key['admin_id'] == '348'){
						$key['admin_id'] = "Recovery Officer 3";
					}
					if($key['admin_id'] == '352'){
						$key['admin_id'] = "Recovery Officer 4";
					}
					if($key['Months'] == '1'){
						$key['Months'] = "JANUARY";
					}
					if($key['Months'] == '2'){
						$key['Months'] = "FEBRUARY";
					}
					if($key['Months'] == '3'){
						$key['Months'] = "MARCH";
					}
					if($key['Months'] == '4'){
						$key['Months'] = "APRIL";
					}
					if($key['Months'] == '5'){
						$key['Months'] = "MAY";
					}
					if($key['Months'] == '6'){
						$key['Months'] = "JUNE";
					}
					if($key['Months'] == '7'){
						$key['Months'] = "JULY";
					}
					if($key['Months'] == '8'){
						$key['Months'] = "AUGUST";
					}
					if($key['Months'] == '9'){
						$key['Months'] = "SEPTEMBER";
					}
					if($key['Months'] == '10'){
						$key['Months'] = "OCTOBER";
					}
					if($key['Months'] == '11'){
						$key['Months'] = "NOVEMBER";
					}
					if($key['Months'] == '12'){
						$key['Months'] = "DECEMBER";
					}
						
					$content[] = array(
						$i+1,
						$key['full_name'],
						substr($key['date_created'], 0, 4) . '0' . $key['loan_id'],
						$key['payment_date'],
						$key['Months'] ,
						$key['admin_name'],
						$key['installment_amt'],
						
					);

				}
				if($key['head_id'] == $this->admin->id){
					if($key['paid_for'] == '1'){
						$key['paid_for'] = "Both (Principal + Interest)";
					}
					if($key['paid_for'] == '2'){
						$key['paid_for'] = "Interest Amount";
					}
					if($key['paid_for'] == '3'){
						$key['paid_for'] = "Rescheduling";
					}
					if($key['paid_for'] == '4'){
						$key['paid_for'] = "Partial Payment";
					}
					if($key['paid_for'] == '5'){
						$key['paid_for'] = "Late Charges";
					}
					if($key['paid_for'] == '6'){
						$key['paid_for'] = "Full Settlement";
					}
					if($key['admin_id'] == '346'){
						$key['admin_id'] = "Recovery Officer 1";
					}
					if($key['admin_id'] == '347'){
						$key['admin_id'] = "Recovery Officer 2";
					}
					if($key['admin_id'] == '348'){
						$key['admin_id'] = "Recovery Officer 3";
					}
					if($key['admin_id'] == '352'){
						$key['admin_id'] = "Recovery Officer 4";
					}
					if($key['Months'] == '1'){
						$key['Months'] = "JANUARY";
					}
					if($key['Months'] == '2'){
						$key['Months'] = "FEBRUARY";
					}
					if($key['Months'] == '3'){
						$key['Months'] = "MARCH";
					}
					if($key['Months'] == '4'){
						$key['Months'] = "APRIL";
					}
					if($key['Months'] == '5'){
						$key['Months'] = "MAY";
					}
					if($key['Months'] == '6'){
						$key['Months'] = "JUNE";
					}
					if($key['Months'] == '7'){
						$key['Months'] = "JULY";
					}
					if($key['Months'] == '8'){
						$key['Months'] = "AUGUST";
					}
					if($key['Months'] == '9'){
						$key['Months'] = "SEPTEMBER";
					}
					if($key['Months'] == '10'){
						$key['Months'] = "OCTOBER";
					}
					if($key['Months'] == '11'){
						$key['Months'] = "NOVEMBER";
					}
					if($key['Months'] == '12'){
						$key['Months'] = "DECEMBER";
					}
					$content[] = array(
						$i+1,
						$key['full_name'],
						substr($key['date_created'], 0, 4) . '0' . $key['loan_id'],
						$key['payment_date'],
						$key['Months'] ,
						$key['admin_name'],
						$key['installment_amt'],
					);

				}
				if ($key['admin_id']==(($this->admin->role == '1' || $this->admin->role == '2' || $this->admin->role_type == '1')))
				{
					if($key['paid_for'] == '1'){
						$key['paid_for'] = "Both (Principal + Interest)";
					}
					if($key['paid_for'] == '2'){
						$key['paid_for'] = "Interest Amount";
					}
					if($key['paid_for'] == '3'){
						$key['paid_for'] = "Rescheduling";
					}
					if($key['paid_for'] == '4'){
						$key['paid_for'] = "Partial Payment";
					}
					if($key['paid_for'] == '5'){
						$key['paid_for'] = "Late Charges";
					}
					if($key['paid_for'] == '6'){
						$key['paid_for'] = "Full Settlement";
					}
					if($key['admin_id'] == '346'){
						$key['admin_id'] = "Recovery Officer 1";
					}
					if($key['admin_id'] == '347'){
						$key['admin_id'] = "Recovery Officer 2";
					}
					if($key['admin_id'] == '348'){
						$key['admin_id'] = "Recovery Officer 3";
					}
					if($key['admin_id'] == '352'){
						$key['admin_id'] = "Recovery Officer 4";
					}
					if($key['Months'] == '1'){
						$key['Months'] = "JANUARY";
					}
					if($key['Months'] == '2'){
						$key['Months'] = "FEBRUARY";
					}
					if($key['Months'] == '3'){
						$key['Months'] = "MARCH";
					}
					if($key['Months'] == '4'){
						$key['Months'] = "APRIL";
					}
					if($key['Months'] == '5'){
						$key['Months'] = "MAY";
					}
					if($key['Months'] == '6'){
						$key['Months'] = "JUNE";
					}
					if($key['Months'] == '7'){
						$key['Months'] = "JULY";
					}
					if($key['Months'] == '8'){
						$key['Months'] = "AUGUST";
					}
					if($key['Months'] == '9'){
						$key['Months'] = "SEPTEMBER";
					}
					if($key['Months'] == '10'){
						$key['Months'] = "OCTOBER";
					}
					if($key['Months'] == '11'){
						$key['Months'] = "NOVEMBER";
					}
					if($key['Months'] == '12'){
						$key['Months'] = "DECEMBER";
					}
					$content[] = array(
						$i+1,
						$key['full_name'],
						substr($key['date_created'], 0, 4) . '0' . $key['loan_id'],
						$key['payment_date'],
						$key['Months'] ,
						$key['admin_name'],
						$key['installment_amt'],

					);

				}
			}

			header('Content-Encoding: UTF-8');
			header('Content-Type: text/csv; charset=UTF-8');
			header('Content-Disposition: attachment;filename="report_baddebt_('.$officername.').csv"');
			header('Cache-Control: max-age=0');

			$fp = fopen('php://output', 'wb');
			//fprintf($fp, chr(0xEF).chr(0xBB).chr(0xBF));

			foreach ($content as $line) {
				fputcsv($fp, $line, ',');
			}
			fclose($fp);
			exit();
		}

		set('recovery',$recovery);
		set('selectofficername',$selectofficername);
		set('admin_id',$admin_id);
		return render('dashboard/dashboard-bad-debt.php', 'layout/default.php');
	}

	public function dashboardCollection(){
		$this->db->query("SELECT a.*,b.loan_id,b.date_created,b.loan_status,c.agent_id FROM installment a, loan b, borrowers c
							WHERE a.installment_status IN ('2')
							AND (a.Months = DATE_FORMAT(CURRENT_DATE + INTERVAL 1 MONTH, '%m') AND a.Year = DATE_FORMAT(CURRENT_DATE, '%Y') OR a.loan_date < CURRENT_DATE + INTERVAL 1 MONTH)
							AND a.loan_id = b.loan_id
							AND b.loan_status <> 99
							AND b.loan_status <> 0
							AND b.loan_status <> 990
							AND a.borrower_id = c.borrower_id
							AND YEAR(a.loan_date) <= ". date('Y') ." AND MONTH(a.loan_date) <= ". date('m') ."
							ORDER BY a.loan_date ASC
						");
		$recovery = $this->db->getRowList();

		if($recovery){
			foreach($recovery as $i => $key){
				$this->db->query("SELECT full_name,agent_id FROM borrowers WHERE borrower_id = " .$this->db->escape($recovery[$i]['borrower_id']));
				$borrower = $this->db->getSingleRow();

				$recovery[$i]['borrower'] = $borrower['full_name'];

				$this->db->query("SELECT admin_name FROM user_admins WHERE admin_id = " .$this->db->escape($recovery[$i]['admin_id']));
				$officer = $this->db->getSingleRow();

				if(isset($officer['admin_name'])){
					$recovery[$i]['officer'] = $officer['admin_name'];
				}
			}
		}
		set('recovery',$recovery);
		return render('dashboard/dashboard-collection.php', 'layout/default.php');
	}

	public function dashboardRecovered(){
		$this->db->query("SELECT a.*,b.full_name,c.installment_status FROM recovery a, borrowers b, installment c
						WHERE a.recovery_status = 2
						AND b.borrower_id=a.borrower_id 
						AND a.installment_id= c.installment_id
						
						");
		$risk = $this->db->getRowList();

		set('risk',$risk);
		return render('dashboard/dashboard-recovered.php', 'layout/default.php');
	}

	public function dashboardYearCollection(){
		$this->db->query("SELECT a.*,b.full_name,c.installment_status,d.loan_id,d.loan_status FROM recovery a, borrowers b, installment c, loan d
						WHERE a.recovery_status = 2
						AND a.loan_id=d.loan_id   
						AND b.borrower_id=a.borrower_id 
						AND a.installment_id= c.installment_id
						AND d.loan_status IN ('1','8')
						AND YEAR(c.loan_date) = '" . date('Y') . "'
						
						");
		$risk = $this->db->getRowList();

		set('risk',$risk);
		return render('dashboard/dashboard-year-collection.php', 'layout/default.php');
	}

	public function dashboardNewBorrowers(){
		$this->db->query("SELECT borrower_id,full_name,agent_id,nric_new,wanted_remarks,created,borrower_status,source,pending_approval,rejection FROM borrowers 
						  WHERE agent_id = ''
						  AND borrower_status <> 99
						  ORDER BY created DESC
						  
						  ");
		$keys = $this->db->getRowList();

		if($keys){
			foreach($keys as $i => $key){
				$this->db->query("SELECT admin_id,admin_name FROM user_admins WHERE admin_id = " .$this->db->escape($key['agent_id']));
				$user = $this->db->getSingleRow();

				if(isset($user['admin_name'])){
					$keys[$i]['agent'] = $user['admin_name'];
				}
			}
		}
		set('keys', $keys);
		return render('dashboard/dashboard-new-borrowers.php', 'layout/default.php');
	}

	public function dashboardTotalBorrowers(){
		$this->db->query("SELECT borrower_id,full_name,agent_id,nric_new,wanted_remarks,created,borrower_status,source,pending_approval,rejection FROM borrowers 
						  WHERE borrower_status <> 99
						  ORDER BY created DESC
						  
						  ");
		$keys = $this->db->getRowList();

		if($keys){
			foreach($keys as $i => $key){
				$this->db->query("SELECT admin_id,admin_name FROM user_admins WHERE admin_id = " .$this->db->escape($key['agent_id']));
				$user = $this->db->getSingleRow();

				if(isset($user['admin_name'])){
					$keys[$i]['agent'] = $user['admin_name'];
				}
			}
		}
		set('keys', $keys);
		return render('dashboard/dashboard-total-borrowers.php', 'layout/default.php');
	}

	public function dashboardActiveBorrowers(){
		$this->db->query("SELECT borrower_id,full_name,agent_id,nric_new,wanted_remarks,created,borrower_status,source,pending_approval,rejection FROM borrowers 
						  WHERE borrower_id IN (SELECT borrower_id FROM loan WHERE loan_status IN (1,8))
						  AND borrower_status <> 99
						  ORDER BY created DESC
						  
						  ");
		$keys = $this->db->getRowList();

		if($keys){
			foreach($keys as $i => $key){
				$this->db->query("SELECT admin_id,admin_name FROM user_admins WHERE admin_id = " .$this->db->escape($key['agent_id']));
				$user = $this->db->getSingleRow();

				if(isset($user['admin_name'])){
					$keys[$i]['agent'] = $user['admin_name'];
				}
			}
		}
		set('keys', $keys);
		return render('dashboard/dashboard-active-borrowers.php', 'layout/default.php');
	}

	public function dashboardTotalLoan(){
		$this->db->query("SELECT * FROM loan WHERE loan_status <> 99 AND loan_status <> 991 ORDER BY FIELD(loan_status,1,8,4,5,2,6,3,7,992,990)");
		$keys = $this->db->getRowList();

		if($keys){
			foreach($keys as $i => $key){
				$this->db->query("SELECT full_name FROM borrowers WHERE borrower_id = " .$this->db->escape($key['borrower_id']));
				$borrower = $this->db->getSingleRow();

				if(isset($borrower['full_name'])){
					$keys[$i]['borrower'] = $borrower['full_name'];
				}
				else{
					$keys[$i]['borrower'] = '';
				}


				$this->db->query("SELECT admin_name FROM user_admins WHERE admin_id = " .$this->db->escape($key['created_by']));
				$user = $this->db->getSingleRow();

				if(isset($user['admin_name'])){
					$keys[$i]['user'] = $user['admin_name'];
				}
				else{
					$keys[$i]['user'] = '';
				}
			}
		}

		set('keys', $keys);
		return render('dashboard/dashboard-total-loan.php', 'layout/default.php');
	}

	public function profile(){
		$this->db->query("SELECT * FROM user_admins WHERE admin_id = ".$this->db->escape($this->admin->id));
		$keys = $this->db->getSingleRow();
		set('keys', $keys);
		return render('settings/profile.php', 'layout/default.php');
	}

	public function admin(){
		$this->db->query("SELECT * FROM user_admins WHERE admin_status < 999");
		$keys = $this->db->getRowList();
		if($keys){
			foreach($keys as $i =>$key)
			{
				$this->db->query("SELECT * FROM admin_role WHERE role_id = ".$keys[$i]['admin_role']."");
				$admin_role = $this->db->getSingleRow();

				if(isset($admin_role['role_name'])){
					$keys[$i]['admin_type'] = $admin_role['role_name'];
				}
			}
		}

		set('admins', $keys);
		return render('settings/admin.php', 'layout/default.php');
	}

	public function adminInsert(){
		$this->db->query("SELECT * FROM admin_role ORDER BY role_id ASC");
		$keys = $this->db->getRowList();

		set('role', $keys);
		return render('settings/admin-insert.php', 'layout/default.php');
	}

	public function adminUpdate($id){
		$this->db->query("SELECT * FROM user_admins WHERE admin_status < 999 AND admin_id = " . $this->db->escape($id));
		$key = $this->db->getSingleRow();

		$this->db->query("SELECT * FROM team_management WHERE officer_id = " . $this->db->escape($id));
		$team = $this->db->getSingleRow();

		$this->db->query("SELECT role_id,role_name,role_status FROM admin_role ORDER BY role_id ASC");
		$role = $this->db->getRowList();

		$this->db->query("SELECT * FROM user_admins WHERE role_type = 2 ORDER BY admin_id ASC");
		$types = $this->db->getRowList();

		if($key){
			set('role', $role);
			set('team', $team);
			set('admin', $key);
			set('type', $types);
			return render('settings/admin-update.php', 'layout/default.php');
		}
	}

	// Role
	public function role(){
		$this->db->query("SELECT * FROM admin_role WHERE role_status < 99");
		$keys = $this->db->getRowList();

		set('roles', $keys);
		return render('settings/role.php', 'layout/default.php');
	}

	public function roleInsert(){
		return render('settings/role-insert.php', 'layout/default.php');
	}

	public function roleUpdate($id){
		$this->db->query("SELECT * FROM admin_role WHERE role_status < 999 AND role_id = " . $this->db->escape($id));
		$key = $this->db->getSingleRow();

		if($key){
			set('role', $key);
			return render('settings/role-update.php', 'layout/default.php');
		}
	}

	public function site_settings(){
		set('no_image', $this->no_image);
		return render('settings/settings.php', 'layout/default.php');
	}



	public function pages(){
		$this->db->query("SELECT * FROM pages ORDER BY title");
		$keys = $this->db->getRowList();

		set('keys', $keys);
		return render('management/pages.php', 'layout/default.php');
	}

	public function pageInsert(){

		return render('management/page-insert.php', 'layout/default.php');

	}

	public function loadApiData(){
		$postdata = json_encode(
			array(
				'username' => 'api@personalbanc.com',
				'password' => '03FC2DA1E597'
			)
		);

		$opts = array('http' =>
			array(
				'method'  => 'POST',
				'header'  => 'Content-type: application/json',
				'content' => $postdata
			)
		);

		$context = stream_context_create($opts);

		$result = file_get_contents('https://applicationdecisioning.ctos.com.my:8443//User/authenticate', false, $context);
		$result=json_decode($result);
		$apiKey= $result->key;
		//first API
		$options = array('http' => array(
			'method'  => 'GET',
			'header' => 'Authorization: Bearer '.$apiKey
		));
		$context  = stream_context_create($options);
		$first_response = file_get_contents('https://applicationdecisioning.ctos.com.my:8443/Record/TruckEventApplication?status=3&pageSize=10000', false, $context);
		$first_response = json_decode($first_response);
		$first_response = $first_response ?: [];

		//second API
		$second_response = file_get_contents('https://applicationdecisioning.ctos.com.my:8443/Record/WalkinOnlineApplication?status=approved&pageSize=10000', false, $context);
		$second_response = json_decode($second_response);
		$second_response = $second_response ?: [];
		//   echo '<pre>'; print_r($second_response);exit;
		$response = [];
		$response=array_merge($first_response,$second_response);
		$external_data=array();
		

		foreach($response as $k=>$v){
			$data=$v->data;

			$this_array=array();
			$this_array['borrower_id']=str_replace("-","",$data->nric);

			$this_array['full_name']=$data->fullname;
			$this_array['agent_id']='';
			$this_array['nric_new']=$data->nric;
			$this_array['created']=date('Y-m-d H:i:s', strtotime($data->createdAt));
			$this_array['wanted_remarks']='';
			$this_array['borrower_status']=5;
			$this_array['pending_approval']='';
			$this_array['rejection']='';
			$this_array['source']=2;
			$this_array['new']=1;
			$this_array['marital']=$data->maritalstatus;
			$this_array['race']=$data->race;
			$this_array['dob']=$data->dateofbirth;
			$this_array['nationality']=$data->nationality;




			$loan_array=array();
			$loan_array['api_id']=str_replace("-","",$v->id);
			$loan_array['borrower_id']=str_replace("-","",$data->nric);
			$loan_array['loan_amt']=$data->loanamount;
			$loan_array['loan_term']=$data->loanterminmonths;
			$loan_array['date_created']=date('Y-m-d H:i:s', strtotime($data->createdAt));
			$loan_array['loan_date']=date('Y-m-d H:i:s', strtotime($data->createdAt));
			$loan_array['principal_paid_date']=date('Y-m-d H:i:s', strtotime($data->createdAt));
			$loan_array['loan_interest_month']=$data->interestrate;
			$loan_array['principal_paid']=$data->principalmyr;
			$loan_array['loan_status']=991;
			$loan_array['created_by']=1;

			$sql="SELECT * FROM loan WHERE api_id='".str_replace("-","",$v->id)."'";
			$this->db->query($sql);
			$check_loan_existance=$this->db->getRowList();
			if(empty($check_loan_existance)){
				$this->db->table("loan");
				$this->db->insertArray($loan_array);
				$this->db->insert();
			}


			$sql="SELECT * FROM borrowers WHERE borrower_id='".str_replace("-","",$data->nric)."'";
			$this->db->query($sql);
			$check_existance=$this->db->getRowList();
			// echo '<pre>'; print_r($check_existance);exit;
			if(empty($check_existance)){
				$this->db->table("borrowers");
				$this->db->insertArray($this_array);
				$this->db->insert();
				//for borrwer contact
				$contact_array=array();
				$contact_array['contact_id']=md5(uniqid(rand(), true));
				$contact_array['borrower_id']=str_replace("-","",$data->nric);
				$contact_array['status']=1;
				$contact_array['mobile_number']=$data->handphoneno;
				$contact_array['address']=$data->address;

				$this->db->table("borrower_contacts");
				$this->db->insertArray($contact_array);
				$this->db->insert();

				//for borrwer employment
				$employment_array=array();
				$employment_array['employment_id']=md5(uniqid(rand(), true));
				$employment_array['borrower_id']=str_replace("-","",$data->nric);
				$employment_array['status']=1;
				$employment_array['employer_name']=$data->employerbusinessname;
				$employment_array['designation']=$data->occupationjobtitle;
				$employment_array['pay_date']=$data->paymentdate;
				$employment_array['phone']=$data->officetelephoneno;
				$employment_array['salary_range']=$data->salary;
				$employment_array['hired_on']=$data->startdate;
				$employment_array['address']=$data->companyaddress;
				$employment_array['phone']=$data->officetelephoneno;



				$this->db->table("borrower_employments");
				$this->db->insertArray($employment_array);
				$this->db->insert();

				//for borrower gurrantor
				$guarantor_array=array();
				$guarantor_array['guarantor_id']=md5(uniqid(rand(), true));
				$guarantor_array['borrower_id']=str_replace("-","",$data->nric);
				$guarantor_array['status']=1;
				$guarantor_array['full_name']=$data->guarantor1name;
				$guarantor_array['nric_new']=$data->guarantor1nric;
				$guarantor_array['relation']=$data->guarantor1relationshiptoborrower;
				$guarantor_array['mobile1']=$data->guarantor1handphoneno;
				$guarantor_array['designation']=$data->guarantor1occupationjobtitle;
				$guarantor_array['employer_name']=$data->guarantor1employerbusinessname;
				$guarantor_array['employer_address']=$data->guarantor1companyaddress;
				$guarantor_array['phone']=$data->guarantor1officetelephoneno;
				$guarantor_array['hired_on']=$data->guarantor1startdate;







				$this->db->table("borrower_guarantors");
				$this->db->insertArray($guarantor_array);
				$this->db->insert();

				//for borrower reference
				$references_array=array();
				$references_array['reference_id']=md5(uniqid(rand(), true));
				$references_array['borrower_id']=str_replace("-","",$data->nric);
				$references_array['status']=1;
				$references_array['full_name']=$data->references1name;
				$references_array['nric_new']=$data->references1nric;
				$references_array['relation']=$data->references1relationshiptoborrower;
				$references_array['mobile1']=$data->references1handphoneno;
				$references_array['designation']=$data->references1occupationjobtitle;
				$references_array['employer_name']=$data->references1employerbusinessname;
				$references_array['employer_address']=$data->references1companyaddress;
				$references_array['phone']=$data->references1officetelephoneno;
				$references_array['hired_on']=$data->references1startdate;



				$this->db->table("borrower_references");
				$this->db->insertArray($references_array);
				$this->db->insert();


				//for borrrower spouse details
				$spouse_array=array();
				$spouse_array['spouse_id']=md5(uniqid(rand(), true));
				$spouse_array['borrower_id']=str_replace("-","",$data->nric);
				$spouse_array['status']=1;
				$spouse_array['full_name']=$data->spousename;
				$spouse_array['nric_new']=$data->spousenric;
				
				// $spouse_array['nric_new']='';
				// $spouse_array['mobile1']=$data->spousehandphoneno;



				$this->db->table("borrowers_spouse_details");
				$this->db->insertArray($spouse_array);
				$this->db->insert();

				//for borrrower spouse employment details
				$spouse_employment_array=array();
				$spouse_employment_array['employment_id']=md5(uniqid(rand(), true));
				$spouse_employment_array['borrower_id']=str_replace("-","",$data->nric);
				$spouse_employment_array['status']=1;
				$spouse_employment_array['employer_name']=$data->spouseemployerbusinessname;
				$spouse_employment_array['designation']=$data->spouseoccupationjobtitle;
				$spouse_employment_array['pay_date']='';
				$spouse_employment_array['phone']=$data->spouseofficetelephoneno;
				$spouse_employment_array['salary_range']=$data->spousesalary;
				$spouse_employment_array['hired_on']=$data->spouseemploymentstartdate;
				$spouse_employment_array['address']=$data->spousecompanyaddress;



				$this->db->table("borrower_spouse_employments");
				$this->db->insertArray($spouse_employment_array);
				$this->db->insert();

			}else{

				if(empty($check_loan_existance)){
					$sql="SELECT * FROM borrowers WHERE borrower_status='1' AND borrower_id='".str_replace("-","",$data->nric)."'";
					$this->db->query($sql);
					$check_status=$this->db->getRowList();

					if(!empty($check_status)){
						// echo '<pre>'; print_r($check_status[0]);exit;
						$this->db->table("loan");
						$this->db->updateArray(array(
							"loan_status" => 2,
							"officer_id" => $check_status[0]['agent_id'],
						));
						$this->db->whereArray(array(
							"api_id" => str_replace("-","",$v->id),
						));
						$this->db->update();
					}
				}

			}

		}
	}

	// Borrowers - LMS
	public function borrowers(){
		// $this->loadApiData();

		if($this->admin->mapproval == '1'){
			$this->db->query("SELECT borrower_id,full_name,agent_id,nric_new,wanted_remarks,created,borrower_status,source,pending_approval,rejection FROM borrowers WHERE borrower_status=1 OR borrower_status=2 OR borrower_status=3 OR borrower_status=4 OR borrower_status=5 ORDER BY FIELD(borrower_status,2,1,3,5,4), full_name ASC");
			$keys = $this->db->getRowList();
		}
		else{
			$this->db->query("SELECT borrower_id,full_name,agent_id,nric_new,wanted_remarks,created,borrower_status,source,pending_approval,rejection FROM borrowers WHERE borrower_status=1 OR borrower_status=2 OR borrower_status=3 OR borrower_status=4 OR borrower_status=5 ORDER BY FIELD(borrower_status,3,5,4,2,1), full_name ASC");
			$keys = $this->db->getRowList();
		}
//		$this->db->query("SELECT borrower_id,full_name,agent_id,rejection,nric_new,wanted_remarks,created,borrower_status,source,pending_approval FROM borrowers ORDER BY borrower_status DESC, pending_approval DESC, created DESC, full_name ASC");
//		$keys = $this->db->getRowList();

//		foreach($keys as $key){
//			if($key['borrower_status'] == '0'){
//				$this->db->table("borrowers");
//				$this->db->updateArray(array(
//					"borrower_status" => '4',
//				));
//				$this->db->whereArray(array(
//					"borrower_id" => $key['borrower_id'],
//				));
//				$this->db->update();
//			}
//		}

		if($keys){
			foreach($keys as $i => $key){
				$this->db->query("SELECT admin_id,admin_name FROM user_admins WHERE admin_id = " .$this->db->escape($key['agent_id']));
				$user = $this->db->getSingleRow();

				if(isset($user['admin_name'])){
					$keys[$i]['agent'] = $user['admin_name'];
				}
			}
		}

		set('keys', $keys);

		return render('modules/borrowers.php', 'layout/default.php');
	}

	public function borrowerExport(){
		$pdf = new FPDF();
		$pdf->AddPage();
		$pdf->SetFont('Arial','B',16);
		$pdf->Cell(40,10,'Hello World!');
		$pdf->Output();
	}

	public function borrowerInsert(){

		$this->db->query("SELECT admin_id,admin_name FROM user_admins WHERE role_type = 3 AND admin_status = 1");
		$agents= $this->db->getRowList();

		$states = $this->state('129');

		set('countries', $this->countries());
		set('agents', $agents);
		return render('modules/borrowers-insert.php', 'layout/default.php');
	}

	public function borrowerDetailsExport($id){
			$this->db->query("SELECT * FROM borrowers WHERE borrower_id = " . $this->db->escape($id));
			$borrower = $this->db->getSingleRow();
			if($borrower){
				$w = array(65, 65, 65);
				$pdf = new FPDF();
				$pdf->SetFont('Arial','',10);
				$page = 1;

				$pdf->AddPage();
				$pdf->SetFont('Arial','',13);
				$pdf->Cell(array_sum($w),10,'BORROWER PROFILE ',0,0,'C');
				$pdf->Ln();
				$pdf->SetFont('Arial','',10);
				$this->db->query("SELECT * FROM files WHERE parent_id = " .$this->db->escape($id));
				$files = $this->db->getRowList();
				$profile_image = [];
				$other_image = [];
				foreach($files as $key => $val){
					if($val["profile_photo"] == "y"){
						array_push($profile_image, $val);
					}else{
						array_push($other_image, $val);
					}
				}

				$x = 10;
				$y = 25;
				$pdf->Ln();
				$i = 1;


				try{
					//print_r($other_image);
					//$pdf->Image('http://chart.googleapis.com/chart?cht=p3&chd=t:60,40&chs=250x100&chl=Hello|World',60,30,90,0,'PNG');
					foreach ($profile_image as $profile){
						if($profile['filename'] != '> ' || $profile['filename'] != ''){
							$pdf->Image('upload/images/'.str_replace("%20", " ",$profile['filename']), $x, $y, 40, 40);
						}
						//$pdf->Image('http://chart.googleapis.com/chart?cht=p3&chd=t:60,40&chs=250x100&chl=Hello|World',60,30,90,0,'PNG');
						//$pdf->Image('http://chart.googleapis.com/chart?cht=p3&chd=t:60,40&chs=250x100&chl=Hello|World',60,30,90,0,'PNG');

						//$pdf->Cell($w[0],10,'PROFILE : <img src="'.$profile['filename'].'"',1,0,'LR');
						$i += 1;
					}
				}
				catch(Exception $e){

				}

				try{
				foreach ($other_image as $other){
					$x += 60;
					if($other['filename'] == '> ' || $other['filename'] == ''){
						//do nothing
					}
					else{
						$pdf->Image('upload/images/'.str_replace("%20", " ",$other['filename']), $x, $y, 40, 40);
					}
					$i += 1;

					//$pdf->Image('../../upload/images/receipts/'.$other['filename'].',10,12,30,0,'','http://www.fpdf.org');
					//$pdf->Cell($w[0],10,'PROFILE : <img src="'.$profile['filename'].'"',1,0,'LR');
				}
				}
				catch(Exception $e){

				}

				$pdf->Ln();
				$pdf->Ln();
				$pdf->Ln();
				$pdf->Ln();
				$pdf->Ln();

				$pdf->SetFont('Arial','B',10);
				$pdf->setFillColor(200,200,200);

				$pdf->Cell(array_sum($w),10,'BORROWER INFORMATION ',1,0,'LR', 1);

				$pdf->Ln();
				$pdf->SetFont('Arial','',10);



				if($borrower['agent_id']){
					$this->db->query("SELECT admin_id,admin_name FROM user_admins WHERE admin_id = ".$this->db->escape($borrower['agent_id']));
					$agent = $this->db->getSingleRow();
				}
				else{
					$agent['admin_name'] = '';
				}

				$borrower['nationality'] = !empty($borrower['nationality']) ? $borrower['nationality'] : 129;
				$states = $this->state($borrower['nationality']);

				$this->db->query("SELECT name FROM country WHERE id = ".$this->db->escape($borrower['nationality']));
				$country = $this->db->getSingleRow();

				if(empty($country['name'])){
					$country['name'] = 'Malaysia';
				}
				if(empty($agent['admin_name'])){
					$agent['admin_name'] = '';
				}

				$pdf->Cell(array_sum($w),10,'FULL NAME : '.strtoupper($borrower['full_name']),1,0,'LR');
				$pdf->Ln();
				$pdf->Cell(array_sum($w),10,'RECOVERY : '.strtoupper($agent['admin_name']),1,0,'LR');
				$pdf->Ln();
				$pdf->Cell($w[0],10,'MARITAL STATUS : '.strtoupper($borrower['marital']),1,0,'LR');
				$pdf->Cell($w[0],10,'RACE : ' .strtoupper($borrower['race']),1,0,'LR');
				$pdf->Cell($w[0],10,'GENDER : ' .strtoupper($borrower['gender']),1,0,'LR');
				$pdf->Ln();
				$pdf->Cell($w[0],10,'NRIC(NEW) : '.strtoupper($borrower['nric_new']),1,0,'LR');
				$pdf->Cell($w[0],10,'NATIONALITY : '.strtoupper($country['name']),1,0,'LR');
				$pdf->Cell($w[0],10,'DOB : ' .$borrower['dob'],1,0,'LR');
				$pdf->Ln();
				$pdf->Cell(array_sum($w),10,'NRIC(OLD) : '.strtoupper($borrower['nric_old']),1,0,'LR');
				$pdf->Ln();
				$pdf->Ln();

				$this->db->query("SELECT * FROM borrower_contacts WHERE borrower_id = " . $this->db->escape($id));
				$borrower['contacts']= $this->db->getRowList();

				$pdf->setFillColor(200,200,200);
				$pdf->SetFont('Arial','B',10);
				$pdf->Cell(array_sum($w),10,'CONTACT INFORMATION ',1,0,'C', 1);
				$pdf->SetFont('Arial','',10);
				$pdf->Ln();
				$pdf->Ln();
				$contact_count = 1;
				foreach($borrower['contacts'] as $contact){
					$pdf->setFillColor(230,230,230);
					$pdf->Cell(array_sum($w),10,'CONTACT '.$contact_count,1,0,'C', 1);
					$pdf->Ln();
					$pdf->Multicell(array_sum($w),5,'ADDRESS :  '.strtoupper($contact['address']),1,'LR');

					$pdf->Cell(array_sum($w),10,'PHONE :  '.strtoupper($contact['mobile_number']),1,0,'LR');
					$pdf->Ln();
					$contact_count += 1;
				}

				$this->db->query("SELECT * FROM borrower_employments WHERE borrower_id = " . $this->db->escape($id));
				$borrower['employments']= $this->db->getRowList();

				$pdf->Ln();
				$pdf->SetFont('Arial','B',10);
				$pdf->setFillColor(200,200,200);
				$pdf->Cell(array_sum($w),10,'EMPLOYMENT',1,0,'C', 1);
				$pdf->SetFont('Arial','',10);
				$employment_count = 1;
					$pdf->Ln();
				foreach($borrower['employments'] as $employment){
					$pdf->Ln();
						$pdf->setFillColor(230,230,230);
					$pdf->Cell(array_sum($w),10,'EMPLOYMENT '.$employment_count,1,0,'C', 1);
					$pdf->Ln();
					$pdf->Cell(array_sum($w),10,'EMPLOYER :  '.strtoupper($employment['employer_name']),1,0,'LR');
					$pdf->Ln();
					$pdf->Cell(array_sum($w),10,'DESIGNATION :  '.strtoupper($employment['designation']),1,0,'LR');
					$pdf->Ln();
					$pdf->Cell($w[0], 10,'PAY DATE :  '.strtoupper($employment['pay_date']),1,0,'LR');
					$pdf->Cell($w[0], 10,'ADVANCED PAY DATE :  '.strtoupper($employment['advance_date']),1,0,'LR');
					$pdf->Cell($w[0], 10,'PHONE :  '.strtoupper($employment['phone']),1,0,'LR');
					$pdf->Ln();
					$employment_count += 1;
				}

				$this->db->query("SELECT * FROM borrowers_spouse_details WHERE borrower_id = " . $this->db->escape($id));
				$borrower['spouses']= $this->db->getRowList();

				$pdf->Ln();
				$pdf->Ln();
				$pdf->setFillColor(200,200,200);
				$pdf->SetFont('Arial','B',10);
				$pdf->Cell(array_sum($w),10,'SPOUSE',1,0,'C', 1);
				$pdf->SetFont('Arial','',10);
				$spouse_count = 1;
					$pdf->Ln();
				foreach($borrower['spouses'] as $spouse){
					$pdf->Ln();
					$pdf->setFillColor(230,230,230);
					$pdf->Cell(array_sum($w),10,'SPOUSE '.$spouse_count,1,0,'C',1);
					$pdf->Ln();
					$pdf->Cell(array_sum($w),10,'FULL NAME :  '.strtoupper($spouse['full_name']),1,0,'LR');
					$pdf->Ln();
					$pdf->Cell(array_sum($w), 10,'NRIC(NEW) :  '.strtoupper($spouse['nric_new']),1,0,'LR');
					$pdf->Ln();

					$this->db->query("SELECT * FROM borrower_spouse_contacts WHERE spouse_id = " . $this->db->escape($spouse['spouse_id']));
					$borrower['spouse_contacts']= $this->db->getRowList();

					foreach($borrower['spouse_contacts'] as $contact){
						$pdf->Cell(array_sum($w), 10,'MOBILE :  '.$contact['mobile'],1,0,'LR');
					}

					$pdf->Ln();
					$spouse_count += 1;
				}


				$this->db->query("SELECT * FROM borrower_spouse_employments WHERE borrower_id = " . $this->db->escape($id));
				$borrower['spouses_employment']= $this->db->getRowList();

				$pdf->Ln();
				$pdf->Ln();
				$pdf->setFillColor(200,200,200);
				$pdf->SetFont('Arial','B',10);
				$pdf->Cell(array_sum($w),10,'SPOUSE EMPLOYMENT',1,0,'C', 1);
				$pdf->SetFont('Arial','',10);
				$spouse_employment_count = 1;
					$pdf->Ln();
				foreach($borrower['spouses_employment'] as $spouse){
					$pdf->Ln();
					$pdf->setFillColor(230,230,230);
					$pdf->Cell(array_sum($w),10,'SPOUSE EMPLOYMENT '.$spouse_employment_count,1,0,'C', 1);
					$pdf->Ln();
					$pdf->Cell(array_sum($w),10,'EMPLOYER NAME :  '.strtoupper($spouse['employer_name']),1,0,'LR');
					$pdf->Ln();
					$pdf->Cell(array_sum($w), 10,'DESIGNATION :  '.strtoupper($spouse['designation']),1,0,'LR');
					$pdf->Ln();
					$pdf->Cell(array_sum($w), 10,'PAY DATE :  '.strtoupper($spouse['pay_date']),1,0,'LR');
					$pdf->Ln();
					$pdf->Cell(array_sum($w), 10,'PHONE :  '.$spouse['phone'],1,0,'LR');
					$pdf->Ln();
					$spouse_employment_count += 1;
				}

				$this->db->query("SELECT * FROM borrower_guarantors WHERE borrower_id = " . $this->db->escape($id));
				$borrower['guarantors']= $this->db->getRowList();

				$pdf->Ln();
				$pdf->Ln();
				$pdf->setFillColor(200,200,200);
				$pdf->SetFont('Arial','B',10);
				$pdf->Cell(array_sum($w),10,'GUARANTOR',1,0,'C', 1);
				$pdf->SetFont('Arial','',10);
				$guarantor_count = 1;
					$pdf->Ln();
				foreach($borrower['guarantors'] as $guarantor){
					$pdf->Ln();
					$pdf->setFillColor(230,230,230);
					$pdf->Cell(array_sum($w),10,'GUARANTOR '.$guarantor_count,1,0,'C', 1);
					$pdf->Ln();
					$pdf->Cell(array_sum($w),10,'FULL NAME :  '.strtoupper($guarantor['full_name']),1,0,'LR');
					$pdf->Ln();
					$pdf->Cell($w[0], 10,'NRIC :  '.$guarantor['nric_new'],1,0,'LR');
					$pdf->Cell($w[0], 10,'MOBILE :  '.$guarantor['mobile1'],1,0,'LR');
					$pdf->Cell($w[0], 10,'RELATION :  '.strtoupper($guarantor['relation']),1,0,'LR');
					$pdf->Ln();

					$guarantor_count += 1;
				}

				$this->db->query("SELECT * FROM borrower_references WHERE borrower_id = " . $this->db->escape($id));
				$borrower['references']= $this->db->getRowList();
				

				if($borrower['references']){

					$pdf->Ln();
					$pdf->Ln();
					$pdf->setFillColor(200,200,200);
					$pdf->SetFont('Arial','B',10);
					$pdf->Cell(array_sum($w),10,'REFERENCES',1,0,'C',1);
					$pdf->SetFont('Arial','',10);
					$references_count = 1;
						$pdf->Ln();

					foreach($borrower['references'] as $reference){
						$pdf->Ln();
						$pdf->setFillColor(230,230,230);
						$pdf->Cell(array_sum($w),10,'REFERENCE '.$references_count,1,0,'C',1);
						$pdf->Ln();
						$pdf->Cell(array_sum($w),10,'FULL NAME :  '.strtoupper($reference['full_name']),1,0,'LR');
						$pdf->Ln();
						$pdf->Cell($w[0], 10,'NRIC :  '.$reference['nric_new'],1,0,'LR');
						$pdf->Cell($w[0], 10,'MOBILE :  '.$reference['mobile1'],1,0,'LR');
						$pdf->Cell($w[0], 10,'RELATION :  '.strtoupper($reference['relation']),1,0,'LR');
						$pdf->Ln();
						$references_count += 1;
					}
				}

				$this->db->query("SELECT * FROM borrower_remarks WHERE borrower_id = " . $this->db->escape($id));
				$borrower['remarks']= $this->db->getRowList();

				if($borrower['remarks']){
					$pdf->Ln();
					$pdf->Ln();
					$pdf->setFillColor(200,200,200);
					$pdf->SetFont('Arial','B',10);
					$pdf->Cell(array_sum($w),10,'REMARKS',1,0,'C',1);
					$pdf->SetFont('Arial','',10);
					$remarks_count = 1;
						$pdf->Ln();
					foreach($borrower['remarks'] as $remark){
						$pdf->Ln();
						$pdf->setFillColor(230,230,230);
						$pdf->Cell(array_sum($w),10,'REMARKS '.$remarks_count,1,0,'C',1);
						$pdf->Ln();
						$pdf->Cell(array_sum($w),10,strtoupper($remark['remarks']),1,0,'LR');
						$pdf->Ln();

						$remarks_count += 1;
					}
				}



				$pdf->Ln();
				$pdf->Output();

			}
		}


	public function borrowerUpdate($id){

		$this->db->query("SELECT * FROM borrowers WHERE borrower_id = " . $this->db->escape($id));
		$borrower = $this->db->getSingleRow();

		$this->db->query("SELECT * FROM borrower_contacts WHERE borrower_id = " . $this->db->escape($id) . " LIMIT 1");
		$borrowerContacts = $this->db->getSingleRow();
		$this->db->query("SELECT * FROM borrower_employments WHERE borrower_id = " . $this->db->escape($id) . " LIMIT 1");
		$borrowerEmployments = $this->db->getSingleRow();
		$this->db->query("SELECT * FROM borrowers_spouse_details WHERE borrower_id = " . $this->db->escape($id) . " LIMIT 1");
		$borrowerSpouse = $this->db->getSingleRow();
		$this->db->query("SELECT * FROM borrower_spouse_employments WHERE borrower_id = " . $this->db->escape($id) . " LIMIT 1");
		$borrowerSpouseEmployments = $this->db->getSingleRow();
		$this->db->query("SELECT * FROM borrower_guarantors WHERE borrower_id = " . $this->db->escape($id) . " LIMIT 1");
		$borrowerGuarantors = $this->db->getSingleRow();
		$this->db->query("SELECT * FROM borrower_references WHERE borrower_id = " . $this->db->escape($id) . " LIMIT 1");
		$borrowerReferences = $this->db->getSingleRow();

		$this->db->query("SELECT * FROM borrower_updates WHERE borrower_id = " . $this->db->escape($id));
		$borrower_update_id = $this->db->getSingleRow();

		//insert default data into into borrower_updates
		if(!empty($borrower_update_id['borrower_id']) != $id){
			$this->db->table("borrower_updates");
			$this->db->insertArray(array(
				"borrower_id" => $id,"label_contacts" => '0',"label_employments" => '0',"label_spouse" => '0',"label_spouse_employments" => '0',"label_guarantor" => '0',"label_references" => '0',"label_remarks" => '0',"race" => '0',"owner" => '0',"full_name" => '0',"agent_id" => '0',"gender" => '0',"dob" => '0',"nationality" => '0',"nric_new" => '0',"nric_old" => '0',"resident_address" => '0',"nric_address" => '0',"resident_address2" => '0',"mobile1" => '0',"mobile2" => '0',"employment_details" => '0',"remarks" => '0',"marital" => '0',"spouse_details" => '0',"wanted_remarks" => '0',"borrower_remarks" => '0',"contactAddress" => '0',"contactMobile_number" => '0',"employmentEmployer_name" => '0',"employmentDesignation" => '0',"employmentSalary_range" => '0',"employmentPay_date" => '0',"employmentAdvance_date" => '0',"employmentStaff_id" => '0',"employmentHired_on" => '0',"employmentDepartment" => '0',"employmentAddress" => '0',"employmentWork_location" => '0',"employmentPhone" => '0',"employmentFax" => '0',"spousedetailsFull_name" => '0',"spousedetailsGender" => '0',"spousedetailsDob" => '0',"spousedetailsNationality" => '0',"spousedetailsNric_new" => '0',"spousedetailsNric_old" => '0',"spousedetailsResident_address" => '0',"spousedetailsNric_address" => '0',"spousedetailsResident_address2" => '0',"spousedetailsRemarks" => '0',"spousedetailsMarital" => '0',"spousedetailsRace" => '0',"spouseMobile1" => '0',"spouseMobile2" => '0',"spousecontactsMobile" => '0',"spouseemploymentsEmployer_name" => '0',"spouseemploymentsDesignation" => '0',"spouseemploymentsSalary_range" => '0',"spouseemploymentsPay_date" => '0',"spouseemploymentsAdvance_date" => '0',"spouseemploymentsStaff_id" => '0',"spouseemploymentsHired_on" => '0',"spouseemploymentsDepartment" => '0',"spouseemploymentsAddress" => '0',"spouseemploymentsWork_location" => '0',"spouseemploymentsPhone" => '0',"spouseemploymentsFax" => '0',"guarantorsFull_name" => '0',"guarantorsNric_new" => '0',"guarantorsNric_old" => '0',"guarantorsRelation" => '0',"guarantorsResidence_address" => '0',"guarantorsOther_address" => '0',"guarantorsMobile1" => '0',"guarantorsMobile2" => '0',"guarantorsEmployer_name" => '0',"guarantorsDesignation" => '0',"guarantorsStaff_id" => '0',"guarantorsHired_on" => '0',"guarantorsDepartment" => '0',"guarantorsEmployer_address" => '0',"guarantorsWork_location" => '0',"guarantorsPhone" => '0',"guarantorsMarital" => '0',"guarantorsFax" => '0',"referencesFull_name" => '0',"referencesEmployer_name" => '0',"referencesRelation" => '0',"referencesDesignation" => '0',"referencesNric_new" => '0',"referencesNric_old" => '0',"referencesStaff_id" => '0',"referencesHired_on" => '0',"referencesDepartment" => '0',"referencesResidence_address" => '0',"referencesEmployer_address" => '0',"referencesOther_address" => '0',"referencesWork_location" => '0',"referencesMarital" => '0',"referencesPhone" => '0',"referencesFax" => '0',"referencesMobile1" => '0',"referencesMobile2" => '0',"remarksRemarks" => '0'
			));
			$this->db->insert();
		}

		if($borrower){
			$this->db->query("SELECT * FROM files WHERE parent_id = " .$this->db->escape($id));
			$files = $this->db->getRowList();
			$profile_image = [];
			$other_image = [];
			foreach($files as $key => $val){
				if($val["profile_photo"] == "y"){
					array_push($profile_image, $val);
				}else{
					array_push($other_image, $val);
				}
			}
			$this->db->query("SELECT admin_id,admin_name FROM user_admins WHERE role_type = 3 AND admin_status = 1");
			$borrower['agents']= $this->db->getRowList();

			$borrower['nationality'] = !empty($borrower['nationality']) ? $borrower['nationality'] : 129;
			$states = $this->state($borrower['nationality']);

			$this->db->query("SELECT * FROM borrower_contacts WHERE borrower_id = " . $this->db->escape($id));
			$borrower['contacts']= $this->db->getRowList();

			foreach($borrower['contacts'] as $contact){
				if(!empty($borrower_update_id['borrower_id']) != $id && !empty($borrower_update_id['contact_id']) != $contact['contact_id']){
					$this->db->table("borrower_updates");
					$this->db->insertArray(array(
						"borrower_id" => $id,"contact_id" => $contact['contact_id'],"label_contacts" => '0',"label_employments" => '0',"label_spouse" => '0',"label_spouse_employments" => '0',"label_guarantor" => '0',"label_references" => '0',"label_remarks" => '0',"race" => '0',"owner" => '0',"full_name" => '0',"agent_id" => '0',"gender" => '0',"dob" => '0',"nationality" => '0',"nric_new" => '0',"nric_old" => '0',"resident_address" => '0',"nric_address" => '0',"resident_address2" => '0',"mobile1" => '0',"mobile2" => '0',"employment_details" => '0',"remarks" => '0',"marital" => '0',"spouse_details" => '0',"wanted_remarks" => '0',"borrower_remarks" => '0',"contactAddress" => '0',"contactMobile_number" => '0',"employmentEmployer_name" => '0',"employmentDesignation" => '0',"employmentSalary_range" => '0',"employmentPay_date" => '0',"employmentAdvance_date" => '0',"employmentStaff_id" => '0',"employmentHired_on" => '0',"employmentDepartment" => '0',"employmentAddress" => '0',"employmentWork_location" => '0',"employmentPhone" => '0',"employmentFax" => '0',"spousedetailsFull_name" => '0',"spousedetailsGender" => '0',"spousedetailsDob" => '0',"spousedetailsNationality" => '0',"spousedetailsNric_new" => '0',"spousedetailsNric_old" => '0',"spousedetailsResident_address" => '0',"spousedetailsNric_address" => '0',"spousedetailsResident_address2" => '0',"spousedetailsRemarks" => '0',"spousedetailsMarital" => '0',"spousedetailsRace" => '0',"spouseMobile1" => '0',"spouseMobile2" => '0',"spousecontactsMobile" => '0',"spouseemploymentsEmployer_name" => '0',"spouseemploymentsDesignation" => '0',"spouseemploymentsSalary_range" => '0',"spouseemploymentsPay_date" => '0',"spouseemploymentsAdvance_date" => '0',"spouseemploymentsStaff_id" => '0',"spouseemploymentsHired_on" => '0',"spouseemploymentsDepartment" => '0',"spouseemploymentsAddress" => '0',"spouseemploymentsWork_location" => '0',"spouseemploymentsPhone" => '0',"spouseemploymentsFax" => '0',"guarantorsFull_name" => '0',"guarantorsNric_new" => '0',"guarantorsNric_old" => '0',"guarantorsRelation" => '0',"guarantorsResidence_address" => '0',"guarantorsOther_address" => '0',"guarantorsMobile1" => '0',"guarantorsMobile2" => '0',"guarantorsEmployer_name" => '0',"guarantorsDesignation" => '0',"guarantorsStaff_id" => '0',"guarantorsHired_on" => '0',"guarantorsDepartment" => '0',"guarantorsEmployer_address" => '0',"guarantorsWork_location" => '0',"guarantorsPhone" => '0',"guarantorsMarital" => '0',"guarantorsFax" => '0',"referencesFull_name" => '0',"referencesEmployer_name" => '0',"referencesRelation" => '0',"referencesDesignation" => '0',"referencesNric_new" => '0',"referencesNric_old" => '0',"referencesStaff_id" => '0',"referencesHired_on" => '0',"referencesDepartment" => '0',"referencesResidence_address" => '0',"referencesEmployer_address" => '0',"referencesOther_address" => '0',"referencesWork_location" => '0',"referencesMarital" => '0',"referencesPhone" => '0',"referencesFax" => '0',"referencesMobile1" => '0',"referencesMobile2" => '0',"remarksRemarks" => '0'
					));
					$this->db->insert();
				}
			}

			$this->db->query("SELECT * FROM borrower_employments WHERE borrower_id = " . $this->db->escape($id));
			$borrower['employments']= $this->db->getRowList();

			foreach($borrower['employments'] as $employment){
				if(!empty($borrower_update_id['borrower_id']) != $id && !empty($borrower_update_id['employment_id']) != $employment['employment_id']){
					$this->db->table("borrower_updates");
					$this->db->insertArray(array(
						"borrower_id" => $id,"employment_id" => $employment['employment_id'],"label_contacts" => '0',"label_employments" => '0',"label_spouse" => '0',"label_spouse_employments" => '0',"label_guarantor" => '0',"label_references" => '0',"label_remarks" => '0',"race" => '0',"owner" => '0',"full_name" => '0',"agent_id" => '0',"gender" => '0',"dob" => '0',"nationality" => '0',"nric_new" => '0',"nric_old" => '0',"resident_address" => '0',"nric_address" => '0',"resident_address2" => '0',"mobile1" => '0',"mobile2" => '0',"employment_details" => '0',"remarks" => '0',"marital" => '0',"spouse_details" => '0',"wanted_remarks" => '0',"borrower_remarks" => '0',"contactAddress" => '0',"contactMobile_number" => '0',"employmentEmployer_name" => '0',"employmentDesignation" => '0',"employmentSalary_range" => '0',"employmentPay_date" => '0',"employmentAdvance_date" => '0',"employmentStaff_id" => '0',"employmentHired_on" => '0',"employmentDepartment" => '0',"employmentAddress" => '0',"employmentWork_location" => '0',"employmentPhone" => '0',"employmentFax" => '0',"spousedetailsFull_name" => '0',"spousedetailsGender" => '0',"spousedetailsDob" => '0',"spousedetailsNationality" => '0',"spousedetailsNric_new" => '0',"spousedetailsNric_old" => '0',"spousedetailsResident_address" => '0',"spousedetailsNric_address" => '0',"spousedetailsResident_address2" => '0',"spousedetailsRemarks" => '0',"spousedetailsMarital" => '0',"spousedetailsRace" => '0',"spouseMobile1" => '0',"spouseMobile2" => '0',"spousecontactsMobile" => '0',"spouseemploymentsEmployer_name" => '0',"spouseemploymentsDesignation" => '0',"spouseemploymentsSalary_range" => '0',"spouseemploymentsPay_date" => '0',"spouseemploymentsAdvance_date" => '0',"spouseemploymentsStaff_id" => '0',"spouseemploymentsHired_on" => '0',"spouseemploymentsDepartment" => '0',"spouseemploymentsAddress" => '0',"spouseemploymentsWork_location" => '0',"spouseemploymentsPhone" => '0',"spouseemploymentsFax" => '0',"guarantorsFull_name" => '0',"guarantorsNric_new" => '0',"guarantorsNric_old" => '0',"guarantorsRelation" => '0',"guarantorsResidence_address" => '0',"guarantorsOther_address" => '0',"guarantorsMobile1" => '0',"guarantorsMobile2" => '0',"guarantorsEmployer_name" => '0',"guarantorsDesignation" => '0',"guarantorsStaff_id" => '0',"guarantorsHired_on" => '0',"guarantorsDepartment" => '0',"guarantorsEmployer_address" => '0',"guarantorsWork_location" => '0',"guarantorsPhone" => '0',"guarantorsMarital" => '0',"guarantorsFax" => '0',"referencesFull_name" => '0',"referencesEmployer_name" => '0',"referencesRelation" => '0',"referencesDesignation" => '0',"referencesNric_new" => '0',"referencesNric_old" => '0',"referencesStaff_id" => '0',"referencesHired_on" => '0',"referencesDepartment" => '0',"referencesResidence_address" => '0',"referencesEmployer_address" => '0',"referencesOther_address" => '0',"referencesWork_location" => '0',"referencesMarital" => '0',"referencesPhone" => '0',"referencesFax" => '0',"referencesMobile1" => '0',"referencesMobile2" => '0',"remarksRemarks" => '0'
					));
					$this->db->insert();
				}
			}

			$this->db->query("SELECT * FROM borrowers_spouse_details WHERE borrower_id = " . $this->db->escape($id));
			$borrower['spouses']= $this->db->getRowList();

			foreach($borrower['spouses'] as $spouse){
				if(!empty($borrower_update_id['borrower_id']) != $id && !empty($borrower_update_id['spouse_id']) != $spouse['spouse_id']){
					$this->db->table("borrower_updates");
					$this->db->insertArray(array(
						"borrower_id" => $id,"spouse_id" => $spouse['spouse_id'],"label_contacts" => '0',"label_employments" => '0',"label_spouse" => '0',"label_spouse_employments" => '0',"label_guarantor" => '0',"label_references" => '0',"label_remarks" => '0',"race" => '0',"owner" => '0',"full_name" => '0',"agent_id" => '0',"gender" => '0',"dob" => '0',"nationality" => '0',"nric_new" => '0',"nric_old" => '0',"resident_address" => '0',"nric_address" => '0',"resident_address2" => '0',"mobile1" => '0',"mobile2" => '0',"employment_details" => '0',"remarks" => '0',"marital" => '0',"spouse_details" => '0',"wanted_remarks" => '0',"borrower_remarks" => '0',"contactAddress" => '0',"contactMobile_number" => '0',"employmentEmployer_name" => '0',"employmentDesignation" => '0',"employmentSalary_range" => '0',"employmentPay_date" => '0',"employmentAdvance_date" => '0',"employmentStaff_id" => '0',"employmentHired_on" => '0',"employmentDepartment" => '0',"employmentAddress" => '0',"employmentWork_location" => '0',"employmentPhone" => '0',"employmentFax" => '0',"spousedetailsFull_name" => '0',"spousedetailsGender" => '0',"spousedetailsDob" => '0',"spousedetailsNationality" => '0',"spousedetailsNric_new" => '0',"spousedetailsNric_old" => '0',"spousedetailsResident_address" => '0',"spousedetailsNric_address" => '0',"spousedetailsResident_address2" => '0',"spousedetailsRemarks" => '0',"spousedetailsMarital" => '0',"spousedetailsRace" => '0',"spouseMobile1" => '0',"spouseMobile2" => '0',"spousecontactsMobile" => '0',"spouseemploymentsEmployer_name" => '0',"spouseemploymentsDesignation" => '0',"spouseemploymentsSalary_range" => '0',"spouseemploymentsPay_date" => '0',"spouseemploymentsAdvance_date" => '0',"spouseemploymentsStaff_id" => '0',"spouseemploymentsHired_on" => '0',"spouseemploymentsDepartment" => '0',"spouseemploymentsAddress" => '0',"spouseemploymentsWork_location" => '0',"spouseemploymentsPhone" => '0',"spouseemploymentsFax" => '0',"guarantorsFull_name" => '0',"guarantorsNric_new" => '0',"guarantorsNric_old" => '0',"guarantorsRelation" => '0',"guarantorsResidence_address" => '0',"guarantorsOther_address" => '0',"guarantorsMobile1" => '0',"guarantorsMobile2" => '0',"guarantorsEmployer_name" => '0',"guarantorsDesignation" => '0',"guarantorsStaff_id" => '0',"guarantorsHired_on" => '0',"guarantorsDepartment" => '0',"guarantorsEmployer_address" => '0',"guarantorsWork_location" => '0',"guarantorsPhone" => '0',"guarantorsMarital" => '0',"guarantorsFax" => '0',"referencesFull_name" => '0',"referencesEmployer_name" => '0',"referencesRelation" => '0',"referencesDesignation" => '0',"referencesNric_new" => '0',"referencesNric_old" => '0',"referencesStaff_id" => '0',"referencesHired_on" => '0',"referencesDepartment" => '0',"referencesResidence_address" => '0',"referencesEmployer_address" => '0',"referencesOther_address" => '0',"referencesWork_location" => '0',"referencesMarital" => '0',"referencesPhone" => '0',"referencesFax" => '0',"referencesMobile1" => '0',"referencesMobile2" => '0',"remarksRemarks" => '0'
					));
					$this->db->insert();
				}
			}

			$this->db->query("SELECT * FROM borrower_spouse_contacts WHERE borrower_id = " . $this->db->escape($id));
			$borrower['spouse_contacts']= $this->db->getRowList();

			$this->db->query("SELECT * FROM borrower_spouse_employments WHERE borrower_id = " . $this->db->escape($id));
			$borrower['spouses_employment']= $this->db->getRowList();

			foreach($borrower['spouses_employment'] as $spouses_employment){
				if(!empty($borrower_update_id['borrower_id']) != $id && !empty($borrower_update_id['spouse_employment_id']) != $spouses_employment['employment_id']){
					$this->db->table("borrower_updates");
					$this->db->insertArray(array(
						"borrower_id" => $id,"spouse_employment_id" => $spouses_employment['employment_id'],"label_contacts" => '0',"label_employments" => '0',"label_spouse" => '0',"label_spouse_employments" => '0',"label_guarantor" => '0',"label_references" => '0',"label_remarks" => '0',"race" => '0',"owner" => '0',"full_name" => '0',"agent_id" => '0',"gender" => '0',"dob" => '0',"nationality" => '0',"nric_new" => '0',"nric_old" => '0',"resident_address" => '0',"nric_address" => '0',"resident_address2" => '0',"mobile1" => '0',"mobile2" => '0',"employment_details" => '0',"remarks" => '0',"marital" => '0',"spouse_details" => '0',"wanted_remarks" => '0',"borrower_remarks" => '0',"contactAddress" => '0',"contactMobile_number" => '0',"employmentEmployer_name" => '0',"employmentDesignation" => '0',"employmentSalary_range" => '0',"employmentPay_date" => '0',"employmentAdvance_date" => '0',"employmentStaff_id" => '0',"employmentHired_on" => '0',"employmentDepartment" => '0',"employmentAddress" => '0',"employmentWork_location" => '0',"employmentPhone" => '0',"employmentFax" => '0',"spousedetailsFull_name" => '0',"spousedetailsGender" => '0',"spousedetailsDob" => '0',"spousedetailsNationality" => '0',"spousedetailsNric_new" => '0',"spousedetailsNric_old" => '0',"spousedetailsResident_address" => '0',"spousedetailsNric_address" => '0',"spousedetailsResident_address2" => '0',"spousedetailsRemarks" => '0',"spousedetailsMarital" => '0',"spousedetailsRace" => '0',"spouseMobile1" => '0',"spouseMobile2" => '0',"spousecontactsMobile" => '0',"spouseemploymentsEmployer_name" => '0',"spouseemploymentsDesignation" => '0',"spouseemploymentsSalary_range" => '0',"spouseemploymentsPay_date" => '0',"spouseemploymentsAdvance_date" => '0',"spouseemploymentsStaff_id" => '0',"spouseemploymentsHired_on" => '0',"spouseemploymentsDepartment" => '0',"spouseemploymentsAddress" => '0',"spouseemploymentsWork_location" => '0',"spouseemploymentsPhone" => '0',"spouseemploymentsFax" => '0',"guarantorsFull_name" => '0',"guarantorsNric_new" => '0',"guarantorsNric_old" => '0',"guarantorsRelation" => '0',"guarantorsResidence_address" => '0',"guarantorsOther_address" => '0',"guarantorsMobile1" => '0',"guarantorsMobile2" => '0',"guarantorsEmployer_name" => '0',"guarantorsDesignation" => '0',"guarantorsStaff_id" => '0',"guarantorsHired_on" => '0',"guarantorsDepartment" => '0',"guarantorsEmployer_address" => '0',"guarantorsWork_location" => '0',"guarantorsPhone" => '0',"guarantorsMarital" => '0',"guarantorsFax" => '0',"referencesFull_name" => '0',"referencesEmployer_name" => '0',"referencesRelation" => '0',"referencesDesignation" => '0',"referencesNric_new" => '0',"referencesNric_old" => '0',"referencesStaff_id" => '0',"referencesHired_on" => '0',"referencesDepartment" => '0',"referencesResidence_address" => '0',"referencesEmployer_address" => '0',"referencesOther_address" => '0',"referencesWork_location" => '0',"referencesMarital" => '0',"referencesPhone" => '0',"referencesFax" => '0',"referencesMobile1" => '0',"referencesMobile2" => '0',"remarksRemarks" => '0'
					));
					$this->db->insert();
				}
			}

			$this->db->query("SELECT * FROM borrower_guarantors WHERE borrower_id = " . $this->db->escape($id));
			$borrower['guarantors']= $this->db->getRowList();

			foreach($borrower['guarantors'] as $guarantor){
				if(!empty($borrower_update_id['borrower_id']) != $id && !empty($borrower_update_id['guarantor_id']) != $guarantor['guarantor_id']){
					$this->db->table("borrower_updates");
					$this->db->insertArray(array(
						"borrower_id" => $id,"guarantor_id" => $guarantor['guarantor_id'],"label_contacts" => '0',"label_employments" => '0',"label_spouse" => '0',"label_spouse_employments" => '0',"label_guarantor" => '0',"label_references" => '0',"label_remarks" => '0',"race" => '0',"owner" => '0',"full_name" => '0',"agent_id" => '0',"gender" => '0',"dob" => '0',"nationality" => '0',"nric_new" => '0',"nric_old" => '0',"resident_address" => '0',"nric_address" => '0',"resident_address2" => '0',"mobile1" => '0',"mobile2" => '0',"employment_details" => '0',"remarks" => '0',"marital" => '0',"spouse_details" => '0',"wanted_remarks" => '0',"borrower_remarks" => '0',"contactAddress" => '0',"contactMobile_number" => '0',"employmentEmployer_name" => '0',"employmentDesignation" => '0',"employmentSalary_range" => '0',"employmentPay_date" => '0',"employmentAdvance_date" => '0',"employmentStaff_id" => '0',"employmentHired_on" => '0',"employmentDepartment" => '0',"employmentAddress" => '0',"employmentWork_location" => '0',"employmentPhone" => '0',"employmentFax" => '0',"spousedetailsFull_name" => '0',"spousedetailsGender" => '0',"spousedetailsDob" => '0',"spousedetailsNationality" => '0',"spousedetailsNric_new" => '0',"spousedetailsNric_old" => '0',"spousedetailsResident_address" => '0',"spousedetailsNric_address" => '0',"spousedetailsResident_address2" => '0',"spousedetailsRemarks" => '0',"spousedetailsMarital" => '0',"spousedetailsRace" => '0',"spouseMobile1" => '0',"spouseMobile2" => '0',"spousecontactsMobile" => '0',"spouseemploymentsEmployer_name" => '0',"spouseemploymentsDesignation" => '0',"spouseemploymentsSalary_range" => '0',"spouseemploymentsPay_date" => '0',"spouseemploymentsAdvance_date" => '0',"spouseemploymentsStaff_id" => '0',"spouseemploymentsHired_on" => '0',"spouseemploymentsDepartment" => '0',"spouseemploymentsAddress" => '0',"spouseemploymentsWork_location" => '0',"spouseemploymentsPhone" => '0',"spouseemploymentsFax" => '0',"guarantorsFull_name" => '0',"guarantorsNric_new" => '0',"guarantorsNric_old" => '0',"guarantorsRelation" => '0',"guarantorsResidence_address" => '0',"guarantorsOther_address" => '0',"guarantorsMobile1" => '0',"guarantorsMobile2" => '0',"guarantorsEmployer_name" => '0',"guarantorsDesignation" => '0',"guarantorsStaff_id" => '0',"guarantorsHired_on" => '0',"guarantorsDepartment" => '0',"guarantorsEmployer_address" => '0',"guarantorsWork_location" => '0',"guarantorsPhone" => '0',"guarantorsMarital" => '0',"guarantorsFax" => '0',"referencesFull_name" => '0',"referencesEmployer_name" => '0',"referencesRelation" => '0',"referencesDesignation" => '0',"referencesNric_new" => '0',"referencesNric_old" => '0',"referencesStaff_id" => '0',"referencesHired_on" => '0',"referencesDepartment" => '0',"referencesResidence_address" => '0',"referencesEmployer_address" => '0',"referencesOther_address" => '0',"referencesWork_location" => '0',"referencesMarital" => '0',"referencesPhone" => '0',"referencesFax" => '0',"referencesMobile1" => '0',"referencesMobile2" => '0',"remarksRemarks" => '0'
					));
					$this->db->insert();
				}
			}

			$this->db->query("SELECT * FROM borrower_references WHERE borrower_id = " . $this->db->escape($id));
			$borrower['references']= $this->db->getRowList();

			foreach($borrower['references'] as $reference){
				if(!empty($borrower_update_id['borrower_id']) != $id && !empty($borrower_update_id['reference_id']) != $reference['reference_id']){
					$this->db->table("borrower_updates");
					$this->db->insertArray(array(
						"borrower_id" => $id,"reference_id" => $reference['reference_id'],"label_contacts" => '0',"label_employments" => '0',"label_spouse" => '0',"label_spouse_employments" => '0',"label_guarantor" => '0',"label_references" => '0',"label_remarks" => '0',"race" => '0',"owner" => '0',"full_name" => '0',"agent_id" => '0',"gender" => '0',"dob" => '0',"nationality" => '0',"nric_new" => '0',"nric_old" => '0',"resident_address" => '0',"nric_address" => '0',"resident_address2" => '0',"mobile1" => '0',"mobile2" => '0',"employment_details" => '0',"remarks" => '0',"marital" => '0',"spouse_details" => '0',"wanted_remarks" => '0',"borrower_remarks" => '0',"contactAddress" => '0',"contactMobile_number" => '0',"employmentEmployer_name" => '0',"employmentDesignation" => '0',"employmentSalary_range" => '0',"employmentPay_date" => '0',"employmentAdvance_date" => '0',"employmentStaff_id" => '0',"employmentHired_on" => '0',"employmentDepartment" => '0',"employmentAddress" => '0',"employmentWork_location" => '0',"employmentPhone" => '0',"employmentFax" => '0',"spousedetailsFull_name" => '0',"spousedetailsGender" => '0',"spousedetailsDob" => '0',"spousedetailsNationality" => '0',"spousedetailsNric_new" => '0',"spousedetailsNric_old" => '0',"spousedetailsResident_address" => '0',"spousedetailsNric_address" => '0',"spousedetailsResident_address2" => '0',"spousedetailsRemarks" => '0',"spousedetailsMarital" => '0',"spousedetailsRace" => '0',"spouseMobile1" => '0',"spouseMobile2" => '0',"spousecontactsMobile" => '0',"spouseemploymentsEmployer_name" => '0',"spouseemploymentsDesignation" => '0',"spouseemploymentsSalary_range" => '0',"spouseemploymentsPay_date" => '0',"spouseemploymentsAdvance_date" => '0',"spouseemploymentsStaff_id" => '0',"spouseemploymentsHired_on" => '0',"spouseemploymentsDepartment" => '0',"spouseemploymentsAddress" => '0',"spouseemploymentsWork_location" => '0',"spouseemploymentsPhone" => '0',"spouseemploymentsFax" => '0',"guarantorsFull_name" => '0',"guarantorsNric_new" => '0',"guarantorsNric_old" => '0',"guarantorsRelation" => '0',"guarantorsResidence_address" => '0',"guarantorsOther_address" => '0',"guarantorsMobile1" => '0',"guarantorsMobile2" => '0',"guarantorsEmployer_name" => '0',"guarantorsDesignation" => '0',"guarantorsStaff_id" => '0',"guarantorsHired_on" => '0',"guarantorsDepartment" => '0',"guarantorsEmployer_address" => '0',"guarantorsWork_location" => '0',"guarantorsPhone" => '0',"guarantorsMarital" => '0',"guarantorsFax" => '0',"referencesFull_name" => '0',"referencesEmployer_name" => '0',"referencesRelation" => '0',"referencesDesignation" => '0',"referencesNric_new" => '0',"referencesNric_old" => '0',"referencesStaff_id" => '0',"referencesHired_on" => '0',"referencesDepartment" => '0',"referencesResidence_address" => '0',"referencesEmployer_address" => '0',"referencesOther_address" => '0',"referencesWork_location" => '0',"referencesMarital" => '0',"referencesPhone" => '0',"referencesFax" => '0',"referencesMobile1" => '0',"referencesMobile2" => '0',"remarksRemarks" => '0'
					));
					$this->db->insert();
				}
			}

			$this->db->query("SELECT * FROM borrower_remarks WHERE borrower_id = " . $this->db->escape($id));
			$borrower['remarks']= $this->db->getRowList();

			$this->db->query("SELECT COUNT(*) AS amount FROM loan WHERE loan_status <> 99 AND loan_status <> 991 AND loan_status <> 4 AND borrower_id = " . $this->db->escape($id));
			$loan = $this->db->getSingleRow();

			$this->db->query("SELECT admin_name,admin_id FROM user_admins WHERE role_type = 3 AND admin_status = 1");
			$admins = $this->db->getRowList();

			$this->db->query("SELECT * FROM borrower_updates WHERE borrower_id = ".$this->db->escape($id)."");
			$borrower_update = $this->db->getSingleRow();

			$this->db->query("SELECT * FROM borrower_updates WHERE borrower_id = ".$this->db->escape($id)." && contact_id <> ''");
			$ucontacts = $this->db->getRowList();
			$this->db->query("SELECT * FROM borrower_updates WHERE borrower_id = ".$this->db->escape($id)." && employment_id <> ''");
			$uemployments = $this->db->getRowList();
			$this->db->query("SELECT * FROM borrower_updates WHERE borrower_id = ".$this->db->escape($id)." && spouse_id <> ''");
			$uspouses = $this->db->getRowList();
			$this->db->query("SELECT * FROM borrower_updates WHERE borrower_id = ".$this->db->escape($id)." && spouse_employment_id <> ''");
			$uspouse_employments = $this->db->getRowList();
			$this->db->query("SELECT * FROM borrower_updates WHERE borrower_id = ".$this->db->escape($id)." && guarantor_id <> ''");
			$uguarantors = $this->db->getRowList();
			$this->db->query("SELECT * FROM borrower_updates WHERE borrower_id = ".$this->db->escape($id)." && reference_id <> ''");
			$ureferences = $this->db->getRowList();

			set('admins', $admins);
			set('borrower_update', $borrower_update);
			set('ucontacts', $ucontacts);
			set('uemployments', $uemployments);
			set('uspouses', $uspouses);
			set('uspouse_employments', $uspouse_employments);
			set('uguarantors', $uguarantors);
			set('ureferences', $ureferences);
			set('borrower', $borrower);
			set('profile_image', $profile_image);
			set('other_image', $other_image);
			set('loan', $loan);
			set('borrowerContacts', $borrowerContacts);
			set('borrowerEmployments', $borrowerEmployments);
			set('borrowerSpouse', $borrowerSpouse);
			set('borrowerSpouseEmployments', $borrowerSpouseEmployments);
			set('borrowerGuarantors', $borrowerGuarantors);
			set('borrowerReferences', $borrowerReferences);
			set('countries', $this->countries());
			// set('states', $states);
			return render('modules/borrowers-update.php', 'layout/default.php');
		}
	}

	public function borrowerUpdateID($id, $lid){

		$this->db->query("SELECT * FROM borrowers WHERE borrower_id = " . $this->db->escape($id));
		$borrower = $this->db->getSingleRow();

		$this->db->query("SELECT * FROM borrower_updates WHERE borrower_id = " . $this->db->escape($id));
		$borrower_update_id = $this->db->getSingleRow();

		//insert default data into into borrower_updates
		if(!empty($borrower_update_id['borrower_id']) != $id){
			$this->db->table("borrower_updates");
			$this->db->insertArray(array(
				"borrower_id" => $id,"label_contacts" => '0',"label_employments" => '0',"label_spouse" => '0',"label_spouse_employments" => '0',"label_guarantor" => '0',"label_references" => '0',"label_remarks" => '0',"race" => '0',"owner" => '0',"full_name" => '0',"agent_id" => '0',"gender" => '0',"dob" => '0',"nationality" => '0',"nric_new" => '0',"nric_old" => '0',"resident_address" => '0',"nric_address" => '0',"resident_address2" => '0',"mobile1" => '0',"mobile2" => '0',"employment_details" => '0',"remarks" => '0',"marital" => '0',"spouse_details" => '0',"wanted_remarks" => '0',"borrower_remarks" => '0',"contactAddress" => '0',"contactMobile_number" => '0',"employmentEmployer_name" => '0',"employmentDesignation" => '0',"employmentSalary_range" => '0',"employmentPay_date" => '0',"employmentAdvance_date" => '0',"employmentStaff_id" => '0',"employmentHired_on" => '0',"employmentDepartment" => '0',"employmentAddress" => '0',"employmentWork_location" => '0',"employmentPhone" => '0',"employmentFax" => '0',"spousedetailsFull_name" => '0',"spousedetailsGender" => '0',"spousedetailsDob" => '0',"spousedetailsNationality" => '0',"spousedetailsNric_new" => '0',"spousedetailsNric_old" => '0',"spousedetailsResident_address" => '0',"spousedetailsNric_address" => '0',"spousedetailsResident_address2" => '0',"spousedetailsRemarks" => '0',"spousedetailsMarital" => '0',"spousedetailsRace" => '0',"spouseMobile1" => '0',"spouseMobile2" => '0',"spousecontactsMobile" => '0',"spouseemploymentsEmployer_name" => '0',"spouseemploymentsDesignation" => '0',"spouseemploymentsSalary_range" => '0',"spouseemploymentsPay_date" => '0',"spouseemploymentsAdvance_date" => '0',"spouseemploymentsStaff_id" => '0',"spouseemploymentsHired_on" => '0',"spouseemploymentsDepartment" => '0',"spouseemploymentsAddress" => '0',"spouseemploymentsWork_location" => '0',"spouseemploymentsPhone" => '0',"spouseemploymentsFax" => '0',"guarantorsFull_name" => '0',"guarantorsNric_new" => '0',"guarantorsNric_old" => '0',"guarantorsRelation" => '0',"guarantorsResidence_address" => '0',"guarantorsOther_address" => '0',"guarantorsMobile1" => '0',"guarantorsMobile2" => '0',"guarantorsEmployer_name" => '0',"guarantorsDesignation" => '0',"guarantorsStaff_id" => '0',"guarantorsHired_on" => '0',"guarantorsDepartment" => '0',"guarantorsEmployer_address" => '0',"guarantorsWork_location" => '0',"guarantorsPhone" => '0',"guarantorsMarital" => '0',"guarantorsFax" => '0',"referencesFull_name" => '0',"referencesEmployer_name" => '0',"referencesRelation" => '0',"referencesDesignation" => '0',"referencesNric_new" => '0',"referencesNric_old" => '0',"referencesStaff_id" => '0',"referencesHired_on" => '0',"referencesDepartment" => '0',"referencesResidence_address" => '0',"referencesEmployer_address" => '0',"referencesOther_address" => '0',"referencesWork_location" => '0',"referencesMarital" => '0',"referencesPhone" => '0',"referencesFax" => '0',"referencesMobile1" => '0',"referencesMobile2" => '0',"remarksRemarks" => '0'
			));
			$this->db->insert();
		}

		if($borrower){
			$this->db->query("SELECT * FROM files WHERE parent_id = " .$this->db->escape($id));
			$files = $this->db->getRowList();
			$profile_image = [];
			$other_image = [];
			foreach($files as $key => $val){
				if($val["profile_photo"] == "y"){
					array_push($profile_image, $val);
				}else{
					array_push($other_image, $val);
				}
			}
			$this->db->query("SELECT admin_id,admin_name FROM user_admins WHERE role_type = 3 AND admin_status = 1");
			$borrower['agents']= $this->db->getRowList();

			$borrower['nationality'] = !empty($borrower['nationality']) ? $borrower['nationality'] : 129;
			$states = $this->state($borrower['nationality']);

			$this->db->query("SELECT * FROM borrower_contacts WHERE borrower_id = " . $this->db->escape($id));
			$borrower['contacts']= $this->db->getRowList();

			foreach($borrower['contacts'] as $contact){
				if(!empty($borrower_update_id['borrower_id']) != $id && !empty($borrower_update_id['contact_id']) != $contact['contact_id']){
					$this->db->table("borrower_updates");
					$this->db->insertArray(array(
						"borrower_id" => $id,"contact_id" => $contact['contact_id'],"label_contacts" => '0',"label_employments" => '0',"label_spouse" => '0',"label_spouse_employments" => '0',"label_guarantor" => '0',"label_references" => '0',"label_remarks" => '0',"race" => '0',"owner" => '0',"full_name" => '0',"agent_id" => '0',"gender" => '0',"dob" => '0',"nationality" => '0',"nric_new" => '0',"nric_old" => '0',"resident_address" => '0',"nric_address" => '0',"resident_address2" => '0',"mobile1" => '0',"mobile2" => '0',"employment_details" => '0',"remarks" => '0',"marital" => '0',"spouse_details" => '0',"wanted_remarks" => '0',"borrower_remarks" => '0',"contactAddress" => '0',"contactMobile_number" => '0',"employmentEmployer_name" => '0',"employmentDesignation" => '0',"employmentSalary_range" => '0',"employmentPay_date" => '0',"employmentAdvance_date" => '0',"employmentStaff_id" => '0',"employmentHired_on" => '0',"employmentDepartment" => '0',"employmentAddress" => '0',"employmentWork_location" => '0',"employmentPhone" => '0',"employmentFax" => '0',"spousedetailsFull_name" => '0',"spousedetailsGender" => '0',"spousedetailsDob" => '0',"spousedetailsNationality" => '0',"spousedetailsNric_new" => '0',"spousedetailsNric_old" => '0',"spousedetailsResident_address" => '0',"spousedetailsNric_address" => '0',"spousedetailsResident_address2" => '0',"spousedetailsRemarks" => '0',"spousedetailsMarital" => '0',"spousedetailsRace" => '0',"spouseMobile1" => '0',"spouseMobile2" => '0',"spousecontactsMobile" => '0',"spouseemploymentsEmployer_name" => '0',"spouseemploymentsDesignation" => '0',"spouseemploymentsSalary_range" => '0',"spouseemploymentsPay_date" => '0',"spouseemploymentsAdvance_date" => '0',"spouseemploymentsStaff_id" => '0',"spouseemploymentsHired_on" => '0',"spouseemploymentsDepartment" => '0',"spouseemploymentsAddress" => '0',"spouseemploymentsWork_location" => '0',"spouseemploymentsPhone" => '0',"spouseemploymentsFax" => '0',"guarantorsFull_name" => '0',"guarantorsNric_new" => '0',"guarantorsNric_old" => '0',"guarantorsRelation" => '0',"guarantorsResidence_address" => '0',"guarantorsOther_address" => '0',"guarantorsMobile1" => '0',"guarantorsMobile2" => '0',"guarantorsEmployer_name" => '0',"guarantorsDesignation" => '0',"guarantorsStaff_id" => '0',"guarantorsHired_on" => '0',"guarantorsDepartment" => '0',"guarantorsEmployer_address" => '0',"guarantorsWork_location" => '0',"guarantorsPhone" => '0',"guarantorsMarital" => '0',"guarantorsFax" => '0',"referencesFull_name" => '0',"referencesEmployer_name" => '0',"referencesRelation" => '0',"referencesDesignation" => '0',"referencesNric_new" => '0',"referencesNric_old" => '0',"referencesStaff_id" => '0',"referencesHired_on" => '0',"referencesDepartment" => '0',"referencesResidence_address" => '0',"referencesEmployer_address" => '0',"referencesOther_address" => '0',"referencesWork_location" => '0',"referencesMarital" => '0',"referencesPhone" => '0',"referencesFax" => '0',"referencesMobile1" => '0',"referencesMobile2" => '0',"remarksRemarks" => '0'
					));
					$this->db->insert();
				}
			}

			$this->db->query("SELECT * FROM borrower_employments WHERE borrower_id = " . $this->db->escape($id));
			$borrower['employments']= $this->db->getRowList();

			foreach($borrower['employments'] as $employment){
				if(!empty($borrower_update_id['borrower_id']) != $id && !empty($borrower_update_id['employment_id']) != $employment['employment_id']){
					$this->db->table("borrower_updates");
					$this->db->insertArray(array(
						"borrower_id" => $id,"employment_id" => $employment['employment_id'],"label_contacts" => '0',"label_employments" => '0',"label_spouse" => '0',"label_spouse_employments" => '0',"label_guarantor" => '0',"label_references" => '0',"label_remarks" => '0',"race" => '0',"owner" => '0',"full_name" => '0',"agent_id" => '0',"gender" => '0',"dob" => '0',"nationality" => '0',"nric_new" => '0',"nric_old" => '0',"resident_address" => '0',"nric_address" => '0',"resident_address2" => '0',"mobile1" => '0',"mobile2" => '0',"employment_details" => '0',"remarks" => '0',"marital" => '0',"spouse_details" => '0',"wanted_remarks" => '0',"borrower_remarks" => '0',"contactAddress" => '0',"contactMobile_number" => '0',"employmentEmployer_name" => '0',"employmentDesignation" => '0',"employmentSalary_range" => '0',"employmentPay_date" => '0',"employmentAdvance_date" => '0',"employmentStaff_id" => '0',"employmentHired_on" => '0',"employmentDepartment" => '0',"employmentAddress" => '0',"employmentWork_location" => '0',"employmentPhone" => '0',"employmentFax" => '0',"spousedetailsFull_name" => '0',"spousedetailsGender" => '0',"spousedetailsDob" => '0',"spousedetailsNationality" => '0',"spousedetailsNric_new" => '0',"spousedetailsNric_old" => '0',"spousedetailsResident_address" => '0',"spousedetailsNric_address" => '0',"spousedetailsResident_address2" => '0',"spousedetailsRemarks" => '0',"spousedetailsMarital" => '0',"spousedetailsRace" => '0',"spouseMobile1" => '0',"spouseMobile2" => '0',"spousecontactsMobile" => '0',"spouseemploymentsEmployer_name" => '0',"spouseemploymentsDesignation" => '0',"spouseemploymentsSalary_range" => '0',"spouseemploymentsPay_date" => '0',"spouseemploymentsAdvance_date" => '0',"spouseemploymentsStaff_id" => '0',"spouseemploymentsHired_on" => '0',"spouseemploymentsDepartment" => '0',"spouseemploymentsAddress" => '0',"spouseemploymentsWork_location" => '0',"spouseemploymentsPhone" => '0',"spouseemploymentsFax" => '0',"guarantorsFull_name" => '0',"guarantorsNric_new" => '0',"guarantorsNric_old" => '0',"guarantorsRelation" => '0',"guarantorsResidence_address" => '0',"guarantorsOther_address" => '0',"guarantorsMobile1" => '0',"guarantorsMobile2" => '0',"guarantorsEmployer_name" => '0',"guarantorsDesignation" => '0',"guarantorsStaff_id" => '0',"guarantorsHired_on" => '0',"guarantorsDepartment" => '0',"guarantorsEmployer_address" => '0',"guarantorsWork_location" => '0',"guarantorsPhone" => '0',"guarantorsMarital" => '0',"guarantorsFax" => '0',"referencesFull_name" => '0',"referencesEmployer_name" => '0',"referencesRelation" => '0',"referencesDesignation" => '0',"referencesNric_new" => '0',"referencesNric_old" => '0',"referencesStaff_id" => '0',"referencesHired_on" => '0',"referencesDepartment" => '0',"referencesResidence_address" => '0',"referencesEmployer_address" => '0',"referencesOther_address" => '0',"referencesWork_location" => '0',"referencesMarital" => '0',"referencesPhone" => '0',"referencesFax" => '0',"referencesMobile1" => '0',"referencesMobile2" => '0',"remarksRemarks" => '0'
					));
					$this->db->insert();
				}
			}

			$this->db->query("SELECT * FROM borrowers_spouse_details WHERE borrower_id = " . $this->db->escape($id));
			$borrower['spouses']= $this->db->getRowList();

			foreach($borrower['spouses'] as $spouse){
				if(!empty($borrower_update_id['borrower_id']) != $id && !empty($borrower_update_id['spouse_id']) != $spouse['spouse_id']){
					$this->db->table("borrower_updates");
					$this->db->insertArray(array(
						"borrower_id" => $id,"spouse_id" => $spouse['spouse_id'],"label_contacts" => '0',"label_employments" => '0',"label_spouse" => '0',"label_spouse_employments" => '0',"label_guarantor" => '0',"label_references" => '0',"label_remarks" => '0',"race" => '0',"owner" => '0',"full_name" => '0',"agent_id" => '0',"gender" => '0',"dob" => '0',"nationality" => '0',"nric_new" => '0',"nric_old" => '0',"resident_address" => '0',"nric_address" => '0',"resident_address2" => '0',"mobile1" => '0',"mobile2" => '0',"employment_details" => '0',"remarks" => '0',"marital" => '0',"spouse_details" => '0',"wanted_remarks" => '0',"borrower_remarks" => '0',"contactAddress" => '0',"contactMobile_number" => '0',"employmentEmployer_name" => '0',"employmentDesignation" => '0',"employmentSalary_range" => '0',"employmentPay_date" => '0',"employmentAdvance_date" => '0',"employmentStaff_id" => '0',"employmentHired_on" => '0',"employmentDepartment" => '0',"employmentAddress" => '0',"employmentWork_location" => '0',"employmentPhone" => '0',"employmentFax" => '0',"spousedetailsFull_name" => '0',"spousedetailsGender" => '0',"spousedetailsDob" => '0',"spousedetailsNationality" => '0',"spousedetailsNric_new" => '0',"spousedetailsNric_old" => '0',"spousedetailsResident_address" => '0',"spousedetailsNric_address" => '0',"spousedetailsResident_address2" => '0',"spousedetailsRemarks" => '0',"spousedetailsMarital" => '0',"spousedetailsRace" => '0',"spouseMobile1" => '0',"spouseMobile2" => '0',"spousecontactsMobile" => '0',"spouseemploymentsEmployer_name" => '0',"spouseemploymentsDesignation" => '0',"spouseemploymentsSalary_range" => '0',"spouseemploymentsPay_date" => '0',"spouseemploymentsAdvance_date" => '0',"spouseemploymentsStaff_id" => '0',"spouseemploymentsHired_on" => '0',"spouseemploymentsDepartment" => '0',"spouseemploymentsAddress" => '0',"spouseemploymentsWork_location" => '0',"spouseemploymentsPhone" => '0',"spouseemploymentsFax" => '0',"guarantorsFull_name" => '0',"guarantorsNric_new" => '0',"guarantorsNric_old" => '0',"guarantorsRelation" => '0',"guarantorsResidence_address" => '0',"guarantorsOther_address" => '0',"guarantorsMobile1" => '0',"guarantorsMobile2" => '0',"guarantorsEmployer_name" => '0',"guarantorsDesignation" => '0',"guarantorsStaff_id" => '0',"guarantorsHired_on" => '0',"guarantorsDepartment" => '0',"guarantorsEmployer_address" => '0',"guarantorsWork_location" => '0',"guarantorsPhone" => '0',"guarantorsMarital" => '0',"guarantorsFax" => '0',"referencesFull_name" => '0',"referencesEmployer_name" => '0',"referencesRelation" => '0',"referencesDesignation" => '0',"referencesNric_new" => '0',"referencesNric_old" => '0',"referencesStaff_id" => '0',"referencesHired_on" => '0',"referencesDepartment" => '0',"referencesResidence_address" => '0',"referencesEmployer_address" => '0',"referencesOther_address" => '0',"referencesWork_location" => '0',"referencesMarital" => '0',"referencesPhone" => '0',"referencesFax" => '0',"referencesMobile1" => '0',"referencesMobile2" => '0',"remarksRemarks" => '0'
					));
					$this->db->insert();
				}
			}

			$this->db->query("SELECT * FROM borrower_spouse_contacts WHERE borrower_id = " . $this->db->escape($id));
			$borrower['spouse_contacts']= $this->db->getRowList();

			$this->db->query("SELECT * FROM borrower_spouse_employments WHERE borrower_id = " . $this->db->escape($id));
			$borrower['spouses_employment']= $this->db->getRowList();

			foreach($borrower['spouses_employment'] as $spouses_employment){
				if(!empty($borrower_update_id['borrower_id']) != $id && !empty($borrower_update_id['spouse_employment_id']) != $spouses_employment['employment_id']){
					$this->db->table("borrower_updates");
					$this->db->insertArray(array(
						"borrower_id" => $id,"spouse_employment_id" => $spouses_employment['employment_id'],"label_contacts" => '0',"label_employments" => '0',"label_spouse" => '0',"label_spouse_employments" => '0',"label_guarantor" => '0',"label_references" => '0',"label_remarks" => '0',"race" => '0',"owner" => '0',"full_name" => '0',"agent_id" => '0',"gender" => '0',"dob" => '0',"nationality" => '0',"nric_new" => '0',"nric_old" => '0',"resident_address" => '0',"nric_address" => '0',"resident_address2" => '0',"mobile1" => '0',"mobile2" => '0',"employment_details" => '0',"remarks" => '0',"marital" => '0',"spouse_details" => '0',"wanted_remarks" => '0',"borrower_remarks" => '0',"contactAddress" => '0',"contactMobile_number" => '0',"employmentEmployer_name" => '0',"employmentDesignation" => '0',"employmentSalary_range" => '0',"employmentPay_date" => '0',"employmentAdvance_date" => '0',"employmentStaff_id" => '0',"employmentHired_on" => '0',"employmentDepartment" => '0',"employmentAddress" => '0',"employmentWork_location" => '0',"employmentPhone" => '0',"employmentFax" => '0',"spousedetailsFull_name" => '0',"spousedetailsGender" => '0',"spousedetailsDob" => '0',"spousedetailsNationality" => '0',"spousedetailsNric_new" => '0',"spousedetailsNric_old" => '0',"spousedetailsResident_address" => '0',"spousedetailsNric_address" => '0',"spousedetailsResident_address2" => '0',"spousedetailsRemarks" => '0',"spousedetailsMarital" => '0',"spousedetailsRace" => '0',"spouseMobile1" => '0',"spouseMobile2" => '0',"spousecontactsMobile" => '0',"spouseemploymentsEmployer_name" => '0',"spouseemploymentsDesignation" => '0',"spouseemploymentsSalary_range" => '0',"spouseemploymentsPay_date" => '0',"spouseemploymentsAdvance_date" => '0',"spouseemploymentsStaff_id" => '0',"spouseemploymentsHired_on" => '0',"spouseemploymentsDepartment" => '0',"spouseemploymentsAddress" => '0',"spouseemploymentsWork_location" => '0',"spouseemploymentsPhone" => '0',"spouseemploymentsFax" => '0',"guarantorsFull_name" => '0',"guarantorsNric_new" => '0',"guarantorsNric_old" => '0',"guarantorsRelation" => '0',"guarantorsResidence_address" => '0',"guarantorsOther_address" => '0',"guarantorsMobile1" => '0',"guarantorsMobile2" => '0',"guarantorsEmployer_name" => '0',"guarantorsDesignation" => '0',"guarantorsStaff_id" => '0',"guarantorsHired_on" => '0',"guarantorsDepartment" => '0',"guarantorsEmployer_address" => '0',"guarantorsWork_location" => '0',"guarantorsPhone" => '0',"guarantorsMarital" => '0',"guarantorsFax" => '0',"referencesFull_name" => '0',"referencesEmployer_name" => '0',"referencesRelation" => '0',"referencesDesignation" => '0',"referencesNric_new" => '0',"referencesNric_old" => '0',"referencesStaff_id" => '0',"referencesHired_on" => '0',"referencesDepartment" => '0',"referencesResidence_address" => '0',"referencesEmployer_address" => '0',"referencesOther_address" => '0',"referencesWork_location" => '0',"referencesMarital" => '0',"referencesPhone" => '0',"referencesFax" => '0',"referencesMobile1" => '0',"referencesMobile2" => '0',"remarksRemarks" => '0'
					));
					$this->db->insert();
				}
			}

			$this->db->query("SELECT * FROM borrower_guarantors WHERE borrower_id = " . $this->db->escape($id));
			$borrower['guarantors']= $this->db->getRowList();

			foreach($borrower['guarantors'] as $guarantor){
				if(!empty($borrower_update_id['borrower_id']) != $id && !empty($borrower_update_id['guarantor_id']) != $guarantor['guarantor_id']){
					$this->db->table("borrower_updates");
					$this->db->insertArray(array(
						"borrower_id" => $id,"guarantor_id" => $guarantor['guarantor_id'],"label_contacts" => '0',"label_employments" => '0',"label_spouse" => '0',"label_spouse_employments" => '0',"label_guarantor" => '0',"label_references" => '0',"label_remarks" => '0',"race" => '0',"owner" => '0',"full_name" => '0',"agent_id" => '0',"gender" => '0',"dob" => '0',"nationality" => '0',"nric_new" => '0',"nric_old" => '0',"resident_address" => '0',"nric_address" => '0',"resident_address2" => '0',"mobile1" => '0',"mobile2" => '0',"employment_details" => '0',"remarks" => '0',"marital" => '0',"spouse_details" => '0',"wanted_remarks" => '0',"borrower_remarks" => '0',"contactAddress" => '0',"contactMobile_number" => '0',"employmentEmployer_name" => '0',"employmentDesignation" => '0',"employmentSalary_range" => '0',"employmentPay_date" => '0',"employmentAdvance_date" => '0',"employmentStaff_id" => '0',"employmentHired_on" => '0',"employmentDepartment" => '0',"employmentAddress" => '0',"employmentWork_location" => '0',"employmentPhone" => '0',"employmentFax" => '0',"spousedetailsFull_name" => '0',"spousedetailsGender" => '0',"spousedetailsDob" => '0',"spousedetailsNationality" => '0',"spousedetailsNric_new" => '0',"spousedetailsNric_old" => '0',"spousedetailsResident_address" => '0',"spousedetailsNric_address" => '0',"spousedetailsResident_address2" => '0',"spousedetailsRemarks" => '0',"spousedetailsMarital" => '0',"spousedetailsRace" => '0',"spouseMobile1" => '0',"spouseMobile2" => '0',"spousecontactsMobile" => '0',"spouseemploymentsEmployer_name" => '0',"spouseemploymentsDesignation" => '0',"spouseemploymentsSalary_range" => '0',"spouseemploymentsPay_date" => '0',"spouseemploymentsAdvance_date" => '0',"spouseemploymentsStaff_id" => '0',"spouseemploymentsHired_on" => '0',"spouseemploymentsDepartment" => '0',"spouseemploymentsAddress" => '0',"spouseemploymentsWork_location" => '0',"spouseemploymentsPhone" => '0',"spouseemploymentsFax" => '0',"guarantorsFull_name" => '0',"guarantorsNric_new" => '0',"guarantorsNric_old" => '0',"guarantorsRelation" => '0',"guarantorsResidence_address" => '0',"guarantorsOther_address" => '0',"guarantorsMobile1" => '0',"guarantorsMobile2" => '0',"guarantorsEmployer_name" => '0',"guarantorsDesignation" => '0',"guarantorsStaff_id" => '0',"guarantorsHired_on" => '0',"guarantorsDepartment" => '0',"guarantorsEmployer_address" => '0',"guarantorsWork_location" => '0',"guarantorsPhone" => '0',"guarantorsMarital" => '0',"guarantorsFax" => '0',"referencesFull_name" => '0',"referencesEmployer_name" => '0',"referencesRelation" => '0',"referencesDesignation" => '0',"referencesNric_new" => '0',"referencesNric_old" => '0',"referencesStaff_id" => '0',"referencesHired_on" => '0',"referencesDepartment" => '0',"referencesResidence_address" => '0',"referencesEmployer_address" => '0',"referencesOther_address" => '0',"referencesWork_location" => '0',"referencesMarital" => '0',"referencesPhone" => '0',"referencesFax" => '0',"referencesMobile1" => '0',"referencesMobile2" => '0',"remarksRemarks" => '0'
					));
					$this->db->insert();
				}
			}

			$this->db->query("SELECT * FROM borrower_references WHERE borrower_id = " . $this->db->escape($id));
			$borrower['references']= $this->db->getRowList();

			foreach($borrower['references'] as $reference){
				if(!empty($borrower_update_id['borrower_id']) != $id && !empty($borrower_update_id['reference_id']) != $reference['reference_id']){
					$this->db->table("borrower_updates");
					$this->db->insertArray(array(
						"borrower_id" => $id,"reference_id" => $reference['reference_id'],"label_contacts" => '0',"label_employments" => '0',"label_spouse" => '0',"label_spouse_employments" => '0',"label_guarantor" => '0',"label_references" => '0',"label_remarks" => '0',"race" => '0',"owner" => '0',"full_name" => '0',"agent_id" => '0',"gender" => '0',"dob" => '0',"nationality" => '0',"nric_new" => '0',"nric_old" => '0',"resident_address" => '0',"nric_address" => '0',"resident_address2" => '0',"mobile1" => '0',"mobile2" => '0',"employment_details" => '0',"remarks" => '0',"marital" => '0',"spouse_details" => '0',"wanted_remarks" => '0',"borrower_remarks" => '0',"contactAddress" => '0',"contactMobile_number" => '0',"employmentEmployer_name" => '0',"employmentDesignation" => '0',"employmentSalary_range" => '0',"employmentPay_date" => '0',"employmentAdvance_date" => '0',"employmentStaff_id" => '0',"employmentHired_on" => '0',"employmentDepartment" => '0',"employmentAddress" => '0',"employmentWork_location" => '0',"employmentPhone" => '0',"employmentFax" => '0',"spousedetailsFull_name" => '0',"spousedetailsGender" => '0',"spousedetailsDob" => '0',"spousedetailsNationality" => '0',"spousedetailsNric_new" => '0',"spousedetailsNric_old" => '0',"spousedetailsResident_address" => '0',"spousedetailsNric_address" => '0',"spousedetailsResident_address2" => '0',"spousedetailsRemarks" => '0',"spousedetailsMarital" => '0',"spousedetailsRace" => '0',"spouseMobile1" => '0',"spouseMobile2" => '0',"spousecontactsMobile" => '0',"spouseemploymentsEmployer_name" => '0',"spouseemploymentsDesignation" => '0',"spouseemploymentsSalary_range" => '0',"spouseemploymentsPay_date" => '0',"spouseemploymentsAdvance_date" => '0',"spouseemploymentsStaff_id" => '0',"spouseemploymentsHired_on" => '0',"spouseemploymentsDepartment" => '0',"spouseemploymentsAddress" => '0',"spouseemploymentsWork_location" => '0',"spouseemploymentsPhone" => '0',"spouseemploymentsFax" => '0',"guarantorsFull_name" => '0',"guarantorsNric_new" => '0',"guarantorsNric_old" => '0',"guarantorsRelation" => '0',"guarantorsResidence_address" => '0',"guarantorsOther_address" => '0',"guarantorsMobile1" => '0',"guarantorsMobile2" => '0',"guarantorsEmployer_name" => '0',"guarantorsDesignation" => '0',"guarantorsStaff_id" => '0',"guarantorsHired_on" => '0',"guarantorsDepartment" => '0',"guarantorsEmployer_address" => '0',"guarantorsWork_location" => '0',"guarantorsPhone" => '0',"guarantorsMarital" => '0',"guarantorsFax" => '0',"referencesFull_name" => '0',"referencesEmployer_name" => '0',"referencesRelation" => '0',"referencesDesignation" => '0',"referencesNric_new" => '0',"referencesNric_old" => '0',"referencesStaff_id" => '0',"referencesHired_on" => '0',"referencesDepartment" => '0',"referencesResidence_address" => '0',"referencesEmployer_address" => '0',"referencesOther_address" => '0',"referencesWork_location" => '0',"referencesMarital" => '0',"referencesPhone" => '0',"referencesFax" => '0',"referencesMobile1" => '0',"referencesMobile2" => '0',"remarksRemarks" => '0'
					));
					$this->db->insert();
				}
			}

			$this->db->query("SELECT * FROM borrower_remarks WHERE borrower_id = " . $this->db->escape($id));
			$borrower['remarks']= $this->db->getRowList();

			$this->db->query("SELECT COUNT(*) AS amount FROM loan WHERE loan_status <> 99 AND loan_status <> 991 AND loan_status <> 4 AND borrower_id = " . $this->db->escape($id));
			$loan = $this->db->getSingleRow();

			$this->db->query("SELECT * FROM loan WHERE borrower_id = ".$this->db->escape($id)." AND loan_id = ".$this->db->escape($lid)."");
			$loanID = $this->db->getSingleRow();

			$this->db->query("SELECT admin_name,admin_id FROM user_admins WHERE role_type = 3 AND admin_status = 1");
			$admins = $this->db->getRowList();

			$this->db->query("SELECT * FROM borrower_updates WHERE borrower_id = ".$this->db->escape($id)."");
			$borrower_update = $this->db->getSingleRow();

			$this->db->query("SELECT * FROM borrower_updates WHERE borrower_id = ".$this->db->escape($id)." && contact_id <> ''");
			$ucontacts = $this->db->getRowList();
			$this->db->query("SELECT * FROM borrower_updates WHERE borrower_id = ".$this->db->escape($id)." && employment_id <> ''");
			$uemployments = $this->db->getRowList();
			$this->db->query("SELECT * FROM borrower_updates WHERE borrower_id = ".$this->db->escape($id)." && spouse_id <> ''");
			$uspouses = $this->db->getRowList();
			$this->db->query("SELECT * FROM borrower_updates WHERE borrower_id = ".$this->db->escape($id)." && spouse_employment_id <> ''");
			$uspouse_employments = $this->db->getRowList();
			$this->db->query("SELECT * FROM borrower_updates WHERE borrower_id = ".$this->db->escape($id)." && guarantor_id <> ''");
			$uguarantors = $this->db->getRowList();
			$this->db->query("SELECT * FROM borrower_updates WHERE borrower_id = ".$this->db->escape($id)." && reference_id <> ''");
			$ureferences = $this->db->getRowList();

			set('admins', $admins);
			set('borrower_update', $borrower_update);
			set('ucontacts', $ucontacts);
			set('uemployments', $uemployments);
			set('uspouses', $uspouses);
			set('uspouse_employments', $uspouse_employments);
			set('uguarantors', $uguarantors);
			set('ureferences', $ureferences);
			set('borrower', $borrower);
			set('profile_image', $profile_image);
			set('other_image', $other_image);
			set('loan', $loan);
			set('loanID', $loanID);
			set('countries', $this->countries());
			// set('states', $states);
			return render('modules/borrowers-update.php', 'layout/default.php');
		}
	}

	public function borrowerContactInsert($bid){
		set('borrower_id', $bid);
		set('countries', $this->countries());
		return render('modules/borrowers-contact-insert.php', 'layout/default.php');
	}

	public function borrowerContactUpdate($bid, $id){
		$this->db->query("SELECT * FROM borrower_contacts WHERE contact_id = " . $this->db->escape($id));
		$contact = $this->db->getSingleRow();
		$this->db->query("SELECT * FROM borrower_updates WHERE borrower_id = ".$this->db->escape($bid)." && contact_id = ".$this->db->escape($id)."");
		$update_contact = $this->db->getSingleRow();
		set('borrower_id', $bid);
		set('contact', $contact);
		set('update_contact', $update_contact);
		set('countries', $this->countries());
		return render('modules/borrowers-contact-update.php', 'layout/default.php');
	}

	public function borrowerEmploymentInsert($bid){
		$states = $this->state('129');
		set('borrower_id', $bid);
		set('countries', $this->countries());
		return render('modules/borrowers-employment-insert.php', 'layout/default.php');
	}

	public function borrowerEmploymentUpdate($bid, $id){
		$this->db->query("SELECT * FROM borrower_employments WHERE employment_id = " . $this->db->escape($id));
		$employment = $this->db->getSingleRow();
		$this->db->query("SELECT * FROM borrower_updates WHERE borrower_id = ".$this->db->escape($bid)." && employment_id = ".$this->db->escape($id)."");
		$update_contact = $this->db->getSingleRow();
		$states = $this->state('129');
		set('borrower_id', $bid);
		set('employment', $employment);
		set('update_contact', $update_contact);
		set('countries', $this->countries());
		return render('modules/borrowers-employment-update.php', 'layout/default.php');
	}

	public function borrowerSpouseInsert($bid){
		$states = $this->state('129');
		set('borrower_id', $bid);
		set('countries', $this->countries());
		return render('modules/borrowers-spouse-insert.php', 'layout/default.php');
	}

	public function borrowerSpouseUpdate($bid, $id){
		$this->db->query("SELECT * FROM borrower_spouse_contacts WHERE borrower_id = " . $this->db->escape($bid) . " AND spouse_id = " . $this->db->escape($id));
		$spouse_contacts = $this->db->getRowList();
		$this->db->query("SELECT * FROM borrowers_spouse_details WHERE spouse_id = " . $this->db->escape($id));
		$spouse = $this->db->getSingleRow();
		$this->db->query("SELECT * FROM borrower_updates WHERE borrower_id = ".$this->db->escape($bid)." && spouse_id = ".$this->db->escape($id)."");
		$update_contact = $this->db->getSingleRow();
		$states = $this->state('129');
		set('borrower_id', $bid);
		set('spouse_contacts', $spouse_contacts);
		set('spouse', $spouse);
		set('update_contact', $update_contact);
		set('countries', $this->countries());
		return render('modules/borrowers-spouse-update.php', 'layout/default.php');
	}

	public function borrowerSpouseEmploymentInsert($bid){
		set('borrower_id', $bid);
		set('countries', $this->countries());
		return render('modules/borrowers-spouse-employment-insert.php', 'layout/default.php');
	}

	public function borrowerSpouseEmploymentUpdate($bid, $id){
		$this->db->query("SELECT * FROM borrower_spouse_employments WHERE employment_id = " . $this->db->escape($id));
		$spouse_employment = $this->db->getSingleRow();
		$this->db->query("SELECT * FROM borrower_updates WHERE borrower_id = ".$this->db->escape($bid)." && spouse_employment_id = ".$this->db->escape($id)."");
		$update_contact = $this->db->getSingleRow();
		set('borrower_id', $bid);
		set('spouse_employment', $spouse_employment);
		set('update_contact', $update_contact);
		set('countries', $this->countries());
		return render('modules/borrowers-spouse-employment-update.php', 'layout/default.php');
	}

	public function borrowerGuarantorInsert($bid){
		set('borrower_id', $bid);
		set('countries', $this->countries());
		return render('modules/borrowers-guarantor-insert.php', 'layout/default.php');
	}

	public function borrowerGuarantorUpdate($bid, $id){
		$this->db->query("SELECT * FROM borrower_guarantors WHERE guarantor_id = " . $this->db->escape($id));
		$guarantor = $this->db->getSingleRow();

		$this->db->query("SELECT * FROM files WHERE parent_id = " .$this->db->escape($id));
		$files = $this->db->getRowList();

		$this->db->query("SELECT * FROM borrower_updates WHERE borrower_id = ".$this->db->escape($bid)." && guarantor_id = ".$this->db->escape($id)."");
		$update_contact = $this->db->getSingleRow();

		$profile_image = [];
		$other_image = [];
		foreach($files as $key => $val){
			if($val["profile_photo"] == "y"){
				array_push($profile_image, $val);
			}else{
				array_push($other_image, $val);
			}
		}

		set('borrower_id', $bid);
		set('guarantor', $guarantor);
		set('update_contact', $update_contact);
		set('profile_image', $profile_image);
		set('other_image', $other_image);
		set('countries', $this->countries());
		return render('modules/borrowers-guarantor-update.php', 'layout/default.php');
	}

	public function borrowerReferenceInsert($bid){
		set('borrower_id', $bid);
		set('countries', $this->countries());
		return render('modules/borrowers-reference-insert.php', 'layout/default.php');
	}

	public function borrowerReferenceUpdate($bid, $id){
		$this->db->query("SELECT * FROM borrower_references WHERE reference_id = " . $this->db->escape($id));
		$reference = $this->db->getSingleRow();
		$this->db->query("SELECT * FROM borrower_updates WHERE borrower_id = ".$this->db->escape($bid)." && reference_id = ".$this->db->escape($id)."");
		$update_contact = $this->db->getSingleRow();
		set('borrower_id', $bid);
		set('reference', $reference);
		set('update_contact', $update_contact);
		set('countries', $this->countries());
		return render('modules/borrowers-reference-update.php', 'layout/default.php');
	}

	public function borrowerRemarkInsert($bid){
		set('borrower_id', $bid);
		set('countries', $this->countries());
		return render('modules/borrowers-remark-insert.php', 'layout/default.php');
	}

	// public function borrowerRemarkUpdate($bid, $id){
	// 	$this->db->query("SELECT * FROM borrower_remarks WHERE borrower_id = " . $this->db->escape($id));
	// 	$reference = $this->db->getSingleRow();
	// 	set('borrower_id', $bid);
	// 	set('reference', $reference);
	// 	set('countries', $this->countries());
	// 	return render('modules/borrowers-remark-update.php', 'layout/default.php');
	// }



	public function customerInsert(){
		$states = $this->state('129');
		set('countries', $this->countries());
		set('states', $states);
		return render('management/customers-insert.php', 'layout/default.php');
	}




	// LMS - Loan
	public function loan(){

		if($this->admin->mapproval == '1'){
			$this->db->query("SELECT * FROM loan WHERE loan_status=3 OR loan_status=7 OR loan_status=5 OR loan_status=6 OR loan_status=2 OR loan_status=1 OR loan_status=8 OR loan_status=992 OR loan_status=990  ORDER BY FIELD(loan_status,5,2,6,3,7,1,8,992,990), borrower_id ASC");
			$keys = $this->db->getRowList();
		}
		else{
			$this->db->query("SELECT * FROM loan WHERE loan_status=3 OR loan_status=7 OR loan_status=5 OR loan_status=6 OR loan_status=2 OR loan_status=1 OR loan_status=8 OR loan_status=992 OR loan_status=990  ORDER BY FIELD(loan_status,3,7,5,2,6,1,8,992,990), borrower_id ASC");
			$keys = $this->db->getRowList();
		}

		if($keys){
			foreach($keys as $i => $key){
				$this->db->query("SELECT full_name FROM borrowers WHERE borrower_id = " .$this->db->escape($key['borrower_id']));
				$borrower = $this->db->getSingleRow();

				if(isset($borrower['full_name'])){
					$keys[$i]['borrower'] = $borrower['full_name'];
				}
				else{
					$keys[$i]['borrower'] = '';
				}


				$this->db->query("SELECT admin_name FROM user_admins WHERE admin_id = " .$this->db->escape($key['created_by']));
				$user = $this->db->getSingleRow();

				if(isset($user['admin_name'])){
					$keys[$i]['user'] = $user['admin_name'];
				}
				else{
					$keys[$i]['user'] = '';
				}
			}
		}

		set('keys', $keys);
		return render('management/loan.php', 'layout/default.php');
	}

	public function loanInsert(){
		$this->db->query("SELECT * FROM borrowers WHERE agent_id != '' AND borrower_status = 1 order by full_name ASC ");
		$borrower = $this->db->getRowList();

		set('borrowerNameList',$borrower);

		return render('management/loan-insert.php', 'layout/default.php');
	}

	public function loanInsertId($id){
		$this->db->query("SELECT * FROM borrowers WHERE borrower_id =".$this->db->escape($id)." order by full_name ASC ");
		$borrower = $this->db->getRowList();

		set('borrowerNameList',$borrower);

		return render('management/loan-insert-id.php', 'layout/default.php');
	}

	public function loanUpdate($id){
		$this->db->query("SELECT * FROM loan WHERE loan_id = ".$this->db->escape($id));
		$loan = $this->db->getSingleRow();

		if($loan){
			$this->db->query("SELECT full_name FROM borrowers WHERE borrower_id = " .$this->db->escape($loan['borrower_id']));
			$borrower = $this->db->getSingleRow();

		}

		set('loan',$loan);
		set('borrower',$borrower);

		return render('management/loan-update.php', 'layout/default.php');
	}

	public function loanView($id){
		$this->db->query("SELECT * FROM loan WHERE loan_status <> '99' AND loan_status <> '991' AND loan_status <> '4' AND borrower_id = ". $this->db->escape($id) ." ORDER BY FIELD(loan_status,3,7,5,2,6,1,8,992,990)");
		$keys = $this->db->getRowList();

		$this->db->query("SELECT * FROM borrowers WHERE borrower_id = " .$this->db->escape($id));
		$borrowerID = $this->db->getSingleRow();

		if($keys){
			foreach($keys as $i => $key){
				$this->db->query("SELECT full_name,borrower_status FROM borrowers WHERE borrower_id = " .$this->db->escape($key['borrower_id']));
				$borrower = $this->db->getSingleRow();

				$keys[$i]['borrower'] = $borrower['full_name'];
				$keys[$i]['borrower_status'] = $borrower['borrower_status'];

				$this->db->query("SELECT admin_name FROM user_admins WHERE admin_id = " .$this->db->escape($key['created_by']));
				$user = $this->db->getSingleRow();

				$keys[$i]['user'] = $user['admin_name'];
			}
		}

		set('keys', $keys);
		set('borrowerID', $borrowerID);
		return render('management/loan-view.php', 'layout/default.php');
	}

	public function loanApproval(){
		$this->db->query("SELECT * FROM loan WHERE loan_status <> '99' && loan_status = 4 ORDER BY loan_status DESC");
		$keys = $this->db->getRowList();

		if($keys){
			foreach($keys as $i => $key){
				$this->db->query("SELECT full_name FROM borrowers WHERE borrower_id = " .$this->db->escape($key['borrower_id']));
				$borrower = $this->db->getSingleRow();

				$keys[$i]['borrower'] = $borrower['full_name'];

				$this->db->query("SELECT admin_name FROM user_admins WHERE admin_id = " .$this->db->escape($key['created_by']));
				$user = $this->db->getSingleRow();

				$keys[$i]['user'] = $user['admin_name'];
			}
		}

		set('keys', $keys);
		return render('management/loan-approval.php', 'layout/default.php');
	}

	public function loanApprovalUpdate($id){
		$this->db->query("SELECT * FROM loan WHERE loan_id = ".$this->db->escape($id));
		$loan = $this->db->getSingleRow();

		if($loan){
			$this->db->query("SELECT full_name FROM borrowers WHERE borrower_id = " .$this->db->escape($loan['borrower_id']));
			$borrower = $this->db->getSingleRow();

		}

		set('loan',$loan);
		set('borrower',$borrower);

		return render('management/loan-approval-update.php', 'layout/default.php');
	}

	public function loanExport($id, $type){
		$this->db->query("SELECT * FROM loan WHERE loan_id = ".$this->db->escape($id));
		$loan = $this->db->getSingleRow();

		if($loan){
			$this->db->query("SELECT * FROM borrowers WHERE borrower_id = " .$this->db->escape($loan['borrower_id']));
			$borrower = $this->db->getSingleRow();

			$this->db->query("SELECT * FROM  borrower_contacts WHERE borrower_id = " .$this->db->escape($loan['borrower_id']));
			$borrower_contacts = $this->db->getSingleRow();

			$this->db->query("SELECT * FROM borrower_employments WHERE borrower_id = " .$this->db->escape($loan['borrower_id']));
			$borrower_employments = $this->db->getSingleRow();

			$w = array(45, 45, 45, 45);
			$pdf = new FPDF();
			$pdf->SetFont('Arial','B',10);
			$page = 1;
			$pdf->setFillColor(230,230,230);

			$pdf->AddPage();
			$pdf->Cell(array_sum($w),10,'AKTA PEMBERI PINJAMAN WANG 1951','',0,'C');
			$pdf->SetFont('Arial','',10);
			$pdf->Ln();
			$pdf->Cell(array_sum($w),10,'[Subsekyen 18(1)]','',0,'C');
			$pdf->Ln();
			$pdf->Cell(array_sum($w),10,'LEJAR AKAUN PEMINJAM','',0,'C');
			$pdf->Ln();
			$pdf->SetFont('Arial','B',10);
			$pdf->Cell(array_sum($w),10,'1. BUTIRAN PEMINJAM','',0,'LR');
			$pdf->SetFont('Arial','',10);
			$pdf->Ln();

			$pdf->SetFont('Arial','B',10);

			$pdf->Cell($w[0],10,'Nama ','1',0,'R',1);
			$pdf->SetFont('Arial','',10);
			$pdf->Cell($w[1] + $w[2] + $w[3],10,$borrower['full_name'],'1',0,'LR');
			$pdf->Ln();
			$pdf->SetFont('Arial','B',10);
			$pdf->Cell($w[0],10, 'No. K.P. ','1',0,'R',1);
			$pdf->SetFont('Arial','',10);
			$pdf->Cell($w[1],10, $borrower['nric_new'],'1',0,'LR');
			$pdf->SetFont('Arial','B',10);
			$pdf->Cell($w[2],10, 'Bangsa ','1',0,'R',1);
			$pdf->SetFont('Arial','',10);
			$pdf->Cell($w[3],10, $borrower['race'],'1',0,'LR');
			$pdf->Ln();
			$pdf->SetFont('Arial','B',10);
			$pdf->Cell($w[0],10, 'Pekerjaan ','1',0,'R',1);
			$pdf->SetFont('Arial','',10);
			$pdf->Cell($w[1] + $w[2] + $w[3],10, isset($borrower_employments['designation']) ? $borrower_employments['designation'] : '-','1',0,'LR');
			$pdf->Ln();
			$pdf->SetFont('Arial','B',10);
			$pdf->Cell($w[2],10, 'Pendapatan ','1',0,'R',1);
			$pdf->SetFont('Arial','',10);
			$pdf->Cell($w[1] + $w[2] + $w[3],10, isset($borrower_employments['salary_range']) ? $borrower_employments['salary_range'] : '-','1',0,'LR');
			$pdf->Ln();
			$pdf->SetFont('Arial','B',10);
			$pdf->Cell($w[0],10, 'Majikan ','1',0,'R',1);
			$pdf->SetFont('Arial','',10);
			$pdf->Cell($w[1] + $w[2] + $w[3],10, isset($borrower_employments['employer_name']) ? $borrower_employments['employer_name'] : '-','1',0,'LR');

			$size = explode(' ', $borrower_contacts['address']);
			$countNextLine = sizeOf($size);
			$pdf->Ln();
			$pdf->SetFont('Arial','B',10);



			$pdf->Cell($w[0] + $w[1] + $w[2] + $w[3], 10, 'Alamat Rumah ','1',0,'C',1);
			$pdf->Ln();
			$pdf->SetFont('Arial','',10);
			$pdf->Multicell($w[0] + $w[1] + $w[2] + $w[3], 5, $borrower_contacts['address'],1,'LR');

			$pdf->Ln();
			$pdf->Ln();
			$pdf->SetFont('Arial','B',10);
			//$pdf->SetFillColor(int r [, int g, int b]);
			$pdf->Cell(array_sum($w),10,'2. BUTIRAN PINJAMAN','',0,'LR');

			$w_2 = array(27, 27, 27, 27, 27, 27, 27, 27);
			$pdf->Ln();
			$x = $pdf->GetX();
			$y = $pdf->GetY();
			$push_right = 0;

			$pdf->SetFont('Arial','B',10);
			$pdf->Cell($w_2[0],20,'Tarikh','1',0,'C',1);
			$pdf->SetFont('Arial','',10);

			$pdf->SetFont('Arial','B',10);
			$pdf->Multicell($w_2[1],5,"Jumlah\nPinjaman\nPokok\n(RM)",1,"C",1);

			$push_right += $w_2[0] + $w_2[1];
			$pdf->SetXY($x + $push_right, $y);
			$pdf->SetFont('Arial','B',10);
			$pdf->Multicell($w_2[3],5,"Jumlah Faedah\n(RM)\n ",1,"C",1);

			$push_right += $w_2[2];
			$pdf->SetXY($x + $push_right, $y);
			$pdf->SetFont('Arial','B',10);


			$pdf->Multicell($w_2[4],5,"Kaedah\nFaedah\nBulanan\n(%)",1,"C",1);

			$push_right += $w_2[3];
			$pdf->SetXY($x + $push_right, $y);
			$pdf->SetFont('Arial','B',10);

			$pdf->Multicell($w_2[5],5,"Bercagar /\nTidak\nBercagar\n\n",1,"C",1);

			$push_right += $w_2[4];
			$pdf->SetXY($x + $push_right, $y);
			$pdf->SetFont('Arial','B',10);

			$pdf->Multicell($w_2[6],5,"Tempoh\nBayaran\n(Bulan)\n\n",1,"C",1);

			$push_right += $w_2[5];
			$pdf->SetXY($x + $push_right, $y);
			$pdf->SetFont('Arial','B',10);

			$pdf->Multicell($w_2[7],5,"Bayaran\nSebulan\n(RM)\n\n",1,"C",1);
			$pdf->Ln();

			$this->db->query("select SUM(interest) as interest, installment_amt from installment where installment_status IN (1,2,3,8,990,992) and loan_id = " .$this->db->escape($id) . ' group by interest');
			$interest = $this->db->getSingleRow();

			if($loan['loan_term'] == ''){
				$loan['loan_term'] = 'Faedah Sahaja';
			}
			if(empty($interest['interest'])){
				$interest['interest'] = '';
			}
			if(empty($interest['installment_amt'])){
				$interest['installment_amt'] = '';
			}

			$x = $pdf->GetX();
			$y = $pdf->GetY();
			$push_right = 0;
			$pdf->SetXY($x + $push_right, $y-5);
			$pdf->SetFont('Arial','',10);

			$date = date("d/m/y", strtotime($loan['loan_date']));

			$pdf->Cell($w_2[0],20,$date,'1',0,'C');
			$pdf->SetFont('Arial','',10);

			$pdf->SetFont('Arial','',10);
			$pdf->Multicell($w_2[1],20,$loan['loan_amt'],1,"C");

			$push_right += $w_2[0] + $w_2[1];
			$pdf->SetXY($x + $push_right, $y-5);
			$pdf->SetFont('Arial','',10);
			$pdf->Multicell($w_2[3],20,$interest['interest'],1,"C");

			$push_right += $w_2[2];
			$pdf->SetXY($x + $push_right, $y-5);
			$pdf->SetFont('Arial','',10);


			$pdf->Multicell($w_2[4],20,$loan['loan_interest_month'],1,"C");

			$push_right += $w_2[3];
			$pdf->SetXY($x + $push_right, $y-5);
			$pdf->SetFont('Arial','',10);

			$pdf->Multicell($w_2[5],5,"\nTidak\nBercagar\n\n",1,"C");

			$push_right += $w_2[4];
			$pdf->SetXY($x + $push_right, $y-5);
			$pdf->SetFont('Arial','',10);

			$pdf->Multicell($w_2[6],20,$loan['loan_term'],1,"C");

			$push_right += $w_2[5];
			$pdf->SetXY($x + $push_right, $y-5);
			$pdf->SetFont('Arial','',10);

			$pdf->Multicell($w_2[7],20,$interest['installment_amt'],1,"C");
			$pdf->Ln();
			$pdf->SetFont('Arial','B',10);
			$pdf->Cell(array_sum($w),10,'3. BUTIRAN BAYARAN BALIK','',0,'LR');
			$w_3 = array(19, 19, 19, 19, 19, 19, 19, 19, 21, 19);



			$this->db->query("SELECT * FROM installment WHERE loan_id = ".$this->db->escape($id)." and installment_status = 2 ORDER BY installment_id ASC");
			$keys = $this->db->getRowList();

			$pdf->Ln();

			$x = $pdf->GetX();
			$y = $pdf->GetY();
			$push_right = 0;

			$pdf->SetFont('Arial','B',10);
			$pdf->Cell($w_3[0],20,'Tarikh','1',0,'C',1);
			$pdf->SetFont('Arial','',10);

			$pdf->SetFont('Arial','B',10);
			$pdf->Multicell($w_3[1],5,"Jumlah\nBesar\nPinjaman\n(RM)",1,"C",1);

			$push_right += $w_3[0] + $w_3[1];
			$pdf->SetXY($x + $push_right, $y);
			$pdf->SetFont('Arial','B',10);
			$pdf->Multicell($w_3[2],5,"Jumlah\nPinjaman Pokok\n(RM)",1,"C",1);

			$push_right += $w_3[2];
			$pdf->SetXY($x + $push_right, $y);
			$pdf->SetFont('Arial','B',10);


			$pdf->Multicell($w_3[4],5,"Jumlah\nFaedah\n(RM)\n\n",1,"C",1);

			$push_right += $w_3[3];
			$pdf->SetXY($x + $push_right, $y);
			$pdf->SetFont('Arial','B',10);

			$pdf->Multicell($w_3[5],5,"Jumlah\nPokok\n(RM)\n\n",1,"C",1);

			$push_right += $w_3[4];
			$pdf->SetXY($x + $push_right, $y);
			$pdf->SetFont('Arial','B',10);

			$pdf->Multicell($w_3[6],5,"Bayaran\nBalik\nPinjaman\n(RM)",1,"C",1);

			$push_right += $w_3[5];
			$pdf->SetXY($x + $push_right, $y);
			$pdf->SetFont('Arial','B',10);

			$pdf->Multicell($w_3[7],5,"Baki\nPinjaman\n(RM)\n\n",1,"C",1);

			$push_right += $w_3[6];
			$pdf->SetXY($x + $push_right, $y);
			$pdf->SetFont('Arial','B',10);

			$pdf->Multicell($w_3[8],5,"Baki\nPinjaman\nPokok\n(RM)\n",1,"C",1);

			$push_right += $w_3[8];
			$pdf->SetXY($x + $push_right, $y);
			$pdf->SetFont('Arial','B',10);

			$pdf->Multicell($w_3[8],5,"Tarikh\nBayaran\nBalik\n\n",1,"C",1);

			$push_right += $w_3[8];
			$pdf->SetXY($x + $push_right, $y);
			$pdf->SetFont('Arial','B',10);

			$pdf->Multicell($w_3[9],5,"Status\nBayaran\nBalik\n\n",1,"C",1);
			$pdf->Ln();

			//print_r($keys);
			$x = $pdf->GetX();
			$y = $pdf->GetY() - 5;
			foreach($keys as $key){



				$push_right = 0;

				$pdf->SetFont('Arial','',10);
				$pdf->SetXY($x + $push_right, $y);

				$date = date("d/m/y", strtotime($key['loan_date']));

				$pdf->Cell($w_3[0],10, $date,'1',0,'C');
				$pdf->SetFont('Arial','',10);

				$pdf->SetFont('Arial','',10);
				$pdf->Multicell($w_3[1],10,$key['balance_bf_gross'],1,"C");

				$push_right += $w_3[0] + $w_3[1];
				$pdf->SetXY($x + $push_right, $y );
				$pdf->SetFont('Arial','',10);
				$pdf->Multicell($w_3[2],10,$key['balance_bf_principal'],1,"C");

				$push_right += $w_3[2];
				$pdf->SetXY($x + $push_right, $y);
				$pdf->SetFont('Arial','',10);


				$pdf->Multicell($w_3[4],10,$key['interest'],1,"C");

				$push_right += $w_3[3];
				$pdf->SetXY($x + $push_right, $y);
				$pdf->SetFont('Arial','',10);

				$pdf->Multicell($w_3[5],10,$key['principal'],1,"C");

				$push_right += $w_3[4];
				$pdf->SetXY($x + $push_right, $y);
				$pdf->SetFont('Arial','',10);

				$pdf->Multicell($w_3[6],10,$key['installment_amt'],1,"C");

				$push_right += $w_3[5];
				$pdf->SetXY($x + $push_right, $y);
				$pdf->SetFont('Arial','',10);

				$pdf->Multicell($w_3[7],10,$key['balance_cf_gross'],1,"C");

				$push_right += $w_3[6];
				$pdf->SetXY($x + $push_right, $y);
				$pdf->SetFont('Arial','',10);

				$pdf->Multicell($w_3[8],10,$key['balance_cf_principal'],1,"C");

				$push_right += $w_3[8];
				$pdf->SetXY($x + $push_right, $y);
				$pdf->SetFont('Arial','',10);

				$myDateTime = DateTime::createFromFormat('Y-m-d H:i:s', $key['updated_date']);
				$updated_date = $myDateTime->format('d/m/y');


				$pdf->Multicell($w_3[8],10,$updated_date,1,"C");

				$push_right += $w_3[8];
				$pdf->SetXY($x + $push_right, $y);
				$pdf->SetFont('Arial','',10);

				$pdf->Multicell($w_3[9],10,"Selesai",1,"C");
				$y += 10;

			}

			if($type == 'csv'){
				$content[] = array(
					'1. BUTIRAN PINJAMAN',
				);

				$content[] = array(
					'Nama',
					'No. K.P.',
					'Pekerjaan',
					'Bangsa',
					'Pendapatan',
					'Majikan',
					'Alamat Rumah'
				);


				$content[] = array(
					$borrower['full_name'],
					$borrower['nric_new'],
					$borrower_employments['designation'],
					$borrower['race'],
					$borrower_employments['salary_range'],
					$borrower_employments['employer_name'],
					$borrower_contacts['address']
				);
				$content[] = array(

				);

				$content[] = array(
					'2. BUTIRAN PINJAMAN',
				);
				$content[] = array(
					'Tarikh',
					'Jumlah Pinjaman Pokok (RM)',
					'Jumlah Faedah (RM)',
					'Kaedah Faedah Bulanan (%)',
					'Bercagar / Tidak Bercagar',
					'Tempoh Bayaran (Bulan)',
					'Bayaran Sebulan (RM)'
				);
				$content[] = array(
					$date,
					$loan['loan_amt'],
					$interest['interest'],
					$loan['loan_interest_month'],
					'Tidak Bercagar',
					$loan['loan_term'],
					$interest['installment_amt']
				);
				$content[] = array(

				);
				$content[] = array(
					'3. BUTIRAN BAYARAN BALIK'
				);
				$content[] = array(
					'Tarikh.',
					'Jumlah Besar Pinjaman(RM)',
					'Jumlah Pinjaman Pokok(RM)',
					'Jumlah Faedah(RM)',
					'Jumlah Pokok',
					'Bayaran Balik Pinjaman(RM)',
					'Baki Pinjaman(RM)',
					'Baki Pinjaman Pokok(RM)',
					'Tarikh Bayaran Balik',
					'Status Bayaran Balik',
				);

				foreach($keys as $i => $key){
					$date = date("d/m/y", strtotime($key['loan_date']));

					$myDateTime = DateTime::createFromFormat('Y-m-d H:i:s', $key['updated_date']);
					$updated_date = $myDateTime->format('d/m/y');
					$content[] = array(
						$date,
						$key['balance_bf_gross'],
						$key['balance_bf_principal'],
						$key['interest'],
						$key['principal'],
						$key['installment_amt'],
						$key['balance_cf_gross'],
						$key['balance_cf_principal'],
						$updated_date,
						'Selesai'
					);
				}

				header('Content-Encoding: UTF-8');
				header('Content-Type: text/csv; charset=UTF-8');
				header('Content-Disposition: attachment;filename="loan_report.csv"');
				header('Cache-Control: max-age=0');

				$fp = fopen('php://output', 'wb');
				//fprintf($fp, chr(0xEF).chr(0xBB).chr(0xBF));

				foreach ($content as $line) {
					fputcsv($fp, $line, ',');
				}
				fclose($fp);
				exit();
				return render('management/loan-update.php', 'layout/default.php');
			}
			else{
				$pdf->output();
			}
		}




	}

	public function loanRecovery($id){
		$this->db->query("SELECT * FROM installment WHERE loan_id = ".$this->db->escape($id)." ORDER BY installment_id ASC");
		$keys = $this->db->getRowList();

		//print_r($keys);

		if($keys){
			foreach($keys as $i=>$key){
				$this->db->query("SELECT SUM(amount_paid) AS total_late FROM recovery WHERE installment_id = " .$this->db->escape($key['installment_id']));
				$late = $this->db->getSingleRow();

				//print_r($late);

				$keys[$i]['total_late'] = $late['total_late'];
			}
		}

		set('keys', $keys);
		return render('management/loan-recovery.php', 'layout/default.php');
	}

	// LMS - Recovery
	public function recovery(){

		$this->db->query("SELECT a.*,b.loan_id,b.date_created,b.loan_status,c.agent_id FROM installment a, loan b, borrowers c
							WHERE a.installment_status IN ('1','3')
							AND (a.Months = DATE_FORMAT(CURRENT_DATE + INTERVAL 1 MONTH, '%m') AND a.Year = DATE_FORMAT(CURRENT_DATE, '%Y') OR a.loan_date < CURRENT_DATE + INTERVAL 1 MONTH)
							AND a.loan_id = b.loan_id
							AND b.loan_status <> 99
							AND b.loan_status <> 0
							AND a.borrower_id = c.borrower_id
							ORDER BY a.loan_date ASC
						");
		$recovery = $this->db->getRowList();

		if($recovery){
			foreach($recovery as $i => $key){
				$this->db->query("SELECT full_name,agent_id FROM borrowers WHERE borrower_id = " .$this->db->escape($recovery[$i]['borrower_id']));
				$borrower = $this->db->getSingleRow();

				$recovery[$i]['borrower'] = $borrower['full_name'];

				$this->db->query("SELECT admin_name FROM user_admins WHERE admin_id = " .$this->db->escape($recovery[$i]['admin_id']));
				$officer = $this->db->getSingleRow();

				if(isset($officer['admin_name'])){
					$recovery[$i]['officer'] = $officer['admin_name'];
				}
			}
		}


		set('recovery',$recovery);
		return render('management/recovery.php', 'layout/default.php');
	}

	public function recoveryUpdate($id){
		$this->db->query("SELECT * FROM installment WHERE installment_id = ".$this->db->escape($id));
		$recovery = $this->db->getSingleRow();

		if($recovery){
			$this->db->query("SELECT full_name FROM borrowers WHERE borrower_id = " .$this->db->escape($recovery['borrower_id']));
			$borrower = $this->db->getSingleRow();

			$this->db->query("SELECT receipts, remarks FROM recovery WHERE installment_id = " .$this->db->escape($recovery['installment_id'])." ORDER BY recovery_id DESC LIMIT 1");
			$remarks = $this->db->getSingleRow();

			$receipts = !empty($remarks['receipts']) ? unserialize(stripslashes($remarks['receipts'])) : '';
		}

		set('recovery',$recovery);
		set('borrower',$borrower);
		set('remarks',$remarks);
		set('receipts',$receipts);

		return render('management/recovery-update.php', 'layout/default.php');
	}

	public function risk(){

		$this->db->query("SELECT a.*,b.full_name FROM recovery a, borrowers b
						WHERE a.recovery_status = 4
						AND b.borrower_id = a.borrower_id
						");
		$risk = $this->db->getRowList();


		set('risk',$risk);
		return render('management/risk.php', 'layout/default.php');
	}

	public function riskUpdate($id){
		$this->db->query("SELECT a.*,b.rejection FROM recovery a,installment b WHERE a.recovery_id = ".$this->db->escape($id),);
		$risk = $this->db->getSingleRow();

		if($risk){
			$this->db->query("SELECT full_name FROM borrowers WHERE borrower_id = " .$this->db->escape($risk['borrower_id']));
			$borrower = $this->db->getSingleRow();
			$this->db->query("SELECT receipts, remarks FROM recovery WHERE installment_id = " .$this->db->escape($risk['installment_id'])." ORDER BY recovery_id DESC LIMIT 1");
			$remarks = $this->db->getSingleRow();

			$receipts = !empty($remarks['receipts']) ? unserialize(stripslashes($remarks['receipts'])) : '';
			$risk['receipt'] = unserialize(stripslashes($risk['receipts']));

		}

		set('risk',$risk);
		set('borrower',$borrower);
		set('receipts',$receipts);

		return render('management/risk-update.php', 'layout/default.php');
	}

	// COLLECTION
	public function collection(){

		$this->db->query("SELECT a.*,b.full_name,c.installment_status FROM recovery a, borrowers b, installment c
						WHERE a.recovery_status = 2
						AND b.borrower_id=a.borrower_id 
						
						AND a.installment_id= c.installment_id
						
						");
		$risk = $this->db->getRowList();


		set('risk',$risk);
		return render('management/collection.php', 'layout/default.php');
	}

	// REPORT
	public function reportLoan(){
		$date_from = $this->request('date_from') ? $this->request('date_from') : date('Y-m-01');
		$date_to = $this->request('date_to') ? $this->request('date_to') : date('Y-m-d');

		$this->db->query("SELECT * FROM loan l LEFT JOIN borrowers b ON l.borrower_id = b.borrower_id WHERE (loan_status = 1 OR loan_status = 8) AND date_created BETWEEN '" . $date_from . "' AND '" . $date_to . "'");
		$keys = $this->db->getRowList();

		if($keys){
			foreach($keys as $i => $key){
				// get loan balance
				$this->db->query("SELECT SUM(principal) AS principal_amount FROM installment WHERE loan_id = " .$this->db->escape($key['loan_id']). " AND installment_status = 2");
				$principal_amount = $this->db->getSingleRow();

				$keys[$i]['principal'] = $key['loan_amt'] - $principal_amount['principal_amount'];
				$keys[$i]['created_by'] = $this->db->getValue("SELECT admin_username FROM user_admins WHERE admin_id = " . $this->db->escape($key['created_by']));
			}

			if($this->request('export')){
				$content[] = array(
					'No.',
					'Borrower Name',
					'Loan ID',
					'Loan Creation Date',
					'Loan Amount (RM)',
					'Terms (Years)',
					'Interest (%)',
					'Loan Status',
					'Created By'
				);

				foreach($keys as $i => $key){
					if($key['loan_term'] > '0'){
						$content[] = array(
							$i+1,
							$key['full_name'],
							substr($key['date_created'], 0, 4) . '0' . $key['loan_id'],
							$key['date_created'],
							number_format($key['loan_amt'], 2, '.', ','),
							$key['loan_term'],
							$key['loan_interest_month'],
							$key['loan_status'],
							$key['created_by']
						);
					}
					else{
						$content[] = array(
							$i+1,
							$key['full_name'],
							substr($key['date_created'], 0, 4) . '0' . $key['loan_id'],
							$key['date_created'],
							number_format($key['loan_amt'], 2, '.', ','),
							'Interest Only',
							$key['loan_interest_month'],
							$key['loan_status'],
							$key['created_by']
						);
					}
				}

				header('Content-Encoding: UTF-8');
				header('Content-Type: text/csv; charset=UTF-8');
				header('Content-Disposition: attachment;filename="report_loan_' . ($date_from != $date_to ? $date_from . '_' . $date_to : $date_from) . '.csv"');
				header('Cache-Control: max-age=0');

				$fp = fopen('php://output', 'wb');
				//fprintf($fp, chr(0xEF).chr(0xBB).chr(0xBF));

				foreach ($content as $line) {
					fputcsv($fp, $line, ',');
				}
				fclose($fp);
				exit();
			}
		}

		set('date_from', $date_from);
		set('date_to', $date_to);
		set('keys', $keys);
		return render('report/report-loan.php', 'layout/default.php');
	}

	public function reportPayment(){
		$date_from = $this->request('date_from') ? $this->request('date_from') : date('Y-m-01');
		$date_to = $this->request('date_to') ? $this->request('date_to') : date('Y-m-d');

		$this->db->query("SELECT * FROM recovery r LEFT JOIN loan l ON r.loan_id = l.loan_id LEFT JOIN borrowers b ON r.borrower_id = b.borrower_id WHERE  recovery_status = 2 AND r.date_created BETWEEN '" . $date_from . "' AND '" . $date_to . "'");
		$keys = $this->db->getRowList();

		if($keys){
			foreach($keys as $i => $key){
				// get loan balance
				$this->db->query("SELECT SUM(principal) AS principal_sum FROM installment WHERE loan_id = " . $this->db->escape($key['loan_id']) . " AND installment_status = 2");
				$principal_amount = $this->db->getSingleRow();
				//print_r($principal_amount);

				$keys[$i]['principal'] = $key['loan_amt'] - $principal_amount['principal_sum'];
			}

			if($this->request('export')){
				$content[] = array(
					'No.',
					'Borrower Name',
					'Loan ID',
					'Loan Amount (RM)',
					'Last Payment Date',
					'Loan Balance (RM)',
					'Terms (Years)',
					'Interest (%)',
				);

				foreach($keys as $i => $key){
					if($key['loan_term'] > '0'){
						$content[] = array(
							$i+1,
							$key['full_name'],
							substr($key['date_created'], 0, 4) . '0' . $key['loan_id'],
							number_format($key['loan_amt'], 2, '.', ','),
							$key['date_created'],
							number_format($key['principal'], 2, '.', ','),
							$key['loan_term'],
							$key['loan_interest_month']
						);
					}
					else{
						$content[] = array(
							$i+1,
							$key['full_name'],
							substr($key['date_created'], 0, 4) . '0' . $key['loan_id'],
							number_format($key['loan_amt'], 2, '.', ','),
							$key['date_created'],
							number_format($key['principal'], 2, '.', ','),
							'Interest Only',
							$key['loan_interest_month']
						);
					}
				}

				header('Content-Encoding: UTF-8');
				header('Content-Type: text/csv; charset=UTF-8');
				header('Content-Disposition: attachment;filename="report_payment_' . ($date_from != $date_to ? $date_from . '_' . $date_to : $date_from) . '.csv"');
				header('Cache-Control: max-age=0');

				$fp = fopen('php://output', 'wb');
				//fprintf($fp, chr(0xEF).chr(0xBB).chr(0xBF));

				foreach ($content as $line) {
					fputcsv($fp, $line, ',');
				}
				fclose($fp);
				exit();
			}
		}

		set('date_from', $date_from);
		set('date_to', $date_to);
		set('keys', $keys);
		return render('report/report-payment.php', 'layout/default.php');
	}

	public function reportCollectionReport(){
		$this->db->query("SELECT * FROM loan l LEFT JOIN borrowers b ON l.borrower_id = b.borrower_id WHERE (loan_status = 1 OR loan_status = 8 OR loan_status = 990) ORDER BY full_name ASC");
		$select = $this->db->getRowList();

		$date_from = $this->request('date_from') ? $this->request('date_from') : "";
		$date_to = $this->request('date_to') ? $this->request('date_to') : "";
		$borrower_id = $this->request('borrowerID');

		if($date_from != '' && $date_to != ''){
			$this->db->query("SELECT * FROM recovery WHERE recovery_status = 2 AND paid_date BETWEEN '" . $date_from . "' AND '" . $date_to . "' ORDER BY loan_id ASC, paid_date ASC");
			$keys = $this->db->getRowList();

			$this->db->query("SELECT SUM(amount_paid) AS total FROM recovery WHERE recovery_status = 2 AND paid_date BETWEEN '" . $date_from . "' AND '" . $date_to . "'");
			$total_amount = $this->db->getSingleRow();
		}
		else if($borrower_id){
			$this->db->query("SELECT * FROM recovery WHERE recovery_status = 2 AND loan_id = '" . $borrower_id . "' ORDER BY paid_date ASC");
			$keys = $this->db->getRowList();

			$this->db->query("SELECT SUM(amount_paid) AS total FROM recovery WHERE recovery_status = 2 AND loan_id = '" . $borrower_id . "'");
			$total_amount = $this->db->getSingleRow();
		}
		else{
			$this->db->query("SELECT * FROM recovery WHERE recovery_status = 2 ORDER BY loan_id ASC, paid_date ASC");
			$keys = $this->db->getRowList();

			$this->db->query("SELECT SUM(amount_paid) AS total FROM recovery WHERE recovery_status = 2");
			$total_amount = $this->db->getSingleRow();
		}

		if($keys){
			foreach($keys as $i => $key){
				$this->db->query("SELECT * FROM borrowers WHERE borrower_id = " .$this->db->escape($key['borrower_id']). "");
				$borrower = $this->db->getSingleRow();

				if(isset($borrower['full_name']) || isset($borrower['borrower_id'])){
					$keys[$i]['borrower_id'] = $borrower['borrower_id'];
					$keys[$i]['full_name'] = $borrower['full_name'];
				}

				$this->db->query("SELECT * FROM loan WHERE loan_id = " .$this->db->escape($key['loan_id']). "");
				$loan = $this->db->getSingleRow();

				if(isset($loan['loan_amt']) || isset($loan['loan_interest_month']) || isset($loan['date_created'])){
					$keys[$i]['loan_amt'] = $loan['loan_amt'];
					$keys[$i]['loan_interest_month'] = $loan['loan_interest_month'];
					$keys[$i]['date_created'] = $loan['date_created'];
				}

				$this->db->query("SELECT * FROM installment WHERE installment_id = " .$this->db->escape($key['installment_id']). "");
				$installment = $this->db->getSingleRow();

				if(isset($installment['payment_date']) || isset($installment['balance_cf_principal']) || isset($installment['interest']) || isset($installment['principal'])){
					$keys[$i]['payment_date'] = strftime('%d-%m-%Y', strtotime($installment['payment_date']));
					$keys[$i]['balance_cf_principal'] = $installment['balance_cf_principal'];
					$keys[$i]['interest'] = $installment['interest'];
					$keys[$i]['principal'] = $installment['principal'];
				}
			}

			if($this->request('exportdate')){
				$content[] = array(
					'No.',
					'Borrower Name',
					'Loan ID',
					'Installment Date',
					'Principal Amount',
					'Monthly Repayment',
					'Balance Principal',
					'Payment Method',
					'Interest(%)',
					'Interest',
					'Principal',
					'Paid Amount',
					'Collection Date',
					'Status'
				);

				foreach($keys as $i => $key){
					$this->db->query("SELECT * FROM borrowers WHERE borrower_id = " .$this->db->escape($key['borrower_id']). "");
					$borrower = $this->db->getSingleRow();

					$this->db->query("SELECT * FROM loan WHERE loan_id = " .$this->db->escape($key['loan_id']). "");
					$loan = $this->db->getSingleRow();

					$this->db->query("SELECT * FROM installment WHERE installment_id = " .$this->db->escape($key['installment_id']). "");
					$installment = $this->db->getSingleRow();

					if($key['pay_type'] == '1'){
						$key['pay_type'] = "Both (Principal + Interest)";
					}
					if($key['pay_type'] == '2'){
						$key['pay_type'] = "Interest Amount";
					}
					if($key['pay_type'] == '3'){
						$key['pay_type'] = "Rescheduling";
					}
					if($key['pay_type'] == '4'){
						$key['pay_type'] = "Partial Payment";
					}
					if($key['pay_type'] == '5'){
						$key['pay_type'] = "Late Charges";
					}
					if($key['pay_type'] == '6'){
						$key['pay_type'] = "Full Settlement";
					}

					if($key['amount_paid'] == $installment['interest']){
						$key['recovery_status'] = "Interest Paid";
					}
					else{
						$key['recovery_status'] = "Paid";
					}

					$content[] = array(
						$i+1,
						$borrower['full_name'],
						substr($loan['date_created'],0,4).'0'.$loan['loan_id'],
						$installment['payment_date'],
						number_format($loan['loan_amt'], 2, '.', ','),
						number_format($key['actual_amount'], 2, '.', ','),
						number_format($installment['balance_cf_principal'], 2, '.', ','),
						$key['pay_type'],
						$loan['loan_interest_month'],
						number_format($installment['interest'], 2, '.', ','),
						number_format($installment['principal'], 2, '.', ','),
						number_format($key['amount_paid'], 2, '.', ','),
						$key['paid_date'],
						$key['recovery_status']
					);
				}

				header('Content-Encoding: UTF-8');
				header('Content-Type: text/csv; charset=UTF-8');
				header('Content-Disposition: attachment;filename="report_collection_' . ($date_from != $date_to ? $date_from . '_' . $date_to : $date_from) . '.csv"');
				header('Cache-Control: max-age=0');

				$fp = fopen('php://output', 'wb');
				//fprintf($fp, chr(0xEF).chr(0xBB).chr(0xBF));

				foreach ($content as $line) {
					fputcsv($fp, $line, ',');
				}
				fclose($fp);
				exit();
			}

			else if($this->request('exportborrower')){
				$content[] = array(
					'No.',
					'Borrower Name',
					'Loan ID',
					'Installment Date',
					'Principal Amount',
					'Monthly Repayment',
					'Balance Principal',
					'Payment Method',
					'Interest(%)',
					'Interest',
					'Principal',
					'Paid Amount',
					'Collection Date',
					'Status'
				);

				foreach($keys as $i => $key){
					$this->db->query("SELECT * FROM borrowers WHERE borrower_id = " .$this->db->escape($key['borrower_id']). "");
					$borrower = $this->db->getSingleRow();

					$borrower_name = $borrower['full_name'];

					$this->db->query("SELECT * FROM loan WHERE loan_id = " .$this->db->escape($key['loan_id']). "");
					$loan = $this->db->getSingleRow();

					$this->db->query("SELECT * FROM installment WHERE installment_id = " .$this->db->escape($key['installment_id']). "");
					$installment = $this->db->getSingleRow();

					if($key['pay_type'] == '1'){
						$key['pay_type'] = "Both (Principal + Interest)";
					}
					if($key['pay_type'] == '2'){
						$key['pay_type'] = "Interest Amount";
					}
					if($key['pay_type'] == '3'){
						$key['pay_type'] = "Rescheduling";
					}
					if($key['pay_type'] == '4'){
						$key['pay_type'] = "Partial Payment";
					}
					if($key['pay_type'] == '5'){
						$key['pay_type'] = "Late Charges";
					}
					if($key['pay_type'] == '6'){
						$key['pay_type'] = "Full Settlement";
					}

					if($key['amount_paid'] == $installment['interest']){
						$key['recovery_status'] = "Interest Paid";
					}
					else{
						$key['recovery_status'] = "Paid";
					}

					$content[] = array(
						$i+1,
						$borrower['full_name'],
						substr($loan['date_created'],0,4).'0'.$loan['loan_id'],
						$installment['payment_date'],
						number_format($loan['loan_amt'], 2, '.', ','),
						number_format($key['actual_amount'], 2, '.', ','),
						number_format($installment['balance_cf_principal'], 2, '.', ','),
						$key['pay_type'],
						$loan['loan_interest_month'],
						number_format($installment['interest'], 2, '.', ','),
						number_format($installment['principal'], 2, '.', ','),
						number_format($key['amount_paid'], 2, '.', ','),
						$key['paid_date'],
						$key['recovery_status']
					);
				}

				header('Content-Encoding: UTF-8');
				header('Content-Type: text/csv; charset=UTF-8');
				header('Content-Disposition: attachment;filename="report_collection_' . $borrower_name . '.csv"');
				header('Cache-Control: max-age=0');

				$fp = fopen('php://output', 'wb');
				//fprintf($fp, chr(0xEF).chr(0xBB).chr(0xBF));

				foreach ($content as $line) {
					fputcsv($fp, $line, ',');
				}
				fclose($fp);
				exit();
			}
		}
		set('total_amount',$total_amount);
		set('borrower_id',$borrower_id);
		set('select',$select);
		set('date_from', $date_from);
		set('date_to', $date_to);
		set('keys', $keys);
		return render('report/report-collection-report.php', 'layout/default.php');
	}

	public function reportCollectionScheduleReport(){
		$this->db->query("SELECT * FROM loan l LEFT JOIN borrowers b ON l.borrower_id = b.borrower_id WHERE (loan_status = 1 OR loan_status = 8 OR loan_status = 990) ORDER BY full_name ASC");
		$select = $this->db->getRowList();

//		$date_from = $this->request('date_from') ? $this->request('date_from') : "";
//		$date_to = $this->request('date_to') ? $this->request('date_to') : "";
		$borrower_id = $this->request('borrowerID');

//		if($date_from != '' && $date_to != ''){
//			$this->db->query("SELECT * FROM installment WHERE installment_status <> 99 AND payment_date BETWEEN '" . $date_from . "' AND '" . $date_to . "' ORDER BY loan_id ASC, year ASC");
//			$keys = $this->db->getRowList();
//
//			$this->db->query("SELECT SUM(interest + principal) AS total FROM installment WHERE installment_status <> 99 AND payment_date BETWEEN '" . $date_from . "' AND '" . $date_to . "'");
//			$total_amount = $this->db->getSingleRow();
//		}
		if($borrower_id){
			$this->db->query("SELECT * FROM installment WHERE installment_status <> 99 AND loan_id = '" . $borrower_id . "' ORDER BY loan_id ASC, year ASC");
			$keys = $this->db->getRowList();

			$this->db->query("SELECT SUM(interest + principal) AS total_paid FROM installment WHERE installment_status = 2 AND loan_id = '" . $borrower_id . "'");
			$total_paid_amount = $this->db->getSingleRow();

			$this->db->query("SELECT SUM(interest + principal) AS total_unpaid FROM installment WHERE installment_status <> 2 AND installment_status <> 99 AND loan_id = '" . $borrower_id . "'");
			$total_unpaid_amount = $this->db->getSingleRow();
		}
		else{
			$this->db->query("SELECT * FROM installment WHERE installment_status <> 99 ORDER BY loan_id ASC, year ASC");
			$keys = $this->db->getRowList();

			$this->db->query("SELECT SUM(interest + principal) AS total_paid FROM installment WHERE installment_status = 2");
			$total_paid_amount = $this->db->getSingleRow();

			$this->db->query("SELECT SUM(interest + principal) AS total_unpaid FROM installment WHERE installment_status <> 2 AND installment_status <> 99");
			$total_unpaid_amount = $this->db->getSingleRow();
		}

		if($keys){
			foreach($keys as $i => $key){
				$this->db->query("SELECT * FROM loan WHERE loan_id = " .$this->db->escape($key['loan_id']). "");
				$loan = $this->db->getSingleRow();

				if(isset($loan['loan_amt']) || isset($loan['loan_interest_month']) || isset($loan['date_created'])){
					$keys[$i]['loan_amt'] = $loan['loan_amt'];
					$keys[$i]['loan_interest_month'] = $loan['loan_interest_month'];
					$keys[$i]['date_created'] = $loan['date_created'];
				}

				$this->db->query("SELECT * FROM borrowers WHERE borrower_id = " .$this->db->escape($loan['borrower_id']). "");
				$borrower = $this->db->getSingleRow();

				$keys[$i]['borrower_id'] = $borrower['borrower_id'];
				$keys[$i]['full_name'] = $borrower['full_name'];

				$keys[$i]['inst_amt'] = $key['interest'] + $key['principal'];

				$this->db->query("SELECT * FROM recovery WHERE installment_id = " .$this->db->escape($key['installment_id']). " ORDER BY recovery_id ASC LIMIT 1");
				$recovery = $this->db->getSingleRow();

				if(isset($recovery['actual_amount'])){
					$keys[$i]['actual_amount'] = $recovery['actual_amount'];
				}
			}

//			if($this->request('exportdate')){
//				$content[] = array(
//					'No.',
//					'Borrower Name',
//					'Loan ID',
//					'Installment Date',
//					'Principal Amount',
//					'Monthly Repayment',
//					'Balance Principal',
//					'Payment Method',
//					'Interest(%)',
//					'Interest',
//					'Principal',
//					'Paid Amount',
//					'Collection Date',
//					'Status'
//				);
//
//				foreach($keys as $i => $key){
//					$this->db->query("SELECT * FROM loan WHERE loan_id = " .$this->db->escape($key['loan_id']). "");
//					$loan = $this->db->getSingleRow();
//
//					$this->db->query("SELECT * FROM borrowers WHERE borrower_id = " .$this->db->escape($key['borrower_id']). "");
//					$borrower = $this->db->getSingleRow();
//
//					$inst_amt = $key['interest'] + $key['principal'];
//
//					if($key['installment_status'] == '2'){
//						$key['installment_status'] = "Paid";
//					}
//					else{
//						$key['installment_status'] = "Unpaid";
//					}
//
//					$content[] = array(
//						$i+1,
//						$borrower['full_name'],
//						substr($loan['date_created'],0,4).'0'.$loan['loan_id'],
//						$key['payment_date'],
//						number_format($loan['loan_amt'], 2, '.', ','),
//						number_format($inst_amt, 2, '.', ','),
//						number_format($key['balance_cf_principal'], 2, '.', ','),
//						'Both (Principal + Interest)',
//						$loan['loan_interest_month'],
//						number_format($key['interest'], 2, '.', ','),
//						number_format($key['principal'], 2, '.', ','),
//						number_format($inst_amt, 2, '.', ','),
//						$key['payment_date'],
//						$key['installment_status']
//					);
//				}
//
//				header('Content-Encoding: UTF-8');
//				header('Content-Type: text/csv; charset=UTF-8');
//				header('Content-Disposition: attachment;filename="report_collection_schedule_' . ($date_from != $date_to ? $date_from . '_' . $date_to : $date_from) . '.csv"');
//				header('Cache-Control: max-age=0');
//
//				$fp = fopen('php://output', 'wb');
//				//fprintf($fp, chr(0xEF).chr(0xBB).chr(0xBF));
//
//				foreach ($content as $line) {
//					fputcsv($fp, $line, ',');
//				}
//				fclose($fp);
//				exit();
//			}

			if($this->request('exportborrower')){
				$content[] = array(
					'No.',
					'Borrower Name',
					'Loan ID',
					'Installment Date',
					'Principal Amount',
					'Monthly Repayment',
					'Balance Principal',
					'Payment Method',
					'Interest(%)',
					'Interest',
					'Principal',
					'Paid Amount',
					'Collection Date',
					'Status'
				);

				foreach($keys as $i => $key){
					$this->db->query("SELECT * FROM loan WHERE loan_id = " .$this->db->escape($key['loan_id']). "");
					$loan = $this->db->getSingleRow();

					$this->db->query("SELECT * FROM borrowers WHERE borrower_id = " .$this->db->escape($key['borrower_id']). "");
					$borrower = $this->db->getSingleRow();

					$borrower_name = $borrower['full_name'];
					$inst_amt = $key['interest'] + $key['principal'];

					if($key['installment_status'] == '2'){
						$key['installment_status'] = "Paid";
					}
					else{
						$key['installment_status'] = "Unpaid";
					}

					$content[] = array(
						$i+1,
						$borrower['full_name'],
						substr($loan['date_created'],0,4).'0'.$loan['loan_id'],
						$key['payment_date'],
						number_format($loan['loan_amt'], 2, '.', ','),
						number_format($inst_amt, 2, '.', ','),
						number_format($key['balance_cf_principal'], 2, '.', ','),
						'Both (Principal + Interest)',
						$loan['loan_interest_month'],
						number_format($key['interest'], 2, '.', ','),
						number_format($key['principal'], 2, '.', ','),
						number_format($inst_amt, 2, '.', ','),
						$key['payment_date'],
						$key['installment_status']
					);
				}

				$this->db->query("SELECT * FROM loan WHERE loan_id = " .$this->db->escape($key['loan_id']). "");
				$loan_id = $this->db->getSingleRow();

				header('Content-Encoding: UTF-8');
				header('Content-Type: text/csv; charset=UTF-8');
				header('Content-Disposition: attachment;filename="report_collection_schedule' . ($borrower_id != '' ? '_' . $borrower_name . '(' . substr($loan_id['date_created'],0,4).'0'.$borrower_id . ')' : '') . '.csv"');
				header('Cache-Control: max-age=0');

				$fp = fopen('php://output', 'wb');
				//fprintf($fp, chr(0xEF).chr(0xBB).chr(0xBF));

				foreach ($content as $line) {
					fputcsv($fp, $line, ',');
				}
				fclose($fp);
				exit();
			}
		}
		set('total_paid_amount',$total_paid_amount);
		set('total_unpaid_amount',$total_unpaid_amount);
		set('borrower_id',$borrower_id);
		set('select',$select);
//		set('date_from', $date_from);
//		set('date_to', $date_to);
		set('keys', $keys);
		return render('report/report-collection-schedule-report.php', 'layout/default.php');
	}

	public function reportCollectionScheduleViewReport($bid){
		$this->db->query("SELECT * FROM loan l LEFT JOIN borrowers b ON l.borrower_id = b.borrower_id WHERE b.borrower_id = '" . $bid . "' AND (loan_status = 1 OR loan_status = 8 OR loan_status = 990) ORDER BY full_name ASC");
		$select = $this->db->getRowList();

//		$date_from = $this->request('date_from') ? $this->request('date_from') : "";
//		$date_to = $this->request('date_to') ? $this->request('date_to') : "";
		$borrower_id = $this->request('borrowerID');

//		if($date_from != '' && $date_to != ''){
//			$this->db->query("SELECT * FROM installment WHERE installment_status <> 99 AND payment_date BETWEEN '" . $date_from . "' AND '" . $date_to . "' ORDER BY loan_id ASC, year ASC");
//			$keys = $this->db->getRowList();
//
//			$this->db->query("SELECT SUM(interest + principal) AS total FROM installment WHERE installment_status <> 99 AND payment_date BETWEEN '" . $date_from . "' AND '" . $date_to . "'");
//			$total_amount = $this->db->getSingleRow();
//		}
		if($borrower_id){
			$this->db->query("SELECT * FROM installment WHERE installment_status <> 99 AND loan_id = '" . $borrower_id . "' ORDER BY loan_id ASC, year ASC");
			$keys = $this->db->getRowList();

			$this->db->query("SELECT SUM(interest + principal) AS total_paid FROM installment WHERE installment_status = 2 AND loan_id = '" . $borrower_id . "'");
			$total_paid_amount = $this->db->getSingleRow();

			$this->db->query("SELECT SUM(interest + principal) AS total_unpaid FROM installment WHERE installment_status <> 2 AND installment_status <> 99 AND loan_id = '" . $borrower_id . "'");
			$total_unpaid_amount = $this->db->getSingleRow();
		}
		else{
			$this->db->query("SELECT * FROM installment WHERE installment_status <> 99 AND borrower_id = '" . $bid . "' ORDER BY loan_id ASC, year ASC");
			$keys = $this->db->getRowList();

			$this->db->query("SELECT SUM(interest + principal) AS total_paid FROM installment WHERE installment_status = 2  AND borrower_id = '" . $bid . "'");
			$total_paid_amount = $this->db->getSingleRow();

			$this->db->query("SELECT SUM(interest + principal) AS total_unpaid FROM installment WHERE installment_status <> 2 AND installment_status <> 99  AND borrower_id = '" . $bid . "'");
			$total_unpaid_amount = $this->db->getSingleRow();
		}

		if($keys){
			foreach($keys as $i => $key){
				$this->db->query("SELECT * FROM loan WHERE loan_id = " .$this->db->escape($key['loan_id']). "");
				$loan = $this->db->getSingleRow();

				if(isset($loan['loan_amt']) || isset($loan['loan_interest_month']) || isset($loan['date_created'])){
					$keys[$i]['loan_amt'] = $loan['loan_amt'];
					$keys[$i]['loan_interest_month'] = $loan['loan_interest_month'];
					$keys[$i]['date_created'] = $loan['date_created'];
				}

				$this->db->query("SELECT * FROM borrowers WHERE borrower_id = " .$this->db->escape($loan['borrower_id']). "");
				$borrower = $this->db->getSingleRow();

				$keys[$i]['borrower_id'] = $borrower['borrower_id'];
				$keys[$i]['full_name'] = $borrower['full_name'];

				$keys[$i]['inst_amt'] = $key['interest'] + $key['principal'];

				$this->db->query("SELECT * FROM recovery WHERE installment_id = " .$this->db->escape($key['installment_id']). " ORDER BY recovery_id ASC LIMIT 1");
				$recovery = $this->db->getSingleRow();

				if(isset($recovery['actual_amount'])){
					$keys[$i]['actual_amount'] = $recovery['actual_amount'];
				}
			}

//			if($this->request('exportdate')){
//				$content[] = array(
//					'No.',
//					'Borrower Name',
//					'Loan ID',
//					'Installment Date',
//					'Principal Amount',
//					'Monthly Repayment',
//					'Balance Principal',
//					'Payment Method',
//					'Interest(%)',
//					'Interest',
//					'Principal',
//					'Paid Amount',
//					'Collection Date',
//					'Status'
//				);
//
//				foreach($keys as $i => $key){
//					$this->db->query("SELECT * FROM loan WHERE loan_id = " .$this->db->escape($key['loan_id']). "");
//					$loan = $this->db->getSingleRow();
//
//					$this->db->query("SELECT * FROM borrowers WHERE borrower_id = " .$this->db->escape($key['borrower_id']). "");
//					$borrower = $this->db->getSingleRow();
//
//					$inst_amt = $key['interest'] + $key['principal'];
//
//					if($key['installment_status'] == '2'){
//						$key['installment_status'] = "Paid";
//					}
//					else{
//						$key['installment_status'] = "Unpaid";
//					}
//
//					$content[] = array(
//						$i+1,
//						$borrower['full_name'],
//						substr($loan['date_created'],0,4).'0'.$loan['loan_id'],
//						$key['payment_date'],
//						number_format($loan['loan_amt'], 2, '.', ','),
//						number_format($inst_amt, 2, '.', ','),
//						number_format($key['balance_cf_principal'], 2, '.', ','),
//						'Both (Principal + Interest)',
//						$loan['loan_interest_month'],
//						number_format($key['interest'], 2, '.', ','),
//						number_format($key['principal'], 2, '.', ','),
//						number_format($inst_amt, 2, '.', ','),
//						$key['payment_date'],
//						$key['installment_status']
//					);
//				}
//
//				header('Content-Encoding: UTF-8');
//				header('Content-Type: text/csv; charset=UTF-8');
//				header('Content-Disposition: attachment;filename="report_collection_schedule_' . ($date_from != $date_to ? $date_from . '_' . $date_to : $date_from) . '.csv"');
//				header('Cache-Control: max-age=0');
//
//				$fp = fopen('php://output', 'wb');
//				//fprintf($fp, chr(0xEF).chr(0xBB).chr(0xBF));
//
//				foreach ($content as $line) {
//					fputcsv($fp, $line, ',');
//				}
//				fclose($fp);
//				exit();
//			}

			if($this->request('exportborrower')){
				$content[] = array(
					'No.',
					'Borrower Name',
					'Loan ID',
					'Installment Date',
					'Principal Amount',
					'Monthly Repayment',
					'Balance Principal',
					'Payment Method',
					'Interest(%)',
					'Interest',
					'Principal',
					'Paid Amount',
					'Collection Date',
					'Status'
				);

				foreach($keys as $i => $key){
					$this->db->query("SELECT * FROM loan WHERE loan_id = " .$this->db->escape($key['loan_id']). "");
					$loan = $this->db->getSingleRow();

					$this->db->query("SELECT * FROM borrowers WHERE borrower_id = " .$this->db->escape($key['borrower_id']). "");
					$borrower = $this->db->getSingleRow();

					$borrower_name = $borrower['full_name'];
					$inst_amt = $key['interest'] + $key['principal'];

					if($key['installment_status'] == '2'){
						$key['installment_status'] = "Paid";
					}
					else{
						$key['installment_status'] = "Unpaid";
					}

					$content[] = array(
						$i+1,
						$borrower['full_name'],
						substr($loan['date_created'],0,4).'0'.$loan['loan_id'],
						$key['payment_date'],
						number_format($loan['loan_amt'], 2, '.', ','),
						number_format($inst_amt, 2, '.', ','),
						number_format($key['balance_cf_principal'], 2, '.', ','),
						'Both (Principal + Interest)',
						$loan['loan_interest_month'],
						number_format($key['interest'], 2, '.', ','),
						number_format($key['principal'], 2, '.', ','),
						number_format($inst_amt, 2, '.', ','),
						$key['payment_date'],
						$key['installment_status']
					);
				}

				$this->db->query("SELECT * FROM loan WHERE loan_id = " .$this->db->escape($key['loan_id']). "");
				$loan_id = $this->db->getSingleRow();

				header('Content-Encoding: UTF-8');
				header('Content-Type: text/csv; charset=UTF-8');
				header('Content-Disposition: attachment;filename="report_collection_schedule' . ($borrower_id != '' ? '_' . $borrower_name . '(' . substr($loan_id['date_created'],0,4).'0'.$borrower_id . ')' : '') . '.csv"');
				header('Cache-Control: max-age=0');

				$fp = fopen('php://output', 'wb');
				//fprintf($fp, chr(0xEF).chr(0xBB).chr(0xBF));

				foreach ($content as $line) {
					fputcsv($fp, $line, ',');
				}
				fclose($fp);
				exit();
			}
			$borrowerID = $bid;
		}
		set('total_paid_amount',$total_paid_amount);
		set('total_unpaid_amount',$total_unpaid_amount);
		set('borrower_id',$borrower_id);
		set('borrowerID',$borrowerID);
		set('select',$select);
//		set('date_from', $date_from);
//		set('date_to', $date_to);
		set('keys', $keys);
		return render('report/report-collection-schedule-view-report.php', 'layout/default.php');
	}

	public function reportCollectionScheduleViewReportID($bid,$id){
		$this->db->query("SELECT * FROM loan l LEFT JOIN borrowers b ON l.borrower_id = b.borrower_id WHERE b.borrower_id = '" . $bid . "' AND (loan_status = 1 OR loan_status = 8 OR loan_status = 990) ORDER BY full_name ASC");
		$select = $this->db->getRowList();
		$borrower_id = $this->request('borrowerID');

		$this->db->query("SELECT * FROM installment WHERE installment_status <> 99 AND loan_id = '" . $id . "' ORDER BY loan_id ASC, year ASC");
		$keys = $this->db->getRowList();

		$this->db->query("SELECT SUM(interest + principal) AS total_paid FROM installment WHERE installment_status = 2  AND loan_id = '" . $id . "'");
		$total_paid_amount = $this->db->getSingleRow();

		$this->db->query("SELECT SUM(interest + principal) AS total_unpaid FROM installment WHERE installment_status <> 2 AND installment_status <> 99  AND loan_id = '" . $id . "'");
		$total_unpaid_amount = $this->db->getSingleRow();

		if($keys){
			foreach($keys as $i => $key){
				$this->db->query("SELECT * FROM loan WHERE loan_id = " .$this->db->escape($key['loan_id']). "");
				$loan = $this->db->getSingleRow();

				if(isset($loan['loan_amt']) || isset($loan['loan_interest_month']) || isset($loan['date_created'])){
					$keys[$i]['loan_amt'] = $loan['loan_amt'];
					$keys[$i]['loan_interest_month'] = $loan['loan_interest_month'];
					$keys[$i]['date_created'] = $loan['date_created'];
				}

				$this->db->query("SELECT * FROM borrowers WHERE borrower_id = " .$this->db->escape($loan['borrower_id']). "");
				$borrower = $this->db->getSingleRow();

				$keys[$i]['borrower_id'] = $borrower['borrower_id'];
				$keys[$i]['full_name'] = $borrower['full_name'];

				$keys[$i]['inst_amt'] = $key['interest'] + $key['principal'];

				$this->db->query("SELECT * FROM recovery WHERE installment_id = " .$this->db->escape($key['installment_id']). " ORDER BY recovery_id ASC LIMIT 1");
				$recovery = $this->db->getSingleRow();

				if(isset($recovery['actual_amount'])){
					$keys[$i]['actual_amount'] = $recovery['actual_amount'];
				}
			}

			if($this->request('exportborrower')){
				$content[] = array(
					'No.',
					'Borrower Name',
					'Loan ID',
					'Installment Date',
					'Principal Amount',
					'Monthly Repayment',
					'Balance Principal',
					'Payment Method',
					'Interest(%)',
					'Interest',
					'Principal',
					'Paid Amount',
					'Collection Date',
					'Status'
				);

				foreach($keys as $i => $key){
					$this->db->query("SELECT * FROM loan WHERE loan_id = " .$this->db->escape($key['loan_id']). "");
					$loan = $this->db->getSingleRow();

					$this->db->query("SELECT * FROM borrowers WHERE borrower_id = " .$this->db->escape($key['borrower_id']). "");
					$borrower = $this->db->getSingleRow();

					$borrower_name = $borrower['full_name'];
					$inst_amt = $key['interest'] + $key['principal'];

					if($key['installment_status'] == '2'){
						$key['installment_status'] = "Paid";
					}
					else{
						$key['installment_status'] = "Unpaid";
					}

					$content[] = array(
						$i+1,
						$borrower['full_name'],
						substr($loan['date_created'],0,4).'0'.$loan['loan_id'],
						$key['payment_date'],
						number_format($loan['loan_amt'], 2, '.', ','),
						number_format($inst_amt, 2, '.', ','),
						number_format($key['balance_cf_principal'], 2, '.', ','),
						'Both (Principal + Interest)',
						$loan['loan_interest_month'],
						number_format($key['interest'], 2, '.', ','),
						number_format($key['principal'], 2, '.', ','),
						number_format($inst_amt, 2, '.', ','),
						$key['payment_date'],
						$key['installment_status']
					);
				}

				$this->db->query("SELECT * FROM loan WHERE loan_id = " .$this->db->escape($key['loan_id']). "");
				$loan_id = $this->db->getSingleRow();

				header('Content-Encoding: UTF-8');
				header('Content-Type: text/csv; charset=UTF-8');
				header('Content-Disposition: attachment;filename="report_collection_schedule' . ($borrower_id != '' ? '_' . $borrower_name . '(' . substr($loan_id['date_created'],0,4).'0'.$borrower_id . ')' : '') . '.csv"');
				header('Cache-Control: max-age=0');

				$fp = fopen('php://output', 'wb');
				//fprintf($fp, chr(0xEF).chr(0xBB).chr(0xBF));

				foreach ($content as $line) {
					fputcsv($fp, $line, ',');
				}
				fclose($fp);
				exit();
			}
			$borrowerID = $bid;
			$loanID = $id;
		}
		set('total_paid_amount',$total_paid_amount);
		set('total_unpaid_amount',$total_unpaid_amount);
		set('borrower_id',$borrower_id);
		set('borrowerID',$borrowerID);
		set('loanID',$loanID);
		set('select',$select);
		set('keys', $keys);
		return render('report/report-collection-schedule-view-report-id.php', 'layout/default.php');
	}

	public function headcollection(){
		$this->db->query("SELECT distinct i.borrower_id,b.borrower_id,l.borrower_id,i.head_id,i.admin_id,b.full_name,r.recovery_status
		 FROM installment i,borrowers b, loan l,recovery r
			WHERE  b.borrower_id=i.borrower_id 
			AND i.borrower_id=l.borrower_id 
			AND r.borrower_id=i.borrower_id
			AND r.recovery_status=2
			
			
	
	 
	");
		$select = $this->db->getRowList();

		$this->db->query("SELECT distinct i.head_id,r.recovery_status,a.admin_name
	FROM installment i,recovery r, user_admins a
	 WHERE i.installment_id=r.installment_id 
	 AND r.recovery_status=2 
	 AND a.admin_id=i.head_id
	 ORDER BY a.admin_name ASC
		
");
		$selectofficername = $this->db->getRowList();

		$date_from = $this->request('date_from') ? $this->request('date_from') : "";
		$date_to = $this->request('date_to') ? $this->request('date_to') : "";
		$borrower_id = $this->request('borrowerID');
		$admin_id = $this->request('adminID');
		// 	if($date_from != '' && $date_to != ''){
		// 		$this->db->query("SELECT a.*,b.full_name,c.loan_id,d.paid_for,c.loan_amt,c.loan_interest_month,d.admin_id,d.head_id,e.admin_name FROM recovery a, borrowers b,loan c,installment d,user_admins e
		// 		WHERE a.recovery_status = 2
		// 		AND b.borrower_id=a.borrower_id
		// 		AND c.loan_id=a.loan_id
		// 		AND a.installment_id= d.installment_id
		// 		AND e.admin_id=d.admin_id
		// 		AND a.paid_date BETWEEN '" . $date_from . "' AND '" . $date_to . "'

		// 		");
		// $risk = $this->db->getRowList();
		// }
		// else if($borrower_id){
		// 	$this->db->query("SELECT a.*,b.full_name,c.loan_id,d.paid_for,c.loan_amt,c.loan_interest_month,d.admin_id,d.head_id,e.admin_name FROM recovery a, borrowers b,loan c,installment d,user_admins e
		// 		WHERE a.recovery_status = 2
		// 		AND b.borrower_id=a.borrower_id
		// 		AND c.loan_id=a.loan_id
		// 		AND e.admin_id=d.admin_id
		// 		AND a.installment_id= d.installment_id AND b.borrower_id = '" . $borrower_id . "' ");
		// 	$risk = $this->db->getRowList();
		// }
		if($admin_id){
			$this->db->query("SELECT a.*,b.full_name,c.loan_id,d.paid_for,c.loan_amt,c.loan_interest_month,d.admin_id,d.head_id,e.admin_name FROM recovery a, borrowers b,loan c,installment d,user_admins e 
			WHERE a.recovery_status = 2
			AND b.borrower_id=a.borrower_id 
			AND c.loan_id=a.loan_id 
			AND e.admin_id=d.admin_id
			AND a.installment_id= d.installment_id 
			AND d.head_id = '" . $admin_id . "' ");
			$risk = $this->db->getRowList();
		}


		else{
			$this->db->query("SELECT a.*,b.full_name,c.loan_id,d.paid_for,c.loan_amt,c.loan_interest_month,d.admin_id,d.head_id,e.admin_name FROM recovery a, borrowers b,loan c,installment d,user_admins e 
			WHERE a.recovery_status = 2
			AND b.borrower_id=a.borrower_id 
			AND c.loan_id=a.loan_id 
			AND a.installment_id= d.installment_id
			AND e.admin_id=d.admin_id
			
			
			");
			$risk = $this->db->getRowList();

		}

		if($risk){
			foreach($risk as $i => $key){


				$this->db->query("SELECT admin_name FROM user_admins WHERE admin_id = " .$this->db->escape($risk[$i]['admin_id']));
				$officer = $this->db->getSingleRow();

				if(isset($officer['admin_name'])){
					$risk[$i]['officer'] = $officer['admin_name'];
				}
			}
// 	if($this->request('exportdate')){


// 		$content[] = array(
// 			'No.',
// 			'Borrower Name',
// 			'Loan ID',
// 			'Collection Amount (RM)',
// 			'Collection Date',
// 			'Payment Method',
// 			'Loan Amount (RM)',
// 			'Percentage (%)',
// 			'Recovery Officer',
// 		);

// 		foreach($risk as $i => $key){
// 			if($key['head_id'] == $this->admin->id){
// 				if($key['paid_for'] == '1'){
// 					$key['paid_for'] = "Both (Principal + Interest)";
// 				}
// 				if($key['paid_for'] == '2'){
// 					$key['paid_for'] = "Interest Amount";
// 				}
// 				if($key['paid_for'] == '3'){
// 					$key['paid_for'] = "Rescheduling";
// 				}
// 				if($key['paid_for'] == '4'){
// 					$key['paid_for'] = "Partial Payment";
// 				}
// 				if($key['paid_for'] == '5'){
// 					$key['paid_for'] = "Late Charges";
// 				}
// 				if($key['paid_for'] == '6'){
// 					$key['paid_for'] = "Full Settlement";
// 				}

// 				$content[] = array(
// 					$i+1,
// 					$key['full_name'],
// 					substr($key['date_created'], 0, 4) . '0' . $key['loan_id'],
// 					number_format($key['amount_paid'], 2, '.', ','),
// 					$key['paid_date'],
// 					$key['paid_for'] ,
// 					$key['loan_amt'],
// 					$key['loan_interest_month'],
// 					$key['admin_name']

// 				);

// 			}

// 			if ($key['admin_id']==(($this->admin->role == '1' || $this->admin->role == '2' || $this->admin->role_type == '1'))){
// 				if($key['paid_for'] == '1'){
// 					$key['paid_for'] = "Both (Principal + Interest)";
// 				}
// 				if($key['paid_for'] == '2'){
// 					$key['paid_for'] = "Interest Amount";
// 				}
// 				if($key['paid_for'] == '3'){
// 					$key['paid_for'] = "Rescheduling";
// 				}
// 				if($key['paid_for'] == '4'){
// 					$key['paid_for'] = "Partial Payment";
// 				}
// 				if($key['paid_for'] == '5'){
// 					$key['paid_for'] = "Late Charges";
// 				}
// 				if($key['paid_for'] == '6'){
// 					$key['paid_for'] = "Full Settlement";
// 				}

// 				$content[] = array(
// 					$i+1,
// 					$key['full_name'],
// 					substr($key['date_created'], 0, 4) . '0' . $key['loan_id'],
// 					number_format($key['amount_paid'], 2, '.', ','),
// 					$key['paid_date'],
// 					$key['paid_for'] ,
// 					$key['loan_amt'],
// 					$key['loan_interest_month'],
// 					$key['admin_name']

// 				);

// 			}
// 		}

// 		header('Content-Encoding: UTF-8');
// 		header('Content-Type: text/csv; charset=UTF-8');
// 		header('Content-Disposition: attachment;filename="headcollection_' . ($date_from != $date_to ? $date_from . '_' . $date_to : $date_from) . '('.$this->admin->name.').csv"');
// 		header('Cache-Control: max-age=0');

// 		$fp = fopen('php://output', 'wb');
// 		//fprintf($fp, chr(0xEF).chr(0xBB).chr(0xBF));

// 		foreach ($content as $line) {
// 			fputcsv($fp, $line, ',');
// 		}
// 		fclose($fp);
// 		exit();



// }
		}
// if($this->request('exportborrower'))
// {


// 	$content[] = array(
// 		'No.',
// 		'Borrower Name',
// 		'Loan ID',
// 		'Collection Amount (RM)',
// 		'Collection Date',
// 		'Payment Method',
// 		'Loan Amount (RM)',
// 		'Percentage (%)',
// 		'Recovery Officer',

// 	);

// 	foreach($risk as $i => $key){
// 		$this->db->query("SELECT * FROM borrowers WHERE borrower_id = " .$this->db->escape($key['borrower_id']). "");
// 					$borrower = $this->db->getSingleRow();

// 					$borrower_name = $borrower['full_name'];
// 		if($key['head_id'] == $this->admin->id){
// 			if($key['paid_for'] == '1'){
// 				$key['paid_for'] = "Both (Principal + Interest)";
// 			}
// 			if($key['paid_for'] == '2'){
// 				$key['paid_for'] = "Interest Amount";
// 			}
// 			if($key['paid_for'] == '3'){
// 				$key['paid_for'] = "Rescheduling";
// 			}
// 			if($key['paid_for'] == '4'){
// 				$key['paid_for'] = "Partial Payment";
// 			}
// 			if($key['paid_for'] == '5'){
// 				$key['paid_for'] = "Late Charges";
// 			}
// 			if($key['paid_for'] == '6'){
// 				$key['paid_for'] = "Full Settlement";
// 			}

// 			$content[] = array(
// 				$i+1,
// 				$key['full_name'],
// 				substr($key['date_created'], 0, 4) . '0' . $key['loan_id'],
// 				number_format($key['amount_paid'], 2, '.', ','),
// 				$key['paid_date'],
// 				$key['paid_for'] ,
// 				$key['loan_amt'],
// 				$key['loan_interest_month'],
// 				$key['admin_name']


// 			);

// 		}

// 	}

// 	header('Content-Encoding: UTF-8');
// 	header('Content-Type: text/csv; charset=UTF-8');
// 	header('Content-Disposition: attachment;filename="report_headcollection_(' . $borrower_name . ')_('.$this->admin->name.').csv"');
// 	header('Cache-Control: max-age=0');

// 	$fp = fopen('php://output', 'wb');
// 	//fprintf($fp, chr(0xEF).chr(0xBB).chr(0xBF));

// 	foreach ($content as $line) {
// 		fputcsv($fp, $line, ',');
// 	}
// 	fclose($fp);
// 	exit();


// }

		if($this->request('exportofficer'))
		{


			$content[] = array(
				'No.',
				'Borrower Name',
				'Loan ID',
				'Collection Amount (RM)',
				'Collection Date',
				'Payment Method',
				'Loan Amount (RM)',
				'Percentage (%)',
				'Recovery Officer',

			);

			foreach($risk as $i => $key){






				// $this->db->query("SELECT * FROM borrowers WHERE borrower_id = " .$this->db->escape($key['borrower_id']). "");
				// 			$borrower = $this->db->getSingleRow();

				// 			$borrower_name = $borrower['full_name'];
				if($key['head_id'] == $this->admin->id){
					if($key['paid_for'] == '1'){
						$key['paid_for'] = "Both (Principal + Interest)";
					}
					if($key['paid_for'] == '2'){
						$key['paid_for'] = "Interest Amount";
					}
					if($key['paid_for'] == '3'){
						$key['paid_for'] = "Rescheduling";
					}
					if($key['paid_for'] == '4'){
						$key['paid_for'] = "Partial Payment";
					}
					if($key['paid_for'] == '5'){
						$key['paid_for'] = "Late Charges";
					}
					if($key['paid_for'] == '6'){
						$key['paid_for'] = "Full Settlement";
					}

					$content[] = array(
						$i+1,
						$key['full_name'],
						substr($key['date_created'], 0, 4) . '0' . $key['loan_id'],
						number_format($key['amount_paid'], 2, '.', ','),
						$key['paid_date'],
						$key['paid_for'] ,
						$key['loan_amt'],
						$key['loan_interest_month'],
						$key['admin_name']


					);

				}
				if ($key['admin_id']==(($this->admin->role == '1' || $this->admin->role == '2' || $this->admin->role_type == '1')))
				{
					if($key['paid_for'] == '1'){
						$key['paid_for'] = "Both (Principal + Interest)";
					}
					if($key['paid_for'] == '2'){
						$key['paid_for'] = "Interest Amount";
					}
					if($key['paid_for'] == '3'){
						$key['paid_for'] = "Rescheduling";
					}
					if($key['paid_for'] == '4'){
						$key['paid_for'] = "Partial Payment";
					}
					if($key['paid_for'] == '5'){
						$key['paid_for'] = "Late Charges";
					}
					if($key['paid_for'] == '6'){
						$key['paid_for'] = "Full Settlement";
					}

					$content[] = array(
						$i+1,
						$key['full_name'],
						substr($key['date_created'], 0, 4) . '0' . $key['loan_id'],
						number_format($key['amount_paid'], 2, '.', ','),
						$key['paid_date'],
						$key['paid_for'] ,
						$key['loan_amt'],
						$key['loan_interest_month'],
						$key['admin_name']


					);
				}

			}

			header('Content-Encoding: UTF-8');
			header('Content-Type: text/csv; charset=UTF-8');
			header('Content-Disposition: attachment;filename="report_headcollection.csv"');
			header('Cache-Control: max-age=0');

			$fp = fopen('php://output', 'wb');
			//fprintf($fp, chr(0xEF).chr(0xBB).chr(0xBF));

			foreach ($content as $line) {
				fputcsv($fp, $line, ',');
			}
			fclose($fp);
			exit();


		}

		set('borrower_id',$borrower_id);
		set('select',$select);
		set('selectofficername',$selectofficername);
		set('date_from', $date_from);
		set('date_to', $date_to);
		set('risk', $risk);
		set('admin_id',$admin_id);

		return render('report/report-head-collection.php', 'layout/default.php');
	}


	public function individualcollection(){
		$this->db->query("SELECT distinct i.borrower_id,b.borrower_id,l.borrower_id,i.head_id,i.admin_id,b.full_name,r.recovery_status
		 FROM installment i,borrowers b, loan l,recovery r
			WHERE  b.borrower_id=i.borrower_id 
			AND i.borrower_id=l.borrower_id 
			AND r.borrower_id=i.borrower_id
			AND r.recovery_status=2
			
			
	
	 
	");
		$select = $this->db->getRowList();
		$this->db->query("SELECT distinct i.admin_id,r.recovery_status,a.admin_name,i.head_id
	FROM installment i,recovery r, user_admins a
	 WHERE i.installment_id=r.installment_id 
	 AND r.recovery_status=2 
	 AND a.admin_id=i.admin_id
	 ORDER BY a.admin_name ASC
		
");
		$selectofficername = $this->db->getRowList();



		$date_from = $this->request('date_from') ? $this->request('date_from') : "";
		$date_to = $this->request('date_to') ? $this->request('date_to') : "";
		// $date_from = $this->request('date_from') ? $this->request('date_from') : date('Y-m-01');
		// $date_to = $this->request('date_to') ? $this->request('date_to') : date('Y-m-d');

		$borrower_id = $this->request('borrowerID');
		$admin_id = $this->request('adminID');
		if($borrower_id){
			$this->db->query("SELECT a.*,b.full_name,c.loan_id,d.paid_for,c.loan_amt,c.loan_interest_month,d.admin_id,d.head_id FROM recovery a, borrowers b,loan c,installment d
			WHERE a.recovery_status = 2
			AND b.borrower_id=a.borrower_id 
			AND c.loan_id=a.loan_id 
			AND a.installment_id= d.installment_id AND b.borrower_id = '" . $borrower_id . "' ");
			$risk = $this->db->getRowList();
		}
		else if($admin_id){
			$this->db->query("SELECT a.*,b.full_name,c.loan_id,d.paid_for,c.loan_amt,c.loan_interest_month,d.admin_id,d.head_id,e.admin_name FROM recovery a, borrowers b,loan c,installment d,user_admins e 
			WHERE a.recovery_status = 2
			AND b.borrower_id=a.borrower_id 
			AND c.loan_id=a.loan_id 
			AND e.admin_id=d.admin_id
			AND a.installment_id= d.installment_id AND d.admin_id = '" . $admin_id . "' 
		
			");

			$risk = $this->db->getRowList();
		}
		else{
			$this->db->query("SELECT a.*,b.full_name,c.loan_id,d.paid_for,c.loan_amt,c.loan_interest_month,d.admin_id,d.head_id,e.admin_name FROM recovery a, borrowers b,loan c,installment d,user_admins e
			WHERE a.recovery_status = 2
			AND b.borrower_id=a.borrower_id 
			AND c.loan_id=a.loan_id 
			AND a.installment_id= d.installment_id
			AND e.admin_id=d.admin_id
			
			
			");
			$risk = $this->db->getRowList();

		}

		if($risk){
			foreach($risk as $i => $key){
				$this->db->query("SELECT * FROM borrowers WHERE borrower_id = " .$this->db->escape($key['borrower_id']). "");
				$borrower = $this->db->getSingleRow();

				if(isset($borrower['full_name']) || isset($borrower['borrower_id'])){
					$keys[$i]['borrower_id'] = $borrower['borrower_id'];
					$keys[$i]['full_name'] = $borrower['full_name'];
				}


				$this->db->query("SELECT admin_name FROM user_admins WHERE admin_id = " .$this->db->escape($risk[$i]['admin_id']));
				$officer = $this->db->getSingleRow();

				if(isset($officer['admin_name'])){
					$risk[$i]['officer'] = $officer['admin_name'];
				}
			}
			if($this->request('exportdate')){


				$content[] = array(
					'No.',
					'Borrower Name',
					'Loan ID',
					'Collection Amount (RM)',
					'Collection Date',
					'Payment Method',
					'Loan Amount (RM)',
					'Percentage (%)',

				);

				foreach($risk as $i => $key){
					if($key['admin_id'] == $this->admin->id){
						if($key['paid_for'] == '1'){
							$key['paid_for'] = "Both (Principal + Interest)";
						}
						if($key['paid_for'] == '2'){
							$key['paid_for'] = "Interest Amount";
						}
						if($key['paid_for'] == '3'){
							$key['paid_for'] = "Rescheduling";
						}
						if($key['paid_for'] == '4'){
							$key['paid_for'] = "Partial Payment";
						}
						if($key['paid_for'] == '5'){
							$key['paid_for'] = "Late Charges";
						}
						if($key['paid_for'] == '6'){
							$key['paid_for'] = "Full Settlement";
						}
						if($key['admin_id'] == '346'){
							$key['admin_id'] = "Recovery Officer 1";
						}
						if($key['admin_id'] == '347'){
							$key['admin_id'] = "Recovery Officer 2";
						}
						if($key['admin_id'] == '348'){
							$key['admin_id'] = "Recovery Officer 3";
						}
						if($key['admin_id'] == '352'){
							$key['admin_id'] = "Recovery Officer 4";
						}
						$content[] = array(
							$i+1,
							$key['full_name'],
							substr($key['date_created'], 0, 4) . '0' . $key['loan_id'],
							number_format($key['amount_paid'], 2, '.', ','),
							$key['paid_date'],
							$key['paid_for'] ,
							$key['loan_amt'],
							$key['loan_interest_month'],

						);

					}
					if ($key['admin_id']==(($this->admin->role == '1' || $this->admin->role == '2' || $this->admin->role_type == '1')))
					{
						if($key['paid_for'] == '1'){
							$key['paid_for'] = "Both (Principal + Interest)";
						}
						if($key['paid_for'] == '2'){
							$key['paid_for'] = "Interest Amount";
						}
						if($key['paid_for'] == '3'){
							$key['paid_for'] = "Rescheduling";
						}
						if($key['paid_for'] == '4'){
							$key['paid_for'] = "Partial Payment";
						}
						if($key['paid_for'] == '5'){
							$key['paid_for'] = "Late Charges";
						}
						if($key['paid_for'] == '6'){
							$key['paid_for'] = "Full Settlement";
						}
						if($key['admin_id'] == '346'){
							$key['admin_id'] = "Recovery Officer 1";
						}
						if($key['admin_id'] == '347'){
							$key['admin_id'] = "Recovery Officer 2";
						}
						if($key['admin_id'] == '348'){
							$key['admin_id'] = "Recovery Officer 3";
						}
						if($key['admin_id'] == '352'){
							$key['admin_id'] = "Recovery Officer 4";
						}
						$content[] = array(
							$i+1,
							$key['full_name'],
							substr($key['date_created'], 0, 4) . '0' . $key['loan_id'],
							number_format($key['amount_paid'], 2, '.', ','),
							$key['paid_date'],
							$key['paid_for'] ,
							$key['loan_amt'],
							$key['loan_interest_month'],

						);

					}
				}

				header('Content-Encoding: UTF-8');
				header('Content-Type: text/csv; charset=UTF-8');
				header('Content-Disposition: attachment;filename="individualcollection_' . ($date_from != $date_to ? $date_from . '_' . $date_to : $date_from) . '('.$this->admin->name.').csv"');
				header('Cache-Control: max-age=0');

				$fp = fopen('php://output', 'wb');
				//fprintf($fp, chr(0xEF).chr(0xBB).chr(0xBF));

				foreach ($content as $line) {
					fputcsv($fp, $line, ',');
				}
				fclose($fp);
				exit();




			}

		}
		if($this->request('exportborrower'))
		{


			$content[] = array(
				'No.',
				'Borrower Name',
				'Loan ID',
				'Collection Amount (RM)',
				'Collection Date',
				'Payment Method',
				'Loan Amount (RM)',
				'Percentage (%)',

			);

			foreach($risk as $i => $key){
				$this->db->query("SELECT * FROM borrowers WHERE borrower_id = " .$this->db->escape($key['borrower_id']). "");
				$borrower = $this->db->getSingleRow();

				$borrower_name = $borrower['full_name'];
				if($key['admin_id'] == $this->admin->id){
					if($key['paid_for'] == '1'){
						$key['paid_for'] = "Both (Principal + Interest)";
					}
					if($key['paid_for'] == '2'){
						$key['paid_for'] = "Interest Amount";
					}
					if($key['paid_for'] == '3'){
						$key['paid_for'] = "Rescheduling";
					}
					if($key['paid_for'] == '4'){
						$key['paid_for'] = "Partial Payment";
					}
					if($key['paid_for'] == '5'){
						$key['paid_for'] = "Late Charges";
					}
					if($key['paid_for'] == '6'){
						$key['paid_for'] = "Full Settlement";
					}
					if($key['admin_id'] == '346'){
						$key['admin_id'] = "Recovery Officer 1";
					}
					if($key['admin_id'] == '347'){
						$key['admin_id'] = "Recovery Officer 2";
					}
					if($key['admin_id'] == '348'){
						$key['admin_id'] = "Recovery Officer 3";
					}
					if($key['admin_id'] == '352'){
						$key['admin_id'] = "Recovery Officer 4";
					}
					$content[] = array(
						$i+1,
						$key['full_name'],
						substr($key['date_created'], 0, 4) . '0' . $key['loan_id'],
						number_format($key['amount_paid'], 2, '.', ','),
						$key['paid_date'],
						$key['paid_for'] ,
						$key['loan_amt'],
						$key['loan_interest_month'],

					);

				}
				if ($key['admin_id']==(($this->admin->role == '1' || $this->admin->role == '2' || $this->admin->role_type == '1')))
				{
					if($key['paid_for'] == '1'){
						$key['paid_for'] = "Both (Principal + Interest)";
					}
					if($key['paid_for'] == '2'){
						$key['paid_for'] = "Interest Amount";
					}
					if($key['paid_for'] == '3'){
						$key['paid_for'] = "Rescheduling";
					}
					if($key['paid_for'] == '4'){
						$key['paid_for'] = "Partial Payment";
					}
					if($key['paid_for'] == '5'){
						$key['paid_for'] = "Late Charges";
					}
					if($key['paid_for'] == '6'){
						$key['paid_for'] = "Full Settlement";
					}
					if($key['admin_id'] == '346'){
						$key['admin_id'] = "Recovery Officer 1";
					}
					if($key['admin_id'] == '347'){
						$key['admin_id'] = "Recovery Officer 2";
					}
					if($key['admin_id'] == '348'){
						$key['admin_id'] = "Recovery Officer 3";
					}
					if($key['admin_id'] == '352'){
						$key['admin_id'] = "Recovery Officer 4";
					}
					$content[] = array(
						$i+1,
						$key['full_name'],
						substr($key['date_created'], 0, 4) . '0' . $key['loan_id'],
						number_format($key['amount_paid'], 2, '.', ','),
						$key['paid_date'],
						$key['paid_for'] ,
						$key['loan_amt'],
						$key['loan_interest_month'],

					);

				}
			}

			header('Content-Encoding: UTF-8');
			header('Content-Type: text/csv; charset=UTF-8');
			header('Content-Disposition: attachment;filename="report_individualcollection_(' . $borrower_name . ')_('.$this->admin->name.').csv"');
			header('Cache-Control: max-age=0');

			$fp = fopen('php://output', 'wb');
			//fprintf($fp, chr(0xEF).chr(0xBB).chr(0xBF));

			foreach ($content as $line) {
				fputcsv($fp, $line, ',');
			}
			fclose($fp);
			exit();




		}
		if($this->request('exportofficer'))
		{


			$content[] = array(
				'No.',
				'Borrower Name',
				'Loan ID',
				'Collection Amount (RM)',
				'Collection Date',
				'Payment Method',
				'Loan Amount (RM)',
				'Percentage (%)',
				'Recovery Officer'

			);

			foreach($risk as $i => $key){
				$officername=$key['admin_name'];
				$this->db->query("SELECT * FROM borrowers WHERE borrower_id = " .$this->db->escape($key['borrower_id']). "");
				$borrower = $this->db->getSingleRow();

				$borrower_name = $borrower['full_name'];

				if($key['admin_id'] == $this->admin->id){
					if($key['paid_for'] == '1'){
						$key['paid_for'] = "Both (Principal + Interest)";
					}
					if($key['paid_for'] == '2'){
						$key['paid_for'] = "Interest Amount";
					}
					if($key['paid_for'] == '3'){
						$key['paid_for'] = "Rescheduling";
					}
					if($key['paid_for'] == '4'){
						$key['paid_for'] = "Partial Payment";
					}
					if($key['paid_for'] == '5'){
						$key['paid_for'] = "Late Charges";
					}
					if($key['paid_for'] == '6'){
						$key['paid_for'] = "Full Settlement";
					}
					if($key['admin_id'] == '346'){
						$key['admin_id'] = "Recovery Officer 1";
					}
					if($key['admin_id'] == '347'){
						$key['admin_id'] = "Recovery Officer 2";
					}
					if($key['admin_id'] == '348'){
						$key['admin_id'] = "Recovery Officer 3";
					}
					if($key['admin_id'] == '352'){
						$key['admin_id'] = "Recovery Officer 4";
					}
					$content[] = array(
						$i+1,
						$key['full_name'],
						substr($key['date_created'], 0, 4) . '0' . $key['loan_id'],
						number_format($key['amount_paid'], 2, '.', ','),
						$key['paid_date'],
						$key['paid_for'] ,
						$key['loan_amt'],
						$key['loan_interest_month'],
						$key['admin_name']
					);

				}
				if($key['head_id'] == $this->admin->id){
					if($key['paid_for'] == '1'){
						$key['paid_for'] = "Both (Principal + Interest)";
					}
					if($key['paid_for'] == '2'){
						$key['paid_for'] = "Interest Amount";
					}
					if($key['paid_for'] == '3'){
						$key['paid_for'] = "Rescheduling";
					}
					if($key['paid_for'] == '4'){
						$key['paid_for'] = "Partial Payment";
					}
					if($key['paid_for'] == '5'){
						$key['paid_for'] = "Late Charges";
					}
					if($key['paid_for'] == '6'){
						$key['paid_for'] = "Full Settlement";
					}
					if($key['admin_id'] == '346'){
						$key['admin_id'] = "Recovery Officer 1";
					}
					if($key['admin_id'] == '347'){
						$key['admin_id'] = "Recovery Officer 2";
					}
					if($key['admin_id'] == '348'){
						$key['admin_id'] = "Recovery Officer 3";
					}
					if($key['admin_id'] == '352'){
						$key['admin_id'] = "Recovery Officer 4";
					}
					$content[] = array(
						$i+1,
						$key['full_name'],
						substr($key['date_created'], 0, 4) . '0' . $key['loan_id'],
						number_format($key['amount_paid'], 2, '.', ','),
						$key['paid_date'],
						$key['paid_for'] ,
						$key['loan_amt'],
						$key['loan_interest_month'],
						$key['admin_name']
					);

				}
				if ($key['admin_id']==(($this->admin->role == '1' || $this->admin->role == '2' || $this->admin->role_type == '1')))
				{
					if($key['paid_for'] == '1'){
						$key['paid_for'] = "Both (Principal + Interest)";
					}
					if($key['paid_for'] == '2'){
						$key['paid_for'] = "Interest Amount";
					}
					if($key['paid_for'] == '3'){
						$key['paid_for'] = "Rescheduling";
					}
					if($key['paid_for'] == '4'){
						$key['paid_for'] = "Partial Payment";
					}
					if($key['paid_for'] == '5'){
						$key['paid_for'] = "Late Charges";
					}
					if($key['paid_for'] == '6'){
						$key['paid_for'] = "Full Settlement";
					}
					if($key['admin_id'] == '346'){
						$key['admin_id'] = "Recovery Officer 1";
					}
					if($key['admin_id'] == '347'){
						$key['admin_id'] = "Recovery Officer 2";
					}
					if($key['admin_id'] == '348'){
						$key['admin_id'] = "Recovery Officer 3";
					}
					if($key['admin_id'] == '352'){
						$key['admin_id'] = "Recovery Officer 4";
					}
					$content[] = array(
						$i+1,
						$key['full_name'],
						substr($key['date_created'], 0, 4) . '0' . $key['loan_id'],
						number_format($key['amount_paid'], 2, '.', ','),
						$key['paid_date'],
						$key['paid_for'] ,
						$key['loan_amt'],
						$key['loan_interest_month'],
						$key['admin_name']

					);

				}
			}

			header('Content-Encoding: UTF-8');
			header('Content-Type: text/csv; charset=UTF-8');
			header('Content-Disposition: attachment;filename="report_individualcollection_('.$officername.').csv"');
			header('Cache-Control: max-age=0');

			$fp = fopen('php://output', 'wb');
			//fprintf($fp, chr(0xEF).chr(0xBB).chr(0xBF));

			foreach ($content as $line) {
				fputcsv($fp, $line, ',');
			}
			fclose($fp);
			exit();




		}
		set('borrower_id',$borrower_id);
		set('select',$select);
		set('date_from', $date_from);
		set('date_to', $date_to);
		set('risk', $risk);
		set('selectofficername',$selectofficername);
		set('admin_id',$admin_id);


		return render('report/report-individual-collection.php', 'layout/default.php');
	}
	public function summarycollection(){

		$this->db->query("SELECT distinct i.admin_id,r.recovery_status,a.admin_name,i.head_id
	FROM installment i,recovery r, user_admins a
	 WHERE i.installment_id=r.installment_id 
	 AND r.recovery_status=2 
	 AND a.admin_id=i.admin_id
	 ORDER BY a.admin_name ASC
		
");
		$selectofficername = $this->db->getRowList();



		$date_from = $this->request('date_from') ? $this->request('date_from') : "";
		$date_to = $this->request('date_to') ? $this->request('date_to') : "";
		$borrower_id = $this->request('borrowerID');
		$admin_id = $this->request('adminID');
		if($admin_id){
			$this->db->query("SELECT d.admin_id,d.head_id,e.admin_name,
		YEAR(a.paid_date), MONTH(a.paid_date), 
		SUM(a.amount_paid) AS TOTALCOUNT 
		FROM recovery a,installment d,user_admins e 
		WHERE a.recovery_status = 2 
		AND e.admin_id=d.admin_id 
		AND a.installment_id= d.installment_id 
		AND d.admin_id = '" . $admin_id . "'
		GROUP BY YEAR(a.paid_date), MONTH(a.paid_date),(d.admin_id)
		ORDER BY YEAR(a.paid_date),MONTH(a.paid_date)
		");
			$risk = $this->db->getRowList();

		}	else{
			$this->db->query("SELECT d.admin_id,d.head_id,e.admin_name,
		YEAR(a.paid_date), MONTH(a.paid_date), 
		SUM(a.amount_paid) AS TOTALCOUNT 
		FROM recovery a,installment d,user_admins e 
		WHERE a.recovery_status = 2 
		AND e.admin_id=d.admin_id 
		AND a.installment_id= d.installment_id 
		AND d.admin_id = e.admin_id
		GROUP BY YEAR(a.paid_date), MONTH(a.paid_date),(d.admin_id)
		ORDER BY YEAR(a.paid_date),MONTH(a.paid_date)
		");
			$risk = $this->db->getRowList();


		}
		if($this->request('export')){


			$content[] = array(
				'No.',
				'Collection Month',
				'Collection Year',
				'Collection Amount (RM)',
				'Recovery Officer',

			);

			foreach($risk as $i => $key){
				$officername=$key['admin_name'];

				if($key['MONTH(a.paid_date)'] == '1'){
					$key['MONTH(a.paid_date)'] = "JANUARY";
				}
				if($key['MONTH(a.paid_date)'] == '2'){
					$key['MONTH(a.paid_date)'] = "FEBRUARY";
				}
				if($key['MONTH(a.paid_date)'] == '3'){
					$key['MONTH(a.paid_date)'] = "MARCH";
				}
				if($key['MONTH(a.paid_date)'] == '4'){
					$key['MONTH(a.paid_date)'] = "APRIL";
				}
				if($key['MONTH(a.paid_date)'] == '5'){
					$key['MONTH(a.paid_date)'] = "MAY";
				}
				if($key['MONTH(a.paid_date)'] == '6'){
					$key['MONTH(a.paid_date)'] = "JUNE";
				}
				if($key['MONTH(a.paid_date)'] == '7'){
					$key['MONTH(a.paid_date)'] = "JULY";
				}
				if($key['MONTH(a.paid_date)'] == '8'){
					$key['MONTH(a.paid_date)'] = "August";
				}
				if($key['MONTH(a.paid_date)'] == '9'){
					$key['MONTH(a.paid_date)'] = "SEPTEMBER";
				}
				if($key['MONTH(a.paid_date)'] == '10'){
					$key['MONTH(a.paid_date)'] = "OCTOBER";
				}
				if($key['MONTH(a.paid_date)'] == '11'){
					$key['MONTH(a.paid_date)'] = "NOVEMBER";
				}
				if($key['MONTH(a.paid_date)'] == '12'){
					$key['MONTH(a.paid_date)'] = "DECEMBER";
				}
				if($key['head_id'] == $this->admin->id){

					

					$content[] = array(
						$i+1,
						$key['MONTH(a.paid_date)'],
						$key['YEAR(a.paid_date)'],
						$key['TOTALCOUNT'] ,
						$key['admin_name'],


					);

				}
				if ($key['admin_id']==(($this->admin->role == '1' || $this->admin->role == '2' || $this->admin->role_type == '1')))
				{
					if ($key['MONTH(a.paid_date)']=='1'){
						$key['MONTH(a.paid_date)']=="January";}
					if ($key['MONTH(a.paid_date)']=='2'){
						$key['MONTH(a.paid_date)']=="February";}
					if ($key['MONTH(a.paid_date)']=='3'){
						$key['MONTH(a.paid_date)']=="March";}
					if ($key['MONTH(a.paid_date)']=='4'){
						$key['MONTH(a.paid_date)']=="April";}
					if ($key['MONTH(a.paid_date)']=='5'){
						$key['MONTH(a.paid_date)']=="May";}
					if ($key['MONTH(a.paid_date)']=='6'){
						$key['MONTH(a.paid_date)']=="June";}
					if ($key['MONTH(a.paid_date)']=='7'){
						$key['MONTH(a.paid_date)']=="July";}
					if ($key['MONTH(a.paid_date)']=='8'){
						$key['MONTH(a.paid_date)']=="August";}
					if ($key['MONTH(a.paid_date)']=='9'){
						$key['MONTH(a.paid_date)']=="September";}
					if ($key['MONTH(a.paid_date)']=='10'){
						$key['MONTH(a.paid_date)']=="October";}
					if ($key['MONTH(a.paid_date)']=='11'){
						$key['MONTH(a.paid_date)']=="November";}
					if ($key['MONTH(a.paid_date)']=='12'){
						$key['MONTH(a.paid_date)']=="December";}

					$content[] = array(
						$i+1,
						$key['MONTH(a.paid_date)'],
						$key['YEAR(a.paid_date)'],
						$key['TOTALCOUNT'] ,
						$key['admin_name'],


					);

				}
			}

			header('Content-Encoding: UTF-8');
			header('Content-Type: text/csv; charset=UTF-8');
			header('Content-Disposition: attachment;filename="summarycollection_('.$officername.').csv"');
			header('Cache-Control: max-age=0');

			$fp = fopen('php://output', 'wb');
			//fprintf($fp, chr(0xEF).chr(0xBB).chr(0xBF));

			foreach ($content as $line) {
				fputcsv($fp, $line, ',');
			}
			fclose($fp);
			exit();




		}

		set('borrower_id',$borrower_id);
// set('select',$select);
		set('date_from', $date_from);
		set('date_to', $date_to);
		set('risk', $risk);
		set('selectofficername',$selectofficername);
		set('admin_id',$admin_id);


		return render('report/report-summary-collection.php', 'layout/default.php');

	}
}
?>
