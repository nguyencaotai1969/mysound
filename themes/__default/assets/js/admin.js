"use strict"

Chart.defaults.global.tooltips.mode = 'x-axis';
Chart.defaults.global.legend.position = 'bottom';
Chart.defaults.global.maintainAspectRatio = false;
Chart.defaults.global.responsive = true;
Chart.defaults.global.defaultFontSize = 10;
Chart.defaults.global.legend.labels.boxWidth = 30;
Chart.defaults.global.tooltips.bodyFontSize = 11;
Chart.defaults.global.tooltips.titleFontSize = 12;

// Suggestioner
function suggest( $type, $this ){

	be_cli({

		action: 'admin_get_suggestions',
		data: {
			type: $type,
			q: $($this).val()
		},
		background: false,
		callBack: function( sta, data ){

			if ( sta ){
				clear_suggestion( $($this).attr("ID") );
		    	make_suggestion( $($this).attr("ID"), $($this), JSON.parse( data ) );
			}
			else {
				clear_suggestion( $($this).attr("ID") );
			}

		}

	});

}
function clear_suggestion( $target ){

	$.each( $(document).find(".suggestions"), function( key, dom ){

		var $dom = $(dom);
		if ( $target ){
			if ( $dom.attr("ID") != $target ){
				$dom.remove();
			}
		}
		else {
			setTimeout( function(){ $dom.remove(); }, 200 );
		}

	});

}
function make_suggestion( $target, $domTarget, $items ){

	var $html = "";
	var $html_items = "";

	$.each( $items, function( key, value ){
		$html_items += "<div class='suggestion ash' data-value='"+key+"' data-target='"+$target+"'>"+value+"</div>";
	} );

	if ( $(document).find("#target_"+$target).length > 0 ){

		$(document).find("#target_"+$target).html( $html_items );

	} else {

		$html += "<div class='suggestions' id='target_"+$target+"'>";
		$html += $html_items;
    	$html += "</div>";

    	$("body").append( $html );

		$(".suggestions").css("width",$domTarget.outerWidth()+"px").css("top",($domTarget.offset().top-$(window).scrollTop()+$domTarget.outerHeight())+"px").css("left",$domTarget.offset().left+"px");

	}

}
$(document).on("click",".ash.suggestion",function(){
	choose_suggestion(
	    $(this).attr("data-target"),
	    $(this).attr("data-value")
	);
})
function choose_suggestion( $domTarget, $value ){

	if ( $value != 0 )
	$("#"+$domTarget).val( $value );
	clear_suggestion( false );

}

// Content Album page
function delete_albums_modal( $ids ){

	$ids = $ids === undefined || $ids === null ? ids : $ids;
	if ( typeof( $ids ) == "object" ? !$ids.length : !$ids ){
		alert( "Select something first" );
		return;
	}

	ids = typeof( $ids ) == "object" ? $ids : [ $ids ];

	createModal({
		title: 'Confirm Action',
		inputs: [
			{
				label: 'New album ID',
				name: 'album',
				type: 'text',
				value: '0',
				tip: 'Where should we move tracks belonging to this album? Enter the ID of new album. Enter 0 if you wish to delete tracks. You can search by album title',
				attr: ' onInput="suggest(\'album_id\',this)" onfocusout="clear_suggestion(false)" autocomplete="off" ',
			}
		],
		buttons: [
			[ 'btn-primary', 'Confirm', 'delete_albums( getModal(true)["album"] )' ]
		]
	});

}
function delete_albums( $new_album_id ){

	be_cli({
		action: 'admin_delete_albums',
		data: {
			albums: ids.join(","),
			new_album: $new_album_id
		},
		domTarget: ".watermark",
		callBack: function( sta, data ){
			if ( sta ) window.location.reload();
		}
	});

	closeModal();

}
function edit_album_modal( $album_id ){

	var $data = $__albums[ $album_id ];

	createModal({
		title: 'Edit Album',
		inputs: [
			{
				name: 'action',
				type: 'hidden',
				value: 'admin_edit_album',
			},
			{
				name: 'ID',
				type: 'hidden',
				value: $data.ID,
			},
			{
				label: 'Title',
				name: 'title',
				type: 'text',
				value: $data.title,
			},
			{
			    type: 'select',
			    name: 'type',
			    label: 'Type',
			    value: $data.type,
			    values:  [ [ 'single', 'Single' ], [ 'studio', 'Studio' ], [ 'compilation', 'Compilation' ], [ 'mixtape', 'Mixtape' ] ],
				attr: ' onChange=" $(document).find(\'.modal\').find(\'.nartist_name\').show(); if( $(this).val() == \'compilation\' ) $(document).find(\'.modal\').find(\'.nartist_name\').hide(); "',

		    },
			{
				label: 'Cover',
				name: 'cover',
				type: 'file',
				tip: 'Select a new image if you wish to change this album\'s cover'
			},
			{
				label: 'Description',
				name: 'comment',
				type: 'textarea',
				value: $data.comment ? $data.comment.replace( /<BR>/g, '\r\n' ) : "",
			},
			{
				label: 'User ID',
				name: 'user_id',
				type: 'text',
				value: $data.user_id,
				attr: ' onInput="suggest(\'user\',this)" onfocusout="clear_suggestion(false)" autocomplete="off" ',
				tip: 'Enter user-ID or search by username',
			},
			{
			    type: 'select',
				name: 'genre',
			    value: $data.genre.code,
			    label: 'Genre',
			    values: $__genres,
			},
			{
				label: 'Artist Name',
				name: 'artist_name',
				type: 'text',
				value: $data.artist_name,
				attr: ' onInput="suggest(\'artist_name\',this)" onfocusout="clear_suggestion(false)" autocomplete="off" ',
			},
			{
				label: 'Spotify ID',
				name: 'spotify_id',
				type: 'text',
				value: $data.spotify_id,
			},
			{
				label: 'Release Time',
				name: 'time_release',
				type: 'text',
				value: $data.time_release,
			},
			{
				label: 'Price',
				name: 'price',
				type: 'text',
				value: $data.price,
			},
		],
		buttons: [
			[ 'btn-primary', 'Confirm', 'edit_album()' ]
		]
	});

}
function edit_album(){

	be_cli({
		data: new FormData( $(document).find(".modal").find("form")[0] ),
		dataType: "html",
		domTarget: ".watermark",
		hasFile: true,
		callBack: function( sta, data ){
			if ( sta ) window.location.reload();
		}
	});

}
$(document).on("click",".edit_album_handle",function(){
	var hook = $(this).attr("data-hook");
	edit_album_modal( hook );
});
$(document).on("click",".delete_album_handle",function(){
	var hook = $(this).attr("data-hook");
	delete_albums_modal( hook );
});

// Content Artist page
function delete_artists_modal( $ids ){

	$ids = $ids === undefined || $ids === null ? ids : $ids;
	if ( typeof( $ids ) == "object" ? !$ids.length : !$ids ){
		alert( "Select something first" );
		return;
	}

	ids = typeof( $ids ) == "object" ? $ids : [ $ids ];

	createModal({
		title: 'Confirm Action',
		inputs: [
			{
				label: 'New artist ID',
				name: 'artist',
				type: 'text',
				value: '0',
				tip: 'Where should we move tracks/albums belonging to this artist? Enter the ID of new artist. Enter 0 if you wish to delete tracks. You can search by artist name',
				attr: ' onInput="suggest(\'artist_id\',this)" onfocusout="clear_suggestion(false)" autocomplete="off" ',
			}
		],
		buttons: [
			[ 'btn-primary', 'Confirm', 'delete_artists( getModal(true)["artist"] )' ]
		]
	});

}
function delete_artists( $new_artist_id ){

	be_cli({
		action: 'admin_delete_artists',
		data: {
			artists: ids.join(","),
			new_artist: $new_artist_id
		},
		domTarget: ".watermark",
		callBack: function( sta, data ){
			if ( sta ) window.location.reload();
		}
	});

	closeModal();

}
function edit_artist_modal( $artist_id ){

	var $data = $__artists[ $artist_id ];

	createModal({
		title: 'Edit artist',
		inputs: [
			{
				name: 'action',
				type: 'hidden',
				value: 'admin_edit_artist',
			},
			{
				name: 'ID',
				type: 'hidden',
				value: $data.ID,
			},
			{
				label: 'Name',
				name: 'name',
				type: 'text',
				value: $data.name,
			},
			{
				label: 'Image',
				name: 'image',
				type: 'file',
				tip: 'Select a new image if you wish to change this artist image'
			},
			{
				label: 'Spotify ID',
				name: 'spotify_id',
				type: 'text',
				value: $data.spotify_id,
			},
		],
		buttons: [
			[ 'btn-primary', 'Confirm', 'edit_artist()' ]
		]
	});

}
function edit_artist(){

	be_cli({
		data: new FormData( $(document).find(".modal").find("form")[0] ),
		dataType: "html",
		domTarget: ".watermark",
		hasFile: true,
		callBack: function( sta, data ){
			if ( sta ) window.location.reload();
		}
	});

}
$(document).on("click",".edit_artist_handle",function(){
	var hook = $(this).attr("data-hook");
	edit_artist_modal( hook );
});
$(document).on("click",".delete_artist_handle",function(){
	var hook = $(this).attr("data-hook");
	delete_artists_modal( hook );
});

