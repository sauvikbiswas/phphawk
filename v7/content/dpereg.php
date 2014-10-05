<?php
$email = $HTTP_GET_VARS['regemail'];
$ip = getIP();
if(isemail($email)==1) { 
if (is_email_in_mailinglist($email)<=0) {
insert_mailinglist($ip, $email);
echo('Thank you for registering the email <b>'.$email.'</b> for <b>DP <font color="red">ezine</font></b>');
}
else echo('The email <b>'.$email.'</b> is already registered for <b>DP <font color="red">ezine</font></b>');
}
else
{
 echo ('Invalid Email.<br>Sign Up for the Newsletter: <b>DP <font color="red">ezine</font></b><br/>
<form id="dpeform" method="post" action="#">
<input onfocus="clearemail();" value="Enter your email here." name="email" style="border: 1px solid rgb(0, 0, 0);"/>
<a onclick="dpeadd();" href="#" style="border: 1px solid rgb(0, 0, 0); padding: 2px; text-decoration: none;">Submit</a>
</form>');
}
?>