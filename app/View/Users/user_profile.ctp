<script>
	function load(address,latitude,longitude) 
	{		
		if(!address)
		{
			var mapProp = {
			center:new google.maps.LatLng(48.89364,48.89364),
			zoom:5,
			mapTypeId:google.maps.MapTypeId.ROADMAP
			  };

			var map=new google.maps.Map(document.getElementById("google_map"),mapProp);

			var marker=new google.maps.Marker({
			  position:myCenter,
			  });

			marker.setMap(map);
				
		}
		else
		{	

			var mapProp = {
			center:new google.maps.LatLng(latitude,longitude),
			zoom:5,
			mapTypeId:google.maps.MapTypeId.ROADMAP
			  };

			var map=new google.maps.Map(document.getElementById("google_map"),mapProp);

			var marker=new google.maps.Marker({
			  position:new google.maps.LatLng(latitude,longitude),
			  });

			marker.setMap(map);		
		
		}	 
	}

	function showAddress(address) 
	{				
		var geo = new google.maps.Geocoder;
		geo.geocode({'address':address},function(results, status){
			if (status == google.maps.GeocoderStatus.OK) 
			{			
				var latitude = results[0].geometry.location.lat();
				var longitude = results[0].geometry.location.lng();	
				$('#lat').val(latitude);
				$('#long').val(longitude);
				load(address,latitude,longitude); 
			}
			
		});
	}
	$(document).ready(function(){
		var data = $('#address').val();
		if(data)
			showAddress(data);
		else
			showAddress('India');
		loadDesignation($('#parentDesignation').val());
	});
	</script>
	<script>
       var specialKeys = new Array();
       specialKeys.push(8); 
       function IsNumeric(e) 
	   {
            var keyCode = e.which ? e.which : e.keyCode
            var ret = ((keyCode >= 48 && keyCode <= 57) || specialKeys.indexOf(keyCode) != -1);
            document.getElementById("error").style.display = ret ? "none" : "inline";
            return ret;
        }
</script>
<div id="registration_form">View Profile</div>
	<form action="" method="post">
		<article class="module width_full" style="width: 75%;float: right;margin: 0px;margin-top:10px;">
		<header><h3 style="color: #1F1F20;text-transform: uppercase;text-shadow: 0 1px 0 #fff;font-size: 13px;margin-left: 10px;">Your Contact Information</h3></header>
				<div class="module_content">
				<table style="float:left;width:50%">
				<tr>
						<td></td>
						<td><input type="hidden" name="data[UserProfile][id]" value="<?php echo $userDetail['UserProfile']['id'];?>" required></td>
					</tr>
					<tr>
						<td>First Name</td>
						<td><input type="text" name="data[UserProfile][first_name]" value="<?php echo $userDetail['UserProfile']['first_name'];?>" required></td>
					</tr>
					<tr>
						<td>Last Name</td>
						<td><input type="text" name="data[UserProfile][last_name]" value="<?php echo $userDetail['UserProfile']['last_name'];?>" required></td>
					</tr>
					<tr>
						<td>Email</td>
						<td><input type="email" name="data[UserProfile][email]" value="<?php echo $userDetail['UserProfile']['email'];?>" required></td>
					</tr>
					<tr>
						<td>Phone no.</td>
						<td><input type="text" name="data[UserProfile][phone]" onkeypress="return IsNumeric(event);" ondrop="return false;" onpaste="return false;" maxlength="10" value="<?php echo $userDetail['UserProfile']['phone'];?>" required></td>
					</tr>
					<tr>
						<td></td>
						<td><span id="error" style="color: Red; display: none">*Enter Only Integer Value</span></td>
					</tr>
					<tr>
						<td>City</td>
						<td><input type="text" name="data[UserProfile][city]" value="<?php echo $userDetail['UserProfile']['city'];?>" required></td>
					</tr>
					<tr>
						<td>State</td>
						<td><input type="text" name="data[UserProfile][state]" value="<?php echo $userDetail['UserProfile']['state'];?>" required></td>
					</tr>
					<tr>
						<td>Address</td>
						<td><textarea name="data[UserProfile][address]" style="border-radius: 4px;border: 2px inset;height: 95px;" id="address" onblur="showAddress(this.value);return false;"><?php echo $userDetail['UserProfile']['address'];?></textarea></td>
					</tr>					
				</table>
					<div id="google_map" style="width:48%;border:1px solid rgb(194, 194, 194); height:300px;"></div>
				</div>
				<footer>
				<div class="submit_link">
					<input type="submit" value="Publish" class="alt_btn">
				</div>
			</footer>
		</article><!-- end of post new article -->
		</form>
