<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * @author      OA Wu <comdan66@gmail.com>
 * @copyright   Copyright (c) 2016 OA Wu Design
 */

class Promo extends OaModel {

  static $table_name = 'promos';

  static $has_one = array (
  );

  static $has_many = array (
  );

  static $belongs_to = array (
  );
  
  const ENABLE_NO  = 0;
  const ENABLE_YES = 1;

  static $enableName = array(
    self::ENABLE_NO  => '停用',
    self::ENABLE_YES => '啟用',
  );

  const TARGET_BLANK = 0;
  const TARGET_SELF  = 0;

  static $targetName = array(
    self::TARGET_BLANK => '分頁',
    self::TARGET_SELF  => '本頁',
  );

  public function __construct ($attributes = array (), $guard_attributes = true, $instantiating_via_find = false, $new_record = true) {
    parent::__construct ($attributes, $guard_attributes, $instantiating_via_find, $new_record);

    OrmImageUploader::bind ('cover', 'PromoCoverImageUploader');
  }
  public function destroy () {
    if (!(isset ($this->cover) && isset ($this->id)))
      return false;

    return $this->cover->cleanAllFiles () && $this->delete ();
  }
}