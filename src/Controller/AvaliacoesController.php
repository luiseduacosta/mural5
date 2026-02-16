<?php

declare(strict_types=1);

namespace App\Controller;

use App\Model\Table\AvaliacoesTable;
use Cake\Datasource\Exception\RecordNotFoundException;
use Cake\Datasource\ResultSetInterface;
use Cake\Http\Response;
use Cake\I18n;
    
/**
 * Avaliacoes Controller
 *
 * @property AvaliacoesTable $Avaliacoes
 * @method \App\Model\Entity\Avaliaco[]|ResultSetInterface paginate($object = null, array $settings = [])
 */
class AvaliacoesController extends AppController
{

    /**
     * Index method. Mostra os estágios de um aluno estagiario.
     *
     * @return Response|null|void Renders view
     */
    public function index($id = NULL)
    {

        /** Autorização */
        if (!$this->user->isAdmin() && !$this->user->isSupervisor() && !$this->user->isStudent()) {
            $this->Flash->error(__('Usuario nao autorizado.'));
            return $this->redirect(['controller' => 'Muralestagios', 'action' => 'index']);
        }

        $estagiario_id = $this->getRequest()->getQuery('estagiario_id');
        if ($estagiario_id) {
            $estagiario = $this->Avaliacoes->Estagiarios->find('all')
                ->contain(['Alunos', 'Instituicoes', 'Supervisores', 'Avaliacoes'])
                ->where(['Estagiarios.id' => $estagiario_id]);

            $this->set('estagiario_id', $estagiario_id);
            $this->set('estagiario', $this->paginate($estagiario));
        } else {
            $this->Flash->error(__('Selecionar estagiário.'));
            return $this->redirect('/alunos/index');
        }
    }

    /**
     * Supervisoravaliacao method
     *
     * @return Response|null|void Renders view
     */
    public function supervisoravaliacao($id = NULL)
    {

        /** Autorização */
        if (!$this->user->isAdmin() && !$this->user->isSupervisor() && !$this->user->isStudent()) {
            $this->Flash->error(__('Usuario nao autorizado.'));
            return $this->redirect(['controller' => 'Muralestagios', 'action' => 'index']);
        }

        /* O submenu_navegacao envia o cress */
        $cress = $this->getRequest()->getQuery('cress');
        if ($cress == null) {
            $this->Flash->error(__('Selecionar estagiário, período e nível de estágio a ser avaliado'));
            return $this->redirect(['controller' => 'alunos', 'action' => 'index']);
        } else {
            $estagiario = $this->Avaliacoes->Estagiarios->find()
                ->contain(['Supervisores', 'Alunos', 'Professores', 'Folhadeatividades'])
                ->where(['Supervisores.cress' => $cress])
                ->order(['periodo' => 'desc'])
                ->all();
            $this->set('estagiario', $estagiario);
        }
    }

    /**
     * View method
     *
     * @param string|null $id Avaliaco id.
     * @param mixed $estagiario_id
     * @return Response|null|void Renders view
     * @throws RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {

        /** Autorização */
        if (!$this->user->isAdmin() && !$this->user->isSupervisor() && !$this->user->isStudent()) {
            $this->Flash->error(__('Usuario nao autorizado.'));
            return $this->redirect(['controller' => 'Muralestagios', 'action' => 'index']);
        }

        $estagiario_id = NULL;
        if ($id) {
            $avaliacao = $this->Avaliacoes->find()
                ->contain(['Estagiarios' => ['Alunos', 'Supervisores', 'Instituicoes']])
                ->where(['Avaliacoes.id' => $id])
                ->first();
            if ($avaliacao) {
                $estagiario_id = $avaliacao->estagiario_id;
            }
        } else {
            $estagiario_id = $this->getRequest()->getQuery('estagiario_id');
            $avaliacao = $this->Avaliacoes->find()
                ->contain(['Estagiarios' => ['Alunos', 'Supervisores', 'Instituicoes']])
                ->where(['Avaliacoes.estagiario_id' => $estagiario_id])
                ->first();
        }

