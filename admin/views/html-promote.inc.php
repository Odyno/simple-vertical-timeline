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
<div id="icon-tools" class="icon32"><br></div><h2><?php _e( 'Information', 'svt' ) ?></h2>

<div id="poststuff" class="ast_container_promotion">
	<div id="post-body" class="metabox-holder columns-2">
		<div id="postbox-container-1" class="postbox-container">
			<div id="side-sortables" class="meta-box-sortables">
				<div class="postbox">
					<div class="handlediv" title="Click to toggle"><br/><br/></div>
					<h3 class="hndle">
						<span>Simple Vertical Timeline<small style="float: right">
								v<?php echo SVT_VER; ?></small><br/></span>
					</h3>
					<div class="inside">
						<div style="float: right; margin: -15px 0 10px 0"><a
								href="http://www.staniscia.net/simple-vertical-timeline" target="_blank"><img
									src="<?php echo plugins_url( 'icon-256x256.png', __SVT_FILE__ ); ?>" border="0"
									alt="logo"
									width="80px"
									height="80px"
									style="border: 1px solid gray"
								/></a></div>
						<a class="sm_button icon_autor" href="http://www.staniscia.net/simple-vertical-timeline"
						   target="_blank"><?php _e( 'Plugin Homepage', 'svt' ) ?></a>
						<!-- a class="sm_button icon_demo"  href="http://www.staniscia.net/simple-vertical-timeline/" target="_blank"><?php _e( 'Live demo', 'svt' ) ?></a -->
						<a class="sm_button icon_code" href="https://github.com/Odyno/simple-vertical-timeline/issues"
						   target="_blank"><?php _e( 'Suggest a Feature', 'svt' ) ?></a>
						<a class="sm_button icon_bug" href="https://github.com/Odyno/simple-vertical-timeline/issues"
						   target="_blank"><?php _e( 'Report a Bug', 'svt' ) ?></a>
						<a class="sm_button icon_star"
						   href="https://wordpress.org/support/view/plugin-reviews/simple-vertical-timeline?rate=5#postform"
						   target="_blank"><?php _e( 'Rate the plugin on WordPress.org', 'svt' ) ?></a>
					</div>
				</div>

				<div class="postbox">
					<div class="handlediv" title="Click to toggle"><br/><br/></div>
					<h3 class="hndle">
						<?php _e( "Translator", "svt" ); ?><br/>
					</h3>
					<div class="inside">
						<a class="sm_button flag_en" href="mailto://alessandro@staniscia.net" target="_blank">Alessandro
							Staniscia</a>
						<a class="sm_button flag_it" href="mailto://alessandro@staniscia.net" target="_blank">Alessandro
							Staniscia</a>
					</div>
				</div>
			</div>
		</div>
		<p><?php _e('
		
Simple Vertical Timeline is a simple plugin that allow you to create a timeline in your Blog or Page. You can decide to add it via shortcode or via useful and simple buttons in your editor. Follow me to discover this new feature for your WordPress.

<h4>QUICK START, YOUR FIRST TIMELINE</h4>

I explain how to do the timeline with a simple example, the timeline of plugin! First to all we need to open a new Article or Page. In your “Visual editor” you can discover 2 new buttons:


<h5>STEP A</h5>

The button “Simple Vertical Timeline”  allow you to create the main vertical line were all of your events will be placed… so select one place on your article and click on this button: two new shortcode will be added in the palace selected. This is your first step! you have create the tempo line! 

<h5>STEP B</h5>

The button “Event for Simple Vertical Timeline” add a new event in the tempo line. It’s very easy, move the pointer into the new element already created and click on it. One dialog will ask you to decide the title, just a quick starting note, the date and the color of node in the time line.

The result is the same of previous button, one shortcode will be added on the place of mouse and the new event with all the information will be showed on the page 

<h4>… IS IT ALL?</h4>

Yes, if you don’t want to customise the timeline, that’s all. But if you want you can try to customise the event as you want. Now all the short code are on place and it’s only up to you to add event or custom comment. Enjoy
		
', 'svt' ) ?></p>
		<div class="clear"></div>
	</div>
</div>

<div id="icon-tools" class="icon32"><br></div><h2><?php _e( 'Short Code Usage', 'svt' ) ?></h2>

<div class="ast_container_promotion">
	<div id="post-body" class="metabox-holder columns-1">


		<p><?php _e( '
		What is probably present in your editor looks like this piece of code, here one time line with with 2 events:
<pre><code>[svtimeline]
  [svt-event title="Decision time..." date="28/05/2016"]
   Lore ipsum...
  [/svt-event]
  [svt-event title="Decision time..." date="28/05/2016" class="svt-cd-yellow" button_link="https://.../" button_label=" more..." ]
   Lore ipsum...
  [/svt-event]
[/svtimeline]</code></pre>
Check the following sections to discover all the feature that you can use.
		', 'svt' ) ?></p>

		<h4><?php _e('[svtimeline] short code', 'svt')?></h4>
		<p><?php _e( '
		
		The <code>[svtimeline] ... [/svtimeline]</code> is the container of timeline
		
		') ?></p>


		<h4><?php _e('[svt-event] short code', 'svt')?></h4>
		<p><?php _e( '
		
				The <code>[svt-event ...] ... [/svt-event]</code>  is used for the definition of one event and that need to be insert only within the <em>svtimeline</em> section.

		', 'svt' ) ?></p>

		<table>
			<tr>
				<td><b><?php _e( 'Options', 'svt' ) ?></b></td>
				<td><b><?php _e( 'Description', 'svt' ) ?></b></td>
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
	<div class="clear"></div>
</div>


