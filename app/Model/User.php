<?php
App::uses('AppModel', 'Model');
/**
 * User Model
 *
 * @property Group $Group
 * @property Chat $Chat
 */
class User extends AppModel {

    public $actsAs = array('Acl' => array('type' => 'requester'));

/**
 * Validation rules
 *
 * @var array
 */
	public $validate = array(
		'name' => array(
			'notempty' => array(
				'rule' => array('notempty'),
				'message' => '入力してください',
				//'allowEmpty' => false,
				//'required' => false,
				'last' => true, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
            'alphaNumeric' => array(
                'rule' => array('alphaNumeric'),
                'message' => '半角英数字を入力してください'
            ),
            'isUnique' => array(
                'rule' => array('isUnique'),
                'message' => 'このユーザ名はすでに使用されています'
            )
		),
		'passwd' => array(
			'notempty' => array(
				'rule' => array('notempty'),
				'message' => '入力してください',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				'on' => 'create',
			),
		),
		'group_id' => array(
			'numeric' => array(
				'rule' => array('numeric'),
				'message' => 'グループを選択してください',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
        'mail' => array(
            'email' => array(
                'rule' => array('email'),
                'message' => 'メールアドレスを入力してください',
                'allowEmpty' => true,
            ),
            'isUnique' => array(
                'rule' => array('isUnique'),
                'message' => 'このメールアドレスはすでに使用されています',
                'allowEmpty' => true,
            )
        )
	);

	//The Associations below have been created with all possible keys, those that are not needed can be removed

/**
 * belongsTo associations
 *
 * @var array
 */
	public $belongsTo = array(
		'Group' => array(
			'className' => 'Group',
			'foreignKey' => 'group_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		),
        'Role' => array(
            'className' => 'Role',
            'foreignKey' => 'role_id',
            'conditions' => '',
            'fields' => '',
            'order' => ''
        )
	);

/**
 * hasMany associations
 *
 * @var array
 */
	public $hasMany = array(
		'Chat' => array(
			'className' => 'Chat',
			'foreignKey' => 'user_id',
			'dependent' => false,
			'conditions' => '',
			'fields' => '',
			'order' => '',
			'limit' => '',
			'offset' => '',
			'exclusive' => '',
			'finderQuery' => '',
			'counterQuery' => ''
		)
	);

    public function save($data = null, $validate = true, $fieldList = array()) {
        if (!empty($data['User']['id']) && empty($data['User']['passwd'])) {
            $fieldList = array(
                'name', 'group_id', 'role_id', 'mail', 'modified', 'deleted', 'deleted_date'
            );
        } else if (isset($data['User']['passwd'])) {
            $data['User']['passwd'] = AuthComponent::password($data['User']['passwd']);
        }
        return parent::save($data, $validate, $fieldList);
    }

    /**
     * 半角英数字のみOK(日本語にも対応)
     *
     * @link http://www.tailtension.com/cakephp/1112/
     */
    public function alphaNumeric($check) {
        $value = array_values($check);
        $value = $value[0];
        return preg_match('/^[a-zA-Z0-9]+$/', $value);
    }

    /**
     * @return array|null
     */
    public function parentNode() {
        if (!$this->id && empty($this->data)) {
            return null;
        }
        if (isset($this->data['User']['role_id'])) {
            $roleId = $this->data['User']['role_id'];
        } else {
            $roleId = $this->field('role_id');
        }
        if (!$roleId) {
            return null;
        } else {
            return array('Role' => array('id' => $roleId));
        }
    }
}
