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

    public $filterArgs = array(
        array('name' => 'category', 'type' => 'value', 'field' => 'Chat.category_id')
    );

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
            'myUpdate' => array(
                'rule' => array('myUpdateCheck'),
                'message' => '自分が作成したものしか変更することが出来ません',
                'on' => 'update',
                'last' => true
            )
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

    /**
     * 自分が所属しているContentのみ表示
     *
     * @param array $queryData
     * @internal param string $type
     * @internal param array $query
     * @return array
     */
    public function beforeFind($queryData) {
        if (Configure::read('GroupFilter') && !empty(AuthComponent::user('group_id'))) {
            $queryData['conditions'][] = array('User.group_id' => AuthComponent::user('group_id'));
        }
        return $queryData;
    }

    /**
     * アップデート時、本人でしか編集させない
     *
     * @param $data
     * @return bool
     */
    public function myUpdateCheck($data) {
        if ($data['user_id'] === AuthComponent::user('id')) {
            return true;
        }
        return false;
    }

    /**
     * 作成者を検索
     *
     * @param null $id
     * @return mixed
     */
    public function createrFind($id = null) {
        $_data = $this->find('first', array('conditions' => array('Chat.id' => $id), 'fields' => array('user_id')));
        return $_data['Chat']['user_id'];
    }
}
