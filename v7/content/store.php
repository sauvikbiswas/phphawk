<img src="images/storebanner.jpg"><br>
<?php
$statelist = array('Andhra Pradesh','Arunachal Pradesh','Assam','Bihar','Chhattisgarh',
'Goa','Gujarat','Haryana','Himachal Pradesh','Jammu and Kashmir','Jharkhand',
'Karnataka','Kerala','Madhya Pradesh','Maharashtra','Manipur','Meghalaya','Mizoram',
'Nagaland','Orissa','Punjab','Rajasthan','Sikkim','Tamil Nadu','Tripura','Uttar Pradesh',
'Uttarakhand','West Bengal','Andaman and Nicobar','Chandigarh','Dadra and Nagar Haveli',
'Daman and Diu','Lakshadweep','NCT Delhi','Puducherry');

$flag=0;
foreach($HTTP_GET_VARS as $key => $value) {
	if ($flag==1) {
		if ($key=='city') $flag=2;
		else $HTTP_GET_VARS['address']=$HTTP_GET_VARS['address'].'&amp;'.$key;
	}
	if ($flag==1) {
		if ($key=='state') $flag=3;
		else $HTTP_GET_VARS['city']=$HTTP_GET_VARS['city'].'&amp;'.$key;
	}
	if ($key=='address') $flag=1;
}
$name = trim($HTTP_GET_VARS['name']);
$copies = (int)trim($HTTP_GET_VARS['copies']);
$email = trim($HTTP_GET_VARS['email']);
$newsletter = $HTTP_GET_VARS['newsletter'];
$address = $HTTP_GET_VARS['address'];
$city = trim($HTTP_GET_VARS['city']);
$state = $HTTP_GET_VARS['state'];
$pin = $HTTP_GET_VARS['pin'];
$code = trim($HTTP_GET_VARS['code']);
$bookingstatus = $HTTP_GET_VARS['bookingstatus'];

if ($bookingstatus=='') {$copies=1; $newsletter='on';}

$pin = (int)$pin;
$pin = (string)$pin;
if ($pin=='0') $pin='';

/*Checks*/

$error = 1;
$err = '';

if (($code!='') and (is_code_in_codes($code)==0)) $code='x';
if (($code!='') and (is_code_in_usedcodes($code)==1)) $code='x';

if ((is_code_in_codes($code)==1) and (is_code_in_usedcodes($code)==0)) $discount=30; else $discount=0;
if ($name=='') {$error *= 2; $err .= 'Name field cannot be left empty.<br>';}
if (($email=='') or (!isEmail($email))) {$error *= 3; $err .= 'Email id is empty or invalid.<br>';}
if (str_replace('<br>','',trim($address))=='') {$error *= 5; $err .= 'Address field cannot be left empty.<br>';}
if ($city=='') {$error *= 7; $err .= 'City field cannot be left empty.<br>';}
if (strlen($pin)!='6') {$error *= 11; $err .= 'PIN Code is either empty or invalid.<br>';}
if ($code=='x') {$error *= 13; $err .= 'Promo-code is either invalid or already used. Proceed with no code or enter a valid one.<br>'; $code='';}
if ($copies<=0) {$error *= 17; $err .= 'Please enter a positive number in Copies.<br>'; $copies=1;}

if (($bookingstatus!='') and ($error!=1)) {
echo('<div style="padding: 5px; background: #FFFF99;">'.$err.'</div>');
$bookingstatus=0;
}

if($bookingstatus==1)
{
	?>
	<b>Please verify the following address :</b>
	<div style="padding: 5px; background: #FFFF99;">
	<b><?php echo($name)?></b><br><?php echo($address)?><br><?php echo($city)?><br><?php echo($state)?> - <?php echo($pin)?></div>
	Your email : <?php echo($email)?><br>
	No. of copies : <?php echo($copies)?><br>
	Pay-on-delivery (VPP Charge) : INR <?php echo(150*$copies+20)?> <?php if($code!="") echo('<br><small>(Subject to 20% discount on one CD by promo code : '.$code.')</small>')?><br><br>
	<form id="booking" method="get" action="#store"><input type="hidden" name="name" value="<?php echo($name)?>"><input type="hidden" name="copies" value="<?php echo($copies)?>">
	<input type="hidden" name="email" value="<?php echo($email)?>">
	<input type="hidden" name="address" value="<?php print_r(preg_replace('/<br\\s*?\/??>/i', "\r\n", $address))?>">
	<input type="hidden" name="city" value="<?php echo($city)?>"><input type="hidden" name="state" value="<?php echo($state)?>">
	<input type="hidden" name="pin" value="<?php echo($pin)?>">
	<input type="hidden" name="bookingstatus" value="2"><input type="hidden" name="code" value="<?php echo($code)?>">
	You can either proceed to <a onclick="booking_re();" href="#store" style="border: 1px solid rgb(0, 0, 0); padding: 2px; font-size: 120%; font-weight: bold; text-decoration: none;">Re-Edit Details</a> or <a onclick="booking();" href="#store" style="border: 1px solid rgb(0, 0, 0); padding: 2px; font-size: 120%; font-weight: bold; text-decoration: none;">Confirm Order</a>
	</form>
	<?php
}
elseif (($bookingstatus==0) or ($bookingstatus=='')){
?>
	<form id="booking" method="get" action="#store">
	Name : <input name="name" value="<?php echo($name)?>" size=40> &nbsp;&nbsp;&nbsp;Copies: <input name="copies" size=1 value="<?php echo($copies)?>"><br>
	Email : <input name="email" value="<?php echo($email)?>" size=40><br>
	Address : <small>Please enter an address where the postman can deliver and receive payment.<br>Please do not use the following special characters - <b>!</b>,<b>\</b>,<b>#</b>,<b>&</b>,<b>@</b>,<b>$</b></small> <br>
	&nbsp;&nbsp;<textarea name="address" wrap="virtual" cols=40 rows=4><?php print_r(preg_replace('/<br\\s*?\/??>/i', "\r\n", $address))?></textarea><br>
	City : <input name="city" value="<?php echo($city)?>"> &nbsp;&nbsp;&nbsp;State/UT : 
	<select name="state">
	<?php
	foreach ($statelist as $stateform)
	{
		if($stateform==$state) echo('<option value="'.$stateform.'" SELECTED>'.$stateform.'</option>');
		else echo('<option value="'.$stateform.'">'.$stateform.'</option>');
	}
	?>
	</select><br>
	PIN : <input name="pin" value="<?php echo($pin)?>"><br>
	<input type="hidden" name="bookingstatus" value="1">
	If you have a promo code* please enter it here : <input name="code" value="<?php echo($code)?>" size="10"> and &nbsp;
	<a onclick="booking();" href="#store" style="border: 1px solid rgb(0, 0, 0); padding: 2px; font-size: 120%; font-weight: bold; text-decoration: none;">Place Order</a>
	</form>
	<small>*Promo Code is optional.</small>
	<?php
}

else {
	$book =  insert_bookinglist($name, $copies, $email, $address, $city, $state, $pin, $code);
	if ($code!='') insert_usedcode($code);
	if(!is_email_in_mailinglist($email)) insert_mailinglist(getIP(), $email);
	if($book) echo('Congratulations. Your order has been successfully booked.<br>You will be shipped '.$copies.' copy/copies of <b><i>Liberty & Entropy</i></b> as soon as it becomes available.<br>Please honour the Value Payable Post.</br>');
	else echo('There has been a problem processing the order. Kindly try again later.<br>');
	echo('<a href="#store" onclick="loadpage(\'store\');">Click Here</a> to book another order.<br>');
}

?>	