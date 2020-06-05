<?php

namespace EgorDubrovskiy\CustomerTextFieldAttribute\Setup;

use Magento\Customer\Model\Customer;
use Magento\Framework\Exception\LocalizedException;
use Magento\Framework\Setup\ModuleContextInterface;
use Magento\Framework\Setup\ModuleDataSetupInterface;
use Magento\Framework\Setup\InstallDataInterface;
use Magento\Customer\Setup\CustomerSetupFactory;
use Zend_Validate_Exception;

/**
 * Class InstallData
 * @package EgorDubrovskiy\CustomerTextFieldAttribute\Setup
 */
class InstallData implements InstallDataInterface
{
    /**
     * @var CustomerSetupFactory $customerSetupFactory
     */
    private $customerSetupFactory;

    /**
     * InstallData constructor.
     * @param CustomerSetupFactory $customerSetupFactory
     */
    public function __construct(CustomerSetupFactory $customerSetupFactory) {
        $this->customerSetupFactory = $customerSetupFactory;
    }

    /**
     * @param ModuleDataSetupInterface $setup
     * @param ModuleContextInterface $context
     * @throws LocalizedException
     * @throws Zend_Validate_Exception
     */
    public function install(ModuleDataSetupInterface $setup, ModuleContextInterface $context)
    {
        $customerSetup = $this->customerSetupFactory->create(['setup' => $setup]);
        $customerSetup->addAttribute(
            Customer::ENTITY,
            'textField',
            [
                'type' => 'varchar',
                'label' => 'Text Field',
                'input' => 'text',
                'required' => false,
                'system' => false,
                'position' => 100,
                'visible' => true,
                'user_defined' => true
            ]
        );

        $attribute = $customerSetup->getEavConfig()->getAttribute('customer', 'textField');
        $attribute->setData('used_in_forms', ['adminhtml_customer']);
        $attribute->save();
    }
}
