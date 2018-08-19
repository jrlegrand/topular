	// Topular AJAX functionality 
	// Replace this with $("#form_field").chosen().change( … );
	$("#cat-sel").chosen().change(function() {
		var container = $('#articles');
		var category_select = $(this);
		
		$.ajax({
			url: '<?php echo $this->createUrl('user/ajaxpreferences'); ?>',
			data: { categories: category_select.val() },
			success: function(result){
				//alert(result);
				container.load('<?php echo $this->createUrl('article/ajax'); ?>');
			},
			beforeSend: function(result){
				$(window).scrollTop(0);
				container.html('<div align="center"><h2><i class="icon-spinner icon-spin"></i> Loading articles...</a></h2></div>');
			}
		});
	});
