<?php if ( !defined("root" ) ) die; ?>

<div class="container user_container" >
	<div>

		<div id="user_content" class="<?php echo $page_data["setting_part"]; ?> us" >

			<div class="user_setting_widget som_scroll_h setting_count_<?php echo count( array_intersect( $page_data["setting_parts_display"], $page_data["setting_parts"] ) ); ?>">
				<div class="set_title">@<?php echo ucfirst( $page_data["user_data"]["username"] ); ?></div>
				<ul>
					<?php foreach( $page_data["setting_parts"] as $s_p ) :
					if ( !in_array( $s_p, $page_data["setting_parts_display"], true ) ) continue; ?>
						<li<?php echo $s_p == $page_data["setting_part"] ? " class='active'" : "" ?>>
						<a href="<?php $loader->ui->eurl( "user_setting", $page_data["user_data"]["username"], "n={$s_p}" ); ?>">
							<span class="mdi mdi-<?php echo $page_data["icons"][$s_p]; ?>"></span>
							<span class="text"><?php $loader->lorem->eturn( "us_" . ( $s_p == "transaction_history" ? "transactions" : ( $s_p == "artist_verification" ? "verification" : $s_p ) ) ); ?></span>
						</a>
					</li>
				<?php endforeach; ?>
			</ul>
		</div>

		<div class="user_setting_main">
			<div class="set_title"><?php echo $page_data["setting_part_name"]; ?></div>
			<div class="inputs">
				<?php echo $loader->html->load_part( "us_{$page_data["setting_part"]}", [ "page_data" => $page_data ] );  ?>
			</div>
		</div>

	</div>

</div>
</div>
