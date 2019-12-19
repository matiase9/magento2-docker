<?php

namespace Mramirez\Migrator\Model\ResourceModel;

use Magento\Eav\Model\Entity\AbstractEntity;


class Employees extends AbstractEntity {

    /**
     * @var \Magento\Framework\EntityManager\EntityManager
     * @since 101.0.0
     */
    protected $entityManager;

    /**
     *
     * @throws \Magento\Framework\Exception\LocalizedException
     * @return \Magento\Eav\Model\Entity\Type
     */
    public function getEntityType()
    {
        if (empty($this->_type)) {
            $this->setType(\Mramirez\Migrator\Model\Employees::ENTITY);
        }
        return parent::getEntityType();
    }



}