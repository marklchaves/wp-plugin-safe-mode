plugin-safe-mode
================

Enables a debugging safe mode by preventing any plugins from loading.

## Installation
Add the `plugin-safe-mode.php` file to your `/wp-content/mu-plugins/` folder. Create the `mu-plugins` directory if you don't have one.

**Note**: Copy only the PHP file not the directory that the file is in.

---

## Usage 

To activate **safe mode**:

- Add `define( 'WP_DISABLE_PLUGINS', true );` to your wp-config.php file.
- Append the query string `?safe_mode=true` to any url to load that post or page with no plugins running.
- Append `&p1=plugin-slug1` to load the page with only the plugin you specify. The plugin slug is the name of the plugin's directory under `/wp-content/plugins/`.
- Append `&p2=plugin-slug2` to load the page with a second active plugin.
- Append `&np=plugin-slug0` to load the page with only this plug deactivated (turned off). This argument overrides `p1` and `p2`. Meaning if `np` is passed in and `p1` or `p2` are also in the URL, then `p1` and `p2` are ignored. All other active plugins stay on.

### Examples

- View the default sample page with no plugin running `https://twenty-twentyone.local/sample-page/?safe_mode=true`
- View the sample page with only **Query Monitor** running `https://twenty-twentyone.local/sample-page/?safe_mode=true&p1=query-monitor`
- View the sample page with only **Query Monitor** and **Popup Maker** running `https://twenty-twentyone.local/sample-page/?safe_mode=true&p1=query-monitor&p2=popup-maker`
- View the sample page with only **Content Control** turned off and all other active plugins stay on `https://twenty-twentyone.local/sample-page/?safe_mode=true&np=content-control`