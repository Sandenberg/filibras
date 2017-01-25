<?php

/**
 * UsuarioPermissao
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 * 
 * @package    ##PACKAGE##
 * @subpackage ##SUBPACKAGE##
 * @author     ##NAME## <##EMAIL##>
 * @version    SVN: $Id: Builder.php 7490 2010-03-29 19:53:27Z jwage $
 */
class UsuarioPermissao extends BaseUsuarioPermissao
{
	
	public function getMenu($parent){
		
		// Seleciona a permissão
		$retPermissao = Doctrine_Query::create()
						->from('UsuarioPermissao p')
						->innerJoin('p.UsuarioGrupoPermissao g')
						->addWhere('g.usuario_grupo_id = '.$_SESSION['sess_usuario_grupo_id'])
						->addWhere('p.tipo = 0')
						->addWhere('p.parent = '.$parent)
						->addWhere('p.status = 1')
						->addOrderBy('p.ordem ASC');
		
		// Verifica se houve retorno
		if ($retPermissao->count() > 0){
			// Resultado
			$resPermissao = $retPermissao->fetchArray();
			
			foreach ($resPermissao as $res){
				// Montagem de URL
				$url = empty($res['model'])?'#':URL_ADMIN.$res['model'].'/';
				
				echo '<li><a href="'.$url.'" class="'.$res['icone'].'">',$res['titulo'].'</a>';
				
				if ($this->checkChildren($res['id'])){
					echo '<ul>';
					$this->getMenu($res['id']);
					echo '</ul>';
				}
				
				echo '</li>';
			}
			
		}
		
	}
	
	public function getPermission($parent, $usuario_grupo_id){
		
		// Seleciona a permissão
		$retPermissao = Doctrine_Query::create()
						->from('UsuarioPermissao p')
						->addWhere('p.parent = '.$parent)
						->addWhere('p.status = 1')
						->addOrderBy('p.ordem ASC');
		
		// Verifica se houve retorno
		if ($retPermissao->count() > 0){
			// Resultado
			$resPermissao = $retPermissao->fetchArray();
			
			foreach ($resPermissao as $res){
				// Checa se o grupo possui a permissão
				$checked = Doctrine_Core::getTable('UsuarioGrupoPermissao')->findByUsuarioGrupoIdAndPermissaoId($usuario_grupo_id, $res['id']);
				$checked = $checked->count()==1?'checked="checked"':'';
				$resBold = Doctrine_Core::getTable('UsuarioPermissao')->findBy('parent',$res['id']);
				$bold = $res['parent']==0?"font-weight: 600":"";
				$bold = $resBold->count()>0?"font-weight: 600":$bold;
				// Imprime a permissão
				echo '<li style="'.$bold.'"><input type="checkbox" '.$checked.' name="usuario_permissao_id[]" class="chkp" parent="'.$res['parent'].'" value="'.$res['id'].'" />'.$res['titulo'],'</li>';
				
				// if ($this->checkChildren($res['id'], null)){
					echo '<ul  style="padding-left: 30px !important; list-style: none !important;">';
					$this->getPermission($res['id'], $usuario_grupo_id);
					echo '</ul>';
				// }
				
			}
			
		}
		
	}
	
	private function checkChildren($usuario_permissao_id, $tipo = 0){
		if (is_null($tipo)){
			$ret = Doctrine_Core::getTable('UsuarioPermissao')->findByParent($usuario_permissao_id);
		} else {
			$ret = Doctrine_Core::getTable('UsuarioPermissao')->findByParentAndTipo($usuario_permissao_id,0);
		}
		
		if ($ret->count() > 0){
			return true;
		} else {
			return false;
		}
		
	}
	
	public function getPermissao($model, $tipo, $action = ''){
		// Tratamento no action
		$action = explode('_', $action);
		$action = $action[0];
		
		// Condição de busca por tipo
		if (is_array($tipo)){
			$where = '';
			foreach ($tipo as $value){
				$where .= $where==''?'p.tipo = '.$value:' OR p.tipo = '.$value;
			}
			$tipo = $where;
		} else {
			$tipo = 'p.tipo = '.$tipo;
		}
		
		// Busca por permissão de acesso
		$retPermissao = Doctrine_Query::create()
			->from('UsuarioPermissao p')
			->innerJoin('p.UsuarioGrupoPermissao g')
			->addWhere('g.usuario_grupo_id = '.$_SESSION['sess_usuario_grupo_id'])
			->addWhere($tipo)
			->addWhere('p.model = "'.$_GET['model'].'"')
			->addOrderBy('p.ordem ASC');
		
		// Verifica se o action foi enviado e adidiona a query
		if ($action != ''){
			$retPermissao->addWhere('p.action LIKE "%'.$action.'%"');
		}
		
		if ($retPermissao->count() > 0){
			return $retPermissao->fetchArray();
		} else {
			return false;
		}
		
	}
	
	public function printActions($model,$tipo,$id= 0,$action = ''){
		// Tratamento no action
		$action = explode('_', $action);
		$action = $action[0];
		
		$id = $id!='0'?$id.'/':'';
		
		// Busca por permissão de acesso
		$retPermissao = Doctrine_Query::create()
		->from('UsuarioPermissao p')
		->innerJoin('p.UsuarioGrupoPermissao g')
		->addWhere('g.usuario_grupo_id = '.$_SESSION['sess_usuario_grupo_id'])
		->addWhere('p.tipo = '.$tipo)
		->addWhere('p.model = "'.$model.'"');
		
		// Verifica se o action foi enviado e adidiona a query
		if ($action != ''){
			$retPermissao->addWhere('p.action LIKE "%'.$action.'%"');
		}
		
		if ($retPermissao->count() > 0){
			$retPermissao = $retPermissao->fetchArray();
			echo '<div class="actionbar">';
			foreach ($retPermissao as $resPermissao){
				echo '<a href="'.URL_ADMIN.$resPermissao['model'].'/'.$resPermissao['action'].'/'.$id.'" class="action '.$resPermissao['icone'].'">';
				echo '<span>'.$resPermissao['titulo'].'</span></a>';
			}
			echo '</div><br /><br />';
		} else {
			return false;
		}
	}
}