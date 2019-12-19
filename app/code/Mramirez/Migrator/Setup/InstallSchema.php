<?php

namespace Mramirez\Migrator\Setup;

use Magento\Framework\DB\Ddl\Table;
use Magento\Framework\Setup\InstallSchemaInterface;
use Magento\Framework\Setup\ModuleContextInterface;
use Magento\Framework\Setup\SchemaSetupInterface;
//use Mramirez\Migrator\Setup\EavTablesSetupFactory;
//use Mramirez\Migrator\Setup\EmployeesSetup;
use Magento\Framework\DB\Adapter\AdapterInterface;
use Mramirez\Migrator\Model\Employees;

/**
 * @codeCoverageIgnore
 */
class InstallSchema implements InstallSchemaInterface
{
    /**
     * {@inheritdoc}
     * @SuppressWarnings(PHPMD.ExcessiveMethodLength)
     */
    public function install(SchemaSetupInterface $setup, ModuleContextInterface $context)
    {
        $setup->startSetup();
        $employeesEntity = Employees::ENTITY;

        $table = $setup->getConnection()
            ->newTable($setup->getTable($employeesEntity . '_entity'))
            ->addColumn(
                'entity_id',
                Table::TYPE_INTEGER,
                null,
                ['identity' => true, 'unsigned' => true, 'nullable' => false, 'primary' => true],
                'Entity ID'
            )
            ->addColumn(
                'emp_no',
                Table::TYPE_INTEGER,
                null,
                ['nullable' => false],
                'number_id'
            )
            ->addColumn(
                'birth_date',
                Table::TYPE_DATE,
                64,
                [],
                'Birth Date'
            )
            ->addColumn(
                'first_name',
                Table::TYPE_TEXT,
                64,
                ['nullable' => false],
                'First Name'
            )
            ->addColumn(
                'last_name',
                Table::TYPE_TEXT,
                64,
                ['nullable' => false],
                'Last Name'
            )
            ->addColumn(
                'gender',
                Table::TYPE_INTEGER,
                null,
                [],
                'Gender'
            )
            ->addColumn(
                'hire_date',
                Table::TYPE_DATE,
                64,
                [],
                'Hire Date'
            )
            ->setComment('EAV Employees Table');
        $setup->getConnection()->createTable($table);

        $table = $setup->getConnection()
            ->newTable($setup->getTable($employeesEntity . '_entity_int'))
            ->addColumn(
                'value_id',
                Table::TYPE_INTEGER,
                null,
                ['identity' => true, 'nullable' => false, 'primary' => true],
                'Value ID'
            )
            ->addColumn(
                'attribute_id',
                Table::TYPE_SMALLINT,
                null,
                ['unsigned' => true, 'nullable' => false, 'default' => '0'],
                'Attribute ID'
            )
            ->addColumn(
                'store_id',
                Table::TYPE_SMALLINT,
                null,
                ['unsigned' => true, 'nullable' => false, 'default' => '0'],
                'Store ID'
            )
            ->addColumn(
                'entity_id',
                Table::TYPE_INTEGER,
                null,
                ['unsigned' => true, 'nullable' => false, 'default' => '0'],
                'Entity ID'
            )
            ->addColumn(
                'value',
                Table::TYPE_INTEGER,
                null,
                [],
                'Value'
            )
            ->addIndex(
                $setup->getIdxName(
                    $employeesEntity . '_entity_int',
                    ['entity_id', 'attribute_id', 'store_id'],
                    AdapterInterface::INDEX_TYPE_UNIQUE
                ),
                ['entity_id', 'attribute_id', 'store_id'],
                ['type' => AdapterInterface::INDEX_TYPE_UNIQUE]
            )
            ->addIndex(
                $setup->getIdxName($employeesEntity . '_entity_int', ['attribute_id']),
                ['attribute_id']
            )
            ->addIndex(
                $setup->getIdxName($employeesEntity . '_entity_int', ['store_id']),
                ['store_id']
            )
            ->addForeignKey(
                $setup->getFkName($employeesEntity . '_entity_int', 'attribute_id', 'eav_attribute', 'attribute_id'),
                'attribute_id',
                $setup->getTable('eav_attribute'),
                'attribute_id',
                Table::ACTION_CASCADE
            )
            ->addForeignKey(
                $setup->getFkName($employeesEntity . '_entity_int', 'entity_id', $employeesEntity . '_entity', 'entity_id'),
                'entity_id',
                $setup->getTable($employeesEntity . '_entity'),
                'entity_id',
                Table::ACTION_CASCADE
            )
            ->addForeignKey(
                $setup->getFkName($employeesEntity . '_entity_int', 'store_id', 'store', 'store_id'),
                'store_id',
                $setup->getTable('store'),
                'store_id',
                Table::ACTION_CASCADE
            )
            ->setComment('Bss Banner Integer Attribute Table');
        $setup->getConnection()->createTable($table);
        $table = $setup->getConnection()
            ->newTable($setup->getTable($employeesEntity . '_entity_datetime'))
            ->addColumn(
                'value_id',
                Table::TYPE_INTEGER,
                null,
                ['identity' => true, 'nullable' => false, 'primary' => true],
                'Value ID'
            )
            ->addColumn(
                'attribute_id',
                Table::TYPE_SMALLINT,
                null,
                ['unsigned' => true, 'nullable' => false, 'default' => '0'],
                'Attribute ID'
            )
            ->addColumn(
                'store_id',
                Table::TYPE_SMALLINT,
                null,
                ['unsigned' => true, 'nullable' => false, 'default' => '0'],
                'Store ID'
            )
            ->addColumn(
                'entity_id',
                Table::TYPE_INTEGER,
                null,
                ['unsigned' => true, 'nullable' => false, 'default' => '0'],
                'Entity ID'
            )
            ->addColumn(
                'value',
                Table::TYPE_DATETIME,
                null,
                [],
                'Value'
            )
            ->addIndex(
                $setup->getIdxName(
                    $employeesEntity . '_entity_datetime',
                    ['entity_id', 'attribute_id', 'store_id'],
                    AdapterInterface::INDEX_TYPE_UNIQUE
                ),
                ['entity_id', 'attribute_id', 'store_id'],
                ['type' => AdapterInterface::INDEX_TYPE_UNIQUE]
            )
            ->addIndex(
                $setup->getIdxName($employeesEntity . '_entity_datetime', ['attribute_id']),
                ['attribute_id']
            )
            ->addIndex(
                $setup->getIdxName($employeesEntity . '_entity_datetime', ['store_id']),
                ['store_id']
            )
            ->addForeignKey(
                $setup->getFkName(
                    $employeesEntity . '_entity_datetime',
                    'attribute_id',
                    'eav_attribute',
                    'attribute_id'
                ),
                'attribute_id',
                $setup->getTable('eav_attribute'),
                'attribute_id',
                Table::ACTION_CASCADE
            )
            ->addForeignKey(
                $setup->getFkName(
                    $employeesEntity . '_entity_datetime',
                    'entity_id',
                    $employeesEntity . '_entity',
                    'entity_id'
                ),
                'entity_id',
                $setup->getTable($employeesEntity . '_entity'),
                'entity_id',
                Table::ACTION_CASCADE
            )
            ->addForeignKey(
                $setup->getFkName($employeesEntity . '_entity_datetime', 'store_id', 'store', 'store_id'),
                'store_id',
                $setup->getTable('store'),
                'store_id',
                Table::ACTION_CASCADE
            )
            ->setComment('Bss Banner Datetime Attribute Table');
        $setup->getConnection()->createTable($table);
        $table = $setup->getConnection()
            ->newTable($setup->getTable($employeesEntity . '_entity_decimal'))
            ->addColumn(
                'value_id',
                Table::TYPE_INTEGER,
                null,
                ['identity' => true, 'nullable' => false, 'primary' => true],
                'Value ID'
            )
            ->addColumn(
                'attribute_id',
                Table::TYPE_SMALLINT,
                null,
                ['unsigned' => true, 'nullable' => false, 'default' => '0'],
                'Attribute ID'
            )
            ->addColumn(
                'store_id',
                Table::TYPE_SMALLINT,
                null,
                ['unsigned' => true, 'nullable' => false, 'default' => '0'],
                'Store ID'
            )
            ->addColumn(
                'entity_id',
                Table::TYPE_INTEGER,
                null,
                ['unsigned' => true, 'nullable' => false, 'default' => '0'],
                'Entity ID'
            )
            ->addColumn(
                'value',
                Table::TYPE_DECIMAL,
                '12,4',
                [],
                'Value'
            )
            ->addIndex(
                $setup->getIdxName(
                    $employeesEntity . '_entity_decimal',
                    ['entity_id', 'attribute_id', 'store_id'],
                    AdapterInterface::INDEX_TYPE_UNIQUE
                ),
                ['entity_id', 'attribute_id', 'store_id'],
                ['type' => AdapterInterface::INDEX_TYPE_UNIQUE]
            )
            ->addIndex(
                $setup->getIdxName($employeesEntity . '_entity_decimal', ['store_id']),
                ['store_id']
            )
            ->addIndex(
                $setup->getIdxName($employeesEntity . '_entity_decimal', ['attribute_id']),
                ['attribute_id']
            )
            ->addForeignKey(
                $setup->getFkName(
                    $employeesEntity . '_entity_decimal',
                    'attribute_id',
                    'eav_attribute',
                    'attribute_id'
                ),
                'attribute_id',
                $setup->getTable('eav_attribute'),
                'attribute_id',
                Table::ACTION_CASCADE
            )
            ->addForeignKey(
                $setup->getFkName(
                    $employeesEntity . '_entity_decimal',
                    'entity_id',
                    $employeesEntity . '_entity',
                    'entity_id'
                ),
                'entity_id',
                $setup->getTable($employeesEntity . '_entity'),
                'entity_id',
                Table::ACTION_CASCADE
            )
            ->addForeignKey(
                $setup->getFkName($employeesEntity . '_entity_decimal', 'store_id', 'store', 'store_id'),
                'store_id',
                $setup->getTable('store'),
                'store_id',
                Table::ACTION_CASCADE
            )
            ->setComment('Bss Banner Decimal Attribute Table');
        $setup->getConnection()->createTable($table);
        $table = $setup->getConnection()
            ->newTable($setup->getTable($employeesEntity . '_entity_varchar'))
            ->addColumn(
                'value_id',
                Table::TYPE_INTEGER,
                null,
                ['identity' => true, 'nullable' => false, 'primary' => true],
                'Value ID'
            )
            ->addColumn(
                'attribute_id',
                Table::TYPE_SMALLINT,
                null,
                ['unsigned' => true, 'nullable' => false, 'default' => '0'],
                'Attribute ID'
            )
            ->addColumn(
                'store_id',
                Table::TYPE_SMALLINT,
                null,
                ['unsigned' => true, 'nullable' => false, 'default' => '0'],
                'Store ID'
            )
            ->addColumn(
                'entity_id',
                Table::TYPE_INTEGER,
                null,
                ['unsigned' => true, 'nullable' => false, 'default' => '0'],
                'Entity ID'
            )
            ->addColumn(
                'value',
                Table::TYPE_TEXT,
                255,
                [],
                'Value'
            )
            ->addIndex(
                $setup->getIdxName(
                    $employeesEntity . '_entity_varchar',
                    ['entity_id', 'attribute_id', 'store_id'],
                    AdapterInterface::INDEX_TYPE_UNIQUE
                ),
                ['entity_id', 'attribute_id', 'store_id'],
                ['type' => AdapterInterface::INDEX_TYPE_UNIQUE]
            )
            ->addIndex(
                $setup->getIdxName($employeesEntity . '_entity_varchar', ['attribute_id']),
                ['attribute_id']
            )
            ->addIndex(
                $setup->getIdxName($employeesEntity . '_entity_varchar', ['store_id']),
                ['store_id']
            )
            ->addForeignKey(
                $setup->getFkName(
                    $employeesEntity . '_entity_varchar',
                    'attribute_id',
                    'eav_attribute',
                    'attribute_id'
                ),
                'attribute_id',
                $setup->getTable('eav_attribute'),
                'attribute_id',
                Table::ACTION_CASCADE
            )
            ->addForeignKey(
                $setup->getFkName(
                    $employeesEntity . '_entity_varchar',
                    'entity_id',
                    $employeesEntity . '_entity',
                    'entity_id'
                ),
                'entity_id',
                $setup->getTable($employeesEntity . '_entity'),
                'entity_id',
                Table::ACTION_CASCADE
            )
            ->addForeignKey(
                $setup->getFkName($employeesEntity . '_entity_varchar', 'store_id', 'store', 'store_id'),
                'store_id',
                $setup->getTable('store'),
                'store_id',
                Table::ACTION_CASCADE
            )
            ->setComment('Bss Banner Varchar Attribute Table');
        $setup->getConnection()->createTable($table);
        $table = $setup->getConnection()
            ->newTable($setup->getTable($employeesEntity . '_entity_text'))
            ->addColumn(
                'value_id',
                Table::TYPE_INTEGER,
                null,
                ['identity' => true, 'nullable' => false, 'primary' => true],
                'Value ID'
            )
            ->addColumn(
                'attribute_id',
                Table::TYPE_SMALLINT,
                null,
                ['unsigned' => true, 'nullable' => false, 'default' => '0'],
                'Attribute ID'
            )
            ->addColumn(
                'store_id',
                Table::TYPE_SMALLINT,
                null,
                ['unsigned' => true, 'nullable' => false, 'default' => '0'],
                'Store ID'
            )
            ->addColumn(
                'entity_id',
                Table::TYPE_INTEGER,
                null,
                ['unsigned' => true, 'nullable' => false, 'default' => '0'],
                'Entity ID'
            )
            ->addColumn(
                'value',
                Table::TYPE_TEXT,
                '64k',
                [],
                'Value'
            )
            ->addIndex(
                $setup->getIdxName(
                    $employeesEntity . '_entity_text',
                    ['entity_id', 'attribute_id', 'store_id'],
                    AdapterInterface::INDEX_TYPE_UNIQUE
                ),
                ['entity_id', 'attribute_id', 'store_id'],
                ['type' => AdapterInterface::INDEX_TYPE_UNIQUE]
            )
            ->addIndex(
                $setup->getIdxName($employeesEntity . '_entity_text', ['attribute_id']),
                ['attribute_id']
            )
            ->addIndex(
                $setup->getIdxName($employeesEntity . '_entity_text', ['store_id']),
                ['store_id']
            )
            ->addForeignKey(
                $setup->getFkName(
                    $employeesEntity . '_entity_text',
                    'attribute_id',
                    'eav_attribute',
                    'attribute_id'
                ),
                'attribute_id',
                $setup->getTable('eav_attribute'),
                'attribute_id',
                Table::ACTION_CASCADE
            )
            ->addForeignKey(
                $setup->getFkName(
                    $employeesEntity . '_entity_text',
                    'entity_id',
                    $employeesEntity . '_entity',
                    'entity_id'
                ),
                'entity_id',
                $setup->getTable($employeesEntity . '_entity'),
                'entity_id',
                Table::ACTION_CASCADE
            )
            ->addForeignKey(
                $setup->getFkName($employeesEntity . '_entity_text', 'store_id', 'store', 'store_id'),
                'store_id',
                $setup->getTable('store'),
                'store_id',
                Table::ACTION_CASCADE
            )
            ->setComment('Bss Banner Text Attribute Table');
        $setup->getConnection()->createTable($table);
        $setup->endSetup();
    }
}