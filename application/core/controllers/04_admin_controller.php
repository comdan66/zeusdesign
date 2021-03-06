<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * @author      OA Wu <comdan66@gmail.com>
 * @copyright   Copyright (c) 2016 OA Wu Design
 */

class Admin_controller extends Oa_controller {

  public function __construct () {
    parent::__construct ();

    if (!(User::current () && User::current ()->is_login ())) {
      Session::setData ('_flash_message', '', true);
      return redirect_message (array ('login'), array (
          '_flash_message' => '請先登入，或者您沒有後台權限！'
        ));
    }
    
    $class  = $this->get_class ();
    $method = $this->get_method ();

    $menus_list = array_map (function ($menus) use ($class, $method, &$has_active) {
      return array_map (function ($item) use ($class, $method, &$has_active) {
        $has_active |= ($a = ((isset ($item['class']) && $item['class']) && ($class == $item['class']) && (isset ($item['method']) && $item['method']) && ($method == $item['method'])) || (((isset ($item['class']) && $item['class'])) && ($class == $item['class']) && !((isset ($item['method']) && $item['method']))) || (!(isset ($item['class']) && $item['class']) && (isset ($item['method']) && $item['method']) && ($method == $item['method'])));
        return array_merge ($item, array ('active' => $a));
      }, $menus);
    }, array_filter (array_map (function ($group) {
      return array_filter ($group, function ($item) {
        return User::current ()->in_roles ($item['roles']);
      });
    }, Cfg::setting ('menu', 'admin'))));

    if (!$has_active)
      return redirect_message (array ('admin'), array (
          '_flash_message' => '您沒有此頁面的管理權限。'
        ));

    $this->set_componemt_path ('component', 'admin')
         ->set_frame_path ('frame', 'admin')
         ->set_content_path ('content', 'admin')
         ->set_public_path ('public')

         ->set_title (Cfg::setting ('site', 'admin', 'title'))

         ->_add_meta ()
         ->_add_css ()
         ->_add_js ()
         ->add_param ('_menus_list', $menus_list)
         ;
  }

  private function _add_meta () {
    return $this;
  }

  private function _add_css () {
    return $this->add_css ('http://fonts.googleapis.com/css?family=Open+Sans:400italic,400,700', false)
                ->append_css (base_url ('application', 'cell', 'views', 'admin_frame_cell', 'navbar', 'content.css'))
                ->add_css (base_url ('application', 'cell', 'views', 'admin_frame_cell', 'wrapper_left', 'content.css'))
                ->append_css (base_url ('application', 'cell', 'views', 'admin_frame_cell', 'tabs', 'content.css'))
                ->append_css (base_url ('application', 'cell', 'views', 'admin_frame_cell', 'footer', 'content.css'))
                ;
  }

  private function _add_js () {
    return $this->add_js (resource_url ('resource', 'javascript', 'jquery_v1.10.2', 'jquery-1.10.2.min.js'))
                ->add_js (resource_url ('resource', 'javascript', 'jquery-rails_d2015_03_09', 'jquery_ujs.js'))
                ->add_js (resource_url ('resource', 'javascript', 'imgLiquid_v0.9.944', 'imgLiquid-min.js'))
                ->add_js (resource_url ('resource', 'javascript', 'jquery-timeago_v1.3.1', 'jquery.timeago.js'))
                ->add_js (resource_url ('resource', 'javascript', 'jquery-timeago_v1.3.1', 'locales', 'jquery.timeago.zh-TW.js'))
                ->add_js (resource_url ('resource', 'javascript', 'autosize_v3.0.8', 'autosize.min.js'))
                ->add_js (resource_url ('resource', 'javascript', 'masonry_v3.1.2', 'masonry.pkgd.min.js'))
                ->append_js (base_url ('application', 'cell', 'views', 'admin_frame_cell', 'navbar', 'content.js'))
                ->add_js (base_url ('application', 'cell', 'views', 'admin_frame_cell', 'wrapper_left', 'content.js'))
                ->append_js (base_url ('application', 'cell', 'views', 'admin_frame_cell', 'tabs', 'content.js'))
                ;
  }
}