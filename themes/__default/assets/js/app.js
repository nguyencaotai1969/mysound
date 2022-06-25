"use strict"

var pre_pos_top = null;
var pos_active = false;
var button_opened = null;
var $upload_started = false;
var $__dropzone = null;

if ( typeof Dropzone !== 'undefined' ) Dropzone.autoDiscover = false;
$(document).on("mouseover",".wsnw",function(e){

	var _ww = $(this).outerWidth();
	var _ew = $(this).find(".wsnwe").outerWidth();
	var _iw = _ew - _ww;
	if ( _ww > _ew || $(this).hasClass("scrolling") ) return;
	$(this).addClass("scrolling");
	$(this).find(".wsnwe").animate({
		right: $_dir == "rtl" ? "-"+_iw+"px" : 0,
		left: $_dir == "ltr" ? "-"+_iw+"px" : 0
	},(_iw*10>300?_iw*10:300));

});
$(document).on("mouseleave",".wsnw",function(e){

	$(document).find(".wsnw.scrolling").find(".wsnwe").stop(true).animate({
		left: $_dir == "ltr" ? 0 : "auto",
		right: $_dir == "rtl" ? 0 : "auto",
	},500);
	$(document).find(".wsnw.scrolling").removeClass("scrolling");

});
$(document).ready(function(){
   starter();
});
$(document).on("change","#receipt_file",function(){
	be_cli({
		data: new FormData( $(document).find(".modal").find("form")[0] ),
		dataType: 'html',
		hasFile: true,
		domTarget: ".watermark",
		callBack: function( sta, data ){
			if (sta) closeModal();
		    pager.page_load( $_home + "user_setting?n=transaction_history" );
		}
	});
});
$(document).on("pageInlined_m",function(){
	$(".widget_slider").each(function( index, item ){
		var slider = $(item).find(".slider")[0];
		if ( slider.scrollWidth && slider.offsetWidth ? slider.scrollWidth - slider.offsetWidth < 50 : true )
		$(item).find(".arrows").remove();
	});
	check_wsnw();
});
$(document).on("submit","#post_comment",function(e){

	be_cli({
		action: 'user_act_post_comment',
		data: {
			comment: $(document).find("#comment").val(),
			hash: $(this).attr("data-track-id"),
			m_hash: muse.song_data ? muse.song_data.hash : "",
			m_seeker: Math.round( muse.seek() ),
			PID: $(document).find("#PID").val(),
		},
		domTarget: '.watermark',
		callBack: function( sta, data ){
			if ( sta ) pager.page_reload( false );
			else alert( data );
		}
	})

	e.preventDefault();
	return false;

});
$(document).on("submit",".search_form_i",function(e){

	pager.page_load( $_home + 'search?qn=' + $(document).find('#qn').val() );
	$("body").removeClass('naved');
	e.preventDefault();
	return false;

});
$(document).on("change",".container.edit .file_handler",function(e){
	$(this).parent('form').submit()
});
$("#scroller").on("scroll",function (event) {

	$("body").find(".button_more.active").removeClass("active");

	 if ( pos_active === true ) return;
	 pos_active = true;

	 setTimeout( function(){
		 style_navbar();
	     pos_active = false;
	 }, 200 )

});

$(document).on("click",function(e){

	if( !$(e.target).parents(".button_more").length && ( !$(e.target).attr("class") ? true : !$(e.target).attr("class").includes("button_more") ) ){
		$("body").find(".button_more").removeClass("active");
	}

	if (
		$(e.target).parents(".button_more").length &&
		!$(e.target).parents(".dropdown-menu").length ?
		  $($(e.target).parents(".button_more")[0]).attr("class").includes("active") &&
		  Date.now() - button_opened > 50
		  : false
	){
		$("body").find(".button_more").removeClass("active");
	}

	if (
		( $(e.target).attr("class") ? $(e.target).attr("class").includes("button_more") : false ) &&
		!$(e.target).parents(".dropdown-menu").length ?
		  $($(e.target)).attr("class").includes("active") &&
		  Date.now() - button_opened > 50
		  : false
	){
		$("body").find(".button_more").removeClass("active");
	}

	if ( $("body").hasClass("search_naved") ? $(e.target).attr("id") != "qn" && !$(e.target).hasClass("search_handler_btn") && !$(e.target).parents(".search_handler_btn").length : false ){
		$("body").removeClass("search_naved");
	}

});
$(document).on("click",".button_more",function(e){

	if (
		$(e.target).parents(".button_more").length &&
		!$(e.target).parents(".dropdown-menu").length ?
		  $($(e.target).parents(".button_more")[0]).attr("class").includes("active")
		  : false
	){
		return;
	}

	if (
		( $(e.target).attr("class") ? $(e.target).attr("class").includes("button_more") : false ) &&
		!$(e.target).parents(".dropdown-menu").length ?
		  $($(e.target)).attr("class").includes("active")
		  : false
	){
		return;
	}

	var special_button_type = $(e.target).parents(".button_more").attr("data-type");
	var special_button_hash = $(e.target).parents(".button_more").attr("data-hash");

  if ( special_button_type && special_button_hash && !$(this).find("ul").length ){

		$(this).append('<ul class="dropdown-menu all_buttons buttons buttons_'+ special_button_hash +' "><li class="loading">'+ $_texts.loading +'</li></ul>');

		be_cli({
			action: 'special_buttons',
			data: {
				type: special_button_type,
				hash: special_button_hash
			},
			callBack_param: $(this),
			callBack: function( sta, data, target ){
				if ( !sta ){
					target.find(".loading").text( data );
				}
				else {
					target.find("ul").html( data );
					position_menu( target );
				}
			}
		});

	}

	$("body").find(".button_more").removeClass("active");
	$(this).addClass("active");

	position_menu( this, $(this).attr("data-target") );

	button_opened = Date.now();

});
function position_menu( _m, target ){

	target = target ? target : "ul";

	var ww = $(window).width();
	var wh = $(window).height();
	var m  = $(_m).find(target);
	var mw = m.width();
	var mh = m.height();
	var ml = 0;
	var mt = 0;
	var bl = $(_m).offset().left;
	var bt = $(_m).offset().top;
	var bh = $(_m).height();
	var bw = $(_m).width();

	ml = bl - ( ( mw - bw ) / 2 );
	mt = bt + bh + 20;

	if ( ml + mw > ww - 20 )
		ml = ww - ( mw + 20 );

	if ( mt + mh > wh - 80 )
		mt = bt - ( bh + mh );

	if ( mt < 0 )
		mt = 60;

	m.css( "right", "auto" );
	m.css( "bottom", "auto" );
	m.css( "left", ml + "px" );
	m.css( "top", mt + "px" );

	if ( mt + mh > ( wh + 70 ) - 20 ){
		m.css( "overflow", "auto" );
		m.css( "height", ( ( ( wh - 70 ) - mt ) - 20 ) + "px" )
	}

}
$(document).on("click",".naved #nav .menu_wrapper",function(e){
	$("body").removeClass("naved")
});
$(document).on("click",".widget_slider .arrows .arrow",function(e){

	if ( !$(this).parents(".widget_slider")[0] ) return;

	var direction = $(this).attr("class").includes("next") ? "right" : "left";
	var slider_parent = $( $(this).parents(".widget_slider")[0] );
	var slider = slider_parent.find(".slider")[0];
	var total_width = slider.scrollWidth;
	var visible_width = slider.offsetWidth;
	var item_width = $(slider).find(".slider_item").outerWidth(true);
	var scroll_position = slider.scrollLeft;
	var visible_items = Math.floor( visible_width / item_width ) > 1 ? Math.floor( visible_width / item_width ) : 1;
	var to_right = ( $_dir == "ltr" ? +1 : -1 ) * ( direction == "right" ? +1 : -1 ) * ( visible_items * item_width );
	var new_scroll_position = scroll_position + to_right;
	var max_scroll_position = total_width - visible_width;
	var final_scroll_position = 9999;
	var possible_scroll_poisitions = [];

	for( var x=0; x<=max_scroll_position; x=x+item_width ){
		possible_scroll_poisitions.push( x );
	} possible_scroll_poisitions.push( max_scroll_position );
	possible_scroll_poisitions.forEach(function( x ){
		var __c = Math.abs( new_scroll_position - x );
		var __b = Math.abs( final_scroll_position - new_scroll_position );
		if ( __b > __c ) final_scroll_position = x;
	});

  if ( visible_width + scroll_position == total_width && to_right > 0 ) final_scroll_position = 0;
	if ( scroll_position == 0 && to_right < 0 ) final_scroll_position = max_scroll_position;

	slider_parent.find(".arrow.prev").css("opacity",1);
    $(slider).stop().animate({scrollLeft: final_scroll_position+"px"}, 800);

});
$(document).on("click","#add_funds",function(){
	add_fund_modal();
});
$(document).on("click",".button.menu_handle",function(){
	if( $('body').hasClass('naved') )
		close_sidebar();
	else
		open_sidebar();
});
$(document).on("click",".search_handle",function(){

	if ( $(window).width() > 540 ){

		if( $('.button.search').hasClass('opened') )
	        $('body').find('.button.search form').submit()
		else
		    $('.button.search').addClass('opened');
		return;

	}

	if ( $('body').hasClass('search_open') ){
		$('body').find('.button.search form').submit()
	} else {
		open_search()
	}

});
$(document).on("click",".languages_handle li",function(){

	var lang_code = $(this).attr("data-lang-code");
	window.location = $_home + "?lang=" + lang_code

});
$(document).on("click",".cpm_handler",function(){
	create_playlist_modal();
});
$(document).on("click",".file_placeholder",function(){
	var dom_target = $(this).attr("data-target");
	$(document).find( dom_target ).click()
});
$(document).on("click",".upload_cover_handle",function(){
	$(this).parent('.cover_wrapper').find('input[name=file]').click();
});
$(document).on("click",".upload_finalize_handle",function(){
	finalize_edit()
});
$(document).on("click",".follow_user_handle",function(){
	var target = $(this).attr("data-target")
	follow_target( target );
});
$(document).on("click",".end_session_handle",function(){
	var hook = $(this).attr("data-hook")
	end_session( hook );
});
$(document).on("click",".delete_comment_handle",function(){
	var ID = $(this).attr("data-ID")
	delete_comment( ID );
});
$(document).on("click",".reply_comment_handle",function(){
	var ID = $(this).attr("data-ID")
	var target = $(this).attr("data-target")
	$(document).find("#PID").val(ID);
	$(document).find("#comment").val("@"+target+" ");
	$("#scroller").animate({
		scrollTop: $(".add_comment").offset().top + $("#scroller").scrollTop() - $(".add_comment").height() - 50
  }, 700);
	$(document).find("#comment").focus();
});
$(document).on("click",".like_comment_handle",function(){
	var ID = $(this).attr("data-ID")
	like_comment( ID );
});
$(document).on("click",".remove_playlist_handle",function(){
	var hook = $(this).attr("data-hook")
	remove_playlist_modal( hook );
});

