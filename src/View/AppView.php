<?php

declare(strict_types=1);

/**
 * CakePHP(tm) : Rapid Development Framework (https://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (https://cakefoundation.org)
 *
 * Licensed under The MIT License
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright Copyright (c) Cake Software Foundation, Inc. (https://cakefoundation.org)
 * @link      https://cakephp.org CakePHP(tm) Project
 * @since     3.0.0
 * @license   https://opensource.org/licenses/mit-license.php MIT License
 */

namespace App\View;

use Cake\Event\EventInterface;
use Cake\View\View;
use Parsedown;

/**
 * Application View
 *
 * Your application's default view class
 *
 * @link https://book.cakephp.org/5/en/views.html#the-app-view
 */
class AppView extends View
{
    /**
     * Initialization hook method.
     *
     * Use this method to add common initialization code like adding helpers.
     *
     * e.g. `$this->addHelper('Html');`
     *
     * @return void
     */
    public function initialize(): void
    {
    }

    /**
     * Hook method called before the view is rendered.
     *
     * @param \Cake\Event\EventInterface $event The event.
     * @return void
     */
    public function beforeRender(EventInterface $event): void
    {
        $identity = $this->getRequest()->getAttribute('identity');
        if ($identity) {
            $user = $identity->getOriginalData();
            $this->set('user', $user);
        }
    }

    /**
     * Converts Markdown text to HTML.
     *
     * @param string|null $text Markdown text to convert
     * @return string HTML output
     */
    public function markdown(?string $text): string
    {
        if (empty($text)) {
            return '';
        }
        $parsedown = new Parsedown();
        return $parsedown->text($text);
    }
}
