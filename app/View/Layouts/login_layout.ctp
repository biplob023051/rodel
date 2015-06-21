<!DOCTYPE html>
<html>
<head>
	<title>
	Rodel-math
	</title>
	<meta charset="UTF-8" />
	<!--- Meta tag viewport -->
	  <meta name="viewport" id="viewport" content="width=device-width,minimum-scale=1.0,initial-scale=1.0" /> 
	  <meta name="viewport" content="user-scalable = yes">
	<!--- css style -->

	<link href="<?php echo $this->html->url('/css/style.css');?>" type="text/css" rel="stylesheet"/>
	<link href="<?php echo $this->html->url('/fonts/fonts.css');?>" type="text/css" rel="stylesheet"/>
<link href="<?php echo $this->html->url('/assets/css/bootstrap.css');?>" type="text/css" rel="stylesheet"/>
<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>
<script src="<?php echo $this->html->url('/js/placeholders.min.js');?>"></script>
</head>
<body style="overflow-x:hidden">
<div class="layout">
	<header class="header home-header">
		<div class="inner-container">
			<div class="left-content">
				<a href="index"><img src="<?php echo $this->html->url('/img/logo.png')?>" alt="logo"></a>
			</div>
			<div class="right-content">
			<form method="post" name="login" action="/users/login" onsubmit="return validateForm()">
				<h5>Sign In</h5>
				
				<ul>
					<li>
					  <input type="text" name="data[User][email]"  placeholder="Email address" id="email">
					  
					  <span class="errortxt" id ="errors"></span>
						
						<?php
 						if(isset($flagExist) && $flagExist==1) 
						 echo "<span class='errortxt'>Invalid email or password</span><script>alert('invalid email or Password');</script>";
						
						if(isset($flagactivate) && $flagactivate==1) 
						 echo "<span class='errortxt'>your account is not activated yet</span><script>alert('your account is not activated yet');</script>";
						?>
					  </li>
					<li>
					 <div class="password">
						<input type="password" name="data[User][password]" placeholder="Password" id="password">
						<input type="submit" id="submit"/>
					 </div>
						
					   
						<span><a href="#" onclick="forgetpass()" data-toggle="modal" data-target="#myModal">Forgot password</a></span>
					</li>
				</ul>
				</form>
			</div>
		</div>
	</header>
	<section class="section">
		<div class="banner">
			<img src="<?php echo $this->html->url('/img/bg.jpg');?>" alt="banner-image"/>
			<div class="banner-content">
<?php if(isset($successtxt)){echo "<div class='form' style='color:#fff;'>".$successtxt."</div>";}else{?>
				<h5>Register</h5>
				<form method="post" name="regis" onsubmit="return validateforms()"   action="/users/registration" >
				<div class="form">
				<span class='errortxt hidetxt' style="color:#fff;">Please fill the required fields.</span>
				
				<span class='hidetxt' id="conpass">*Password not Match*</span>
				<?php if(isset($message)){ ?>
				<span class='errortxt' id="userexist">*Email already exist.*<script>alert("Email already exist.");</script></span>
				<?php } ?>
                               


				<ul>
					<li><input type="text" class="requiredtxt" name="data[User][first_name]" value="<?php echo $data['first_name'];?>" placeholder="First" id="first"></li>
<li><input type="text" class="requiredtxt" name="data[User][last_name]" value="<?php echo $data['last_name'];?>" placeholder="Last" id="last"></li>		
					<li><input type="password" class="requiredtxt" name="data[User][user_password]" placeholder="Password" id="password1"></li>	

				
								
					<li><input type="password"  class="requiredtxt" name="data[User][confirm_password]" placeholder="Confirm Password" 

id="cnfpassword"></li>
					<li><input type="email" value="<?php echo $data['email'];?>" onchange="check_availability()" class="requiredtxt" name="data[User][email]" placeholder="Email address" id="email1"></li>
				</ul>
				<input type="submit" id="submit1"/>
				</form>
<?php }?>
				</div>
			</div>
		<div  id="myModal" class="fpass" <?php if(isset($forgetsuccess) || isset($forgetPass)) echo "style='display:block'"; ?> >
                       <?php if(!isset($forgetsuccess)){ if(isset($forgetPass)) echo '<div id="errortxt" style="padding: 8px;background-color:#4E8DB3;height:54px;margin:-27px;">'.$forgetPass.'</div>';?>                                
                                <div><button onclick="forgetpass()" style="float:right;  margin-top: -20px;margin-right: -15px;" class="close">X</button><h4 <?php if(isset($forgetPass)) echo 'style="margin-top:48px;"';?> >Change Password</h4><h6 style="font-size:10px;">Let's Find Your Account</h6><form action='/users/forgetpassword/' method="post" onsubmit="return validateaccount();"><input type="email" class="form-control" placeholder="email address" name="data[User][email]" id="passforget"><br><input type="submit" id="submit3"></form></div>
<?php }else{?><div  style="padding: 8px;background-color:#4E8DB3;height:30px;margin:-27px;">Email sent.<a href="#" style="color:#fff">Didn't get it?</a><a href="/"><button class="close">X</button></a></div><div ><h2  style="margin-top: 29px;">We've sent you a link to change password</h2></div><?php }?>
                                <!-- /.modal-dialog -->
                            </div>

