<?php if ( !defined( "root" ) ) die; ?>
<div id="nav" class="goingTop">
<div class="container">

  <div class="logo">
  	<a href="<?php $loader->ui->eurl( "index" ) ?>">
  	  <img src="<?php echo $loader->general->path_to_addr( $loader->theme->set_name()->get_setting( "logo" ) ); ?>" alt="logo">
  	</a>
  </div>

  <div class="buttons opp" >

    <?php if ( $loader->visitor->user()->has_access( "group", "language" ) ? count( $loader->admin->get_setting( "langs", [ "en" => "English" ], null, true ) ) > 1 : false ) : ?>
    <div class="button lang button_more">
      <span class="mdi mdi-translate"></span>
      <ul class='languages_handle a_dropdown a_m_dropdown dropdown-menu'>
        <?php foreach( $loader->admin->get_setting( "langs", [ "en" => "English" ], null, true ) as $lang_code => $lang_name ): ?>
          <li data-lang-code="<?php echo $loader->secure->escape( $lang_code ); ?>"><?php echo $loader->secure->escape( $lang_name ); ?></li>
        <?php endforeach; ?>
      </ul>
    </div>
    <?php endif; ?>

    <div class="button search" >
      <span class="mdi mdi-magnify search_handle"></span>
      <div class="search_box_wrapper" >
        <form autocomplete="off" method="get" class="search_form_i" action="<?php $loader->ui->eurl( "search" ); ?>">
          <input id="qn" name="qn" type="text" class="form-control" placeholder="<?php $loader->lorem->eturn("search_placeholder"); ?>" >
        </form>
      </div>
    </div>

    <div class="button menu_handle" >
      <span class="mdi mdi-menu"></span>
      <span class="mdi mdi-close"></span>
    </div>

  </div>

  <?php if ( $loader->visitor->user()->guest ) : ?>
  <div class="buttons user_menu">
    <a class="button login" href="<?php $loader->ui->eurl( "user_login" ); ?>">
      <span class="mdi mdi-lock"></span>
      <span class="text"><?php $loader->lorem->eturn( "login", ["uc"=>true] ); ?></span>
    </a>
  </div>
<?php else: ?>
    <?php if ( $loader->visitor->user()->has_access( "group", "notification" ) ) : ?>
    <div class="buttons nots">
    	<a class="button nots_btn button_more" >
    	  <span class="mdi mdi-bell-outline"></span>
        <ul class='a_dropdown a_m_dropdown dropdown-menu nots_ul'>
    	  	<li>Loading</li>
    	  </ul>
    	</a>
    </div>
    <?php endif; ?>
  <div class="buttons user_menu logged button_more">

    <div class="user_wrapper">

      <div class="avatar" >
  	    <img src="<?php echo $loader->visitor->user()->avatar; ?>" alt="avatar">
  	  </div>

  	  <div class="user_name" >
  	  	<?php echo $loader->visitor->user()->username; ?>
  	  	<span class="mdi mdi-chevron-down"></span>
  	  </div>

  	  <ul class='a_dropdown a_m_dropdown dropdown-menu'>
  	    <li><a id="add_funds"><span class="mdi mdi-wallet-travel"></span><?php $loader->lorem->eturn("fund",["uc"=>true]); ?>: <?php $loader->general->display_price( $loader->visitor->user()->data["fund"] ); ?></a></li>
  	    <?php if ( $loader->visitor->user()->has_access( "group", "upload" ) ) : ?>
		<li class="upload"><a href="<?php $loader->ui->eurl( "user_upload" ); ?>"><span class="mdi mdi-cloud-upload"></span><?php $loader->lorem->eturn( "upload", ["uc"=>true] ); ?></a></li>
  	    <?php endif; ?>
		<?php if ( $loader->visitor->user()->has_access( "group", "upgrade" ) ) : ?>
  	    <li class="upgrade"><a href="<?php $loader->ui->eurl( "user_upgrade" ); ?>"><span class="mdi mdi-chevron-triple-up"></span><?php $loader->lorem->eturn("upgrade",["uc"=>true]); ?></a></li>
  	    <?php endif; ?>
  	    <?php foreach( $loader->visitor->user()->get_sidebar_links() as $link ) : ?>
  	    <li><a href="<?php $loader->ui->eurl( $link[2], $loader->visitor->user()->username ); ?>"><span class="mdi mdi-<?php echo $link[0]; ?>"></span><?php echo $link[1]; ?></a></li>
  	    <?php endforeach; ?>
  	    <?php if ( $loader->visitor->user()->artist ) : ?>
  	    <li class="divider"></li>
  	    <li><a href="<?php $loader->ui->eurl( "user_setting", $loader->visitor->user()->username, "n=artist_withdrawal" ); ?>"><span class="mdi mdi-credit-card-outline"></span><?php $loader->lorem->eturn("us_artist_withdrawal",["uc"=>true]); ?></a></li>
  	    <?php elseif ( $loader->visitor->user()->has_access( "group", "artist_req" ) ) : ?>
  	    <li class="divider"></li>
  	    <li><a href="<?php $loader->ui->eurl( "user_setting", $loader->visitor->user()->username, "n=artist_verification" ); ?>"><span class="mdi mdi-microphone"></span><?php $loader->lorem->eturn("us_verification",["uc"=>true]); ?></a></li>
  	    <?php endif; ?>
  	    <?php if ( $loader->visitor->user()->has_access( "group", "admin" ) ) : ?>
  	    <li class="divider"></li>
  	    <li><a href="<?php $loader->ui->eurl( "admin_dashboard" ); ?>"><span class="mdi mdi-chart-pie"></span><?php $loader->lorem->eturn("admin",["uc"=>true]); ?></a></li>
  	    <?php endif; ?>
        <?php if ( $loader->visitor->user()->has_access( "group", "advertisement" ) ) : ?>
  	    <li class="divider"></li>
  	    <li><a href="<?php $loader->ui->eurl( "user_setting", $loader->visitor->user()->username, "n=advertising" ); ?>"><span class="mdi mdi-star"></span><?php $loader->lorem->eturn("advertising",["uc"=>true]); ?></a></li>
  	    <?php endif; ?>
  	    <li class="divider"></li>
  	    <li><a href="<?php $loader->ui->eurl( "user_logout" ); ?>"><span class="mdi mdi-exit-to-app"></span><?php $loader->lorem->eturn("logout",["uc"=>true]); ?></a></li>
  	  </ul>

    </div>

  </div>
  <?php endif; ?>

  <div class="buttons">
  	<?php if ( $loader->visitor->user()->has_access( "group", "upload" ) ) : ?>
  	<a class="button upload" href="<?php $loader->ui->eurl( "user_upload" ); ?>">
  	  <span class="mdi mdi-cloud-upload"></span>
  	  <span class="text"><?php $loader->lorem->eturn( "upload", ["uc"=>true] ); ?></span>
  	</a>
  	<?php elseif ( $loader->visitor->user()->has_access( "group", "upgrade" ) ) : ?>
  	<a class="button upgrade" href="<?php $loader->ui->eurl( "user_upgrade" ); ?>">
  	  <span class="mdi mdi-chevron-triple-up"></span>
  	  <span class="text"><?php $loader->lorem->eturn( "upgrade", ["uc"=>true] ); ?></span>
  	</a>
  	<?php endif; ?>
  </div>

</div>
</div>
