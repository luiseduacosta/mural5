<?php

declare(strict_types=1);

namespace App\Controller;

/**
 * Users Controller
 *
 * @property \App\Model\Table\UsersTable $Users
 * @method \App\Model\Entity\User[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class UsersController extends AppController
{

    public function beforeFilter(\Cake\Event\EventInterface $event)
    {
        parent::beforeFilter($event);
        // Configure the login action to not require authentication, preventing
        // the infinite redirect loop issue
        $this->Authentication->addUnauthenticatedActions(['login', 'add', 'index']);
    }

    /**
     * Index method
     *
     * @return \Cake\Http\Response|null|void Renders view
     */
    public function index()
    {
        $query = $this->Users->find('all')->contain(['Alunos', 'Supervisores', 'Professores']);
        $users = $this->paginate($query);
        $this->set(compact('users'));
    }

    /**
     * View method
     *
     * @param string|null $id User id.
     * @return \Cake\Http\Response|null|void Renders view
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {

        $userestagio = $this->Users->get($id, [
            'contain' => ['Alunos', 'Supervisores', 'Professores'],
        ]);

        if (!isset($userestagio)) {
            $this->Flash->error(__('Nao ha registros de usuario para esse numero!'));
            return $this->redirect(['action' => 'index']);
        }

        $this->set(compact('userestagio'));
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $user = $this->Users->newEmptyEntity();
        if ($this->request->is('post')) {

            /** Aluno */
            if ($this->request->getData('categoria') == 2):

                $dados = $this->request->getData();

                /* Verifico se já está cadastrado */
                $usercadastrado = $this->Users->find()
                    ->where(['email' => $this->request->getData('email'), 'registro' => $this->request->getData('registro')])
                    ->first();

                /* Se está cadastrado excluo para refazer a senha */
                if ($usercadastrado):
                    $this->Users->delete($usercadastrado->id);
                endif;

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
    }
}
