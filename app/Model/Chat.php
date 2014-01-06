<?php
App::uses('AppModel', 'Model');
/**
 * Chat Model
 *
 * @property User $User
 * @property Category $Category
 */
class Chat extends AppModel {

    public $order = 'Chat.id DESC';

/**
 * Validation rules
 *
 * @var array
 */
	public $validate = array(
		'user_id' => array(
			'numeric' => array(
				'rule' => array('numeric'),
				'message' => 'ユーザ情報が不正です',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
		'chat' => array(
			'notempty' => array(
				'rule' => array('notempty'),
				'message' => 'メッセージを入力してください',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
		'category_id' => array(
			'numeric' => array(
				'rule' => array('numeric'),
				'message' => 'カテゴリを選択してください',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
	);

	//The Associations below have been created with all possible keys, those that are not needed can be removed

/**
 * belongsTo associations
 *
 * @var array
 */
	public $belongsTo = array(
		'User' => array(
			'className' => 'User',
			'foreignKey' => 'user_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		),
		'Category' => array(
			'className' => 'Category',
			'foreignKey' => 'category_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		)
	);

    // comet処理
    public function update_check($id = null) {
        if(empty($id)) return false;
        $result = false;
        $this->recursive = -1;
        $_data['created'] = $this->find('first', array('fields' => array('id', 'user_id') ,'order' => array('id' => 'DESC')));
        $_data['modified'] = $this->find('first', array('fields' => array('id', 'user_id') ,'order' => array('modified' => 'DESC')));
        for ($i = 0; $i < 20; $i++) {
            sleep(1);
            // 作成・更新されたデータがあれば終了
            $_tmp['created'] = $this->find('first', array('fields' => array('id', 'user_id') ,'order' => array('id' => 'DESC')));
            if ($_data['created'] != $_tmp['created']) {
                // 自分以外が更新した場合trueを返す
                if ($_tmp['created']['Chat']['user_id'] == $id) {
                    $result = false;
                } else {
                    $result = true;
                }
                break;
            }
            $_tmp['modified'] = $this->find('first', array('fields' => array('id', 'user_id') ,'order' => array('modified' => 'DESC')));
            if ($_data['modified'] != $_tmp['modified']) {
                // 自分以外が更新した場合trueを返す
                if ($_tmp['modified']['Chat']['user_id'] == $id) {
                    $result = false;
                } else {
                    $result = true;
                }
                break;
            }
        }
        return $result;
    }
}
