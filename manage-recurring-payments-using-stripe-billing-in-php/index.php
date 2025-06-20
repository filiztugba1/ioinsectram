<?php require_once('./config.php'); ?>
<style>
.frmStripePayment {
    border: #E0E0E0 1px solid;
    padding: 20px 30px;
    width: 180px;
    text-align: center;
    background: #ececec;
    margin: 60px auto;
    font-family: Arial;
}
.plan-caption {
    margin-bottom: 30px;
    font-size: 1.2em;
    width: 180px;
}
</style>
<form action="charge.php" method="post" class="frmStripePayment">
  <div class="plan-caption">Want to Read PHP Video Tutorials?</div>
  <script src="https://checkout.stripe.com/checkout.js" class="stripe-button"
          data-key="<?php echo $stripe['publishable_key']; ?>"
          data-name="GOALSTART"
          data-description="ABONNEMENT 1 MOIS"
          data-panel-label="Souscrire"
          data-label="Subscribe Now"
          data-locale="auto">></script>
</form>