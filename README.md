## CSS/JS Cache Buster for Magento

This Magento extension allows you to automatically add a query string to CSS and JS files to help bust browser caches.

But wait! This extension does not rewrite the Mage_Page_Block_Html_Head block like other similar extensions do. This is crucially important as it means it has greater compatibility with many other extensions that already rewrite that same block.

### Features

- Helps bust browser caches by adding a defined query string to JS and CSS assets.
- Uses no rewrites! Does not rewrite the Mage_Page_Block_Html_Head block like other similar extensions.
- Admin setting to define what query string to add.
- Clean code.

### Compatibility

Tested on Magento CE 1.9.3.2. Should work on lower versions and equivalent EE. Almost certainly doesn't work with FPC.

### How to use?

1. Enable the extension under System -> Configuration -> Leytech Extensions.
2. Enter the version number to append.
3. Flush the cache.
4. Repeat steps 2 and 3 when you make changes to JS and CSS assets and wish to force browsers to re-download them.

### Screenshots

Coming soon....

### To do

1. Nothing... please add issues for any feature requests.

### Support

This extension is provided free of charge as-is. We don't provide free support.

### Contribute

Pull requests and feedback welcome.