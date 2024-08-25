<!DOCTYPE html>
<html lang="en">
<head>
	<title>PAK TANI</title>
	<link rel="stylesheet" href="/assets/css/stylelogin.css" />
	<link href="https://fonts.googleapis.com/css?family=Poppins:600&display=swap" rel="stylesheet">
	<script src="https://kit.fontawesome.com/a81368914c.js"></script>
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="shortcut icon" href="/assets/img/logo.png" />
</head>
<body>
	<div class="container">
		<div class="img">
			<img src="/assets/img/imgleft.png">
		</div>
		<div class="login-content">
			<form method="POST" action="{{ route('login') }}">
                @csrf
				<img src="/assets/img/logo.png">
				<h2 class="title">Selamat Datang!</h2>
				<!-- Cek apakah ada pesan error -->
				@if($errors->any())
					<div class="alert alert-danger">
						<strong>Error!</strong> {{ $errors->first('email') }}
					</div>
				@endif
           		<div class="input-div one">
           		   <div class="i">
           		   		<i class="fas fa-user"></i>
           		   </div>
           		   <div class="div">
           		   		{{-- <input type="text" class="input" placeholder ="Username"> --}}
                        <input type="email" value="{{ old('email') }}" name="email" class="input form-control" id="email" placeholder ="Email" required autofocus>
           		   </div>
           		</div>
           		<div class="input-div pass">
           		   <div class="i"> 
           		    	<i class="fas fa-lock"></i>
           		   </div>
           		   <div class="div">
           		    	{{-- <input type="password" class="input" placeholder ="Password "> --}}
                        <input type="password" name="password" class="input form-control" id="password" placeholder ="Password" required>
            	   </div>
            	</div>
            	{{-- <input type="submit" class="btn" value="Login"> --}}
                <button type="submit" class="btn btn-primary">Login</button>
            </form>
        </div>
    </div>
    <script type="text/javascript" src="js/main.js"></script>
</body>
</html>
