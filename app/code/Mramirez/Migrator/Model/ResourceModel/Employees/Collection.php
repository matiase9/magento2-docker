<?php

namespace Mramirez\Migrator\Model\ResourceModel\Employees;

class Collection extends \Magento\Eav\Model\Entity\Collection\AbstractCollection
{
    /**
     * Define resource model
     *
     * @return void
     */
    protected function _construct()
    {
        $this->_init(
            \Mramirez\Migrator\Model\Employees::class,
            \Mramirez\Migrator\Model\ResourceModel\Employees::class
        );
    }
}