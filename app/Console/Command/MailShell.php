<?php
/**
 * Created by PhpStorm.
 * User: ishigetani
 * Date: 14/01/18
 * Time: 9:20
 */

App::uses('CakeEmail', 'Network/Email');

class MailShell extends Shell {
    public $uses = array('Chat', 'User');

    function main() {
        // 更新チェック
        if ($this->yesterday_content() == 0) {
            $this->log('昨日の更新はありませんでした', DESK_LOG);
            return;
        }
        $all = 0; // 送るべき人数
        $success = 0; // 送信成功人数
        // メールアドレスを設定しているユーザの検索
        $this->User->recursive = -1;
        $users = $this->User->find('all', array('conditions' => array('NOT' => array('mail' => ""))));
        $email = new CakeEmail('gmail');
        foreach ($users as $user) {
            $all++;
            try {
                // テンプレートに送る変数
                $ary_vars = array (
                    'name' => $user['User']['name']
                );
                $email->template('routine', 'default'); // template, layout
                $email->viewVars($ary_vars);

                $email->to($user['User']['mail'])
                    ->subject('test')
                    ->send('テスト');
                $success++;
            } catch(Exception $e) {
                $message = "USERID:". $user['id']. "へのメールが飛びませんでした";
                LogError($message);
            }
        }
        $message = $success. "/". $all. "名にメール送信しました";
        $this->log($message, DESK_LOG);
        $this->out($message);
    }

    /**
     * yesterday_content method
     *
     * @return int
     */
    public function yesterday_content() {
        $date = new DateTime();
        $date->sub(new DateInterval('P1D'));
        $this->Chat->recursive = -1;
        return $this->Chat->find('count', array('conditions' => array(
            'modified BETWEEN ? AND ?' => array($date->format('Y-m-d')." 00:00:00", $date->format('Y-m-d')." 23:59:59")
        )));
    }
}