<?php

/**
 * BaseEquipamentoModelo
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 * 
 * @property integer $id
 * @property string $nome
 * @property string $dns
 * @property integer $marca_id
 * @property integer $equipamento_tipo_id
 * @property string $procedimento
 * @property EquipamentoTipo $EquipamentoTipo
 * @property Marca $Marca
 * @property Doctrine_Collection $Equipamento
 * @property Doctrine_Collection $MaterialEquipamento
 * 
 * @package    ##PACKAGE##
 * @subpackage ##SUBPACKAGE##
 * @author     ##NAME## <##EMAIL##>
 * @version    SVN: $Id: Builder.php 7490 2010-03-29 19:53:27Z jwage $
 */
abstract class BaseEquipamentoModelo extends Doctrine_Record
{
    public function setTableDefinition()
    {
        $this->setTableName('equipamento_modelo');
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
        $this->hasColumn('marca_id', 'integer', 4, array(
             'type' => 'integer',
             'length' => 4,
             'fixed' => false,
             'unsigned' => true,
             'primary' => false,
             'notnull' => true,
             'autoincrement' => false,
             ));
        $this->hasColumn('equipamento_tipo_id', 'integer', 4, array(
             'type' => 'integer',
             'length' => 4,
             'fixed' => false,
             'unsigned' => true,
             'primary' => false,
             'notnull' => false,
             'autoincrement' => false,
             ));
        $this->hasColumn('procedimento', 'string', null, array(
             'type' => 'string',
             'fixed' => false,
             'unsigned' => false,
             'primary' => false,
             'notnull' => false,
             'autoincrement' => false,
             ));
    }

    public function setUp()
    {
        parent::setUp();
        $this->hasOne('EquipamentoTipo', array(
             'local' => 'equipamento_tipo_id',
             'foreign' => 'id'));

        $this->hasOne('Marca', array(
             'local' => 'marca_id',
             'foreign' => 'id'));

        $this->hasMany('Equipamento', array(
             'local' => 'id',
             'foreign' => 'equipamento_modelo_id'));

        $this->hasMany('MaterialEquipamento', array(
             'local' => 'id',
             'foreign' => 'equipamento_id'));
    }
}