// Content Track page
function delete_tracks_modal( $ids ){

	$ids = $ids === undefined || $ids === null ? ids : $ids;
	if ( typeof( $ids ) == "object" ? !$ids.length : !$ids ){
		alert( "Select something first" );
		return;
	}

	ids = typeof( $ids ) == "object" ? $ids : [ $ids ];

	createModal({
		title: 'Confirm Action',
		buttons: [
			[ 'btn-primary', 'Confirm', 'delete_tracks()' ]
		]
	});

}
function delete_tracks(){

	be_cli({
		action: 'admin_delete_tracks',
		data: {
			tracks: ids.join(",")
		},
		domTarget: ".watermark",
		callBack: function( sta, data ){
			if ( sta ) window.location.reload();
		}
	});

	closeModal();

}
function new_track_modal(){
    edit_track_modal( "new" );
}
function edit_track_modal( $track_id ){

	var $data = null;
	if ( $track_id != "new" ){
		$data = $__tracks[ $track_id ];
	}
	else {
		$data = { text_data: {} };
	}


	createModal({
		title: ( $track_id == "new" ? "New" : "Edit" ) + ' Track',
		inputs: [
			{
				name: 'action',
				type: 'hidden',
				value: $track_id == 'new' ? 'admin_new_track' : 'admin_edit_track',
			},
			{
				name: 'ID',
				type: 'hidden',
				value: $data.ID,
			},
			{
				label: 'Title',
				name: 'title',
				type: 'text',
				value: $data.title,
			},
			{
				label: 'Cover',
				name: 'cover',
				type: 'file',
				tip: 'Select a new image if you wish to change this track\'s cover'
			},
			{
				label: 'User ID',
				name: 'user_id',
				type: 'text',
				value: $data.user_id,
				attr: ' onInput="suggest(\'user\',this)" onfocusout="clear_suggestion(false)" autocomplete="off" ',
				tip: 'Enter user-ID or search by username',
			},
			{
			 type: 'select',
				name: 'genre',
				value: $data.genre_code,
				label: 'Genre',
				values: $__genres,
			},
			{
				label: 'Artist Name',
				name: 'artist_name',
				type: 'text',
				value: $data.artist_name,
				attr: ' onInput="suggest(\'artist_name\',this)" onfocusout="clear_suggestion(false)" autocomplete="off" ',
			},
			{
				label: 'Featured Artists',
				name: 'artists_featured',
				type: 'text',
				value: $data.artists_featured ? $data.artists_featured.join(";") : "",
			},
            {
                label: 'Album Type',
                name: 'album_type',
                type: $track_id == "new" ? "select" : "hidden",
                value: $data.album_type,
                values:  [ [ 'single', 'Single' ], [ 'studio', 'Studio' ], [ 'compilation', 'Compilation' ], [ 'mixtape', 'Mixtape' ] ],
				attr: ' onChange=" $(document).find(\'.modal\').find(\'.nartist_name\').show(); if( $(this).val() == \'compilation\' ) $(document).find(\'.modal\').find(\'.nartist_name\').hide(); "',
            },
            {
			    type: $track_id == "new" ? 'select' : 'hidden',
				name: 'album_genre',
				value: $data.album_genre,
				label: 'Album Genre',
				values: $__genres,
			},
			{
				label: 'Album Artist Name',
				name: 'album_artist_name',
				type: 'text',
				value: $data.album_artist_name,
				attr: ' onInput="suggest(\'artist_name\',this)" onfocusout="clear_suggestion(false)" autocomplete="off" ',
			},
			{
				label: 'Album Title',
				name: 'album_title',
				type: 'text',
				value: $data.album_title,
				attr: ' onInput="suggest(\'album_title\',this)" onfocusout="clear_suggestion(false)" autocomplete="off" ',
			},
			{
				label: 'Album Order',
				name: 'album_order',
				type: 'text',
				value: $data.album_order,
			},
			{
				label: 'Spotify ID',
				name: 'spotify_id',
				type: 'text',
				value: $data.spotify_id,
			},
            {
				label: 'SoundCloud URL',
				name: 'soundcloud_url',
				type: 'hidden',
				value: $data.soundcloud_url,
			},
            {
				label: 'Youtube ID',
				name: 'youtube_id',
				type: 'hidden',
				value: $data.youtube_id,
			},
               {
				label: 'iTunes URL',
				name: 'itunes_url',
				type: 'hidden',
				value: $data.itunes_url,
			},
            {
				label: 'Bandcamp full address',
				name: 'bandcamp_id',
				type: 'hidden',
				value: $data.bandcamp_id,
			},
            {
                label: 'Site Link',
                name: 'site_link',
                type: 'hidden',
                value: $data.sitelink
            },
			{
				label: 'Price',
				name: 'price',
				type: 'text',
				value: $data.price,
			},
			{
				label: 'Duration',
				name: 'duration',
				type: 'text',
				value: $data.duration,
				tip: 'Duration in seconds'
			},
			{
				label: 'Release Time',
				name: 'time_release',
				type: 'text',
				value: $data.time_release,
			},
			{
				label: 'comment',
				name: 'text_comment',
				type: 'textarea',
				value: $data.text_data.comment,
			},
			{
				label: 'Lyrics',
				name: 'text_lyrics',
				type: 'textarea',
				value: $data.text_data.lyrics,
			},

			{
				label: 'Download Link',
				name: 'download_link',
				type: 'hidden',
				value: $data.dl_link,
				tip: 'Should this track download link redirect user to a customized url? Enter that url'
			},

		],
		buttons: [
			[ 'btn-primary', 'Confirm', 'edit_track()' ]
		]
	});

}
function edit_track(){

	be_cli({
		data: new FormData( $(document).find(".modal").find("form")[0] ),
		dataType: "html",
		domTarget: ".watermark",
		hasFile: true,
		callBack: function( sta, data ){
			if ( sta ) window.location.reload();
		}
	});

}
$(document).on("click",".edit_track_handle",function(){
	var hook = $(this).attr("data-hook");
	edit_track_modal( hook );
});
$(document).on("click",".delete_track_handle",function(){
	var hook = $(this).attr("data-hook");
	delete_tracks_modal( hook );
});
$(document).on("click",".new_track_handle",function(){
	new_track_modal();
});

// Content Genre page
function delete_genres_modal( $ids ){

	$ids = $ids === undefined || $ids === null ? ids : $ids;
	if ( typeof( $ids ) == "object" ? !$ids.length : !$ids ){
		alert( "Select something first" );
		return;
	}

	ids = typeof( $ids ) == "object" ? $ids : [ $ids ];

	createModal({
		title: 'Confirm Action',
		inputs: [
			{
				label: 'Genre',
				name: 'genre',
				type: 'text',
				value: '1',
				attr: ' onInput="suggest(\'genre_id\',this)" autocomplete="off" onfocusout="clear_suggestion(false)" ',
				tip: 'Where should we move tracks/albums belonging to this genre? Enter the ID of new genre. Enter 1 for "No-Genre"'
			}
		],
		buttons: [
			[ 'btn-primary', 'Confirm', 'delete_genres( getModal(true)["genre"] )' ]
		]
	});

}
function delete_genres( $new_genre_id ){

	be_cli({
		action: 'admin_remove_genres',
		data: {
			genres: ids.join(","),
			new_genre: $new_genre_id
		},
		domTarget: ".watermark",
		callBack: function( sta, data ){
			if ( sta ) window.location.reload();
		}
	});

	closeModal();

}
function new_genre_modal(){

	createModal({
		title: 'Create new genre',
		inputs: [
			{
				label: 'Name',
				name: 'name',
				type: 'text',
				tip: 'Name of new genre'
			}
		],
		buttons: [
			[ 'btn-primary', 'Confirm', 'new_genre( getModal(true)["name"] )' ]
		]
	});

}
function new_genre( $name ){

	be_cli({
		action: 'admin_new_genre',
		data: {
			name: $name,
		},
		domTarget: ".watermark",
		callBack: function( sta, data ){
			if ( sta ) window.location.reload();
		}
	});

}
function edit_genre_modal( genre ){

	createModal({
		title: 'Edit ' + genre.name,
		inputs: [
			{
				name: 'ID',
				type: 'hidden',
				value: genre.ID
			},
			{
				name: 'action',
				type: 'hidden',
				value: 'admin_edit_genre'
			},
			{
				label: 'Name',
				name: 'name',
				type: 'text',
				tip: 'Name of genre',
				value: genre.name
			},
			{
				label: 'Image',
				name: 'file',
				type: 'file',
				tip: 'New background image of genre. Image should have a 1.5 ratio for example . 700*350',
			}
		],
		buttons: [
			[ 'btn-primary', 'Confirm', 'edit_genre()' ]
		]
	});

}
function edit_genre(){

	be_cli({
		data: new FormData( $(document).find(".modal").find("form")[0] ),
		dataType: "html",
		domTarget: ".watermark",
		hasFile: true,
		callBack: function( sta, data ){
			if ( sta ) window.location.reload();
		}
	});

}
function recover_genre( $ID ){

	be_cli({
		action:'admin_recover_genre',
		data: {
			ID: $ID
		},
		domTarget:'.watermark',
		callBack:function(sta,data){
			if(sta)window.location.reload()
		}
	})

}
function truncate_genre( $ID ){

	be_cli({
		action:'admin_delete_genre',
		data: {
			ID: $ID
		},
		domTarget:'.watermark',
		callBack:function(sta,data){
			if(sta)window.location.reload()
		}
	})

}
$(document).on("click",".edit_genre_handle",function(){
	var hook = $(this).attr("data-hook");
	console.log( $__genres[ hook ] );
	edit_genre_modal( $__genres[ hook ] );
});
$(document).on("click",".delete_genre_handle",function(){
	var hook = $(this).attr("data-hook");
	delete_genres_modal( hook );
});
$(document).on("click",".recover_genre_handle",function(){
	var hook = $(this).attr("data-hook");
	recover_genre( hook );
});
$(document).on("click",".truncate_genre_handle",function(){
	var hook = $(this).attr("data-hook");
	truncate_genre( hook );
});
$(document).on("click",".new_genre_handle",function(){
	new_genre_modal();
});

