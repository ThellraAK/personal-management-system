<?php

namespace App\Controller\Modules\Payments;

use App\Controller\Core\Application;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class MyPaymentsOwedController extends AbstractController
{

    /**
     * @var Application $app
     */
    private $app;

    public function __construct(Application $app) {

        $this->app = $app;
    }

}
