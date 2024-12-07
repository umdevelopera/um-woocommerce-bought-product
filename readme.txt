=== Ultimate Member - Bought products ===

Author: umdevelopera
Author URI: https://github.com/umdevelopera
Plugin URI: https://github.com/umdevelopera/um-woocommerce-bought-product
Tags: ultimate member, woocommerce, bought products, field, filter
License: GNU Version 2 or Any Later Version
License URI: http://www.gnu.org/licenses/gpl-3.0.txt

Requires at least: 6.5
Tested up to: 6.7.2
Requires UM core at least: 2.6.8
Tested UM core up to: 2.9.2
Stable tag: 1.2.2

== Description ==

Adds the "Bought products" field and filter based on WooCommerce orders.

= Key Features =

- Adds the "Bought products" field to the profile form builder.
- Adds the "Bought products" filter to the member directory.
- Adds a widget used to update information about bought products manually.
- Automatically updates information about bought products for all users on the plugin activation.
- Automatically updates information about bought products for a user on the order status change.
- Supports the High-Performance Order Storage (HPOS) feature since 1.2.0.

== Installation ==

Note: This plugin requires the "Ultimate Member" and "WooCommerce" plugins to be installed first.

You can install this plugin from the ZIP file as any other plugin.
Download ZIP file from GitHub or Google Drive. You can find download links here: https://github.com/umdevelopera/um-woocommerce-bought-product

Follow this instruction: https://wordpress.org/support/article/managing-plugins/#upload-via-wordpress-admin

== Documentation & Support ==

This is a free extension created for the community. The Ultimate Member team does not provide support for this extension.
Open new issue in the GitHub repository if you are facing a problem or have a suggestion: https://github.com/umdevelopera/um-woocommerce-bought-product/issues

Documentation is the README section in the GitHub repository: https://github.com/umdevelopera/um-woocommerce-bought-product

== Changelog ==

= 1.2.2: December 7, 2024 =

	- Fixed: The "Bought products" filter visibility.
	- Tweak: The "Bought products" field icon.
	- Tweak: Avoid using the "plugins_loaded" hook.

= 1.2.1: November 17, 2024 =

	- Fixed: "Load textdomain just in time" issue.

= 1.2.0: December 24, 2023 =

	- Added: Support of the High-Performance Order Storage (HPOS) feature.
	- Fixed: Error on activation without WooCommerce.
	- Tweak: The "Bought products" field is hidden for non-profile forms.
	- Tweak: Documentation updated.

= 1.1.0: September 12, 2023 =

	- Added: Dashboard widget with a tool "Create or update bought products usermeta"

= 1.0.1: July 20, 2023 =

	- Added: Filter 'um_woocommerce_bought_product_can_view_field' that allows displaying the "Bought products" filter for everyone.
	- Fixed: The core 2.6.7 version compatibility.

= 1.0.0: June 30, 2023 =

	- Initial release.