<div class="menu-links">
<?php
if ($user===null): ?>

<ul>
<li><a target="_parent" href="<?php echo $this->createUrl('user/register'); ?>">Register</a></li>
<li><a target="_parent" href="<?php echo $this->createUrl('site/login'); ?>">Login</a></li>
</ul>

<?php else: ?>
<?php if ($user->image): ?>
<div>
<img src="<?php echo Yii::app()->request->baseUrl . '/images/user/' . $user->image; ?>" class="profile-image img-polaroid"></img>
</div>
<?php endif; ?>
<strong><?php echo $user->first_name . ' ' . $user->last_name; ?></strong>
<?php echo '(' . $user->email . ')'; ?>

<ul>
<li><a target="_parent" href="<?php echo $this->createUrl('user/articles'); ?>">Saved Articles</a></li>
</ul>

<ul>
<li><a target="_parent" href="<?php echo $this->createUrl('user/view'); ?>">View Profile</a></li>
<li><a target="_parent" href="<?php echo $this->createUrl('user/edit'); ?>">Edit Profile</a></li>
</ul>

<ul>
<li><a target="_parent" href="<?php echo $this->createUrl('site/logout'); ?>">Logout</a></li>
</ul>

<?php endif; ?>
</div>