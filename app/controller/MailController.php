<?php

namespace app\controller {

use app\service\OrderService;
use app\service\PayService;
use \app\service\R;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
    
    class MailController extends AbstractController
    {

          /**
         * @RequestMapping(url="order/mail", method="GET", type="template")
         * @RequestParams(true)
         */
        public function mailOrder($order)
        {
        	return 'mail/email';
        	$mail = new PHPMailer(true);                              // Passing `true` enables exceptions
			try {
			    //Server settings
			    $mail->SMTPDebug = 2;                                 // Enable verbose debug output
			    $mail->isSMTP();                                      // Set mailer to use SMTP
			    $mail->Host = 'smtp.gmail.com';//smtp2.gmail.com';  // Specify main and backup SMTP servers
			    $mail->SMTPAuth = true;                               // Enable SMTP authentication
			    $mail->Username = '';                 // SMTP username
			    $mail->Password = '';                           // SMTP password
			    $mail->SMTPSecure = 'ssl';                            // Enable TLS encryption, `ssl` also accepted
			    $mail->Port = 465;                                    // TCP port to connect to

			    //Recipients
			    $mail->setFrom('prabhat2k15@gmail.com', 'Mailer');
			    $mail->addAddress('mevicky4u2k11@gmail.com', 'Joe User');     // Add a recipient
			    // $mail->addAddress('ellen@example.com');               // Name is optional
			    // $mail->addReplyTo('info@example.com', 'Information');
			    // $mail->addCC('cc@example.com');
			    // $mail->addBCC('bcc@example.com');

			    //Attachments
			    // $mail->addAttachment('/var/tmp/file.tar.gz');         // Add attachments
			    // $mail->addAttachment('/tmp/image.jpg', 'new.jpg');    // Optional name

			    //Content
			    $mail->isHTML(true);                                  // Set email format to HTML
			    $mail->Subject = 'Here is the subject';
			    $mail->Body    = 'This is the HTML message body <b>in bold!</b>';
			    $mail->AltBody = 'This is the body in plain text for non-HTML mail clients';

			    $mail->send();
			    echo 'Message has been sent';
			} catch (Exception $e) {
			    echo 'Message could not be sent.';
			    echo 'Mailer Error: ' . $mail->ErrorInfo;
			}
        }
    }
}