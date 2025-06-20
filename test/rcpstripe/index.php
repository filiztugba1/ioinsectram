<!DOCTYPE html>
<html lang="en">
<head>
  <title>Bootstrap Example</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>

  <style>
	.card{
		width:300px;
		margin-right: auto;
		margin-left: auto;
	}
	.card:hover{
	    box-shadow: 0px 0px 5px 1px #c3c3c3;
		width:310px;
	}
	.price
	{
		    font-size: 83px;
		 text-align: center;
	}
	.price>span{
		font-size: 25px;
		position: absolute;
		margin-top: 20px;
		left: 93px;
	}
  
  </style>
</head>
<body>

<div class="jumbotron text-center">
  <h1>My First Bootstrap Page</h1>
  <p>Resize this responsive page to see the effect!</p> 
</div>
  
<div class="container">
  <div class="row">
    <div class="col-sm-4">
	<div class='card'>
		<div class='card-header'>
			<h2 class='price'><span>€</span>27</h2>
		</div>
		<div class='card-body'>
			<h2>Product 1</h1>
			<ul class='list-group'>
				<li class='list-group-item'>Feature 1</li>
				<li class='list-group-item'>Feature 2</li>
				<li class='list-group-item'>Feature 3</li>
			</ul>
		</div>

		<div class='card-footer'>
			<form action="paymentProcess.php?pid=1" method="POST">
				<script
					src="https://checkout.stripe.com/checkout.js" class="stripe-button"
					data-key="pk_test_nY6Nz1MJpUxsXqpCLnqHS2Xs00zqpszcNa"
					data-amount="2700"
					data-name="Stripe.com"
					data-description="Sample Charge"
					data-locale="auto"
					data-currency="eur"
					data-zip-code="true">
				</script>
			</form>
		</div>

		</div>
    </div>

    <div class="col-sm-4">
	<div class='card'>
		<div class='card-header'>
			<h2 class='price'><span>€</span>67</h2>
		</div>
		<div class='card-body'>
			<h2>Product 1</h1>
			<ul class='list-group'>
				<li class='list-group-item'>Feature 1</li>
				<li class='list-group-item'>Feature 2</li>
				<li class='list-group-item'>Feature 3</li>
			</ul>
		</div>

			<div class='card-footer'>
			<form action="paymentProcess.php?pid=2" method="POST">
				<script
					src="https://checkout.stripe.com/checkout.js" class="stripe-button"
					data-key="pk_test_nY6Nz1MJpUxsXqpCLnqHS2Xs00zqpszcNa"
					data-amount="6700"
					data-name="Stripe.com"
					data-description="Sample Charge"
					data-locale="auto"
					data-currency="eur"
					data-zip-code="true">
				</script>
			</form>
		</div>

		</div>
    </div>
    
	<div class="col-sm-4">
	<div class='card'>
		<div class='card-header'>
			<h2 class='price'><span>€</span>97</h2>
		</div>
		<div class='card-body'>
			<h2>Product 1</h1>
			<ul class='list-group'>
				<li class='list-group-item'>Feature 1</li>
				<li class='list-group-item'>Feature 2</li>
				<li class='list-group-item'>Feature 3</li>
			</ul>
		</div>

		<div class='card-footer'>
			<form action="paymentProcess.php?pid=3" method="POST">
				<script
					src="https://checkout.stripe.com/checkout.js" class="stripe-button"
					data-key="pk_test_nY6Nz1MJpUxsXqpCLnqHS2Xs00zqpszcNa"
					data-amount="9700"
					data-name="Stripe.com"
					data-description="Sample Charge"
					data-locale="auto"
					data-currency="eur"
					data-zip-code="true">
				</script>
			</form>
		</div>


		</div>
    </div>

  </div>
</div>

</body>
</html>
