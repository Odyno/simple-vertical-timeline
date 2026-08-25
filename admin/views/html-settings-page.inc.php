<?php
/*  Copyright 2012  Alessandro Staniscia  (email : alessandro@staniscia.net)

  This program is free software; you can redistribute it and/or modify
  it under the terms of the GNU General Public License, version 2, as
  published by the Free Software Foundation.

  This program is distributed in the hope that it will be useful,
  but WITHOUT ANY WARRANTY; without even the implied warranty of
  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
  GNU General Public License for more details.

  You should have received a copy of the GNU General Public License
  along with this program; if not, write to the Free Software
  Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
 */
?>

<script>
	function svtOpenTab(evt, cityName) {
		// Declare all variables
		var i, tabcontent, tablinks;

		// Get all elements with class="tabcontent" and hide them
		tabcontent = document.getElementsByClassName("tabcontent");
		for (i = 0; i < tabcontent.length; i++) {
			tabcontent[i].style.display = "none";
		}

		// Get all elements with class="tablinks" and remove the class "active"
		tablinks = document.getElementsByClassName("nav-tab");
		for (i = 0; i < tablinks.length; i++) {
			tablinks[i].className = tablinks[i].className.replace(" nav-tab-active", "");
		}

		// Show the current tab, and add an "active" class to the link that opened the tab
		document.getElementById(cityName).style.display = "block";
		evt.currentTarget.className += "  nav-tab-active";
	}
</script>


