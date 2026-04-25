# CLAUDE.md

This file provides guidance to Claude Code (claude.ai/code) when working with code in this repository.

## What this plugin does

A WordPress plugin that registers a single Elementor widget called **Interactive Questionnaire**. The widget presents a series of questions with 0–3 rating buttons, accumulates scores per category, and displays a horizontal bar chart of results. It has no server-side storage — everything is calculated in the browser.

## File structure and responsibilities

| File | Role |
|---|---|
| `elementor-questionaire.php` | Plugin entry point. Registers the widget via `elementor/widgets/register`, enqueues CSS and JS via `wp_enqueue_scripts`. Defines `QUESTIONNAIRE_VERSION` constant — **bump this constant whenever CSS or JS changes** to bust browser caches. |
| `widgets/questionaire-widget.php` | The `Questionnaire_Widget` class (extends `Widget_Base`). Defines all Elementor controls (content + style tabs) and renders the HTML. Loads defaults from `defaults/questionnaire-defaults.php` at the top of `register_controls()`. |
| `assets/questionaire-widget.css` | Static styles. Uses plain class selectors (no `{{WRAPPER}}` scoping), so Elementor's dynamic CSS wins via higher specificity. Do **not** use `!important` here — it would block Elementor style controls from taking effect. |
| `assets/questionaire-widget.js` | All client-side logic. Finds every `.questionnaire-container[data-questions]` on the page and calls `initQuestionnaire()` for each, supporting multiple widget instances per page. Reads per-instance data from `data-questions` and `data-result-types` HTML attributes (jQuery parses these to JS objects automatically). |
| `defaults/questionnaire-defaults.php` | Returns a PHP array with `questions` and `result_types` keys. Edit this file to change or extend the default content — no widget code changes needed. |

## Architecture: how data flows

1. **PHP → HTML attributes**: `render()` JSON-encodes `$settings['questions']` and `$settings['result_types']` into `data-questions` / `data-result-types` attributes on the `.questionnaire-container` div using `wp_json_encode()` + `esc_attr()`.
2. **JS reads attributes**: jQuery's `.data()` auto-parses the JSON. `data-result-types` is accessed as `container.data('resultTypes')` (jQuery camelCases hyphenated attribute names).
3. **Scoring**: each `.rating-button` carries `data-value` (0–3) and `data-mappings` (a `result_id` string). Clicks accumulate `sumOfPoints[mappings] += value`. On the last question, scores are sorted descending and expressed as percentages relative to the highest score (top result always shows 100 %).
4. **Editor preview**: `render()` outputs static placeholder result bars visible only in edit mode (`$editMode` flag). `content_template()` provides the live JS template for the Elementor editor panel.

## Elementor-specific conventions

- Style controls use `'selectors' => ['{{WRAPPER}} .some-class' => 'property: {{VALUE}};']`. The `{{WRAPPER}}` prefix gives Elementor's CSS higher specificity than the static stylesheet, so the control wins without needing `!important`.
- The one legitimate use of `!important` in a selector is `result_title_padding`, which overrides theme heading styles.
- Widget registration uses the current API: hook `elementor/widgets/register`, method `$widgets_manager->register()`. The deprecated `elementor/widgets/widgets_registered` / `register_widget_type()` pair must not be reintroduced.
- `get_script_depends()` and `get_style_depends()` return `['questionnaire-widget']`, matching the handles used in `wp_enqueue_scripts`.

## Versioning rule

If a new version of the plugin should be bundled, be sure to adapt the version-number in the file `elementor-questionaire.php` at two locations:
- In the comment header
- In the variable `QUESTIONNAIRE_VERSION`
