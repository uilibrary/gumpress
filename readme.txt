=== Gumpress ===
Contributors: uilib
Tags: gumroad, gumroad store, gumroad checkout, woocommerce
Requires at least: 4.7
Tested up to: 5.8
Stable tag: 1.0.0
Requires PHP: 7.0
License: GPLv2 or later
License URI: https://www.gnu.org/licenses/gpl-2.0.html

Sync and checkout with Gumroad for personalized Gumroad storefront.

== Description ==

Gumpress is a woocommerce extension that allows you to import Gumroad products into your woocommerce store. It allows you to create a personalized gumroad storefront using any woocommerce theme.

Customers can purchase your gumroad products through your woocommerce website. Gumpress replaces the default buy button (checkout system) in woocommerce with the gumroad checkout popup.

When you want to update your gumroad product (product thumbnail, description, price, etc.), simply go to your wordpress admin panel and click "Sync products." And all of your products will be instantly synchronized.

Gumpress also syncs your gumroad product versions with your woocommerce variable product.
Customers will see a price range on your woocommerce single product page and shop page as a result.

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

== Changelog ==

= 1.0 =
* Initial release