// Content Source page
function delete_sources( $ids ){

	$ids = $ids === undefined || $ids === null ? ids : $ids;
	if ( typeof( $ids ) == "object" ? !$ids.length : !$ids ){
		alert( "Select something first" );
		return;
	}

	ids = typeof( $ids ) == "object" ? $ids : [ $ids ];

	be_cli({
		action: 'admin_delete_sources',
		data: {
			sources: ids.join(",")
		},
		domTarget: ".watermark",
		callBack: function( sta, data ){
			if ( sta ) window.location.reload();
		}
	});

}
function delete_source_waves( $ID ){

	be_cli({
		action: 'admin_delete_source_waves',
		data: {
			ID: $ID
		},
		domTarget: ".watermark",
		callBack: function( sta, data ){
			if ( sta ) window.location.reload();
		}
	});

}
function new_source_modal( $___track_id ){

    createModal({
		title: 'New Source',
		inputs: [

			{
				name: 'action',
				type: 'hidden',
				value: 'admin_new_source',
			},
			{
				label: 'Track ID',
				name: 'track_id',
				type: 'text',
                attr: ' onInput="suggest(\'track_id\',this)" onfocusout="clear_suggestion(false)" autocomplete="off" ',
				tip: 'Enter track-ID or search by title',
                value: $___track_id
			},
			{
				label: 'Type',
				name: 'type',
				type: 'select',
				values: [
				    [ "youtube", "Youtube" ],
				    [ "local", "File" ]
				]
			},
			{
				label: 'File',
				name: 'file',
				type: 'file',
				tip: 'Select the file if you wish to add a file source'
			},
			{
				label: 'Youtube',
				name: 'youtube',
				type: 'text',
				tip: 'Enter the yotube-ID if you wish to add a yotube source'
			},
			{
				label: 'Duration',
				name: 'duration',
				type: 'text',
			},

		],
		buttons: [
			[ 'btn-primary', 'Confirm', 'new_source()' ]
		]
	});

}
function new_source(){

	be_cli({
		data: new FormData( $(document).find(".modal").find("form")[0] ),
		dataType: "html",
		domTarget: ".watermark",
		hasFile: true,
		callBack: function( sta, data ){
		}
	});

}
$(document).on("click",".delete_source_handle",function(){
	var hook = $(this).attr("data-hook");
	delete_sources( hook );
});
$(document).on("click",".delete_source_waves_handle",function(){
	var hook = $(this).attr("data-hook");
	delete_source_waves( hook );
});
$(document).on("click",".new_source_handle",function(){
	var hook = $(this).attr("data-hook");
	new_source_modal( hook );
});

// Users
function delete_users_modal( $ids ){

	$ids = $ids === undefined || $ids === null ? ids : $ids;
	if ( typeof( $ids ) == "object" ? !$ids.length : !$ids ){
		alert( "Select something first" );
		return;
	}

	ids = typeof( $ids ) == "object" ? $ids : [ $ids ];

	createModal({
		title: 'Confirm Action',
		inputs: [
			{
				label: 'New user ID',
				name: 'user',
				type: 'text',
				value: '0',
				tip: 'Where should we move tracks/albums belonging to this user? Enter the ID of new user. Enter 0 if you wish to delete tracks'
			}
		],
		buttons: [
			[ 'btn-primary', 'Confirm', 'delete_users( getModal(true)["user"] )' ]
		]
	});

}
function delete_users( $new_user_id ){

	be_cli({
		action: 'admin_delete_users',
		data: {
			users: ids.join(","),
			new_user: $new_user_id,
		},
		domTarget: ".watermark",
		callBack: function( sta, data ){
			if ( sta ) window.location.reload();
		}
	});

	closeModal();

}
function connect_artist_modal( $ID ){

	createModal({
		title: 'Connect User+Artist',
		inputs: [
			{
				label: 'Artist ID',
				name: 'artist_id',
				type: 'text',
				value: '0',
				tip: 'Enter Artist-ID of this user or search by username',
				attr: ' onInput="suggest(\'artist_id\',this)" autocomplete="off" onfocusout="clear_suggestion(false)" ',
			}
		],
		buttons: [
			[ 'btn-primary', 'Confirm', 'connect_artist( '+$ID+', getModal(true)["artist_id"] )' ]
		]
	});

}
function connect_artist( $user_id, $artist_id ){

	be_cli({
		action: 'admin_user_connect',
		data: {
			user_id: $user_id,
			artist_id: $artist_id,
		},
		callBack: function ( sta, data ){
			if ( sta ) window.location.reload();
		},
		domTarget: ".watermark"
	});

}
function disconnect_artist( $user_id ){

	be_cli({
		action: 'admin_user_disconnect',
		data: {
			artist_id: "",
			user_id: $user_id,
		},
		callBack: function ( sta, data ){
			if ( sta ) window.location.reload();
		},
		domTarget: ".watermark"
	});

}
function edit_user_modal( $data ){

 	createModal({
		title:  $data ? 'Edit user' : 'Add user',
		inputs: [
			{
				name: 'action',
				type: 'hidden',
				value: 'admin_edit_user',
			},
			{
				name: 'ID',
				type: 'hidden',
				value: $data ? $data.ID : null,
			},
			{
				label: 'Group',
				name: 'group',
				type: 'select',
				value: $data ? $data.GID : null,
				values: $__groups
			},
			{
				label: 'Username',
				name: 'username',
				type: 'text',
				value: $data ? $data.username : null,
			},
			{
				label: 'Name',
				name: 'name',
				type: 'text',
				value: $data ? $data.name_raw : null,
			},
			{
				label: 'Email',
				name: 'email',
				type: 'text',
				value: $data ? $data.email : null,
			},
			{
				label: 'New Password',
				name: 'new_password',
				type: 'text',
				tip: 'Enter a new password for this user'
			},
			{
				label: 'Fund',
				name: 'fund',
				type: 'text',
				value: $data ? $data.fund : null,
			},
			{
				label: '`Paid` Expiration Date',
				name: 'time_paid_expire',
				type: 'text',
				value: $data ? $data.time_paid_expire : null,
				tip: 'Full timestamp. Example: 2020/12/30 16:20:00'
			},
			{
				label: 'Avatar',
				name: 'avatar',
				type: 'file',
			},
		],
		buttons: [
			[ 'btn-primary', 'Confirm', $data ? 'edit_user()' : 'add_user()' ]
		]
	});

}
function edit_user(){

	be_cli({
		data: new FormData( $(document).find(".modal").find("form")[0] ),
		dataType: "html",
		domTarget: ".watermark",
		hasFile: true,
		callBack: function( sta, data ){
			if ( sta ) window.location.reload();
		}
	});

}
function add_user(){
	console.log( new FormData( $(document).find(".modal").find("form")[0] ) );
}
function verify_user( $user_id ){

	be_cli({
		action: "admin_user_verify",
		data: {
			ID: $user_id
		},
		domTarget: ".watermark",
		callBack: function( sta, data ){
			if ( sta ) window.location.reload();
		}
	});

}
$(document).on("click",".edit_user_handle",function(){
	var hook = $(this).attr("data-hook");
	edit_user_modal( $__users[ hook ] );
});
$(document).on("click",".delete_user_handle",function(){
	var hook = $(this).attr("data-hook");
	delete_users_modal( hook );
});
$(document).on("click",".new_user_handle",function(){
	edit_user_modal();
});
$(document).on("click",".connect_artist_handle",function(){
	var hook = $(this).attr("data-hook");
	connect_artist_modal( hook );
});
$(document).on("click",".disconnect_artist_handle",function(){
	var hook = $(this).attr("data-hook");
	disconnect_artist( hook );
});
$(document).on("click",".verify_user_handle",function(){
	var hook = $(this).attr("data-hook");
	verify_user( hook );
});

// Users artist request
function accept_artist_request( $ID ){

	be_cli({
		action: "admin_accept_artist",
		data: {
			ID: $ID
		},
		domTarget: ".watermark",
		callBack: function( sta, data ){
			if ( sta ) window.location.reload();
		}
	})

}
function reject_artist_request( $ID ){

	be_cli({
		action: "admin_reject_artist",
		data: {
			ID: $ID
		},
		domTarget: ".watermark",
		callBack: function( sta, data ){
			if ( sta ) window.location.reload();
		}
	})

}
$(document).on("click",".accept_artist_handle",function(){
	var hook = $(this).attr("data-hook");
	accept_artist_request( hook );
});
$(document).on("click",".reject_artist_handle",function(){
	var hook = $(this).attr("data-hook");
	reject_artist_request( hook );
});

// Users comments
function delete_comments( $ids ){

	$ids = $ids === undefined || $ids === null ? ids : $ids;
	if ( typeof( $ids ) == "object" ? !$ids.length : !$ids ){
		alert( "Select something first" );
		return;
	}

	ids = typeof( $ids ) == "object" ? $ids : [ $ids ];

	be_cli({
		action: 'admin_delete_comments',
		data: {
			comments: ids.join(",")
		},
		domTarget: ".watermark",
		callBack: function( sta, data ){
			if ( sta ) window.location.reload();
		}
	});

}
function approve_comments( $ids ){

	$ids = $ids === undefined || $ids === null ? ids : $ids;
	if ( typeof( $ids ) == "object" ? !$ids.length : !$ids ){
		alert( "Select something first" );
		return;
	}

	ids = typeof( $ids ) == "object" ? $ids : [ $ids ];

	be_cli({
		action: 'admin_approve_comments',
		data: {
			comments: ids.join(",")
		},
		domTarget: ".watermark",
		callBack: function( sta, data ){
			if ( sta ) window.location.reload();
		}
	});

}
$(document).on("click",".delete_comment_handle",function(){
	var hook = $(this).attr("data-hook");
	delete_comments( hook );
});
$(document).on("click",".approve_comment_handle",function(){
	var hook = $(this).attr("data-hook");
	approve_comments( hook );
});

// Users groups
function _confirm_remove_user_group( $name, $ID ){

	createModal({
		title: "Confirm",
		content: "Do you really want to remove <i><b>"+$name+"</b></i> user group?<br>",
		buttons: [
			[ 'btn-danger', 'Confirm', 'remove_user_group("'+$ID+'")' ],
		]
	});

}
function remove_user_group( $ID ){

	be_cli({
		action: "admin_users_remove_group",
		data: {
			ID: $ID
		},
		domTarget: ".watermark",
		callBack: function( sta, data ){
			if ( sta ){
				window.location.reload();
			}
		}
	});

}
function add_new_user_group_modal(){

	createModal({

		title: 'Add new user-group',
		tip: 'Configure new user-group',
		inputs: [
			{
		    	type: 'text',
		    	name: 'name',
		    	label: 'name',
	    	},
		],
		buttons: [
			[ 'btn-primary', 'Add', 'add_new_user_group_action()' ],
		]

	});

}
function add_new_user_group_action(){

	be_cli({
		action: "admin_users_new_group",
		data: {
			name: getModal(true)['name']
		},
		domTarget: ".watermark",
		callBack: function( sta, data ){
			if ( sta ){
				window.location.reload();
				return;
			}
		}
	});

}
$(document).on("click",".remove_user_group_handle",function(){
	var hook = $(this).attr("data-hook");
	var name = $(this).attr("data-name");
	_confirm_remove_user_group( name, hook );
});
$(document).on("click",".add_user_group_handle",function(){
	add_new_user_group_modal();
});

