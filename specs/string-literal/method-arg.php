<?php

declare(strict_types=1);

/*
 * This file is part of the humbug/php-scoper package.
 *
 * Copyright (c) 2017 Théo FIDRY <theo.fidry@gmail.com>,
 *                    Pádraic Brady <padraic.brady@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

use Humbug\PhpScoper\SpecFramework\Config\Meta;

return [
    'meta' => new Meta(
        title: 'String literal used as a method argument',
    ),

    'FQCN string argument' => <<<'PHP'
        <?php

        class Foo {
            function foo($x = 'Symfony\\Component\\Yaml\\Ya_1', $y = 'Foo') {}
        }

        (new X())->foo('Humbug\\Symfony\\Component\\Yaml\\Ya_1', $y = 'Foo');

        $x = new X();

        $x->foo()('Humbug\\Symfony\\Component\\Yaml\\Ya_1', $y = 'Foo');

        ----
        <?php

        namespace Humbug;

        class Foo
        {
            function foo($x = 'Humbug\Symfony\Component\Yaml\Ya_1', $y = 'Foo')
            {
            }
        }
        (new X())->foo('Humbug\Symfony\Component\Yaml\Ya_1', $y = 'Foo');
        $x = new X();
        $x->foo()('Humbug\Symfony\Component\Yaml\Ya_1', $y = 'Foo');

        PHP,

    'FQCN string argument with a static method' => <<<'PHP'
        <?php

        class Foo {
            static function foo($x = 'Symfony\\Component\\Yaml\\Ya_1', $y = 'Foo') {}
        }

        X::foo('Symfony\\Component\\Yaml\\Ya_1', $y = 'Foo');

        ----
        <?php

        namespace Humbug;

        class Foo
        {
            static function foo($x = 'Humbug\Symfony\Component\Yaml\Ya_1', $y = 'Foo')
            {
            }
        }
        X::foo('Humbug\Symfony\Component\Yaml\Ya_1', $y = 'Foo');

        PHP,
];
