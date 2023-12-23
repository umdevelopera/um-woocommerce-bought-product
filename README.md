# Ultimate Member - Bought products

Adds the "Bought products" field and filter based on WooCommerce orders.

## Key features
- Add the "Bought products" field to the profile form builder.
- Add the "Bought products" filter to the member directory (for administrators).
- Adds a widget used to update the `woo_bought_products` user meta manually.
- Automatically updates the `woo_bought_products` user meta for all users on the plugin activation.
- Automatically updates the `woo_bought_products` user meta for a user on the order status change.
- Supports the [High-Performance Order Storage](https://woo.com/document/high-performance-order-storage/) feature since **1.2.0**

## Installation

__Note:__ This plugin requires the [Ultimate Member](https://wordpress.org/plugins/ultimate-member/) and [WooCommerce](https://wordpress.org/plugins/woocommerce/) plugins to be installed first.

### How to install from GitHub

Open git bash, navigate to the **plugins** folder and execute this command:

`git clone --branch=main git@github.com:umdevelopera/um-woocommerce-bought-product.git um-woocommerce-bought-product`

Once the plugin is cloned, enter your site admin dashboard and go to _wp-admin > Plugins > Installed Plugins_. Find the "Ultimate Member - Bought products" plugin and click the "Activate" link.

### How to install from ZIP archive

You can install this plugin from the [ZIP archive](https://drive.google.com/file/d/1DXR9UA_ecmCM6KzwBeTx4FEPB0kylkGl/view?usp=sharing) as any other plugin. Follow [this instruction](https://wordpress.org/support/article/managing-plugins/#upload-via-wordpress-admin).

## How to use

### How to update data

The plugin automatically updates information about bought products for all users on activation. You can use a widget to update information about bought products manually.

Go to *wp-admin > Ultimate Member > Dashboard* to update information about bought products for members. Find the **Bought products** widget and click the **Start** button to run the process. You'll see a progress bar below. Wait until the process will be done.

Image - How to updates information about bought products using a widget.
![UM Dashboard](https://github.com/umdevelopera/um-woocommerce-bought-product/assets/113178913/d6aacb52-03eb-4f1c-a9bd-07b773d64b6a)

Image - Update bought products process.
![UM Dashboard + Update purchased products process](https://github.com/umdevelopera/um-woocommerce-bought-product/assets/113178913/b23bda7c-1312-485e-84b2-1e96cd9211b9)

### How to add the **Bought products** field to profiles

Go to *wp-admin > Ultimate Member > Forms > Default Profile* to add the **Bought products** field to profiles. Click the "+" icon in the **Form Builder**. You will see the **Fields Manager** pop-up. Click the **Bought products** button. A field will be added to the form. Click the **Update** button to save changes. See details [here](https://docs.ultimatemember.com/article/188-how-to-add-fields-to-a-form).

__Note:__ By default this field is visible for the profile owner and administrators.

Image - How to add a field to the Profile form.
![um-woocommerce-bought-product 01-1](https://github.com/umdevelopera/um-woocommerce-bought-product/assets/113178913/7e2bbbb0-0204-4562-9e43-44b856da4b04)

Image - The "Bought products" field in the Profile form.
![um-woocommerce-bought-product 01-2](https://github.com/umdevelopera/um-woocommerce-bought-product/assets/113178913/f758821f-e64b-4586-b6a6-6473d65ba302)

### How to add the **Bought products** filter to the member directory

Go to *wp-admin > Ultimate Member > Member Directories > Edit* to add the **Bought products** filter to the member directory. Scroll down to the **Search Options** section. Turn on the **Enable Filters feature** setting and you will see the **Choose filter(s) meta to enable** setting below. Click the **Add New Custom Field** button to add a new filter. Choose the **Bought products** in the field that appears. Click the **Update** button to save the changes. See details [here](https://docs.ultimatemember.com/article/1513-member-directories-2-1-0#search).

__Note:__ By default this filter is visible for administrators.

Image - How to add a filter to the Member Directory.
![um-woocommerce-bought-product 02-1](https://github.com/umdevelopera/um-woocommerce-bought-product/assets/113178913/0ca53adc-6a2f-4202-b195-b478f8c41baf)

Image - The "Bought products" filter in the Member Directory.
![um-woocommerce-bought-product 02-2](https://github.com/umdevelopera/um-woocommerce-bought-product/assets/113178913/77bb7790-1d73-424d-941f-0c8bc7cba290)

### Hooks

**um_woocommerce_bought_product_can_view_field** - allows displaying the "Bought products" filter for everyone.
Example:
`add_filter( 'um_woocommerce_bought_product_can_view_field', '__return_true', 10, 1 );`

## Support

This is a free extension created for the community. The Ultimate Member team does not provide support for this extension.
Open new [issue](https://github.com/umdevelopera/um-woocommerce-bought-product/issues) if you are facing a problem or have a suggestion.

### Related links

Ultimate Member home page: https://ultimatemember.com/

Ultimate Member documentation: https://docs.ultimatemember.com/

Ultimate Member on wordpress.org: https://wordpress.org/plugins/ultimate-member
