<?php

declare(strict_types=1);

namespace App\Controller;

use Cake\Datasource\Exception\RecordNotFoundException;
use Cake\Event\EventInterface;

/**
 * Users Controller
 *
 * @property \App\Model\Table\UsersTable $Users
 * @property \Authorization\Controller\Component\AuthorizationComponent $Authorization
 * @property \Authentication\Controller\Component\AuthenticationComponent $Authentication
 * @method \App\Model\Entity\User[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class UsersController extends AppController
{
    public function beforeFilter(EventInterface $event): void
    {
        parent::beforeFilter($event);
        $this->Authentication->addUnauthenticatedActions(['login', 'add', 'logout']);
    }

    public function login()
    {
        $this->Authorization->skipAuthorization();
        $this->request->allowMethod(['get', 'post']);

        $result = $this->Authentication->getResult();

        if ($result && $result->isValid()) {
            $user = $result->getData();
            $controlador = 'Users';
            $acao = 'view';
            $parametro = $user->aluno_id ?? $user->professor_id ?? $user->supervisor_id ?? null;

            // Check category and ensure linkage
            switch ($user->categoria) {
                case '2': // Aluno
                    $aluno_id = $user->aluno_id;
                    if (empty($aluno_id)) {
                        $estudante = $this->fetchTable('Alunos')->find()
                            ->where(['Alunos.email' => $user->email])
                            ->first();

                        if (empty($estudante)) {
                            // Link failed, redirect to add Aluno?
                            $this->Flash->error(__('Aluno não encontrado. Por favor, cadastre-se.'));

                            return $this->redirect(['controller' => 'Alunos', 'action' => 'add', '?' => ['dre' => $user->numero, 'email' => $user->email]]);
                        } else {
                            // Link found, update user
                            $userEntity = $this->Users->get($user->id);
                            $userEntity->aluno_id = $estudante->id;
                            $this->Users->save($userEntity);
                            $parametro = $aluno->id;
                        }
                    } else {
                        $parametro = $aluno_id;
                    }
                    $controlador = 'Alunos';
                    $acao = 'view';
                    break;

                case '3': // Professor
                    $professor_id = $user->professor_id;
                    if (empty($professor_id)) {
                        $professor = $this->fetchTable('Professores')->find()
                            ->where(['Professores.email' => $user->email])
                            ->first();

                        if (empty($professor)) {
                            return $this->redirect(['controller' => 'Professores', 'action' => 'add', '?' => ['siape' => $user->numero, 'email' => $user->email]]);
                        } else {
                            $userEntity = $this->Users->get($user->id);
                            $userEntity->professor_id = $professor->id;
                            $userEntity->numero = $professor->siape;
                            $this->Users->save($userEntity);
                            $parametro = $professor->id;
                        }
                    } else {
                        $parametro = $professor_id;
                    }
                    $controlador = 'Professores';
                    $acao = 'view';
                    break;

                case '4': // Supervisor
                    $supervisor_id = $user->supervisor_id;
                    if (empty($supervisor_id)) {
                        $supervisor = $this->fetchTable('Supervisores')->find()
                            ->where(['Supervisores.email' => $user->email])
                            ->first();

                        if (empty($supervisor)) {
                             return $this->redirect(['controller' => 'Supervisores', 'action' => 'add', '?' => ['cress' => $user->numero, 'email' => $user->email]]);
                        } else {
                            $userEntity = $this->Users->get($user->id);
                            $userEntity->supervisor_id = $supervisor->id;
                            $userEntity->numero = $supervisor->cress;
                            $this->Users->save($userEntity);
                            $parametro = $supervisor->id;
                        }
                    } else {
                        $parametro = $supervisor_id;
                    }
                    $controlador = 'Supervisores';
                    $acao = 'view';
                    break;

                case '1': // Admin
                    $controlador = 'Muralestagios';
                    $acao = 'index';
                    break;

                default:
                    $this->Flash->error(__('Categoria inválida.'));
                    $this->Authentication->logout();

                    return $this->redirect(['action' => 'login']);
            }

            $this->Flash->success(__('Login realizado com sucesso'));

            // Redirect using parameters
            return $this->redirect(['controller' => $controlador, 'action' => $acao, $parametro]);
        }

        if ($this->request->is('post') && $result && !$result->isValid()) {
            $this->Flash->error(__('Usuário ou senha inválidos'));
        }
    }

    public function logout()
    {
        $this->Authorization->skipAuthorization();
        $result = $this->Authentication->getResult();
        if ($result && $result->isValid()) {
            $this->Authentication->logout();
            $this->Flash->success(__('Até mais!'));
        }

        return $this->redirect(['action' => 'login']);
    }

    /**
     * Index method
     *
     * @return \Cake\Http\Response|null|void Renders view
     */
    public function index()
    {
        $this->Authorization->skipAuthorization();
        $user = $this->Authentication->getIdentity();

        if ($user && $user->categoria == 1) {
            $users = $this->paginate($this->Users);
            $this->set(compact('users'));
        } else {
            $this->Flash->error(__('Usuário não autorizado'));

            return $this->redirect(['action' => 'login']);
        }
    }

    /**
     * View method
     *
     * @param string|null $id User id.
     * @return \Cake\Http\Response|null|void Renders view
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view(?string $id = null)
    {
        try {
            $user = $this->Users->get($id, [
                'contain' => [],
            ]);
        } catch (RecordNotFoundException $e) {
            $this->Flash->error(__('Usuário não encontrado.'));

            return $this->redirect(['action' => 'index']);
        }
        $this->Authorization->authorize($user);
        $this->set('user', $user);
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
<<<<<<< HEAD
        $user = $this->Users->newEmptyEntity();
=======
        $this->Authorization->skipAuthorization();
        $user = $this->Users->newEmptyEntity();

>>>>>>> f24fd5044a46c82646db2ccb8d44e906b708f1fd
        if ($this->request->is('post')) {
            $user = $this->Users->patchEntity($user, $this->request->getData());
            if ($this->Users->save($user)) {
                $this->Flash->success(__('Usuário cadastrado.'));

<<<<<<< HEAD
            /** Aluno */
            if ($this->request->getData('categoria') == 2):
