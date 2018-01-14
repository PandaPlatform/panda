<?php

/*
 * This file is part of the Panda framework.
 *
 * (c) Ioannis Papikas <papikas.ioan@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace App\Controllers\Html\Layouts;

use App\Controllers\Html\AbstractPageViewController;
use Exception;
use InvalidArgumentException;

/**
 * Class PlainLayoutViewController
 * @package App\Controllers\Html\Layouts
 */
class PlainLayoutViewController extends AbstractPageViewController
{
    /**
     * @param string $title
     * @param string $viewName
     * @param string $id
     * @param string $class
     *
     * @return $this
     * @throws Exception
     * @throws InvalidArgumentException
     */
    public function build($title = '', $viewName = '', $id = '', $class = '')
    {
        // Build core view
        parent::build($title, 'layout/plain', $id, $class);

        // Load extra view
        if (!empty($viewName)) {
            $viewHtml = $this->getViewHtml($viewName);
            $pageOuterViewContainer = $this->getViewContainer()->select('.container')->item(0);
            $this->getViewContainer()->getHTMLHandler()->innerHTML($pageOuterViewContainer, $viewHtml);
        }

        return $this;
    }
}
