<?php

namespace App\Controllers;

class BaseController
{
    /**
     * Render a view.
     *
     * @param string $view
     *   The view to render.
     * @param array $data
     *   The data to pass to the view.
     *
     * @return void
     *
     * @throws \Exception
     *   If the view or layout is not found.
     */
    protected function render(string $view, array $data = []): void
    {
        extract($data);

        $template = dirname(__DIR__) . '/Views/pages/' . $view . '.php';
        if (!file_exists($template)) {
            throw new \Exception("View '{$view}' not found");
        }

        ob_start();
        include $template;
        $content = ob_get_clean();

        $layout = dirname(__DIR__) . '/Views/layout/layout.php';
        if (!file_exists($layout)) {
            throw new \Exception("Layout not found");
        }

        include $layout;
    }

    /**
     * Render a JSON response.
     *
     * @param array $data
     *   The data to pass to the JSON response.
     *
     * @return void
     */
    protected function json(array $data): void
    {
        header('Content-Type: application/json');
        echo json_encode($data);
    }
}
