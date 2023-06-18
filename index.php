<!DOCTYPE html>
<html>
<head>
    <title>Login - Post And Comment System</title>
	<link href="jGrowl/jquery.jgrowl.css" rel="stylesheet" media="screen"/>
	<script src="js/jquery-1.9.1.min.js"></script>
	<?php include('dbconn.php'); ?>
	<!--CSS Bootstrap CDN-->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-9ndCyUaIbzAi2FUVXJi0CjmCapSmO7SnpJef0486qhLnuZ2cdeRhO02iuK6FUUVM" crossorigin="anonymous">
    <!--Alert JS-->
    <script src="js/alert.js"></script>
    <!--Alert CSS-->
    <link rel="stylesheet" href="css/alert.css">
</head>

    <body>
    	<form id="login_form"  method="post">
            <h3>Login</h3>
            <label for="">Username</label><br/>
            <input type="text"  id="username" name="username" placeholder="Username" required><br><br>
            
            <label for="">Password</label><br/>
            <input type="password" id="password" name="password" placeholder="Password" required><br><br>
            
            <button name="login" type="submit" class="btn btn-primary">Login</button>
    	</form>
    		
    		<script>
    			jQuery(document).ready(function(){
        			jQuery("#login_form").submit(function(e){
            			e.preventDefault();
            		    var formData = jQuery(this).serialize();
            			$.ajax({
            				type: "POST",
            				url: "login.php",
            				data: formData,
            				success: function(html){
                    			if(html=='true'){
                    			    
                    			 //   $.jGrowl("Welcome Back!", { header: 'Access Granted' });
                    				var delay = 2000;
                    				setTimeout(function(){ window.location = 'home.php'  }, delay);  
                    				show_success_alert();
                    			}
                    			else{
                    				// $.jGrowl("Please Check your username and Password", { header: 'Login Failed' });
                    				show_Err_alert();
                    			}
            			    }
            						
            			});
            			let form = document.getElementById('login_form');
                    	form.reset();
            			return false;
        			});
    			});
    			</script>  
    
            <?php include('scripts.php');?>
        <!--JS Bootstrap CDN-->
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-geWF76RCwLtnZ8qwWowPQNguL3RmwHVBC9FhGdlKrxdiJJigb/j/68SIy3Te4Bkz" crossorigin="anonymous"></script>
    </body>
</html>