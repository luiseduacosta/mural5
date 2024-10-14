<?php

declare(strict_types=1);

namespace App\Controller;

/**
 * Professores Controller
 *
 * @property \App\Model\Table\ProfessoresTable $Professores
 * @method \App\Model\Entity\Professor[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class ProfessoresController extends AppController {

    /**
     * Index method
     *
     * @return \Cake\Http\Response|null|void Renders view
     */
    public function index() {
        $professores = $this->paginate($this->Professores);

        $this->set(compact('professores'));
    }

    /**
     * View method
     *
     * @param string|null $id Professor id.
     * @return \Cake\Http\Response|null|void Renders view
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null) {

        if (is_null($id)) {
            $siape = $this->getRequest()->getQuery('siape');
            if (isset($siape)):
                $idquery = $this->Professores->find()->where(['siape' => $siape]);
                $id = $idquery->first();
                $id = $id->id;
            endif;
        }
        /** Têm professores com muitos estagiários: aumentar a memória */
        ini_set('memory_limit', '2048M');
        $professor = $this->Professores->get($id, [
            'contain' => ['Estagiarios' => ['sort' => ['Estagiarios.periodo DESC'], 'Alunos', 'Instituicoes', 'Supervisores', 'Professores']]
                ]
        );

        if (!isset($professor)) {
            $this->Flash->error(__('Nao ha registros de professor para esse numero!'));
            return $this->redirect(['action' => 'index']);
        }

        $this->set(compact('professor'));
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null|void Redirects on successful add, renders view otherwise.
     */
    public function add() {

        $siape = $this->getRequest()->getQuery('siape');
        $email = $this->getRequest()->getQuery('email');

        /** Para o formulário */
        if ($siape):
            $this->set('siape', $siape);
        endif;

        if ($email):
            $this->set('email', $email);
        endif;

        /* Verifico se já está cadastrado */
        if ($siape) {
            $professorcadastrado = $this->Professores->find()
                    ->where(['siape' => $siape])
                    ->first();

            if ($professorcadastrado):
                $this->Flash->error(__('Professor já cadastrado'));
                return $this->redirect(['view' => $professorcadastrado->id]);
            endif;
        }

        $professor = $this->Professores->newEmptyEntity();

        if ($this->request->is('post')) {

            /** Busca se já está cadastrado como user */
            $siape = $this->request->getData('siape');
            $usercadastrado = $this->Professores->Users->find()
                    ->where(['categoria_id' => 3, 'registro' => $siape])
                    ->first();
            if (empty($usercadastrado)):
                $this->Flash->error(__('Professor(a) não cadastrado(a) como usuário(a)'));
                return $this->redirect('/users/add');
            endif;

            $professorresultado = $this->Professores->patchEntity($professor, $this->request->getData());
            if ($this->Professores->save($professorresultado)) {
                $this->Flash->success(__('Registro do(a) professor(a) inserido.'));

                /**
                 * Verifico se está preenchido o campo professor_id na tabela Users.
                 * Primeiro busco o usuário.
                 */
                $userprofessor = $this->Professores->Users->find()
                        ->where(['professor_id' => $professorresultado->id])
                        ->first();

                /**
                 * Se a busca retorna vazia então atualizo a tabela Users com o valor do professor_id.
                 */
                if (empty($userprofessor)) {

                    $userestagio = $this->Professores->Users->find()
                            ->where(['categoria_id' => 3, 'registro' => $professorresultado->siape])
                            ->first();
                    $userdata = $userestagio->toArray();
                    /** Carrego o valor do campo professor_id */
                    $userdata['professor_id'] = $professorresultado->id;
                    $userestagiostabela = $this->fetchTable('Users');
                    $user_entity = $userestagiostabela->get($userestagio->id);
                    /** Atualiza */
                    $userestagioresultado = $this->Professores->Users->patchEntity($user_entity, $userdata);
                    // pr($userestagioresultado);
                    if ($this->Professores->Users->save($userestagioresultado)) {
                        $this->Flash->success(__('Usuário atualizado com o id do professor'));
                        return $this->redirect(['action' => 'view', $professorresultado->id]);
                    } else {
                        $this->Flash->erro(__('Não foi possível atualizar a tabela Users com o id do professor'));
                        // debug($users->getErrors());
                        return $this->redirect(['controller' => 'Users', 'action' => 'logout']);
                    }
                }
                return $this->redirect(['action' => 'view', $professorresultado->id]);
            }
            $this->Flash->error(__('Registro do(a) professor(a) não inserido. Tente novamente.'));
            return $this->redirect(['action' => 'add', '?' => ['siape' => $siape, 'email' => $email]]);
        }
        $this->set(compact('professor'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Professor id.
     * @return \Cake\Http\Response|null|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null) {

        $professor = $this->Professores->get($id, [
            'contain' => [],
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $professor = $this->Professores->patchEntity($professor, $this->request->getData());
            if ($this->Professores->save($professor)) {
                $this->Flash->success(__('Registro do(a) professor(a) atualizado.'));

                return $this->redirect(['action' => 'view', $id]);
            }
            $this->Flash->error(__('Registro do(a) professor(a) no foi atualizado. Tente novamente.'));
        }
        $this->set(compact('professor'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Professor id.
     * @return \Cake\Http\Response|null|void Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null) {

        $this->request->allowMethod(['post', 'delete']);
        $professor = $this->Professores->get($id, [
            'contain' => ['Estagiarios']
        ]);
        if (sizeof($professor->estagiarios) > 0) {
            $this->Flash->error(__('Professor(a) tem estagiários associados'));
            return $this->redirect(['controller' => 'Professores', 'action' => 'view', $id]);
        }
        if ($this->Professores->delete($professor)) {
            $this->Flash->success(__('Registro professor(a) excluído.'));
        } else {
            $this->Flash->error(__('Registro professor(a) não foi excluído. Tente novamente.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
