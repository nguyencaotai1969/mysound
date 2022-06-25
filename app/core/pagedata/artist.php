<?php

if ( !defined( "root" ) ) die;

$loader->db->query("UPDATE _m_artists SET views = views + 1 WHERE ID = {$loader->ui->page_hook} ");

$index = true;
$items = [];

// widgets
$widgets = [ "tracks_popular", "artists_related", "albums_studio", "albums_single", "albums_as_guest" ];

// user requests
$reqed_widget = $loader->secure->get( "get", "w", "string", [ "strict" => true, "strict_regex" => "[a-z_]" ], "all" );
$index = $reqed_widget == "all";

// page data
$data = $loader->artist->select(["ID"=>$loader->ui->page_hook,"_eg"=>["followed"]]);

// artist spotify ID
if ( !empty( $loader->admin->get_setting( "spotify_d_ar", 1 ) ) ){

	// get spotify ID
	if ( empty( $data["spotify_id"] ) && empty( $data["time_spotify_search"] ) ){

		$search_for_artist = $loader->spotify->search_artist( $data["name"] );
		if ( $search_for_artist[0] && !empty( $search_for_artist[1]["ID"] ) ){

			$stmt = $this->db->prepare("UPDATE _m_artists SET spotify_id = ?, spotify_hits = ?, time_spotify_search = null WHERE ID = ? ");
			$stmt->bind_param("sss",$search_for_artist[1]["ID"],$search_for_artist[1]["popularity"],$data["ID"]);
			$stmt->execute();
			$stmt->close();
			$data["spotify_id"] = $search_for_artist[1]["ID"];

		}

	}

}

// get widgets content
foreach( $widgets as $widget_name ){

	if ( $reqed_widget != "all" && $widget_name != $reqed_widget )
		continue;

	// Spotify content
	if ( !empty( $loader->admin->get_setting( "spotify_d_ar", 1 ) ) && !empty( $data["spotify_id"] ) ){

		$_get_from_spotify = false;
		if ( $widget_name == "tracks_popular" ){
			$_get_from_spotify = $loader->spotify->get_artist_top_tracks( $data["spotify_id"] );
		}
		elseif ( $widget_name == "albums_studio" ){
			$_get_from_spotify = $loader->spotify->get_artist_top_albums( $data["spotify_id"], [ "album", "compilation" ], $index ? 20 : 50, $index ? false : true );
		}
		elseif ( $widget_name == "albums_single" ){
			$_get_from_spotify = $loader->spotify->get_artist_top_albums( $data["spotify_id"], [ "single" ], $index ? 20 : 50, $index ? false : true );
		}
		elseif ( $widget_name == "albums_as_guest" ){
			$_get_from_spotify = $loader->spotify->get_artist_top_albums( $data["spotify_id"], [ "appears_on" ], $index ? 20 : 50, $index ? false : true );
		}
		elseif ( $widget_name == "artists_related" ){
			$_get_from_spotify = $loader->spotify->get_artist_related_artists( $data["spotify_id"] );
		}

		if ( !empty( $_get_from_spotify[0] ) && !empty( $_get_from_spotify[1] ) ){

			foreach( $_get_from_spotify[1] as $_item ){

				// Spotify content is also local?
			    $_item["code"] = $loader->general->make_code(
					$widget_name == "artists_related" ? $_item["name"] :
					( $widget_name == "tracks_popular" ? $_item["artist_name"] . $_item["album_title"] . $_item["title"] : $_item["artist_name"] . $_item["title"] )
				);

				$spotify_code = $_item["ID"];
				$_item["spotify"] = true;

				$_widget_name = explode( "_", $widget_name );
				$__wt = substr( reset( $_widget_name ), 0, -1 );
				unset ( $_widget_name );

				$_db_data = $loader->$__wt->select([
					"where_o"    => "OR",
					"spotify_id" => $_item["ID"],
					"code"       => $_item["code"]
				]);

				if ( $_db_data ){
					$_item = $_db_data;
				}
				else if ( $widget_name == "tracks_popular" ){

					$loader->bot->spotify_create( "track", $spotify_code );
					$_db_data = $loader->$__wt->select([
					    "where_o"    => "OR",
					    "spotify_id" => $_item["ID"],
					    "code"       => $_item["code"]
				    ]);
				    if ( $_db_data ){
					    $_item = $_db_data;
				    }

				}

			    $items[$widget_name][$_item["code"]] = $_item;

		    }

		}

	}

	// Local content
	if ( $index ? empty( $items[$widget_name] ) : true ){

		$_get_from_DB = false;
		if ( $widget_name == "tracks_popular" ){
			$_get_from_DB = $loader->track->select(["limit"=>20,"singular"=>false,"artist_id"=>$data["ID"],"order_by"=>"play_full","order"=>"DESC"]);
		}
		elseif ( $widget_name == "albums_studio" ){
			$_get_from_DB = $loader->album->select(["limit"=>200,"singular"=>false,"artist_id"=>$data["ID"],"order_by"=>"time_release","order"=>"DESC","types"=>["studio","mixtape","compilation"]]);
		}
		elseif ( $widget_name == "albums_single" ){
			$_get_from_DB = $loader->album->select(["limit"=>200,"singular"=>false,"artist_id"=>$data["ID"],"order_by"=>"time_release","order"=>"DESC","types"=>["single"]]);
		}
		elseif ( $widget_name == "albums_as_guest" ){

			$_get_from_DB = $loader->track->select(["limit"=>200,"singular"=>false,"ft_artist_id"=>$data["ID"],"order_by"=>"time_release","order"=>"DESC"]);
			if ( !empty( $_get_from_DB ) ){
				foreach( $_get_from_DB as &$item ){
					$item = $loader->album->select(["ID"=>$item["album_id"],"limit"=>1,"singular"=>true]);
				}
			}

		}

		if ( !empty( $_get_from_DB ) ){
			foreach( $_get_from_DB as $_item ){
				$items[$widget_name][$_item["code"]] = $_item;
			}
		}

	}

}

$loader->ui->set_page_data([
	"index"         => $index ? true : $reqed_widget,
	"data"          => $data,
	"user"          => $data["user_id"] ? $loader->user->set( $data["user_id"] )->get_data() : null,
	"items"         => $items
]);

$loader->html
	->set_title( $data["name"] )
	->set_description( $data["name"] )
	->set_og( "image", $data["image"] )
	->set_twitter( "image", $data["image"] );

?>
