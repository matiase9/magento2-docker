<?php

namespace Mramirez\Migrator\Setup;
use Magento\Framework\Setup\InstallDataInterface;
use Magento\Framework\Setup\ModuleContextInterface;
use Magento\Framework\Setup\ModuleDataSetupInterface;
/**
 * @codeCoverageIgnore
 */
class InstallData implements InstallDataInterface
{
    private $employeesSetupFactory;

    public function __construct(
        \Mramirez\Migrator\Setup\EmployeesSetupFactory $employeesSetupFactory
    ) {
        $this->employeesSetupFactory = $employeesSetupFactory;
    }
    /**
     * {@inheritdoc}
     * @SuppressWarnings(PHPMD.ExcessiveMethodLength)
     */
    public function install(ModuleDataSetupInterface $setup, ModuleContextInterface $context)
    {
        $setup->startSetup();
        $employeesEntity = \Mramirez\Migrator\Model\Employees::ENTITY;
        $employeesSetup = $this->employeesSetupFactory->create(['setup' => $setup]);
        $employeesSetup->installEntities();
        $employeesSetup->addAttribute(
            $employeesEntity, 'display_from', ['type' => 'datetime']
        );
        $employeesSetup->addAttribute(
            $employeesEntity, 'display_to', ['type' => 'datetime']
        );
        $employeesSetup->addAttribute(
            $employeesEntity, 'priority', ['type' => 'int']
        );
        $setup->endSetup();
    }
}