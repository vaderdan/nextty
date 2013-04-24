<?php

/**
 * This file is part of the symfony package.
 * (c) 2004-2006 Fabien Potencier <fabien.potencier@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

/**
 * Unit test library.
 *
 * @package    lime
 * @author     Fabien Potencier <fabien.potencier@gmail.com>
 * @version    SVN: $Id$
 */
class limetest extends lime_test
{
  private static $db_setup_file;
  private static $db_backup_file;
  private static $db_database = 'happy_flatsharing';

  private static $path = '/../../fixtures/';

  public function __construct($plan = null, $options = array())
  {
    self::testEnvironment();
    $this->setup();
    
    parent::__construct($plan, $options);
  }

  public function __destruct()
  {
    parent::__destruct();
    $this->teardown();
  }

  public function setup()
  {
    if(isset(self::$db_setup_file) && file_exists(self::$db_setup_file)){
      exec('mysqldump -h "localhost" -u "root" '.self::$db_database.' > '.self::$db_backup_file);
      exec('mysql -h "localhost" -u "root" '.self::$db_database.' < '.self::$db_setup_file);
    }
  }

  public function teardown()
  {
    if(isset(self::$db_backup_file) && file_exists(self::$db_backup_file)){
      exec('mysql -h "localhost" -u "root" '.self::$db_database.' < '.self::$db_backup_file);
      unlink(self::$db_backup_file);
    }
  }

  public static function testEnvironment($db_file = '', $db_database = ''){
    $db_file = empty($db_file) ? 'db.sql' : $db_file;
    self::$db_setup_file = realpath(dirname(__FILE__) . self::$path . $db_file);

    self::$db_backup_file = dirname(__FILE__) . self::$path . md5(time()) . '.sql';    

    self::$db_database = empty($db_database) ? self::$db_database : $db_database;
  }
}