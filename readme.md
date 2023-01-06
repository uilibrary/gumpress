# Gumpress

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

### Changelog

* 1.0.0
    * Initial release
* 1.0.1
    * removed function array_key_last
* 1.1.0
    * updated: thumbnail upload
    * added: plugin action link
    * fixed: import only published
    * added: variation select
    * updated: variable product button
* 1.1.1
    * added: error code to error message
* 1.2.0
    * added: Product title, description reset options
* 1.2.1
    * fixed: Open overlay issue

### Roadmap
* Out of stok prodcut
* Affiliated products going to external page
* Same product order/sort as Gumroad
* Additional information/ Versions