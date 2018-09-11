<?php

namespace Eshop\UserBundle;

use Symfony\Component\HttpKernel\Bundle\Bundle;

class EshopUserBundle extends Bundle
{
    public function getParent(){

        return 'FOSUserBundle';

    }
}
