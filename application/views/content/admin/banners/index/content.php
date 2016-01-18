<form action='<?php echo base_url ('admin', 'banners');?>' method='get' class="search<?php echo $has_search ? ' show' : '';?>">
  <div class='l i2 n1'>
    <input type='text' name='title' value='<?php echo @$columns['title'];?>' placeholder='請輸入 標題..' />
    <input type='text' name='content' value='<?php echo @$columns['content'];?>' placeholder='請輸入 內容..' />
  </div>
  <button type='submit'>尋找</button>
  <a href='<?php echo base_url ('admin', 'banners', 'add');?>'>新增</a>
</form>
<button type='button' onClick="if (!$(this).prev ().is (':visible')) $(this).attr ('class', 'icon-chevron-left').prev ().addClass ('show'); else $(this).attr ('class', 'icon-chevron-right').prev ().removeClass ('show');" class='icon-chevron-<?php echo $has_search ? 'left' : 'right';?>'></button>

  <table class='table-list-rwd'>
    <tbody>
<?php if ($banners) {
        foreach ($banners as $banner) { ?>
          <tr>
            <td data-title='標題' width='150'><?php echo $banner->title;?></td>
            <td data-title='內容' ><?php echo $banner->mini_content ();?></td>
            <td data-title='封面' width='50'><?php echo img ($banner->cover->url ('100x100c'), false, 'class="i_30"');?></td>
            <td data-title='開啟方式' width='80'><?php echo Banner::$targetName[$banner->target];?></td>
            <td data-title='鏈結' width='250'><?php echo $banner->link;?></td>
            <td data-title='狀態' width='50'<?php echo !$banner->is_enabled ? 'class="red"' : '';?>><?php echo Banner::$enableName[$banner->is_enabled];?></td>
            <td data-title='編輯' width='80'>
              <a href='<?php echo base_url ('admin', 'banners', $banner->id, 'edit');?>' class='icon-pencil2'></a>
              <a href='<?php echo base_url ('admin', 'banners', $banner->id);?>' data-method='delete' class='icon-bin destroy'></a>
            </td>
            <td data-title='排序' width='50' class='sort'>
              <a href='<?php echo base_url ('admin', 'banners', $banner->id, 'sort', 'up');?>' data-method='post' class='icon-triangle-up'></a>
              <a href='<?php echo base_url ('admin', 'banners', $banner->id, 'sort', 'down');?>' data-method='post' class='icon-triangle-down'></a>
            </td>
          </tr>
  <?php }
      } else { ?>
        <tr><td colspan>目前沒有任何資料。</td></tr>
<?php }?>
    </tbody>
  </table>

<?php echo render_cell ('admin_frame_cell', 'pagination', $pagination);?>

