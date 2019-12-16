<?php
/**
 * Created by PhpStorm.
 * User: Timothy
 * Date: 09/10/2019
 * Time: 19:18
 */

namespace Tools4Schools\Graph\Contracts\Request;


use Tools4Schools\Graph\Language\AST\SelectionSet;

interface ExecutableDefinition
{
    public function name(): string;

    public function getSelectionSet(): SelectionSet;
}