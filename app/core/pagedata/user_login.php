<?php

if ( !defined( "root" ) ) die;

use Hybridauth\Hybridauth;
$loader->html->set_title( $loader->lorem->turn( 'login_h1', [ "uc" => true ] ) );

$codes = [
  "fb"  => "Facebook",
  "tw"  => "Twitter",
  "ggl" => "Google",
  "ig"  => "Instagram"
];

foreach( $codes as $sl_code => $sl_name ){
  if ( $loader->admin->get_setting( "sl_{$sl_code}" ) )
  $active_codes[ $sl_code ] = $sl_name;
}

if ( ( $sl = $loader->secure->get( "get", "sl", "in_array", [ "values" => array_values( $codes ) ] ) ) ){

  $sl_name = strtolower( $sl );
  $sl_code = array_search( $sl, $codes );
  $sl_enabled = $loader->admin->get_setting( "sl_{$sl_code}" );
  $sl_k1 = $loader->admin->get_setting( "sl_{$sl_code}_k1" );
  $sl_k2 = $loader->admin->get_setting( "sl_{$sl_code}_k2" );

  if ( $sl_enabled && $sl_k1 && $sl_k2 ){

    require_once( app_core_root . "/third/hybridauth-3.6/autoload.php" );

    $config = array(
      "callback" => $loader->ui->rurl( "user_login", null, "sl={$sl}" ),
    );

    $config["providers"][ $sl_name ]["enabled"] = true;
    $config["providers"][ $sl_name ]["keys"][ $sl_code == "tw" ? "key" : "id" ] = $sl_k1;
    $config["providers"][ $sl_name ]["keys"]["secret"] = $sl_k2;

    if ( $sl_code == "fb" ){
      $config["providers"][ $sl_name ]["scope"] = "email";
      $config["providers"][ $sl_name ]["trustForwarded"] = false;
    }
    if ( $sl_code == "tw" ){
      $config["providers"][ $sl_name ]["includeEmail"] = true;
    }
    if ( $sl_code == "ig" ){
      $config["providers"][ $sl_name ]["scope"] = "user_profile";
    }

    try {

      $hybridauth = new Hybridauth( $config );
      $authProvider = $hybridauth->authenticate( $sl_name );
      $tokens = $authProvider->getAccessToken();
      $user_profile = $authProvider->getUserProfile();

      if ( $user_profile && isset( $user_profile->identifier ) ){

          $email = !empty( $user_profile->email ) ? $user_profile->email : "{$sl_code}_{$user_profile->identifier}@{$sl_name}.com";

          if ( ( $_user_id = $loader->user->email_exists( $email ) ) ){

            $loader->hit->create_session( $_user_id );

          }
          else {

            // username
            $username = $user_profile->identifier;
            $displayname_as_username = $loader->general->make_code( $user_profile->displayName );
            if ( $loader->secure->validate( $displayname_as_username, "username" ) ){
              $username = $displayname_as_username;
            }
            $username_o = $username;
            $username_i = 2;
            $username_exists = $loader->user->username_exists( $username );
            while( $username_exists ){
              $username = "{$username_o}{$username_i}";
              $username_exists = $loader->user->username_exists( $username );
            }

            $loader->user->create( $username, $email, md5(uniqid()), 1 );
            $_user_id = $loader->user->email_exists( $email );

            if ( $_user_id ){

              if ( $user_profile->firstName ? $loader->secure->validate( $user_profile->firstName, "string" ) : false ){
                $loader->db->_update(array(
                  "table" => "_users",
                  "set" => array(
                    [ "name", $user_profile->firstName ]
                  ),
                  "where" => array(
                    [ "ID", "=", $_user_id ]
                  )
                ));
              }
              if ( $user_profile->photoURL ){
                $loader->db->_update(array(
                  "table" => "_users",
                  "set" => array(
                    [ "avatar", $user_profile->photoURL ]
                  ),
                  "where" => array(
                    [ "ID", "=", $_user_id ]
                  )
                ));
              }

            }

          }

          header( "Location: " . $loader->ui->rurl("/") );
          exit;

      }

    }
    catch( Exception $e ){
      exit($e->getMessage());
    }

  }

}

$this->set_page_data([
  "sls" => !empty( $active_codes ) ? $active_codes : []
]);

?>
