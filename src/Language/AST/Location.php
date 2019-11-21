<?php


namespace Tools4Schools\Graph\Language\AST;


use Tools4Schools\Graph\Language\Token;
use Tools4Schools\Graph\Contracts\Request\Location as LocationContract;

class Location implements LocationContract
{
    /**
     * The character offset at which this Node begins.
     *
     * @var int
     */
    public $start;

    /**
     * The character offset at which this Node ends.
     *
     * @var int
     */
    public $end;

    /**
     * The Token at which this Node begins.
     *
     * @var Token
     */
    public $startToken;

    /**
     * The Token at which this Node ends.
     *
     * @var Token
     */
    public $endToken;

    /**
     * The Source document the AST represents.
     *
     * @var string|null
     */
    public $text;

    public function __construct(Token $startToken,Token $endToken,$text)
    {
        $this->startToken =$startToken;
        $this->endToken = $endToken;
        $this->text = $text;

        if (! $startToken || ! $endToken) {
            return;
        }

        $this->start = $startToken->position();
        $this->end = $endToken->position();
    }
}