<?php
/* @var $this SiteController */

$this->pageTitle = 'Topular';

if (!Yii::app()->user->isGuest) $this->redirect($this->createUrl('article/index', array('city'=>Yii::app()->user->city)));
?>
   <style>
	
    /* MARKETING CONTENT
    -------------------------------------------------- */

    /* Center align the text within the three columns below the carousel */
    .marketing .span4 {
      text-align: center;
    }
    .marketing h2 {
      font-weight: normal;
    }
    .marketing .span4 p {
      margin-left: 10px;
      margin-right: 10px;
    }


    /* Featurettes
    ------------------------- */

    .featurette-divider {
      margin: 80px 0; /* Space out the Bootstrap <hr> more */
    }
    .featurette {
      padding-top: 60px; /* Vertically center images part 1: add padding above and below text. */
      overflow: hidden; /* Vertically center images part 2: clear their floats. */
    }
    .featurette-image {
      margin-top: -60px; /* Vertically center images part 3: negative margin up the image the same amount of the padding to center it. */
    }
    
    .featurette-icon-right {
      margin-top: -60px; /* Vertically center images part 3: negative margin up the image the same amount of the padding to center it. */
    }
    
     .featurette-icon-left {
      margin-top: -60px; /* Vertically center images part 3: negative margin up the image the same amount of the padding to center it. */
    }
    
     .featurette-login {
     	text-align: center;
    }

    /* Give some space on the sides of the floated elements so text doesn't run right into it. */
    .featurette-image.pull-left {
      margin-right: 40px;
       font-size: 50px;
    }
    .featurette-image.pull-right {
      margin-left: 40px;
       font-size: 50px;
    }
    .featurette-icon-right {
      margin-left: 40px;
    	font-size: 150px;
    	float: right;
    }
      .featurette-icon-left {
      margin-right: 40px;
    	font-size: 150px;
    	float: left;
    }
    
    .featurette .icon-bar-chart {
      	color: #009966;
    }
      	
    .featurette .icon-thumbs-up {
      	color: #3366FF;
    }
      	
    .featurette .icon-map-marker {
    	color: #CC3333;
    	
    }

    /* Thin out the marketing headings */
    .featurette-heading {
      font-size: 50px;
      font-weight: 300;
      line-height: 1;
      letter-spacing: -1px;
    }



    /* RESPONSIVE CSS
    -------------------------------------------------- */

    @media (max-width: 979px) {

      .container.navbar-wrapper {
        margin-bottom: 0;
        width: auto;
      }
      .navbar-inner {
        border-radius: 0;
        margin: -20px 0;
      }

      .carousel .item {
        height: 500px;
      }
      .carousel img {
        width: auto;
        height: 500px;
      }

      .featurette {
        height: auto;
        padding: 0;
      }
      .featurette-image.pull-left,
      .featurette-image.pull-right {
        display: block;
        float: none;
        max-width: 40%;
        margin: 0 auto 20px;
      }
      
      .featurette-icon-right,
      .featurette-icon-left {
        display: block;
        float: none;
        max-width: 40%;
        margin: 0 auto 20px;
      }	
      
    }


    @media (max-width: 767px) {

      .navbar-inner {
        margin: -20px;
      }

      .carousel {
        margin-left: -20px;
        margin-right: -20px;
      }
      .carousel .container {
		width: 100%;
      }
      .carousel .item {
        height: 300px;
      }
      .carousel img {
        height: 300px;
      }
      .carousel-caption {
        width: 65%;
        padding: 0 70px;
        margin-top: 100px;
      }
      .carousel-caption h1 {
        font-size: 30px;
      }
      .carousel-caption .lead,
      .carousel-caption .btn {
        font-size: 18px;
      }

      .marketing .span4 + .span4 {
        margin-top: 40px;
      }

      .featurette-heading {
        font-size: 30px;
      }
      .featurette .lead {
        font-size: 18px;
        line-height: 1.5;
      }

    }
    </style>
