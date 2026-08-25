## 1. P1.1 Horizontal Mode
- [ ] 1.1 Add `orientation` attribute to timeline container block schema.
- [ ] 1.2 Add Inspector control for vertical/horizontal orientation.
- [ ] 1.3 Add orientation wrapper classes in server render.
- [ ] 1.4 Implement horizontal CSS layout with mobile fallback.
- [ ] 1.5 Validate no regression for current vertical default.

## 2. P1.3 Container-Level Settings
- [ ] 2.1 Add attributes: alignmentMode, itemSpacing, dateDisplayMode, itemLimit.
- [ ] 2.2 Add Inspector controls with defaults and validation ranges.
- [ ] 2.3 Apply settings in render pipeline and wrapper classes.
- [ ] 2.4 Preserve per-event class behavior for title/date hooks.
- [ ] 2.5 Add tests for persistence across save/reload.

## 3. P2.4 Event Filtering
- [ ] 3.1 Add attributes: filterMode, filterTerms, showFilterUI.
- [ ] 3.2 Implement filter UI rendering (optional) at container top.
- [ ] 3.3 Implement runtime filtering without full page reload.
- [ ] 3.4 Add empty-state handling for no matching events.
- [ ] 3.5 Add keyboard and ARIA coverage tests.

## 4. P2.5 Pagination / Load More
- [ ] 4.1 Add attributes: displayMode, itemsPerPage, loadMoreLabel.
- [ ] 4.2 Implement pagination controls and deterministic page windows.
- [ ] 4.3 Implement load-more chunk append behavior.
- [ ] 4.4 Ensure exhaustion state disables/hides load-more correctly.
- [ ] 4.5 Validate combined behavior with active filters.

## 5. Documentation and QA
- [ ] 5.1 Update readme feature matrix and usage examples.
- [ ] 5.2 Update admin Information manual with new controls.
- [ ] 5.3 Add responsive/browser QA matrix evidence.
- [ ] 5.4 Add regression tests for shortcode compatibility.