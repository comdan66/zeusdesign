<div>
  <div>
    <div><div>宙思</div><div>Design</div></div>
    <div><div>ZEUS</div><div>設計</div></div>
  </div>

<?php
  if ($menus_list) {
    foreach ($menus_list as $menus_text => $menus) { ?>
      <h4><?php echo $menus_text;?></h4>
<?php if ($menus) { ?>
        <div>
    <?php foreach ($menus as $menu_text => $menu) {
            if (isset ($menu['no_show']) && $menu['no_show']) continue;
            if ($menu == 'line') { ?>
              <a class='l'></a>
      <?php } else { ?>
              <a href='<?php echo $menu['href'];?>'<?php echo ($c = $menu['active'] || (((isset ($menu['class']) && $menu['class']) && ($class == $menu['class']) && (isset ($menu['method']) && $menu['method']) && ($method == $menu['method'])) || (((isset ($menu['class']) && $menu['class'])) && ($class == $menu['class']) && !((isset ($menu['method']) && $menu['method']))) || (!(isset ($menu['class']) && $menu['class']) && (isset ($menu['method']) && $menu['method']) && ($method == $menu['method']))) ? $menu['icon'] ? $menu['icon'] . ' a' : 'a': $menu['icon']) ? " class='" . $c . "'" : '';?><?php echo $menu['target'] == '_blank' ? 'target="_blank"' : '';?>><?php echo $menu_text;?></a>
      <?php }?>
    <?php } ?>
        </div>
<?php }
    }
  } ?>
</div>
