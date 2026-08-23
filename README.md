# Simple Vertical Timeline

Allow to create a Simple Vertical Timeline on the current blog.

[![WordPress](https://img.shields.io/wordpress/v/simple-vertical-timeline.svg)]() [![WordPress plugin](https://img.shields.io/wordpress/plugin/v/simple-vertical-timeline.svg)]() [![WordPress rating](https://img.shields.io/wordpress/plugin/r/simple-vertical-timeline.svg)]()

## Description

Simple Vertical Timeline is a simple plugin that allows you to create a timeline in your Article or Page.

### Block Editor (recommended)

Add the **"Simple Vertical Timeline"** block, then insert **"Timeline Event"** blocks inside it.

Each event supports:
- Title and date
- Node color (green, red, blue, yellow)
- Custom icon URL
- Optional "Read more" button with link
- Rich text content (paragraphs, images, etc.)

### Classic Editor fallback

The legacy shortcodes still work for backward compatibility:

```
[svtimeline]
  [svt-event title="First Event" date="2026-01-01" class="svt-cd-green"]
    Event description here...
  [/svt-event]
[/svtimeline]
```

## Quick start

1. Create or edit a Post/Page
2. Click **+** (Block Inserter)
3. Search for **"Simple Vertical Timeline"** and insert it
4. Click **+** inside the timeline to add your first **Timeline Event**
5. Fill the event details in the sidebar
6. Write the event description directly in the block

## Installation

### Integrated WordPress plugin installer

* Go to Plugins > Add New
* Search for `Simple Vertical Timeline`
* Click Install Now, then Activate

### Manual method

* Upload `simple-vertical-timeline` folder to `/wp-content/plugins/`
* Activate through the `Plugins` menu

## Development

```bash
npm install
npm run build   # production build
npm run start   # watch mode
```

Blocks are in `blocks/src/`, compiled to `blocks/build/` (committed for SVN deploy).

## Credits

Copyright 2012-2026 Alessandro Staniscia (alessandro@staniscia.net)

License: GPLv2

Icons: https://linearicons.com/free/license