<div class="wrap">

	<h2 class="nav-tab-wrapper">
		<a href="#" class="nav-tab nav-tab-active"
		   onclick="svtOpenTab(event, 'information_tab')">Information</a>
		<a href="#" class="nav-tab"
		   onclick="svtOpenTab(event, 'shortcode_tab')">Short Code</a>
		<a href="#" class="nav-tab" onclick="svtOpenTab(event, 'options_tab')">Options</a>
	</h2>


	<div id="poststuff">

		<div id="post-body" class="metabox-holder columns-2">

			<!-- main content -->
			<div id="post-body-content">

				<div class="meta-box-sortables ui-sortable">

					<!-- <div class="postbox">  -->

					<div class="inside">

						<div id="information_tab" class="tabcontent">
							<h2><?php _e( 'Simple Vertical Timeline — Manual', 'svt' ); ?></h2>
							<p><?php _e( 'Use Gutenberg blocks for new content. Legacy shortcodes remain available for old posts.', 'svt' ); ?></p>

							<h3><?php _e( '1) Insert the timeline container', 'svt' ); ?></h3>
							<ol>
								<li><?php _e( 'Open a post or page in the Block Editor.', 'svt' ); ?></li>
								<li><?php _e( 'Click Block Inserter (+) and search for "Simple Vertical Timeline".', 'svt' ); ?></li>
								<li><?php _e( 'Insert the container block in your content.', 'svt' ); ?></li>
							</ol>
							<p><strong><?php _e( 'Screenshot #1 — block inserter search', 'svt' ); ?></strong></p>
							<p>
								<img src="<?php echo esc_url( add_query_arg( 'v', (string) ( file_exists( plugin_dir_path( __SVT_FILE__ ) . 'assets/screenshot-1.png' ) ? filemtime( plugin_dir_path( __SVT_FILE__ ) . 'assets/screenshot-1.png' ) : time() ), plugins_url( 'assets/screenshot-1.png', __SVT_FILE__ ) ) ); ?>"
									 alt="Insert Simple Vertical Timeline from Gutenberg Block Inserter"
									 style="max-width:100%;height:auto;border:1px solid #dcdcde;border-radius:6px;" />
							</p>

							<h3><?php _e( '2) Add and configure Timeline Event blocks', 'svt' ); ?></h3>
							<p><?php _e( 'Inside the timeline, add one or more "Timeline Event" blocks. Each event has editable body content, so you can insert text, images, lists, and other allowed blocks.', 'svt' ); ?></p>
							<p><strong><?php _e( 'Event settings (right sidebar):', 'svt' ); ?></strong></p>
							<ul>
								<li><code>Title</code>: <?php _e( 'event heading shown in the card.', 'svt' ); ?></li>
								<li><code>Date</code>: <?php _e( 'free text date label (for example: 2026-08-23 or March 2012).', 'svt' ); ?></li>
								<li><code>Icon source</code>: <?php _e( 'choose "External library (Bootstrap Icons)" or "Image URL".', 'svt' ); ?></li>
								<li><code>Bootstrap icon name</code>: <?php _e( 'icon token without prefix (example: geo-alt-fill).', 'svt' ); ?></li>
								<li><code>Icon image URL</code>: <?php _e( 'absolute URL for custom icon image (SVG/PNG).', 'svt' ); ?></li>
								<li><code>Title CSS class</code>: <?php _e( 'custom class added to the event title element.', 'svt' ); ?></li>
								<li><code>Date CSS class</code>: <?php _e( 'custom class added to the event date element.', 'svt' ); ?></li>
								<li><code>Icon color</code> + <code>Icon circle background</code>: <?php _e( 'visual colors for marker icon and marker circle.', 'svt' ); ?></li>
							</ul>
							<p><strong><?php _e( 'Screenshot #2 — Event settings and editable event content', 'svt' ); ?></strong></p>
							<p>
								<img src="<?php echo esc_url( add_query_arg( 'v', (string) ( file_exists( plugin_dir_path( __SVT_FILE__ ) . 'assets/screenshot-2.jpg' ) ? filemtime( plugin_dir_path( __SVT_FILE__ ) . 'assets/screenshot-2.jpg' ) : time() ), plugins_url( 'assets/screenshot-2.jpg', __SVT_FILE__ ) ) ); ?>"
									 alt="Timeline Event settings sidebar and editable event content"
									 style="max-width:100%;height:auto;border:1px solid #dcdcde;border-radius:6px;" />
							</p>

							<h3><?php _e( '3) Validate layout in editor', 'svt' ); ?></h3>
							<p><?php _e( 'Check event order, titles, dates, markers, and rich content directly in the editor canvas before publishing.', 'svt' ); ?></p>
							<p><strong><?php _e( 'Screenshot #3 — timeline canvas with multiple events', 'svt' ); ?></strong></p>
							<p>
								<img src="<?php echo esc_url( add_query_arg( 'v', (string) ( file_exists( plugin_dir_path( __SVT_FILE__ ) . 'assets/screenshot-3.jpg' ) ? filemtime( plugin_dir_path( __SVT_FILE__ ) . 'assets/screenshot-3.jpg' ) : time() ), plugins_url( 'assets/screenshot-3.jpg', __SVT_FILE__ ) ) ); ?>"
									 alt="Timeline canvas with multiple events, marker icons, and rich content"
									 style="max-width:100%;height:auto;border:1px solid #dcdcde;border-radius:6px;" />
							</p>

							<h3><?php _e( '4) Verify frontend output', 'svt' ); ?></h3>
							<p><?php _e( 'Publish or update the post, then verify responsive behavior and final rendering on frontend.', 'svt' ); ?></p>
							<p><strong><?php _e( 'Screenshot #4 — responsive frontend result', 'svt' ); ?></strong></p>
							<p>
								<img src="<?php echo esc_url( add_query_arg( 'v', (string) ( file_exists( plugin_dir_path( __SVT_FILE__ ) . 'assets/screenshot-4.jpg' ) ? filemtime( plugin_dir_path( __SVT_FILE__ ) . 'assets/screenshot-4.jpg' ) : time() ), plugins_url( 'assets/screenshot-4.jpg', __SVT_FILE__ ) ) ); ?>"
									 alt="Responsive frontend timeline output"
									 style="max-width:100%;height:auto;border:1px solid #dcdcde;border-radius:6px;" />
							</p>

							<h3><?php _e( '5) Legacy shortcode compatibility', 'svt' ); ?></h3>
							<p><?php _e( 'Old content using [svtimeline] and [svt-event] still works. For shortcode syntax and option details, open the "Shortcodes" tab in this page.', 'svt' ); ?></p>
						</div>


						<div id="shortcode_tab" class="tabcontent"
						     style="display: none;">

							<h1><?php _e( 'Example', 'svt' ) ?></h1>

							<p><?php
								_e( ' What is probably present in your editor looks like this piece of code, here one time line with with 2 events:
<pre class="codestyle">[svtimeline]
  [svt-event title="Decision time..." date="28/05/2016"]
   Lore ipsum...
  [/svt-event]
  [svt-event title="Decision time..." date="28/05/2016" class="svt-cd-yellow" button_link="https://.../" button_label=" more..." ]
   Lore ipsum...
  [/svt-event]
[/svtimeline]</pre>
Check the following sections to discover all the feature that you can use.
		', 'svt' )
								?></p>
							<h1><?php _e( ' Short code [svtimeline]', 'svt' ) ?></h1>
							<p><?php _e( ' The <code>[svtimeline] ... [/svtimeline]</code> is the container of timeline' ) ?></p>
							<h1><?php _e( 'Short code [svt-event] ', 'svt' ) ?></h1>
							<p><?php _e( 'The <code>[svt-event ...] ... [/svt-event]</code>  is used for the definition of one event and that need to be insert only within the <em>svtimeline</em> section.', 'svt' ) ?></p>
							<table>
								<tr>
									<td><b><?php _e( 'Options', 'svt' ) ?></b>
									</td>
									<td>
										<b><?php _e( 'Description', 'svt' ) ?></b>
									</td>
								</tr>
								<tr>
									<td><code>title</code></td>
									<td><?php _e( 'The title of events', 'svt' ) ?></td>
								</tr>
								<tr>
									<td><code>date</code></td>
									<td><?php _e( 'The date of event', 'svt' ) ?></td>
								</tr>
								<tr>
									<td><code>class</code></td>
									<td><?php _e( 'With this tag you can specify class for the icons or color of button', 'svt' ) ?></td>
								</tr>
								<tr>
									<td><code>button_link</code></td>
									<td><?php _e( 'if specified with one href link then one button appears with this link.', 'svt' ) ?></td>
								</tr>
								<tr>
									<td><code>button_label</code></td>
									<td><?php _e( 'if specified with one label then the label will be appear on the button.', 'svt' ) ?></td>
								</tr>
							</table>
						</div>


						<div id="options_tab" class="tabcontent"
						     style="display: none;">
							<form method="post" action="options.php">
								<?php
								settings_fields( SVT_Settings::PAGE_SETTING );
								do_settings_sections( SVT_Settings::PAGE_ID );
								submit_button( __( 'Save options', 'svt' ) );
								?>
							</form>
						</div>

					</div>

					<!-- .inside -->

					<!--</div>
				  .postbox -->

				</div>
				<!-- .meta-box-sortables .ui-sortable -->

			</div>
			<!-- post-body-content -->

			<!-- sidebar -->
			<div id="postbox-container-1"
			     class="postbox-container ast_container_promotion">

				<div class="meta-box-sortables">

					<div class="postbox">

						<h2><span>Simple Vertical Timeline<small
									style="float: right">v<?php echo SVT_VER; ?></small><br/></span>
						</h2>


						<div class="inside">


							<div style="float: right; margin: -15px 0 10px 0"><a
									href="http://www.staniscia.net/simple-vertical-timeline"
									target="_blank"><img
										src="<?php echo plugins_url( 'icon-256x256.png', __SVT_FILE__ ); ?>"
										border="0"
										alt="logo"
										width="80px"
										height="80px"
										style="border: 1px solid gray"
									/></a>
							</div>
							<a class="adv_button"
							   href="http://www.staniscia.net/simple-vertical-timeline"
							   target="_blank"><span
									class="dashicons dashicons-admin-home"></span> <?php _e( 'Plugin Homepage', 'svt' ) ?>
							</a>
							<a class="adv_button"
							   href="https://github.com/Odyno/simple-vertical-timeline/issues"
							   target="_blank"><span
									class="dashicons dashicons-lightbulb"></span> <?php _e( 'Suggest a Feature', 'svt' ) ?>
							</a>
							<a class="adv_button"
							   href="https://github.com/Odyno/simple-vertical-timeline/issues"
							   target="_blank"><span
									class="dashicons dashicons-welcome-comments"></span> <?php _e( 'Report a Bug', 'svt' ) ?>
							</a>
							<a class="adv_button"
							   href="https://wordpress.org/support/view/plugin-reviews/simple-vertical-timeline?rate=5#postform"
							   target="_blank"><span
									class="dashicons dashicons-star-filled"></span> <?php _e( 'Rate the plugin on WordPress.org', 'svt' ) ?>
							</a>

							<a class="adv_button "
							   href="https://wordpress.org/plugins/simple-vertical-timeline/"
							   target="_blank"><span
									class="dashicons dashicons-wordpress"></span>
								Check it on Wordpress.org</a>


						</div>
						<!-- .inside -->

					</div>
					<!-- .postbox -->

					<div class="postbox">
						<h2> <?php _e( "Translator", "svt" ); ?></h2>
						<div class="inside">
							<a class="sm_button flag_en"
							   href="mailto://alessandro@staniscia.net"
							   target="_blank">Alessandro
								Staniscia</a>
							<a class="sm_button flag_it"
							   href="mailto://alessandro@staniscia.net"
							   target="_blank">Alessandro
								Staniscia</a>
						</div>
					</div>


				</div>
				<!-- .meta-box-sortables -->

			</div>
			<!-- #postbox-container-1 .postbox-container -->

		</div>
		<!-- #post-body .metabox-holder .columns-2 -->

		<br class="clear">
	</div>
	<!-- #poststuff -->

</div> <!-- .wrap -->







