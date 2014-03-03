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
        $this->Auth->allow('login', 'getGroupId');
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
            $this->request->data['User']['group_id'] = $this->Auth->user('group_id');
			$this->User->create();
			if ($this->User->save($this->request->data['User'])) {
                $message = '登録しました。';
                $message = $this->__entryMail($this->User->getInsertID(), $message);
				$this->Session->setFlash($message);
				$this->redirect(array('action' => 'index'));
			}
		}
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
            $this->request->data['User']['group_id'] = $this->Auth->user('group_id');
			if ($this->User->save($this->request->data['User'])) {
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
	}

    /**
     * ユーザ登録時のメール送信
     *
     * @param null $id
     * @param null $message
     * @return null|string
     */
    private function __entryMail($id = null, $message = null) {
        if (empty($id)) {
            LogError('登録メールの送信を始められませんでした');
            return $message;
        }
        App::uses('CakeEmail', 'Network/Email');
        $email = new CakeEmail('gmail');
        try {
            $data = $this->User->find('first', array('conditions' => array('User.id' => $id)));
            // テンプレートに送る変数
            $ary_vars = array (
                'name' => $data['User']['name'],
                'group' => $data['Group']['name'],
                'role' => $data['Role']['name'],
            );
            $email->template('entry', 'default'); // template, layout
            $email->viewVars($ary_vars);

            $email->to($data['User']['mail'])
                ->subject('DESK登録完了')
                ->send();

            $message .= '完了メールを送信しましたのでご確認ください';
        } catch(Exception $e) {
            $message = "USERID:". $id. "へのメールが飛びませんでした";
            LogError($message);
        }

        return $message;
    }

    /**
     * ログインユーザのgroup_idを返す(node.js)
     *
     * @return int
     */
    public function getGroupId($user_id = null) {
        $this->viewClass = 'Json';
        $this->User->recursive = -1;
        $group_id = $this->User->find('first', array('conditions' => array('id' => $user_id), 'fields' => array('group_id')));
        $this->set('group_id', $group_id['User']);
        $this->set('_serialize', 'group_id');
    }
}