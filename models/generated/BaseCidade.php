<?php

/**
 * BaseCidade
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 * 
 * @property integer $id
 * @property string $nome
 * @property integer $uf_id
 * @property Uf $Uf
 * @property Doctrine_Collection $Agenda
 * @property Doctrine_Collection $Cliente
 * @property Doctrine_Collection $Fornecedor
 * @property Doctrine_Collection $Funcionario
 * 
 * @package    ##PACKAGE##
 * @subpackage ##SUBPACKAGE##
 * @author     ##NAME## <##EMAIL##>
 * @version    SVN: $Id: Builder.php 7490 2010-03-29 19:53:27Z jwage $
 */
abstract class BaseCidade extends Doctrine_Record
{
    public function setTableDefinition()
    {
        $this->setTableName('cidade');
        $this->hasColumn('id', 'integer', 4, array(
             'type' => 'integer',
             'length' => 4,
             'fixed' => false,
             'unsigned' => true,
             'primary' => true,
             'autoincrement' => true,
             ));
        $this->hasColumn('nome', 'string', 150, array(
             'type' => 'string',
             'length' => 150,
             'fixed' => false,
             'unsigned' => false,
             'primary' => false,
             'notnull' => true,
             'autoincrement' => false,
             ));
        $this->hasColumn('uf_id', 'integer', 4, array(
             'type' => 'integer',
             'length' => 4,
             'fixed' => false,
             'unsigned' => true,
             'primary' => false,
             'notnull' => true,
             'autoincrement' => false,
             ));
    }

    public function setUp()
    {
        parent::setUp();
        $this->hasOne('Uf', array(
             'local' => 'uf_id',
             'foreign' => 'id'));

        $this->hasMany('Agenda', array(
             'local' => 'id',
             'foreign' => 'cidade_id'));

        $this->hasMany('Cliente', array(
             'local' => 'id',
             'foreign' => 'cidade_id'));

        $this->hasMany('Fornecedor', array(
             'local' => 'id',
             'foreign' => 'cidade_id'));

        $this->hasMany('Funcionario', array(
             'local' => 'id',
             'foreign' => 'cidade_id'));
    }
}