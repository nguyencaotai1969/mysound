"use strict"

var $fix_fit_height_doms = [".modal","#sidebar ul li .mdi","#player .song_data .song_detail .playlist_buttons","#que_list .loading_t","#que_list .que_tracks_wrapper .track .duration","#que_list .que_tracks_wrapper .track .buttons","body.loading.hard_loading .pager_wrapper #pager","body.loading.hard_loading .pager_wrapper #pager_text","#main .page_head.album .t_wrapper .data_wrapper","#main .page .widget_table .table_wrapper table tbody tr td.col-btn .buttons.play .mdi","#main .page .widget_slider.widget_genre_slider .slider .a_row .slider_item .text","#main .page .widget_slider .arrows .arrow","body.uap .logo","body.uap #form_holder","#uploader","#main .user_container #user_content .playlists .playlist .tracks .track .data .icons","#main .user_container #user_content .playlists .playlist .head .icon","#main .user_container #user_content .acts .track .track_wrapper .title","#main .page .widget_slider.widget_genre_slider .slider .a_row .slider_item .text","div.search_open",".edit .album .cover_wrapper .cover .edit span"];

function fix_height_fit_content(){

	if ( cssPropertyValueSupported( "height", "fit-content" ) ) return;

  for ( var keyIndex in $fix_fit_height_doms ){

		var selector = $fix_fit_height_doms[ keyIndex ];
		$( selector ).each(function(ii,e){

			if ( $(e).hasClass("fixed") )
				return;

		    var _original_position = $(e).css("position");
		    var _original_height   = $(e).height();

		    $(e).css("transition","none")
				.css("height","auto")
				.css("position","static");

			var _content_height = $(e).outerHeight();

			$(e).css("height", _content_height +"px" )
				.css("position", _original_position )
				.addClass("fixed");

		});
	}

}
function cssPropertyValueSupported(prop, value) {
  var d = document.createElement('div');
  d.style[prop] = value;
  return d.style[prop] === value;
}

if ( !cssPropertyValueSupported( "height", "fit-content" ) ){
	$(document).on( "pageInlined_m", fix_height_fit_content );
	$(document).on( "new_modal", fix_height_fit_content );
}

$(document).on("pageInlined_m", function(){

	$('.button.search.opened').removeClass('opened')

	if ( $("body").hasClass("naved") || $("body").hasClass("shown") ){
		$("body").find("#sidebar .p.has-child.shown").click();
		close_sidebar();
	}

	pager.bind();

});
$(document).on("pageUnloaded_m", function(){

	if ( $("body").hasClass("search_open") ){
		close_search();
	}

	if ( $("body").hasClass("active_que_list") ){
		muse.close_que()
	}

});
$(document).ready(function(){

	pager.bind();

	console.log( $_config );

	if (
	  !$_config["pg_op"] &&
	  !$_config["pg_pp"] &&
	  !$_config["pg_st"] &&
	  !$_config["pg_kk"] &&
	  !$_config["pg_ps"] &&
	  !$_config["pg_fw"] &&
	  !$_config["pg_cp"] &&
	  !$_config["pg_rp"]
	){
		$(document).find("#add_funds").addClass("hide").hide()
	}

	if ( $(window).width() > 610 )
		return;

	mobilize_menus();

});
$(document).on("click",".close_sidebar_handle",function(){
	close_sidebar()
});
$(document).on("click",".close_search_handle",function(){
	close_search()
});

function mobilize_menus(){

	if ( $(".buttons.user_menu").hasClass("logged") ){
		$("#sidebar .p.sos.account").html( $(".buttons.user_menu .user_wrapper > *").clone() );
		$("#sidebar .p.sos.account").addClass("has_user");
		$("#sidebar .p.sos.account").find("ul").addClass("items");
	}

	$(document).on("click","#sidebar .p",function(e){


		$("body").removeClass("active_yt");

		if ( $(e.target).hasClass("search") && $(e.target).hasClass("sos") ){
			if ( $("body").hasClass("search_open") )
				close_search()
			else
				open_search();
			return;
		}

		if ( e.target.nodeName == "A" ){
			pager.page_load( $(e.target).attr('href') );
			e.preventDefault();
			return true;
		}

		if ( !$(e.target).hasClass("has-child") ){
			$(e.target).find("a").click();
			return true;
		}

		if ( $(e.target).hasClass("shown") ){
			$(e.target).removeClass("shown");
			$("body").removeClass("shown");
		} else {
			$("#sidebar .p.has-child.shown").removeClass("shown");
			$(e.target).addClass("shown");
			$("body").addClass("shown");
		}

		close_search();
		muse.close_que();

	});

	$(document).on("pageInlined_m", function(){
		close_search();
		close_sidebar();
		$(document).find("body").removeClass("active_yt");
		$("body").find("#player .song_data .song_detail .artist_album_wrapper .album_title").removeClass("album_title").addClass("artist_title");
	});

}
function open_sidebar() {
	$("body").addClass("naved");
	$("body").append("<div class='naved_hover close_sidebar_handle'></div>");
	$("body").find("#nav .button.menu_handle").clone().appendTo("#sidebar");
}
function close_sidebar(){
	$("body").removeClass("naved");
	$("body").find(".naved_hover").remove();
	$("#sidebar").find(".button.menu_handle").remove();
}
function open_search(){
	$("#sidebar .p.has-child.shown").removeClass("shown");
	$("body").removeClass('active_yt');
	$("body").find(".p.single.sos.search").addClass("shown");
	$("body").addClass("search_open");
	$("body").append("<div class='search_open_hover close_search_handle'></div><div class='search_open'></div>");
	$("body").find(".search_open").append( "<div class='cross close_search_handle'><span class='mdi mdi-close'></span></div>" );
	$("body").find(".search_open").append( $("body").find("#nav .button.search").clone() );
	$("body").find("#nav .button.search").remove();
	fix_height_fit_content();
	muse.close_que();
}
function close_search(){
	$("body").find(".p.single.sos.search").removeClass("shown");
	$("body").find(".search_open .button.search").clone().appendTo("#nav .buttons.opp");
	$("body").removeClass("search_open");
	$("body").find("#nav .search_open .button.search")
	$("body").find(".search_open_hover").remove();
	$("body").find(".search_open").remove();
}
