<?php
/**
 * Created by PhpStorm.
 * User: Timothy
 * Date: 08/08/2018
 * Time: 22:43
 */

namespace Tools4Schools\Graph\Fields;


class Avatar extends Field
{

    public function thumbnail(Closure $closure)
    {
        return $this;
    }

    public function exceptOnForums()
    {
        return $this;
    }
}