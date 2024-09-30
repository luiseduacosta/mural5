<?php
declare(strict_types=1);

namespace App\Controller;

/**
 * Areaestagios Controller
 *
 * @property \App\Model\Table\AreaestagiosTable $Areaestagios
 * @method \App\Model\Entity\Areaestagio[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class AreaestagiosController extends AppController
{
    /**
     * Index method
     *
     * @return \Cake\Http\Response|null|void Renders view
     */
    public function index()
    {
        $areaestagios = $this->paginate($this->Areaestagios);

        $this->set(compact('areaestagios'));
    }

    /**
     * View method
     *
     * @param string|null $id Areaestagio id.
     * @return \Cake\Http\Response|null|void Renders view
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $areaestagio = $this->Areaestagios->get($id, [
            'contain' => ['Estagiarios' => ['Alunos', 'Instituicaoestagios', 'Supervisores', 'Professores', 'Areaestagios'], 'Muralestagios'],
        ]);

        $this->set(compact('areaestagio'));
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $areaestagio = $this->Areaestagios->newEmptyEntity();
        if ($this->request->is('post')) {
            $areaestagio = $this->Areaestagios->patchEntity($areaestagio, $this->request->getData());
            if ($this->Areaestagios->save($areaestagio)) {
                $this->Flash->success(__('The areaestagio has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The areaestagio could not be saved. Please, try again.'));
        }
        $this->set(compact('areaestagio'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Areaestagio id.
     * @return \Cake\Http\Response|null|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $areaestagio = $this->Areaestagios->get($id, [
            'contain' => [],
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $areaestagio = $this->Areaestagios->patchEntity($areaestagio, $this->request->getData());
            if ($this->Areaestagios->save($areaestagio)) {
                $this->Flash->success(__('The areaestagio has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The areaestagio could not be saved. Please, try again.'));
        }
        $this->set(compact('areaestagio'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Areaestagio id.
     * @return \Cake\Http\Response|null|void Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $areaestagio = $this->Areaestagios->get($id);
        if ($this->Areaestagios->delete($areaestagio)) {
            $this->Flash->success(__('The areaestagio has been deleted.'));
        } else {
            $this->Flash->error(__('The areaestagio could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
