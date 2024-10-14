<?php

declare(strict_types=1);

namespace App\Controller;

/**
 * Areas Controller
 *
 * @property \App\Model\Table\AreasTable $Areas
 * @method \App\Model\Entity\Area[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class AreasController extends AppController {

    /**
     * Index method
     *
     * @return \Cake\Http\Response|null|void Renders view
     */
    public function index() {
        $areas = $this->paginate($this->Areas);

        $this->set(compact('areas'));
    }

    /**
     * View method
     *
     * @param string|null $id Area id.
     * @return \Cake\Http\Response|null|void Renders view
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null) {
        $area = $this->Areas->get($id, [
            'contain' => [],
        ]);

        if (!isset($area)) {
            $this->Flash->error(__('Nao ha registros de area para esse numero!'));
            return $this->redirect(['action' => 'index']);
        }

        $this->set(compact('area'));
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null|void Redirects on successful add, renders view otherwise.
     */
    public function add() {
        $area = $this->Areas->newEmptyEntity();
        if ($this->request->is('post')) {
            $arearesultado = $this->Areas->patchEntity($area, $this->request->getData());
            if ($this->Areas->save($arearesultado)) {
                $this->Flash->success(__('Registro area inserido.'));

                return $this->redirect(['action' => 'view', $arearesultado->id]);
            }
            $this->Flash->error(__('Registro area nao foi inserido. Tente novamente.'));
        }
        $this->set(compact('area'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Area id.
     * @return \Cake\Http\Response|null|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null) {
        $area = $this->Areas->get($id, [
            'contain' => [],
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $arearesultado = $this->Areas->patchEntity($area, $this->request->getData());
            if ($this->Areas->save($arearesultado)) {
                $this->Flash->success(__('Registro area atualizado.'));

                return $this->redirect(['action' => 'view', $arearesultado->id]);
            }
            $this->Flash->error(__('Registro area nao foi atualziado. Tente novamente.'));
        }
        $this->set(compact('area'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Area id.
     * @return \Cake\Http\Response|null|void Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null) {
        $this->request->allowMethod(['post', 'delete']);
        $arearesultado = $this->Areas->get($id);
        if ($this->Areas->delete($arearesultado)) {
            $this->Flash->success(__('Registro area excluido.'));
        } else {
            $this->Flash->error(__('Registro area nao foi excluido. Tente novamente.'));
            return $this->redirect(['action' => 'view', $id]);
        }

        return $this->redirect(['action' => 'index']);
    }
}
