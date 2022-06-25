<?php

if ( !defined( "root" ) ) die;

$modalData = array(
	"class"  => "add_fund bank_transfer type2",
	"title"  => "Bank Transfer",
	"inputs" => [
	    [
	        "name"  => "amount",
	        "type"  => "hidden",
	        "value" => $this->ps["amount"]
        ]
    ],
	"content" => "Transfer {$this->ps["amount"]}{$loader->admin->get_setting("currency")} to account below then upload the receipt<div class=\"info\">".(strip_tags(str_replace(PHP_EOL,"<BR>",$loader->admin->get_setting("bank_data")),"<br>"))."</div><input name='action' value='user_bank_transfer_submit' type='hidden'><input name='receipt' id='receipt_file' type='file'><a id='file_placeholder' class='file_placeholder' data-target='#receipt_file'>Select & Upload receipt</a>",
);

$this->set_response( json_encode( $modalData ), false, false, true );

?>