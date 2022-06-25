<?php if ( !defined("root" ) ) die; ?>
<div class="box-title auto">
  <div class="icon"><span class="mdi mdi-view-dashboard"></span></div>
  <div class="title">Dashboard</div>
</div>

<div class="row">

  <div class="col-lg-3 col-sm-6 col-12">
  	<div class="card">
  	  <div class="icon"><span class="mdi mdi-account"></span></div>
  	  <div class="title">Total Users</div>
  	  <div class="count"><?php echo number_format( $page_data["count_users"] ); ?></div>
  	</div>
  </div>

  <div class="col-lg-3 col-sm-6 col-12">
  	<div class="card">
  	  <div class="icon"><span class="mdi mdi-play-box-multiple"></span></div>
  	  <div class="title">Total Tracks</div>
  	  <div class="count"><?php echo number_format( $page_data["count_tracks"] ); ?></div>
  	</div>
  </div>

  <div class="col-lg-3 col-sm-6 col-12">
  	<div class="card">
  	  <div class="icon"><span class="mdi mdi-album"></span></div>
  	  <div class="title">Total Albums</div>
  	  <div class="count"><?php echo number_format( $page_data["count_albums"] ); ?></div>
  	</div>
  </div>

  <div class="col-lg-3 col-sm-6 col-12">
  	<div class="card">
  	  <div class="icon"><span class="mdi mdi-account-music"></span></div>
  	  <div class="title">Total Artists</div>
  	  <div class="count"><?php echo number_format( $page_data["count_artists"] ); ?></div>
  	</div>
  </div>

</div>

<div class="row">
  <div class="col-md-8 col-12">

  	<div class="box auto">
  	  <div class="title">Daily Hits</div>
  	  <?php
  	  $loader->html->doms->create_graph(
	      array(
	          "datas_options" => [
			      "hits" => array(
			          "label" => "Daily hits",
		              "fill"  => true,
		          ),
		      ],
              "hooks" => $page_data["hits"]["hooks"],
              "datas" => $page_data["hits"]["datas"],
	      ),
	      array(
		      "aGraph" => false,
	          "type" => "line",
	          "height" => 300,
	          "options" => (object) array(
		          "legend" => (object) array(
	                  "display" => false
	              ),
	          )
	      )
  	  );
  	  ?>
  	</div>

  </div>
  <div class="col-md-4 col-12">

  	<div class="box auto">
  	  <div class="title">Top Browsers</div>
  	  <?php
  	  $loader->html->doms->create_graph(
	      array(
	          "datas_options" => [
		          "counts" => [ "label" => "Counts", "bg_color" => "_def", "width" => 0 ]
	          ],
              "hooks" => $page_data["browsers"]["hooks"],
              "datas" => $page_data["browsers"]["datas"]
	      ),
	      array(
	          "aGraph" => false,
	          "type" => "doughnut",
	          "height" => 300,
		  )
  	  );
  	  ?>
  	</div>

  </div>
</div>

<div class="row">
  <div class="col-md-4 col-12">

  	<div class="box auto">
  	  <div class="title">Top Countries</div>
  	  <?php
  	  $loader->html->doms->create_graph(
	      array(
	          "datas_options" => [
		          "counts" => [ "label" => "Counts", "bg_color" => "_def", "width" => 0 ]
	          ],
              "hooks" => $page_data["countries"]["hooks"],
              "datas" => $page_data["countries"]["datas"]
	      ),
	      array(
	          "aGraph" => false,
	          "type" => "doughnut",
	          "height" => 300,
	      )
  	  );
  	  ?>
  	</div>

  </div>
  <div class="col-md-8 col-12">

  	<div class="box auto">
  	  <div class="title">Daily New Users & Tracks count</div>
  	  <?php
  	  $loader->html->doms->create_graph(
	      array(
	          "datas_options" => [
			      "users" => array(
			          "label" => "Daily Signups",
		          ),
		          "tracks" => array(
			          "label" => "Daily Tracks",
		          ),
		      ],
              "hooks" => $page_data["users"]["hooks"],
              "datas" => $page_data["users"]["datas"],
	      ),
	      array(
		      "aGraph" => false,
	          "type" => "line",
	          "height" => 300,
	      )
  	  );
  	  ?>
  	</div>

  </div>

</div>
