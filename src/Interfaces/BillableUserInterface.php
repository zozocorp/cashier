<?php

namespace Worker\Cashier\Interfaces;

interface BillableUserInterface
{
    public function getBillableId();
    public function getBillableEmail();
}