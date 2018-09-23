<?php

namespace Core\System\TemplateEngines;

/**
 * Class PHP
 *
 * @since 2.3.0
 * @package Justify\System\TemplateEngines
 */
class PHP extends TemplateEngine implements TemplateEngineInterface
{
	public function render(string $view, array $params = []): string
	{
		extract($params);

		$viewPath = $this->createViewPath($view);

		ob_start();

		require_once $viewPath;

		$template = ob_get_clean();

		return $template;
	}
}
