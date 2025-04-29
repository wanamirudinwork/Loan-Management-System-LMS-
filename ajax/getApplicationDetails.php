<?php 

session_start();

include ('db_connection.php');	

$conn = OpenCon();

	//$stmt = $mysqli->prepare("SELECT * FROM myTable WHERE name = ? AND age = ?");
    $stmt = $conn->prepare("SELECT * FROM application where app_id = ?");
  	$stmt->bind_param("s", $_GET['id']); 
  	
    
  	$result=$stmt->execute();
  	$result = $stmt->get_result();

  
  

while($row = $result->fetch_assoc()) {
	$loanAmount =$row['app_amount'];
	$terms=	$row['app_years'];
	$interest = $row['app_interest_return']/100;
	$installment = (($loanAmount*($interest/12))) / (1-pow((1+($interest/12)),(-1*$terms*12)));
	$installment= number_format($installment,2,'.','');

    echo "<div class=\"form-group\">";
	echo "<label class=\"col-sm-2 control-label\">Loan Amount</label>";
	echo "<div class=\"col-sm-10\">";
	echo  $row['app_amount'];
	echo "</div>";
	echo "</div>";

	echo "<div class=\"form-group\">";
	echo "<label class=\"col-sm-2 control-label\">Loan Tenure(Years)</label>";
	echo "<div class=\"col-sm-10\">";
	echo  $row['app_years'];
	echo "</div>";
	echo "</div>";

	echo "<div class=\"form-group\">";
	echo "<label class=\"col-sm-2 control-label\">Loan Amount</label>";
	echo "<div class=\"col-sm-10\">";
	echo  $row['app_amount'];
	echo "</div>";
	echo "</div>";

	echo "<div class=\"form-group\">";
	echo "<label class=\"col-sm-2 control-label\">Interest Rate</label>";
	echo "<div class=\"col-sm-10\">";
	echo  $row['app_interest_return'];
	echo "</div>";
	echo "</div>";

	echo "<div class=\"form-group\">";
	echo "<label class=\"col-sm-2 control-label\">Installment Amount</label>";
	echo "<div class=\"col-sm-10\">";
	echo  $installment;
	echo "</div>";
	echo "</div>";
	
}

   
   
							

    


		//return render('management/inquiry.php', 'layout/default.php');
?>