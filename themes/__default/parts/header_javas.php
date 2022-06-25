<?php if ( !defined("root" ) ) die; ?>
<script>

var $_home = "<?php echo $this->loader->admin->get_setting( 'web_addr' ); ?>";
var $_play_hash = "<?php echo $this->loader->visitor->play_hash; ?>";
var $_user_id = <?php echo !empty( $this->loader->visitor->user()->ID ) ? $this->loader->visitor->user()->ID : 'null' ?>;
var $_user_name = <?php echo !empty( $this->loader->visitor->user()->ID ) ? "'{$this->loader->visitor->user()->username}'" : 'null' ?>;
var $_name = <?php echo !empty( $this->loader->visitor->user()->ID ) ? "'{$this->loader->visitor->user()->name_raw}'" : 'null' ?>;
var $_email = <?php echo !empty( $this->loader->visitor->user()->ID ) ? "'{$this->loader->visitor->user()->email}'" : 'null' ?>;
var $_out_time = <?php echo $loader->timeout; ?>;
var $_dir = '<?php $loader->lorem->eturn( "dir" ); ?>';
var $_not_enabled = <?php echo $loader->visitor->user()->has_access( "group", "notification" ) ? 1 : 0; ?>;

</script>