// Users payments
function approve_payments( $ids ){

	$ids = $ids === undefined || $ids === null ? ids : $ids;
	if ( typeof( $ids ) == "object" ? !$ids.length : !$ids ){
		alert( "Select something first" );
		return;
	}
	ids = typeof( $ids ) == "object" ? $ids : [ $ids ];

	be_cli({
		action: 'admin_approve_payments',
		data: {
			payments: ids.join(",")
		},
		domTarget: ".watermark",
		callBack: function( sta, data ){
			if ( sta ) window.location.reload();
		}
	});

}
function reject_payments( $ids ){

	$ids = $ids === undefined || $ids === null ? ids : $ids;
	if ( typeof( $ids ) == "object" ? !$ids.length : !$ids ){
		alert( "Select something first" );
	    return;
	}
	ids = typeof( $ids ) == "object" ? $ids : [ $ids ];

	be_cli({
		action: 'admin_reject_payments',
		data: {
			payments: ids.join(",")
		},
		domTarget: ".watermark",
		callBack: function( sta, data ){
			if ( sta ) window.location.reload();
		}
	});

}
$(document).on("click",".approve_payment_handle",function(){
	var hook = $(this).attr("data-hook");
	approve_payments( hook );
});
$(document).on("click",".reject_payment_handle",function(){
	var hook = $(this).attr("data-hook");
	reject_payments( hook );
});

// Users artist withdrawal
function approve_withdraw( $ID ){

	be_cli({
		action: "admin_artist_withdraw_done",
		data: {
			ID: $ID
		},
		domTarget: ".watermark",
		callBack: function( sta, data ){
			if ( sta ) window.location.reload();
		}
	})

}
function reject_withdraw( $ID ){

	be_cli({
		action: "admin_artist_withdraw_remove",
		data: {
			ID: $ID
		},
		domTarget: ".watermark",
		callBack: function( sta, data ){
			if ( sta ) window.location.reload();
		}
	})

}
$(document).on("click",".approve_withdraw_handle",function(){
	var hook = $(this).attr("data-hook");
	approve_withdraw( hook );
});
$(document).on("click",".reject_withdraw_handle",function(){
	var hook = $(this).attr("data-hook");
	reject_withdraw( hook );
});

// User Reports
$(document).on("click",".dismiss_report_handle",function(){
	var hook = $(this).attr("data-hook");
	dismiss_reports( hook );
});
function dismiss_reports( $ids ){

	$ids = $ids === undefined || $ids === null ? ids : $ids;
	if ( typeof( $ids ) == "object" ? !$ids.length : !$ids ){
		alert( "Select something first" );
		return;
	}

	ids = typeof( $ids ) == "object" ? $ids : [ $ids ];

	be_cli({
		action: 'admin_dismiss_reports',
		data: {
			tracks: ids.join(",")
		},
		domTarget: ".watermark",
		callBack: function( sta, data ){
			if ( sta ) window.location.reload();
		}
	});

	closeModal();

}

// User Advertisement
$(document).on("click",".admin_ad_handle",function(){

	var action = $(this).attr("data-action");
	var hook = $(this).attr("data-hook");

	be_cli({
		action: 'admin_manage_ads',
		data: {
			hook: hook,
			sta: action
		},
		domTarget: ".watermark",
		callBack: function( sta, data ){
			if ( sta ) window.location.reload();
		}
	});

});
$(document).on("click",".admin_ad_edit_handle",function(){
	var hook = $(this).attr("data-hook");
	edit_ad_modal( hook );
});
function edit_ad_modal( $ad_id ){

	var $data = $__ads[ $ad_id ];

	if ( $data["type"] == "adsense" ){
		return edit_adsense_modal( $ad_id );
	}

	createModal({
		title: 'Edit advertisement',
		inputs: [
			{
				name: 'ID',
				type: 'hidden',
				value: $data.ID,
			},
			{
				label: 'Name',
				name: 'name',
				type: 'text',
				value: $data.name,
			},
			{
				label: 'URL',
				name: 'url',
				type: 'text',
				value: $data.url,
			},
			{
				label: 'Total funds',
				name: 'fund_total',
				type: 'text',
				value: $data.fund_total,
			},
			{
				label: 'Remaining funds',
				name: 'fund_remain',
				type: 'text',
				value: $data.fund_remain ? $data.fund_remain : "0",
			},
			{
				label: 'Spent funds',
				name: 'fund_spent',
				type: 'text',
				value: $data.fund_spent ? $data.fund_spent : "0",
			},
			{
				label: 'Funds daily limit',
				name: 'fund_limit',
				type: 'text',
				value: $data.fund_limit,
			},
			{
				label: 'Spent funds ( daily )',
				name: 'fund_spent_day',
				type: 'text',
				value: $data.fund_spent_day ? $data.fund_spent_day : "0",
			},
			{
				label: 'Placements',
				name: 'placements',
				type: 'select_multi',
				value: $data.placements,
				values: $__placements
			},
			{
				label: 'Status',
				name: 'active',
				type: 'select',
				value: $data.active,
				values: [
					[ "-1", "Removed" ],
					[ "-2", "Rejected" ],
					[ "0", "Pending" ],
					[ "1", "Active" ],
					[ "2", "Paused" ],
				]
			},
		],
		buttons: [
			[ 'btn-primary', 'Confirm', 'edit_ad()' ]
		]
	});

}
function edit_ad(){

	be_cli({
		action: 'admin_edit_ad',
		data: getModal(true),
		domTarget: ".watermark",
		callBack: function( sta, data ){
			if ( sta ) window.location.reload();
		}
	});

}

function new_adsense_modal(){
    edit_adsense_modal( "new" );
}
function edit_adsense_modal( $adID ){

	var $data = null;
	if ( $adID != "new" ){
		$data = $__ads[ $adID ];
	}
	else {
		$data = {};
	}

	createModal({
		title: 'Google Adsense',
		inputs: [
			{
				name: 'ID',
				type: 'hidden',
				value: $data.ID,
			},
			{
				label: 'Name',
				name: 'name',
				type: 'text',
				value: $data.name,
			},
			{
				label: 'Code',
				name: 'code',
				type: 'textarea',
				value: $data.code ? $data.code : "<script>........</script>",
			},
			{
				label: 'Placements',
				name: 'placements',
				type: 'select_multi',
				value: $data.placements,
				values: $__placements
			},
			{
				label: 'Status',
				name: 'active',
				type: 'select',
				value: $data.active,
				values: [
					[ "1", "Active" ],
					[ "2", "Paused" ],
				]
			},
		],
		buttons: [
			[ 'btn-primary', 'Confirm', 'edit_adsense()' ]
		]
	});

}
function edit_adsense(){

	be_cli({
		action: 'admin_edit_adsense',
		data: getModal(true),
		domTarget: ".watermark",
		callBack: function( sta, data ){
			if ( sta ) window.location.reload();
		}
	});

}
$(document).on("click",".new_adsense_handle",function(){
	new_adsense_modal();
});

// UI Language page
function __edit_language( hook, text, en_text ){

	createModal({

		title: 'Edit a language text',
		inputs: [
			{
		    	type: 'hidden',
		    	name: 'hook',
		    	label: 'hook',
				value: hook
	    	},
			{
		    	type: 'textarea',
		    	name: 'text',
		    	label: 'Text',
				tip:  '<div class="m10t">English equivalent:<br>' + escapeHtml( en_text ) + "</div>",
				value: text
	    	},
		],
		buttons: [
			[ 'btn-success', 'Save', '__edit_language_action()' ],
		]

	});

}
function __edit_language_action(){

	be_cli({
		action: "admin_edit_language",
		data: getModal(true),
		domTarget: ".watermark",
		callBack: function( sta, data ){
			if ( sta ){
				window.location.reload();
				return;
			}
		}
	});

}
function _confirm_remove_lang( $code, $title ){

	createModal({
		title: "Confirm",
		content: "Do you really want to remove <i><b>"+$title+"</b></i> language?<br>The translations that you have made won't be deleted but this language will be inaccessible<br><br>",
		buttons: [
			[ 'btn-danger', 'Confirm', 'remove_lang("'+$code+'")' ],
		]
	});

}
function remove_lang( $code ){

	be_cli({
		action:'admin_remove_language',
		domTarget:'.watermark',
		data: {
			code: $code
		},
		callBack:function( sta, data ){
			if ( sta ){
				window.location.reload()
			}
		}
	});

}
function __add_new_language_modal(){

	createModal({

		title: 'Add new language',
		tip: 'Configure new language',
		inputs: [
			{
		    	type: 'text',
		    	name: 'name',
		    	label: 'name',
	    	},
			{
		    	type: 'text',
		    	name: 'code',
		    	label: 'code',
				tip: 'ISO 639-1 code of language. en for english, es for español and etc. You can find a list <a target="_blank" href="https://en.wikipedia.org/wiki/List_of_ISO_639-1_codes">Here</a>'
	    	},
		],
		buttons: [
			[ 'btn-primary', 'Add', '__add_new_language_action()' ],
		]

	});

}
function __add_new_language_action(){

	be_cli({
		action: "admin_new_language",
		data: getModal(true),
		domTarget: ".watermark",
		callBack: function( sta, data ){
			if ( sta ){
				window.location.reload();
				return;
			}
		}
	});

}
$(document).on("click",".remove_lang_handle",function(){
	var hook = $(this).attr("data-hook");
	var name = $(this).attr("data-name");
	_confirm_remove_lang( hook, name );
});
$(document).on("click",".new_lang_handle",function(){
	__add_new_language_modal();
});
$(document).on("click",".edit_lang_handle",function(){
	var hook   = $(this).attr("data-hook");
	var val    = $(this).attr("data-val");
	var val_en = $(this).attr("data-en-val");
	__edit_language( hook, val, val_en );
});

