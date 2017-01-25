<?php

/**
 * BaseMarca
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 * 
 * @property integer $id
 * @property string $nome
 * @property string $dns
 * @property Doctrine_Collection $Equipamento
 * @property Doctrine_Collection $EquipamentoModelo
 * 
 * @package    ##PACKAGE##
 * @subpackage ##SUBPACKAGE##
 * @author     ##NAME## <##EMAIL##>
 * @version    SVN: $Id: Builder.php 7490 2010-03-29 19:53:27Z jwage $
 */
abstract class BaseMarca extends Doctrine_Record
{
    public function setTableDefinition()
    {
        $this->setTableName('marca');
        $this->hasColumn('id', 'integer', 4, array(
             'type' => 'integer',
             'length' => 4,
             'fixed' => false,
             'unsigned' => true,
             'primary' => true,
             'autoincrement' => true,
             ));
        $this->hasColumn('nome', 'string', 60, array(
             'type' => 'string',
             'length' => 60,
             'fixed' => false,
             'unsigned' => false,
             'primary' => false,
             'notnull' => true,
             'autoincrement' => false,
             ));
        $this->hasColumn('dns', 'string', 60, array(
             'type' => 'string',
             'length' => 60,
             'fixed' => false,
             'unsigned' => false,
             'primary' => false,
             'notnull' => true,
             'autoincrement' => false,
             ));
    }

    public function setUp()
    {
        parent::setUp();
        $this->hasMany('Equipamento', array(
             'local' => 'id',
             'foreign' => 'marca_id'));

        $this->hasMany('EquipamentoModelo', array(
             'local' => 'id',
             'foreign' => 'marca_id'));
    }
}