<?php if(isset($changepass) && $changepass==1){?>
<div  class="fpass" style="display:block">
<h3>Choose a new Password</h3>
<form method="post" action="/users/changepassword/" onsubmit="return validateforms1()">
<input type="hidden" name="data[User][email]" value="<?php echo $email;?>">
<input type="password" name="data[User][password]" class="form-control" placeholder="New Password" id="pass"/><br/>
<input type="password" name="data[User][confirm]" class="form-control" placeholder="confirm Password" id="confpass"/><br/>
continue <input type="submit" id="submit3">
</form><br><br>
<p style="text-align:justify">Passwords are case-sensitive and must be at least 6 characters long. A good password should contain a mix of capital and lower-case letters, numbers and symbols.</p>
<?php }?>
<?php if(isset($successpass)){?>
<div  class="fpass" style="display:block">
<h3>Great!</h3>
<h3>You've changed your password</h3>
Continue to Student Booklet Builder&nbsp;&nbsp;<a href="/users/dashboard/"><input type="submit" id="submit3"/></a>
</div>
<?php }?>


	</section>

	<footer class="footer">
		<div class="inner-container">
			<div class="left">
				<img src="<?php echo $this->html->url('/img/footer-logo.jpg')?>" alt="footer-logo">
			</div>
			<div class="right">
				<h6>RodelAZ.org</h6>
				<p>&copy;2015 Rodel Foundation of Arizona</p>
			</div>
		</div>
	</footer>
</div>
<script>
function validateForm() {
$(".errortxt").hide();
    var x = document.forms["login"]["data[User][email]"].value;
	var y = document.forms["login"]["data[User][password]"].value;
	if((x == null || x == "") && (y == null || y == "")){
         
         alert("Please enter a email and password");	
 document.getElementById('errors').innerHTML='*Please enter a email and password*';
        return false;
	}
    else if (x == null || x == "") {
          alert("Please enter a email");	
         document.getElementById('errors').innerHTML='*Please enter a email*';
        return false;
    }
	else if (y == null || y == "") {
         alert("Please enter a password");
       document.getElementById('errors').innerHTML='*Please enter a password*';
        return false;
    }
}
function validateforms1(){
var pass=document.getElementById('pass').value;
var conf=document.getElementById('confpass').value;
if(pass!=conf){
alert("Passwords don't match. Try again?");
return false;
}
else
return true;
}
function validateaccount(){
var forgetpass=document.getElementById('passforget').value;
if(forgetpass=='' || forgetpass==null){
alert("Please fill the value");
return false;
}
else{
return true;
} 
}
function validateforms()
{
 var flagerror=1;
 jQuery('.requiredtxt').each(function() {
 
  if(jQuery(this).val()=='')
  {
  
   jQuery(this).css('border-color','#ff0000');
  jQuery(this).css('border-width','thin'); 
   jQuery('.errortxt').show();
   flagerror=2;
  }
  else
  {
    jQuery(this).css('border-color','');
  }

    });
 
pass=document.getElementById('password1').value;
conf=document.getElementById('cnfpassword').value;
if(pass!=conf){
flagerror=2;
alert("Passwords don't match. Try again?");
return false;
}
 if(flagerror==1)
 {
  jQuery('.errortxt').hide();
  return true;
}
 

 
return false;
}
</script>

<script>
function forgetpass(){
$("#myModal").toggle();
$("#backdrop").toggle();
}
function errotxt(){
$("#errortxt").hide();
}
function check_availability(){  
  
        //get the username  
        var email = $('#email1').val();  
  
        //use ajax to run the check  
        $.post("/users/checkUsers", { email: email },  
            function(result){  
                //if the result is 1  
                
                if(result == 1){  
                    //show that the username is available  
                    $('#userexist1').show();  
               } 
        });  
  
}  
</script>
<div class="modal-backdrop fade in" <?php if(isset($forgetsuccess) || isset($forgetPass) ) echo "style='display:block'"; ?>  style="display:none" id="backdrop"></div>
</body>
</html>