$(document).on("click",".caem_handle",function(){
	var hook = $(this).attr("data-hook");
	createAlbumEditModal( hook );
});
$(document).on("click",".ctem_handle",function(){
	var hook = $(this).attr("data-hook")
	createTrackEditModal( hook );
});
$(document).on("click",".share_handle",function(){

	var $title = $(this).attr("data-title");
	var $image = $(this).attr("data-image");
	var $url   = $(this).attr("data-url");
	var $name  = $(this).attr("data-name");
	var $type  = $(this).attr("data-type");

	createShareModal({
		title: $title,
		type: $type,
		image: $image,
		url: $url,
		name: $name
	});

});
$(document).on("click",".report_handle",function(){

	var $hash = $(this).attr("data-hash");
	createModal({

		title: 'Report Track',
		class: 'report type2',
		inputs: [
			{
				type: 'textarea',
				name: 'reason',
				label: 'Reason',
			},
			{
				type: 'hidden',
				name: 'hash',
				value: $hash,
			},
		],
		buttons: [
			[ 'btn-primary', $_texts.confirm_action, '$(".modal form").submit()' ],
		],
		action : 'user_act_report_track',
		target : '.watermark',
		callback: 'refresh'

	});

});
$(document).on("click",".rti_handle",function(){

	var $s_type = $(this).attr("data-source-type");
	var $t_type = $(this).attr("data-target-type");
	var $t_hook = $(this).attr("data-target-hook");

	redirect_to_item( $s_type, $t_type, $t_hook );

});
$(document).on("click","._c_w.bank",function(){
	add_fund_bank()
});
$(document).on("click","._c_w.online_gateway",function(){
	var $name = $(this).attr( "data-name" );
	add_fund_online_gateway( $name );
});
$(document).on("click",".m_rp_a",function(){
	remove_playlist( $(this).attr("data-hook") );
});
$(document).on("click",".m_cp_a",function(){
	create_playlist();
});
$(document).on("click",".tul_handle",function(){
	toggleUploadList();
});
$(document).on("click",".close_modal_handle",function(){
	closeModal();
});
$(document).on("click",".add_fund_modal_handle",function(){
	add_fund_modal();
});
$(document).on("click",".modal .groups button",function(){

	var GID = $(this).attr("data-GID");
	$(document).find(".modal").find(".input").hide();
	$(document).find(".modal").find(".groups .active").removeClass("active");
	$(this).addClass("active");
	$(document).find(".modal").find(".input.g"+GID+"").show();
	$(document).find(".modal").find(".input.g"+GID+" .form-control").trigger("change")
	$(document).trigger( "group_change", [ GID ] );

});
$(document).on("click",".pp_handle",function(){
	proceedPurchase({
		type: $(this).attr("data-type"),
		hook: $(this).attr("data-hook")
	})
});
$(document).on("click",".purchase_handle",function(){

	var $title = $(this).attr("data-title");
	var $tip = $(this).attr("data-tip");
	var $fund = $(this).attr("data-fund");
	var $item_type = $(this).attr("data-item-type");
	var $item_title = $(this).attr("data-item-title");
	var $item_hook = $(this).attr("data-item-hook") ? $(this).attr("data-item-hook") : "";
	var $item_price = $(this).attr("data-item-price");

	createPurchaseModal({
		title: $title,
		tip: $tip,
		fund: $fund,
		item_type: $item_type,
		item_hook: $item_hook,
		item_name: $item_title,
		item_price: $item_price
	});

});
$(document).on("click",".artist_subsribe_handle",function(){

	var code = $(this).attr("data-code");
	be_cli({
		action: 'user_act_sub_artist',
		domTarget: '.watermark',
		data: {
			code: code
		},
		callBack: function ( sta, data ){
			pager.page_reload();
		}
	});

});
$(document).on("click",".playlist_subscribe_handle",function(){

	var hook = $(this).attr("data-hook");
	be_cli({
		action: 'user_act_sub_playlist',
		domTarget: '.watermark',
		data: {
			hook: hook
		},
		callBack: function ( sta, data ){
			pager.page_reload();
		}
	});

});
$(document).on("click",".edit_playlist_handle",function(){
	var hook = $(this).attr("data-hook")
	var name = $(this).attr("data-name");
	var collabs = $(this).attr("data-collabs");
	createModal({

		title: $_texts.edit_playlist,
		tip: name,
		class: 'edit album type2',
		inputs: [

			{
				type: 'text',
				name: 'name',
				value: name,
				label: $_texts.name,
				group: 'a'
			},
			{
				type: 'hidden',
				name: 'hook',
				value: hook,
				group: 'a'
			},
			{
				type: 'file',
				name: 'cover',
				label: $_texts.cover_image,
				group: 'a'
			},
			{
				type: 'textarea',
				name: 'collabs',
				label: $_texts.collabs,
				group: 'b',
				value: collabs,
				tip: $_texts.collab_tip
			},

		],
		groups: {
			a: $_texts.detail,
			b: $_texts.collabs
		},
		buttons: [
			[ 'btn-primary', $_texts.save, '$(".modal form").submit()' ],
		],
		action : 'user_act_edit_playlist',
		target : '.watermark',
		callback: 'refresh'
	});
});
$(document).on("click",".campaign_handler",function(){

	$.getScript( $_home + "themes/__default/assets/third/chosen_v1.8.7/chosen.jquery.min.js" ).done(function( script, textStatus ) {

		$('<link/>', {
			rel: 'stylesheet',
			type: 'text/css',
			href: $_home + 'themes/__default/assets/third/chosen_v1.8.7/chosen.min.css'
		}).appendTo('head');

		createModal({

			title: $_texts.new_ad,
			class: 'new_campaign type2',
			inputs: [

				{
					type: 'text',
					name: 'name',
					label: 'Name',
					tip : $_texts.ad_name,
					group: 'a'
				},
				{
					type: 'text',
					name: 'fund',
					label: 'Total Fund',
					tip : $_texts.ad_tip2,
					group: 'a'
				},
				{
					type: 'text',
					name: 'limit',
					label: 'Limit',
					tip: $_texts.ad_tip3,
					group: 'a'
				},

				{
					type: 'text',
					name: 'url',
					label: 'Url',
					tip: $_texts.ad_tip4,
					group: 'pl_b'
				},
				{
					type: 'select',
					name: 'ad_type',
					label: 'Ad Type',
					tip: $_texts.ad_tip5,
					group: 'pl_b',
					values: [
						[ 'banner_v', $_texts.ad_tip14 ],
						[ 'banner_c', $_texts.ad_tip15 ],
						[ 'audio_v', $_texts.ad_tip16 ]
					],
				},
				{
					type: 'select_multi',
					values: $placements,
					name: 'placements_b',
					label: $_texts.ad_tip6,
					group: 'pl_b',
					tip: $_texts.ad_tip8,
				},
				{
					type: 'hidden',
					name: 'placements',
					group: 'pl_b',
				},
				{
					type: 'file',
					name: 'audio',
					label: $_texts.ad_tip7,
					group: 'pl_b',
					tip: $_texts.ad_tip9,
				},
				{
					type: 'file',
					name: 'audio_banner',
					label: $_texts.ad_tip10,
					group: 'pl_b',
					tip: $_texts.ad_tip11,
				},
				{
					type: 'file',
					name: 'banner',
					label: $_texts.ad_tip12,
					group: 'b',
					tip: $_texts.ad_tip13,
				},


			],
			groups: {
				a: $_texts.setting,
				pl_b: $_texts.content,
			},
			buttons: [
				[ 'btn-primary', $_texts.save, '$(".modal form").submit()' ],
			],
			action : 'user_ads_create',
			target : '.watermark',
			callback: 'refresh'
		});

		$(document).find("#ad_type").trigger("change");

	});

});
$(document).on("change","#ad_type",function(){

	if( $(document).find(".groups button[data-gid=a]").hasClass("active") )
	return;

	var val = $(this).val();
	if ( val != "audio_v" ){
		$(document).find(".nbanner").show();
		$(document).find(".nplacements_b").show();
		$(document).find(".naudio_banner").hide();
		$(document).find(".naudio").hide();
	}
	else {
		$(document).find(".nbanner").hide();
		$(document).find(".nplacements_b").hide();
		$(document).find(".naudio_banner").show();
		$(document).find(".naudio").show();
	}

});
$(document).on("group_change",function( event, GID ){

	if ( GID == "pl_b" ){
		$(document).find("#placements_b").chosen({
			disable_search_threshold: 1,
			max_selected_options: 10
		}).change(function(){

			var placements = getModal(true)["placements_b"];
			$(document).find("#placements").val(placements);
			console.log( placements );

		});
	}

});
$(document).on("click",".playlist_like_handle",function(){

	var hook = $(this).attr("data-hook");
	be_cli({
		action: 'user_act_like_playlist',
		domTarget: '.watermark',
		data: {
			hook: hook
		},
		callBack: function ( sta, data ){
			pager.page_reload();
		}
	});

});
$(document).on("click",".album_like_handle",function(){

	var hook = $(this).attr("data-hook");
	be_cli({
		action: 'user_act_like_album',
		domTarget: '.watermark',
		data: {
			hook: hook
		},
		callBack: function ( sta, data ){
			pager.page_reload();
		}
	});

});
$(document).on("click",".nots_btn:not(.active)",function(e){

  $(this).find("ul").html("<li class='loading'>"+$_texts.loading+"</li>");
	get_nots( true, 1, $(this).find("ul") );

});
$(document).on("click",".pl_wrapper",function(e){

	var ad_id = $(this).attr("data-ad-id");
	be_cli({
		action: "get_ad_link",
		data: {
			ad_id: ad_id
		},
		callBack: function( sta, data ){
			if ( sta ) window.open( data, '_blank' );
		}
	});

});
$(document).on("click",".apl_wrapper",function(e){

	var ad_id = $(this).attr("data-ad-id");
	be_cli({
		action: "get_ad_link",
		data: {
			ad_id: ad_id
		},
		callBack: function( sta, data ){
			if ( sta ) window.location.replace( data );
		}
	});

});
$(document).on("click",".save_feed_handler",function(){
	submitFeedSetting()
});

