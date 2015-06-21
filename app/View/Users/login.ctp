<div class="form-ct">
    <h1>Company logo</h1>
	<?php if($flagExist==1)  {?>
	<span class="error">Invalid Username or Password</span>
	<?php }?>
	<form method="post" action="">
          <ol>
            <li><span class="user"><img src="<?php echo $this->Html->url('/');?>img/user.png"></span><input type="text" required title="Username" Placeholder="Username" name="username" class="half-full"/></li>
              <li><span class="user"><img src="<?php echo $this->Html->url('/');?>img/lock.png"></span><input type="password" required title="Password" name="password" Placeholder="Password" class="half-full"/></li>
               <li><input type="submit" class="login" value="Login"><a href="#">Forgot Password</a></li>
          </ol>
        </form>
</div>