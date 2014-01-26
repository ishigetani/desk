<?php
App::uses('AppController', 'Controller');
/**
 * Users Controller
 *
 * @property User $User
 * @property PaginatorComponent $Paginator
 */
class UsersController extends AppController {

/**
 * Components
 *
 * @var array
 */
	public $components = array('Paginator', 'Auth' => array(
        'authenticate' => Array('Form' => Array('fields' => Array('username' => 'name', 'password' => 'passwd')))
    ));

/**
 * beforeFilter method
 *
 * @return void
 */
    public function beforeFilter() {
        parent::beforeFilter();
        $this->Auth->allow('login');
        $this->Auth->userScope = array('deleted' => 0);
    }

/**
 * login method
 *
 * @return void
 */
    public function login() {
        $this->layout = 'login';
        $this->set("title_for_layout","ログイン");
        $this->Session->delete('Auth.redirect');
        if (!empty($this->request->data)) {
            if($this->Auth->login()){
                $message = "Login is Success : ". $this->request->data['User']['name'];
                $this->log("$message", DESK_LOG);
                $this->redirect($this->Auth->redirectUrl());
            }else{
                $message = "Login is Error : ". $this->request->data['User']['name'];
                $this->log("$message", DESK_LOG);
                $this->Session->setFlash("ユーザ名またはパスワードが一致しません");
            }
        }
    }

/**
 * logout method
 *
 * @return void
 */
    public function logout() {
        $this->redirect($this->Auth->logout());
    }

/**
 * index method
 *
 * @return void
 */
	public function index() {
		$this->User->recursive = 0;
		$this->set('users', $this->Paginator->paginate());
	}

/**
 * view method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function view($id = null) {
		if (!$this->User->exists($id)) {
			throw new NotFoundException(__('Invalid user'));
		}
		$options = array('conditions' => array('User.' . $this->User->primaryKey => $id));
		$this->set('user', $this->User->find('first', $options));
	}

/**
 * add method
 *
 * @return void
 */
	public function add() {
		if ($this->request->is('post')) {
			$this->User->create();
			if ($this->User->save($this->request->data)) {
				$this->Session->setFlash('登録しました');
				$this->redirect(array('action' => 'index'));
			}
		}
		$groups = $this->User->Group->find('list');
		$this->set(compact('groups'));
        $roles = $this->User->Role->find('list');
        $this->set(compact('roles'));
	}

/**
 * edit method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function edit($id = null) {
		if (!$this->User->exists($id)) {
			throw new NotFoundException(__('Invalid user'));
		}
		if ($this->request->is('post') || $this->request->is('put')) {
			if ($this->User->save($this->request->data)) {
				$this->Session->setFlash(__('The user has been saved.'));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The user could not be saved. Please, try again.'));
			}
		} else {
			$options = array('conditions' => array('User.' . $this->User->primaryKey => $id));
			$this->request->data = $this->User->find('first', $options);
            $this->request->data['User']['passwd'] = null;
		}
		$groups = $this->User->Group->find('list');
		$this->set(compact('groups'));
        $roles = $this->User->Role->find('list');
        $this->set(compact('roles'));
	}

/**
 * delete method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function delete($id = null) {
		$this->User->id = $id;
		if (!$this->User->exists()) {
			throw new NotFoundException(__('Invalid user'));
		}
		$this->request->onlyAllow('post', 'delete');
		if ($this->User->delete()) {
			$this->Session->setFlash(__('The user has been deleted.'));
		} else {
			$this->Session->setFlash(__('The user could not be deleted. Please, try again.'));
		}
		$this->redirect(array('action' => 'index'));
	}}
