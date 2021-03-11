<!DOCTYPE html>
<html>
	<!-- Session starting & connecting to Database -->
	<?php 
	session_start();
	include('db_connect.php');
	?>
	<head>
		<!-- Title of the Page-->
		<title>Login and Sign Up</title>
		<!-- CSS & Font Awesome -->
		<link rel="stylesheet" type="text/css" href="style.css">
		<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
	</head>
	<body>
		<!-- Login Container -->
		<div class="container" id="container">
			<!-- Form Signup Container -->
			<div class="form-container sign-up-container">
				<!-- Form -->
				<form method="POST">
					<h1>Create Account</h1>
					<input type="text" name="signup_name" placeholder="Name" required>
					<input type="email" name="signup_email" placeholder="Email" required>
					<input type="password" name="signup_password" placeholder="Password" required>
					<button type="submit" name="signup">Sign Up</button>
				</form>
			</div>
			<!-- Form Sign In Container -->
			<div class="form-container sign-in-container">
				<form action="signin.php" method="POST" id="login-form">
					<h1>Log In Here</h1>			
				<input type="email" name="login_email" placeholder="Email" required>
				<input type="password" name="login_password" placeholder="Password" required>
				<button type="submit" name="login">Log In</button>
				</form>
			</div>
			<div class="overlay-container">
				<div class="overlay">
					<div class="overlay-panel overlay-left">
						<h1>Welcome Back!</h1>
						<p>To keep connected with us please login with your personal info</p>
						<button class="ghost" id="signIn">Log In</button>
					</div>
					<div class="overlay-panel overlay-right">
						<h1>Hello</h1>
						<p>Enter your details and start journey with us</p>
						<button class="ghost" id="signUp">Sign Up</button>
					</div>
				</div>
			</div>
		</div>
		<script type="text/javascript">
			const signUpButton = document.getElementById('signUp');
			const signInButton = document.getElementById('signIn');
			const container = document.getElementById('container');
			signUpButton.addEventListener('click', () => {
				container.classList.add("right-panel-active");
			});
			signInButton.addEventListener('click', () => {
				container.classList.remove("right-panel-active");
			});
		</script>
	</body>
</html>
<?php
		if(isset($_POST['login'])){
        
			$login_email = mysqli_real_escape_string($conn,$_POST['login_email']);
			
			$login_password = mysqli_real_escape_string($conn,$_POST['login_password']);

			$salt = "codeflix";
			$password_encrypted = sha1($login_password.$salt);
			
			$get_login_info = "select * from signup where (email='$login_email' AND password='$password_encrypted')";
			
			$run_login = mysqli_query($conn,$get_login_info);
			
			$count = mysqli_num_rows($run_login);
			
			if($count==1){
				
				$_SESSION['login_email']=$login_email;
	
				echo "<script>window.open('index.php','_self')</script>";
				
			}else{
				
				echo "<script>alert('Wrong Credentials. Try Again!')
				location.href ='signin.php';
				</script>";				
			}	
		}

		if(isset($_POST['signup'])){
		
			$signup_name = $_POST['signup_name'];
			
			$signup_email = $_POST['signup_email'];
			
			$signup_password = $_POST['signup_password'];

			$salt = "codeflix";
			$password_encrypted = sha1($signup_password.$salt);
			
			$signup_exists = "select * from signup where (name ='$signup_name' AND email='$signup_email' AND password='$password_encrypted')";

			$run_signup_exists = mysqli_query($conn,$signup_exists);
			
			$count = mysqli_num_rows($run_signup_exists);

			if($count==1)
			{
				echo "<script>alert('Sign Up Info Exists')</script>";
			}
			else{
				$signup_info = "insert into signup (name, email, password)
				values ('$signup_name', '$signup_email', '$password_encrypted')";
				
				$run_signup = mysqli_query($conn,$signup_info);
				
				if($run_signup){
					echo "<script>alert('Your account has been created')</script>";
					echo "<script>window.open('signin.php','_self')</script>";
				}else{
					echo "<script>alert('Your account has not been created. Try Again!')</script>";
					echo "<script>window.open('signin.php','_self')</script>";	
				}
			}
			
		}
?>