function get_nots( $full, $page, $target ){

	$full = $full === true;
	$page = $page ? $page : 1;
	be_cli({
		action: 'user_get_nots',
		data: {
			page: $page,
			full: $full,
			hash: $_play_hash
		},
		callBack_param: $target,
		callBack: function( sta, data, $target ){
			if ( $full ){
				$(".buttons.nots").removeClass("new");
				$(".buttons.nots").find(".count").remove()
				$target.html( data );
				pager.bind_links();
			}
			else {
				if ( data > 0 ){
					$(".buttons.nots").find(".count").remove();
					$(".buttons.nots").append("<div class='count'>"+data+"</div>");
					$(".buttons.nots").addClass("new");
					if ( $(".nots_btn").hasClass("active") ){
						get_nots( true, 1, $(".nots_ul") );
					}
				}
				setTimeout(function(){
					get_nots( false );
				},12*1000);
			}
		}
	});

}

function decode_htmlspecialchars( text ){

    var map = {
        '&amp;': '&',
        '&#038;': "&",
        '&#38;': "&",
        '&lt;': '<',
        '&gt;': '>',
        '&quot;': '"',
        '&#039;': "'",
        '&#39;': "'",
        '&#8217;': "’",
        '&#8216;': "‘",
        '&#8211;': "–",
        '&#8212;': "—",
        '&#8230;': "…",
        '&#8221;': '”'
    };

  return text.replace(/\&[\w\d\#]{2,5}\;/g, function(m) {
		return map[m];
	});

}
function starter(){

	if ( typeof pager === 'undefined' )
		return;

	style_navbar();
	pager.set_menu();
	pager.page_title = $(document).find("title").text()
	if (window.history && window.history.pushState) {
		$(window).on('popstate', function() {
			pager.page_load( window.location.href, false );
		});
	}
	pager.load_start();
	pager.set_type();
	pager.page_load_images();
	be_cli_forms_hook();
	pager.bind();

	if ( $_user_id && $_not_enabled )
	get_nots( false )

}
function style_navbar(){

    var pos_top = $("#scroller").scrollTop();
    if ( pos_top > $("#nav").outerHeight()/3 ){
        $("#nav").removeClass("attached").addClass("floating")
    }
    else {
        $("#nav").addClass("attached").removeClass("floating")
    }
    if ( pre_pos_top ? pre_pos_top > pos_top : true ){
        $("#nav").removeClass("goingBot").addClass("goingTop");
    } else {
        $("#nav").addClass("goingBot").removeClass("goingTop");
    }
    pre_pos_top = pos_top;

}
function check_wsnw(){

	$(".wsnw").each(function( index, item ){

		var $item = $(item);
		var item_width  = $item.outerWidth();
		var child_width = $item.find( ".wsnwe" ).outerWidth();
		if ( child_width > item_width ){
			$item.addClass("has_more");
		}
		else if ( $item.hasClass("has_more") ){
			$item.removeClass("has_more");
		}

	});

}
function add_fund_modal(){

	closeModal();

	var $count = 0;
	var $content = "";
	if ( $_config.pg_pp ){
		$count++;
		$content = $content + '<div class="_c_w paypal online_gateway" data-name="paypal">'+$_texts.paypal+'</div>';
	}

	if ( $_config.pg_st ){
		$count++;
		$content = $content + '<div class="_c_w stripe online_gateway" data-name="stripe">'+$_texts.stripe+'</div>';
	}

	if ( $_config.pg_kk ){
		$count++;
		$content = $content + '<div class="_c_w other online_gateway" data-name="kkiapay">KKiaPay</div>';
	}

	if ( $_config.pg_fw ){
		$count++;
		$content = $content + '<div class="_c_w other online_gateway" data-name="flutterwave">Flutterwave</div>';
	}

	if ( $_config.pg_rp ){
		$count++;
		$content = $content + '<div class="_c_w other online_gateway" data-name="razorpay">Razorpay</div>';
	}

	if ( $_config.pg_cp ){
		$count++;
		$content = $content + '<div class="_c_w other online_gateway" data-name="coinpayments">Coinpayments</div>';
	}

	if ( $_config.pg_ps ){
		$count++;
		$content = $content + '<div class="_c_w other online_gateway" data-name="paystack">Paystack</div>';
	}

	if ( $_config.pg_op ){
		$count++;
		$content = $content + '<div class="_c_w bank">'+$_texts.bank_tf+'</div>';
	}

	if ( $count == 0 )
	$content = $_texts.no_pay_method;
	else
	$content = '<label class="_c_ws_l">'+$_texts.pay_method+'</label><div class="_c_ws c_'+$count+'">' + $content + '</div>'

	createModal({
		class: "type2 add_fund add_fund_main",
		title: $_texts.add_fund_title,
		inputs: [
			{
				name: "amount",
				label: $_texts.dep_amount,
				placeholder: $_texts.dep_amount_tip,
				type: "text"
			}
		],
		content: $content,
	});

}
function add_fund_online_gateway( $name ){

	var $amount = getModal(true)["amount"];

	be_cli({
		action: "user_proceed_payment",
		data: {
			amount: $amount,
			name: $name
		},
		domTarget: ".watermark",
		callBack_param: $name,
		callBack: function( sta, data, $name ){
			if ( sta ){
				$(document).find(".watermark").text( $_texts.wait )
				if ( $name == "stripe" )
				return stripe( data );
				if ( $name == "kkiapay" )
				return kkiapay( data, $amount );
				if ( $name == "flutterwave" )
				return flutterwave( data, $amount );
				if ( $name == "razorpay" )
				return razorpay( data, $amount );
				window.location = data;
			}
		}
	});

}
function stripe( $sessID ){

	$.getScript( "https://js.stripe.com/v3/" ).done(function( script, textStatus ) {

		var stripe = Stripe( $_config.pg_st_key );
		stripe
		.redirectToCheckout({ sessionId: $sessID })
		.then(function(result){
			console.log( result );
		})
		.catch(function( error ){
			console.log( error );
		});

	});

}
function kkiapay( $order_no, $amount ){

	$.getScript( "https://cdn.kkiapay.me/k.js" ).done(function( script, textStatus ) {
		openKkiapayWidget({
			amount: $amount,
			callback: $_home + "/user_pay_result?og=kkiapay&on=" + $order_no,
      key: $_config.pg_kk_key,
			sandbox: $_config.pg_kk_mode
		})
	});

}
function flutterwave( $order_no, $amount ){

	$.getScript( "https://checkout.flutterwave.com/v3.js" ).done(function( script, textStatus ) {
		FlutterwaveCheckout({
 		 public_key: $_config.pg_fw_key,
 		 amount: $amount,
 		 currency: $_texts.currency_code,
		 tx_ref: $order_no,
 		 redirect_url: $_home + "/user_pay_result?og=flutterwave&on=" + $order_no,
		 customer: {
        email: $_email,
        name: $_name,
      },
 	 });
	});

}
function razorpay( $orderData, $amount ){

	$orderData = JSON.parse( $orderData );

	$.getScript( "https://checkout.razorpay.com/v1/checkout.js" ).done(function( script, textStatus ) {

		var options = {
			"key": $_config.pg_rp_key,
			"amount": $amount * 100,
			"currency": $_texts.currency_code,
			"order_id": $orderData["remote"],
			"callback_url": $_home + "/user_pay_result?og=razorpay&on=" + $orderData["local"] + "&rn=" + $orderData["remote"],
		};

		var razorpayClient = new Razorpay(options);
		razorpayClient.open();

	});

}
function add_fund_bank(){

	be_cli({
		action: "user_bank_transfer",
		data: {
			amount: getModal(true)["amount"]
		},
		domTarget: ".watermark",
		callBack: function (sta, data ){

			if ( !sta ) return;

			closeModal();
			$(document).find(".watermark").remove();
			createModal( JSON.parse( data ) );
			be_cli_forms_hook();

		}
	});

}
function sortable_table( $args ){

	var $action = $args.action ? $args.action : "user_act_sort_playlist";
	var $table  = $args.table ? $args.table : ".table_wrapper table tbody";
	var $handle = $args.handle ? $args.handle : ".mdi-sort";
	var $item = $args.item ? $args.item : ".table_wrapper table tbody tr";
	var $hook_type = $args.hook_type ? $args.hook_type : "playlist_hash";
	var $hook = $args.hook;

	$( $table ).sortable({
		handle: $handle,
		update: function(){

			var hashes = [];
			$($item).each(function(){
				var classes = $(this).attr("class").split(" ");
				$.each( classes, function ( k, v ){
					if ( v.substr( 0, 10 ) == "track_dom_" )
					hashes.push( v.substr( 10 ) );
				} );
			});

			var data = {
				hashes: hashes.join(",")
			};
			data[ $hook_type ] = $hook;
			be_cli({
				action: $action,
				data: data,
				domTarget: '.watermark',
				callBack: function ( sta, data ){
					if ( sta ) pager.page_reload( false );
				}
			});

		}
	});

}
function submitFeedSetting(){

  var $actions = {
    feed: [],
    not: [],
    email: [],
  };
  $(".feed_setting input[type=checkbox]:checked").each(function(e){
    var __splits = $(this).attr("name").split("_");
    var __type = __splits[0];
    var __id   = __splits[1];
    $actions[__type].push( __id );
  });

  be_cli({
    action: 'user_setting_feed_setting',
    data: {
      feed: $actions["feed"].join(","),
      not: $actions["not"].join(","),
      email: $actions["email"].join(","),
    },
    domTarget: '.watermark',
    callBack: 'check_user_setting_response',
    callBack_param: 'feed_setting'
  });

}

