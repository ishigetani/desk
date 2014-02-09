<?php
App::uses('AppModel', 'Model');
/**
 * Role Model
 *
 * @property User $User
 */
class Role extends AppModel {

/**
 * Display field
 *
 * @var string
 */
	public $displayField = 'name';

    public $actsAs = array('Acl' => array('type' => 'requester'));

    public function parentNode() {
        return null;
    }

/**
 * Validation rules
 *
 * @var array
 */
	public $validate = array(
		'name' => array(
			'notEmpty' => array(
				'rule' => array('notEmpty'),
				'message' => '権限名を入力してください',
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
        'Group' => array(
            'className' => 'Group',
            'foreignKey' => 'group_id',
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
		'User' => array(
			'className' => 'User',
			'foreignKey' => 'role_id',
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

    /**
     * 所属しているグループで保存
     *
     * @param array $options
     * @return bool true
     */
    public function beforeSave($options = array()) {
        parent::beforeSave($options);
        $this->set('group_id', AuthComponent::user('group_id'));
        return true;
    }

    /**
     * 自分が所属しているContentとAllのみ表示
     *
     * @param array $queryData
     * @internal param string $type
     * @internal param array $query
     * @return array
     */
    public function beforeFind($queryData) {
        $queryData['conditions'][] = array('OR' => array('Role.group_id' => AuthComponent::user('group_id'),
                                                            'Role.opend' => 1));
        return $queryData;
    }
}