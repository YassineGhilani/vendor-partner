<?php
declare(strict_types=1);

/**
 * Module registration.
 * Registers the module Vendor_Partners with Magento.
 */

use Magento\Framework\Component\ComponentRegistrar;

ComponentRegistrar::register(
    ComponentRegistrar::MODULE,
    'Vendor_Partners',
    __DIR__
);
