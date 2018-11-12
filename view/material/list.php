<?php view::layout('layout')?>
<?php 
function file_ico($item){
  $ext = strtolower(pathinfo($item['name'], PATHINFO_EXTENSION));
  if(in_array($ext,['bmp','jpg','jpeg','png','gif'])){
  	return "image";
  }
  if(in_array($ext,['mp4','mkv','webm','avi','mpg', 'mpeg', 'rm', 'rmvb', 'mov', 'wmv', 'mkv', 'asf'])){
  	return "ondemand_video";
  }
  if(in_array($ext,['ogg','mp3','wav'])){
  	return "audiotrack";
  }
  return "insert_drive_file";
}
?>

<?php view::begin('content');?>
	
<div class="mdui-container-fluid">

<?php if($head):?>
<div class="mdui-typo" style="padding: 20px;">
	<?php e($head);?>
</div>
<?php endif;?>

	
<div class="mdui-row list-detail" style="<?php echo $_COOKIE['display_type'] != 'table' ? '' : 'display:none;'; ?>">
	<ul class="mdui-list">
		<li class="mdui-list-item th">
		  <div class="mdui-col-xs-12 mdui-col-sm-7">文件</div>
		  <div class="mdui-col-sm-3 mdui-text-right">修改时间</div>
		  <div class="mdui-col-sm-2 mdui-text-right">大小</div>
		</li>
		<?php if($path != '/'):?>
		<li class="mdui-list-item mdui-ripple">
			<a href="<?php echo get_absolute_path($root.$path.'../');?>">
			  <div class="mdui-col-xs-12 mdui-col-sm-7">
				<i class="mdui-icon material-icons">arrow_upward</i>
		    	..
			  </div>
			  <div class="mdui-col-sm-3 mdui-text-right"></div>
			  <div class="mdui-col-sm-2 mdui-text-right"></div>
		  	</a>
		</li>
		<?php endif;?>

		<?php foreach((array)$items as $item):?>
			<?php if(!empty($item['folder'])):?>

		<li class="mdui-list-item mdui-ripple">
			<a href="<?php echo get_absolute_path($root.$path.$item['name']);?>">
			  <div class="mdui-col-xs-12 mdui-col-sm-7 mdui-text-truncate">
				<i class="mdui-icon material-icons">folder_open</i>
		    	<?php e($item['name']);?>
			  </div>
			  <div class="mdui-col-sm-3 mdui-text-right"><?php echo date("Y-m-d H:i:s", $item['lastModifiedDateTime']);?></div>
			  <div class="mdui-col-sm-2 mdui-text-right"><?php echo $item['size'];?></div>
		  	</a>
		</li>
			<?php else:?>
		<li class="mdui-list-item file mdui-ripple">
			<a href="<?php echo get_absolute_path($root.$path).urlencode($item['name']);?>" target="_blank">
			  <div class="mdui-col-xs-12 mdui-col-sm-7 mdui-text-truncate">
				<i class="mdui-icon material-icons"><?php echo file_ico($item);?></i>
		    	<?php e($item['name']);?>
			  </div>
			  <div class="mdui-col-sm-3 mdui-text-right"><?php echo date("Y-m-d H:i:s", $item['lastModifiedDateTime']);?></div>
			  <div class="mdui-col-sm-2 mdui-text-right"><?php echo $item['size'];?></div>
		  	</a>
		</li>
			<?php endif;?>
		<?php endforeach;?>
	</ul>
</div>
<div style="margin-top: 20px;<?php echo $_COOKIE['display_type'] == 'table' ? '' : 'display:none;'; ?>" class="obj-list mdui-row-xs-1 mdui-row-sm-4 mdui-row-md-5 mdui-row-lg-6 mdui-row-xl-7 mdui-grid-list">
    <?php foreach((array)$items as $item):?>
    <?php if(!empty($item['folder'])):?>
    <div class="mdui-col">
        <a href="<?php echo get_absolute_path($root.$path.$item['name']);?>">
        <div class="col-icon">
            <img src="https://static2.sharepointonline.com/files/fabric/office-ui-fabric-react-assets/foldericons/folder-large_frontplate_nopreview.svg">
        </div>
        <div class="col-detail" style="text-align: center">
            <div class="col-title">
                <?php e($item['name']);?>
            </div>
            <div class="col-date">
                <?php echo date("y-m-d H:i", $item['lastModifiedDateTime']);?>
            </div>
        </div>
        </a>
    </div>
    <?php else:?>
    <div class="mdui-col file">
        <a target="_blank" href="<?php echo get_absolute_path($root.$path).urlencode($item['name']);
        $ext = strtolower(pathinfo($item['name'], PATHINFO_EXTENSION));?>">
            <div class="col-icon">
                <?php if(in_array($ext,['bmp','jpg','jpeg','png','gif'])):?>
                <img class="lazy" data-original="<?php e($item['downloadUrl']) ?>" src="http://pan.ilt.me/Images/static/loding.gif">
                <?php else:?>
                <img  style="height: 80%;" src="https://spoprod-a.akamaihd.net/files/odsp-next-prod_2018-10-26_20181031.001/odsp-media/images/itemtypes/64/genericfile.png">
                <?php endif;?>

            </div>
            <div class="col-detail" style="text-align: center">
                <div class="col-title" title="<?php e($item['name']);?>">
                    <?php e($item['name']);?>
                </div>
                <div class="col-date">
                    <?php echo date("y-m-d H:i", $item['lastModifiedDateTime']);?>
                </div>
            </div>
        </a>
    </div>
    <?php endif;?>
    <?php endforeach; ?>
</div>


<?php if($readme):?>
<div class="mdui-typo mdui-shadow-3" style="padding: 20px;margin: 20px; 0">
	<div class="mdui-chip">
	  <span class="mdui-chip-icon"><i class="mdui-icon material-icons">face</i></span>
	  <span class="mdui-chip-title">README.md</span>
	</div>
	<?php e($readme);?>
</div>
<?php endif;?>
</div>
<script>

    $('.display-type').click(function () {
        var display_type = $.cookie('display_type'); // 读取 cookie
        if(display_type !== 'table'){
            $('.list-detail').hide();
            $('.obj-list').show();
            $.cookie('display_type','table', { path: '/' });
            $('img.lazy').lazyload();
        }else{
            $('.list-detail').show();
            $('.obj-list').hide();
            $.cookie('display_type','list', { path: '/' });
        }
    });

$('img.lazy').lazyload();

$(function(){
	$('.file a').each(function(){
		$(this).on('click', function () {
			var form = $('<form target=_blank method=post></form>').attr('action', $(this).attr('href')).get(0);
			$(document.body).append(form);
			form.submit();
			$(form).remove();
			return false;
		});
	});
});
</script>
<?php view::end('content');?>
