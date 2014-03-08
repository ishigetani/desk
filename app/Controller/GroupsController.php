<?php
App::uses('AppController', 'Controller');
/**
 * Groups Controller
 *
 * @property Group $Group
 * @property PaginatorComponent $Paginator
 */
class GroupsController extends AppController {

/**
 * Components
 *
 * @var array
 */
	public $components = array('Paginator');

    public function beforeFilter() {
        parent::beforeFilter();
        $this->Auth->allow('add');
    }

/**
 * index method
 *
 * @return void
 */
	public function index() {
        $options = array('conditions' => array('Group.' . $this->Group->primaryKey => $this->Auth->user('group_id')));
        $this->set('group', $this->Group->find('first', $options));
	}

/**
 * add method
 *
 * @return void
 */
	public function add() {
        $this->layout = 'login';
        $this->set("title_for_layout","グループ作成");
		if (!$this->request->is('post')) return;

        $this->Group->create();
        if ($this->Group->save($this->request->data['Group'])) {
            $this->request->data['User']['group_id'] = $this->Group->getInsertID();
            $this->request->data['User']['role_id'] = $this->__getAdminId();
            $this->loadModel('User');
            $this->User->recursive = -1;
            if ($this->User->save($this->request->data['User'])) {
                $this->Session->setFlash('DESKへようこそ！！');
                $this->request->data['User'] = array_merge($this->request->data['User'], array('id' => $this->User->id));
                $this->log($this->request->data['User'], DESK_LOG);
                $this->Auth->login($this->request->data['User']);
                $this->redirect(array('controller' => 'chats', 'action' => 'index'));
            }
        }
        // saveに失敗した場合
        $this->Session->setFlash(__('The group could not be saved. Please, try again.'));
	}

/**
 * edit method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function edit($id = null) {
		if (!$this->Group->exists($id)) {
			throw new NotFoundException(__('Invalid group'));
		}
		if ($this->request->is('post') || $this->request->is('put')) {
			if ($this->Group->save($this->request->data)) {
				$this->Session->setFlash(__('The group has been saved.'));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The group could not be saved. Please, try again.'));
			}
		} else {
			$options = array('conditions' => array('Group.' . $this->Group->primaryKey => $id));
			$this->request->data = $this->Group->find('first', $options);
		}
	}

/**
 * delete method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function delete($id = null) {
		$this->Group->id = $id;
		if (!$this->Group->exists()) {
			throw new NotFoundException(__('Invalid group'));
		}
		$this->request->onlyAllow('post', 'delete');
		if ($this->Group->delete()) {
			$this->Session->setFlash(__('The group has been deleted.'));
		} else {
			$this->Session->setFlash(__('The group could not be deleted. Please, try again.'));
		}
	    $this->redirect(array('action' => 'index'));
	}

    /**
     * Admin権限のID取り出し
     *
     * @return int
     */
    private function __getAdminId() {
        $this->loadModel('Role');
        $this->Role->recursive = -1;
        $_result = $this->Role->find('first', array('conditions' => array('name' => 'Admin'), 'fields' => array('id')));
        return (int)$_result['Role']['id'];
    }
}
