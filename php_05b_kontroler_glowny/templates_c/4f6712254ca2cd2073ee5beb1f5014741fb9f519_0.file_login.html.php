<?php
/* Smarty version 5.4.2, created on 2025-12-05 17:23:31
  from 'file:/home/scovy/AS-Zadania/php_05_kontroler_glowny/app/security/login.html' */

/* @var \Smarty\Template $_smarty_tpl */
if ($_smarty_tpl->getCompiled()->isFresh($_smarty_tpl, array (
  'version' => '5.4.2',
  'unifunc' => 'content_69331513df14f7_22613174',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '4f6712254ca2cd2073ee5beb1f5014741fb9f519' => 
    array (
      0 => '/home/scovy/AS-Zadania/php_05_kontroler_glowny/app/security/login.html',
      1 => 1764955238,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
))) {
function content_69331513df14f7_22613174 (\Smarty\Template $_smarty_tpl) {
$_smarty_current_dir = '/home/scovy/AS-Zadania/php_05_kontroler_glowny/app/security';
$_smarty_tpl->getInheritance()->init($_smarty_tpl, true);
?>


<?php 
$_smarty_tpl->getInheritance()->instanceBlock($_smarty_tpl, 'Block_120680372969331513dedca5_04057757', 'content');
?>

<?php $_smarty_tpl->getInheritance()->endChild($_smarty_tpl, "../../templates/main.html", $_smarty_current_dir);
}
/* {block 'content'} */
class Block_120680372969331513dedca5_04057757 extends \Smarty\Runtime\Block
{
public function callBlock(\Smarty\Template $_smarty_tpl) {
$_smarty_current_dir = '/home/scovy/AS-Zadania/php_05_kontroler_glowny/app/security';
?>

<form action="<?php echo $_smarty_tpl->getValue('conf')->action_root;?>
login" method="post" class="pure-form pure-form-stacked">
	<legend>Logowanie</legend>
	<fieldset>
		<label for="id_login">Login: </label>
		<input id="id_login" type="text" name="login" value="<?php echo (($tmp = $_smarty_tpl->getValue('form')['login'] ?? null)===null||$tmp==='' ? '' ?? null : $tmp);?>
" />
		<label for="id_pass">Hasło: </label>
		<input id="id_pass" type="password" name="pass" />
	</fieldset>
	<input type="submit" value="zaloguj" class="pure-button pure-button-primary"/>
</form>	

<?php if ((null !== ($_smarty_tpl->getValue('messages') ?? null))) {?>
	<?php if ($_smarty_tpl->getSmarty()->getModifierCallback('count')($_smarty_tpl->getValue('messages')) > 0) {?> 
		<ol style="padding: 10px 10px 10px 30px; border-radius: 5px; background-color: #f88; width:300px;">
		<?php
$_from = $_smarty_tpl->getSmarty()->getRuntime('Foreach')->init($_smarty_tpl, $_smarty_tpl->getValue('messages'), 'msg');
$foreach0DoElse = true;
foreach ($_from ?? [] as $_smarty_tpl->getVariable('msg')->value) {
$foreach0DoElse = false;
?>
			<li><?php echo $_smarty_tpl->getValue('msg');?>
</li>
		<?php
}
$_smarty_tpl->getSmarty()->getRuntime('Foreach')->restore($_smarty_tpl, 1);?>
		</ol>
	<?php }
}
}
}
/* {/block 'content'} */
}
