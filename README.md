image-mosaicifier
=================

Turns images into html tables, that you could send through email if you really wanted to.

There is even an attempt to generate all the html that you would need to send the image with an image replacement so the image will show up in the place of the table when they click "show images" in their email client.

The demo `index.php` page only does the image -> table conversion, there is a different function (`generate`) in the class to generate the html + image replacement page.