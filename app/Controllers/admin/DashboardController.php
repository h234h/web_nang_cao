<?php
// app/Controllers/admin/DashboardController.php

require_once __DIR__ . "/../../Core/BaseController.php";
require_once __DIR__ . "/../../Models/Dashboard.php";

class DashboardController extends BaseController
{
    private $dashboardModel;

    public function __construct()
    {
        $this->dashboardModel = new Dashboard();
    }

    public function index()
    {
        $data = [
            "totalProducts"  => $this->dashboardModel->getTotalProducts(),
            "totalOrders"    => $this->dashboardModel->getTotalOrders(),
            "totalUsers"     => $this->dashboardModel->getTotalUsers(),
            "totalRevenue"   => $this->dashboardModel->getTotalRevenue(),
            "recentOrders"   => $this->dashboardModel->getRecentOrders()
        ];

        $this->view("admin/dashboard", $data);
    }
}
