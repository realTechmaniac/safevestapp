<!DOCTYPE html>
<html>
<head>
	<title>Currency Converter App</title>
	<link rel="stylesheet" type="text/css" href="{{asset('asset/css/bootstrap.min.css')}}">
	<link rel="preconnect" href="https://fonts.gstatic.com"> 
	<link href="https://fonts.googleapis.com/css2?family=Lato&display=swap" rel="stylesheet">
	<style type="text/css">
		body{

			font-family: 'Lato', sans-serif;
		}
	</style>
</head>
<body class="bg-light">

	

	<section>
	

		<div class=" mb-5">
			
			<div class="offset-md-3 col-md-6 offset-md-3 border border-light p-5 bg-white">

				<div class="error-div">
					
					<button type="button" class="close" aria-label="Close" id="closebutton">
					  <span aria-hidden="true">&times;</span>
					</button>

                    <header>

							<ul class="nav">
								 <li class="nav-item">
								    <img src="{{asset('asset/img/sprout-logo-new.png')}}" >
								 </li>
								 
							</ul>
				
					</header>

					@if(session()->has('success'))
				    <div class="alert alert-success">

				        {{ session()->get('success') }}

				    </div>

					@endif

					<div class="text-center mt-5">
                    	
                    	<h2>Transfer Payment</h2>
                    	

                    	<p class="pt-3 mr-2 ml-2">Kindly make a transfer to the account details provided below, <br>click the button below to verify when done.</p>
                    </div>
				</div>
				
				
				

				<form method="POST" action="{{route('return')}}">

					@csrf

						<div class="offset-md-1 col-md-10 offset-md-1">
							<div class="form-group mt-5">
							    <label for="exampleInputEmail1" class="font-weight-bold">Amount</label>
							    <h2><strong>&#8358;{{$amount}}</strong></h2>

								<div class="form-group mt-5" hidden="" >
							    <label for="exampleInputEmail1" class="font-weight-bold">Account Name</label>
							    <input type="text" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" name="amount" value="{{$amount}}" readonly="" class="font-weight-bold">
							
								</div>
							</div>
						</div>

						
						<div class="offset-md-1 col-md-10 offset-md-1">
							<div class="form-group mt-5" >
							    <label for="exampleInputEmail1" class="font-weight-bold">Account Name</label>
							    <input type="text" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" name="firstName" value="Sproutpay" readonly="" class="font-weight-bold">
							
							</div>
						</div>

						<div class="offset-md-1 col-md-10 offset-md-1">
							<div class="form-group mt-5">
							    <label for="exampleInputEmail1" class="font-weight-bold">Account Number</label>
							    <input type="text" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" name="firstName" value="4460795678" readonly="">
							
							</div>
						</div>


						<div class="offset-md-1 col-md-10 offset-md-1">
							<div class="form-group mt-5">
							    <label for="exampleInputEmail1" class="font-weight-bold">Bank Name</label>
							    <input type="text" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" name="firstName" value="Rubies MFB" readonly="">
							
							</div>
						</div>

				
					<div class="text-center pt-3">
						
					   <button type="submit" class="btn btn-primary">Pay Now</button>

					</div>
					
				</form>

			</div>

		</div>
	</section>




<script type="text/javascript" src="{{asset('asset/js/jquery-3.3.1.slim.min.js')}}"></script>
<script type="text/javascript" src="{{asset('asset/js/pay.js')}}"></script>
<script type="text/javascript" src="{{asset('asset/js/popper.min.js')}}"></script>
<script type="text/javascript" src="{{asset('asset/js/bootstrap.min.js')}}"></script>


</script>
</body> 
</html>