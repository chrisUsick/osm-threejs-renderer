<!doctype html>
<html lang="">
  <head>
    <meta charset="utf-8">
    <meta name="description" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>OSM threejs renderer</title>

    <link rel="apple-touch-icon" href="apple-touch-icon.png">
    <!-- Place favicon.ico in the root directory -->

    <!-- build:css styles/vendor.css -->
    <!-- bower:css -->
    <link rel="stylesheet" href="/bower_components/bootstrap/dist/css/bootstrap.css" />
    <!-- endbower -->
    <!-- endbuild -->

    <!-- build:css styles/main.css -->
    <link rel="stylesheet" href="styles/main.css">
    <!-- endbuild -->

  </head>
  <body>
    <!--[if lt IE 10]>
      <p class="browserupgrade">You are using an <strong>outdated</strong> browser. Please <a href="http://browsehappy.com/">upgrade your browser</a> to improve your experience.</p>
    <![endif]-->

    <div class="container">
      <div class="header">
        <ul class="nav nav-pills pull-right">
          <li class="active"><a href="#">Home</a></li>
        </ul>
        <h3 class="text-muted">osm threejs renderer</h3>
      </div>


      <div id="three">
      </div>
      <div class="footer">
        <p>♥ from the Yeoman team</p>
      </div>
    </div>

    <!-- Google Analytics: change UA-XXXXX-X to be your site's ID. -->
    <script>
      (function(b,o,i,l,e,r){b.GoogleAnalyticsObject=l;b[l]||(b[l]=
      function(){(b[l].q=b[l].q||[]).push(arguments)});b[l].l=+new Date;
      e=o.createElement(i);r=o.getElementsByTagName(i)[0];
      e.src='https://www.google-analytics.com/analytics.js';
      r.parentNode.insertBefore(e,r)}(window,document,'script','ga'));
      ga('create','UA-XXXXX-X');ga('send','pageview');
    </script>

    <!-- build:js scripts/vendor.js -->
    <!-- bower:js -->
    <script src="/bower_components/jquery/dist/jquery.js"></script>
    <script src="/bower_components/three.js/three.js"></script>
    <script src="/bower_components/bluebird/js/browser/bluebird.js"></script>
    <!-- endbower -->
    <!-- endbuild -->

    <!-- build:js scripts/plugins.js -->
    <script src="/bower_components/bootstrap/js/affix.js"></script>
    <script src="/bower_components/bootstrap/js/alert.js"></script>
    <script src="/bower_components/bootstrap/js/dropdown.js"></script>
    <script src="/bower_components/bootstrap/js/tooltip.js"></script>
    <script src="/bower_components/bootstrap/js/modal.js"></script>
    <script src="/bower_components/bootstrap/js/transition.js"></script>
    <script src="/bower_components/bootstrap/js/button.js"></script>
    <script src="/bower_components/bootstrap/js/popover.js"></script>
    <script src="/bower_components/bootstrap/js/carousel.js"></script>
    <script src="/bower_components/bootstrap/js/scrollspy.js"></script>
    <script src="/bower_components/bootstrap/js/collapse.js"></script>
    <script src="/bower_components/bootstrap/js/tab.js"></script>
    <!-- endbuild -->

    <!-- build:js scripts/main.js -->
    <script src="dist/scripts/browser-polyfill.min.js"></script>
    <script src="dist/scripts/environment.js"></script>
    <script src="dist/scripts/main.js"></script>

    <!-- <script src="scripts/environment.js"></script>
    <script src="scripts/main.js"></script> -->
    <!-- endbuild -->
  </body>
</html>
