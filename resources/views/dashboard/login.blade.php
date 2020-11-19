@include('dashboard.layout.header')

<div class="hero hero3">
	<div class="container">
		<div class="row">
			<div class="col-md-12">
				<!-- <h1> movie listing - list</h1>
				<ul class="breadcumb">
					<li class="active"><a href="#">Home</a></li>
					<li> <span class="ion-ios-arrow-right"></span> movie listing</li>
				</ul> -->

<div class="login-content">
<form method="post" action="{{ url('/login') }}">
        	@csrf
	<div class="row">
		 <label for="username">
	        Username:
	        <input type="text" name="username" id="username" placeholder="Username" required="required" />
	    </label>
	</div>

	<div class="row">
		<label for="password">
	        Password:
	        <input type="password" name="password" id="password" placeholder="******" required="required" />
	    </label>
	</div>
	<div class="row">
		<div class="remember">
			<div>
				<input type="checkbox" name="remember" value="Remember me"><span>Remember me</span>
			</div>
			<a href="#">Forget password ?</a>
		</div>
	</div>
	<div class="row">
		 <button type="submit">Login</button>
	</div>
	</form>

			</div>
			</div>
		</div>
	</div>
</div>


<div class="col-lg-8 " >
<div class="card text-left">
    <div class="card-header">
    	<h3 class="card-title">DataTable For Actors</h3>
    </div>

    <div class="card-body">
    	
	</div>
</div>
</div>

<div class="login-wrapper" id="login-content">
    <div class="login-content">
        <a href="#" class="close">x</a>
        <h3>Login</h3>
        <form method="post" action="{{ url('/login') }}">
        	@csrf
        	<div class="row">
        		 <label for="username">
                    Username:
                    <input type="text" name="username" id="username" placeholder="Username" required="required" />
                </label>
        	</div>
           
            <div class="row">
            	<label for="password">
                    Password:
                    <input type="password" name="password" id="password" placeholder="******" required="required" />
                </label>
            </div>
            <div class="row">
            	<div class="remember">
					<div>
						<input type="checkbox" name="remember" value="Remember me"><span>Remember me</span>
					</div>
            		<a href="#">Forget password ?</a>
            	</div>
            </div>
           <div class="row">
           	 <button type="submit">Login</button>
           </div>
        </form>
    </div>
</div>

@include('dashboard.layout.footer')