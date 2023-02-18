<?php

namespace Wkukielczak\PhpUtils\Doctrine;

use Doctrine\ORM\Query\AST\ASTException;
use Doctrine\ORM\Query\AST\Functions\FunctionNode;
use Doctrine\ORM\Query\AST\Node;
use Doctrine\ORM\Query\Parser;
use Doctrine\ORM\Query\QueryException;
use Doctrine\ORM\Query\SqlWalker;
use Doctrine\ORM\Query\Lexer;

/**
 * MySQL Arc COSine function
 *
 * ACOS(float)
 */
class Acos extends FunctionNode
{

    public ?Node $valueExpression = null;

    /**
     * @param SqlWalker $sqlWalker
     * @return string
     * @throws ASTException
     */
    public function getSql(SqlWalker $sqlWalker): string
    {
        return 'ACOS(' . $this->valueExpression->dispatch($sqlWalker) . ')';
    }

    /**
     * @param Parser $parser
     * @return void
     * @throws QueryException
     */
    public function parse(Parser $parser): void
    {
        $parser->match(Lexer::T_IDENTIFIER);
        $parser->match(Lexer::T_OPEN_PARENTHESIS);
        $this->valueExpression = $parser->ScalarExpression();
        $parser->match(Lexer::T_CLOSE_PARENTHESIS);
    }
}
