## ADDED Requirements

### Requirement: Orientation Mode
The timeline container SHALL support two orientations: vertical and horizontal.

#### Scenario: Default orientation remains vertical
- **Given** an existing timeline container without explicit orientation
- **When** the timeline is rendered
- **Then** it SHALL render in vertical mode

#### Scenario: Horizontal orientation on desktop
- **Given** a timeline container with `orientation=horizontal`
- **When** the timeline is rendered on desktop viewport
- **Then** events SHALL render in horizontal flow

#### Scenario: Mobile fallback readability
- **Given** a timeline container with `orientation=horizontal`
- **When** the viewport is mobile-sized
- **Then** the timeline SHALL render in a stacked readable layout

### Requirement: Container Global Settings
The timeline container SHALL expose global controls for alignment, spacing, date display mode, and item limit.

#### Scenario: Alignment mode application
- **Given** `alignmentMode=left`
- **When** rendering events
- **Then** event cards SHALL align to left mode consistently

#### Scenario: Spacing control application
- **Given** `itemSpacing` is set
- **When** rendering event list
- **Then** inter-event spacing SHALL reflect configured spacing value within allowed bounds

#### Scenario: Date display raw mode
- **Given** `dateDisplayMode=raw`
- **When** rendering event date
- **Then** date text SHALL be output unchanged

#### Scenario: Item limit applied
- **Given** `itemLimit=5`
- **When** the event set contains more than five items
- **Then** only the first five items in active sort order SHALL render

### Requirement: Event Filtering
The timeline container SHALL support optional filtering of event subsets.

#### Scenario: Filter disabled default
- **Given** `filterMode=none`
- **When** rendering timeline
- **Then** no filter transformation SHALL be applied

#### Scenario: Filter by configured term
- **Given** filtering is enabled and a valid term is selected
- **When** user activates that term
- **Then** only matching events SHALL be visible

#### Scenario: Empty result state
- **Given** selected filter matches zero events
- **When** rendering filtered output
- **Then** an accessible empty-state message SHALL be shown

### Requirement: Pagination and Load More
The timeline container SHALL support `all`, `pagination`, and `load_more` display modes.

#### Scenario: Pagination mode subset
- **Given** `displayMode=pagination` and `itemsPerPage=10`
- **When** page 2 is selected
- **Then** only events in page 2 window SHALL render

#### Scenario: Load more progressive reveal
- **Given** `displayMode=load_more` and remaining hidden items
- **When** user activates load-more control
- **Then** next chunk SHALL append without replacing existing visible items

#### Scenario: Load more exhausted state
- **Given** no remaining hidden items
- **When** load-more state is recomputed
- **Then** the load-more control SHALL be disabled or hidden

### Requirement: Deterministic Combined Processing
Filtering and paging SHALL be applied in deterministic order.

#### Scenario: Filter and pagination composition
- **Given** active filter and pagination mode
- **When** render pipeline executes
- **Then** filtering SHALL apply before pagination windowing

#### Scenario: Filter and load-more composition
- **Given** active filter and load_more mode
- **When** render pipeline executes
- **Then** chunking SHALL apply on the filtered event set only

### Requirement: Backward Compatibility
New container features SHALL not break existing content.

#### Scenario: Legacy block content unchanged
- **Given** a post saved before these features exist
- **When** rendered after upgrade
- **Then** output SHALL remain equivalent to previous behavior unless user changes new controls

#### Scenario: Shortcode content still valid
- **Given** timeline content created with legacy shortcode
- **When** rendering post frontend
- **Then** shortcode output SHALL continue to function without migration.