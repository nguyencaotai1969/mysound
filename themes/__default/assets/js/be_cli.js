"use strict"

var $_active_query = false;
var $__timer        = false;

function be_cli( $args ){

	if( $args === undefined ) return false;

	var $action         = $args.action         === undefined ? false : $args.action;
	var $data           = $args.data           === undefined ? {} : $args.data;
	var $dataType       = $args.dataType       === undefined ? "json" : $args.dataType;
	var $callBack       = $args.callBack       === undefined ? false : $args.callBack;
	var $callBack_param = $args.callBack_param === undefined ? false : $args.callBack_param;
	var $domTarget      = $args.domTarget      === undefined ? false : $args.domTarget;
	var $background     = $args.background     === undefined ? true : $args.background;
	var $hasFile        = $args.hasFile        === true;
	var $url            = $args.url            === undefined ? window.location.href : $args.url;
	var $good_header    = $args.goodHeader     === undefined ? 202 : $args.goodHeader;
	var $timeout        = $args.timeout        === undefined ? $_out_time * 1000 : $args.timeout;

	if( !$background && $_active_query ) return false;
	if( !$background ) $_active_query = true;
	if( $action && $dataType == 'json' ) $data.action = $action;
	if( $action && $dataType == 'html' && !$hasFile && typeof $data === 'string' ? !$data.includes( "action=" + $action ) : false ) $data = $data + "&action=" + $action

	var __build = {

		url: $url,
		type: "POST",
		data: $data,
		timeout: $timeout,
		beforeSend: function(){

			if ( $__timer && $domTarget ){
				clearTimeout( $__timer );
				$__timer = false;
			}

			if( $domTarget ){

				if( $domTarget === ".watermark" ){
					$("body").find(".watermark").remove();
					$("body").append("<div class='watermark loading'><div class='text'>"+$_texts.loading+"</div></div>");
				}

				$("body").find($domTarget).removeClass("ok");
				$("body").find($domTarget).removeClass("notok");
				$("body").find($domTarget).removeClass("failed");
				$("body").find($domTarget).addClass("loading");
				$("body").find($domTarget).html( "<div class='text'>"+$_texts.wait+"</div>" );

			}

		},
		complete: function( responseData, status ){

			if( $domTarget )
				$("body").find($domTarget).removeClass("loading");

			if( !$background )
				$_active_query = false;

			var sta  = status == "success" && responseData.status == $good_header;
			var data = responseData.responseText ? responseData.responseText : "Failed";

			if ( sta ){
				$("body").find($domTarget).addClass("ok");
			}
			else {
				if ( data == "Invalid_request_3" && !$_user_id ){
					$("body").find($domTarget).remove();
					createNoAccessModal();
				}
				else {
					$("body").find($domTarget).addClass("notok");
				    $("body").addClass("failed");
				    setTimeout( function(){
					    $("body").removeClass("failed");
				    }, 1000 );
				}
			}

			if ( $domTarget )
				$("body").find($domTarget).html( $domTarget===".watermark"?"<div class='text'>"+data+"</div>":data );

			if ( $domTarget === ".watermark" ){

				if ( $__timer ){
					clearTimeout( $__timer );
					$__timer = false;
				}

				$__timer = setTimeout( function(){
					$("body").find($domTarget).remove();
				}, 10000 );

			}
			if ( $callBack ){
				if ( $callBack === "refresh" ){
					if ( sta )
					pager.page_reload( false );
				} else if ( typeof( $callBack ) == "string" ){
					window[ $callBack ]( sta, data, $callBack_param );
				} else {
					$callBack( sta, data, $callBack_param );
				}
			}

		},
		error: function( responseData, status, err ){

			console.log( err, $timeout, $args );

			if( $domTarget ){
				$("body").find($domTarget).removeClass("loading");
				$("body").find($domTarget).addClass("failed");
			}

			if( !$background )
				$_active_query = false;

			var sta  = false;
			var data = responseData.responseText ? responseData.responseText : "Failed";

			if ( $domTarget )
				$("body").find($domTarget).html( data );

			if ( $domTarget === ".watermark" ){

				$("body").find(".watermark").addClass("failed");

				if ( $__timer ){
					clearTimeout( $__timer );
					$__timer = false;
				}

				$__timer = setTimeout( function(){
					$("body").find($domTarget).remove();
				}, 10000 );

			}

			$("body").find($domTarget).addClass("notok");
			$("body").addClass("failed");
			setTimeout( function(){
				$("body").removeClass("failed");
			}, 1000 );

			if ( $callBack ){
				if ( $callBack === "refresh" ){
				} else if ( typeof( $callBack ) == "string" ){
					window[ $callBack ]( sta, "fatal_error", $callBack_param );
				} else {
					$callBack( sta, data, $callBack_param );
				}
			}

		}

	};

	if ( $hasFile ){
		__build['contentType'] = false;
		__build['processData'] = false;
	} else if ( $dataType == 'json' ){
	} else {
		__build['dataType'] = 'html';
	}

	var __ajax = $.ajax(__build);

}
function be_cli_forms_hook(){

	if ( !$("form.be_cli_form").length ) return;

	$("form.be_cli_form").each(function(i,o){
		if ( $(o).hasClass("hooked") ){
			$(o).off("submit");
		} else {
			$(o).addClass("hooked");
		}
	});

	$("form.be_cli_form").on("submit",function(e){

		e.preventDefault();

		var $__hasFile  = $(this).attr("data-hasFile") ? true : false;
		var $__action   = $(this).attr("data-action");
		var $__target   = $(this).attr("data-target");
		var $__callback = $(this).attr("data-callback");
		var $__callback_param = $(this).attr("data-callback-param");
		var $__formData = null;

		if ( $__hasFile ){
			$__formData = new FormData( this );
		    $__formData.append( "action", $__action );
		} else {
			$__formData = $(this).serialize() + "&action=" + $__action;
		}

		be_cli({
			data: $__formData,
			dataType: 'html',
			callBack: $__callback,
			callBack_param: $__callback_param,
			domTarget: $__target,
			hasFile: $__hasFile
		});

	})

}

be_cli_forms_hook();
$(document).on("click",".watermark",function(){
	$(document).find(".watermark").remove();
});
