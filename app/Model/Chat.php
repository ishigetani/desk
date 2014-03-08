<?php
App::uses('AppModel', 'Model');
App::uses('CakeSession', 'Model/Datasource');
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
			'notEmpty' => array(
				'rule' => array('notEmpty'),
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

    /**
     * @param null $id
     * @return bool
     */
    public function update_check($id = null) {
        if(empty($id)) return false;
        $result = false;
        $this->recursive = -1;
        $_data['created'] = $this->find('first', array('fields' => array('id', 'user_id') ,'order' => array('id' => 'DESC')));
        $_data['modified'] = $this->find('first', array('fields' => array('id', 'user_id') ,'order' => array('modified' => 'DESC')));
        // session値に前回の最新データを入れておく
        if (!CakeSession::check('chatId')) {
            CakeSession::write('chatId', $_data);
            return $result;
        } else {
            $_tmp = CakeSession::read('chatId');
        }
        if ($_data['created'] != $_tmp['created']) {
            // 自分以外が更新した場合trueを返す
            if ($_tmp['created']['Chat']['user_id'] != $id) {
                $result = true;
            }
        }
        if ($_data['modified'] != $_tmp['modified']) {
            // 自分以外が更新した場合trueを返す
            if ($_tmp['modified']['Chat']['user_id'] != $id) {
                $result = true;
            }
        }
        if ($result) {
            // 更新がある場合
            CakeSession::write('chatId', $_data);
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
        if (Configure::read('GroupFilter') && !empty(AuthComponent::user('group_id')) && $this->recursive > -1) {
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
}
