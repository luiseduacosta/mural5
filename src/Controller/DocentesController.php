<?php

declare(strict_types=1);

namespace App\Controller;

/**
 * Docentes Controller
 *
 * @property \App\Model\Table\DocentesTable $Docentes
 * @method \App\Model\Entity\Docente[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class DocentesController extends AppController {

    /**
     * Index method
     *
     * @return \Cake\Http\Response|null|void Renders view
     */
    public function index() {
        $docentes = $this->paginate($this->Docentes);

        $this->set(compact('docentes'));
    }

    /**
     * View method
     *
     * @param string|null $id Docente id.
     * @return \Cake\Http\Response|null|void Renders view
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null) {

        if (is_null($id)) {
            $siape = $this->getRequest()->getQuery('siape');
            if (isset($siape)):
                $idquery = $this->Docentes->find()->where(['siape' => $siape]);
                $id = $idquery->first();
                $id = $id->id;
            endif;
        }
        /** Têm professores com muitos estagiários: aumentar a memória */
        ini_set('memory_limit', '2048M');
        $docente = $this->Docentes->get($id, [
            'contain' => ['Estagiarios' => ['sort' => ['Estagiarios.periodo DESC'], 'Estudantes', 'Instituicaoestagios', 'Supervisores', 'Docentes']]
                ]
        );
        $this->set(compact('docente'));
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
            $docentecadastrado = $this->Docentes->find()
                    ->where(['siape' => $siape])
                    ->first();

            if ($docentecadastrado):
                $this->Flash->error(__('Docente já cadastrado'));
                return $this->redirect(['view' => $docentecadastrado->id]);
            endif;
        }

        $docente = $this->Docentes->newEmptyEntity();

        if ($this->request->is('post')) {

            /** Busca se já está cadastrado como user */
            $siape = $this->request->getData('siape');
            $usercadastrado = $this->Docentes->Userestagios->find()
                    ->where(['categoria_id' => 3, 'registro' => $siape])
                    ->first();
            if (empty($usercadastrado)):
                $this->Flash->error(__('Professor(a) não cadastrado(a) como usuário(a)'));
                return $this->redirect('/userestagios/add');
            endif;

            $docenteresultado = $this->Docentes->patchEntity($docente, $this->request->getData());
            if ($this->Docentes->save($docenteresultado)) {
                $this->Flash->success(__('Registro do(a) professor(a) inserido.'));

                /**
                 * Verifico se está preenchido o campo professor_id na tabela Users.
                 * Primeiro busco o usuário.
                 */
                $userdocente = $this->Docentes->Userestagios->find()
                        ->where(['professor_id' => $docenteresultado->id])
                        ->first();

                /**
                 * Se a busca retorna vazia então atualizo a tabela Users com o valor do professor_id.
                 */
                if (empty($userdocente)) {

                    $userestagio = $this->Docentes->Userestagios->find()
                            ->where(['categoria_id' => 3, 'registro' => $docenteresultado->siape])
                            ->first();
                    $userdata = $userestagio->toArray();
                    /** Carrego o valor do campo professor_id */
                    $userdata['professor_id'] = $docenteresultado->id;
                    $userestagiostabela = $this->fetchTable('Userestagios');
                    $user_entity = $userestagiostabela->get($userestagio->id);
                    /** Atualiza */
                    $userestagioresultado = $this->Docentes->Userestagios->patchEntity($user_entity, $userdata);
                    // pr($userestagioresultado);
                    if ($this->Docentes->Userestagios->save($userestagioresultado)) {
                        $this->Flash->success(__('Usuário atualizado com o id do professor'));
                        return $this->redirect(['action' => 'view', $docenteresultado->id]);
                    } else {
                        $this->Flash->erro(__('Não foi possível atualizar a tabela Users com o id do professor'));
                        // debug($userestagios->getErrors());
                        return $this->redirect(['controller' => 'Userestagios', 'action' => 'logout']);
                    }
                }
                return $this->redirect(['action' => 'view', $docenteresultado->id]);
            }
            $this->Flash->error(__('Registro do(a) professor(a) não inserido. Tente novamente.'));
            return $this->redirect(['action' => 'add', '?' => ['siape' => $siape, 'email' => $email]]);
        }
        $this->set(compact('docente'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Docente id.
     * @return \Cake\Http\Response|null|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null) {

        $docente = $this->Docentes->get($id, [
            'contain' => [],
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $docente = $this->Docentes->patchEntity($docente, $this->request->getData());
            if ($this->Docentes->save($docente)) {
                $this->Flash->success(__('Registro do(a) professor(a) atualizado.'));

                return $this->redirect(['action' => 'view', $id]);
            }
            $this->Flash->error(__('Registro do(a) professor(a) no foi atualizado. Tente novamente.'));
        }
        $this->set(compact('docente'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Docente id.
     * @return \Cake\Http\Response|null|void Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null) {

        $this->request->allowMethod(['post', 'delete']);
        $docente = $this->Docentes->get($id, [
            'contain' => ['Estagiarios']
        ]);
        if (sizeof($docente->estagiarios) > 0) {
            $this->Flash->error(__('Professor(a) tem estagiários associados'));
            return $this->redirect(['controller' => 'Docentes', 'action' => 'view', $id]);
        }
        if ($this->Docentes->delete($docente)) {
            $this->Flash->success(__('Registro professor(a) excluído.'));
        } else {
            $this->Flash->error(__('Registro professor(a) não foi excluído. Tente novamente.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
