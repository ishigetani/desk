<?php
App::uses('AppModel', 'Model');
/**
 * Chat Model
 *
 * @property User $User
 * @property Category $Category
 */
class Chat extends AppModel {

    public $order = 'Chat.created DESC';

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
    public function update_check() {
        $this->recursive = -1;
        $_data['created'] = $this->find('first', array('fields' => 'id' ,'order' => array('created' => 'DESC')));
        $_data['modified'] = $this->find('first', array('fields' => 'id' ,'order' => array('modified' => 'DESC')));
        for ($i = 0; $i < 10; $i++) {
            sleep(1);
            // 作成・更新されたデータがあれば終了
            if ($_data['created'] != $this->find('first', array('fields' => 'id' ,'order' => array('created' => 'DESC'))) ||
                $_data['modified'] != $this->find('first', array('fields' => 'id' ,'order' => array('modified' => 'DESC')))) {
                return true;
            }
        }
        return false;
    }
}
