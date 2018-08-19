<div class="under-menu" id="site-menu" style="display: none; padding-bottom: 20px;">

	<span id="menu-close" class="pull-right" style="margin-top:10px;margin-right:10px;cursor: pointer; font-size: 20px; line-height: 20px; height: 20px; width: 20px;"><i class="icon-remove"></i></span>

	<div class="col-md-3 col-xs-12">
		<h3>Cities</h3>
		<div class="col-xs-12">
			<ul>
				<li><a href="<?php echo $this->createUrl('article/index'); ?>">All Cities</a></li>
				<?php foreach ($menu['city'] as $c): ?>
				<li><a href="<?php echo $this->createUrl('article/index', array('city'=>$c['title'])); ?>"><?php echo $c['title']; ?></a></li>
				<?php endforeach; ?>
			</ul>
		</div>
	</div>
	<div class="col-md-6 col-xs-12">
		<h3>Categories</h3>
		<div class="col-xs-12">
			<ul>
			<?php foreach ($menu['category'] as $c): ?>
				<li><a href="<?php echo $this->createUrl('article/index', array('city'=>$c['title'])); ?>"><?php echo $c['title']; ?></a></li>
			<?php endforeach; ?>
			</ul>
		</div>
	</div>
	<div class="col-md-3 col-xs-12">
		<h3>Functions</h3>
			<div class="col-xs-12">
				<ul>
					<li><a href="<?php echo $this->createUrl('source/submit'); ?>">Submit source</a></li>
					<li><a href="<?php echo $this->createUrl('site/contact'); ?>">Contact us</a></li>
				</ul>
			</div>
	</div>
</div>

<div class="under-menu" id="search-menu" style="display: none; height: 53px; padding: 10px 0;">
	<form action="<?php echo $this->createUrl('article/search'); ?>">
		<div class="col-md-6 col-xs-12 pull-right">
			<div class="input-group">
			<input type="search" name="q" placeholder="Search" class="form-control">
			<span class="input-group-btn">
			<button class="btn btn-default" type="submit">Go</button>
			</span>
			</div><!-- /input-group -->
		</div><!-- /.col-lg-6 -->
	</form>
</div>


<div class="row" id="header-wrapper">
	<div class="col-xs-12">
		<div id="header">
			<span id="tplr-logo">
				<span class="pull-left" id="menu-button" style="cursor: pointer; font-size: 24px; line-height: 30px; height: 30px; width: 30px;"><i class="icon-align-justify"></i></span>
				<span class="pull-right" id="search-button" style="cursor: pointer; font-size: 24px; line-height: 30px; height: 30px; width: 30px;"><i class="icon-search"></i></span>
				<a href="<?php echo $this->createUrl('article/index', array('city'=>strtolower(Yii::app()->session['city']))); ?>">
					<span id="tplr-logo-img">
						<img src = "<?php echo Yii::app()->request->baseUrl; ?>/images/topular-logo-black.png" />
					</span> 
					<span id="tplr-logo-text">
						Topular
					</span>
				</a>
			</span>
			<br>

			<?php
			if (!Yii::app()->user->isGuest) {
				$user = User::model()->findByPk(Yii::app()->user->getId());
			} else {
				$user = User::model()->loadGuest();
			}
			?>
			
			<?php if ($this->route == 'article/index' || $this->route == 'article/search'): $page_title = $this->page_title; ?>
			
				<span class="dropdown tplr-dropdown">
					<a class="dropdown-toggle" data-toggle="dropdown" href="#">
						<span id="tplr-title">
							<?php echo $page_title; ?>
							<span class="caret"></span>
						</span>
					</a>
					<ul class="dropdown-menu">
						<li role="presentation" class="dropdown-header">Favorite City</li>
						<?php if ($city = $user->city): ?>
							<li><a href="<?php echo $this->createUrl('city/set', array('id'=>$city->id)); ?>"><?php echo $city->title; ?></a></li>
						<?php else: ?>
							<li><a href="<?php echo $this->createUrl('city/index'); ?>">Choose City</a></li>
						<?php endif; ?>
						<li class="divider"></li>
						<li role="presentation" class="dropdown-header">Your Bundles</li>
						<?php if ($bundles = $user->bundles): ?>
							<?php foreach ($bundles as $bundle): ?>
							<li><a href="<?php echo $this->createUrl('bundle/set', array('id'=>$bundle->id)); ?>"><?php echo $bundle->title; ?></a></li>
							<?php endforeach; ?>
						<?php else: ?>
							<li><a href="<?php echo $this->createUrl('user/register'); ?>">Login To Create</a></li>
						<?php endif; ?>
						<li class="divider"></li>
						<li><a href="<?php echo $this->createUrl('city/index'); ?>">Update City</a></li>
						<?php if (!Yii::app()->user->isGuest): ?>
							<li><a href="<?php echo $this->createUrl('bundle/index'); ?>">Update Bundles</a></li>
						<?php endif; ?>
					</ul>
				</span>
	
			<?php endif; ?>
		</div>
	</div>


	<div class="col-xs-12">
		<div id="sub-header">


			<?php if ($this->route == 'article/index'): ?>
			<span class="pull-left">
				<span class="dropdown tplr-dropdown">
					<a class="dropdown-toggle" data-toggle="dropdown" href="#">
						<span class="visible-xs" id="tplr-date">
							<?php 
								$timespan = $user->timespan;
								switch ($timespan) {
									case 'month':
										echo date('M j', time()-(30*24*60*60)) . ' - ' . date('M j');
										break;
									case 'week':
										echo date('M j', time()-(7*24*60*60)) . ' - ' . date('M j');
										break;
									default:
										$timespan = 'day';
										echo date('D, M jS');
										break;
								}
							?>
							<span class="caret"></span>
						</span>
						<span class="hidden-xs" id="tplr-date">
							<?php 
								switch ($timespan) {
									case 'month':
										echo date('F jS', time()-(30*24*60*60)) . ' - ' . date('F jS, Y');
										break;
									case 'week':
										echo date('F jS', time()-(7*24*60*60)) . ' - ' . date('F jS, Y');
										break;
									default:
										$timespan = 'day';
										echo date('l, F jS, Y');
										break;
								}
							?>
							<span class="caret"></span>
						</span>
					</a>
					<ul class="dropdown-menu">
						<li class="dropdown-header">Timespan: <strong><?php echo ucfirst($timespan); ?></strong></li>
						<li class="divider"></li>
						<li class="dropdown-header">Change timespan</li>
						<?php $timespans = array('day','week','month');
						foreach ($timespans as $t): ?>
							<li<?php echo ($t == $timespan ? ' class="disabled"' : ''); ?>><a href="<?php echo $this->createUrl('user/set', array('timespan'=>$t)); ?>"><?php echo ucfirst($t); ?></a></li>
						<?php endforeach; ?>
					</ul>
				</span>
			</span>
			<?php else: ?>
				<span class="pull-left">
					<span class="visible-xs" id="tplr-date">
						<?php echo date("D, M jS"); ?>
					</span>
					<span class="hidden-xs" id="tplr-date">
						<?php echo date("l, F jS, Y"); ?>
					</span>
				</span>
			<?php endif; ?>
		
			<span class="pull-right">
				<?php if (!Yii::app()->user->isGuest): ?>
					<span class="dropdown tplr-dropdown">
						<a class="dropdown-toggle" data-toggle="dropdown" href="#">
							<span id="tplr-user">
								<?php echo $user->first_name . ' ' . $user->last_name; ?> <span class="caret"></span>
							</span>
						</a>
						<ul class="dropdown-menu pull-right">
							<li><a href="<?php echo $this->createUrl('user/articles'); ?>">Saved Articles</a></li>
							<li><a href="<?php echo $this->createUrl('user/view'); ?>">View Profile</a></li>
							<li><a href="<?php echo $this->createUrl('user/edit'); ?>">Edit Profile</a></li>
							<?php if (!Yii::app()->user->isGuest && Yii::app()->user->type === 'admin'): ?>
								<li class="divider"></li>
								<li role="presentation" class="dropdown-header">Admin Tools</li>
								<li><a href="<?php echo $this->createUrl('site/dashboard'); ?>">Admin Dashboard</a></li>
							<?php endif; ?>
							<li class="divider"></li>
							<li><a href="<?php echo $this->createUrl('site/logout'); ?>">Logout</a></li>
						</ul>
					</span>
				<?php else: ?>
					<span id="tplr-signup-login">
						<a href="<?php echo $this->createUrl('user/register'); ?>"><i class="icon-caret-right"></i> Sign up</a>
						<a href="<?php echo $this->createUrl('site/login'); ?>"><i class="icon-caret-right"></i> Log in</a>
					</span>
				<?php endif; ?>
			</span>
		</div>
	</div>