// UI menu builder
function hook( $build ){

	if ( $build === true ){
	   $items = dom_to_json();
	   $("#builder").html(" ");
	   buildItems();
	}

	$( "#builder .item.child" ).draggable({
		revert: true
	});

	$( "#builder .item.cover" ).droppable({
		drop: dropHandle
	});

	$( "#builder .item.before" ).droppable({
		drop: sortHandle
	});

	$( "#builder" ).disableSelection();

}
function dropHandle( event, ui ) {

	var $target = event.target;
	var $handled = ui.draggable;

	if ( $($handled).attr("class").includes("cover") )
		$($handled).parent(".item.parent").remove();
	else
		$($handled).remove();

	$($target).parent(".item.parent").find(".items").append( buildItem( $($handled).data("page"), $($handled).find(".text").text(), $($handled).data("icon") ) );

	hook( true );

}
function sortHandle( event, ui ) {

	var $target = event.target;
	var $handled = ui.draggable;

	if ( $($target).attr("class").includes("cover") ){
		$("<div class='item parent p666 nochild'>"+buildItem( $($handled).data("page"), $($handled).find(".text").text(), $($handled).data("icon"), " cover child" )+"<div class='items menus'></div></div>").insertBefore($($target).parent(".item.parent"));

		var $__ss = $($handled).parent(".item.parent").find(".items .item");
		if ( $__ss.length ){
			for ( var i=0; i<$__ss.length; i++ ){
				var $__s = $__ss[i];
				if( !$($__s).attr("class").includes("before") ){
					$( buildItem( $__s.getAttribute("data-page"), $($__s).find(".text").text(), $__s.getAttribute("data-icon") ) ).appendTo($(document).find(".item.parent.p666 .items"));
				}
			}
		}

	}
	else {
		$( buildItem( $($handled).data("page"), $($handled).find(".text").text(), $($handled).data("icon") ) ).insertBefore($($target));
	}

	if ( $($handled).attr("class").includes("cover") )
		$($handled).parent(".item.parent").remove();
	else
		$($handled).remove();

	hook( true );

}
function buildItems(){

	for( var i=0; i<$items.length; i++ ){

		var $item = $items[i];
		$("<div class='item parent p"+(i*3)+" nochild'>"+buildItem( $item.page, $item.title, $item.icon, " cover child p"+((i*3)-1 ))+"<div class='items menus'></div></div>").appendTo("#builder")

		if ( $item.items !== undefined ? $item.items.length : false ){
			$( ".item.parent.p"+(i*3) ).removeClass("nochild").addClass("haschild");
			for( var z=0; z<$item.items.length; z++ ){
				var $sub_item = $item.items[z];
				$( buildItem( $sub_item.page, $sub_item.title, $sub_item.icon ) ).appendTo(".item.parent.p"+(i*3)+" .items")
			}
		}

	}

}
function buildItem( $page, $title, $icon, $class ){

	return "<div class='"+($class?$class+" item face before":"item face before")+"'></div>" + "<div class='"+($class?$class+" item face":"item face child")+"' data-page='"+($page)+"' data-icon='"+($icon)+"'><div class='text'>"+$title+"</div><span class='edit mb_cem_handle' title='edit' ></span><span class='delete mb_di_handle' title='delete'></span></div>";

}
$(document).on("click",".mb_cem_handle",function(){
	createEditModal(this);
});
$(document).on("click",".mb_di_handle",function(){
	deleteItem(this)
});
function dom_to_json(){

	var menuData = [];
	var $__ms = $("#builder .item.parent");
	for ( var a=0; a<$__ms.length; a++ ){
		var $__m = $__ms[a];
		var _m = {
			title: $($__m).find(".item.cover:not(.before) .text").text(),
			page: $($__m).find(".item.cover:not(.before)").attr("data-page"),
			icon: $($__m).find(".item.cover:not(.before)").attr("data-icon"),
			items: []
		}
		var $__ss = $($__m).find(".items .item");
		if ( $__ss.length ){
			for ( var i=0; i<$__ss.length; i++ ){
				var $__s = $__ss[i];
				if( !$($__s).attr("class").includes("before") ){
					_m.items.push({
					    title: $($__s).find(".text").text(),
			    		page: $($__s).attr("data-page"),
			    		icon: $($__s).attr("data-icon")
			    	});
				}
			}
		}
		menuData.push(_m);
	}
	return menuData;

}
function addItem( $title, $page, $icon ){

	$( "<div class='item parent p666 nochild'>" + buildItem($page,$title,$icon," cover child") + "<div class='items menus'></div></div>" ).appendTo("#builder")
	hook( true );

}
function deleteItem(e){

	if( $(e).parent().attr("class").includes("cover") ){
		$(e).parent().parent(".item.parent").remove();
	} else {
		$(e).parent(".item.child").remove();
	}

	hook( true );

}
function createSaveModal(){

	createModal({
		title: 'Save menu',
		tip: 'Choose a name. Save this menu and use it in themes',
		content: '<label>Name</label><input type="text" class="form-control" id="name" name="name" value="'+$menu_name+'"><input name="data" type="hidden" value=\''+(JSON.stringify(dom_to_json()))+'\'>',
		buttons: [
			[ 'btn-success', 'Save', 'saveMenu()' ],
		]
	});

}
function saveMenu(){

	$menu_name = $(document).find("#name").val();

	be_cli({
		action: "admin_save_menu",
		data: $(".modal form").serialize(),
		dataType: "html",
		domTarget: ".watermark"
	})

}
function createEditModal(e){

    $selected_e = e;
	var item  = $(e).parent(".item.face");
	$selected_item = item;
	var title = item.find(".text").text();
	var link  = item.attr("data-page");
	var icon  = item.attr("data-icon");

	createModal({
		title: "Edit a menu item",
		tip: "Don't forget to save the menu after editing",
		inputs: [
			{
				label: "Title",
				name: "title",
				tip: "Use # before title to make theme load text from languages",
				type: "text",
				value: title
			},
			{
				label: "Address",
				name: "addr",
				type: "text",
				value: link
			},
			{
				label: "Icon",
				name: "icon",
				type: "text",
				value: icon,
                tip: "Click <a class='btn btn-sm btn-primary mb_ish'>here</a> to select or copy the code from <a href='https://materialdesignicons.com/'>materialdesignicons.com</a> and paste it here"
			}
		],
		buttons: [
			[ 'btn-primary', 'Edit', '$($selected_item).attr("data-page",$(document).find("#addr").val());$($selected_item).attr("data-icon",$(document).find("#icon").val());$($selected_item).find(".text").text($(document).find("#title").val());closeModal();hook();' ],
		]
	});

}
$(document).on("click",".mb_ish",function(){

	$(document).find(".modal .buttons .btn-primary").click();
	createIconModal()

});
function createIconModal(){

	createModal({
		title: "Select an icon",
		inputs: [
			{
				label: "Search",
				name: "title",
				type: "text",
				attr: "onkeydown='createIconModalContent($(this).val())' onpaste='createIconModalContent($(this).val())' "
			},
		],
		content: "<div id='icons' class='icons_wrapper'></div>",
		buttons: []
	});

	createIconModalContent();

}
function createIconModalContent( $search ){

	var str = "";
	$.each( getIconList(), function( k, v ){
		if ( $search ? !v.includes( $search ) : false )
			return;
		str += "<span class='mdi mdi-"+v+"'></span>";
	});
	$(document).find("#icons").html( str );
	$(document).off("click","#icons .mdi");
	$(document).on("click","#icons .mdi",function(e){
		var select_icon = $(this).attr("class").substr( 8 );
        $selected_item.attr("data-icon",select_icon);
        closeModal();
        createEditModal( $selected_e );
	});

}
function _confirm_remove_menu_group( $title ){

	createModal({
		title: "Confirm",
		content: "Do you really want to remove <i><b>"+$title+"</b></i> menu group?<br><b>Make sure</b> theme is not using this menu group <b>before</b> removing it<br><br>",
		buttons: [
			[ 'btn-danger', 'Confirm', 'remove_menu_group("'+$title+'")' ],
		]
	});

}
function remove_menu_group( $title ){

	be_cli({
		action: "admin_remove_menu",
		data: {
			name: $title
		},
		domTarget: ".watermark",
		callBack: function( sta, data ){
			if ( sta ){
				window.location.reload();
			}
		}
	});

}
$(document).on("click",".remove_menu_handle",function(){
	var hook = $(this).attr("data-name");
	_confirm_remove_menu_group( hook );
});
$(document).on("click",".add_menu_item_handle",function(){
	addItem('title','page','card')
});
$(document).on("click",".save_menu_handle",function(){
	createSaveModal()
});

