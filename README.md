# WooCommerce Tools

Adds more features for UM integration with the WooCommerce plugin.

## Key features

1. Bought products
- Add the "Bought products" field to the profile form builder.
- Add the "Bought products" filter to the member directory.
- Adds a widget used to update information about bought products manually.
- Automatically updates information about bought products for all users on activation.
- Automatically updates information about bought products for a user on the order status change.
2. Subscriptions
- Allow removing other roles when assign a role on subscription status change.

## Installation

__Note:__ This plugin requires the [Ultimate Member](https://wordpress.org/plugins/ultimate-member/) and [WooCommerce](https://wordpress.org/plugins/woocommerce/) plugins to be installed first.

### How to install from GitHub

Open git bash, navigate to the **plugins** folder and execute this command:

`git clone --branch=main git@github.com:umdevelopera/um-woocommerce-tools.git um-woocommerce-tools`

Once the plugin is cloned, enter your site admin dashboard and go to _wp-admin > Plugins > Installed Plugins_. Find the "Ultimate Member - Bought products" plugin and click the "Activate" link.

### How to install from ZIP archive

You can install the plugin from this [ZIP file](https://drive.google.com/file/d/1KSuR9TA-ZoQY6H-aOStzX1qo1eY4xcBK/view) as any other plugin. Follow [this instruction](https://wordpress.org/support/article/managing-plugins/#upload-via-wordpress-admin).

## How to use

### How to add the "Bought products" field to profiles

Go to *wp-admin > Ultimate Member > Forms > Default Profile* to add the **Bought products** field to profiles. Click the "+" icon in the **Form Builder**. You will see the **Fields Manager** pop-up. Click the **Bought products** button. A field will be added to the form. Click the **Update** button to save changes. See details [here](https://docs.ultimatemember.com/article/188-how-to-add-fields-to-a-form).

![UM Forms, Edit Form (Bought products)](https://github.com/user-attachments/assets/8f8bb8c0-2a57-43d5-94aa-29ee470f27a9)

The **Bought products** field is visible for the profile owner and administrators. Change the field's **Privacy** option if you want to make the field visible to others.

![Profile + Bought products](https://github.com/user-attachments/assets/c6d2a47c-f366-40fb-bdab-51b14646926c)

### How to add the "Bought products" filter to the member directory

Go to *wp-admin > Ultimate Member > Member Directories > Edit* to add the **Bought products** filter to the member directory. Scroll down to the **Search Options** section. Turn on the **Enable Filters feature** setting and you will see the **Choose filter(s) meta to enable** setting below. Click the **Add New Custom Field** button to add a new filter. Choose the **Bought products** in the field that appears. Click the **Update** button to save the changes. See details [here](https://docs.ultimatemember.com/article/1513-member-directories-2-1-0#search).

![UM Member Directories, Edit + Search Options (Bought products)](https://github.com/user-attachments/assets/2ec55917-510b-4f35-85b7-ef6a410d5c49)

The **Bought products** filter is visible for administrators and roles that can edit other member accounts. Use the `um_woocommerce_bought_product_can_view_field` filter hook if you want to make the filter visible to others.

![filter in the member directory](https://github.com/user-attachments/assets/d1eb3e4d-260c-4966-9ee3-4b2012826476)

### How to update data manually

The plugin automatically updates information about bought products for all users on activation. You can use a widget to update information about bought products manually.

Go to _wp-admin > Ultimate Member > Dashboard_, find the **Bought products** widget and click the **Start** button to run the process. You'l see a progress bar below. Wait until the process will be done.

![UM Dashboard + Create or update bought products usermeta](https://github.com/user-attachments/assets/71393ca6-139e-4b2f-ad44-1fb8fc446cfb)

### How to remove other roles on subscription change

The "Ultimate Member - WooCommerce" plugin does not remove all roles when the subscription status is changed. Only a role previously assigned by the tool is removed. This logic is chosen to avoid conflicts with other plugins. You may want to remove all other roles when subscription is purchased or expire. This plugin adds a feature you need.

Go to _wp-admin > Ultimate Member > Settings > Extensions > Woocommerce_ and choose **Yes** in the **Remove other roles when assign a role on subscription status change** setting.

![UM Settings, Extensions, WooCommerce](https://github.com/user-attachments/assets/4d8e0990-3fad-43bf-902a-fdbd30f60d42)

## Support

This is a free extension created for the community. The Ultimate Member team does not provide support for this extension.
Open new [issue](https://github.com/umdevelopera/um-woocommerce-tools/issues) if you are facing a problem or have a suggestion.

**Give a star if you think this extension is useful. Thanks.**

## Useful links

[Ultimate Member core plugin info and download](https://wordpress.org/plugins/ultimate-member)

[Documentation for Ultimate Member](https://docs.ultimatemember.com)

[Official extensions for Ultimate Member](https://ultimatemember.com/extensions/)

[Free extensions for Ultimate Member](https://docs.google.com/document/d/1wp5oLOyuh5OUtI9ogcPy8NL428rZ8PVTu_0R-BuKKp8/edit?usp=sharing)

[Code snippets for Ultimate Member](https://docs.google.com/document/d/1_bikh4JYlSjjQa0bX1HDGznpLtI0ur_Ma3XQfld2CKk/edit?usp=sharing)