</div>

<!-- HIDDEN -->
<div class="hidden">

<div id="menu-inner">

	<span id="tplr-logo">
		<a href="<?php echo $this->createUrl('article/index', array('city'=>strtolower(Yii::app()->session['city']))); ?>">
			<img src = "<?php echo Yii::app()->request->baseUrl; ?>/images/topular-logo-white.png" /> Topular
		</a>
	</span>
	
	
	<span class="btn-group btn-group-sm">
		<button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown">
		City <span class="caret"></span>
		</button>
		<ul class="dropdown-menu" role="menu">
			<li><a href="<?php echo $this->createUrl('article/index'); ?>">All Cities</a></li>
			<?php foreach ($menu['city'] as $c): ?>
			<li><a href="<?php echo $this->createUrl('article/index', array('city'=>$c['title'])); ?>"><?php echo $c['title']; ?></a></li>
			<?php endforeach; ?>
		</ul>
	</span>
	
	<span class="btn-group btn-group-sm">
		<button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown">
		Category <span class="caret"></span>
		</button>
		<ul class="dropdown-menu" role="menu">
		<?php foreach ($menu['category'] as $c): ?>
			<li><a href="<?php echo $this->createUrl('article/index', array('city'=>$c['title'])); ?>"><?php echo $c['title']; ?></a></li>
		<?php endforeach; ?>
		</ul>
	</span>
	
	<?php if (!Yii::app()->user->isGuest): ?>
	<span class="btn-group btn-group-sm">
		<button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown">
		Profile <span class="caret"></span>
		</button>
		<ul class="dropdown-menu" role="menu">
			<li><a href="<?php echo $this->createUrl('user/view'); ?>">View Profile</a></li>
			<li><a href="<?php echo $this->createUrl('user/articles'); ?>">Saved Articles</a></li>
			<li><a href="<?php echo $this->createUrl('user/edit'); ?>">Edit Profile</a></li>
			<li><a href="<?php echo $this->createUrl('site/logout'); ?>">Logout</a></li>
		</ul>
	</span>
	<?php else: ?>
	<span class="btn-group btn-group-sm">
		<button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown">
		Sign Up <span class="caret"></span>
		</button>
		<ul class="dropdown-menu" role="menu">
			<li><a href="<?php echo $this->createUrl('user/register'); ?>">Register</a></li>
			<li><a href="<?php echo $this->createUrl('site/login'); ?>">Login</a></li>
		</ul>
	</span>
	<?php endif; ?>


</div>

</div>
<!-- /HIDDEN -->
