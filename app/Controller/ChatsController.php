<?php
App::uses('AppController', 'Controller');
/**
 * Chats Controller
 *
 * @property Chat $Chat
 * @property PaginatorComponent $Paginator
 */
class ChatsController extends AppController {

/**
 * Components
 *
 * @var array
 */
	public $components = array('Paginator');

    public $uses = array('Chat');

/**
 * index method
 *
 * @return void
 */
	public function index() {
        $this->Chat->recursive = 0;
        $this->set('chats', $this->Paginator->paginate());
        if ($this->request->is('ajax')) {
            return $this->render('/Elements/chat', 'ajax');
        }
        $this->loadModel('Category');
        $this->Category->recursive = 0;
        $this->set('categories', $this->Category->find('list'));
	}

/**
 * add method
 *
 * @return void
 */
	public function add() {
        $this->autoRender = false;
		if (!$this->request->is('ajax')) {$this->redirect(array('action' => 'index'));}
        $this->Chat->create();
        $this->request->data['Chat']['user_id'] = $this->Auth->user('id');
        if (!$this->Chat->save($this->request->data)) {
            $this->set('valerror', $this->Chat->validationErrors['chat']);
        }
        $this->render('/Elements/success','ajax');
	}

/**
 * edit method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function edit($id = null) {
		if (!$this->Chat->exists($id)) {
			throw new NotFoundException(__('Invalid chat'));
		}
		if ($this->request->is('post') || $this->request->is('put')) {
			if ($this->Chat->save($this->request->data)) {
				$this->Session->setFlash(__('The chat has been saved.'));
				return $this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The chat could not be saved. Please, try again.'));
			}
		} else {
			$options = array('conditions' => array('Chat.' . $this->Chat->primaryKey => $id));
			$this->request->data = $this->Chat->find('first', $options);
		}
		$users = $this->Chat->User->find('list');
		$categories = $this->Chat->Category->find('list');
		$this->set(compact('users', 'categories'));
	}

/**
 * delete method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function delete($id = null) {
		$this->Chat->id = $id;
		if (!$this->Chat->exists()) {
			throw new NotFoundException(__('Invalid chat'));
		}
		$this->request->onlyAllow('post', 'delete');
		if ($this->Chat->delete()) {
			$this->Session->setFlash(__('The chat has been deleted.'));
		} else {
			$this->Session->setFlash(__('The chat could not be deleted. Please, try again.'));
		}
		return $this->redirect(array('action' => 'index'));
	}

    /**
     * update_check method
     *
     * @access Ajax only
     * @throws NotFoundException
     * @return boolean
     */
    public function update_check() {
        //if(!$this->request->is('ajax')) throw new NotFoundException();
        $this->autoRender = false;
        if ($this->Chat->update_check()) {
            return $this->render('/Elements/chat', 'ajax');
        } else {
            return $this->render('/Elements/chat', 'ajax');
        }
    }

}