function create_playlist_modal(){

	createModal({
		class: "create_playlist",
		content_before: '<div class="icon"><span class="mdi mdi-playlist-plus"></span></div><div class="title">'+$_texts.create_new_playlist+'</div><div class="text">'+$_texts.create_pl_name_tip+'</div><input type="text" class="form-control" name="name" placeholder=""><div class="pl_res"></div><div class="buttons"><a class="m_cp_a btn btn-secondary btn-sm">'+$_texts.create+'</a></div>',
	})

}
function create_playlist(){

	be_cli({
		action: "user_act_create_playlist",
		data: {
			name: getModal(true)['name']
		},
		domTarget: ".pl_res",
		callBack: function( sta, data ){
			if ( sta ){
				pager.page_load( $_home + "user/" + $_user_name + "/playlists" );
				closeModal();
				return false;
			}
		}
	});

}
function remove_playlist_modal( $ID ){

	createModal({
		class: "playlist small",
		content_before: '<div class="icon"><span class="mdi mdi-minus-circle-outline"></span></div><div class="title">'+$_texts.remove_playlist+'</div><div class="text">'+$_texts.confirm_action+'</div><div class="pl_res"></div><div class="buttons"><a data-hook="'+$ID+'" class="m_rp_a btn btn-secondary btn-sm">'+$_texts.remove+'</a></div>',
	})

}
function remove_playlist( $ID ){

	be_cli({
		action: "user_act_remove_playlist",
		data: {
			hash: $ID
		},
		domTarget: ".pl_res",
		callBack: function( sta, data ){
			if ( sta ){
				$(document).find(".pl_res").text( $_texts.removed );
				pager.page_reload();
				closeModal();
				return false;
			}
		}
	});

}
function remove_track_from_playlist( $track_ID ){

	be_cli({
		action: "user_act_lessen_playlist",
		data: {
			track_hash: $track_ID,
			playlist_hash: $(document).find(".playlist").attr("data-id")
		},
		domTarget: ".watermark",
		callBack: function( sta, data ){
			if( sta ){
				pager.page_reload( false )
			}
		}
	});

}

