<?php
declare(strict_types=1);

namespace App\Controller;

/**
 * Muralinscricoes Controller
 *
 * @property \App\Model\Table\MuralinscricoesTable $Muralinscricoes
 * @method \App\Model\Entity\Muralinscricao[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class MuralinscricoesController extends AppController
{
    /**
     * Index method
     *
     * @return \Cake\Http\Response|null|void Renders view
     */
    public function index()
    {
        //$this->paginate = [
        //    'contain' => ['Alunos', 'Muralestagios'],
        //];
        $muralinscricoes = $this->paginate($this->Muralinscricoes);

        $this->set(compact('muralinscricoes'));
    }

    /**
     * View method
     *
     * @param string|null $id Muralinscricao id.
     * @return \Cake\Http\Response|null|void Renders view
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $muralinscricao = $this->Muralinscricoes->get($id, [
            'contain' => ['Alunos', 'Muralestagios'],
        ]);

        $this->set(compact('muralinscricao'));
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $muralinscricao = $this->Muralinscricoes->newEmptyEntity();
        if ($this->request->is('post')) {
            $muralinscricao = $this->Muralinscricoes->patchEntity($muralinscricao, $this->request->getData());
            if ($this->Muralinscricoes->save($muralinscricao)) {
                $this->Flash->success(__('The muralinscricao has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The muralinscricao could not be saved. Please, try again.'));
        }
        $alunos = $this->Muralinscricoes->Alunos->find('list', ['limit' => 200]);
        $muralestagios = $this->Muralinscricoes->Muralestagios->find('list', ['limit' => 200]);
        $this->set(compact('muralinscricao', 'alunos', 'muralestagios'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Muralinscricao id.
     * @return \Cake\Http\Response|null|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $muralinscricao = $this->Muralinscricoes->get($id, [
            'contain' => [],
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $muralinscricao = $this->Muralinscricoes->patchEntity($muralinscricao, $this->request->getData());
            if ($this->Muralinscricoes->save($muralinscricao)) {
                $this->Flash->success(__('The muralinscricao has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The muralinscricao could not be saved. Please, try again.'));
        }
        $alunos = $this->Muralinscricoes->Alunos->find('list', ['limit' => 200]);
        $muralestagios = $this->Muralinscricoes->Muralestagios->find('list', ['limit' => 200]);
        $this->set(compact('muralinscricao', 'alunos', 'muralestagios'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Muralinscricao id.
     * @return \Cake\Http\Response|null|void Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $muralinscricao = $this->Muralinscricoes->get($id);
        if ($this->Muralinscricoes->delete($muralinscricao)) {
            $this->Flash->success(__('The muralinscricao has been deleted.'));
        } else {
            $this->Flash->error(__('The muralinscricao could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
    
    public function mural($id = null)
    {

        $muralinscricao = $this->Muralinscricoes->find('all');
        // pr($muralinscricao);
        foreach ($muralinscricao as $c_muralinscriacao) {
            // pr($c_muralinscriacao);
        }
        die();
    }
    
}
