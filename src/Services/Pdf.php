<?php

namespace App\Services;

use Dompdf\Dompdf;
use Dompdf\Options;

/**
 * Class Pdf
 * @package App\Services
 * @author Guillermo Quinteros A. <gu.quinteros@gmail.com>
 */
class Pdf
{
    /**
     * @var string
     */
    public $view;

    /**
     * @var array|null
     */
    private $options;

    public function make()
    {
        $pdfOptions = new Options();
        $pdfOptions->set('defaultFont', 'Arial');

        $dompdf = new Dompdf($);
    }

    /**
     * @param string $view
     * @return string
     */
    public function setView(string $view)
    {
        $this->view = $view;

        return $this;
    }
}