        if ($avaliacao) {
            $this->set(compact('avaliacao'));
        } else {
            /** Somente supervisor e administrador (?) podem avaliar. Portanto, redireciona para ver o estágio do estágiario */
            $this->Flash->error(__('Estagiário sem avaliaçao'));
            return $this->redirect(['controller' => 'Estagiarios', 'action' => 'view', $estagiario_id]);
        }
    }

    /**
     * Add method
     * @param mixed $estagiario_id
     *
     * @return Response|null|void Redirects on successful add, renders view otherwise.
     */
    public function add($id = NULL)
    {

        /** Autorização */
        if (!$this->user->isAdmin() && !$this->user->isSupervisor()) {
            $this->Flash->error(__('Usuario nao autorizado.'));
            return $this->redirect(['controller' => 'Muralestagios', 'action' => 'index']);
        }

        $estagiario_id = $this->getRequest()->getQuery('estagiario_id');
        if ($estagiario_id) {
            $avaliacaoexiste = $this->Avaliacoes->find()
                ->where(['estagiario_id' => $estagiario_id])
                ->first();
        } elseif ($id) {
            $avaliacaoexiste = $this->Avaliacoes->find()
                ->where(['id' => $id])
                ->first();
            if ($avaliacaoexiste) {
                $estagiario_id = $avaliacaoexiste->estagiario_id;
            }
        } else {
            $this->Flash->error(__('Falta o estagiario_id'));
            return $this->redirect(['controller' => 'Alunos', 'action' => 'index']);
        }

        if ($avaliacaoexiste) {
            $this->Flash->error(__('Estagiário já foi avaliado'));
            return $this->redirect(['controller' => 'avaliacoes', 'action' => 'view', $avaliacaoexiste->id]);
        }

        $avaliacao = $this->Avaliacoes->newEmptyEntity();

        if ($this->request->is('post')) {
            $avaliacaoresposta = $this->Avaliacoes->patchEntity($avaliacao, $this->request->getData());
            // pr($avaliacaoresposta);
            if ($this->Avaliacoes->save($avaliacaoresposta)) {
                $this->Flash->success(__('Avaliação registrada.'));
                return $this->redirect(['controller' => 'avaliacoes', 'action' => 'view', $avaliacaoresposta->id]);
            }
            $this->Flash->error(__('Avaliaçãoo no foi registrada. Tente novamente.'));
            // debug($avaliacaoresposta);
            return $this->redirect(['action' => 'add', $estagiario_id]);
        }

        $estagiario = $this->Avaliacoes->Estagiarios->find()
            ->contain(['Alunos'])
            ->where(['Estagiarios.id' => $estagiario_id])
            ->first();
        // pr($estagiario);
        $this->set(compact('avaliacao', 'estagiario'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Avaliaco id.
     * @return Response|null|void Redirects on successful edit, renders view otherwise.
     * @throws RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {

        /** Autorização */
        if (!$this->user->isAdmin() && !$this->user->isSupervisor()) {
            $this->Flash->error(__('Usuario nao autorizado.'));
            return $this->redirect(['controller' => 'Muralestagios', 'action' => 'index']);
        }

        $avaliacao = $this->Avaliacoes->get($id, [
            'contain' => ['Estagiarios' => ['Alunos']],
        ]);
        // pr($avaliacao->estagiario);
        $estagiario = $avaliacao->estagiario;
        // die();
        if ($this->request->is(['patch', 'post', 'put'])) {
            $avaliacao = $this->Avaliacoes->patchEntity($avaliacao, $this->request->getData());
            if ($this->Avaliacoes->save($avaliacao)) {
                $this->Flash->success(__('Avaliacao atualizada.'));
                return $this->redirect(['action' => 'view', $avaliacao->id]);
            }
            $this->Flash->error(__('Avaliaçao não foi atualizada. Tente novamente.'));
            return $this->redirect(['action' => 'view', $id]);
        }
        $this->set(compact('avaliacao', 'estagiario'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Avaliaco id.
     * @return Response|null|void Redirects to index.
     * @throws RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {

        /** Autorização */
        if (!$this->user->isAdmin() && !$this->user->isSupervisor()) {
            $this->Flash->error(__('Usuario nao autorizado.'));
            return $this->redirect(['controller' => 'Muralestagios', 'action' => 'index']);
        }

        $this->request->allowMethod(['post', 'delete']);
        $avaliacao = $this->Avaliacoes->get($id);
        if ($this->Avaliacoes->delete($avaliacao)) {
            $this->Flash->success(__('Avaliacao excluida.'));
        } else {
            $this->Flash->error(__('Avaliacao nao foi excluida. Tente novamente.'));
        }

        return $this->redirect(['action' => 'index']);
    }

    /**
     * Seleciona avaliacao method
     *
     * @param string|null $id Avaliaco id.
     * @return Response|null|void Renders view
     */
    public function selecionaavaliacao($id = NULL)
    {

        /** Autorização */
        if (!$this->user->isAdmin() && !$this->user->isSupervisor() && !$this->user->isStudent()) {
            $this->Flash->error(__('Usuario nao autorizado.'));
            return $this->redirect(['controller' => 'Muralestagios', 'action' => 'index']);
        }

        /* No login foi capturado o id do estagiário */
        $estagiario_id = $this->getRequest()->getSession()->read('estagiario_id');
        if ($estagiario_id == null) {
            $this->Flash->error(__('Selecionar o aluno estagiário'));
            return $this->redirect(['controller' => 'alunos', 'action' => 'index']);
        } else {
            $estagiariostabela = $this->fetchTable('Estagiarios');
            $estagiario = $estagiariostabela->find()
                ->contain(['Alunos', 'Supervisores', 'Instituicoes'])
                ->where(['Estagiarios.registro' => $estagiario_id])
                ->all();
        }

        $this->set('estagiario', $this->paginate($estagiario));
    }

    /**
     * Imprime avaliacao pdf method
     *
     * @param string|null $id Avaliaco id.
     * @return Response|null|void Renders view
     */
    public function imprimeavaliacaopdf($id = NULL)
    {

        /** Autorização */
        if (!$this->user->isAdmin() && !$this->user->isSupervisor() && !$this->user->isStudent()) {
            $this->Flash->error(__('Usuario nao autorizado.'));
            return $this->redirect(['controller' => 'Muralestagios', 'action' => 'index']);
        }

        /* No login foi capturado o id do estagiário */
        $this->layout = false;
        if ($id == null) {
            $this->Flash->error(__('Por favor selecionar a folha de avaliação do estágio do aluno'));
            return $this->redirect(['controller' => 'alunos', 'action' => 'view', '?' => ['id' => $this->user->aluno_id]]);
        } else {
            $avaliacaoquery = $this->Avaliacoes->find()
                ->contain(['Estagiarios' => ['Alunos', 'Supervisores', 'Professores', 'Instituicoes']])
                ->where(['Avaliacoes.id' => $id]);
        }
        $avaliacao = $avaliacaoquery->first();

        $this->viewBuilder()->enableAutoLayout(false);
        $this->viewBuilder()->setClassName('CakePdf.Pdf');
        $this->viewBuilder()->setOption(
            'pdfConfig',
            [
                'orientation' => 'portrait',
                'download' => true, // This can be omitted if "filename" is specified.
                'filename' => 'avaliacao_discente_' . $id . '.pdf' //// This can be omitted if you want file name based on URL.
            ]
        );
        $this->set('avaliacao', $avaliacao);
    }
}
