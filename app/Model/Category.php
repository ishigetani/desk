<?php
App::uses('AppModel', 'Model');
/**
 * Category Model
 *
 * @property Chat $Chat
 */
class Category extends AppModel {

/**
 * Validation rules
 *
 * @var array
 */
	public $validate = array(
		'name' => array(
			'notempty' => array(
				'rule' => array('notempty'),
				//'message' => 'Your custom message here',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
		'color' => array(
			'notempty' => array(
				'rule' => array('notempty'),
				//'message' => 'Your custom message here',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
		'deleted' => array(
			'boolean' => array(
				'rule' => array('boolean'),
				//'message' => 'Your custom message here',
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
		'Chat' => array(
			'className' => 'Chat',
			'foreignKey' => 'category_id',
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
     * @return bool ture
     */
    public function beforeSave($options = array()) {
        parent::beforeSave($options);
        $this->set('group_id', AuthComponent::user('group_id'));
        return ture;
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
        $queryData['conditions'][] = array('Category.group_id' => AuthComponent::user('group_id'));
        return $queryData;
    }
}
