<?php
/**
 * Created by PhpStorm.
 * User: ishigetani
 * Date: 13/12/29
 * Time: 10:36
 * link: http://kwski.net/cakephp-2-x/1064/
 */
App::uses( 'Mysql', 'Model/Datasource/Database');
class MysqlLog extends Mysql {
    function logQuery( $sql, $params = array()) {
        parent::logQuery( $sql);
        if (Configure::read('debug') > 0) {
//          $this->log( $this->_queriesLog, SQL_LOG);  // SQLの実行詳細
            $this->log( $sql. '', SQL_LOG);                // SQLクエリーのみ
        }
    }
}