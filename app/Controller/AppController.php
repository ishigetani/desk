<?php
/**
 * Application level Controller
 *
 * This file is application-wide controller file. You can put all
 * application-wide controller-related methods here.
 *
 * PHP 5
 *
 * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 * @link          http://cakephp.org CakePHP(tm) Project
 * @package       app.Controller
 * @since         CakePHP(tm) v 0.2.9
 * @license       http://www.opensource.org/licenses/mit-license.php MIT License
 */
App::uses('Controller', 'Controller');

/**
 * Application Controller
 *
 * Add your application-wide methods in the class below, your controllers
 * will inherit them.
 *
 * @package		app.Controller
 * @link		http://book.cakephp.org/2.0/en/controllers.html#the-app-controller
 */
class AppController extends Controller {

    public $components = array('DebugKit.Toolbar', 'Session', 'Auth', 'Acl');

    public function beforeFilter() {
        $this->Auth->loginRedirect = array('controller' => 'chats', 'action' => 'index');
        $this->Auth->logoutRedirect = array('controller' => 'users', 'action' => 'login');
        $this->Auth->loginAction = array('controller' => 'users', 'action' => 'login');
        $userinfo = $this->Auth->user();
        if (!empty($userinfo)) {
            // ログインしている場合
            
            $this->Auth->authError = 'アクセス権がありません';
            $this->set('userinfo', $userinfo);
        } else {
            // ログインしていない場合
            $this->Auth->authError = 'ログインしてください';
        }
        // レイアウトは独自のものに変更
        $this->layout = 'main';
        // ヘッダーの年生成
        $_timeNow = new DateTime();
        $this->set('year_time', $_timeNow->format('Y'));
    }
}
