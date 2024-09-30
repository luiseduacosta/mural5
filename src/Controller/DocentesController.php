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
 
        $docente = $this->Docentes->get($id, [
            'contain' => ['Estagiarios' => ['Estudantes', 'Supervisores', 'Instituicaoestagios']]
        ]);
        
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

        $docente = $this->Docentes->newEmptyEntity();
        if ($siape):
            $docente->siape = $siape;
        endif;
        if ($email):
            $docente->email = $email;
        endif;

        if ($this->request->is('post')) {
            $docente = $this->Docentes->patchEntity($docente, $this->request->getData());
            if ($this->Docentes->save($docente)) {
                $this->Flash->success(__('The docente has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The docente could not be saved. Please, try again.'));
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
                $this->Flash->success(__('Registro do docente atualizado.'));

                return $this->redirect(['action' => 'view', $id]);
            }
            $this->Flash->error(__('Registro do docente no foi atualizado. Tente novamente.'));
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
        $docente = $this->Docentes->get($id);
        if ($this->Docentes->delete($docente)) {
            $this->Flash->success(__('The docente has been deleted.'));
        } else {
            $this->Flash->error(__('The docente could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }

}
