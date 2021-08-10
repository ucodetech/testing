<?php
    require_once '../core/init.php';
    require_once APPROOT . '/includes/authhead.php';

     $msg = '';

    $user = new Admin();
    $email = $user->getAdminEmail();
    if (isset($_POST['verifyOtp'])){
            if(isset($_POST['otp'])){
                $otp = $_POST['otp'];
                $check = Database::getInstance()->get('verifyAdmin', array('token', '=', $otp));
            if ($check->count()) {
                $checke = $check->first();
                if($otp == $checke->token){
                $sql = "DELETE FROM verifyAdmin  WHERE sudo_email = '$email'";
                if(Database::getInstance()->query($sql))
                Redirect::to('admin-dashboard');
                }
            }else{
                $msg = '<span class="text-danger">OTP is invalid or has expired</span>';
            }
            
            }
        }
    //resend

  if (isset($_POST['resendOtp'])) {
    $adminEmail = $admin->getAdminEmail();
      $sql = "SELECT * FROM verifyAdmin WHERE  sudo_email = '$adminEmail'";
     $check = $this->_db->query($sql);
   if ($check->count()) {
        $check = $check->first();
        $rndno=rand(100000, 999999);//OTP generate
        $token = "OTP NUMBER: "."<h2>".$rndno."</h2>";
        
    $mail =  new PHPMailer(true);

    try{
      
               // //SMTP settings
               // $mail->isSMTP();
               // $mail->Host = "mail.ucodetuts.com.ng";
               // $mail->SMTPAuth = true;
               // $mail->Username = "noreply@ucodetuts.com.ng";
               // $mail->Password =  "warmechine500@#**@@";
               // $mail->SMTPSecure = "ssl";
               // $mail->Port = 465; //587 for tls
              $mail->isSMTP();
              $mail->Host = "smtp.gmail.com";
              $mail->SMTPAuth = true;
              $mail->Username = "ucodetut@gmail.com";
              $mail->Password =  "warmechine500@##***";
              $mail->SMTPSecure = "tls";
              $mail->Port = 587; // for tls

               //email settings
               $mail->isHTML(true);
               $mail->setFrom("ucodetut@gmail.com", "Library Offence Doc.");
               $mail->addAddress($adminEmail);
               // $mail->addReplyTo("ucodetut@gmail.com", "Library Offence Doc.");
               $mail->Subject = 'Device Verification';
               $mail->Body = "
            <div style='width:80%; height:auto; padding:10px; margin:10px'>
      
        <p style='color: #fff; font-size: 20px; text-align: center; text-transform: uppercase;margin-top:0px'>One Time Password Verification<br></p>
        <p>Hey $fullname! <br><br>

        A sign in attempt requires further verification because we did not recognize your device. To complete the sign in, enter the verification code on the unrecognized device.
        
       <br><hr>
        $token <br><hr>
        
        If you did not attempt to sign in to your account, your password may be compromised. Visit https://localhost/libraryoffencedoc/lod_Admin/admin-login to create a new, strong password for your UcodeTut account.</p>
                <hr>
       
       </div>
        ";
        if($mail->send())
       
         $sql = "UPDATE verifyAdmin SET token = '$rndno' WHERE sudo_email = '$check->sudo_email' ";
          $this->_db->query($sql);
          $msg = '<span class="text-success">Token Resent</span>';
        
        } catch (\Exception $e) {
        echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
        }
    
  }
}
?>
    <!-- Content Wrapper. Contains page content -->
 
   	 <div class="container h-100">
      <div class="row h-100 align-items-center justify-content-center">
        <div class="col-lg-5">
          <div class="card border-danger shadow-lg">
            <div class="card-header bg-danger">
              <h3 class="m-0 text-white">
                <i class="fas fa-user-cog"></i>&nbsp; OTP Verification
              </h3>
            </div>
            <div class="card-body text-dark">
             <form action="" method="post" id="otpForm" class="px-3 my-auto">
            <div class="form">
              <span><?= $msg; ?></span><br>
              <span class="text-danger">
                An OTP was sent to your email address during login process for verification of your device. please enter the otp number to complete login process!
              </span>
            </div>
            <div class="form-group">
              <label for="otp">Enter OTP<sup class="text-danger">*</sup></label>
              <input type="text" name="otp" id="otp" class="form-control form-control-lg" placeholder="Enter OTP">
            </div>
          
            <div class="form-group">
              <button type="submit" name="verifyOtp" id="verifyOtp" class="btn  btn-success">Verify</button>
               <button type="submit" id="resendOtp" name="resendOtp" class="btn btn-info btn-sm float-right" >Resend OTP</button>

            </div>
           

        
        </form>
            </div>
          </div>
        </div>
      </div>
    </div>

>

 
  
</div>
           
<?php
    require_once APPROOT . '/includes/footer1.php';

?>

