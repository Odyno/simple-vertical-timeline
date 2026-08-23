=== Simple Vertical Timeline ===
Contributors: Odyno
Tags: responsive timeline, Responsive Timeline WordPress,Timeline for WordPress, Timeline, vertical, timeline, animated, css3, animations, evan, herman, evan herman, easy, time, line, font awesome, font, awesome, announcements, notifications, simple, events, calendar, scroll, triggered, scrolling, animated, fade, in, fade in, timeline, timelines, timelineJS, journalism tool
Donate link: http://www.staniscia.net/donate
Requires at least: 5.0
Tested up to: 6.7
Requires PHP: 7.4
Stable tag: 0.2.0
Text Domain: svt
License: GPLv2
License URI: http://www.gnu.org/licenses/gpl-2.0.html

Allow to create a  Simple Vertical Timeline on the current blog.

== Description ==
Simple Vertical Timeline is a simple plugin that allow you to create a timeline in your Article or Page.

**Block Editor (recommended)**: add the "Simple Vertical Timeline" block, then insert "Timeline Event" blocks inside it. Each event has title, date, node color, icon, optional button, and rich content.

**Classic Editor fallback**: the legacy shortcodes [svtimeline] and [svt-event] still work for backward compatibility with old posts.

Follow me to discover this new feature for your your wordpress.

= Quick start, your first timeline (Block Editor) =

1. Create or edit a Post/Page
2. Click the **+** (Block Inserter)
3. Search for **"Simple Vertical Timeline"** and insert it
4. Click **+** inside the timeline to add your first **Timeline Event**
5. Fill the event details in the sidebar (title, date, color, icon, button)
6. Write the event description directly in the block

= Legacy: shortcode method (Classic Editor) =

If you still use the Classic Editor, the old shortcodes work:
- `[svtimeline]` ... `[/svtimeline]` — creates the timeline container
- `[svt-event title="My Event" date="2026-01-01" title_class="my-custom-class"]` ... `[/svt-event]` — adds an event with custom title CSS class

= ... IS IT ALL? =
Yes and no, if you don't want to customise the timeline, that's all. But if you want you can try to customise the event as you want. Now all the short code are on place and it's only up to you to add event or custom comment.
Enjoy

——
Icons Used Please refer to https://linearicons.com/free/license for the license.



== Installation ==
"Simple Vertical Timeline" can be installed using integrated WordPress plugin installer or manually.

= Integrated WordPress plugin installer method =

* Go to Plugins > Add New.
* Under Search, type in ’Simple Vertical Timeline’.
* Click Install Now to install the WordPress Plugin.
* A popup window will ask you to confirm your wish to install the Plugin.
* If this is the first time you've installed a WordPress Plugin, enter the FTP login credential information. If you've installed a Plugin before, it will still have the login information.
* Click Proceed to continue with the installation. The resulting installation screen will list the installation as successful or note any problems during the install.
* If successful, click Activate Plugin to activate it, or Return to Plugin Installer for further actions.

= Manual method =

* Upload ’Simple Vertical Timeline’ folder from simple-vertical-timeline.zip file downloaded from Simple Vertical Timeline WordPress plugin directory page to the ’/wp-content/plugins/’ directory.
* Activate ’Simple Vertical Timeline’ plugin through the ’Plugins’ menu in WordPress.


== Credits ==
Copyright 2012  Alessandro Staniscia  (email : alessandro@staniscia.net)

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

== Frequently Asked Questions ==
None

== Screenshots ==
1. Block Inserter: Simple Vertical Timeline
2. Timeline Event block settings
3. Timeline with events in editor
4. Timeline responsive view
5. Share Event


== Changelog ==

= 0.2.0 =
* NEW: Gutenberg block support — "Simple Vertical Timeline" container + "Timeline Event" child blocks
* NEW: Dynamic blocks (server-rendered) for consistent output with shortcode
* NEW: Block sidebar settings for title, date, color, icon, button, and custom title CSS class
* NEW: Shortcode parameter `title_class` for custom CSS classes on event title (from PR #5 idea)
* REMOVE: TinyMCE legacy buttons (svtimeline, svtevent)
* REMOVE: js/svtplugin/ directory (TinyMCE plugin)
* Keep: shortcodes [svtimeline] and [svt-event] for backward compatibility
* Update: WordPress 6.7 block editor support
* Update: @wordpress/scripts build system

= 0.1.1 =
* SECURITY FIX: XSS via shortcode attributes (title, button_link, icon)
* SECURITY FIX: XSS in share button URLs
* Fix: esc_url() validation for button links
* Fix: deprecated target="_new" replaced with target="_blank" + rel="noopener noreferrer"
* Fix: Author URI typo (ttp://)
* Fix: wp_get_attachment_url() instead of guid for thumbnails
* Update: WordPress 6.7 compatibility
* Update: PHP 7.4 minimum requirement
* Add: GitHub Action for automated WordPress.org deployment

= 0.1.0 =
* FIX - Not correctly displayed on my site
* FIX - Parse Error on activation


= 0.0.7 =
* Added Linear Icons for share and future use
* ITA translation

= 0.0.6 =
* Added anchor foreach event
* New share icons
* Removed the auto date fill
* New settings page with help


= 0.0.2 =
* new the "more" button on event
* WP 4.6 ready

= 0.0.1 =
* Baseline to Release

 == Upgrade Notice ==
0.2.0 adds Gutenberg block support. Old shortcodes still work. No action needed for existing content.