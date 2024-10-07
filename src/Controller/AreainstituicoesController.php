<?php

declare(strict_types=1);

namespace App\Controller;

/**
 * Areainstituicoes Controller
 *
 * @property \App\Model\Table\AreainstituicoesTable $Areainstituicoes
 * @method \App\Model\Entity\Areainstituicao[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class AreainstituicoesController extends AppController {

    /**
     * Index method
     *
     * @return \Cake\Http\Response|null|void Renders view
     */
    public function index() {
        $areainstituicoes = $this->paginate($this->Areainstituicoes);

        $this->set(compact('areainstituicoes'));
    }

    /**
     * View method
     *
     * @param string|null $id Areainstituicao id.
     * @return \Cake\Http\Response|null|void Renders view
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null) {
        $areainstituicao = $this->Areainstituicoes->get($id, [
            'contain' => [],
        ]);

        if (!isset($areainstituicao)) {
            $this->Flash->error(__('Nao ha registros de area para esse numero!'));
            return $this->redirect(['action' => 'index']);
        }

        $this->set(compact('areainstituicao'));
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null|void Redirects on successful add, renders view otherwise.
     */
    public function add() {
        $areainstituicao = $this->Areainstituicoes->newEmptyEntity();
        if ($this->request->is('post')) {
            $areainstituicaoresultado = $this->Areainstituicoes->patchEntity($areainstituicao, $this->request->getData());
            if ($this->Areainstituicoes->save($areainstituicaoresultado)) {
                $this->Flash->success(__('Registro areainstituicao inserido.'));

                return $this->redirect(['action' => 'view', $areainstituicaoresultado->id]);
            }
            $this->Flash->error(__('Registro areainstituicao nao foi inserido. Tente novamente.'));
        }
        $this->set(compact('areainstituicao'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Areainstituicao id.
     * @return \Cake\Http\Response|null|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null) {
        $areainstituicao = $this->Areainstituicoes->get($id, [
            'contain' => [],
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $areainstituicaoresultado = $this->Areainstituicoes->patchEntity($areainstituicao, $this->request->getData());
            if ($this->Areainstituicoes->save($areainstituicaoresultado)) {
                $this->Flash->success(__('Registro areainstituicao atualizado.'));

                return $this->redirect(['action' => 'view', $areainstituicaoresultado->id]);
            }
            $this->Flash->error(__('Registro areainstituicao nao foi atualziado. Tente novamente.'));
        }
        $this->set(compact('areainstituicao'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Areainstituicao id.
     * @return \Cake\Http\Response|null|void Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null) {
        $this->request->allowMethod(['post', 'delete']);
        $areainstituicaoresultado = $this->Areainstituicoes->get($id);
        if ($this->Areainstituicoes->delete($areainstituicaoresultado)) {
            $this->Flash->success(__('Registro areainstituicao excluido.'));
        } else {
            $this->Flash->error(__('Registro areainstituicao nao foi excluido. Tente novamente.'));
            return $this->redirect(['action' => 'view', $id]);
        }

        return $this->redirect(['action' => 'index']);
    }
}
