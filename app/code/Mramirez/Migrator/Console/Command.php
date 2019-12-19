<?php

namespace Mramirez\Migrator\Console;

use Braintree\Exception;
use Symfony\Component\Console\Command\Command as SymfonyCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class Command extends SymfonyCommand
{
    const TABLE_EMPLOYEES = 'employees';

    const EXTERNAL_HOST = 'mysql';

    const EXTERNAL_DB = 'external_db';

    const EXTERNAL_USER = 'root';

    const EXTERNAL_PASSWORD = 'root';

    const MIN_VALUE = 10000;

    const PLUS_VALUE = 15000;

    /**
     * @var \Magento\Framework\App\ResourceConnection\ConnectionFactory
     */
    protected $connectionFactory = null;

    /**
     * @var \Mramirez\Migrator\Model\EmployeesFactory
     */
    protected $employeesFactory;

    /**
     * @var \Mramirez\Migrator\Model\ResourceModel\EmployeesResourceFactory
     */
    protected $employeesResourceFactory;


    /**
     * Command constructor.
     * @param string|null $name
     * @param \Magento\Framework\App\ResourceConnection\ConnectionFactory $connectionFactory
     * @param \Mramirez\Migrator\Model\ResourceModel\EmployeesFactory $employeesResourceFactory
     * @param \Mramirez\Migrator\Model\EmployeesFactory $employeesFactory
     */
    public function __construct(
        string $name = null,
        \Magento\Framework\App\ResourceConnection\ConnectionFactory $connectionFactory,
        \Mramirez\Migrator\Model\ResourceModel\EmployeesFactory $employeesResourceFactory,
        \Mramirez\Migrator\Model\EmployeesFactory $employeesFactory

    ) {
        parent::__construct($name);
        $this->connectionFactory = $connectionFactory;
        $this->employeesResourceFactory = $employeesResourceFactory;
        $this->employeesFactory = $employeesFactory;
    }

    protected function configure()
    {
        $this->setName('migrate:data');
        $this->setDescription('Migration conventional table to EAV');
        parent::configure();
    }

    /**
     * @param InputInterface $input
     * @param OutputInterface $output
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $limit_plus = self::PLUS_VALUE;
        $limit_min = self::MIN_VALUE;
        $connection = true;
        $iteration = 0;

        $db = $this->connectionFactory->create(array(
            'host' => self::EXTERNAL_HOST,
            'dbname' => self::EXTERNAL_DB,
            'username' => self::EXTERNAL_USER,
            'password' => self::EXTERNAL_PASSWORD,
            'active' => '1',
        ));

        try {
            $query = "select count(*) as maximum from " . self::TABLE_EMPLOYEES;

            $maxRows = $db->query($query)->fetchAll();

            if (!empty($maxRows[0]['maximum'])) {
                $iteration = $maxRows[0]['maximum'] / $limit_plus;
                $iteration = intval($iteration) + 1;
            }
        } catch (Exception $exception) {
            //dispatch log
            $connection = false;
        }

        if ($connection) {
            try {
                $max = $limit_min;

                for ($pos=0; $pos < $iteration; $pos++) {
                    $max = $max + $limit_plus;
                    $query = "select * from " . self::TABLE_EMPLOYEES . " where $limit_min < emp_no and emp_no < $max";
                    $results = $db->query($query)->fetchAll();

                    foreach ($results as $employees) {
                        $employ = $this->employeesFactory->create();
                        $employ->setData($employees);
                        $employ->save();
                    }

                    $limit_min = $max;
                }
            } catch (Exception $exception) {
                // dispatch Log
            }
        } else {
            $output->writeln(" - Connection to external DB failed - ");
        }
        $output->writeln(" - Operation Complete - ");
    }
}