// UI page builder
function __hook( $reset ){

	if ( $reset === true ){

	   $__pageWidgets = __translate_doms_to_data();
	   $("#builder .row").html(" ");
	   __translate_data_to_doms();

	}

	$( "#builder .row .item.child .move" ).draggable({
		revert: true,
		start: function(){
			$("#builder").addClass("dragging");
			$(this).parent(".item.cover").addClass("being_dragged");

		},
		stop: function(){
			$("#builder").removeClass("dragging");
			$(this).parent(".item.cover").removeClass("being_dragged");
		},
	});
	$( "#builder .row .item.before" ).droppable({
		drop: __sortHandle
	})
	$( "#builder .row" ).disableSelection();
	$("[data-toggle=tooltip]").tooltip({ boundary: 'window' })

	$(document).find(".tooltip").remove();

}
function __sortHandle( event, ui ) {

	var $target = event.target;
	var $handled = ui.draggable.parent(".item.cover");

	$( __translate_data_to_dom( $($handled).attr("id") ) ).insertBefore( $($target) );

	$($handled).remove();
	__hook( true );

}
function __translate_data_to_doms(){

	if ( !Object.keys( $__pageWidgets ).length ) return;

  for ( var wid in $__pageWidgets ){
		$("#builder .row").append(
			__translate_data_to_dom( wid )
		);
	}

}
function __translate_data_to_dom( $wid ){

	var $dom_data = $__pageWidgets[ $wid ];
	var $type = $dom_data['type'];
	var $sett = $dom_data['sett'];

	var $__display_type = $type.split("_");
	$__display_type = $__display_type[ $__display_type.length - 1 ];
	$__display_type = $type == "spotify" && $sett["type"] ? $sett["type"] : $__display_type;

	var $__display_size  = $sett["size"] ? $sett["size"] : null;
	var $__display_cols  = $sett["columns"] ? $sett["columns"] : null;
	var $__display_rows  = $sett["rows"] ? $sett["rows"] : null;
	var $__display_limit = $sett["limit"] ? $sett["limit"] : null;
	var $__display_width = $sett["width"] ? $sett["width"] : 12;
	$__display_limit = $type == "genre_slider" ? 10 : $__display_limit;
	$__display_size  = $type == "genre_slider" || $type == "artist_slider" ? "medium" : $__display_size;

	var $__display_html = "<div class='display type_"+$type+" display_"+$__display_type+" size_"+$__display_size+" rows_"+$__display_rows+" cols_"+$__display_cols+" '>";
	if ( $__display_type == "slider" ? $__display_size && $__display_rows && $__display_limit : false ){

		$__display_html += "<div class='display_slider'>";
		for( var $row=1; $row<=$__display_rows; $row++ ){
			$__display_html += "<div class='display_slider_row'>";
			for( var $i=1; $i<=$__display_limit/$__display_rows; $i++ ){
				$__display_html += "<div class='display_slider_item display_item'><div class='display_slider_cover display_cover'></div><div class='display_slider_text display_text'></div></div>";
			}
			$__display_html += "</div>";
		}
		$__display_html += "</div>";

	}
	if ( $__display_type == "list" ? $__display_cols && $__display_limit : false ){

		$__display_html += "<div class='display_list'>";
		for( var $row=1; $row<=$__display_cols; $row++ ){
			$__display_html += "<div class='display_list_col'>";
			for( var $i=1; $i<=$__display_limit/$__display_cols; $i++ ){
				$__display_html += "<div class='display_list_item display_item'><div class='display_list_cover display_cover'></div><div class='display_list_text display_text'></div></div>";
			}
			$__display_html += "</div>";
		}
		$__display_html += "</div>";

	}
	if ( $__display_type == "table" ? $__display_limit : false ){

		$__display_html += "<div class='display_table'>";
		$__display_html += "<div class='display_table_head'></div>";
		for( var $i=1; $i<=$__display_limit; $i++ ){
			$__display_html += "<div class='display_table_item display_item'><div class='display_table_cover display_cover'></div><div class='display_table_text display_text'></div></div>";
		}
		$__display_html += "</div>";

	}

	$__display_html += "</div>";

	return "" +
	     "<div class='col-12 col-lg-"+$__display_width+"'>" +
	       "<div class='item face before cover'></div>" +
		   "<div class='p666'>" +
	       "<div class='item face cover child type_"+$type+" display_"+$__display_type+"' id='"+$wid+"'>" +
		     "<div class='move' data-toggle='tooltip' title='Move this widget'><span class='mdi mdi-drag-variant'></span></div>" +
		     "<div class='text'><i>[ "+$type+" ]</i>"+$sett.title+"</div>" +
		     $__display_html +
		     "<div class='buttons'>" +
		       "<span class='edit pb_hei' data-toggle='tooltip' title='Edit'></span>" +
		       "<span class='copy pb_hci' data-toggle='tooltip' title='Copy'></span>" +
		       "<span class='delete pb_hdi' data-toggle='tooltip' title='Delete'></span>" +
		     "</div>" +
		   "</div>" +
		   "</div>" +
	     "</div>";

}
function __translate_doms_to_data(){

	var items = $(".item.child");
	var itemsDatas = {};
	for ( var i=0; i<items.length; i++ ){

		var item = $(items[i]);
		var itemData = __translate_dom_to_data( item, false );
		itemsDatas[ itemData.sett.wid ] = itemData;

	}

	return itemsDatas;

}
function __translate_dom_to_data( dom, it ){

	var __wid  = dom.attr("id");
	var __data = $__pageWidgets[ __wid ];

	$__pageWidgets[ __wid ].sett.title = $("<div>"+__data.sett.title+"</div>").text()

	return {
		type: __data.type,
		sett: __data.sett,
	}

}
function __handler_clicked_new_item(){

	createModal({
		title: 'Creating new page-element',
		tip: 'Type in a title and choose element type',
		inputs: [
			{
				type: 'text',
				name: 'title',
				label: 'Title',
			},
			{
				type: 'select',
				name: 'type',
				label: 'Type',
				values: [
					[ 'album_slider', 'Album Slider' ],
					[ 'album_table', 'Album Table' ],
					[ 'album_list', 'Album List' ],
					[ 'track_slider', 'Track Slider' ],
					[ 'track_table', 'Track Table' ],
					[ 'track_list', 'Track List' ],
					[ 'artist_slider', 'Artist Slider' ],
					[ 'spotify', 'Spotify Track Playlist' ],
					[ 'genre_slider', 'Genre Slider' ],
					[ 'playlist_slider', 'Playlist Slider' ],
					[ 'user_slider', 'User Slider' ],
					[ 'html', 'HTML or Text' ],
					[ 'pl', 'Advertisement Place' ],
				]
			},
		],
		buttons: [
			[ 'btn-primary', 'Add', '__dom_make_item( $(".modal").find("#title").val(), $(".modal").find("#type").val(), true )' ],
		]
	});

}
function __handler_edit_item( editdom ){

	var __data = __translate_dom_to_data( $(editdom).parents('.item') );
	var __groups = {
		a: 'General',
		b: 'Design',
		c: 'Content',
	};

	var __inputs = [

		{
			type: 'text',
			name: 'title',
			label: 'Title',
			value: __data.sett.title,
			tip: 'If you wish to make translatable titles, instead of writing a name like "Most Popular" use "#most_popular" then enter the real title in Language-Editor for every language',
			group: "a",
		},

		{
			type: 'text',
			name: 'linked',
			label: 'Linked page',
			value: __data.sett.linked,
			group: "a",
		},

		{
			type: 'select',
			name: 'width',
			label: 'Width',
			value: __data.sett.width ? __data.sett.width : 12,
			values: [
				[ "12", "Full" ],
				[ "6", "Half" ],
			],
			group: "b",
		},

	];

	var data_target_type = __data.type == "spotify" ? "spotify" : __data.type.split("_")[0];
	var data_widget_type = __data.type == "spotify" ? "spotify" : __data.type.split("_")[1];

	// Pagination Feature
	if ( [ "track", "album", "artist", "spotify", "user", "playlist" ].includes( data_target_type ) ){

		__inputs.push({
			type: 'select',
			name: 'pagination',
			label: 'Pagination',
			value: __data.sett.pagination,
			values: [
				[ "0", 'Off' ],
				[ "1", 'On' ],
			],
			group: "a",
		});

	}

	// Target Types
	if ( data_target_type == 'spotify' ){

		__inputs.push({
			type: 'text',
			name: 'id',
			label: 'Playlist ID <a class="btn btn-sm btn-primary pb_hss" data-target="'+__data.sett.wid+'">Search for playlists</a>',
			tip: '<b>Save your changes before starting the search</b>',
			value: __data.sett.id,
			group: "c",
		});

		__inputs.push({
			type: 'select',
			name: 'type',
			label: 'Widget Type',
			values: [
				[ 'slider', 'Track Slider' ],
				[ 'list', 'Track List' ],
				[ 'table', 'Track Table' ]
			],
			value: __data.sett.type,
			tip: 'Also enter Row & Size for slider<br>Also enter Columns for List',
			group: "b",
		});

	}
	if ( data_target_type == "album" ){

		__inputs.push({
			type: 'select_multi',
			name: 'album_type',
			label: '[filter] Album type',
			values: [
				[ 'all', 'All' ],
				[ 'single', 'Single' ],
				[ 'mixtape', 'Mixtape' ],
				[ 'compilation', 'Compilation' ],
				[ 'studio', 'Studio' ],
			],
			value: __data.sett.album_type ? __data.sett.album_type : "all",
			group: "c",
		});

	}
	if ( data_target_type == "artist" ){

		__inputs.push({
			type: 'select',
			name: 'artist_verified',
			label: '[filter] Verified',
			values: [
				[ 'all', 'All' ],
				[ 'yes', 'Verified Only' ],
				[ 'no', 'Un-Verified Only' ],
			],
			value: __data.sett.artist_verified ? __data.sett.artist_verified : "all",
			group: "c",
		});

	}

	// Source && Genre filter ( album && track )
	if ( [ "track", "album" ].includes( data_target_type ) ){

		__inputs.push({
			type: 'select',
			name: 'source',
			label: '[filter] Source',
			values: [
				[ 'all', 'All' ],
				[ 'youtube', 'Youtube only' ],
				[ 'local', 'Local only' ]
			],
			value: __data.sett.source,
			group: "c",
		});

		__inputs.push({
			type: 'select',
			name: 'price',
			label: '[filter] Price',
			values: [
				[ 'all', 'All' ],
				[ 'free', 'Free' ],
				[ 'priced', 'Priced' ]
			],
			value: __data.sett.price,
			group: "c",
		});

		__inputs.push({
			type: 'select_multi',
			name: 'genre',
			label: '[filter] Genre',
			values: $__genres,
			value: __data.sett.genre ? __data.sett.genre : "all",
			group: "c",
		});

		__inputs.push({
			type: 'text',
			name: 'user_id',
			label: '[filter] User ID',
			value: __data.sett.user_id,
			tip: 'If you want to display items from a certain user, enter that user ID here',
			group: "c",
		});

	}

	// Widget Types
	if ( data_widget_type == "slider" || data_widget_type == "spotify" ){

		__inputs.push({
			type: 'select',
			name: 'size',
			label: 'Size',
			values: [
				[ 'small', 'Small' ],
				[ 'medium', 'Medium' ],
				[ 'large', 'Large' ],
			],
			value: __data.sett.size,
			group: "b",
		});

		__inputs.push({
			type: 'select',
			name: 'rows',
			label: 'Rows',
			values: [
				[ '1', '1' ],
				[ '2', '2' ],
				[ '3', '3' ],
				[ '4', '4' ],
				[ '5', '5' ],
				[ '6', '6' ],
			],
			value: __data.sett.rows,
			group: "b",
		});

	}
	if ( data_widget_type == "list"   || data_widget_type == "spotify" ){

		__inputs.push({
			type: 'select',
			name: 'columns',
			label: 'Columns',
			values: [
				[ '1', '1' ],
				[ '2', '2' ],
				[ '3', '3' ],
			],
			value: __data.sett.columns,
			group: "b",
		});

	}

	// HTML widget
	if ( data_target_type == "html" ){

		__inputs.push({
			type: 'textarea',
			name: 'html',
			label: 'HTML code OR pure text',
			value: __data.sett.html,
			group: "c",
		});

	}

	// Advertisement widget
	if ( data_target_type == "pl" ){

		__inputs.push({
			type: 'hidden',
			name: 'pl_code',
			value: __data.sett.pl_code,
		});

		__inputs.push({
			type: 'select',
			name: 'banner_size',
			label: 'Size',
			tip: 'Approximate width*height (px) of this widget for a banner',
			value: __data.sett.banner_size,
			group: "c",
			values: $__banner_sizes
		});

		__inputs.push({
			type: 'text',
			name: 'banner_pl_name',
			label: 'Detail',
			tip: 'Short detail about this ad placement. Example: Index page - under `Top Artists`.<br><b>Detail is like ID of this ad place, no two ID should be same, make sure you enter different detail for each advertisement place</b>',
			value: __data.sett.banner_pl_name,
			group: "c",
		});

	}

	// Order_By Option
	if ( data_target_type == "track" ){

		__inputs.push({
			type: 'select',
			name: 'sort',
			label: 'Sort By',
			values: [
				[ 'title', 'Title' ],
				[ 'spotify_hits', 'Spotify popularity score' ],
				[ 'play_full', 'Most played' ],
				[ 'play_skip', 'Most skipped' ],
				[ 'play_full_m', 'Most played monthly' ],
				[ 'play_skip_m', 'Most skipped monthly' ],
				[ 'views', 'Most viewed' ],
				[ 'likes', 'Most liked' ],
				[ 'reposts', 'Most reposted' ],
				[ 'comments', 'Most commented' ],
				[ 'playlisteds', 'Most added to playlist' ],
				[ 'downloads', 'Most downloaded' ],
				[ 'purchased', 'Most purchased' ],
				[ 'time_release', 'Release time' ],
				[ 'time_play', 'Play time' ],
				[ 'time_add', 'Creation time' ],
			],
			value: __data.sett.sort,
			group: "c",
		});

	}
	if ( data_target_type == "album" ){

		__inputs.push({
			type: 'select',
			name: 'sort',
			label: 'Sort By',
			values: [
				[ 'title', 'Title' ],
				[ 'spotify_hits', 'Spotify popularity score' ],
				[ 'play_full', 'Most played' ],
				[ 'play_skip', 'Most skipped' ],
				[ 'play_full_m', 'Most played monthly' ],
				[ 'play_skip_m', 'Most skipped monthly' ],
				[ 'views', 'Most viewed' ],
				[ 'time_release', 'Release time' ],
				[ 'time_play', 'Play time' ],
				[ 'time_add', 'Creation time' ],
			],
			value: __data.sett.sort,
			group: "c",
		});

	}
	if ( data_target_type == "artist" ){

		__inputs.push({
			type: 'select',
			name: 'sort',
			label: 'Sort By',
			values: [
				[ 'name', 'Name' ],
				[ 'spotify_hits', 'Spotify popularity score' ],
				[ 'play_full', 'Most played' ],
				[ 'play_skip', 'Most skipped' ],
				[ 'play_full_m', 'Most played monthly' ],
				[ 'play_skip_m', 'Most skipped monthly' ],
				[ 'views', 'Most viewed' ],
				[ 'time_play', 'Play time' ],
				[ 'time_add', 'Creation time' ],
			],
			value: __data.sett.sort,
			group: "c",
		});

	}

	if ( data_target_type == "playlist" ){

		__inputs.push({
			type: 'select',
			name: 'sort',
			label: 'Sort By',
			values: [
				[ 'name', 'Name' ],
				[ 'likes', 'Likes' ],
				[ 'followers', 'Subscribers' ],
				[ 'views', 'Views' ],
				[ 'time_add', 'Creation time' ],
				[ 'time_update', 'Update time' ],
			],
			value: __data.sett.sort,
			group: "c",
		});

	}

	if ( data_target_type == "user" ){

		__inputs.push({
			type: 'select',
			name: 'sort',
			label: 'Sort By',
			values: [
				[ 'followers', 'Followers' ],
				[ 'followings', 'Followings' ],
				[ 'likes', 'Likes' ],
				[ 'reposts', 'Reposts' ],
				[ 'comments', 'Comments' ],
				[ 'comments_likes', 'Comments received likes' ],
				[ 'comments_replied', 'Comments received replies' ],
				[ 'media_comments', 'Medias received comments' ],
				[ 'media_likes', 'Medias received likes' ],
				[ 'media_uploads', 'Uploaded Medias' ],
				[ 'playlists', 'Playlists' ],
				[ 'playlists_likes', 'Playlists received likes' ],
				[ 'playlists_followers', 'Playlists subscribers' ],
				[ 'time_add', 'Sign up date' ],
			],
			value: __data.sett.sort,
			group: "c",
		});

	}

	// Limit
	if ( data_target_type != "genre" && data_target_type != "html" && data_target_type != "pl" ){

		__inputs.push({
			type: 'text',
			name: 'limit',
			label: 'Limit',
			value: __data.sett.limit,
			group: "b",
		});

	}

	createModal({

		title: 'Editing page-element',
		inputs: __inputs,
		groups: __groups,
		buttons: [
			[ 'btn-primary', 'Edit', '__dom_edit_item("'+__data.sett.wid+'")' ],
		]

	});

	$("#album_type").chosen({max_selected_options: 5});
	$("#genre").chosen({max_selected_options: 3});

}
function __handler_spotify_searcher( widID ){

	closeModal();
	createModal({

		title: 'Searching for spotify playlist',
		inputs: [
			{
				type: 'text',
				name: 'query',
				label: 'Eenter a query and search spotify for it',
			}
		],
		buttons: [
			[ 'btn-primary', 'Search', '__dom_search_spotify("'+widID+'")' ],
		],
		content: "<div class='modalResult'></div>"

	});

}
function __handler_spotify_selector( widID, ID ){

	var $__u_data = getModal(true);
	var $__d_data = __translate_dom_to_data( $("#"+widID) );

	var $__type  = $__d_data.type;
	var $__title = $__d_data.title;
	var $__sett  = $__d_data.sett;
	$__sett.id = ID;

	$("#"+widID).parent(".p666").html( __translate_data_to_dom( widID ) );
	closeModal();
	$("#"+widID).find("span.edit").click();

}
function __handler_save_page(){

	createModal({

		title: 'Saving page build',
		tip: 'Save the page you just modified',
		inputs: [
			{
				type: 'text',
				name: 'name',
				label: 'Name',
				tip: 'Page name only containing a-z, numbers and underline',
				value: $__pageName
			},
			{
				type: 'text',
				name: 'url',
				tip: $_home + 'Your_Chosen_Link',
				label: 'Link',
				value: $__pageUrl
			},
		],
		buttons: [
			[ 'btn-success', 'Save', '__finalize_edit()' ],
		]

	});

}
function __finalize_edit(){

	var modal_data = getModal( true );

	be_cli({
		domTarget: ".watermark",
		action: "admin_save_page",
		data: {
			name: modal_data.name,
			url: modal_data.url,
			data: JSON.stringify( __translate_doms_to_data() )
		},
		callBack: function( sta, data ){
			if ( sta ){
				$__pageName = modal_data.name;
				$__pageUrl  = modal_data.url;
				history.replaceState( null, document.title, $_home + "admin_page_editor?name=" + $__pageName );
			}
		}
	});

}
function __dom_edit_item(e){

	var $__d_data = __translate_dom_to_data( $("#"+e) );
	var $__type  = $__d_data.type;
	var $__u_data = null;

	if ( $__type === "html" )
		$__u_data = getModal(true);
	else
		$__u_data = getModal(true,true);

	var $__sett  = $__u_data;
	$__sett.wid = $__d_data.sett.wid;
	$__sett.title = $("<div>"+$__sett.title+"</div>").text()

	$__pageWidgets[ $__d_data.sett.wid ][ 'sett' ] = $__u_data;

	$("#"+e).parent(".p666").html( __translate_data_to_dom( $__d_data.sett.wid ) );

	__hook( true );
	closeModal();
	warn_user();

}
function __dom_make_item( title, type, open, sett ){

	var new_wid = Math.random().toString( 36 ).substr( 2, 8 );

	sett = sett ? sett : { limit: 10 }
	sett.title = title;
	sett.wid = new_wid;

	$__pageWidgets[ new_wid ] = {
		type: type,
		sett: sett
	};

	$( __translate_data_to_dom( new_wid ) ).appendTo("#builder .row")
	__hook( true );
	closeModal();

	if ( open === true ){
		$(document).find(".col-12:last-child").find(".edit").click()
	}

}
function __dom_remove_item(e){

	$(e).parents(".item").remove();
	__hook( true );

}
function __dom_copy_item(e){

	var $__d_data = __translate_dom_to_data( $(e).parents(".item") );
	__dom_make_item( $__d_data.sett.title + " copy", $__d_data.type, false, Object.assign( {}, $__d_data.sett ) );
	$("html, body").animate({ scrollTop: $(document).height()-$(window).height() }, 300);

}
function __dom_search_spotify(widID){

	var data = getModal( true );
	data.widID = widID;

	be_cli({

		action: 'admin_save_page_snoop_spotify',
		data: data,
		domTarget: ".modalResult"

	});

}
function warn_user(){

	$(".warn_wrapper").html("<div class='alert alert-danger alert-warn'>Don't forget to save the page</div>");

}
function _confirm_remove_page( $ID, $name ){

	createModal({
		title: "Confirm",
		content: "Do you really want to remove <i><b>"+$name+"</b></i> page build?<br><br>",
		buttons: [
			[ 'btn-danger', 'Confirm', 'remove_page("'+$ID+'")' ],
		]
	});

}
function remove_page( $ID ){

	be_cli({
		action:'admin_remove_page',
		domTarget:'.watermark',
		data: {
			ID: $ID
		},
		callBack:function( sta, data ){
			if ( sta ){
				window.location.reload()
			}
		}
	});

}
$(document).on("click",".remove_page_handle",function(){
	var hook = $(this).attr("data-hook");
	var name = $(this).attr("data-name");
	_confirm_remove_page( hook, name );
});
$(document).on("click",".index_page_handle",function(){

	var hook = $(this).attr("data-hook");

	be_cli({
		action:'admin_index_page',
		domTarget:'.watermark',
		data: {
			ID: hook
		},
		callBack:function( sta, data ){
			if ( sta ){
				window.location.reload()
			}
		}
	});

});
$(document).on("click",".new_page_handle",function(){
	__handler_clicked_new_item()
});
$(document).on("click",".save_page_handle",function(){
	__handler_save_page();
});
$(document).on("click",".aspss_handle",function(){
	var $hook  = $(this).attr("data-hook");
	var $widID = $(this).attr("data-widget-id");
	__handler_spotify_selector( $widID, $hook );
});
$(document).on("click",".pb_hss",function(){
	__handler_spotify_searcher( $(this).attr("data-target") )
});
$(document).on("click",".pb_hei",function(){
	__handler_edit_item(this);
});
$(document).on("click",".pb_hci",function(){
	__dom_copy_item(this);
});
$(document).on("click",".pb_hdi",function(){
	__dom_remove_item(this);
});

