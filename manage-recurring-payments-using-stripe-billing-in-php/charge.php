<?php
  require_once('./config.php');

  require_once("vendor/autoload.php");
  \Stripe\Stripe::setApiKey($stripe['secret_key']);

  $token  = $_POST['stripeToken'];
  $email  = $_POST['stripeEmail'];

  $plan = \Stripe\Plan::create(array(
      "product" => [
          "name" => "PHP Tutorials with Examples",
          "type" => "service"
      ],
      "nickname" => "PHP Tutorials Public Access",
      "interval" => "month",
      "interval_count" => "1",
      "currency" => "usd",
      "amount" => "3000",
  ));

  $customer = \Stripe\Customer::create([
      'email' => $email,
      'source'  => $token,
  ]);

   $subscription = \Stripe\Subscription::create(array(
      "customer" => $customer->id,
      "items" => array(
          array(
              "plan" => $plan->id,
          ),
      ),
  ));


  echo '<h1>Successfully charged $30.00!</h1>';


?>