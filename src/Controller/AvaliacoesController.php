<?php

declare(strict_types=1);

namespace App\Controller;

/**
 * Avaliacoes Controller
 *
 * @property \App\Model\Table\AvaliacoesTable $Avaliacoes
 * @method \App\Model\Entity\Avaliaco[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class AvaliacoesController extends AppController {

    /**
     * Index method. Mostra os estágios de um estudante estagiario.
     *
     * @return \Cake\Http\Response|null|void Renders view
     */
    public function index($id = NULL) {

        $estagiario_id = $this->getRequest()->getQuery('estagiario_id');
        // pr($estagiario_id);
        // die();
        if ($estagiario_id) {
            $registro = $this->Avaliacoes->Estagiarios->find()
                    ->where(['Estagiarios.id' => $estagiario_id])
                    ->first();
            // pr($registro);
            // die();
            $estagiariostabela = $this->fetchTable('Estagiarios');
            $estagiarios = $estagiariostabela->find()
                    ->contain(['Estudantes', 'Instituicaoestagios', 'Supervisores', 'Avaliacoes'])
                    ->where(['Estagiarios.registro' => $registro->registro])
                    ->all();
            // pr($estagiarios);
            // die();
            $this->set('id', $id);
            $this->set('estagiario', $estagiarios);
        } else {
            $this->Flash->error(__('Selecionar estagiário, período e nível de estágio a ser avaliado'));
            if ($this->getRequest()->getSession()->read('registro')) {
                return $this->redirect('/estudantes/view?registro=' . $this->getRequest()->getSession()->read('registro'));
            } else {
                return $this->redirect('/estudantes/index');
            }
        }
    }

    /**
     * Supervisoravaliacao method
     *
     * @return \Cake\Http\Response|null|void Renders view
     */
    public function supervisoravaliacao($id = NULL) {

        /* O submenu_navegacao envia o cress */
        $cress = $this->getRequest()->getQuery('cress');
        if (is_null($cress)) {
            $this->Flash->error(__('Selecionar estagiário, período e nível de estágio a ser avaliado'));
            return $this->redirect('/estudantes/view?registro=' . $this->getRequest()->getSession()->read('registro'));
        } else {
            $estagiarioquery = $this->Avaliacoes->Estagiarios->find()
                    ->contain(['Supervisores', 'Estudantes', 'Docentes', 'Folhadeatividades'])
                    ->where(['Supervisores.cress' => $cress])
                    ->order(['periodo' => 'desc']);
            $estagiario = $estagiarioquery->all();
            // pr($estagiario);
            // die();
            $this->set('estagiario', $estagiario);
        }
    }

    /**
     * View method
     *
     * @param string|null $id Avaliaco id.
     * @return \Cake\Http\Response|null|void Renders view
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null) {

        /* Esta incompleto porque somente o aluno pode ver. Tem que deixar para o supervisor e o professor */
        if ($this->getRequest()->getSession()->read('id_categoria') == 2) {

            $registro = $this->getRequest()->getQuery('registro');
            // pr($registro);
            // die();
            if ($registro) {
                $estagiario = $this->Avaliacoes->Estagiarios->find()
                        ->where(['Estagiarios.registro' => $registro])
                        ->first();
            } else {
                $this->Flash->error(__('Precisa do número de registro'));
                return $this->redirect(['controller' => 'Estudante', 'action' => 'index']);
            }
            // pr($estagiario['id']);
            // die();
            $avaliacao = $this->Avaliacoes->find()
                    ->where(['Avaliacoes.estagiario_id' => $estagiario['id']])
                    ->first();
            // pr($avaliacao);
            // die();

            if ($avaliacao) {
                $this->set(compact('avaliacao'));
            } else {
                /** Somente supervisor e administrador (?) podem avaliar. Portanto, redireciona para ver o estágio do estágiario */
                $this->Flash->error(__('Estudante sem avaliaçao'));
                return $this->redirect(['controller' => 'Estagiarios', 'action' => 'view', $estagiario->id]);
            }
        }
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null|void Redirects on successful add, renders view otherwise.
     */
    public function add($id = NULL) {

        if (is_null($id)) {
            $this->Flash->error(__('Selecione um nível e período de estágio do estudante'));
            return $this->redirect('/Estudantes/view?registro=' . $this->getRequest()->getSession()->read('registro'));
        } else {
            $avaliacaoquery = $this->Avaliacoes->find()->where(['estagiario_id' => $id]);
            // pr($avaliacaoquery);
            $avaliacaoverifica = $avaliacaoquery->first();
            // pr($avaliacaoverifica);
            if (isset($avaliacaoverifica) && !is_null($avaliacaoverifica)) {
                $this->Flash->error(__('Estagiário já foi avaliado'));
                return $this->redirect('/avaliacoes/view/' . $avaliacaoverifica->id);
            }
            // die();
        }

        // pr($this->request->getData());
        // die();
        $avaliacao = $this->Avaliacoes->newEmptyEntity();
        if ($this->request->is('post')) {
            $avaliacao = $this->Avaliacoes->patchEntity($avaliacao, $this->request->getData());
            // pr($avaliacao);
            // die();
            if ($this->Avaliacoes->save($avaliacao)) {
                $this->Flash->success(__('Avaliação registrada.'));

                return $this->redirect(['controller' => 'avaliacoes', 'action' => 'index', $this->getRequest()->getData('estagiario_id')]);
            }
            $this->Flash->error(__('Avaliaçãoo no foi registrada. Tente novamente.'));
        }
        $estagiarioquery = $this->Avaliacoes->Estagiarios->find()
                ->contain(['Estudantes'])
                ->where(['Estagiarios.id' => $id]);
        $estagiario = $estagiarioquery->first();
        // pr($avaliacao);
        // pr($estagiario);
        $this->set(compact('avaliacao', 'estagiario'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Avaliaco id.
     * @return \Cake\Http\Response|null|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null) {
        $avaliacao = $this->Avaliacoes->get($id, [
            'contain' => ['Estagiarios' => 'Estudantes'],
        ]);
        // pr($avaliacao->estagiario);
        $estagiario = $avaliacao->estagiario;
        // die();
        if ($this->request->is(['patch', 'post', 'put'])) {
            $avaliacao = $this->Avaliacoes->patchEntity($avaliacao, $this->request->getData());
            if ($this->Avaliacoes->save($avaliacao)) {
                $this->Flash->success(__('The avaliacao has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The avaliacao could not be saved. Please, try again.'));
        }
        // $estagiarios = $this->Avaliacoes->Estagiarios->find('list', ['limit' => 200]);
        $this->set(compact('avaliacao', 'estagiario'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Avaliaco id.
     * @return \Cake\Http\Response|null|void Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null) {
        $this->request->allowMethod(['post', 'delete']);
        $avaliacao = $this->Avaliacoes->get($id);
        if ($this->Avaliacoes->delete($avaliacao)) {
            $this->Flash->success(__('The avaliacao has been deleted.'));
        } else {
            $this->Flash->error(__('The avaliacao could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }

    public function selecionaavaliacao($id = NULL) {

        /* No login foi capturado o id do estagiário */
        $id = $this->getRequest()->getSession()->read('estagiario_id');
        if (is_null($id)) {
            $this->Flash->error(__('Selecionar o estudante estagiário'));
            return $this->redirect('/estudantes/index');
        } else {
            $estagiariostabela = $this->fetchTable('Estagiarios');
            $estagiario = $estagiariostabela->find()
                    ->contain(['Estudantes', 'Supervisores', 'Instituicaoestagios'])
                    ->where(['Estagiarios.registro' => $this->getRequest()->getSession()->read('registro')])
                    ->all();
            //pr($estagiario);
            // die();
        }

        $this->set('estagiario', $estagiario);
    }

    public function imprimeavaliacaopdf($id = NULL) {

        /* No login foi capturado o id do estagiário */
        $this->layout = false;
        if (is_null($id)) {
            $this->Flash->error(__('Por favor selecionar a folha de avaliação do estágio do estudante'));
            return $this->redirect('/estudantes/view?registro=' . $this->getRequest()->getSession()->read('registro'));
        } else {
            $avaliacaoquery = $this->Avaliacoes->find()
                    ->contain(['Estagiarios' => ['Estudantes', 'Supervisores', 'Docentes', 'Instituicaoestagios']])
                    ->where(['Avaliacoes.id' => $id]);
        }
        $avaliacao = $avaliacaoquery->first();
        // pr($avaliacao);
        // die();

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
