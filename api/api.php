<?php

include ('config/database.php');

//Take from form
//$cust_id = $_POST['cust_id'];

// Check if customer already have Credit Scoring
$conn = OpenCon();

$sql = "SELECT * FROM user_data WHERE cust_completion = 99 AND cust_scoring = 0 cust_id >=315 ";
$result = $conn->query($sql);


$token1 = "";
$token2 = "";

if (mysqli_num_rows($result) > 0) {
	while($row = $result->fetch_assoc()) {
		if($row['cust_dob']){
			print_r($row['cust_firstname']);
		
			$firstAPI = api1($row['cust_firstname'],$row['cust_nric'],$row['cust_dob']);

			$FirstAPIResponse = json_decode($firstAPI,true);
			
			print_r($FirstAPIResponse);
			$response = $FirstAPIResponse['ccris_identity'];

			$idKey = $response[0]['CRefId'];
			$entityKey  = $response[0]['EntityKey'];
			
			echo "<br>Idkey = ".$idKey;
			echo "<br>entityKey = ".$entityKey;
			

			$SecondAPI = api2($idKey,$entityKey,$row['cust_mobile1']);
			$data = json_decode($SecondAPI);

			$token1 = strval($data->token1);
			$token2 = strval($data->token2);
			
			//echo "<br>Token1 : ".$token1;
			//echo "<br>Token2 : ".$token2;

			$final_data = '';
			api3($token1,$token2,$row['cust_firstname']);
			
			$final = json_decode($final_data,true);
			
			// Add one more step to update column cust_scoring from ["i_score"]=>["risk_grade"]
			//print_r($final);

			foreach($final['summary'] as $finale){
				if($finale['risk_grade']){
					$insert_query = "UPDATE user_data SET cust_scoring='".$finale['risk_grade']."' and ramci_data = '".$finale."' WHERE cust_id = '".$row['cust_id']."'";
					$stmt = $conn->prepare($insert_query);
					$stmt->execute();
					$stmt->close();
				}
			}
		
			
		}
	}
}else{
	var_dump('No records');
	exit();
}

function api1($name,$nric,$dob){
	// Staging
	$url = 'https://b2buat.ramcreditinfo.com.my/index.php/homecrowd/report';
	
	// Production
	//$url = 'https://b2buat.ramcreditinfo.com.my/index.php/homecrowd/report';

	//echo $name."<br>".$nric."<br>".$dob.'<br>';
	$data = array('request' => array(
			'ProductType' => 'CCRIS_SEARCH',
			'GroupCode' => '11',
			'EntityName' => $name,
			'EntityId' => $nric,
			'EntityId2' => '',
			'Country' => 'MY',
			'DOB' => $dob,
			)
		);

	$ch = curl_init();

	// Staging Credentials
	$username = 'HOMECUAT1';
	$password = 'Homecuat.1';
	
	// Production Credentials
	//$username = 'HCB2B1';
	//$password = 'e2x5k3';
	
	curl_setopt($ch, CURLOPT_URL,$url);
	curl_setopt($ch, CURLOPT_POST, 1);
	curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-type: application/json'));
	curl_setopt($ch, CURLOPT_USERPWD, $username . ":" . $password);
	curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode( $data ));
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

	$server_output = curl_exec($ch);

	curl_close ($ch);
	
	return $server_output;
}

function api2($CRefId, $EntityKey,$mobile){
	// Staging
	$url = 'https://b2buat.ramcreditinfo.com.my/index.php/homecrowd/report';
	
	// Production
	//$url = 'https://b2buat.ramcreditinfo.com.my/index.php/homecrowd/report';


	$data = array('request' => array(
			'ProductType' => 'IRISS',
			'CRefId' => $CRefId,
			'EntityKey' => $EntityKey,
			'MobileNo' => $mobile,
			'ConsentGranted' => 'Y',
			'EnquiryPurpose' => 'NEW APPLICATION',
			'Ref1' => '',
			'Ref2' => '',
			'Ref3' => '',
			'Ref4' => '',
			)
		);

	$ch = curl_init();

	// Staging Credentials
	$username = 'HOMECUAT1';
	$password = 'Homecuat.1';
	
	// Production Credentials
	//$username = 'HCB2B1';
	//$password = 'e2x5k3';
	
	curl_setopt($ch, CURLOPT_URL,$url);
	curl_setopt($ch, CURLOPT_POST, 1);
	curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-type: application/json'));
	curl_setopt($ch, CURLOPT_USERPWD, $username . ":" . $password);
	curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode( $data ));
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

	$server_output = curl_exec($ch);
	curl_close ($ch);
	return ($server_output);
}

function api3($t1, $t2, $custname){
	// Staging
	$url = 'https://b2buat.ramcreditinfo.com.my/index.php/homecrowd/json';
	
	// Production
	//$url = 'https://b2buat.ramcreditinfo.com.my/index.php/homecrowd/json';

	$data = array('request' => array(
			'token1' => $t1,
			'token2' => $t2,
			)
		);

	$ch = curl_init();

	// Staging Credentials
	$username = 'HOMECUAT1';
	$password = 'Homecuat.1';
	
	// Production Credentials
	//$username = 'HCB2B1';
	//$password = 'e2x5k3';
	
	curl_setopt($ch, CURLOPT_URL,$url);
	curl_setopt($ch, CURLOPT_POST, 1);
	curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-type: application/json'));
	curl_setopt($ch, CURLOPT_USERPWD, $username . ":" . $password);
	curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode( $data ));
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

	$server_output = curl_exec($ch);
	curl_close ($ch);
	
	$json_data = json_decode(json_encode($server_output,true));
	
	$fp = fopen($row['cust_firstname'].'_log.txt', 'w');
	fwrite($fp, serialize($json_data));
	fclose($fp);
	
	$last_data = json_decode($json_data,true);
	
	//echo '<br>'.$last_data['code'];
	
		if($last_data['code'] == '102'){
			sleep(10);
			api3($t1, $t2);
		}else{
			$GLOBALS['final_data'] = $json_data;
		}
}

?>
