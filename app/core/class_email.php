<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\SMTP;

if ( !defined( "root" ) ) die;

class email {

	public function __construct( $loader ){
		$this->loader = $loader;
	}
	public function send( $to, $_subject, $content, $from=null ){

		$email_s_type    = $this->loader->admin->get_setting( "email_s_type", "mail" );
		$email_s_host    = $this->loader->admin->get_setting( "email_s_host", null );
		$email_s_port    = $this->loader->admin->get_setting( "email_s_port", null );
		$email_s_user    = $this->loader->admin->get_setting( "email_s_user", null );
		$email_s_pass    = $this->loader->admin->get_setting( "email_s_pass", null );
		$email_s_encrypt = $this->loader->admin->get_setting( "email_s_encrypt", null );
		$sitename        = $this->loader->admin->get_setting( "sitename" );

		$from = $from ? $from : "noreply@" . domain;

		$_content = $this->loader->html->load_part( "email_template",[
			"logo"     => $this->loader->general->path_to_addr( $this->loader->theme->set_name($this->loader->admin->get_setting("theme_name"))->get_setting( "logo" ) ),
			"color"    => $this->loader->theme->set_name($this->loader->admin->get_setting("theme_name"))->get_setting( "color" ),
			"text"     => htmlspecialchars_decode( $content, ENT_QUOTES ),
			"sitename" => $sitename,
			"siteurl"  => $this->loader->ui->rurl( "index" )
		] );

		if ( $email_s_type == "mail" || empty( $email_s_host ) || empty( $email_s_port ) ){

			$headers  = "From: {$sitename} <{$from}>\r\n";
			$headers .= "Content-Type: text/html; charset=UTF-8";
			try {
				mail( $to, $_subject, $_content, $headers );
				$sent = true;
			}
			catch( Exception $err ){
				$sent = false;
			}

		}
		else {

			require_once( app_core_root . "/third/PHPMailer/vendor/autoload.php" );
			$mail = new PHPMailer( true );
			try {

				//Server settings
				$mail->isSMTP();
				$mail->Host       = $email_s_host;
				$mail->Port       = $email_s_port;
				$mail->SMTPAuth   = true;
				$mail->Username   = $email_s_user;
				$mail->Password   = $email_s_pass;
				$mail->SMTPSecure = $email_s_encrypt == "tls" ? "tls" : "ssl";
				$mail->SMTPOptions = array(
					'ssl' => array(
						'verify_peer' => false,
						'verify_peer_name' => false,
						'allow_self_signed' => true
					)
				);

				//Recipients
				$mail->setFrom( $from , $sitename );
				$mail->addAddress( $to );

				// Content
				$mail->isHTML(true);
				$mail->Subject = $_subject;
				$mail->Body    = $_content;

				// Send
				$mail->send();
				$sent = true;

			} catch (phpmailerException $e) {
				$error = $e->errorMessage();
			} catch (Exception $e) {
				$error = $e->getMessage();
			}

			if ( !empty( $sent ) && empty( $error ) )
			return true;

			return !empty( $error ) ? $error : false;

		}

	}
	public function test_smtp(){

		$tester_user = $this->loader->visitor->user()->data;
		$email_s_host = $this->loader->admin->get_setting( "email_s_host", null );
		$email_s_port = $this->loader->admin->get_setting( "email_s_port", null );

		if ( !$email_s_host || !$email_s_port ) return "Invalid SMTP setting";

		$test = $this->send( $tester_user["email"], "Testing SMTP", "SMTP Works!" );

		return $test === true ? true : ( $test === false ? "Failed. Unkown reason" : $test );

	}

}

?>
