<?php
/**
 * Copyright © 2016 SW-THEMES. All rights reserved.
 */

namespace Lovevox\CustomerSizeFee\Setup;

use Magento\Framework\Setup\UpgradeDataInterface;
use Magento\Framework\Setup\ModuleContextInterface;
use Magento\Framework\Setup\ModuleDataSetupInterface;

/**
 * @codeCoverageIgnore
 */
class UpgradeData implements UpgradeDataInterface
{

    /**
     * Upgrades data for a module
     *
     * @param ModuleDataSetupInterface $setup
     * @param ModuleContextInterface $context
     * @return void
     * @SuppressWarnings(PHPMD.ExcessiveMethodLength)
     */
    public function upgrade(ModuleDataSetupInterface $setup, ModuleContextInterface $context)
    {
        $installer = $setup;

        $installer->startSetup();
        //quote表扩展开税单标识
        $installer->getConnection()->addColumn(
            $installer->getTable('quote'),
            'customsizefee',
            [
                'type' => \Magento\Framework\DB\Ddl\Table::TYPE_DECIMAL,
                'length' => '6,2',
                'nullable' => false,
                'default' => 0.00,
                'comment' => 'quote customsize fee'
            ]
        );

        //sales_order表扩展开税单标识
        $installer->getConnection()->addColumn(
            $installer->getTable('sales_order'),
            'customsizefee',
            [
                'type' => \Magento\Framework\DB\Ddl\Table::TYPE_DECIMAL,
                'length' => '6,2',
                'nullable' => false,
                'default' => 0.00,
                'comment' => 'order customsize fee'
            ]
        );

        //sales_invoice表扩展开税单标识
        $installer->getConnection()->addColumn(
            $installer->getTable('sales_invoice'),
            'customsizefee',
            [
                'type' => \Magento\Framework\DB\Ddl\Table::TYPE_DECIMAL,
                'length' => '6,2',
                'nullable' => false,
                'default' => 0.00,
                'comment' => 'invoice customsize fee'
            ]
        );
        $installer->endSetup();
    }
}
