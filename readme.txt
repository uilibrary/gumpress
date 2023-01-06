=== Gumpress ===
Contributors: uilib
Tags: gumroad, gumroad store, gumroad checkout, woocommerce
Requires at least: 4.7
Tested up to: 6.1.1
Stable tag: 1.2.1
Requires PHP: 7.0
License: GPLv2 or later
License URI: https://www.gnu.org/licenses/gpl-2.0.html

Sync and checkout with Gumroad for personalized Gumroad storefront.

== Description ==

Gumpress is a woocommerce extension that allows you to import Gumroad products into your woocommerce store. It allows you to create a personalized gumroad storefront using any woocommerce theme.

## How to use?
[youtube https://www.youtube.com/watch?v=tmzzT0v1joc]

[Demo website](https://gumpress.io/demo1/)

Customers can purchase your gumroad products through your woocommerce website. Gumpress replaces the default buy button (checkout system) in woocommerce with the gumroad checkout popup.

When you want to update your gumroad product (product thumbnail, description, price, etc.), simply go to your wordpress admin panel and click "Sync products." And all of your products will be instantly synchronized.

Gumpress also syncs your gumroad product versions with your woocommerce variable product.
Customers will see a price range on your woocommerce single product page and shop page as a result.

## Key features
* Import product from Gumroad
* Integrate Gumroad checkout with Woocommerce
* Varaible product support

## Works with any Woocommerce theme
You can use any woocommerce theme to build your gumroad store.

## Works with woocommerce shortcodes
To display your products, you can use woocommerce short codes or simply a "Buy now" button.
Because your products are synchronized with gumroad, when a user clicks the "Buy now" button, the Gumroad checkout popup appears.

* `[add_to_cart id="1652"]` shows "buy now button".
* `[product_page id="1652"]` show single product page
* `[products]` shows shop page.

`id` is your Woocommerce product ID (not Gumroad product ID) as it is already connected
to Gumroad.

## Features
* Personalized Gumroad storefront.
* Import Gumroad products to your woocommerce website.
* Integrate Gumroad checkout system.
* Sync Gumroad products with your woocommerce products.
* Import Gumroad product version as woocommerce variable product.
* Compatible with the woocommerce shortcodes.
* [Request features](https://github.com/uilibrary/gumpress/issues)

[Bug Report](https://github.com/uilibrary/gumpress/issues) | [Support](mailto:support@ui-lib.com)

== Screenshots ==
1. Gumpress settings and Sync product
2. Woocommerce theme connected to gumroad

== Frequently Asked Questions ==

= How can I update my products? =

Just click "Sync Products" button in gumpress admin page. All of your products will be
synchronized with your gumroad products.

= Can I use any woocommerce theme? =

Yes, you can use any woocommerce theme.

== Changelog ==

= 1.0.0 =
* Initial release

= 1.0.1 =
* removed function array_key_last

= 1.1.0 =
* updated: thumbnail upload
* added: plugin action link
* fixed: import only published
* added: variation select
* updated: variable product button

= 1.1.1 =
* added: error code to error message

= 1.2.0 =
* added: Product title, description reset options

= 1.2.1 =
* fixed: Open overlay issue