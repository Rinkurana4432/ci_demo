<?php
/*******************************************************************************
 * Copyright 2009-2021 Amazon Services. All Rights Reserved.
 * Licensed under the Apache License, Version 2.0 (the "License"); 
 *
 * You may not use this file except in compliance with the License. 
 * You may obtain a copy of the License at: http://aws.amazon.com/apache2.0
 * This file is distributed on an "AS IS" BASIS, WITHOUT WARRANTIES OR 
 * CONDITIONS OF ANY KIND, either express or implied. See the License for the 
 * specific language governing permissions and limitations under the License.
 *******************************************************************************
 * PHP Version 5
 * @category Amazon
 * @package  Marketplace Web Service Orders
 * @version  2013-09-01
 * Library Version: 2021-01-06
 * Generated: Wed Jan 06 18:02:52 UTC 2021
 */

/**
 *  @see MarketplaceWebServiceOrders_Model
 */

require_once (dirname(__FILE__) . '/../Model.php');


/**
 * MarketplaceWebServiceOrders_Model_ListOrdersOrderItem
 * 
 * Properties:
 * <ul>
 * 
 * <li>StoreChainStoreId: string</li>
 *
 * </ul>
 */

 class MarketplaceWebServiceOrders_Model_ListOrdersOrderItem extends MarketplaceWebServiceOrders_Model {

    public function __construct($data = null)
    {
    $this->_fields = array (
    'StoreChainStoreId' => array('FieldValue' => null, 'FieldType' => 'string'),
    );
    parent::__construct($data);
    }

    /**
     * Get the value of the StoreChainStoreId property.
     *
     * @return String StoreChainStoreId.
     */
    public function getStoreChainStoreId()
    {
        return $this->_fields['StoreChainStoreId']['FieldValue'];
    }

    /**
     * Set the value of the StoreChainStoreId property.
     *
     * @param string storeChainStoreId
     * @return this instance
     */
    public function setStoreChainStoreId($value)
    {
        $this->_fields['StoreChainStoreId']['FieldValue'] = $value;
        return $this;
    }

    /**
     * Check to see if StoreChainStoreId is set.
     *
     * @return true if StoreChainStoreId is set.
     */
    public function isSetStoreChainStoreId()
    {
                return !is_null($this->_fields['StoreChainStoreId']['FieldValue']);
            }

    /**
     * Set the value of StoreChainStoreId, return this.
     *
     * @param storeChainStoreId
     *             The new value to set.
     *
     * @return This instance.
     */
    public function withStoreChainStoreId($value)
    {
        $this->setStoreChainStoreId($value);
        return $this;
    }

}
