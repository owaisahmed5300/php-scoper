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
use Humbug\PhpScoper\SpecFramework\Config\SpecWithConfig;

return [
    'meta' => new Meta(
        title: 'Two-parts namespaced constant call in the global scope with a single-level aliased use statement',
    ),

    'Namespaced constant call with namespace partially imported' => <<<'PHP'
        <?php

        class Foo {}

        use Foo as A;

        A\Bar\DUMMY_CONST;
        ----
        <?php

        namespace Humbug;

        class Foo
        {
        }
        use Humbug\Foo as A;
        A\Bar\DUMMY_CONST;

        PHP,

    'FQ namespaced constant call with namespace partially imported' => <<<'PHP'
        <?php

        class Foo {}

        use Foo as A;

        \A\Bar\DUMMY_CONST;
        ----
        <?php

        namespace Humbug;

        class Foo
        {
        }
        use Humbug\Foo as A;
        \Humbug\A\Bar\DUMMY_CONST;

        PHP,

    'Exposed namespaced constant call with namespace partially imported' => SpecWithConfig::create(
        exposeConstants: ['Foo\Bar\DUMMY_CONST'],
        spec: <<<'PHP'
            <?php

            class Foo {}

            use Foo as A;

            A\Bar\DUMMY_CONST;
            ----
            <?php

            namespace Humbug;

            class Foo
            {
            }
            use Humbug\Foo as A;
            \Foo\Bar\DUMMY_CONST;

            PHP,
    ),
];
