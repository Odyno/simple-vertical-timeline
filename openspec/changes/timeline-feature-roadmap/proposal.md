## Why
The timeline feature set needs stronger layout flexibility, better global controls, and scalable rendering for large datasets.

## What Changes
- Add horizontal orientation mode for timeline containers (P1.1).
- Add container-level global settings for alignment, spacing, date display mode, and item limit (P1.3).
- Add filter system for event subsets with optional filter UI (P2.4).
- Add pagination/load-more display strategies for long timelines (P2.5).

## Impact
- Affected specs: timeline-container, timeline-rendering, timeline-interactions
- Affected code:
  - `blocks/src/timeline/*`
  - `blocks/src/event/*` (only where needed for compatibility)
  - frontend runtime scripts/styles for filtering and pagination
  - admin/help docs for feature usage
- Backward compatibility is preserved for existing posts and shortcode content.