<?php

use yii\db\Migration;

/**
 * Class m200402_085527_init_rbac
 */
class m200402_085527_init_rbac extends Migration
{
    public function up()
    {
        $auth = Yii::$app->authManager;

        // add "manageProfile" permission
        $manageProfile = $auth->createPermission('manageProfile');
        $manageProfile->description = 'Manage my profile';
        $auth->add($manageProfile);

        // add "Lease" permission
        $lease = $auth->createPermission('lease');
        $lease->description = 'Lease by customer';
        $auth->add($lease);

        // add "reserveCart" permission
        $reserveCart = $auth->createPermission('reserveCart');
        $reserveCart->description = 'Reserve by customer';
        $auth->add($reserveCart);

        // add "manageLease" permission
        $manageLease = $auth->createPermission('manageLease');
        $manageLease->description = 'Manage lease by employee';
        $auth->add($manageLease);

        // add "manageOrder" permission 
        $manageOrder = $auth->createPermission('manageOrder');
        $manageOrder->description = 'manageOrder';
        $auth->add($manageOrder);

        // add "activeOrder" permission 
        $activeOrder = $auth->createPermission('activeOrder');
        $activeOrder->description = 'activeOrder';
        $auth->add($activeOrder);

        // add "manageTracking" permission 
        $manageTracking = $auth->createPermission('manageTracking');
        $manageTracking->description = 'manageTracking';
        $auth->add($manageTracking);

        // add "managePayment" permission 
        $managePayment = $auth->createPermission('managePayment');
        $managePayment->description = 'managePayment';
        $auth->add($managePayment);

        // add "viewBill" permission 
        $viewBill = $auth->createPermission('viewBill');
        $viewBill->description = 'viewBill';
        $auth->add($viewBill);

        // add "viewReport" permission 
        $viewReport = $auth->createPermission('viewReport');
        $viewReport->description = 'viewReport';
        $auth->add($viewReport);

        //จัดการข้อมูลลูกค้า
        $manageCustomer = $auth->createPermission('manageCustomer');
        $manageCustomer->description = 'manageCustomer';
        $auth->add($manageCustomer);

        //จัการบัญชีผู้ใช้
        $manageUser = $auth->createPermission('manageUser');
        $manageUser->description = 'manageUser';
        $auth->add($manageUser);

        //จัดการสินค้า
        $manageProduct = $auth->createPermission('manageProduct');
        $manageProduct->description = 'manageProduct';
        $auth->add($manageProduct);

        //จัดการประเภทสินค้า
        $manageCategory = $auth->createPermission('manageCategory');
        $manageCategory->description = 'manageCategory';
        $auth->add($manageCategory);


        // add "customer" role and give this role the "manageProfile" permission
        $customer = $auth->createRole('customer');
        $auth->add($customer);
        $auth->addChild($customer, $manageProfile);
        $auth->addChild($customer, $reserveCart);
        $auth->addChild($customer, $lease);
        $auth->addChild($customer, $managePayment);


        /**
         * 
         *  ////////// employee ////////////////
         * 
         */
        $employee = $auth->createRole('employee');
        $auth->add($employee);
        $auth->addChild($employee, $manageTracking);
        $auth->addChild($employee, $viewBill);
        $auth->addChild($employee, $viewReport);
        $auth->addChild($employee, $manageCustomer);
        $auth->addChild($employee, $manageProduct);
        $auth->addChild($employee, $manageCategory);
        $auth->addChild($employee, $manageOrder);
        $auth->addChild($employee, $activeOrder);
        $auth->addChild($employee, $customer); //ทำทุกอย่างที่ลูกค้าทำได้  

        //Admin ทำได้ทุกอย่าง
        $admin = $auth->createRole('admin');
        $auth->add($admin);
        $auth->addChild($admin, $manageUser);
        $auth->addChild($admin, $customer);
        $auth->addChild($admin, $employee);


        // Assign roles to users. 1 and 2 are IDs returned by IdentityInterface::getId()
        // usually implemented in your User model.
        //$auth->assign($customer, 2);
        $auth->assign($admin, 1);
    }

    public function down()
    {
        $auth = Yii::$app->authManager;

        $auth->removeAll();
    }
}
