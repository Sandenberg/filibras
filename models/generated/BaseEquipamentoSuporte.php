<?php

/**
 * BaseEquipamentoSuporte
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 * 
 * @property integer $equipamento_id
 * @property integer $suporte_id
 * @property integer $material_id
 * @property timestamp $data_realizacao
 * @property integer $servico_id
 * @property Equipamento $Equipamento
 * @property Suporte $Suporte
 * @property Material $Material
 * @property Servico $Servico
 * 
 * @package    ##PACKAGE##
 * @subpackage ##SUBPACKAGE##
 * @author     ##NAME## <##EMAIL##>
 * @version    SVN: $Id: Builder.php 7490 2010-03-29 19:53:27Z jwage $
 */
abstract class BaseEquipamentoSuporte extends Doctrine_Record
{
    public function setTableDefinition()
    {
        $this->setTableName('equipamento_suporte');
        $this->hasColumn('equipamento_id', 'integer', 4, array(
             'type' => 'integer',
             'length' => 4,
             'fixed' => false,
             'unsigned' => true,
             'primary' => false,
             'notnull' => true,
             'autoincrement' => false,
             ));
        $this->hasColumn('suporte_id', 'integer', 4, array(
             'type' => 'integer',
             'length' => 4,
             'fixed' => false,
             'unsigned' => true,
             'primary' => false,
             'notnull' => true,
             'autoincrement' => false,
             ));
        $this->hasColumn('material_id', 'integer', 4, array(
             'type' => 'integer',
             'length' => 4,
             'fixed' => false,
             'unsigned' => true,
             'primary' => false,
             'notnull' => false,
             'autoincrement' => false,
             ));
        $this->hasColumn('data_realizacao', 'timestamp', null, array(
             'type' => 'timestamp',
             'fixed' => false,
             'unsigned' => false,
             'primary' => false,
             'notnull' => true,
             'autoincrement' => false,
             ));
        $this->hasColumn('servico_id', 'integer', 4, array(
             'type' => 'integer',
             'length' => 4,
             'fixed' => false,
             'unsigned' => true,
             'primary' => false,
             'notnull' => false,
             'autoincrement' => false,
             ));
    }

    public function setUp()
    {
        parent::setUp();
        $this->hasOne('Equipamento', array(
             'local' => 'equipamento_id',
             'foreign' => 'id'));

        $this->hasOne('Suporte', array(
             'local' => 'suporte_id',
             'foreign' => 'id'));

        $this->hasOne('Material', array(
             'local' => 'material_id',
             'foreign' => 'id'));

        $this->hasOne('Servico', array(
             'local' => 'servico_id',
             'foreign' => 'id'));
    }
}