<?php

namespace rrsystemBundle;

use Symfony\Component\HttpKernel\Bundle\Bundle;

class rrsystemBundle extends Bundle
{
    public function getParent(){
        
        return 'FOSUserBundle';
    }

}
