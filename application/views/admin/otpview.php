<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Two Factor Authentication</title>
<style>
  body {
    font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    background-color: #f4f4f4;
    display: flex;
    justify-content: center;
    align-items: center;
    height: 100vh;
    margin: 0;
  }
  
  .container {
    background-color: #fff;
    padding: 30px;
    border-radius: 10px;
    box-shadow: 0 4px 8px rgba(0,0,0,0.1);
    width: 450px;
    text-align: center;
  }
  
  h2 {
    text-align: center;
    color: #333; 
    font-size: 32px; 
    margin-bottom: 20px; 
    text-transform: uppercase; 
    letter-spacing: 2px; 
    font-weight: bold; 
    text-shadow: 2px 2px 2px rgba(0, 0, 0, 0.3); 
  }
  
  .otp-input {
    width: calc(100% - 20px);
    padding: 12px;
    margin-bottom: 20px;
    font-size: 16px;
    border: 1px solid #ccc;
    border-radius: 6px;
    box-sizing: border-box;
    text-align: center;
    background-color: #f9f9f9; 
    color: #333; 
    outline: none;
  }
  
  .submit-btn {
    background-color: #ff6666; 
    color: #fff;
    border: none;
    padding: 14px 0;
    font-size: 16px;
    border-radius: 6px;
    cursor: pointer;
    transition: background-color 0.3s ease;
    width: 50%;
    margin-top: 10px;
    border-bottom: 4px solid #cc4d4d;
  }
  
  .submit-btn:hover {
    background-color: #cc4d4d; 
  }
  
  .error-message {
    background-color: rgba(255, 0, 0, 0.3); 
    color: white;
    padding: 10px;
    border-radius: 5px;
    margin-top: 10px;
    font-weight: bold;
  }
  .success-message {
    background-color: darkgreen;
    color: white;
    padding: 10px;
    border-radius: 5px;
    margin-top: 10px;
    opacity: 0.5;
    font-weight: bold;
  }
  .error {
    color: red;
    font-weight: bold;
  }
</style>
</head>
<body>
  <div class="container">
    <?php if (isset($error)) : ?>
        <div class="error-message">
            <?= $error ?>
        </div>
    <?php endif; ?>
    <h2>Two Factor Authentication</h2>
    <?php echo form_open('Otp/verifyOtp', array('onsubmit' => 'return validateOtpForm()')); ?>
      <input type="text" name="otp" id="otp" class="otp-input" placeholder="Enter OTP">
      <button type="submit" class="submit-btn">Submit</button>
      <p class="otpError" id="otpError"></p>
    <?php echo form_close(); ?>
    <br>
    <div class="copyright">
      Powered By :<br>
      <a href="https://www.zuku.co.in/" target="_blank"> 
        <img src="<?=base_url()?>adminast/assets/images/Zuku_Logo.png" style="height: 90px;" />
      </a>
    </div>
  </div>
  
  <script>
    function validateOtpForm() {
        document.getElementById("otpError").textContent = "";
        const otp = document.querySelector('.otp-input').value.trim();
        let valid = true;

        if (otp === "") {
            document.getElementById("otpError").textContent = "OTP cannot be empty";
            document.getElementById("otpError").classList.add('error');
            valid = false;
        } else if (otp.length !== 6 || isNaN(otp)) {
            document.getElementById("otpError").textContent = "Invalid OTP";
            document.getElementById("otpError").classList.add('error');
            valid = false;
        }

        return valid;
    }

    setTimeout(function () {
        var errorMessage = document.querySelector('.error-message');
        var successMessage = document.querySelector('.success-message');
        if (errorMessage) {
            errorMessage.style.display = 'none';
        }
        if (successMessage) {
            successMessage.style.display = 'none';
        }
    }, 6000);

    setTimeout(function () {
        var error = document.querySelector('.otpError');
        if (error) {
            error.style.display = 'none';
        }
    }, 6000);
  </script>
</body>
</html>