function follow_target( $username ){

	be_cli({
		action: 'user_act_follow',
		domTarget: '.watermark',
		data: {
			target: $username
		},
		callBack: function( sta, data ){
			if ( sta ) pager.page_reload();
		}
	})

}
function redirect_to_item( $source, $type, $hook ){

	pager.load_start();

	if ( $source == "db" )
	pager.page_load( $hook );

	if ( $source == "spotify" ){

		be_cli({
			action: "spotify_create",
			data: {
				qn: "",
				type: $type,
				hook: $hook
			},
			callBack: function ( sta, data ){

				if ( !sta ){
					pager.load_finish();
					alert( data );
					return false;
				}

				pager.page_load( data );

			}
		});

	}

}
function scroll_to( element ){

	$([document.documentElement, document.body]).animate({
		scrollTop: $(element).offset().top - 70
	}, 800);

}
function end_session( $SID ){

	be_cli({
		action: 'user_setting_end_session',
		data: {
			ID: $SID
		},
		domTarget: '.watermark',
		callBack: function(){
			setTimeout( function(){
				pager.page_reload()
			}, 500 );
		}
	});

}
function toggleUploadList(){
	if ( $("#uploading").hasClass("opened") ){
		$("#uploading").removeClass("opened");
	} else {
		$("#uploading").addClass("opened");
	}
}
function delete_comment( comment_id ){

	be_cli({
		action: 'user_act_delete_comment',
		data: {
			ID: comment_id
		},
		callBack: function( sta, data ){
			if ( sta ) pager.page_reload( false );
		}
	});

}
function like_comment( comment_id ){

	be_cli({
		action: 'user_act_like_comment',
		domTarget: ".watermark",
		data: {
			ID: comment_id
		},
		callBack_param: comment_id,
		callBack: function( sta, data, comment_id ){
		  if ( sta ){
				pager.page_reload( false );
			}
		}
	});

}
function __up( dz, file, sdz ){

	var total_qued = 0;
	var total_uped = 0;
	var total_size = 0;
	var total_done = 0;

	for ( var i=0; i<dz.files.length; i++ ){

		if ( dz.files[i].upload.progress == 100 && dz.files[i].status == 'uploading' )
		return;

		total_size += dz.files[i].size;
		total_done += ( dz.files[i].status == "error" ? 0 : dz.files[i].upload.progress ) * dz.files[i].size / 100;
		total_qued++;
		if ( ( dz.files[i].status == "error" ? 0 : dz.files[i].upload.progress ) == 100 ) total_uped++;

	}

	var __text = total_uped+"/"+total_qued+" "+$_texts.upload_progress+"<span class='tul_handle'></span>";
	if ( $("#uploader .prg .text").text() != __text.replace(/(<([^>]+)>)/ig,"") ){
		$("#uploader .prg .text").html( __text );
	}
	$("#uploader .prg .progress-bar").css("width",Math.round((total_done/total_size)*100)+"%");

}
function __ini(){

	this.on("complete", function(file) {
		__up( this, file, false );
	});

	this.on("canceled", function(file) {
		__up( this, file, false );
	});

	this.on("addedfile", function(file) {

		if ( !$upload_started ){
			$("#uploader .progress").fadeIn(400);
		}

		$upload_started = true;

		if ( $("#uploader").hasClass("ready") ){
			$("#uploader .continue").hide(100);
			$("#uploader").animate({height:"300px"},200);
			$("#uploader").removeClass("ready");
		}

	});

	this.on("uploadprogress", function(file){
		__up( this, file, true );
	});

	this.on("queuecomplete", function(){
		$("#uploader").animate({height:"340px"},400,function(){
			$("#uploader .continue").delay(400).show('slow');
			$("#uploader").addClass("ready");
		});
	});

}