<div class="alert alert-info" style="margin-top: 10px;"><strong>ALPHA TESTERS</strong> please <a class="alert-link" href="http://topular.in/login">login</a> here.</div>

		<div class="hero-unit">
			<img src="http://topular.in/images/topular-logo-black.png" class="pull-right" width="150" height="150"></img>
		  <h1>What are the best reads in your city? Topular knows.</h1>
		  <p class="lead">We take all the stories from your city and rank them by social impact.</p>
		  <a class="tplr-btn" href="http://www.topular.in/register">Sign up today</a>
		</div>

	<br><br>
      <a name="city"></a>
 	<div class="container marketing">
      <div class="row">
        <div class="span4">
          <img class="img-circle"  alt="140x140" style="width: 140px; height: 140px;" src="http://www.americanrealestateinvestments.com.au/wp-content/uploads/2012/05/Indianapolis-Junk-Removal.jpg">
          <h2>Indianapolis</h2>
          <p>From Pattern to Nuvo to IndySphere, Indy has awesome emerging local content.  Check out Topular's founding city!</p>
          <p style="margin-top:10px;"><a class="tplr-btn" href="http://topular.in/indianapolis">Read IND »</a></p>
        </div><!-- /.span4 -->
        <div class="span4">
          <img class="img-circle" alt="140x140" style="width: 140px; height: 140px;" src="http://www.richard-seaman.com/Wallpaper/USA/Cities/Chicago/ChicagoSkyline2.jpg">
          <h2>Chicago</h2>
          <p>Chicago is not just filled with deep dish pizza and the hopes and dream of Cubs fans.  Check out great sites like Chicago Now and Lost in Concert. </p>
          <p style="margin-top:10px;"><a class="tplr-btn" href="http://topular.in/chicago">Read CHI »</a></p>
        </div><!-- /.span4 -->
<!--       
	   <div class="span4">
          <img class="img-circle" alt="140x140" style="width: 140px; height: 140px;" src="http://i.slimg.com/sc/sl/photo/m/mo/mo-stlouis-daytime-xl.jpg">
          <h2>St. Louis</h2>
          <p>St. Louis is the next city on our list.  There are lots of great cities...but we don't know where to start.  Want your city added?</p>
          <p><a class="btn" href="#vote">Vote now »</a></p>
        </div>
-->
      </div>
    </div>  
    


      <!-- START THE FEATURETTES -->    
      <a name="login"></a>
      <hr class="featurette-divider">
      
      <div class="featurette-login">
      	<h2 class="featurette-heading">Sign up or login via
      	<a href="http://topular.in/register">
		<i class="icon-facebook-sign" href="#"></i>
     	<i class="icon-twitter-sign" href="#"></i>
      	<i class="icon-envelope-alt" href="http://topular.in/login"></i></h2>
		</a>
      </div>
      
      <a name="learnmore"></a>
      <hr class="featurette-divider">
      
      <div class="featurette">
         <div class="featurette-icon-right">
        	<i class="icon-bar-chart"></i>
        </div>
        <h2 class="featurette-heading">Read what's popular. <span class="muted">Right now.</span></h2>
        <p class="lead">Everything is ranked and easy to read to give you a quick glance of what's important right now.</p>
      </div>

      <hr class="featurette-divider">

      <div class="featurette">
        <div class="featurette-icon-left">
        	<i class="icon-thumbs-up"></i>
        </div>
        <h2 class="featurette-heading">Share and save it all. <span class="muted">Like a boss.</span></h2>
        <p class="lead">Share stories right from the headline or save them with services like Pocket or Instapaper.</p>
      </div>
      
    	<hr class="featurette-divider">
      
      <div class="featurette">
        <div class="featurette-icon-right">
        	<i class="icon-map-marker"></i>
        </div>
        <h2 class="featurette-heading">Discover your city. <span class="muted">Every single day.</span></h2>
        <p class="lead">Find out what is popular in your city today, this week, or even this month. Discover something new!</p>
      </div>
      
      <a name="vote"></a>
 <hr class="featurette-divider">
    <div class="featurette-login">
      	<h3 class="featurette-heading">Where should Topular explore next?
      <div class="input-append">
  		<input class="span2" id="appendedInputButton" type="text">
 		<button class="btn" type="button">Vote</button>
	</h3></div>
	</div>
	
	<hr class="featurette-divider">

      <!-- /END THE FEATURETTES -->