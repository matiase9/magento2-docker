<?php

namespace Mramirez\Migrator\Model;

class Employees extends \Magento\Framework\Model\AbstractModel
{
    const ENTITY = 'eav_employees';

    public function _construct()
    {
        $this->_init(\Mramirez\Migrator\Model\ResourceModel\Employees::class);
    }
}