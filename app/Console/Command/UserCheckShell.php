<?php
/**
 * Created by PhpStorm.
 * User: ishigetani
 * Date: 14/01/18
 * Time: 9:20
 */

App::uses('CakeEmail', 'Network/Email');

class UserCheckShell extends Shell {
    public $uses = array('User', 'Group');

    public function main() {
        $this->log("---------------------------------------------------------------------------", DESK_LOG);
        $this->log("ユーザ数のチェックを開始します", DESK_LOG);
        // Groupフィルターの一時解除
        Configure::write('GroupFilter', false);
        // グループ数の確認
        $this->Group->recursive = -1;
        $group_num = $this->Group->find('count', array('conditions' => array($this->__weekSet())));
        // ユーザ数の確認
        $this->User->recursive = -1;
        $user_num = $this->User->find('count', array('conditions' => array($this->__weekSet())));

        if ($user_num > 0 || $group_num > 0) {
            $this->log('新規ユーザがいたのでメール送信をします', DESK_LOG);
            $email = new CakeEmail('gmail');
            // テンプレートに送る変数
            $ary_vars = array (
                'user_num' => $user_num,
                'group_num' => $group_num,
            );
            $email->template('num_check', 'default'); // template, layout
            $email->viewVars($ary_vars);
            $email->to(ADMIN_MAIL)
                ->subject('DESKユーザ情報')
                ->send();
        } else {
            $this->log('新規ユーザはいませんでした', DESK_LOG);
        }

        $this->log("ユーザ数のチェックを終了します", DESK_LOG);
        $this->log("---------------------------------------------------------------------------", DESK_LOG);
    }

    /**
     * 8日前～１日前(１週間)のconditionを生成する
     *
     * @return array
     */
    private function __weekSet() {
        $date = new DateTime();
        $date->sub(new DateInterval('P1D'));    // 1日前
        $now = $date->format('Y-m-d');
        $date->sub(new DateInterval('P7D'));    // さらに7日前
        $before_week = $date->format('Y-m-d');
        return array(
            'modified BETWEEN ? AND ?' => array($before_week." 00:00:00", $now." 23:59:59")
        );
    }
}