function check_login_result( sta, data ){
	if ( sta ){
		window.location = $_home;
	}
}
function check_user_setting_response( sta, data, settingPartName ){
	if( sta ) pager.page_load( $_home + "user_setting?n=" + settingPartName );
}
function check_signup_result( sta, data ){
	if ( sta ){
		window.location = $_home;
	}
}

function updateUploadingTrackData(){
	be_cli({
		action: 'user_update_uploading_track',
		data: getModal(true),
		domTarget: ".watermark",
		callBack: "updatedUploadingTrackData"
	});
}
function updateUploadingAlbumData(){
	be_cli({
		action: 'user_update_uploading_album',
		data: getModal(true),
		domTarget: ".watermark",
		callBack: "updatedUploadingAlbumData"
	});
}
function updatedUploadingTrackData( sta, data ){
	if ( sta ) pager.page_reload();
}
function updatedUploadingAlbumData( sta, data ){
	if ( sta ) pager.page_reload();
}
function updated_uploading_cover( sta, data ){
	if ( sta ) pager.page_reload();
}
function updated_waveform( sta, data, id ){

	if ( sta ){
		$("body").find("#tr_"+id+" .waveform").html('<span class="mdi mdi-check-circle"></span>');
	} else {
		$("body").find("#tr_"+id+" .waveform").text("failed");
	}

	setTimeout( function(){
		createWaveform();
	}, 200 );

}
function finalize_edit(){

	be_cli({
		action: 'user_update_finalize_edit',
		domTarget: '.watermark',
		background: false,
		callBack: function( sta, data ){
			if ( sta )
			  pager.page_load( $_home + "user/" + $_user_name + "/uploads" );
			else
			  pager.page_reload();
		}
	});

}

function createTrackEditModal(e){

	var $__t = $__tracks[e];
	createModal({
		title: $_texts.upload_edit_t_title,
		tip: $__t.originalName,
		class: 'edit track type2',
		inputs: [

			{
				type: 'hidden',
				name: 'rID',
				value: $__t.rID,
			},
			{
				type: 'hidden',
				name: 'uploadID',
				value: $__upload_id,
			},
			{
				type: 'text',
				name: 'title',
				value: $__t.title,
				label: $_texts.title,
				group: 'a'
			},
			{
				type: 'text',
				name: 'artist_name',
				value: $__t.artist_name,
				label: $_texts.artist,
				group: 'a'
			},
			{
				type: 'text',
				name: 'artists_featured',
				value: $__t.artists_featured,
				label: $_texts.featured_artists,
				group: 'a',
				tip: $_texts.featured_artists_tip
			},
			{
				type: 'select',
				name: 'album_type',
				label: $_texts.album_type,
				group: 'a',
				value: $__t.album_type,
				values:  [ [ 'single', 'Single' ], [ 'studio', 'Studio' ], [ 'compilation', 'Compilation' ], [ 'mixtape', 'Mixtape' ] ],
				attr: ' onChange="$(document).find(\'.modal\').find(\'.nalbum_title\').show(); $(document).find(\'.modal\').find(\'.nalbum_order\').show(); $(document).find(\'.modal\').find(\'.nalbum_artist_name\').show(); if( $(this).val() == \'single\' || $(this).val() == \'compilation\' ) $(document).find(\'.modal\').find(\'.nalbum_artist_name\').hide(); if( $(this).val() == \'single\' ) { $(document).find(\'.modal\').find(\'.nalbum_title\').hide(); $(document).find(\'.modal\').find(\'.nalbum_order\').hide(); }"'
			},
			{
				type: 'text',
				name: 'album_title',
				value: $__t.album_title,
				label: $_texts.album_title,
				group: 'a'
			},
			{
				type: 'text',
				name: 'album_artist_name',
				value: $__t.album_artist_name,
				label: $_texts.album_artist,
				group: 'a'
			},
			{
				type: 'text',
				name: 'album_order',
				value: $__t.album_order,
				label: $_texts.album_order,
				group: 'a'
			},
			{
				type: 'select',
				name: 'genre',
				value: $__t.genre,
				label: $_texts.genre,
				group: 'a',
				values: $__genres
			},
			{
				type: 'textarea',
				name: 'comment',
				value: $__t.comment,
				label: $_texts.description,
				group: 'a'
			},
			{
				type: 'textarea',
				name: 'lyrics',
				label: $_texts.lyrics,
				value: $__t.lyrics,
				group: 'b'
			},
			{
				type: 'text',
				name: 'file_name',
				value: $__t.originalName,
				label: $_texts.file,
				group: 'd',
				readonly: true
			},
			{
				type: 'text',
				name: 'spotifyID',
				value: $__t.spotify_ID,
				label: $_texts.spotify_id,
				group: 'd',
				readonly: $_config.spotify_upload_e ? false : true
			},
			{
				type: 'radio',
				name: 'price',
				label: $_texts.price,
				group: 'e',
				value: $__t.price,
				values: $__prices,
				readonly: $_config.can_sell ? false : true,
				disabled: $_config.can_sell ? false : true,
			},

		],
		groups: {
			a: $_texts.detail,
			b: $_texts.lyrics,
			d: $_texts.sources,
			e: $_texts.price
		},
		buttons: [
			[ 'btn-primary', $_texts.save, 'updateUploadingTrackData()' ],
		]
	});

}
function createAlbumEditModal(e){
	let dateM = new Date();

	var $__a = $__albums[e]; 
	$__a.time = dateM.getFullYear()+'-'+dateM.getMonth()+'-'+dateM.getDay();
	createModal({

		title: $_texts.upload_edit_a_title,
		tip: $__a.title,
		class: 'edit album type2',
		inputs: [

			{
				type: 'hidden',
				name: 'code',
				value: $__a.code,
				group: "a"
			},
			{
				type: 'hidden',
				name: 'uploadID',
				value: $__upload_id,
				group: "a"
			},
			{
				type: 'text',
				name: 'title',
				value: $__a.title,
				label: $_texts.title,
				group: "a"
			},
			{
				type: 'text',
				name: 'artist_name',
				value: $__a.artist_name,
				label: $_texts.artist,
				group: "a"
			},
			{
				type: 'hidden',
				name: 'time',
				value: $__a.time,
				group: "a"
			},
			{
				type: 'select',
				name: 'type',
				label: $_texts.album_type,
				value: $__a.type,
				values:  [ [ 'single', 'Single' ], [ 'studio', 'Studio' ], [ 'compilation', 'Compilation' ], [ 'mixtape', 'Mixtape' ] ],
				attr: ' onChange=" $(document).find(\'.modal\').find(\'.nartist_name\').show(); if( $(this).val() == \'compilation\' ) $(document).find(\'.modal\').find(\'.nartist_name\').hide(); "',
				group: "a"
			},
			{
				type: 'select',
				name: 'genre',
				value: $__a.genre,
				label: $_texts.genre,
				values: $__genres,
				group: "a"
			},
			{
				type: 'text',
				name: 'spotifyID',
				value: $__a.spotify_ID,
				label: $_texts.spotify_id,
				readonly: $_config.spotify_upload_e ? false : true,
				group: "a"
			},
			{
				type: 'textarea',
				name: 'comment',
				value: $__a.comment,
				label: $_texts.description,
				group: "a"
			},
			{
				type: 'radio',
				name: 'price',
				label: $_texts.price,
				group: 'e',
				value: $__a.price,
				values: $__prices,
				readonly: $_config.can_sell ? false : true,
				disabled: $_config.can_sell ? false : true,
			}
		],
		groups: {
			a: $_texts.detail,
			e: $_texts.price
		},
		buttons: [
			[ 'btn-primary', $_texts.save, 'updateUploadingAlbumData()' ],
		]

	});

}

