 <body style='background:#112233'>
 <?php 
 
 if(isset($_GET['birthId'])){
     $birthId=$_GET['birthId'];
 }
 
 ?>
   <script src="https://code.jquery.com/jquery-3.3.1.js"></script>
 <form id="paymentForm">
  <div class="form-group" hidden>
    <label for="email">Email Address</label>
    <input type="email" value="s@f.com" id="email-address" required />
  </div>
  <div class="form-group" hidden>
    <label for="amount">Amount</label>
    <input type="tel" id="amount" value='150' required />
  </div>
  <div class="form-group" hidden>
    <label for="first-name">First Name</label>
    <input type="text" value='No' id="first-name" />
  </div>
  <div class="form-group" hidden>
    <label for="last-name">Last Name</label>
    <input type="text" value='no' id="last-name" />
  </div>
  
  <div class="payment-info-card" style="max-width: 500px; margin: 60px auto 30px auto; background: #fff; border-radius: 16px; box-shadow: 0 4px 24px rgba(44,62,80,0.08); padding: 32px 28px 24px 28px; text-align: center;">
    <div style="margin-bottom: 18px;">
      <i class="fas fa-wallet" style="font-size: 2.5rem; color: #3498db;"></i>
    </div>
    <h2 style="font-weight: 700; color: #2c3e50; margin-bottom: 12px;">Complete Your Payment</h2>
    <p style="color: #6c757d; font-size: 1.08rem; margin-bottom: 18px;">
      You are about to make a secure payment for your registration. Please review the details below and click <b>Continue with Payment</b> to proceed.
    </p>
    <div class="payment-summary" style="background: #f8f9fa; border-radius: 8px; padding: 18px 0; margin-bottom: 10px;">
      <div style="font-size: 1.1rem; color: #2c3e50; font-weight: 600;">Service:</div>
      <div style="font-size: 1.05rem; color: #4a90e2; margin-bottom: 6px;">Birth/Death Certificate Registration</div>
      <div style="font-size: 1.1rem; color: #2c3e50; font-weight: 600;">Amount:</div>
      <div style="font-size: 1.2rem; color: #27ae60; font-weight: 700;">GHS 150</div>
    </div>
    <div style="font-size: 0.98rem; color: #888; margin-bottom: 0;">
      All payments are processed securely. You will receive a confirmation after successful payment.
    </div>
  </div>
  
  <div class="form-submit" style="display: flex; justify-content: center; align-items: center; gap: 20px; margin-top: 40px;">
    <button type="submit" onclick="payWithPaystack()" class="btn btn-primary pay-btn">
      <i class="fas fa-credit-card"></i> Continue with Payment
    </button>
    <button type="button" onclick="window.history.back()" class="btn btn-secondary back-btn">
      <i class="fas fa-arrow-left"></i> Back
    </button>
  </div>
</form>
<script src="https://js.paystack.co/v1/inline.js"></script> 

<script>
    const paymentForm = document.getElementById('paymentForm');
paymentForm.addEventListener("submit", payWithPaystack, false);
function payWithPaystack(e) {
  e.preventDefault();
  let handler = PaystackPop.setup({
    key: 'pk_test_5649ae77c299633f3c7b842f257c719ae2cf4cd5', // Replace with your public key
    email: document.getElementById("email-address").value,
    amount: document.getElementById("amount").value * 100,
    currency: 'GHS',
    ref: ''+Math.floor((Math.random() * 1000000000) + 1), // generates a pseudo-unique reference. Please replace with a reference you generated. Or remove the line entirely so our API will generate one for you
    // label: "Optional string that replaces customer email"
    onClose: function(){
      alert('Window closed.');
    },
    callback: function(response){
        var id=<?php echo $birthId ?>;
        $.ajax({
                url: 'ajaxRequest.php?id='+id,
                method: 'get',
                success: function (response) {
                   alert(response);
                }
              });
      let message = 'Payment complete! Reference: ' + response.reference;
      alert(message);
    }
  });
  handler.openIframe();
}

</script>

<style>
.pay-btn {
  background: linear-gradient(90deg, #3498db 0%, #4a90e2 100%);
  color: #fff;
  border: none;
  border-radius: 8px;
  padding: 14px 32px;
  font-size: 1.1rem;
  font-weight: 600;
  box-shadow: 0 4px 12px rgba(52,152,219,0.15);
  transition: background 0.3s, box-shadow 0.3s;
  display: flex;
  align-items: center;
  gap: 10px;
}
.pay-btn:hover {
  background: linear-gradient(90deg, #217dbb 0%, #357ab8 100%);
  box-shadow: 0 6px 18px rgba(52,152,219,0.25);
}
.back-btn {
  background: #f8f9fa;
  color: #2c3e50;
  border: 1px solid #e0e0e0;
  border-radius: 8px;
  padding: 14px 32px;
  font-size: 1.1rem;
  font-weight: 600;
  box-shadow: 0 2px 6px rgba(44,62,80,0.07);
  transition: background 0.3s, color 0.3s;
  display: flex;
  align-items: center;
  gap: 10px;
}
.back-btn:hover {
  background: #e9ecef;
  color: #217dbb;
}
@media (max-width: 600px) {
  .form-submit {
    flex-direction: column;
    gap: 12px;
  }
  .pay-btn, .back-btn {
    width: 100%;
    justify-content: center;
    padding: 12px 0;
    font-size: 1rem;
  }
}
</style>

</body>