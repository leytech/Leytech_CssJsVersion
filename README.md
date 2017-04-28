## CSS/JS Cache Buster for Magento

This Magento extension allows you to automatically add a version number to CSS and JS files to help bust browser caches.

Unlike other similar extensions this extension does not rewrite the Mage_Page_Block_Html_Head block. This is crucially important as it means it has greater compatibility with many other extensions that already rewrite that same block.

### Features

- Helps bust browser caches by adding a defined query string to JS and CSS assets.
- Uses no rewrites! Does not rewrite the Mage_Page_Block_Html_Head block like other similar extensions.
- Admin setting to define what query string / version to append.
- Clean code.

### Compatibility

Tested on Magento CE 1.9.3.2. Should work on lower versions and equivalent EE. Almost certainly doesn't work with FPC.

### How to use?

1. Enable the extension under System -> Configuration -> Leytech Extensions.
2. Enter the version number to append.
3. Flush the cache.
4. Repeat steps 2 and 3 when you make changes to JS and CSS assets and wish to force browsers to re-download them.

### Screenshots

Without this extension:

![No CSS/JS version](https://cloud.githubusercontent.com/assets/1577895/25537596/0c67aedc-2c37-11e7-84e7-fa29f51a3754.png "No CSS/JS version")

With this extension:

![Appended CSS/JS version](https://cloud.githubusercontent.com/assets/1577895/25537595/0c46ba56-2c37-11e7-9cd6-a9611d1265b8.png "Appended CSS/JS version")

### To do

1. Possibly make an option to automatically update the version when the cache is cleared.

### Support

This extension is provided free of charge as-is. We don't provide free support.

### Contribute

Pull requests and feedback welcome.