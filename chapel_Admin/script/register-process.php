<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

require_once '../../core/init.php';

$admin = new Admin();
$validate = new Validate();
$show = new Show();
if (isset($_POST['action']) && $_POST['action'] == 'addAdmin') {

	if (Input::exists()) {

			$validation = $validate->check($_POST, array(
				'fullname' => array(
					'required' => true,
					'min' => 10,
					'max' => 255

				),
				'sudo_email' => array(
					'required' => true,
					'unique' => 'superusers'

				),
                'sudo_phoneNo' => array(
                    'required' => true,
                    'unique' => 'superusers'

                ),
				'password' => array(
					'required' => true,
					'min' => '10',
					'max' => '50'

				),
				'confirm-password' => array(
					'required' => true,
					'matches' => 'password'
				),
				'permission' => array(
					'required' => true,

				)



			));
		if ($validation->passed()) {

			$password_hash = password_hash(Input::get('password'), PASSWORD_DEFAULT);
		try {

			$admin->create(array(
				'sudo_full_name' => Input::get('fullname'),
				'sudo_email' => Input::get('sudo_email'),
				'sudo_password' => $password_hash,
				'sudo_permission' => Input::get('permission'),
                'sudo_phoneNo' => Input::get('sudo_phoneNo'),
                'passport' => 'default.png'

			));
				$randNo = rand(1000, 9999);
				$token = md5(microtime(uniqid()));
				$url =  'https://localhost/allsaintschapel/chapel_Admin/verify_email.php?token='.$token;

				$email = Input::get('sudo_email');
				$password = Input::get('password');
				$fullname = Input::get('fullname');

				$adminGet = $admin->findEmail($email);

					$adminFullName = $adminGet->sudo_full_name;
					$adminId = $adminGet->id;

					$fname = explode(' ', $adminFullName);
					$firstname = $fname[0];

					$username = $firstname.'-'.$randNo;

					$admin->updateAdmin($username, $email);
                     echo 'success';



            //Load Composer's autoloader
            require APPROOT . '/vendor/autoload.php';

            //mail function
            $mail = new PHPMailer(true);



//            try {
//                //SMTP settings
////              $mail->SMTPDebug = 3;
//                $mail->isSMTP();
//                $mail->Host = "smtp.gmail.com";
//                $mail->SMTPAuth = true;
//                $mail->Username = EMAIL;
//                $mail->Password =  PASSWORD;
//                $mail->SMTPSecure = "tls";
//                $mail->Port = 587; // for tls
//
//                //email settings
//                $mail->isHTML(true);
//                $mail->setFrom("ucodetut@gmail.com",  "All Saints Chapel.");
//                $mail->addAddress($email);
//                //   $mail->addReplyTo("noreply@ucodetuts.com.ng");
//                $mail->Subject = "Welcome to All Saints Chapel Admin";
//               $mail->Body = "
//            <div style='width:80%; height:auto; padding:10px; margin:10px'>
//
//           <p style='color: #000; font-size: 20px; text-align: center; text-transform: uppercase;margin-top:0px'> Welcome All Saints Chapel. </p>
//        <p  style='color: #000; font-size: 18px; text-transform:capitalize;margin:10px;  '>Hi!&nbsp;&nbsp; $fullname<br>
//            You have be granted access to the Admin Panel of All Saints Chapel.
//        </p>
//        <p style='color:red;'>Note: You are been monitored so please be careful what you do here!</p>
//        <p>Here are your login details <br> <span style='color:green;'>Username: $username and Password: $password </span></p>
//        <h4>You are advised to change your password immediately on your first login</h4>
//        <p>
//        	You are equally mandated to verify your email address by clicking the link blow: <br>
//        	<a href='$url'>$url</a>
//        </p>
//
//         </div>
//
//        ";
//        $mail->send();
//        echo 'success';
//
//        } catch (\Exception $e) {
//
//        echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
//        }



	}catch (Exception $e) {
		echo $e->getMessage();
	}




		}else{
			foreach ($validation->errors() as $error) {
			echo $show->showMessage('danger',$error, 'warning');
			return false;
			}


		}
	}






}
