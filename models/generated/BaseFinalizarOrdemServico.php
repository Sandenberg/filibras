<?php

/**
 * BaseFinalizarOrdemServico
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 * 
 * @property integer $id
 * @property string $descricao
 * @property timestamp $data_final
 * @property integer $id_cliente
 * @property integer $id_ordem_servico
 * @property integer $audit
 * @property string $entregue
 * @property Usuario $Usuario
 * @property Cliente $Cliente
 * @property OrdemServico $OrdemServico
 * @property Doctrine_Collection $FinalizarEquipamento
 * 
 * @package    ##PACKAGE##
 * @subpackage ##SUBPACKAGE##
 * @author     ##NAME## <##EMAIL##>
 * @version    SVN: $Id: Builder.php 7490 2010-03-29 19:53:27Z jwage $
 */
abstract class BaseFinalizarOrdemServico extends Doctrine_Record
{
    public function setTableDefinition()
    {
        $this->setTableName('finalizar_ordem_servico');
        $this->hasColumn('id', 'integer', 4, array(
             'type' => 'integer',
             'length' => 4,
             'fixed' => false,
             'unsigned' => false,
             'primary' => true,
             'autoincrement' => true,
             ));
        $this->hasColumn('descricao', 'string', null, array(
             'type' => 'string',
             'fixed' => false,
             'unsigned' => false,
             'primary' => false,
             'notnull' => false,
             'autoincrement' => false,
             ));
        $this->hasColumn('data_final', 'timestamp', null, array(
             'type' => 'timestamp',
             'fixed' => false,
             'unsigned' => false,
             'primary' => false,
             'notnull' => false,
             'autoincrement' => false,
             ));
        $this->hasColumn('id_cliente', 'integer', 4, array(
             'type' => 'integer',
             'length' => 4,
             'fixed' => false,
             'unsigned' => true,
             'primary' => false,
             'notnull' => false,
             'autoincrement' => false,
             ));
        $this->hasColumn('id_ordem_servico', 'integer', 4, array(
             'type' => 'integer',
             'length' => 4,
             'fixed' => false,
             'unsigned' => false,
             'primary' => false,
             'notnull' => false,
             'autoincrement' => false,
             ));
        $this->hasColumn('audit', 'integer', 4, array(
             'type' => 'integer',
             'length' => 4,
             'fixed' => false,
             'unsigned' => true,
             'primary' => false,
             'notnull' => false,
             'autoincrement' => false,
             ));
        $this->hasColumn('entregue', 'string', 255, array(
             'type' => 'string',
             'length' => 255,
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
        $this->hasOne('Usuario', array(
             'local' => 'audit',
             'foreign' => 'id'));

        $this->hasOne('Cliente', array(
             'local' => 'id_cliente',
             'foreign' => 'id'));

        $this->hasOne('OrdemServico', array(
             'local' => 'id_ordem_servico',
             'foreign' => 'id'));

        $this->hasMany('FinalizarEquipamento', array(
             'local' => 'id',
             'foreign' => 'finalizar_id'));
    }
}