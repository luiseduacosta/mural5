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
        $user = $this->Users->newEmptyEntity();
        if ($this->request->is('post')) {
            $user = $this->Users->patchEntity($user, $this->request->getData());
            if ($this->Users->save($user)) {
                $this->Flash->success(__('Usuário cadastrado.'));

                $categoria = (int)$this->request->getData('categoria');
                $registro = $this->request->getData('registro');

                /** Aluno */
                if ($categoria === 2) {
                    $estudantetabela = $this->fetchTable('Alunos');
                    $estudantecadastrado = $estudantetabela->find()
                        ->where(['registro' => $registro])
                        ->first();
                        
                    if ($estudantecadastrado) {
                        $user->aluno_id = $estudantecadastrado->id;
                        $this->Users->save($user);
                        $this->Flash->success(__('Usuário aluno vinculado.'));
                        return $this->redirect(['controller' => 'Alunos', 'action' => 'view', $estudantecadastrado->id]);
                    } else {
                        $this->Flash->error(__('Redireciona para continuar com o cadastro do(a) aluno(a).'));
                        return $this->redirect(['controller' => 'Alunos', 'action' => 'add', '?' => ['dre' => $user->numero ?? $registro, 'email' => $user->email]]);
                    }
                }

                /** Professor */
                if ($categoria === 3) {
                    $professortabela = $this->fetchTable('Professores');
                    $professorcadastrado = $professortabela->find()
                        ->where(['siape' => $registro])
                        ->first();
                        
                    if ($professorcadastrado) {
                        $user->professor_id = $professorcadastrado->id;
                        $this->Users->save($user);
                        $this->Flash->success(__('Usuário professor vinculado.'));
                        return $this->redirect(['controller' => 'Professores', 'action' => 'view', $professorcadastrado->id]);
                    } else {
                        $this->Flash->error(__('Professores são cadastrados diretamente junto com a Coordenação de Estágio'));
                        return $this->redirect(['controller' => 'Professores', 'action' => 'add', '?' => ['siape' => $user->numero ?? $registro, 'email' => $user->email]]);
                    }
                }

                /** Supervisor */
                if ($categoria === 4) {
                    $supervisorestabela = $this->fetchTable('Supervisores');
                    $supervisorcadastrado = $supervisorestabela->find()
                        ->where(['cress' => $registro])
                        ->first();
                        
                    if ($supervisorcadastrado) {
                        $user->supervisor_id = $supervisorcadastrado->id;
                        $this->Users->save($user);
                        $this->Flash->success(__('Usuário supervisor vinculado.'));
                        return $this->redirect(['controller' => 'Supervisores', 'action' => 'view', $supervisorcadastrado->id]);
                    } else {
                        $this->Flash->error(__('Supervisor não encontrado, redirecionando para cadastro.'));
                        return $this->redirect(['controller' => 'Supervisores', 'action' => 'add', '?' => ['cress' => $user->numero ?? $registro, 'email' => $user->email]]);
                    }
                }

                // If admin or other category, just redirect to index
                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('O usuário não pôde ser cadastrado. Tente novamente.'));
        }
        $this->set(compact('user'));
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
