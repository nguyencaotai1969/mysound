"use strict"

function _hr_seconds( $seconds ){

	if ( $seconds > 60 ){
		var $minutes = Math.floor( $seconds / 60 );
		$seconds = $seconds - ( $minutes * 60 );
		if ( $seconds.toString().length == 1 ) $seconds = "0" + $seconds;
        if ( $minutes.toString().length == 1 ) $minutes = "0" + $minutes;
		return $minutes+":"+$seconds;
	}
    else {
        if ( $seconds.toString().length == 1 ) $seconds = "0" + $seconds;
        $seconds = "00:" + $seconds;
    }

	return $seconds;

}

window.muse = {

	debug: false,
	type: null,
	player: false,
	yt_ready : false,
	yt_load: false,
	yt_player: false,
	seeker_timer: null,
	sta: null,
	sta_playing: false,
	que_open: false,
	heard: 0,
	volume: 100,
	repeat: true,
	pl: false,

	cache: {
		lwu: null
	},
	song_data: {
		hash: null,
	},
	song_time_total: null,
	song_time_current: null,
	song_time_elapsed_percentage: null,

	log: function( $log_text ){
		if ( !muse.debug ) return;
		console.log( "muse." + $log_text );
	},

	add_track: function ( $hook, $que_to_top ){
		return muse.add( "track", $hook, $que_to_top );
	},
	add_album: function ( $hook, $que_to_top ){
		return muse.add( "album", $hook, $que_to_top );
	},
	add_playlist: function ( $hook, $que_to_top ){
		return muse.add( "playlist", $hook, $que_to_top );
	},
	add: function( $type, $hook, $que_to_top, $start_radio ){

		$start_radio = $start_radio === true ? 1 : 0;
		$que_to_top = $que_to_top === false ? 0 : 1;
		muse.log( "add type="+$type+" ID=" + $hook );

		if ( muse.song_data && !$start_radio ? ( $type + "_" + $hook == muse.song_data.from || ( $type == "track" ? muse.song_data.hash == $hook : false ) ) && ( muse.player || muse.yt_player ) : false ){
			muse.log( "add -> pause_play" );
			muse.pause_play();
			return;
		}

		var $requestData = {
			action: 'muse_add',
			data: {
				type: $type,
				hash: $hook,
				que_to_top: $que_to_top,
				start_radio: $start_radio
			},
			callBack: muse.added,
			callBack_param: {
				que_to_top: $que_to_top,
				start_radio: $start_radio
			}
		};

		if ( $start_radio ){
			$("body").addClass("radio_starting");
		}

		be_cli($requestData);

	},
	added: function( sta, data, $args ){

		$("body").removeClass("radio_starting");

		if ( $args["que_to_top"] )
			muse.get_track();

		if ( $args["start_radio"] )
			muse.get_que();

	},
	start_radio: function( $seed_type, $seed_hook ){

		return muse.add( $seed_type, $seed_hook, true, true );

	},
	next_track: function( $force ){

		$force = $force === true;
		if ( muse.pl && !$force ) return false;
		muse.log( "next_track" );

		be_cli({
			action: 'muse_next_track',
			callBack: muse.get_track,
		});

	},
	prev_track: function(){

		if ( muse.pl ) return false;
		muse.log( "prev_track" );

		be_cli({
			action: 'muse_prev_track',
			callBack: muse.get_track,
		});

	},

	get_track: function( autoplay, pl ){

		if ( typeof be_cli != 'function' ) return;

		autoplay = autoplay === false ? 0 : 1;
		pl = pl === true;
		muse.log( "get_track autoplay=" + autoplay );
		muse.pause( true );
		setTimeout(function(){
			muse.change_sta("loading");
		},50);

		if ( muse.yt_player ){
			muse.sta_playing = 0;
			muse.yt_player.stopVideo();
		}

		$(document).find(".yt_wapper").removeClass("active");

		be_cli({
			action: 'muse_get_track',
			data: {
				autoplay: autoplay,
				pl: pl ? 1 : 0,
				second: Math.round( muse.heard )
			},
			callBack: muse.got_track,
			callBack_param: autoplay,
			timeout: 40000,
		});

	},
	got_track: function( sta, data, autoplay ){

		if ( !sta || data == "no_qued_song" ){

			$(document).find("body").removeClass("active_muse");
			$(document).find("body").removeClass("active_muse_video");
			$(document).find(".yt_wrapper").removeClass("active");
			muse.song_data = null;
			muse.update_dom_buttons();
			muse.close_que();
			return;

		}

		data = JSON.parse( data );
		$(document).find("#player .song_detail").css("opacity","1");
		$(document).find("#player .artist_detail").css("opacity","1");
		$(document).find("body").find(".apl_wrapper").remove();;

		muse.pl = false;
		if ( data["pl"] === true ){

			muse.log("audioAdvertisement");
			muse.pl = true;
			$(document).find("body").addClass("active_muse");
			$(document).find(".yt_wrapper").removeClass("active");
			$(document).find("body").removeClass("active_muse_video");
			$(document).find("#player .song_detail").css("opacity","0");
			$(document).find("#player .artist_detail").css("opacity","0");
			$(document).find("body").append("<div class='apl_wrapper' data-ad-id='"+data.id+"'><div class='apl' style='background-image:url("+data["banner"]+")'></div></div>");

			muse.song_data = {
				source_type: 'file_r',
				stream_url: data["audio"],
				duration_hr: data["audio_duration_hr"]
			};

			muse.type = "audio";
			muse.heard = 0;
			muse.song_time_total = data["audio_duration"];
			muse.update_dom_data();
			muse.change_sta( "loading" );
			muse.setup_audio_player( autoplay );

			return;

		}

		if ( muse.song_data ? muse.song_data.url == window.location.href : false ){
			pager.page_load( data.url );
		}

		if ( data.force_refresh == 1 ){
			pager.page_reload();
		}

		muse.song_data = data;
		muse.heard = 0;
		muse.log( "got_track hash=" + data.hash + ", title=" + data.title );
		muse.song_time_total = data.duration;
		muse.update_dom_data();
		muse.volume = data.volume;
		muse.repeat = data.repeat;

		$(document).find(".yt_wrapper").removeClass("active");
		$(document).find("body").removeClass("active_muse_video");

		if ( muse.song_data.source_type === null ){
			muse.next_track(true);
			return;
		}

		setTimeout( function(){
			muse.setup_player( autoplay );
		}, 50 );

		muse.change_sta( "loading" );

		if ( muse.que_open ){
			muse.get_que( true );
		}

		pager.bind();

		if ( muse.song_data ){
			$(document).find("body").addClass("active_muse");
		}

		muse.set_repeat();

	},

	remove_from_que: function( $track_ID ){

		muse.log( "remove_from_que ID=" + $track_ID );

		be_cli({
			action: 'muse_remove_from_que',
			data: {
				hash: $track_ID
			},
			callBack: muse.removed_from_que,
		});

	},
	removed_from_que: function( sta, data ){

		if ( !sta ) return;
		muse.log( "removed_from_que data=" + data );
		muse.get_que( true );

	},
	close_que: function(){

		muse.log( "close_que" );

		$('#que_list').removeClass("display");
		$('.que_hover').remove();
		$("body").removeClass("active_que_list");
		muse.que_open = false;

	},
	clear_que: function(){

		muse.log( "clear_que" );
		muse.pause();
		be_cli({
			action: 'muse_clear_que',
			callBack: muse.cleared_que,
		});

	},
	cleared_que: function( sta, data ){

		if ( !sta ) return;
		muse.log( "cleared_que data=" + data );
		muse.get_track();
		muse.get_que(true);

	},
	shuffle_que: function(){

		muse.log( "shuffle_que" );
		be_cli({
			action: 'muse_shuffle_que',
			callBack: muse.shuffled_que,
		});

	},
	shuffled_que: function( sta, data ){

		if ( !sta ) return;
		muse.log( "shuffled_que data=" + data );
		muse.get_que(true);

	},
	get_que: function( $skip_closing ){

		$skip_closing = $skip_closing === true;
		muse.log( "get_que skip_closing=" + $skip_closing );

		if ( muse.que_open && !$skip_closing ){
			muse.log( "get_que --> close_que");
			muse.close_que();
			return;
		}

		$('#que_list')
			.addClass("display")
			.css("max-height",$(window).height()-(100));

		if ( !$skip_closing ){
			$('#que_list').html("<div class='loading_t'>loading</div>");
			$("body").append("<div class='que_hover m_cq'></div>");
		}

		if ( $("body").hasClass("search_open") ){
		    close_search();
		}

		$("body").removeClass('active_yt')

		muse.que_open = true;
		$("body").addClass("active_que_list");

		be_cli({
			action: 'muse_get_que',
			callBack: muse.got_que,
		});

	},
	got_que: function( sta, data ){

		muse.log( "got_que" );

		if ( data == "No_qued_song" ){
			muse.close_que();
			return;
		}

		$('#que_list').html(data);

		pager.bind();
		muse.update_dom_buttons();

	},

	like_track: function( id ){

		id = id === undefined ? muse.song_data.hash : id;
		if ( !id ) return;

		be_cli({
			action:'user_act_like',
			domTarget:'.watermark',
			data: {
				hash: id
			},
			callBack: function( sta, data ){
				if ( sta ){
					if ( data == $_texts.liked ){
						if ( muse.song_data ? id == muse.song_data.hash : false ) $(document).find(".like_dom.master").addClass("liked");
						$(document).find(".like_dom.id_"+id).addClass("liked")
						$(document).find(".like_btn_"+id).addClass("liked").find(".text").text("Unlike");
					} else {
						if ( muse.song_data ? id == muse.song_data.hash : false ) $(document).find(".like_dom.master").removeClass("liked");
						$(document).find(".like_dom.id_"+id).removeClass("liked")
						$(document).find(".like_btn_"+id).removeClass("liked").find(".text").text("Like");
					}
				}
			}
		})

	},
	repost_track: function( id ){

		be_cli({
			action:'user_act_repost',
			domTarget:'.watermark',
			data: {
				hash: id
			},
			callBack: function( sta, data ){
				if ( sta ){
					if ( data == $_texts.reposted ){
						$(document).find(".repost_btn_"+id).addClass("reposted").find(".text").text("Un-Repost");
					} else {
						$(document).find(".repost_btn_"+id).removeClass("reposted").find(".text").text("Repost");
					}
				}
			}
		})

	},
	add_track_to_playlist: function( id ){

		id = id === undefined ? muse.song_data.hash : id;
		if ( !id ) return;

		createModal({
			class: "type2 playlist",
			content_before: '<div class="icon"><span class="mdi mdi-playlist-music"></span></div><div class="title">'+$_texts.add_to_playlist+'</div><div class="text">'+$_texts.add_to_playlist_tip+'</div><div class="playlists">Loading</div><div class="buttons"><a data-hook="'+id+'" class="m_attp_a btn btn-secondary btn-sm">'+$_texts.perform+'</a><a href="'+$_home+'user_playlists" class="btn btn-light btn-sm">'+$_texts.create_new_playlist+'</a></div>',
		})

		be_cli({
			action: 'user_act_load_playlists',
			domTarget: '.modal .playlists',
		})

		pager.bind_links();

	},
	add_track_to_playlist_action: function( id ){

		be_cli({
			action: "user_act_extend_playlist",
			data: {
				playlist_hash: getModal(true)['playlist_hash'],
				track_hash: id
			},
			domTarget: ".watermark",
		});

	},
	download_track: function( ids ){

		var multi = ids.includes(",");

		createModal({
			class: "type2 download",
			content_before: '<div class="icon"><span class="mdi mdi-cloud-download"></span></div><div class="title">'+$_texts.download+'</div><div class="text">'+$_texts.download_tip+'</div><div class="buttons">'+(multi?'':'<a data-hook="'+ids+'" data-type="file" class="btn btn-secondary btn-sm m_dl_ini">'+$_texts.download+'</a>')+'<a data-hook="'+ids+'" data-type="link" class="btn btn-light btn-sm m_dl_ini">'+$_texts.get_links+'</a></div>'
		});

	},
	download_track_ini: function( ids, type ){

		type = !ids.includes(",") ? type : "link";

		be_cli({

			action: 'download_music',
			data: {
				type: type,
				ids: ids
			},
			domTarget: ".watermark",
			callBack: function( sta, data, type ){

				if ( !sta ) return true;

			    data = JSON.parse( data );

				if ( sta && type == "file" ){

					$(document).find(".watermark").remove();
					closeModal();
					window.location = data[0]

				}
				else {

					$(document).find(".watermark").remove();
					closeModal();

					var links = data.join("\r\n\r\n")

					createModal({
						class: "type2 download link_list",
						content_before: '<div class="title">'+$_texts.download_links+'</div><div class="text">'+$_texts.download_links_tip+'</div><textarea class="form-control">'+links+'</textarea>'
					});

				}

				return false;

			},
			callBack_param: type

		});

	},

	setup_player: function( autoplay ){

		muse.log( "setup_player autoplay=" + autoplay + ", type=" + muse.song_data.source_type );
		autoplay = !autoplay ? false : true;

		if ( muse.song_data.source_type == "youtube" ){
			muse.setup_video_player( autoplay );
			muse.type = "video"
		}
		else {
			muse.setup_audio_player( autoplay );
			muse.type = "audio"
		}

		muse.set_mediasession();
		muse.set_volume( muse.volume );

	},
	setup_video_player: function( autoplay, videoID ){

		if ( videoID ? videoID != muse.song_data.hash : false )
			return;

		if ( !muse.yt_ready ){

			if ( !muse.yt_load ){
				$.getScript( 'https://www.youtube.com/iframe_api' );
				muse.yt_load = true;
			}

			muse.log("youtube player is not ready" );
			var hash = muse.song_data.hash;
			setTimeout(function(){
				muse.setup_video_player( autoplay, hash );
			},1000);

			return;

		}

		if ( $_config.video_display == 1 ){
			$(document).find(".yt_wrapper").addClass("active");
			$(document).find("body").addClass("active_muse_video");
		}

		if ( muse.yt_player ) {
			muse.yt_player.loadVideoById( muse.song_data.source_data );
      muse.yt_player.playVideo();
		}
		else {
			muse.yt_player = new YT.Player('yt_holder', {
				width: 230,
				height: 230,
				videoId: muse.song_data.source_data,
				events: {
					onReady: function( event ){
						muse.log( "setup_video_play.Ready" );
						muse.change_sta("loadeddata");
						if ( autoplay ) muse.play()
						muse.set_volume( muse.volume, true );
					},
					onStateChange: function( event ){
						muse.log( "setup_video_play.onStateChange data=" + event.data );
						if ( event.data == 1 ){
							muse.change_sta("playing");
							$(document).find("body").addClass("active_yt");
						}
						else if ( event.data == 2 ) muse.change_sta("paused");
						else if ( event.data == 3 ) muse.change_sta("loading");
						else if ( event.data == 0 ) muse.change_sta("ended");
					},
					onError: function( event ){
						muse.log( "setup_video_play.onError" );
					},
					onApiChange: function( event ){
						muse.log( "setup_video_play.onApiChange" );
					},
				},
				playerVars: {
            autoplay: 0,
            rel: 0,
            showinfo: 0,
            disablekb: 1,
            controls: 0,
            modestbranding: 1,
            iv_load_policy: 3,
            playsinline: 1,
            host: window.location.protocol + '//www.youtube.com'
        },
			});
		}

		/*
		if ( muse.yt_player ) muse.yt_player.destroy();
		muse.yt_player = new YT.Player('yt_holder', {
			width: 230,
			height: 230,
			videoId: muse.song_data.source_data,
			events: {
				onReady: function( event ){
					muse.log( "setup_video_play.Ready" );
					muse.change_sta("loadeddata");
					if ( autoplay ) muse.play()
					muse.set_volume( muse.volume, true );
				},
				onStateChange: function( event ){
					muse.log( "setup_video_play.onStateChange data=" + event.data );
					if ( event.data == 1 ){
						muse.change_sta("playing");
						$(document).find("body").addClass("active_yt");
					}
					else if ( event.data == 2 ) muse.change_sta("paused");
					else if ( event.data == 3 ) muse.change_sta("loading");
					else if ( event.data == 0 ) muse.change_sta("ended");
				},
				onError: function( event ){
					muse.log( "setup_video_play.onError" );
				},
				onApiChange: function( event ){
					muse.log( "setup_video_play.onApiChange" );
				},
			}
		});
		*/

	},
	setup_audio_player: function( autoplay ){

		muse.log("setup_audio_player autoplay:"+autoplay);
		var streamUrl = muse.song_data.source_type == "file_r" ? muse.song_data.stream_url :
		$_home + "stream.php?play_hash="+ $_play_hash + "&source_hash=" + muse.song_data.source_hash + "&track_hash=" + muse.song_data.hash + "&track_key=" + muse.song_data.key

		if ( muse.player ){

			muse.log("setup_audio_player.player_exists");
			var newSong = muse.player.addSong({
				name: muse.song_data.title,
				artist: muse.song_data.artist_name,
				album: muse.song_data.album_title,
				url: streamUrl,
				cover_art_url: muse.song_data.cover
			});
			muse.player.skipTo( 0, newSong );
			return;

		}

		muse.log("setup_audio_player.new_player");

		if ( typeof Amplitude === "undefined" ){
			setTimeout(function(){
				muse.log("Waiting for Amplitude");
			    muse.setup_audio_player( autoplay );
			},1000);
			return;
		}

		muse.player = Amplitude;
		muse.player.init({

			preload: "auto",
			songs: [{
				name: muse.song_data.title,
				artist: muse.song_data.artist_name,
				album: muse.song_data.album_title,
				url: streamUrl,
				cover_art_url: muse.song_data.cover
			}],
			callbacks: {
				initialized: function(){
					muse.log("Amplitude.init");
					muse.pause( true );
				},
				stop: function(){
					muse.change_sta("stopped");
				},
				loadstart: function(){
					muse.change_sta("loading");
				},
				loadeddata: function(){
					muse.change_sta("loaded");
				},
				pause: function(){
					muse.change_sta("paused");
				},
				play: function(){
					muse.change_sta("played");
				},
				playing: function(){
					muse.change_sta("playing");
				},
				seeked: function(){
					muse.change_sta("seeked");
					if ( muse.pl )
					muse.pause( true );
				},
				canplay: function(){
					if ( autoplay ){
						muse.log( "setup_audio_player -> autoplay" );
						setTimeout(function(){
							muse.play();
						},100);
					}
					muse.change_sta("loaded");
				},
				ended: function(){
					if ( muse.song_time_elapsed_percentage > 90 )  muse.change_sta( "ended" );
					else muse.change_sta( "bad_ended" );
				},
				error: function(){
					muse.log( "player ERROR" );
				},
				abort: function(){
					muse.log( "player ABORT" );
				}
			}

		});

	},
	change_sta: function( sta_string ){

		muse.log( "change_sta ---> " + sta_string );

		if ( sta_string == "loading" ){
			if ( typeof pager !== "undefined" ) pager.load_start( true );
			$("body").addClass("loading_muse");
		} else {
			if ( typeof pager !== "undefined" ) pager.load_finish();
			$("body").removeClass("loading_muse");
		}

		muse.sta_playing = sta_string == "playing" || sta_string == "played" || sta_string == "seeked";
		muse.sta = sta_string;

		if ( muse.sta == "playing" )
			muse.update_dom_waves(true)

		if ( !muse.sta_playing )
			clearTimeout( muse.seeker_timer );

		muse.update_dom_buttons();

		if ( sta_string == "ended" || sta_string == "bad_ended" ){

			muse.log("ended: "+sta_string+" ,pl:"+(muse.pl?"y":"n") );

			if ( muse.pl ){
				muse.pause( true );
				muse.get_track(true,true);
				return;
			}
			else {
				muse.next_track(true);
			}

		}

		if ( sta_string == "bad_ended" && muse.song_data.paid === false )
			createNoAccessMediaModal();

		if ( typeof pager != "undeined" ){
			if ( muse.sta_playing && muse.song_data ){
				pager.song_title = muse.song_data.artist_name + " - " + muse.song_data.title;
			} else {
				pager.song_title = null;
			}
			pager.set_title();
		}


	},

	pause_play: function(){

		muse.log( "pause_play" );

		if ( muse.sta_playing ){
			muse.pause();
		}
		else {
			muse.play();
		}

	},
	play: function(){

		muse.log( "play" );

		if ( muse.sta_playing ) return;

		if ( !muse.player && !muse.yt_player ){
			muse.log( "play.getting_track" );
			muse.get_track();
		} else {
			muse.log( "play.play_source" );
			if ( muse.type == "audio" ) muse.player.play();
			else muse.yt_player.playVideo();
		}

	},
	pause: function( force ){

		muse.log( "pause:ini" );
		if ( muse.pl && force !== true ) return;
		if ( !muse.sta_playing && force !== true ) return;
		muse.log( "pause:exe" );
		if ( muse.player ) muse.player.pause();
		if ( muse.yt_player ) muse.yt_player.pauseVideo();

	},
	seek: function( second ){

		if ( second === undefined ){
			if ( !muse.player && !muse.yt_player ) return 0;
			if ( muse.type == "audio" ) return muse.player.getSongPlayedSeconds()
			else return muse.yt_player.getCurrentTime();
		}

		if ( muse.pl ) return false;
		if ( muse.song_data.paid == false )
			return;

		var second_percentage = second / muse.song_data.duration_fr * 100;
		muse.log( "seek second="+second+" ,percentage="+second_percentage );

		if ( !muse.player && !muse.yt_player ) return;
		if ( muse.type == "audio" ) muse.player.setSongPlayedPercentage( second_percentage );
		else muse.yt_player.seekTo( second );
		muse.play();

	},
	buffered: function (){

		if ( muse.type == "audio" ) return muse.player.getBuffered()
		else return 100;

	},

	set_volume: function( volume, update ){

		if ( !muse.player && !muse.yt_player )
			return;

		volume = volume > 100 ? 100 : ( volume < 0 ? 0 : volume );

		if ( muse.type == "audio" ) muse.player.setVolume( volume );
		else if ( muse.yt_ready && update === true ) muse.yt_player.setVolume( volume );

		muse.volume = volume;
		$(document).find("#player .volume .pr").css("height",muse.volume+"%")

		if ( update === true && typeof be_cli == "function" ){
			be_cli({
			    action: 'muse_set_volume',
				data: {
					volume: Math.round( volume )
				}
		    });
		}


	},
	set_repeat: function( value ){

		if ( value === true || value === false ){

			muse.repeat = value;

			be_cli({
			    action: 'muse_set_repeat',
				data: {
					value: muse.repeat ? 1 : 0
				},
			});

		}

		$(document).find("#player .repeat").removeClass("on").removeClass("off").addClass( muse.repeat ? "on" : "off" )

	},
	set_mediasession: function(){

		if ( !( 'mediaSession' in navigator ) )
			return;

		navigator.mediaSession.metadata = new MediaMetadata({
			title:  decode_htmlspecialchars( muse.song_data.title ),
			artist: decode_htmlspecialchars( muse.song_data.artist_name ),
			album:  decode_htmlspecialchars( muse.song_data.album_title ),
			artwork: [
				{ src: muse.song_data.cover, sizes: '96x96',   type: 'image/jpg' },
				{ src: muse.song_data.cover, sizes: '128x128', type: 'image/jpg' },
				{ src: muse.song_data.cover, sizes: '192x192', type: 'image/jpg' },
				{ src: muse.song_data.cover, sizes: '256x256', type: 'image/jpg' },
				{ src: muse.song_data.cover, sizes: '384x384', type: 'image/jpg' },
				{ src: muse.song_data.cover, sizes: '512x512', type: 'image/jpg' },
			]
		});

		document.onkeydown = null
		$(document).off("keydown");
		navigator.mediaSession.setActionHandler('previoustrack', null);
		navigator.mediaSession.setActionHandler('nexttrack', null);
		navigator.mediaSession.setActionHandler('play', null);
		navigator.mediaSession.setActionHandler('pause', null);

		if ( muse.type == "audio" ){

			navigator.mediaSession.setActionHandler('previoustrack', function() {
			    muse.prev_track()
			});
			navigator.mediaSession.setActionHandler('nexttrack', function() {
			    muse.next_track();
			});
			navigator.mediaSession.setActionHandler('play', function() {
			    muse.pause_play()
			});
			navigator.mediaSession.setActionHandler('pause', function() {
			    muse.pause_play()
			});


		} else {

			$(document).on("keydown",function(e){
				if ( e.key == "MediaTrackNext" ){
				    muse.next_track();
				    e.preventDefault();
				}
				if ( e.key == "MediaTrackPrevious" ){
				    muse.prev_track();
				    e.preventDefault();
				}
				if ( e.key == "MediaPlayPause" ){
				    muse.pause_play();
				    e.preventDefault();
				}
			});

		}


	},

	update_dom_data: function(){

		$(document).find("#player .song_data .cover img").attr("src",muse.song_data.cover)
		$(document).find("#player .song_data .artist_cover img").attr("src",muse.song_data.artist_image);
		$(document).find("#player .song_data .song_title span").html( "<a href='"+muse.song_data.url+"'>" + muse.song_data.title + "</a>" );
		$(document).find("#player .song_data .artist_title span").html( "<a href='"+muse.song_data.artist_url+"'>" + muse.song_data.artist_name + "</a>" );
		$(document).find("#player .song_data .album_title span").html( "<a href='"+muse.song_data.album_url+"'>" + muse.song_data.album_title + "</a>" );
		$(document).find("#player .song_data .time_cur").html( "00:00" );
		$(document).find("#player .song_data .time_all").html( muse.song_data.duration_hr );
		$(document).find("#player .song_data .progress_e").css("width",0);
		$(document).find("#player .song_data .progress_b").css("width",0);
		$(document).find(".like_dom.master").removeClass("liked");

		if ( muse.song_data.liked )
			$(document).find(".like_dom.master").addClass("liked");

		if (typeof check_wsnw !== "undefined") check_wsnw();

	},
	update_dom_waves: function( fresh ){

		fresh = fresh === true;
		if ( !muse.player && !muse.yt_player ){
			muse.log("update_dom_waves: no_player_exit");
			return;
		}
		var second = muse.seek();
		var __per = second / muse.song_time_total * 100;
		var __buffed = muse.buffered();

		if ( fresh ){
			muse.cache.lwu = null;
		}
		if ( __buffed == 100 ){
			$(document).find("#player .song_data .progress_b").addClass("loaded").css("width","100%");
		} else {
			$(document).find("#player .song_data .progress_b").removeClass("loaded").css("width",Math.round(__buffed)+"%");
		}

		$(document).find("#player .song_data .time_cur").html( _hr_seconds( Math.round( second ) ) );
		$(document).find("#player .song_data .progress_e").css("width",__per+"%");

		if ( $(document).find("#waveform.wave_"+muse.song_data.hash+" .pr").length ){
			$(document).find("#waveform.wave_"+muse.song_data.hash+" .pr").css("width",__per+"%");
		}

		muse.song_time_current = second;
		muse.song_time_elapsed_percentage = Math.ceil( __per );

		if ( muse.sta_playing ){
			muse.heard += 0.2;
			muse.seeker_timer = setTimeout( function(){
		    	muse.update_dom_waves();
	    	}, 200 );
		}

	},
	update_dom_buttons: function(){

		$(document).find(".pauseplay .mdi")
			.removeClass("mdi-pause")
			.removeClass("mdi-play")
			.removeClass("mdi-refresh")
			.removeClass("spinner")
			.addClass("mdi-play");

		$(document).find(".track_dom")
			.removeClass("playing")
			.removeClass("paused")
			.removeClass("loading");

		$(document).find(".album_dom")
			.removeClass("playing")
			.removeClass("paused")
			.removeClass("loading");

		$(document).find(".a_dom")
			.removeClass("playing")
			.removeClass("paused")
			.removeClass("loading");

		$(document).find(".pauseplay .text").text( $_texts.play );

		if ( !muse.song_data ? true : !muse.song_data.hash ) return;

		if ( muse.sta === "loading" ){
			$(document).find(".control_buttons .pauseplay .text").text( $_texts.loading );
			$(document).find(".buttons_"+muse.song_data.hash+" .pauseplay .text").text( $_texts.loading );
			$(document).find(".control_buttons .pauseplay .mdi").removeClass("mdi-play").addClass("mdi-refresh").addClass("spinner");
			$(document).find(".buttons_"+muse.song_data.hash+" .pauseplay .mdi").removeClass("mdi-play").addClass("mdi-refresh").addClass("spinner");
			$(document).find(".track_dom.track_dom_"+muse.song_data.hash).addClass("loading");
			if ( muse.song_data.from ){
				$(document).find(".a_dom.dom_"+muse.song_data.from).addClass("loading");
				$(document).find(".a_dom.dom_"+muse.song_data.from).find(".pauseplay:first .mdi").removeClass("mdi-play").addClass("mdi-refresh").addClass("spinner");
				$(document).find(".a_dom.dom_"+muse.song_data.from).find(".pauseplay:first .text").text( $_texts.loading );
			}
		}
		else if ( muse.sta_playing ){
			$(document).find(".control_buttons .pauseplay .text").text( $_texts.pause );
			$(document).find(".buttons_"+muse.song_data.hash+" .pauseplay .text").text( $_texts.pause );
			$(document).find(".control_buttons .pauseplay .mdi").removeClass("mdi-play").addClass("mdi-pause");
			$(document).find(".buttons_"+muse.song_data.hash+" .pauseplay .mdi").removeClass("mdi-play").addClass("mdi-pause");
			$(document).find(".track_dom.track_dom_"+muse.song_data.hash).addClass("playing");
			if ( muse.song_data.from ){
				$(document).find(".a_dom.dom_"+muse.song_data.from).addClass("playing");
				$(document).find(".a_dom.dom_"+muse.song_data.from).find(".pauseplay:first .mdi").removeClass("mdi-play").addClass("mdi-pause");
				$(document).find(".a_dom.dom_"+muse.song_data.from).find(".pauseplay:first .text").text( $_texts.pause );
			}
		}
		else {
			$(document).find(".control_buttons .pauseplay .text").text( $_texts.play );
			$(document).find(".buttons_"+muse.song_data.hash+" .pauseplay .text").text( $_texts.play );
			$(document).find(".control_buttons .pauseplay .mdi").addClass("mdi-play");
			$(document).find(".buttons_"+muse.song_data.hash+" .pauseplay .mdi").addClass("mdi-play");
			$(document).find(".track_dom.track_dom_"+muse.song_data.hash).addClass("paused");
			if ( muse.song_data.from ){
				$(document).find(".a_dom.dom_"+muse.song_data.from).addClass("paused");
				$(document).find(".a_dom.dom_"+muse.song_data.from).find(".pauseplay:first .mdi").addClass("mdi-play");
				$(document).find(".a_dom.dom_"+muse.song_data.from).find(".pauseplay:first .text").text( $_texts.play );
			}
		}

	}

};

