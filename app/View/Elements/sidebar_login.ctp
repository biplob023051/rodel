<!--=========================
  Left Zone ct
==============================-->
<aside>
     <div class="logo"><img src="../img/logo.png"/></div>
         <?php if($this->Session->read('user.User.role_id')=='0'){ ?>
	 <h2>Authentications</h2>
         <ul>

			<li class="l-user"><a href="<?php echo $this->html->url('/Authentications') ?>">Authentications</a></li>

			<li class="l-user"><a href="<?php echo $this->html->url('/Designations') ?>">Designations</a>
			<ul>
				<li class="user"><a href="<?php echo $this->html->url('/Designations/') ?>">List Designations</a></li>
				<li class="user"><a href="<?php echo $this->html->url('/Designations/add') ?>">Add Designation</a></li>
			</ul>
			</li>
			<li class="l-user"><a href="<?php echo $this->html->url('/Branches') ?>">Branches</a>
			<ul>
				<li class="user"><a href="<?php echo $this->html->url('/Branches/') ?>">List Branches</a></li>
				<li class="user"><a href="<?php echo $this->html->url('/Branches/add') ?>">Add Branch</a></li>
			</ul>
			</li>

         </ul>
	 <?php }?>
	 <h2>Users</h2>
         <ul>
           
	       <li class="user"><a href="<?php echo $this->html->url('/Users/add') ?>">Add Employee</a></li>
		<li class="l-user"><a href="<?php echo $this->html->url('/Users/view/1') ?>">List Employees</a></li>
		<li class="profile"><a href="<?php echo $this->html->url('/Users/userProfile') ?>">Your Profile</a></li>

         </ul>
         <h2>Retailers</h2>
         <ul>
             <li class="l-user"><a href="<?php echo $this->html->url('/Retailers/') ?>">Retailers List</a></li>
         </ul>
            <div class="copyright">
              <p><strong>Copyright © 2014 BMS4U</strong></p>
                <p>Theme by Webin info Soft Pvt Ltd</p>
            </div>
</aside>
<!--=========================
  Left Zone ct ENd
==============================-->