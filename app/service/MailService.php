<?php
namespace app\service {

use Instamojo\Instamojo;
use app\service\OrderService;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use Dompdf\Dompdf;

  class MailService
  {
  	public static function mail($orderid)
  	{

  		$res=OrderService::getOrder($orderid);
  		
  		$message = file_get_contents('app/view/mail/email.tpl'); 
	    $message = str_replace('username', $res->user->name, $message); 
	    $message = str_replace('useraddress','['.$res->user->address_type.']'. $res->user->address, $message); 
	    $message = str_replace('usercity', $res->user->city.','.$res->user->state.' '.$res->user->pincode, $message); 
	    $message = str_replace('usermobile', $res->user->mobile, $message); 
	    $message = str_replace('receipt', $orderid, $message); 
	  
	    $content=''; $total=0;
	    foreach ($res->suborder as $key => $so) {
		    $content.=	'<tr>';
	        $content.=  '<td class="col-md-9"><em>'.$so->title.'</em></h4></td>';
	        $content.=  '<td class="col-md-1" style="text-align: center"> '.$so->qty.' </td>';
	        $content.=  '<td class="col-md-1 text-center">'.$so->price.'</td>';
	        $content.=  '<td class="col-md-1 text-center">'.$so->qty*$so->price.'</td>';
	        $content.=	'</tr>';
	        $total+=$so->qty*$so->price;
	    }
	    $message = str_replace('contentproduct', $content, $message); 
	    $message = str_replace('amount', $total, $message); 
	    $message = str_replace('tax', '0.00', $message); 
	    $message = str_replace('gtotal', $total, $message); 

  		$dompdf = new Dompdf();
		$dompdf->loadHtml($message);//("hello this is a pdf <br>hii this is 2nd line");

		// (Optional) Setup the paper size and orientation
		$dompdf->setPaper('A4', 'landscape');

		// Render the HTML as PDF
		$dompdf->render();

		// //saving in directory
		$pdf = $dompdf->output();
		$filename='order'.time().'.pdf';
		$file_location = $_SERVER['DOCUMENT_ROOT'].'src/image/pdf/'.$filename;
		file_put_contents($file_location,$pdf); 

		// // Output the generated PDF to Browser
		// // $dompdf->stream();
		
		// echo 'done';

		// die;

	    $mail = new PHPMailer(true);                              // Passing `true` enables exceptions
			try {
				$config=\Config::getSection("MAIL_CONFIG");
			    //Server settings
			    $mail->SMTPDebug = 0;                                 // Enable verbose debug output
			    $mail->isSMTP();                                      // Set mailer to use SMTP
			    $mail->Host = 'smtp.gmail.com';//smtp2.gmail.com';  // Specify main and backup SMTP servers
			    $mail->SMTPAuth = true;                               // Enable SMTP authentication
			    $mail->Username = $config['email'];                 // SMTP username
			    $mail->Password = $config['secret'];                  // SMTP password
			    $mail->SMTPSecure = 'ssl';                            // Enable TLS encryption, `ssl` also accepted
			    $mail->Port = 465;                                    // TCP port to connect to

			    //Recipients
			    $mail->setFrom('info@modestreet.in', 'Modestreet');
			    $mail->addAddress('mstreet2k15@gmail.com','Modestreet');//$res->user->email, $res->user->name);     // Add a recipient
			    // $mail->addAddress('ellen@example.com');               // Name is optional
			    // $mail->addReplyTo('info@example.com', 'Information');
			    // $mail->addCC('cc@example.com');
			     $mail->addBCC('mstreet2k15@gmail.com');

			    //Attachments
			    $mail->addAttachment($_SERVER['DOCUMENT_ROOT'].'src/image/pdf/'.$filename);         // Add attachments
			    // $mail->addAttachment('/tmp/image.jpg', 'new.jpg');    // Optional name

			    //Content
			    $mail->isHTML(true);                                  // Set email format to HTML
			    $mail->Subject = 'MS Purchase :'.rand(1000,9999);
			    $mail->Body    = $message;//'This is the HTML message body <b>in bold!</b>';
			    $mail->AltBody = 'This is the body in plain text for non-HTML mail clients';

			    $mail->send();
			    
			    return 'Message has been sent';
			} catch (Exception $e) {
			    echo 'Message could not be sent.';
			    echo 'Mailer Error: ' . $mail->ErrorInfo;
			}

  		
  		
  	}
  }
}