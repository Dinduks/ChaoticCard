<?php

/**
 * This file is part of the ChaoticCard package.
 *
 * PHP version 5
 * 
 * @category PHP
 * @package  ChaoticCard
 * @author   Samy Dindane <samy@dindane.com>
 * @license  http://opensource.org/licenses/gpl-license.php GNU Public License
 * @link     https://github.com/Dinduks/ChaoticCard
 */

/**
 * Class linking the admin table to the Admin model
 * 
 * @category PHP
 * @package  ChaoticCard
 * @author   Samy Dindane <samy@dindane.com>
 * @license  http://opensource.org/licenses/gpl-license.php GNU Public License
 * @link     https://github.com/Dinduks/ChaoticCard
 */
class AdminTable
{

    /**
     * Load the info about the site's admin
     *
     * @param Doctrine\DBAL\Connection $db The database object
     * 
     * @return Admin 
     */
    public static function load(Doctrine\DBAL\Connection $db)
    {
        $sql = 'SELECT * FROM admin';
        $result = $db->fetchAll($sql);

        $admin = new Admin();
        $admin->setId($result['id']);
        $admin->setUsername($result['username']);
        $admin->setPassword($result['password']);

        return $admin;
    }

}
