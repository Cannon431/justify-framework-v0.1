<?php

namespace Core\Components\TemplateEngines;

/**
 * Interface TemplateEngineInterface
 *
 * @since 2.3.0
 * @package Justify\System\TemplateEngines
 */
interface TemplateEngineInterface
{
	public function render($view, array $params = []);
}
