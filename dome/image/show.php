<?php
//显示页面
use LSYS\Captcha\Image;
require_once  __DIR__."/../Bootstarp.php";
$t = new Image();
$res=$t->get_result();

?>
<script src="http://code.jquery.com/jquery-1.12.3.min.js"></script>
<form action="check.php" method="GET">
<img src="image.php?token=<?php echo $res?>" onclick="this.src=this.src.indexOf('r=')==-1?(this.src+'&r='):(this.src.replace(/r=.*$/,'r='+Math.random()))"/>
<input type="hidden" name="token" value="<?php echo $res?>">
<input type="text"name="code"><span class="show_status"></span>
<input type="submit"/>
</form>
<script>
	$('input[name=code]').blur(function(){
		var val=this.value;
		$.ajax({
			url:'./test.php',
			data:{code:val,token:'<?php echo $res?>'},
			success:function(data){
				if(data==1)$('.show_status').html('ok');
				else $('.show_status').html('bad');
			}
		})
	})
</script>