=======
                // Post-save logic to link depending on category
                switch ($user->categoria) {
                    case '2': // Aluno
                        $aluno = $this->fetchTable('Alunos')->find()
                            ->where(['Alunos.registro' => $user->numero])
                            ->first();
>>>>>>> f24fd5044a46c82646db2ccb8d44e906b708f1fd

                        if ($aluno) {
                            $user->aluno_id = $aluno->id;
                            $this->Users->save($user);

                            return $this->redirect(['controller' => 'Alunos', 'action' => 'view', $aluno->id]);
                        } else {
                             $this->Flash->error(__('Redireciona para continuar com o cadastro do(a) aluno(a).'));

                             return $this->redirect(['controller' => 'Alunos', 'action' => 'add', '?' => ['dre' => $user->numero, 'email' => $user->email]]);
                        }
                        break;

<<<<<<< HEAD
                /* Verifico se está cadatrado como aluno */
                $estudantetabela = $this->fetchTable('Alunos');
                $estudantecadastrado = $estudantetabela->find()
                    ->where(['registro' => $this->request->getData('registro')])
                    ->first();
                /* Se está já cadastrado como aluno então capturo o id e aplico no usuer no campo aluno_id */
                if ($estudantecadastrado) {
                    $dados['aluno_id'] = $estudantecadastrado->id;
                    $userresultado = $this->Users->patchEntity($user, $dados);
                    $this->Users->save($userresultado);
                    $this->Flash->success(__('Usuário aluno inserido.'));
                    return $this->redirect(['controller' => 'alunos', 'action' => 'view', $estudantecadastrado->id]);
                } else {
                    $userresultado = $this->Users->patchEntity($user, $dados);
                    $this->Users->save($userresultado);
                    $this->Flash->success(__('Usuário inserido.'));
                    return $this->redirect(['controller' => 'alunos', 'action' => 'add']);
                }
                $this->Flash->error(__('O usuário de aluno não foi cadastrado. Tente novamente.'));
            endif;

            /** Professor */
            if ($this->request->getData('categoria') == 3):
                $dados = $this->request->getData();
                /* Verifico se já está cadastrado */
                $usercadastrado = $this->Users->find()
                    ->where(['email' => $this->request->getData('email')])
                    ->first();
                /* Se está cadastrado excluo para refazer a senha */
                if ($usercadastrado):
                    $this->Users->delete($usercadastrado->id);
                endif;

                /* Verifico se está cadatrado como professor */
                $professortabela = $this->fetchTable('Professores');
                $professorcadastrado = $professortabela->find()
                    ->where(['siape' => $this->request->getData('registro')])
                    ->first();
                if ($professorcadastrado):
                    $dados['professor_id'] = $professorcadastrado->id;
                    $userresultado = $this->Users->patchEntity($user, $dados);
                    $this->Users->save($userresultado);
                    $this->Flash->success(__('Usuário professor inserido.'));
                    return $this->redirect(['controller' => 'professores', 'action' => 'view', $professorcadastrado->id]);
                else:
                    $userresultado = $this->Users->patchEntity($user, $dados);
                    $this->Users->save($userresultado);
                    $this->Flash->success(__('Usuário professor inserido.'));
                    return $this->redirect(['controller' => 'professores', 'action' => 'add']);
                endif;
                $this->Flash->error(__('Professores são cadastrados diretamente junto com a Coordenação de Estágio'));
            endif;

            /** Supervisor */
            if ($this->request->getData('categoria') == 4):

                $dados = $this->request->getData();
                /* Verifico se já está cadastrado */
                $usercadastrado = $this->Users->find()
                    ->where(['email' => $this->request->getData('email')])
                    ->first();
                /* Se está cadastrado excluo para refazer a senha */
                if ($usercadastrado):
                    $this->Users->delete($usercadastrado->id);
                endif;
                /* Verifico se está cadatrado como supervisor */
                $supervisorestabela = $this->fetchTable('Supervisores');
                $supervisorcadastrado = $supervisorestabela->find()
                    ->where(['cress' => $this->request->getData('registro')])
                    ->first();
                if ($supervisorcadastrado):
                    $dados['supervisor_id'] = $supervisorcadastrado->id;
                    $userresultado = $this->Users->patchEntity($user, $dados);
                    $this->Users->save($userresultado);
                    $this->Flash->success(__('Usuário supervisor inserido.'));
                    return $this->redirect(['controller' => 'supervisores', 'action' => 'view', $supervisorcadastrado->id]);
                else:
                    $userresultado = $this->Users->patchEntity($user, $dados);
                    $this->Users->save($userresultado);
                    $this->Flash->success(__('Usuário supervisor inserido.'));
                    return $this->redirect(['controller' => 'supervisores', 'action' => 'add']);
                endif;
            endif;
        }
    }

    public function edit($id = null)
    {
        $user = $this->Users->get($id, [
            'contain' => [],
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $userresultado = $this->Users->patchEntity($user, $this->request->getData());
            $this->Users->save($userresultado);
            $this->Flash->success(__('User atualizado.'));
            return $this->redirect(['action' => 'view', $userresultado->id]);
        }
        $alunos = $this->Users->Alunos->find('list');
        $supervisores = $this->Users->Supervisores->find('list');
        $professores = $this->Users->Professores->find('list');
        $this->set(compact('user', 'alunos', 'supervisores', 'professores'));
    }

    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $userresultado = $this->Users->get($id);
        $this->Users->delete($userresultado);
        $this->Flash->success(__('Usuário excluído.'));
        return $this->redirect(['action' => 'index']);
    }

    public function logout()
    {
        $this->Authentication->logout();
        return $this->redirect(['controller' => 'Users', 'action' => 'login']);
    }

    public function login()
    {
        $this->request->allowMethod(['get', 'post']);
        $result = $this->Authentication->getResult();
        if ($result->isValid()) {
            switch ($this->Authentication->getIdentityData('categoria')):
                case 1:
                    $this->Flash->success(__('Bem-vindo(a) administrador(a)!'));
                    return $this->redirect(['controller' => 'Users', 'action' => 'index']);
                case 2:
                    $this->Flash->success(__('Bem-vindo(a) aluno(a)!'));
                    if (empty($this->Authentication->getIdentityData('aluno_id'))) {
                        $estudantecadastrado = $this->Users->Alunos->find()
                            ->where(['registro' => $this->Authentication->getIdentityData('registro')])
                            ->select(['id'])
                            ->first();
                        if ($estudantecadastrado) {
                            $users = $this->Users->get($this->Authentication->getIdentityData('id'));
                            $userestagiodata = $users->toArray();
                            $userestagiodata['aluno_id'] = $estudantecadastrado->id;
                            $userestagioresultado = $this->Users->patchEntity($users, $userestagiodata);
                            $this->Users->save($userestagioresultado);
                            return $this->redirect(['controller' => 'Alunos', 'action' => 'view', $estudantecadastrado->id]);
                        }
                    } else {
                        $aluno = $this->Users->Alunos->find()->where(['id' => $this->Authentication->getIdentityData('aluno_id')])->first();
                        if ($aluno) {
                            return $this->redirect(['controller' => 'Alunos', 'action' => 'view', $aluno->id]);
                        }
                        $this->Flash->error(__('Aluno não cadastrado'));
                        return $this->redirect(['controller' => 'Alunos', 'action' => 'add']);
                    }
                    break;
                case 3:
                    $this->Flash->success(__('Bem-vindo(a) professor(a)!'));
                    if (empty($this->Authentication->getIdentityData('professor_id'))) {
                        $professorcadastrado = $this->Users->Professores->find()->where(['siape' => $this->Authentication->getIdentityData('registro')])
                            ->select(['id'])
                            ->first();
                        if ($professorcadastrado) {
                            $users = $this->Users->get($this->Authentication->getIdentityData('id'));
                            $userestagiodata = $users->toArray();
                            $userestagiodata['professor_id'] = $professorcadastrado->id;
                            $users = $this->Users->patchEntity($users, $userestagiodata);
                            $this->Users->save($users);
                            return $this->redirect(['controller' => 'Professores', 'action' => 'view', $professorcadastrado->id]);
                        } else {
                            return $this->redirect(['controller' => 'Professores', 'action' => 'add']);
                        }
                    } else {
                        $professor = $this->Users->Professores->find()->where(['id' => $this->Authentication->getIdentityData('professor_id')])->first();
                        if ($professor) {
                            return $this->redirect(['controller' => 'Professores', 'action' => 'view', $professor->id]);
                        } else {
                            return $this->redirect(['controller' => 'Professores', 'action' => 'add']);
                        }
                    }
                    break;
                case 4:
                    if (empty($this->Authentication->getIdentityData('supervisor_id'))) {
                        $supervisorcadastrado = $this->Users->Supervisores->find()->where(['cress' => $this->Authentication->getIdentityData('registro')])
                            ->select(['id'])
                            ->first();
                        if ($supervisorcadastrado) {
                            $users = $this->Users->get($this->Authentication->getIdentityData('id'));
                            $userestagiodata = $users->toArray();
                            $userestagiodata['supervisor_id'] = $supervisorcadastrado->id;
                            $users = $this->Users->patchEntity($users, $userestagiodata);
                            $this->Users->save($users);
                            return $this->redirect(['controller' => 'Supervisores', 'action' => 'view', $supervisorcadastrado->id]);
                        } else {
                            return $this->redirect(['controller' => 'Supervisores', 'action' => 'add']);
                        }
                    } else {
                        $supervisor = $this->Users->Supervisores->find()->where(['id' => $this->Authentication->getIdentityData('supervisor_id')])->first();
                        if ($supervisor) {
                            return $this->redirect(['controller' => 'Supervisores', 'action' => 'view', $supervisor->id]);
                        }
                        return $this->redirect(['controller' => 'Supervisores', 'action' => 'add']);
                    }
                    break;
                default:
                    return $this->redirect(['controller' => 'Users', 'action' => 'logout']);
            endswitch;
        }
        if ($this->request->is('post') && !$result->isValid()) {
            $this->Flash->error(__('Usuário e/ou senha errado'));
        }
    }

    public function preencher()
    {
        $user = $this->Users->find('all');
        foreach ($user as $c_user) {
            if ($c_user->categoria == 2) {
                $alunostabela = $this->fetchTable('Alunos');
                $aluno = $alunostabela->find()
                    ->contain([])
                    ->where(['alunos.registro' => $c_user->registro])
                    ->first();
                $c_user->aluno_id = $aluno->id;
                $this->Users->save($c_user);
            }
            if ($c_user->categoria == 3) {
                $professorestabela = $this->fetchTable('Professores');
                $professor = $professorestabela->find()
                    ->contain([])
                    ->where(['professores.siape' => $c_user->registro])
                    ->first();
                $c_user->professor_id = $professor->id;
                $this->Users->save($c_user);
            }
            if ($c_user->categoria == 4) {
                $supervisorestabela = $this->fetchTable('Supervisores');
                $supervisor = $supervisorestabela->find()
                    ->contain([])
                    ->where(['supervisores.cress' => $c_user->registro])
                    ->first();
                $c_user->supervisor_id = $supervisor->id;
                $this->Users->save($c_user);
            }
        }
=======
                    case '3': // Professor
                         $professor = $this->fetchTable('Professores')->find()
                             ->where(['Professores.siape' => $user->numero])
                             ->first();
                        if ($professor) {
                            $user->professor_id = $professor->id;
                            $this->Users->save($user);

                            return $this->redirect(['controller' => 'Professores', 'action' => 'view', $professor->id]);
                        } else {
                            return $this->redirect(['controller' => 'Professores', 'action' => 'add', '?' => ['siape' => $user->numero, 'email' => $user->email]]);
                        }
                        break;

                    case '4': // Supervisor
                        $supervisor = $this->fetchTable('Supervisores')->find()
                            ->where(['Supervisores.cress' => $user->numero])
                            ->first();
                        if ($supervisor) {
                            $user->supervisor_id = $supervisor->id;
                            $this->Users->save($user);

                            return $this->redirect(['controller' => 'Supervisores', 'action' => 'view', $supervisor->id]);
                        } else {
                            return $this->redirect(['controller' => 'Supervisores', 'action' => 'add', '?' => ['cress' => $user->numero, 'email' => $user->email]]);
                        }
                        break;
                }

                return $this->redirect(['action' => 'login']);
            }
            $this->Flash->error(__('Usuário não foi cadastrado. Tente novamente.'));
        }
        $this->set(compact('user'));
    }

    /**
     * Edit method
     *
     * @param string|null $id User id.
     * @return \Cake\Http\Response|null|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit(?string $id = null)
    {
        try {
            $user = $this->Users->get($id, [
                'contain' => [],
            ]);
        } catch (RecordNotFoundException $e) {
            $this->Flash->error(__('Usuário não encontrado.'));

            return $this->redirect(['action' => 'index']);
        }

        $this->Authorization->authorize($user);

        if ($this->request->is(['patch', 'post', 'put'])) {
            $user = $this->Users->patchEntity($user, $this->request->getData());
            if ($this->Users->save($user)) {
                $this->Flash->success(__('Usuário atualizado.'));

                return $this->redirect(['action' => 'view', $user->id]);
            }
            $this->Flash->error(__('Usuário não atualizado.'));
        }
        $this->set(compact('user'));
    }

    /**
     * Delete method
     *
     * @param string|null $id User id.
     * @return \Cake\Http\Response|null|void Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete(?string $id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        try {
            $user = $this->Users->get($id);
        } catch (RecordNotFoundException $e) {
            $this->Flash->error(__('Registro de usuário não encontrado.'));

            return $this->redirect(['action' => 'index']);
        }

        $this->Authorization->authorize($user);

        if ($this->Users->delete($user)) {
            $this->Flash->success(__('Registro de usuário excluído.'));
        } else {
            $this->Flash->error(__('Registro de usuário não excluído.'));
        }

        return $this->redirect(['action' => 'index']); // or login
>>>>>>> f24fd5044a46c82646db2ccb8d44e906b708f1fd
    }
}
