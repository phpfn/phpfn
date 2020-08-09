<?php

/**
 * This file is part of phpfn package.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

\class_alias(\Fun\Symbol\Symbol::class, \Serafim\Symbol\Symbol::class);
\class_alias(\Fun\Symbol\ReflectionSymbol::class, \Serafim\Symbol\ReflectionSymbol::class);
\class_alias(\Fun\Symbol\FactoryInterface::class, \Serafim\Symbol\FactoryInterface::class);
\class_alias(\Fun\Symbol\Metadata::class, \Serafim\Symbol\Metadata::class);

\class_alias(\Fun\Symbol\Metadata\Sign::class, \Serafim\Symbol\Metadata\Sign::class);
\class_alias(\Fun\Symbol\Metadata\SignInterface::class, \Serafim\Symbol\Metadata\SignInterface::class);

\class_alias(\Fun\Symbol\Exception\TypeError::class, \Serafim\Symbol\TypeError::class);