$(document).on("click",".p_w",function(e){

	if ( $(this).attr("id") == "waveform" ? $(this).attr("data-hash") != muse.song_data.hash : false )
		return;

	var _wanted_per = e.offsetX / $(this).width()
	var _wanted_sec = _wanted_per * muse.song_time_total;
	muse.seek( _wanted_sec );

});
$(document).on("mouseenter","#player .volume",function(e){

	$(document).find("#player .volume").addClass("active");
	$(document).find("#player .volume .pr").css("height",muse.volume+"%")

});
$(document).on("mouseleave","#player .volume",function(e){
	$(document).find("#player .volume").removeClass("active");
});
$(document).on("click","#player .volume .sound_wrapper",function(e){

	var __y = e.pageY - $(this).offset().top;
	if ( __y < 10 ) __y = 0;
	else if ( __y > 88 ) __y = 88;
	else __y -= 10;
	var __new_volume = 100-(__y/88*100);

	muse.set_volume( __new_volume, true );

});
$(document).on("click","#player .repeat",function(e){
	muse.set_repeat( muse.repeat ? false : true );
});
$(document).on("click","#player .prev",function(e){
	muse.prev_track();
});
$(document).on("click","#player .next",function(e){
	muse.next_track();
});
$(document).on("click","#player .pauseplay",function(e){
	muse.pause_play();
});
$(document).on("click","#player .like_dom.master",function(e){
	muse.like_track();
});
$(document).on("click","#player .list.attp",function(e){
	muse.add_track_to_playlist();
});
$(document).on("click","#player .list.gq",function(e){
	muse.get_que();
});
$(document).on("click","#player .yt_handler",function(e){

	if ( $("body").hasClass("search_open") )
		close_search()

  muse.close_que();
  $("#sidebar .p.has-child.shown").removeClass("shown");

	$("body").toggleClass('active_yt')

});
$(document).on("click","#yt_buttons #move_handle",function(){
	$(document).find('.yt_wrapper').toggleClass('p2')
});
$(document).on("click","#yt_buttons #open_handle",function(){
	window.open( muse.yt_player.getVideoUrl() , '_blank' )
});
$(document).on("click","#yt_buttons #full_handle",function(){
	muse.yt_player.getIframe().requestFullscreen()
});
$(document).on("click",".que_buttons_wrapper .clear_que_handle",function(e){
	muse.clear_que()
});
$(document).on("click",".que_buttons_wrapper .shuffle_que_handle",function(e){
	muse.shuffle_que()
});
$(document).on("click",".m_add",function(){
	var type = $(this).attr("data-type") ? $(this).attr("data-type") : "track";
	var hook = $(this).attr("data-hook");
	var radio = $(this).attr("data-radio") === "1" ? true : false;
	var que_to_top = radio ? true : ( $(this).attr("data-que") === "0" ? false : true );
	muse.add( type, hook, que_to_top, radio );
});
$(document).on("click",".m_rfq",function(){
	var hook = $(this).attr("data-hook");
	muse.remove_from_que( hook );
});
$(document).on("click",".m_cq",function(){
	muse.close_que();
});
$(document).on("click",".m_like",function(){
	var hook = $(this).attr("data-hook");
	var type = "track";
	muse.like_track( hook );
});
$(document).on("click",".m_dl",function(){
	var hook = $(this).attr("data-hook");
	var type = $(this).attr("data-type") ? $(this).attr("data-type") : "track";
	muse.download_track( hook );
});
$(document).on("click",".m_dl_ini",function(){
	var hook = $(this).attr("data-hook");
	var type = $(this).attr("data-type");
	muse.download_track_ini( hook, type );
});
$(document).on("click",".m_repost",function(){
	var hook = $(this).attr("data-hook");
	muse.repost_track( hook );
});
$(document).on("click",".m_attp",function(){
	var hook = $(this).attr("data-hook");
	muse.add_track_to_playlist( hook );
});
$(document).on("click",".m_attp_a",function(){
	var hook = $(this).attr("data-hook");
	muse.add_track_to_playlist_action( hook );
});
$(document).on("click",".m_rtfp",function(){
	var hook = $(this).attr("data-hook");
	remove_track_from_playlist( hook );
});

muse.get_track( false );

function onYouTubeIframeAPIReady(){
	muse.yt_ready = true;
	muse.log( "youtube Iframe API is ready" );
}