// Tools widget updater
function update_widget(){

	add_log( "===================" );
	if ( !$widgets.length ){
		add_log( "No widgets to update. Nothing to do!" );
		return;
	}
	var $ID = $widgets.shift();
	add_log( "Updating spotify widget ID:" + $ID );

	be_cli({
		action: "admin_tool_update_widget",
		data: {
			ID: $ID
		},
		domTarget: ".watermark",
		callBack: function( sta, data ){

			if ( sta ){
				add_log("<b>Successfully</b> updated widget ID:"+$ID );
				add_log( "===> Result: " + data );
			} else {
				add_log("<b>Failed</b> to update widget ID:"+$ID);
				add_log( "===> Error: " + data );
			}

			update_widget()

		}
	});

}
function add_log( $string ){
	$(".logs").append( "<div class='log'>" + $string + "</div>" );
}

// Tools translator
function translate($__lang){

	if ( !$ids.length ) return;
	var $ID = $ids.shift();

	be_cli({
		action: 'admin_tools_translate',
		domTarget: '.watermark',
		data: {
			ID: $ID,
			code: $__lang
		},
		callBack: function( sta, data ){

			if ( !sta ){
				if ( data == "finished" ) return;
				alert("Something went wrong. Retry. " + data );
				return;
			}

			$("#logs").append("<div class='log'>"+data+"</div>");
			setTimeout(function(){
				translate($__lang);
			},5000)

		}
	});
}

