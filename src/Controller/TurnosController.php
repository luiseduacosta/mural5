<?php
declare(strict_types=1);

namespace App\Controller;

use Cake\Event\EventInterface;

/**
 * Turnos Controller
 *
 * @property \App\Model\Table\TurnosTable $Turnos
 */
class TurnosController extends AppController
{
    public function index()
    {
        $this->Authorization->authorize($this->Turnos);

        $query = $this->Turnos->find();
        $turnos = $this->paginate($query);

        $this->set(compact('turnos'));
    }

    public function view($id = null)
    {
        $turno = $this->Turnos->get($id);
        $this->Authorization->authorize($turno);

        $this->set(compact('turno'));
    }

    public function add()
    {
        $turno = $this->Turnos->newEmptyEntity();
        $this->Authorization->authorize($turno);

        if ($this->request->is('post')) {
            $turno = $this->Turnos->patchEntity($turno, $this->request->getData());
            if ($this->Turnos->save($turno)) {
                $this->Flash->success(__('O turno foi salvo.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('O turno não pôde ser salvo. Tente novamente.'));
        }
        $this->set(compact('turno'));
    }

    public function edit($id = null)
    {
        $turno = $this->Turnos->get($id);
        $this->Authorization->authorize($turno);

        if ($this->request->is(['patch', 'post', 'put'])) {
            $turno = $this->Turnos->patchEntity($turno, $this->request->getData());
            if ($this->Turnos->save($turno)) {
                $this->Flash->success(__('O turno foi salvo.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('O turno não pôde ser salvo. Tente novamente.'));
        }
        $this->set(compact('turno'));
    }

    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $turno = $this->Turnos->get($id);
        $this->Authorization->authorize($turno);

        if ($this->Turnos->delete($turno)) {
            $this->Flash->success(__('O turno foi excluído.'));
        } else {
            $this->Flash->error(__('O turno não pôde ser excluído. Tente novamente.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
