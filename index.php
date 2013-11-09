
<!DOCTYPE html>
<!--[if IE 8]>    <html class="no-js lt-ie9" lang="en"> <![endif]-->
<!--[if gt IE 8]><!--> <html class="no-js" lang="en"> <!--<![endif]-->
<head>
  <meta charset="utf-8" />

  <!-- Set the viewport width to device width for mobile -->
  <!-- <meta name="viewport" content="width=device-width" /> -->

  <title>Image Mosaicifier</title>

  <link rel="stylesheet" href="css/normalize.css">
  <link rel="stylesheet" href="css/foundation.css">
  <link rel="stylesheet" href="css/app.css">

  <script src="js/vendor/custom.modernizr.js"></script>

</head>
<body>

  <div class="container">
	  <header class="row">
	  	<?php include 'logo.php'; ?>
	  </header>

	  <div class="row">
	  	<form method="get" action="encode.php">
        <div class="columns large-6">
  		  	<label for="image-url">Image Url</label>
  		  	<input type="text" id="image-url" name="image_url" required />
        </div>
		  	<div class="columns large-6">
          <label for="sharpness">Sharpness</label>
  		  	<input type="number" min="10" max="300" steps="1" value="10" id="sharpness" name="sharpness" required />
        </div>
        <div class="columns large-1 push-right">
		  	 <button type="submit">Go</button>
        </div>
	  	</form>
	  </div>
    <div class="row">
      <div class="toggle" style="display: none;">Toggle</div>
    </div>
	  <div class="row mosaic">
	  </div>
  </div>

  <script>
  document.write('<script src=js/vendor/' +
  ('__proto__' in {} ? 'zepto' : 'jquery') +
  '.js><\/script>')
  </script>
  <script src="js/vendor/jquery.js"></script>
  <script src="js/app.js"></script>
  <!-- End Footer -->
</body>
</html>
