<?php


namespace Tools4Schools\Graph\Contracts\Schema;

use Tools4Schools\Graph\Contracts\Request;

interface RequestValidator
{
    public function __construct(Schema $schema);

    public function validate(Request $request): array;
}