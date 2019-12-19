<?php

namespace Mramirez\Migrator\Setup;

use Magento\Eav\Setup\EavSetup;

class EmployeesSetup extends EavSetup {


    public function getDefaultEntities() {

        $employeesEntity = \Mramirez\Migrator\Model\Employees::ENTITY;

        $entities = [
            $employeesEntity => [
                'entity_model' => \Mramirez\Migrator\Model\ResourceModel\Employees::class,
                'table' => $employeesEntity . '_entity',
                'attributes' => [
                    'emp_no' => [
                        'type' => 'static',
                    ],
                    'birth_date' => [
                        'type' => 'static',
                    ],
                    'first_name' => [
                        'type' => 'static',
                    ],
                    'last_name' => [
                        'type' => 'static',
                    ],
                    'gender' => [
                        'type' => 'static',
                    ],
                    'hire_date' => [
                        'type' => 'static',
                    ],
                ],
            ],
        ];
        return $entities;
    }
}