// Tools cleaner
var cleaner_cache = {};
function runCleanerJob( $type, $jobs, thePromise ){

	var promise = thePromise ? thePromise : $.Deferred();
	var $job = $jobs.shift();

	be_cli({
		action: "admin_tool_cleaner_job",
		data: {
			type: $type,
			job: $job
		},
		callBack_param: promise,
		callBack: function( sta, data, $promise ){

			if ( $type == "query" )
			$(document).find("#cleaner_logs").append( $job + "<BR>" );

			else
			$(document).find("#cleaner_logs").append( "Cleaning user-upload cache files from " + $job + "<BR>" );

			if ( $jobs.length )
			runCleanerJob( $type, $jobs, $promise );

			else
			$promise.resolve();

		}
	});

	return promise;

}
$(document).on("click","#cleaner_handler",function(){

	$(document).find("#cleaner_logs").html("Cleaning in process. Don't close this page please<br><br>");

	var queries = ["TRUNCATE `_curl_cache`","TRUNCATE `_debug`","TRUNCATE `_emails`","TRUNCATE `_user_downloads`","DELETE FROM _hits WHERE time_add < SUBDATE( now(), INTERVAL 1 YEAR )","DELETE FROM _user_sessions WHERE active = 0 OR time_update < SUBDATE( now(), INTERVAL 3 MONTH )","DELETE FROM _user_uploads WHERE time_add < SUBDATE( now(), INTERVAL 1 DAY )","OPTIMIZE TABLE `_blocked_ips`","OPTIMIZE TABLE `_curl_cache`","OPTIMIZE TABLE `_debug`","OPTIMIZE TABLE `_emails`","OPTIMIZE TABLE `_hits`","OPTIMIZE TABLE `_langs`","OPTIMIZE TABLE `_m_albums`","OPTIMIZE TABLE `_m_artists`","OPTIMIZE TABLE `_m_genres`","OPTIMIZE TABLE `_m_relations`","OPTIMIZE TABLE `_m_sources`","OPTIMIZE TABLE `_m_tracks`","OPTIMIZE TABLE `_m_tracks_data`","OPTIMIZE TABLE `_setting_admin`","OPTIMIZE TABLE `_setting_ads`","OPTIMIZE TABLE `_setting_ads_placements`","OPTIMIZE TABLE `_setting_menu`","OPTIMIZE TABLE `_setting_page`","OPTIMIZE TABLE `_setting_page_widgets`","OPTIMIZE TABLE `_setting_theme`","OPTIMIZE TABLE `_users`","OPTIMIZE TABLE `_user_actions`","OPTIMIZE TABLE `_user_artist_reqs`","OPTIMIZE TABLE `_user_comments`","OPTIMIZE TABLE `_user_downloads`","OPTIMIZE TABLE `_user_groups`","OPTIMIZE TABLE `_user_heard`","OPTIMIZE TABLE `_user_playlists`","OPTIMIZE TABLE `_user_playlists_relations`","OPTIMIZE TABLE `_user_purchases`","OPTIMIZE TABLE `_user_relations`","OPTIMIZE TABLE `_user_reports`","OPTIMIZE TABLE `_user_sessions`","OPTIMIZE TABLE `_user_transaction`","OPTIMIZE TABLE `_user_uploads`"];

	runCleanerJob( "query", queries ).done(function(){
		console.log( "Database Queries Done" );
		runCleanerJob( "folder", $__uploadingDirsNames ).done(function(){
			console.log( "Cleaning Files Done" );

			$(document).find("#cleaner_logs").append("<div style='font-size:14pt; margin-top:30px'>All done!</div>");
		});
	});

});

// Setting
function save_notification_form(){

	var $data = {
		ua_acts: null,
		ua_feeds: null,
		ua_nots: null,
		ua_emails: null,
		admin_ids: $(document).find("[name=not_adids]").val()
	};

	var $actions = {};
	$(".box.nots input[type=checkbox]:checked").each(function(e){
		var $input_name_splits = $(this).attr("name").split("_");
		var $type = $input_name_splits[1];
		var $sect = $input_name_splits[0];
		if ( $actions[ $sect ] === undefined )
		$actions[ $sect ] = [];
		$actions[ $sect ].push( $type );
	});

	if ( $actions["feed"] ) $data["ua_feeds"] = $actions["feed"].join(",");
	if ( $actions["act"] ) $data["ua_acts"] = $actions["act"].join(",");
	if ( $actions["not"] ) $data["ua_nots"] = $actions["not"].join(",");
	if ( $actions["email"] ) $data["ua_emails"] = $actions["email"].join(",");

	be_cli({
		action: 'admin_save_setting_notifications',
		data: $data,
		domTarget: '.watermark',
		callBack: function( sta, data ){
			console.log( sta, data );
		}
	});

}

var ids = [];
$(document).on("click","[type=checkbox]",function(e){

	if ( $(this).val().substr( 0, 2 ) == "ID" ){

		var __ID = $(this).val().substr( 2 );

	    if ( this.checked ){
		    if ( !ids.includes( __ID ) ) ids.push( __ID );
	    } else {
		    var index = ids.indexOf( __ID );
		    if ( index > -1 ) ids.splice( index, 1 );
	    }

	    if ( ids.length ) $("table tfoot .btn.hoi").css("opacity","1");
	    else $("table tfoot .btn.hoi").css("opacity","0.2");

	}
	else if ( $(this).val() == "all" ){
		document.querySelectorAll('input[type=checkbox]').forEach(function(i){
			if ( $(i).val().substr( 0, 2 ) == 'ID' ){
				$(i).click()
			}
		});
	}

});
$(document).on("change",".sort_wrapper select",function(e){
	window.location = $(this).find("option:selected").val();
});
$(document).on("click","#sidebar ul li",function(e){

	if ( $(this).hasClass("parent") ){

		if ( $(this).hasClass("active") )
			return;

		if ( $(this).hasClass("has-child") ){
			$("#sidebar ul li.parent.active").removeClass("active");
		    $(this).addClass("active");
			return;
		}

	}

	window.location = $_home + $(this).attr("data-url");

});
$(document).on("click",".menu_handler",function(e){

	$("body").toggleClass('active_menu')

});
$(document).ready(function(){

	$("[data-toggle=tooltip]").tooltip({ boundary: 'window' });
	if ( $("input[type=color]").length )
		$("input[type=color]").spectrum({ showInput: true,preferredFormat: "hex" });

});
