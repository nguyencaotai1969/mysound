"use strict"

window.pager = {

	debug: false,
	page_title: null,
	song_title: null,
	loading: false,

	log: function( $log_text ){

		if ( !pager.debug ) return;
		console.log( "pager." + $log_text );

	},

	bind: function(){

		pager.log( "bind" );
		pager.bind_links();

	},
	bind_links: function(){

		pager.log( "bind_links" );
		$("body").find("a").off("click");
		$("body").find("a").on("click",function(e){

		    if ( !$(this).attr("href") ) return;
				if ( $(this).data("skip_bind") ) return;
		    if ( $(this).attr("href").substr( 0, $_home.length ) != $_home ) return;
		    if ( muse.que_open ) muse.close_que();

			closeModal();
		    pager.load_start();
		    e.preventDefault();

			pager.page_load( $(this).attr("href") )

		});

	},

	page_reload: function( $scroll ){

    $scroll = $scroll === true ? true : false;
		pager.log( "reload" );
		pager.page_load( window.location.href, false, $scroll );

	},
	page_load: function( $url, $history, $scroll ){

		$history = $history === false ? false : true;
		$scroll  = $scroll  === false ? false : true;

		pager.trigger_off();
		$(document).trigger("pageUnloaded");
		$(document).trigger("pageUnloaded_m");
		pager.load_start();
		pager.log( "page_load url=" + $url );
		be_cli({
		    url: $url,
			dataType: "html",
		    callBack: pager.page_loaded,
		    callBack_param: [ $url, $history, $scroll ],
		    background: false,
		    goodHeader: 200
		});

	},
	page_loaded: function( sta, data, params ){

		if ( !data.includes("id=\"scroller\"") ){

            pager.log("no #scroller found!");

			if ( data.includes( "page_no_access" ) ){
				pager.load_finish();
				createNoAccessModal();
				return;
			}

			window.location = params[0];
			return;

		}

		var __n     = $(data),
			content = __n.filter("#main").html(),
			title   = __n.filter("title").text();

		if ( data.match(/<body class="(.*?)">/) ){

			var new_body_classes = data.match(/<body class="(.*?)">/)[1];

			if ( new_body_classes.match(/theme_admin/) ){

                pager.log("direct request");
				window.location = params[0];
				return;
			}

			var classes = [];

			jQuery.grep( $("body").attr("class").split(" "), function(el) {
				if ( el.substr( 0, 5 ) != "page_" && el.substr( 0, 3 ) != "pt_" )
					classes.push( el );
			});

			jQuery.grep( new_body_classes.split( " " ), function(el) {
				if ( el != "hard_loading" && jQuery.inArray( el, classes ) == -1 )
				    classes.push( el );
			});

			$("body").attr( "class", classes.join(" " ) );

			pager.set_type();

		}

		pager.log( "page_loaded title=" + title );

		if ( !sta || !content ){
			$("body").addClass("failed");
			pager.log("failed");
			setTimeout(function(){
				window.location.reload();
			},2000);
			return;
		}

		if( params[1] ) window.history.pushState(data, title, params[0] );

		$(document).off("pageUnloaded");
		$(document).off("pageInlined");
		$(document).find("#scroller").html( content.trim().substr( 19 ).substr( 0, content.trim().length - ( 19 + 6 ) ) );

		pager.page_load_images( params[2] );
		pager.page_title = title;
		pager.set_title();
		pager.set_menu();
		pager.bind()

		be_cli_forms_hook();

	},
	page_load_images: function( scroll ){

		// $("#scroller").waitForImages(function() {

			pager.trigger_on();
			$(document).trigger("pageInlined");
			$(document).trigger("pageInlined_m");
			if ( scroll !== false ){
				$("#scroller").animate({ scrollTop: 0 }, "slow");
			}
			pager.load_finish();
			muse.update_dom_buttons();
			muse.update_dom_waves();

		// });

	},

	load_start: function( skipBody ){

		if ( pager.loading === true ) return;
		if ( skipBody !== true ) $("body").addClass("loading");
		$("body").addClass("active");
		$("body").prepend("<div class='pager_wrapper'><div id='pager'></div><div id='pager_text'>"+$_texts.wait+"</div></div>");
		if ( $("body").hasClass("hard_loading") ){
			if ( $(window).width() > 540 ){
				window.loader.start();
			} else {
				$("body").removeClass("hard_loading");
			}
		}
		pager.loading = true;

	},
	load_finish: function(){

		$("body").removeClass("loading").removeClass("active").removeClass("hard_loading");
		window.loader.end();
		$("body").find(".pager_wrapper").remove();
		pager.loading = false;

    $("body").find(".button_more.active").removeClass("active");

		var target_dom_id = window.location.hash;
		if ( target_dom_id && $(target_dom_id).length ){
			$("#scroller").animate({
				scrollTop: $(target_dom_id).offset().top + $("#scroller").scrollTop() - $(target_dom_id).height() - 50
		  }, 700);
		}
		if ( $("#scroller")[0] ){
			if ( $("#scroller")[0].scrollHeight > $("#scroller").outerHeight() )
			$("#scroller").addClass("scrolled").removeClass("nonscrolled");
			else
			$("#scroller").removeClass("scrolled").addClass("nonscrolled");
		}

	},

	set_type: function(){

		if ( !$("body").attr("class").match(/page_(.*?) /gi) )
			return;

		pager.page_type = $("body").attr("class").match(/page_(.*?) /gi)[0].toString().trim().substr(5)

	},
	set_title: function(){

		if ( pager.song_title )
			$(document).find("title").text( decode_htmlspecialchars( pager.song_title ) );
		else if ( pager.page_title )
			$(document).find("title").text( decode_htmlspecialchars( pager.page_title ) );

		pager.log( "set_title st=" + pager.song_title + ", pt=" + pager.page_title );

	},
	set_menu: function(){

		pager.log( "set_menu" );

		$(".menu_wrapper li.active").removeClass("active");

		var menus = $(".menu_wrapper li.p");
		for ( var i=0; i<menus.length; i++ ){

			var menu = menus[i];
			var ahrefs = $(menu).find("a");
			for ( var z=0; z<ahrefs.length; z++ ){
				var ahref = ahrefs[z];
				if( ahref.href == window.location.href ){
					$(menu).addClass("active");
                    if ( $(ahref).parent().attr("class") ? $(ahref).parent().attr("class").split(" ").includes("c") : false ){
                        $(ahref).parent().addClass("active");
                    }
				}
			}

		}

	},

	trigger_on: function(){

		if ( pager.page_type == "track" ){
			$("#waveform .pr img").css("width",$("#waveform .bg").width()+"px");
			$("#waveform .pr img").css("height",$("#waveform .bg").height()+"px");
		}

		if ( pager.page_type == "user_logout" ){
			window.location = $_home;
		}

		if ( pager.page_type == "user_upload" ){

			console.log( $_home + "user_upload?action=user_upload_music&ID=" + $(document).find("#uploader").attr("data-id") );

			var args = {
				url: $_home + "user_upload?action=user_upload_music&ID=" + $(document).find("#uploader").attr("data-id"),
			    paramName: "$file",
			    maxFilesize: $_config.upload_max_size,
			    parallelUploads: $_config.upload_max_par_ups,
			    acceptedFiles: ".mp3",
			    createImageThumbnails: false,
			    previewsContainer: "#uploading",
			    timeout: $_out_time * 1000,
			    init: __ini
			}

			if ( $_config.chunk ){
				args['chunking'] = true;
				args['retryChunks'] = true;
				args['chunkSize'] = $_config.chunk_size * 1000000
			}

			$__dropzone = new Dropzone(
				"#uploader",
				args
			);

		}

	},
	trigger_off: function(){

		if ( pager.page_type == "track" ){
			if ( typeof wavesurfer !== 'undefined' ? wavesurfer !== undefined && wavesurfer !== null : false ){
			    wavesurfer.cancelAjax();
			    wavesurfer = null;
		    }
		}

		if ( pager.page_type == "user_upload" ){

			if ( $__dropzone === null )
				return;

			$__dropzone.removeAllFiles(true);
		}

	}

};

