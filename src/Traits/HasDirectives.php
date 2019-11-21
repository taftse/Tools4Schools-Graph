<?php


namespace Tools4Schools\Graph\Traits;


use Tools4Schools\Graph\Contracts\Directive;

trait HasDirectives
{
    protected $directives = [];

    /**
     * Add a directive to this type
     *
     * @param Directive $directive
     */
    public function addDirective(Directive $directive)
    {
        $this->directives[$directive->name()] = $directive;
    }

    public function hasDirective($directiveName)
    {
        return isset($this->directives[$directiveName]);
    }

    public function getDirective($directiveName):Directive
    {
        return $this->directives[$directiveName];
    }
}