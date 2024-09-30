<?php

declare(strict_types=1);

namespace App\Controller;

/**
 * Users Controller
 *
 * @property \App\Model\Table\UsersTable $Users
 * @method \App\Model\Entity\User[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class UsersController extends AppController {

    /**
     * Index method
     *
     * @return \Cake\Http\Response|null|void Renders view
     */
    public function index() {
        //$this->paginate = [
        //    'contain' => ['Alunos', 'Supervisores', 'Professores'],
        //];
        $users = $this->paginate($this->Users);
        $this->set(compact('users'));
    }

    /**
     * View method
     *
     * @param string|null $id User id.
     * @return \Cake\Http\Response|null|void Renders view
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null) {
        $user = $this->Users->get($id, [
            'contain' => ['Alunos', 'Supervisores', 'Professores'],
        ]);
        $this->set(compact('user'));
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null|void Redirects on successful add, renders view otherwise.
     */
    public function add() {
        $user = $this->Users->newEmptyEntity();
        if ($this->request->is('post')) {
            $user = $this->Users->patchEntity($user, $this->request->getData());
            if ($this->Users->save($user)) {
                $this->Flash->success(__('The user has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The user could not be saved. Please, try again.'));
        }
        $categorias = $this->Users->Categorias->find('list', ['limit' => 200]);
        $alunos = $this->Users->Alunos->find('list', ['limit' => 200]);
        $supervisores = $this->Users->Supervisores->find('list', ['limit' => 200]);
        $professores = $this->Users->Professores->find('list', ['limit' => 200]);
        $this->set(compact('user', 'alunos', 'supervisores', 'professores', 'categorias'));
    }

    /**
     * Edit method
     *
     * @param string|null $id User id.
     * @return \Cake\Http\Response|null|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null) {
        $user = $this->Users->get($id, [
            'contain' => [],
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $user = $this->Users->patchEntity($user, $this->request->getData());
            if ($this->Users->save($user)) {
                $this->Flash->success(__('The user has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The user could not be saved. Please, try again.'));
        }
        $categorias = $this->Users->Categorias->find('list', ['limit' => 200]);
        $alunos = $this->Users->Alunos->find('list', ['limit' => 200]);
        $supervisores = $this->Users->Supervisores->find('list', ['limit' => 200]);
        $professores = $this->Users->Professores->find('list', ['limit' => 200]);
        $this->set(compact('user', 'alunos', 'supervisores', 'professores', 'categorias'));
    }

    /**
     * Delete method
     *
     * @param string|null $id User id.
     * @return \Cake\Http\Response|null|void Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null) {
        $this->request->allowMethod(['post', 'delete']);
        $user = $this->Users->get($id);
        if ($this->Users->delete($user)) {
            $this->Flash->success(__('The user has been deleted.'));
        } else {
            $this->Flash->error(__('The user could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }

    /*
     * Preenche o id da tabela users com os valores correspondentes
     */

    public function preencher() {

        $user = $this->Users->find('all');
        foreach ($user as $c_user) {
            // pr($c_user->categoria);
            if ($c_user->categoria == 2) {
                // pr($c_user->numero);
                $alunostabela = $this->fetchTable('Alunos');
                $aluno = $alunostabela->find()
                        ->contain([])
                        ->where(['alunos.registro' => $c_user->numero])
                        ->first();
                // pr($aluno);
                // pr($aluno->first()->registro);
                $c_user->aluno->id;
                // pr($c_user->aluno_id);
                // pr($c_user->id);
                if ($this->Users->save($c_user)) {
                    // echo "Atualizado!" . "</br>";
                    $this->Flash->success(__('The user has been saved.'));
                } else {
                    // echo "Erro!" . "<br>";
                    $this->Flash->error(__('The user could not be saved. Please, try again.'));
                };
                // die();
            }
            // die('Alunos');
            // Professores
            if ($c_user->categoria == 3) {
                // pr($c_user->numero);
                // die();
                $professorestabela = $this->fetchTable('Professores');
                $professor = $professorestabela->find()
                        ->contain([])
                        ->where(['professores.siape' => $c_user->numero])
                        ->first();
                // pr($professor);
                // pr($professor->first()->siape);
                $c_user->professor_id = $professor->id;
                // pr($c_user->professor_id);
                // pr($c_user->id);
                // die();
                if ($this->Users->save($c_user)) {
                    echo "Atualizado!" . "</br>";
                    $this->Flash->success(__('The user has been saved.'));
                } else {
                    echo "Erro!" . "<br>";
                    $this->Flash->error(__('The user could not be saved. Please, try again.'));
                };
                // die('if professores');
            }
            // die('Professores');
            // Supervisores
            if ($c_user->categoria == 4) {
                // pr($c_user->numero);
                // die();
                $supervisorestabela = $this->fetchTable('Supervisores');
                $supervisor = $supervisorestabela->find()
                        ->contain([])
                        ->where(['supervisores.cress' => $c_user->numero])
                        ->first();
                // pr($professor);
                // pr($professor->first()->siape);
                $c_user->supervisor_id = $supervisor->id;
                // pr($c_user->professor_id);
                // pr($c_user->id);
                // die();
                if ($this->Users->save($c_user)) {
                    echo "Atualizado!" . "</br>";
                    $this->Flash->success(__('The user has been saved.'));
                } else {
                    echo "Erro!" . "<br>";
                    $this->Flash->error(__('The user could not be saved. Please, try again.'));
                };
                // die('if professores');
            }
            // die('Professores');
        }
        // pr($user);
        die();
    }
}