window.loader = {

	vivus: null,
	pointer: 0,
    svgs: [
        "/themes/__default/assets/icons/loading_svgs/l1.svg",
        "/themes/__default/assets/icons/loading_svgs/l3.svg",
        "/themes/__default/assets/icons/loading_svgs/l4.svg",
		"/themes/__default/assets/icons/loading_svgs/l2.svg",
    ],
    dom: "#pager",
	timer: null,

	start: function(){

		loader.vivus = new Vivus(
			'pager', {
	    		duration: 220,
	    		type: 'delayed',
	    		file: $_home + loader.svgs[ loader.pointer ],
	    		onReady: function (myVivus){
	    			loader.vivus.play(1);
	    		}
	    	},
			function() {

				if ( loader.vivus.getStatus() === 'end' ){
					loader.timer = setTimeout( function(){
						loader.vivus.play(-1);
					}, 350 );
				}

				else {
					$("#pager").html(" ");
					loader.vivus.destroy();
					loader.pointer = ( loader.pointer + 1 ) % loader.svgs.length;
					loader.start();
				}
			}
		);

	},
	end: function(){

		if ( loader.vivus ){
			loader.vivus.destroy();
		}
		if ( loader.timer ){
			clearTimeout( loader.timer );
			loader.timer = null;
		}
		$("body").removeClass("hard_loading");

	}

}

$(document).trigger("pageInlined_m");

window.addEventListener('resize', function(event){
	$(document).trigger("pageUnloaded");
	$(document).trigger("pageInlined");
});
