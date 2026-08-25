## Overview
This change introduces four capabilities centered on the timeline container as the orchestration unit: orientation, global settings, filtering, and paging.

## Architecture
- Container block owns global state.
- Event blocks remain content units.
- Server-side render remains first-paint source of truth.
- Client-side enhancement handles dynamic filter/paging interactions.

## Data Model (container attributes)
- `orientation`: `vertical | horizontal` (default `vertical`)
- `alignmentMode`: `alternate | left | right` (default `alternate`)
- `itemSpacing`: integer px, clamped range (default `32`)
- `dateDisplayMode`: `raw | dmy | my | y` (default `raw`)
- `itemLimit`: integer (`0` = unlimited, default `0`)
- `filterMode`: `none | category | tag | taxonomy` (default `none`)
- `filterTerms`: array of strings (default `[]`)
- `showFilterUI`: boolean (default `false`)
- `displayMode`: `all | pagination | load_more` (default `all`)
- `itemsPerPage`: integer (default `10`)
- `loadMoreLabel`: string (default `Load more`)

## Rendering Order
1. Resolve event list
2. Apply filtering criteria
3. Apply itemLimit and global display transforms
4. Apply paging window (pagination/load_more)
5. Render with orientation/alignment classes

## CSS/Markup Strategy
- Container class additions:
  - `.svt-orientation-vertical`
  - `.svt-orientation-horizontal`
  - `.svt-align-alternate|left|right`
- Keep event markup stable.
- Prefer class-based style application over inline style injection.

## Accessibility
- Filter controls keyboard reachable and labeled.
- Active filter state has clear visual and semantic indicators.
- Pagination and load-more controls use semantic buttons/links with descriptive labels.
- New chunk announcements for assistive technologies when using load-more.

## Performance
- Do not render full event set when paging modes are active.
- Avoid expensive DOM reflows during filter transitions.
- Keep first paint deterministic from server render.

## Backward Compatibility
- Existing blocks with no new attributes render unchanged.
- Legacy shortcode content remains supported.
- Existing per-event class hooks (`title_class`, `date_class`) remain effective.

## Risks and Mitigations
- Risk: CSS regressions between orientations.
  - Mitigation: orientation-specific snapshots and responsive QA matrix.
- Risk: inconsistent state between filter + paging.
  - Mitigation: enforce deterministic order: filter -> page window.
- Risk: frontend/editor parity drift.
  - Mitigation: add editor preview assertions for each display mode.