<?php

/**
 * BaseMaterial
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 * 
 * @property integer $id
 * @property string $nome
 * @property string $dns
 * @property decimal $valor
 * @property integer $tipo
 * @property string $cobranca
 * @property integer $minimo
 * @property integer $estoque
 * @property string $localizacao
 * @property Doctrine_Collection $EntradaMaterial
 * @property Doctrine_Collection $EquipamentoSuporte
 * @property Doctrine_Collection $FornecedorMaterial
 * @property Doctrine_Collection $MaterialEquipamento
 * @property Doctrine_Collection $Movimentacao
 * @property Doctrine_Collection $OrdemServicoMaterial
 * @property Doctrine_Collection $SaidaMaterial
 * 
 * @package    ##PACKAGE##
 * @subpackage ##SUBPACKAGE##
 * @author     ##NAME## <##EMAIL##>
 * @version    SVN: $Id: Builder.php 7490 2010-03-29 19:53:27Z jwage $
 */
abstract class BaseMaterial extends Doctrine_Record
{
    public function setTableDefinition()
    {
        $this->setTableName('material');
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
        $this->hasColumn('valor', 'decimal', 10, array(
             'type' => 'decimal',
             'length' => 10,
             'fixed' => false,
             'unsigned' => false,
             'primary' => false,
             'notnull' => false,
             'autoincrement' => false,
             'scale' => '2',
             ));
        $this->hasColumn('tipo', 'integer', 1, array(
             'type' => 'integer',
             'length' => 1,
             'fixed' => false,
             'unsigned' => true,
             'primary' => false,
             'notnull' => false,
             'autoincrement' => false,
             ));
        $this->hasColumn('cobranca', 'string', 1, array(
             'type' => 'string',
             'length' => 1,
             'fixed' => false,
             'unsigned' => false,
             'primary' => false,
             'default' => '0',
             'notnull' => false,
             'autoincrement' => false,
             ));
        $this->hasColumn('minimo', 'integer', 4, array(
             'type' => 'integer',
             'length' => 4,
             'fixed' => false,
             'unsigned' => false,
             'primary' => false,
             'default' => '0',
             'notnull' => false,
             'autoincrement' => false,
             ));
        $this->hasColumn('estoque', 'integer', 4, array(
             'type' => 'integer',
             'length' => 4,
             'fixed' => false,
             'unsigned' => false,
             'primary' => false,
             'default' => '0',
             'notnull' => false,
             'autoincrement' => false,
             ));
        $this->hasColumn('localizacao', 'string', null, array(
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
        $this->hasMany('EntradaMaterial', array(
             'local' => 'id',
             'foreign' => 'material_id'));

        $this->hasMany('EquipamentoSuporte', array(
             'local' => 'id',
             'foreign' => 'material_id'));

        $this->hasMany('FornecedorMaterial', array(
             'local' => 'id',
             'foreign' => 'material_id'));

        $this->hasMany('MaterialEquipamento', array(
             'local' => 'id',
             'foreign' => 'material_id'));

        $this->hasMany('Movimentacao', array(
             'local' => 'id',
             'foreign' => 'material_id'));

        $this->hasMany('OrdemServicoMaterial', array(
             'local' => 'id',
             'foreign' => 'material_id'));

        $this->hasMany('SaidaMaterial', array(
             'local' => 'id',
             'foreign' => 'material_id'));
    }
}