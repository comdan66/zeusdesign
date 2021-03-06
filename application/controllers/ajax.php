<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * @author      OA Wu <comdan66@gmail.com>
 * @copyright   Copyright (c) 2016 OA Wu Design
 */

class Ajax extends Site_controller {

  public function __construct () {
    parent::__construct ();

    if (!$this->input->is_ajax_request ())
      return show_404 ();
  }

  public function navbar () {
    $menus = array ();
    array_push ($menus, array ('text' => '前台', 'class' => 'icon-home', 'href' => base_url ()));
    array_push ($menus, array ('text' => '登出', 'class' => 'icon-exit top_line logout', 'href' => Fb::logoutUrl ('platform', 'sign_out')));

    $content = $this->load_content (array (
        'menus' => $menus,
      ), true);

    return $this->output_json (array ('status' => true, 'content' => $content));
  }
  public function pv () {
    if (!(($id = OAInput::post ('id')) && ($class = OAInput::post ('class')) && class_exists ($class) && in_array ($class, array ('Work', 'Article'))))
      return show_404 ();

    if (!($obj = $class::find_by_id ($id, array ('select' => 'id, pv'))))
      return $this->output_json (array ('status' => false));

    $obj->pv += 1;

    $update = $class::transaction (function () use ($obj) {
      return $obj->save ();
    });

    if (!$update)
      return $this->output_json (array ('status' => true, 'pv' => $obj->pv - 1));

    return $this->output_json (array ('status' => true, 'pv' => $obj->pv));
  }
}
