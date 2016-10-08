<?php

/**
 * Data object containing the SQL and PHP code to migrate the database
 * up to version 1475930079.
 * Generated on 2016-10-08 14:34:39 by simon
 */
class PropelMigration_1475930079
{

    public function preUp($manager)
    {
        // add the pre-migration code here
    }

    public function postUp($manager)
    {
        // add the post-migration code here
    }

    public function preDown($manager)
    {
        // add the pre-migration code here
    }

    public function postDown($manager)
    {
        // add the post-migration code here
    }

    /**
     * Get the SQL statements for the Up migration
     *
     * @return array list of the SQL strings to execute for the Up migration
     *               the keys being the datasources
     */
    public function getUpSQL()
    {
        return array (
  'default' => '
# This is a fix for InnoDB in MySQL >= 4.1.x
# It "suspends judgement" for fkey relationships until are tables are set.
SET FOREIGN_KEY_CHECKS = 0;

CREATE TABLE `stream`
(
    `id` INTEGER NOT NULL AUTO_INCREMENT,
    `uri` VARCHAR(255) NOT NULL,
    `created_at` DATETIME,
    `updated_at` DATETIME,
    PRIMARY KEY (`id`)
) ENGINE=MyISAM;

CREATE TABLE `account`
(
    `id` INTEGER NOT NULL AUTO_INCREMENT,
    `channel` VARCHAR(255) NOT NULL,
    `key` VARCHAR(255) NOT NULL,
    `created_at` DATETIME,
    `updated_at` DATETIME,
    PRIMARY KEY (`id`)
) ENGINE=MyISAM;

CREATE TABLE `account_has_stream`
(
    `stream_id` INTEGER NOT NULL,
    `account_id` INTEGER NOT NULL,
    PRIMARY KEY (`stream_id`,`account_id`),
    INDEX `account_has_stream_FI_2` (`account_id`)
) ENGINE=MyISAM;

# This restores the fkey checks, after having unset them earlier
SET FOREIGN_KEY_CHECKS = 1;
',
);
    }

    /**
     * Get the SQL statements for the Down migration
     *
     * @return array list of the SQL strings to execute for the Down migration
     *               the keys being the datasources
     */
    public function getDownSQL()
    {
        return array (
  'default' => '
# This is a fix for InnoDB in MySQL >= 4.1.x
# It "suspends judgement" for fkey relationships until are tables are set.
SET FOREIGN_KEY_CHECKS = 0;

DROP TABLE IF EXISTS `stream`;

DROP TABLE IF EXISTS `account`;

DROP TABLE IF EXISTS `account_has_stream`;

# This restores the fkey checks, after having unset them earlier
SET FOREIGN_KEY_CHECKS = 1;
',
);
    }

}