function createModal( $args ){

	if ( $args === undefined ){
		console.log( "modal arguemts are missing" );
		return;
	}

	var $class   = $args.class   === undefined ? ""    : $args.class;
	var $title   = $args.title   === undefined ? false : $args.title;
	var $tip     = $args.tip     === undefined ? false : $args.tip;
	var $content = $args.content === undefined ? false : $args.content;
	var $content_before = $args.content_before === undefined ? false : $args.content_before;
	var $inputs  = $args.inputs  === undefined ? false : $args.inputs;
	var $groups  = $args.groups  === undefined ? false : $args.groups;
	var $buttons = $args.buttons === undefined ? false : $args.buttons;
	var $action  = $args.action  === undefined ? false : $args.action;
	var $target  = $args.target  === undefined ? false : $args.target;
	var $callback  = $args.callback  === undefined ? false : $args.callback;
	var $callback_param  = $args.callback_param  === undefined ? false : $args.callback_param;

	$("body").addClass("active_modal");

	var $triggers = [];
	var $html = "";
	$html = $html + "<div class='hover close_modal_handle "+$class+"'></div>";
	$html = $html + "<div class='modal "+$class+"'><form class='be_cli_form' data-hasFile='true' data-target='"+$target+"' data-callback='"+$callback+"' data-callback_param='"+$callback_param+"' method='post' data-action='"+$action+"' enctype='multipart/form-data'>";

	if ( $title )
		$html = $html + "<div class='title'>"+$title+"<span class='close_modal_span close_modal_handle'>X</span></div>";

	if ( $tip )
		$html = $html + "<div class='tip'>"+$tip+"</div>";

	if ( $content_before )
		$html = $html + "<div class='content before'>"+$content_before+"</div>";

	if ( $inputs ){

		var __fg = null;
		if ( $groups ){

			$html = $html + "<div class='groups'><div class='btn-group'>";
			for ( var __gid in $groups ){
				__fg = __fg === null ? __gid : __fg;
				var __gtitle = $groups[ __gid ];
				$html = $html + "<button data-GID='"+__gid+"' type='button' class='btn btn-secondary"+(__fg==__gid?" active":"")+"' style='width:"+(Math.floor(100/Object.keys($groups).length))+"%'>"+__gtitle+"</button>";
			}
			$html = $html + "</div></div>";

		}

		$html = $html + "<div class='inputs'>";
		for ( var i=0; i<$inputs.length; i++ ){

			var $input = $inputs[i];
			if ( !$input.type || !$input.name ) continue;
			var $input_dom_type = null;
			$input.value = !$input.value ? "" : $input.value;
			$input.full_attr = "id='"+$input.name+"' name='"+$input.name+"' class='form-control'" + ( $input.attr ? " " + $input.attr : "" ) + ( $input.readonly ? " readonly='readonly'" : "" ) + ( $input.disabled ? " disabled='disabled'" : "" );

			if ( $input.type == 'hidden' ){
				$html = $html + "<input type='hidden' value='"+$input.value+"' "+$input.full_attr+">";
				continue;
			}

			$html = $html + "<div class='input t"+$input.type+" n"+$input.name+" g"+($input.group===undefined?"A":$input.group)+"' "+($input.group===undefined||$input.group==__fg?"":" style='display:none' ")+">";
			$html = $html + "<label>"+$input.label+"</label>";

			if ( $input.type == "text" ){

				$html = $html + "<input type='text' value='"+$input.value+"' "+$input.full_attr+( $input.placeholder ? " placeholder='"+$input.placeholder+"'" : "" )+">";

		    }
			else if ( $input.type == "textarea" ){

				$html = $html + "<textarea "+$input.full_attr+">"+$input.value+"</textarea>";

		    }
			else if ( ( $input.type == "select" || $input.type == "select_multi" ) && $input.values !== undefined ? $input.values.length : false ){

				if ( $input.type == "select_multi" ){
					$input.full_attr = $input.full_attr + " multiple='true' data-multi='true' "
					var __val = $input.value ? $input.value.split( "," ) : [];
				}

				$html = $html + "<select "+$input.full_attr+">";
				for ( var z=0; z<$input.values.length; z++ ){
					var __o = $input.values[z];
					if ( __o === undefined ) continue;
					var __selected = ( $input.type == "select_multi" ? $input.value == __o[0]: $input.value == __o[0] ) ? " selected='selected'" : ""
					$html = $html + "<option value='"+__o[0]+"'"+__selected+">"+__o[1]+"</option>";
				}
				$html = $html + "</select>";

				$triggers.push( [ "#"+$input.name, "change" ] );

			}
			else if ( $input.type == "radio" && $input.values !== undefined ? $input.values.length : false ){
				$html = $html + "<div class='radio_wrappers'>";
				for ( var z=0; z<$input.values.length; z++ ){

					var __o = $input.values[z];
					if ( typeof( __o ) == "string" || typeof( __o ) == "number" ){
						__o = [ __o, __o ];
					}

					$html = $html +
						"<div class='radio_wrapper'>"+
						"<input "+$input.full_attr+" type='radio' value='"+__o[0]+"'"+($input.value==__o[0]?" checked='checked'":"")+">"+__o[1]+
						"<span class='checkmark'></span>"+
						"</div>";

				}
				$html = $html + "</div>";
				$triggers.push( [ "#"+$input.name, "change" ] );
			}
			else if ( $input.type == "file" ){
				$html = $html + "<div class='form-control' style='opacity:0.4' onClick='$(\"#"+$input.name+"\").click()'>"+$_texts.click_to_select+"</div>";
				$html = $html + "<input style='display:none' type='file' "+$input.full_attr+">";
			}

			if ( $input.tip ){
				$html = $html + "<div class='itip'>"+$input.tip+"</div>";
			}

			$html = $html + "</div>";
		}
		$html = $html + "</div>";

	}

	if ( $content )
		$html = $html + "<div class='content after'>"+$content+"</div>";

	$html = $html + "<div class='response'></div>";

	if ( $buttons ){

		$html = $html + "<div class='buttons'>";
		$html = $html + "<div class='button'><a class='btn btn-secondary close_modal_handle'>"+$_texts.cancel+"</a></div>";
		for( var i=0; i<$buttons.length; i++ ){
			$html = $html + "<div class='button'><a class='btn "+$buttons[i][0]+"' onClick='"+$buttons[i][2]+"'>"+$buttons[i][1]+"</a></div>";
		}
		$html = $html + "</div>";

	}

	$html = $html + "</form></div>";

	$("body").append( $html );

	if ( $triggers ){
		for( var i=0; i<$triggers.length; i++ ){
			var $trigger = $triggers[i];
			$( $trigger[0] ).trigger( $trigger[1] );
		}
	}

	if ( typeof( pager ) != 'undefined' )
		pager.bind();

	if ( $action )
	be_cli_forms_hook();

	$(document).trigger("new_modal");

}
function closeModal(){

	$(".hover").remove();
	$(".modal").remove();
	$("body").removeClass("active_modal")

}
function getModal( returnArray, EscapeData ){

	if ( returnArray === true ){

		var unindexed_array = $(document).find(".modal").find("form").serializeArray();
		var indexed_array = {};
		$.map(unindexed_array, function(n, i){

			if ( EscapeData === true )
			n['value'] = escapeHtml( n['value'] );

			if ( typeof( indexed_array[n['name']] ) != "string" ){
				indexed_array[n['name']] = n['value'];
			} else {
				indexed_array[n['name']] = indexed_array[n['name']] + "," + n['value'];
			}

		});
		return indexed_array;

	}

	return $(document).find(".modal").find("form").serialize();

}
function escapeHtml(text) {

	if ( typeof(text) != 'string' )
	return text;

	var map = {
		'&': '&amp;',
		'<': '&lt;',
		'>': '&gt;',
		'"': '&quot;',
		"'": '&#39;',
		'/': '&#x2F;',
		'`': '&#x60;',
		'=': '&#x3D;'
	};

	return text.replace(/[&<>"']/g, function(m) { return map[m]; });

}
function createNoAccessModal(){

	$("body").addClass("no_access");
	closeModal();
	$("body").append('<div class="hover no_access close_modal_handle"></div><div class="modal no_access"><div class="icon"><span class="mdi mdi-shield-key"></span></div><div class="title">'+$_texts.members_only+'<span class="close_modal_span close_modal_handle">X</span></div><div class="text">'+$_texts.members_only_tip+'</div><div class="buttons"><a href="'+$_home+'user_signup" class="btn btn-secondary btn-sm">'+$_texts.signup+'</a><a href="'+$_home+'user_login" class="btn btn-light btn-sm">'+$_texts.login+'</a></div></div>');
	pager.bind()

}
function createNoAccessMediaModal(){

	$("body").addClass("no_access");
	closeModal();
	$("body").append('<div class="hover no_access close_modal_handle"></div><div class="modal no_access"><div class="icon"><span class="mdi mdi-shield-key"></span></div><div class="title">'+$_texts.not_purchased+'<span class="close_modal_span close_modal_handle">X</span></div><div class="text">'+$_texts.purchase_to_hear+'</div><div class="buttons"><a class="close_modal_handle btn btn-secondary btn-sm">'+$_texts.purchase+'</a><a class="add_fund_modal_handle btn btn-light btn-sm">'+$_texts.add_funds+'</a></div></div>');
	pager.bind()

}
function createPurchaseModal( $args ){

	if ( !$_user_id ){
		createNoAccessModal()
		return;
	}

	var $title = $args.title;
	var $tip   = $args.tip;
	var $item_type = $args.item_type;
	var $item_hook = $args.item_hook;
	var $item_name = $args.item_name;
	var $item_price = $args.item_price;
	var $fund = $args.fund;
	var $currency = $_texts.currency;

	createModal({
		class: "type2 purchase",
		content_before: '<div class="icon"><span class="mdi mdi-cart"></span></div><div class="title">'+$title+'</div><div class="detail"><div class="item_name"><i>'+$_texts.item_name+':</i><b>'+$item_name+'</b></div><div class="item_price"><i>'+$_texts.item_price+':</i><b>'+$item_price+$currency+'</b></div><div class="fund"><i>'+$_texts.account_funt+':</i><b>'+$fund+$currency+'</b></div></div><div class="buttons"><a class="btn btn-secondary btn-sm pp_handle" data-type="'+$item_type+'" data-hook="'+$item_hook+'">'+$_texts.confirm+'</a><a class="add_fund_modal_handle btn btn-light btn-sm">'+$_texts.add_funds+'</a></div><div class="result"></div>',
	})

}
function proceedPurchase( $args ){

	var $type = $args.type;
	var $hook = $args.hook;

	$(document).find(".modal").addClass("has_result");

	be_cli({
		action: 'user_purchase',
		data: {
			type: $type,
			hook: $hook
		},
		domTarget: '.modal .result',
		callBack: function( sta, data ){
			if( sta ){
				window.location = $_home + "user_setting?n=transaction_history"
			}
		}
	});

}
function createShareModal( $args ){

	var $title = $args.title;
	var $name  = $args.name;
	var $tip   = $args.tip;
	var $url   = $args.url;
	var $image = $args.image;
	var $type  = $args.type;

	if ( $type == "track" ){

		createModal({
			class: "type2 share",
			content_before: '<div class="title">'+$title+'</div><div class="groups"><div class="btn-group"><button data-gid="a" type="button" class="btn btn-secondary active" style="width:50%">Link</button><button data-gid="b" type="button" class="btn btn-secondary" style="width:50%">Embed</button></div></div><div class="share_content ga input"><div class="image_wrapper"><img src="'+$image+'"></div><div class="name">'+$name+'</div><div class="url"><input type="text" value="'+$url+'" class="form-control" readonly onClick="select()"></div><div class="soicons"><a class="soicon fb" href="https://www.facebook.com/sharer.php?u='+$url+'"><span class="icon"></a><a class="soicon tt" href="http://twitter.com/intent/tweet?text='+$name+'&url='+$url+'"><span class="icon"></a></div></div><div class="embed_content gb input" style="display:none"><iframe src="'+$url+'/embed" frameborder="0" width="100%" height="160px"></iframe><input type="text" value="&lt;iframe src=\''+$url+'/embed\' frameborder=\'0\' width=\'100%\' height=\'160px\'&gt;&lt;/iframe&gt;" class="form-control" readonly onClick="select()"></div>',
		});
		return;

	}

	createModal({
		class: "type2 share",
		content_before: '<div class="title">'+$title+'</div><div class="share_content"><div class="image_wrapper"><img src="'+$image+'"></div><div class="name">'+$name+'</div><div class="url"><input type="text" value="'+$url+'" class="form-control" readonly onClick="select()"></div><div class="soicons"><a class="soicon fb" href="https://www.facebook.com/sharer.php?u='+$url+'"><span class="icon"></a><a class="soicon tt" href="http://twitter.com/intent/tweet?text='+$name+'&url='+$url+'"><span class="icon"></a></div></div>',
	});

}
