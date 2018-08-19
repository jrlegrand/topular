<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<title>Signup for Topular</title>
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta name="description" content=Signup for Topular">
<meta name="author" content="Topular">

<link href="assets/css/bootstrap.css" rel="stylesheet">
<link href="assets/css/bootstrap-responsive.css" rel="stylesheet">
<link href="assets/css/custom.css" rel="stylesheet">

<!-- HTML5 shim, for IE6-8 support of HTML5 elements -->
<!--[if lt IE 9]>
      <script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
<![endif]-->

</head>

<body>
	<div class="container">
      <div class="row" id="header">
      	<div class="span12">
       	 <h1><a href="#"><span id="it"><i class="icon-star"></i>ITS <i class="icon-star"></i></span><span id="beta">BETA</span></a></h1>
        </div><!--end span12-->        
      </div><!--end row-->
      
      <div class="row" id="catchycontent">
      	<div class="span12">
        <h2>Stay tuned, we are launching very soon... </h2>        
        <p>ITS BETA is working hard to launch a new site that's going to revolutionize the way you do business. Leave us your email below, and we'll notify you the minute we open the doors. </p>        
        </div><!--end span12-->            
      </div><!--end row-->
      
      <div class="row" id="subscribe">
      
      	<div id="mc_embed_signup">
            <form action="http://doozypixels.us5.list-manage.com/subscribe/post?u=f0d1850fbb2d2d2d531287d35&amp;id=c74a5c548f" method="post" id="mc-embedded-subscribe-form" name="mc-embedded-subscribe-form" class="validate form-inline" target="_blank">	
            <input type="email" value="" name="EMAIL" class="span4 input-large email" id="mce-EMAIL" placeholder="email address" required="">
            <input type="submit" value="Subscribe" name="subscribe" id="mc-embedded-subscribe" class="btn btn-success btn-large">
        </form>
        </div>
      </div><!--end row-->
      
      <div class="row" id="features">
      	<div class="span3 divider">
        	<div class="featureicon"><i class="icon-resize-full"></i></div>
            <h3>Responsive</h3>
            <p>Talk about one of the biggest features that your new website is going to have.</p>
        </div>        
        <div class="span3 divider">
        	<div class="featureicon"><i class="icon-flag"></i></div>
            <h3>Font Awesome Icons</h3>
            <p>Talk about one of the biggest features that your new website is going to have.</p>
        </div>       
        <div class="span3 divider">
        	<div class="featureicon"><i class="icon-envelope"></i></div>
            <h3>Mail Chimp Signup Form</h3>
            <p>Talk about one of the biggest features that your new website is going to have.</p>
        </div>
         <div class="span3">
        	<div class="featureicon"><i class="icon-font"></i></div>
            <h3>Google WebFonts</h3>
            <p>Talk about one of the biggest features that your new website is going to have.</p>
        </div>
      </div><!--end row-->
      
      <div class="row" id="footer">
      <h4>For more details leading up to our launch <br>follow us on twitter</h4>
      <div class="footericon"><a href="https://twitter.com/madebyraj"><i class="icon-twitter-sign"></i></a></div>
      <p>©2012 Its Beta. All rights reserved.</p>
      </div><!--end row-->      
      </div><!--end container-->     
      <script type="text/javascript" src="assets/js/jquery.js"></script>
      <script type="text/javascript" src="assets/js/cookie.js"></script>                         
      <script type="text/javascript">
	  if($.cookie("css")) {
         $("#change").attr("href",$.cookie("css"));
      }
      $(document).ready(function() { 
      $("a.color-box").click(function() { 
         $("#change").attr("href",$(this).attr('rel'));		 
         $.cookie("css",$(this).attr('rel'), {expires: 365, path: '/'});
         return false;
      });	 
	  });
      </script>
      <script type="text/javascript" src="assets/js/respond.js"></script>
  
</body>
<!-- Le javascript
    ================================================== --> 
<!-- Placed at the end of the document so the pages load faster --> 

<!--[if lt IE 7]><p class="chromeframe">You are using an outdated browser. <a href="http://browsehappy.com/">Upgrade your browser today</a> or <a href="http://www.google.com/chromeframe/?redirect=true">install Google Chrome Frame</a> to better experience this site.</p><![endif]--> 
<script src="http://code.jquery.com/jquery-1.9.0.min.js" type="text/javascript"></script> 
<script src="assets/js/bootstrap-transition.js"></script> 
<script src="assets/js/bootstrap-modal.js"></script> 

<!-- Feedback -->
<div id="myModal1" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
    <h3 id="myModalLabel">Feedback Form</h3>
  </div>
  <div class="modal-body">
    <form class="form-horizontal">
      <div class="control-group">
        <label class="control-label" for="inputName">Name</label>
        <div class="controls">
          <input type="text" id="inputName" placeholder="Name" required>
        </div>
      </div>
      <div class="control-group">
        <label class="control-label" for="inputEmail">Email</label>
        <div class="controls">
          <input type="text" id="inputEmail" placeholder="Email" required>
        </div>
      </div>
      <div class="control-group">
        <label class="control-label" for="inputPassword">Message</label>
        <div class="controls">
          <textarea placeholder="Your message..."></textarea>
        </div>
      </div>
    </form>
  </div>
  <div class="modal-footer">
    <button class="btn" data-dismiss="modal" aria-hidden="true">Cancel</button>
    <button class="btn btn-primary">Send</button>
  </div>
</div>

<!-- Privacy and Terms -->
<div id="myModal2" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
    <h3 id="myModalLabel">Feedback Form</h3>
  </div>
  <div class="modal-body"> 
    <!-- start slipsum code --> 
    
    <strong>We happy?</strong>
    <p>Your bones don't break, mine do. That's clear. Your cells react to bacteria and viruses differently than mine. You don't get sick, I do. That's also clear. But for some reason, you and I react the exact same way to water. We swallow it too fast, we choke. We get some in our lungs, we drown. However unreal it may seem, we are connected, you and I. We're on the same curve, just on opposite ends. </p>
    <strong>Uuummmm, this is a tasty burger!</strong>
    <p>Now that we know who you are, I know who I am. I'm not a mistake! It all makes sense! In a comic, you know how you can tell who the arch-villain's going to be? He's the exact opposite of the hero. And most times they're friends, like you and me! I should've known way back when... You know why, David? Because of the kids. They called me Mr Glass. </p>
    <strong>No man, I don't eat pork</strong>
    <p>Normally, both your asses would be dead as fucking fried chicken, but you happen to pull this shit while I'm in a transitional period so I don't wanna kill you, I wanna help you. But I can't give you this case, it don't belong to me. Besides, I've already been through too much shit this morning over this case to hand it over to your dumb ass. </p>
    
    <!-- please do not remove this line -->
    
    <div style="display:none;"> <a href="http://slipsum.com">lorem ipsum</a></div>
    
    <!-- end slipsum code --> 
    
  </div>
  <div class="modal-footer">
    <button class="btn" data-dismiss="modal" aria-hidden="true">Close</button>
  </div>
</div>
</body>
</html>
