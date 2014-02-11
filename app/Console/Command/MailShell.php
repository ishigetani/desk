<?php
/**
 * Created by PhpStorm.
 * User: ishigetani
 * Date: 14/01/18
 * Time: 9:20
 */

App::uses('CakeEmail', 'Network/Email');

class MailShell extends Shell {
    public $uses = array('Chat', 'User', 'Group');

    public function main() {
        $this->log("更新メールの送信を開始します", DESK_LOG);
        // Groupフィルターの一時解除
        Configure::write('GroupFilter', false);
        // グループごとに送信
        $this->Group->recursive = -1;
        $groups = $this->Group->find('all', array('fields' => array('id', 'name')));
        foreach ($groups as $group) {
            $this->log("---------------------------------------------------------------------------", DESK_LOG);
            $this->log($group['Group']['name']. 'への送信', DESK_LOG);
            $message = $this->send($group['Group']['id']);
            $this->log($message, DESK_LOG);
            $this->log("---------------------------------------------------------------------------", DESK_LOG);
        }
        $this->log("送信が正常に終了しました", DESK_LOG);
    }

    /**
     * send method
     *
     * @param int $group_id
     * @return string $message
     */
    private function send($group_id = null) {
        // 更新チェック
        $update_number = $this->yesterday_content($group_id);
        if ($update_number == 0) {
            $message = '昨日の更新はありませんでした';
            return $message;
        }
        $all = 0; // 送るべき人数
        $success = 0; // 送信成功人数
        // メールアドレスを設定しているユーザの検索
        $this->User->recursive = -1;
        $users = $this->User->find('all',
            array('conditions' => array('NOT' => array('mail' => ""), array('User.group_id' => $group_id))));
        $email = new CakeEmail('gmail');
        foreach ($users as $user) {
            $all++;
            try {
                // テンプレートに送る変数
                $ary_vars = array (
                    'name' => $user['User']['name'],
                    'update_number' => $update_number,
                );
                $email->template('routine', 'default'); // template, layout
                $email->viewVars($ary_vars);

                $email->to($user['User']['mail'])
                    ->subject('DESK更新情報')
                    ->send();

                $success++;
            } catch(Exception $e) {
                $message = "USERID:". $user['id']. "へのメールが飛びませんでした";
                LogError($message);
            }
        }
        return $message = $success. "/". $all. "名にメール送信しました";
    }

    /**
     * yesterday_content method
     *
     * @param int $group_id
     * @return int
     */
    private function yesterday_content($group_id = null) {
        $date = new DateTime();
        $date->sub(new DateInterval('P1D'));    // 昨日の日付に設定
        $this->Chat->recursive = 0;
        return $this->Chat->find('count', array('conditions' => array(
            'Chat.modified BETWEEN ? AND ?' => array($date->format('Y-m-d')." 00:00:00", $date->format('Y-m-d')." 23:59:59"),
            'User.group_id' => $group_id,
        )));
    }
}