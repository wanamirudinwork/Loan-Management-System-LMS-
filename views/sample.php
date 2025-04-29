<html>
<head>
<title>Loan Calculator -example</title>
</head>
<body>
<form method="post" action="loan.php">
<h2>Calculate your instalment</h2>
<table>
<tr>
<td>Loan capital</td><td><input type="text" name="capital" maxlength="7" size="7"></td>
</tr>
<tr>
<td>Time in years</td>
<td>
<select name="year">
<option>1</option>
<option>2</option>
<option>3</option>
<option>4</option>
<option>5</option>
<option>6</option>
<option>7</option>
<option>8</option>
<option>9</option>
<option>10</option>
<option>11</option>
<option>12</option>
<option>13</option>
<option>14</option>
<option>15</option>
<option>16</option>
<option>17</option>
<option>18</option>
<option>19</option>
<option>20</option>
<option>21</option>
<option>22</option>
<option>23</option>
<option>24</option>
<option>25</option>
</select>
</td>
</tr>
<tr>
<td>Interest</td>
<td>
<select name="interest">
<option>1.00</option>
<option>1.25</option>
<option>1.50</option>
<option>1.75</option>
<option>2.00</option>
<option>2.25</option>
<option>2.50</option>
<option>2.75</option>
<option>3.00</option>
<option>3.25</option>
<option>3.50</option>
<option>3.75</option>
<option>4.00</option>
<option>4.25</option>
<option>4.75</option>
<option>5.00</option>
</select>
</td>
</tr>
<tr>
<td>Instalment</td>
<td>
<select name="instalment">
<option>Fixed</option>
<option>Annuity</option>
</select>
</td>
</tr>
</table>
<br />
<input type="submit" value="Calculate">
</form>
<a href="index.htm">Back to examples</a>
</body>
</html>
PHP-script

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"> 
<html> 
<head> 
<title>Loan Calculator -example</title> 
</head> 
<body> 
<? 
/* 
Author: Jouni Juntunen  
Date: 8/2009  
Description: Read capital, interest, time and instalment from HTML-form and calculates annuity or fixed instalment 
         amortization schedule payment. 
*/ 
//Read values passed from HTML-form. 
$capital=$_POST['capital']; 
$interest=$_POST['interest']; 
$year=$_POST['year']; 
$instalment=$_POST['instalment']; 

//Print passed values to page. 
print "Capital $capital<br>"; 
print "Interest $interest<br>"; 
print "Instalment $instalment<br>"; 
print "Years $year<br>"; 

//Calculate time in months. 
$months=$year * 12; 

//Check out which is the instalment. 
if (strcmp($instalment,"Fixed")==0) 
//Fixed amortization schedule 
{ 
//Calculate fixed payment for month. 
    $fixedPayment=$capital / $months; 
    $interestRateForMonth=$interest / 12; 

//Calculate interest for every month. 
    for ($i=0;$i<$months;$i++) 
    { 
//Interest for the month. 
        $interestForMonth=$capital / 100 * $interestRateForMonth; 
//Diminish capital after calculating interest. 
        $capital=$capital - $fixedPayment; 
//Payment for month is fixed pay + interest. 
        $paymentForMonth=$fixedPayment + $interestForMonth; 
//Print out payment for this month. Output is formatted (payment has two digits) 
        $month=$i+1; 
        printf("$month payment is %.2f<br>", $paymentForMonth); 
    }     
} 
//Annuity 
else 
{ 
//Calculate montly pay. 
    $interest=$interest / 100; 
    $result=$interest / 12 * pow(1 + $interest / 12,$months) / (pow(1 + $interest / 12,$months) - 1) * $capital;     
    printf("Monthly pay is %.2f", $result); 
} 
?> 
<br><a href="loan.html">Calculate again</a><br> 
<a href="index.html">Back to examples</a> 
</body> 
</html>