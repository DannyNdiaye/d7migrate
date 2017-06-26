<?php

namespace Drupal\d7migrate\Plugin\migrate\process;

use Drupal\migrate\ProcessPluginBase;
use Drupal\migrate\MigrateExecutableInterface;
use Drupal\migrate\Row;

/**
 * Provides a 'D7migrate' migrate process plugin.
 *
 * @MigrateProcessPlugin(
 *  id = "d7migrate"
 * )
 */
class D7migrate extends ProcessPluginBase {

  /**
   * {@inheritdoc}
   */
  public function transform($value, MigrateExecutableInterface $migrate_executable, Row $row, $destination_property) {
    // Plugin logic goes here.
  /**
   * {@inheritdoc}
   */
  function prepareRow(Row $row) {
    $uid = $row->getSourceProperty('uid');

    // firstname
    $result = $this->getDatabase()->query('
      SELECT
        fld.field_firstname_value
      FROM
        {field_data_field_firstname} fld
      WHERE
        fld.entity_id = :uid
    ', array(':uid' => $uid));
    foreach ($result as $record) {
      $row->setSourceProperty('firstname', $record->field_firstname_value );
    }

    // lastname
    $result = $this->getDatabase()->query('
      SELECT
        fld.field_lastname_value
      FROM
        {field_data_field_lastname} fld
      WHERE
        fld.entity_id = :uid
    ', array(':uid' => $uid));
    foreach ($result as $record) {
      $row->setSourceProperty('lastname', $record->field_lastname_value );
    }

    // biography
    $result = $this->getDatabase()->query('
      SELECT
        fld.field_biography_value,
        fld.field_biography_format
      FROM
        {field_data_field_biography} fld
      WHERE
        fld.entity_id = :uid
    ', array(':uid' => $uid));
    foreach ($result as $record) {
      $row->setSourceProperty('biography_value', $record->field_biography_value );
      $row->setSourceProperty('biography_format', $record->field_biography_format );
    }

    return parent::prepareRow($row);
  }

  }

}
