<?php

/**
 * BaseOrdemServico
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 * 
 * @property integer $id
 * @property integer $tipo_ordem
 * @property timestamp $data_atendimento
 * @property string $solicitante
 * @property integer $status
 * @property string $observacao
 * @property integer $cliente_id
 * @property integer $tipo_cliente
 * @property integer $audt
 * @property string $problema
 * @property integer $rota
 * @property integer $rota_usuario_id
 * @property string $rota_ordem
 * @property string $rota_turno
 * @property timestamp $data_rota
 * @property string $tecnico
 * @property Cliente $Cliente
 * @property Usuario $Usuario
 * @property Doctrine_Collection $FinalizarOrdemServico
 * @property Doctrine_Collection $OrdemServAcessoremoto
 * @property Doctrine_Collection $OrdemServInstalacao
 * @property Doctrine_Collection $OrdemServManutencao
 * @property Doctrine_Collection $OrdemServNumerador
 * @property Doctrine_Collection $OrdemServPreventiva
 * @property Doctrine_Collection $OrdemServRetirada
 * @property Doctrine_Collection $OrdemServToner
 * @property Doctrine_Collection $OrdemServTroca
 * @property Doctrine_Collection $OrdemServicoMaterial
 * @property Doctrine_Collection $Saida
 * 
 * @package    ##PACKAGE##
 * @subpackage ##SUBPACKAGE##
 * @author     ##NAME## <##EMAIL##>
 * @version    SVN: $Id: Builder.php 7490 2010-03-29 19:53:27Z jwage $
 */
abstract class BaseOrdemServico extends Doctrine_Record
{
    public function setTableDefinition()
    {
        $this->setTableName('ordem_servico');
        $this->hasColumn('id', 'integer', 4, array(
             'type' => 'integer',
             'length' => 4,
             'fixed' => false,
             'unsigned' => false,
             'primary' => true,
             'autoincrement' => true,
             ));
        $this->hasColumn('tipo_ordem', 'integer', 4, array(
             'type' => 'integer',
             'length' => 4,
             'fixed' => false,
             'unsigned' => false,
             'primary' => false,
             'notnull' => false,
             'autoincrement' => false,
             ));
        $this->hasColumn('data_atendimento', 'timestamp', null, array(
             'type' => 'timestamp',
             'fixed' => false,
             'unsigned' => false,
             'primary' => false,
             'notnull' => false,
             'autoincrement' => false,
             ));
        $this->hasColumn('solicitante', 'string', 60, array(
             'type' => 'string',
             'length' => 60,
             'fixed' => false,
             'unsigned' => false,
             'primary' => false,
             'notnull' => false,
             'autoincrement' => false,
             ));
        $this->hasColumn('status', 'integer', 1, array(
             'type' => 'integer',
             'length' => 1,
             'fixed' => false,
             'unsigned' => false,
             'primary' => false,
             'notnull' => false,
             'autoincrement' => false,
             ));
        $this->hasColumn('observacao', 'string', null, array(
             'type' => 'string',
             'fixed' => false,
             'unsigned' => false,
             'primary' => false,
             'notnull' => false,
             'autoincrement' => false,
             ));
        $this->hasColumn('cliente_id', 'integer', 4, array(
             'type' => 'integer',
             'length' => 4,
             'fixed' => false,
             'unsigned' => true,
             'primary' => false,
             'notnull' => false,
             'autoincrement' => false,
             ));
        $this->hasColumn('tipo_cliente', 'integer', 4, array(
             'type' => 'integer',
             'length' => 4,
             'fixed' => false,
             'unsigned' => false,
             'primary' => false,
             'notnull' => false,
             'autoincrement' => false,
             ));
        $this->hasColumn('audt', 'integer', 4, array(
             'type' => 'integer',
             'length' => 4,
             'fixed' => false,
             'unsigned' => true,
             'primary' => false,
             'notnull' => false,
             'autoincrement' => false,
             ));
        $this->hasColumn('problema', 'string', 255, array(
             'type' => 'string',
             'length' => 255,
             'fixed' => false,
             'unsigned' => false,
             'primary' => false,
             'notnull' => false,
             'autoincrement' => false,
             ));
        $this->hasColumn('rota', 'integer', 4, array(
             'type' => 'integer',
             'length' => 4,
             'fixed' => false,
             'unsigned' => false,
             'primary' => false,
             'notnull' => false,
             'autoincrement' => false,
             ));
        $this->hasColumn('rota_usuario_id', 'integer', 4, array(
             'type' => 'integer',
             'length' => 4,
             'fixed' => false,
             'unsigned' => false,
             'primary' => false,
             'notnull' => false,
             'autoincrement' => false,
             ));
        $this->hasColumn('rota_ordem', 'string', 255, array(
             'type' => 'string',
             'length' => 255,
             'fixed' => false,
             'unsigned' => false,
             'primary' => false,
             'notnull' => false,
             'autoincrement' => false,
             ));
        $this->hasColumn('rota_turno', 'string', 30, array(
             'type' => 'string',
             'length' => 30,
             'fixed' => false,
             'unsigned' => false,
             'primary' => false,
             'notnull' => false,
             'autoincrement' => false,
             ));
        $this->hasColumn('data_rota', 'timestamp', null, array(
             'type' => 'timestamp',
             'fixed' => false,
             'unsigned' => false,
             'primary' => false,
             'notnull' => false,
             'autoincrement' => false,
             ));
        $this->hasColumn('tecnico', 'string', 11, array(
             'type' => 'string',
             'length' => 11,
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
        $this->hasOne('Cliente', array(
             'local' => 'cliente_id',
             'foreign' => 'id'));

        $this->hasOne('Usuario', array(
             'local' => 'audt',
             'foreign' => 'id'));

        $this->hasMany('FinalizarOrdemServico', array(
             'local' => 'id',
             'foreign' => 'id_ordem_servico'));

        $this->hasMany('OrdemServAcessoremoto', array(
             'local' => 'id',
             'foreign' => 'id_ordem_servico'));

        $this->hasMany('OrdemServInstalacao', array(
             'local' => 'id',
             'foreign' => 'id_ordem_servico'));

        $this->hasMany('OrdemServManutencao', array(
             'local' => 'id',
             'foreign' => 'id_ordem_servico'));

        $this->hasMany('OrdemServNumerador', array(
             'local' => 'id',
             'foreign' => 'id_ordem_servico'));

        $this->hasMany('OrdemServPreventiva', array(
             'local' => 'id',
             'foreign' => 'id_ordem_servico'));

        $this->hasMany('OrdemServRetirada', array(
             'local' => 'id',
             'foreign' => 'id_ordem_servico'));

        $this->hasMany('OrdemServToner', array(
             'local' => 'id',
             'foreign' => 'id_ordem_servico'));

        $this->hasMany('OrdemServTroca', array(
             'local' => 'id',
             'foreign' => 'id_ordem_servico'));

        $this->hasMany('OrdemServicoMaterial', array(
             'local' => 'id',
             'foreign' => 'ordem_servico_id'));

        $this->hasMany('Saida', array(
             'local' => 'id',
             'foreign' => 'ordem_servico_id'));
    }
}