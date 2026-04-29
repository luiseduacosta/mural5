<?php

declare(strict_types=1);

namespace App\Controller;

use App\Model\Entity\User;
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
                        $aluno = $this->fetchTable('Alunos')->find()
                            ->where(['Alunos.email' => $user->email])
                            ->first();

                        if (empty($aluno)) {
                            $this->Flash->error(__('Aluno não encontrado. Por favor, cadastre-se.'));

                            return $this->redirect(['controller' => 'Alunos', 'action' => 'add', '?' => ['dre' => $user->identificacao, 'email' => $user->email]]);
                        }

                        $userEntity = $this->Users->get($user->id);
                        $userEntity->aluno_id = $aluno->id;
                        $userEntity->entidade_id = $aluno->id;
                        $userEntity->identificacao = $aluno->registro;
                        $this->Users->save($userEntity);
                        $parametro = $aluno->id;
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
                            return $this->redirect(['controller' => 'Professores', 'action' => 'add', '?' => ['siape' => $user->identificacao, 'email' => $user->email]]);
                        }

                        $userEntity = $this->Users->get($user->id);
                        $userEntity->professor_id = $professor->id;
                        $userEntity->entidade_id = $professor->id;
                        $userEntity->identificacao = $professor->siape;
                        $this->Users->save($userEntity);
                        $parametro = $professor->id;
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
                            return $this->redirect(['controller' => 'Supervisores', 'action' => 'add', '?' => ['cress' => $user->identificacao, 'email' => $user->email]]);
                        }

                        $userEntity = $this->Users->get($user->id);
                        $userEntity->supervisor_id = $supervisor->id;
                        $userEntity->entidade_id = $supervisor->id;
                        $userEntity->identificacao = $supervisor->cress;
                        $this->Users->save($userEntity);
                        $parametro = $supervisor->id;
                    } else {
                        $parametro = $supervisor_id;
                    }
                    $controlador = 'Supervisores';
                    $acao = 'view';
                    break;

                case '1': // Admin
                    if (empty($user->entidade_id)) {
                        $administrador = $this->fetchTable('Administradores')->find()
                            ->where(['Administradores.user_id' => $user->id])
                            ->first();

                        if (empty($administrador)) {
                            $this->Flash->error(__('Registro de administrador não encontrado.'));
                            $this->Authentication->logout();

                            return $this->redirect(['action' => 'login']);
                        }

                        $userEntity = $this->Users->get($user->id);
                        $userEntity->entidade_id = $administrador->id;
                        $this->Users->save($userEntity);
                    }
                    $controlador = 'Muralestagios';
                    $acao = 'index';
                    break;

                default:
                    $this->Flash->error(__('Categoria inválida.'));
                    $this->Authentication->logout();

                    return $this->redirect(['action' => 'login']);
            }

            $this->Flash->success(__('Login realizado com sucesso'));

            // Refresh identity in session so FKs (aluno_id, professor_id, etc.)
            // updated above are visible to policies on this and subsequent requests.
            $freshUser = $this->Users->get($user->id);
            $this->Authentication->setIdentity($freshUser);

            // Redirect using parameters
            return $this->redirect(['controller' => $controlador, 'action' => $acao, $parametro]);
        }

        if ($this->request->is('post') && $result && !$result->isValid()) {
            $this->Flash->error(__('Usuário ou senha inválidos'));
        }

        $this->set('user', $this->Authentication->result);
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

        if ($user && $user->categoria === '1') {
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
        $this->Authorization->skipAuthorization();

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
        $this->Authorization->skipAuthorization();

        $user = $this->Users->newEmptyEntity();
        if ($this->request->getQuery('entidade_id')) {
            $entidade_id = $this->request->getQuery('entidade_id');
            $administradorCadastrado = $this->fetchTable('Administradores')->find()
                ->where(['id' => $entidade_id])
                ->first();

            if ($administradorCadastrado) {
                $user->nome = $administradorCadastrado->nome;
                $user->entidade_id = $administradorCadastrado->id;
                $user->role = 'admin';
            }
        }

        if ($this->request->is('post')) {
            $user = $this->Users->patchEntity($user, $this->request->getData());
            if ($this->Users->save($user)) {
                $this->Flash->success(__('Usuário cadastrado.'));
                // Update the user_id in the Users table
                $this->Users->save($user);

                $categoria = $this->request->getData('categoria');
                $email = $this->request->getData('email');
                $identificacao = $this->request->getData('identificacao');

                /** Aluno */
                if ($categoria === '2') {
                    $alunoCadastrado = $this->fetchTable('Alunos')->find()
                        ->where(['registro' => $identificacao])
                        ->first();

                    if ($alunoCadastrado) {
                        $user->aluno_id = $alunoCadastrado->id;
                        $user->entidade_id = $alunoCadastrado->id;
                        $user->role = 'aluno';
                        $this->Users->save($user);
                        $this->Flash->success(__('Usuário aluno vinculado.'));
                        // Update the user_id in the Alunos table
                        $alunoCadastrado->user_id = $user->id;
                        $this->fetchTable('Alunos')->save($alunoCadastrado);
                        return $this->redirect(['controller' => 'Alunos', 'action' => 'view', $alunoCadastrado->id]);
                    }

                    $this->Flash->error(__('Redireciona para continuar com o cadastro do(a) aluno(a).'));
                    return $this->redirect(['action' => 'add', '?' => ['email' => $email, 'registro' => $identificacao]]);
                }

                /** Professor */
                if ($categoria === '3') {
                    $professessorTabela = $this->fetchTable('Professores');
                    $professorCadastrado = $professessorTabela->find()
                        ->where(['siape' => $identificacao])
                        ->first();

                    if ($professorCadastrado) {
                        $user->professor_id = $professorCadastrado->id;
                        $user->entidade_id = $professorCadastrado->id;
                        $user->role = 'professor';
                        $this->Users->save($user);
                        $this->Flash->success(__('Usuário professor vinculado.'));
                        // Update the user_id in the Professores table
                        $professorCadastrado->user_id = $user->id;
                        $professessorTabela->save($professorCadastrado);
                        return $this->redirect(['controller' => 'Professores', 'action' => 'view', $professorCadastrado->id]);
                    }

                    $this->Flash->error(__('Professores são cadastrados diretamente junto com a Coordenação de Estágio'));
                    return $this->redirect(['controller' => 'Professores', 'action' => 'add', '?' => ['siape' => $identificacao, 'email' => $email]]);
                }

                /** Supervisor */
                if ($categoria === '4') {
                    $supervisorCadastrado = $this->fetchTable('Supervisores')->find()
                        ->where(['cress' => $identificacao])
                        ->first();

                    if ($supervisorCadastrado) {
                        $user->supervisor_id = $supervisorCadastrado->id;
                        $user->entidade_id = $supervisorCadastrado->id;
                        $user->role = 'supervisor';
                        $this->Users->save($user);
                        $this->Flash->success(__('Usuário supervisor vinculado.'));
                        // Update the user_id in the Supervervisores table
                        $supervisorCadastrado->user_id = $user->id;
                        $this->fetchTable('Supervisores')->save($supervisorCadastrado);
                        return $this->redirect(['controller' => 'Supervisores', 'action' => 'view', $supervisorCadastrado->id]);
                    }

                    $this->Flash->error(__('Supervisor não encontrado, redirecionando para cadastro.'));
                    return $this->redirect(['controller' => 'Supervisores', 'action' => 'add', '?' => ['cress' => $identificacao, 'email' => $email]]);
                }

                /** Admin */
                if ($categoria === '1') {
                    // Administrador add() gives the entidade_id value
                    $entidade_id = $this->request->getQuery('entidade_id');
                    if (empty($entidade_id)) {
                        $this->Flash->error(__('Administrador não cadastrado.'));
                        $this->Authentication->logout();
                        return $this->redirect(['action' => 'login']);
                    }
                    $administradorCadastrado = $this->fetchTable('Administradores')->find()
                        ->where(['id' => $entidade_id])
                        ->first();

                    if ($administradorCadastrado) {
                        $user->entidade_id = $administradorCadastrado->id;
                        $user->nome = $administradorCadastrado->nome;
                        $user->role = 'admin';
                        $this->Users->save($user);
                        $this->Flash->success(__('Usuário administrador vinculado.'));
                        // Update the user_id in the Administradores table
                        $administradorCadastrado->user_id = $user->id;
                        $this->fetchTable('Administradores')->save($administradorCadastrado);
                        return $this->redirect(['action' => 'view', $administradorCadastrado->id]);
                    }
                    $this->Flash->error(__('Administrador não encontrado, redirecionando para cadastro.'));
                    return $this->redirect(['controller' => 'Administradores', 'action' => 'add']);
                }

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('O usuário não pôde ser cadastrado. Tente novamente.'));
        }
        $this->set(compact('user'));
    }

    public function edit($id = null)
    {
        try {
            $user = $this->Users->get($id, [
                'contain' => [],
            ]);
        } catch (RecordNotFoundException $e) {
            $this->Flash->error(__('Usuário não encontrado.'));

            return $this->redirect(['action' => 'index']);
        }

        try {
            $this->Authorization->authorize($user);
        } catch (\Authorization\Exception\ForbiddenException $e) {
            $this->Flash->error(__('Acesso negado.'));

            return $this->redirect(['action' => 'index']);
        }

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

        try {
            $user = $this->Users->get($id);
        } catch (RecordNotFoundException $e) {
            $this->Flash->error(__('Usuário não encontrado.'));

            return $this->redirect(['action' => 'index']);
        }

        try {
            $this->Authorization->authorize($user);
        } catch (\Authorization\Exception\ForbiddenException $e) {
            $this->Flash->error(__('Acesso negado.'));

            return $this->redirect(['action' => 'index']);
        }

        if ($this->Users->delete($user)) {
            $this->Flash->success(__('Usuário excluído.'));
        }

        return $this->redirect(['action' => 'index']);
    }

    public function preencher()
    {
        try {
            $this->Authorization->authorize($this->Users);
        } catch (\Authorization\Exception\ForbiddenException $e) {
            $this->Flash->error(__('Acesso negado.'));

            return $this->redirect(['action' => 'index']);
        }

        $users = $this->Users->find('all');
        foreach ($users as $c_user) {
            // Sync role with categoria
            $expectedRole = User::CATEGORIA_ROLE_MAP[$c_user->categoria] ?? null;
            if ($expectedRole !== null && $c_user->role !== $expectedRole) {
                $c_user->role = $expectedRole;
            }

            if ($c_user->categoria === '1') {
                // Admin: ensure identificacao is null, link to administradores
                $c_user->identificacao = null;
                if (empty($c_user->entidade_id)) {
                    $administrador = $this->fetchTable('Administradores')->find()
                        ->where(['Administradores.user_id' => $c_user->id])
                        ->first();
                    if ($administrador) {
                        $c_user->entidade_id = $administrador->id;
                    }
                }
            }

            if ($c_user->categoria === '2') {
                // Aluno: link by identificacao (registro)
                if (empty($c_user->aluno_id) || empty($c_user->entidade_id)) {
                    $aluno = $this->fetchTable('Alunos')->find()
                        ->where(['Alunos.registro' => $c_user->identificacao])
                        ->first();
                    if ($aluno) {
                        $c_user->aluno_id = $aluno->id;
                        $c_user->entidade_id = $aluno->id;
                    }
                }
            }

            if ($c_user->categoria === '3') {
                // Professor: link by identificacao (siape)
                if (empty($c_user->professor_id) || empty($c_user->entidade_id)) {
                    $professor = $this->fetchTable('Professores')->find()
                        ->where(['Professores.siape' => $c_user->identificacao])
                        ->first();
                    if ($professor) {
                        $c_user->professor_id = $professor->id;
                        $c_user->entidade_id = $professor->id;
                    }
                }
            }

            if ($c_user->categoria === '4') {
                // Supervisor: link by identificacao (cress)
                if (empty($c_user->supervisor_id) || empty($c_user->entidade_id)) {
                    $supervisor = $this->fetchTable('Supervisores')->find()
                        ->where(['Supervisores.cress' => $c_user->identificacao])
                        ->first();
                    if ($supervisor) {
                        $c_user->supervisor_id = $supervisor->id;
                        $c_user->entidade_id = $supervisor->id;
                    }
                }
            }

            $this->Users->save($c_user);
        }

        $this->Flash->success(__('Dados dos usuários atualizados.'));

        return $this->redirect(['action' => 'index']);
    }
}
