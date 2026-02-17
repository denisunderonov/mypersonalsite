<?php

/**
 * Точка входа, когда document root указывает на корень проекта, а не на public/.
 * Подключает стандартный index.php Laravel из папки public.
 */
require __DIR__.'/public/index.php';
