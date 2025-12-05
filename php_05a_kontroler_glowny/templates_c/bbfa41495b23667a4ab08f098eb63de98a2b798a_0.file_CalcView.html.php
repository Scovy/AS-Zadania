<?php
/* Smarty version 5.4.2, created on 2025-12-05 18:31:44
  from 'file:CalcView.html' */

/* @var \Smarty\Template $_smarty_tpl */
if ($_smarty_tpl->getCompiled()->isFresh($_smarty_tpl, array (
  'version' => '5.4.2',
  'unifunc' => 'content_693325101794e2_69680216',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    'bbfa41495b23667a4ab08f098eb63de98a2b798a' => 
    array (
      0 => 'CalcView.html',
      1 => 1764957924,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
))) {
function content_693325101794e2_69680216 (\Smarty\Template $_smarty_tpl) {
$_smarty_current_dir = '/home/scovy/AS-Zadania/php_05a_kontroler_glowny/app/views';
$_smarty_tpl->getInheritance()->init($_smarty_tpl, true);
?>


<?php 
$_smarty_tpl->getInheritance()->instanceBlock($_smarty_tpl, 'Block_1052585672693325101634e4_89699179', 'content');
$_smarty_tpl->getInheritance()->endChild($_smarty_tpl, "main.html", $_smarty_current_dir);
}
/* {block 'content'} */
class Block_1052585672693325101634e4_89699179 extends \Smarty\Runtime\Block
{
public function callBlock(\Smarty\Template $_smarty_tpl) {
$_smarty_current_dir = '/home/scovy/AS-Zadania/php_05a_kontroler_glowny/app/views';
?>


<div style="width:90%; margin: 2em auto;">
	<a href="<?php echo $_smarty_tpl->getValue('conf')->action_root;?>
logout" class="pure-button pure-button-active">Wyloguj</a>
    <a href="<?php echo $_smarty_tpl->getValue('conf')->app_url;?>
" class="pure-button">Strona główna</a>
</div>

<div style="width:90%; margin: 2em auto;">

<form action="<?php echo $_smarty_tpl->getValue('conf')->action_root;?>
calcCompute" method="post" class="pure-form pure-form-stacked">
	<legend>Kalkulator kredytowy</legend>
	<fieldset>
		<label for="id_amount">Kwota kredytu (PLN): </label>
		<input id="id_amount" type="text" name="amount" value="<?php echo (($tmp = $_smarty_tpl->getValue('form')->amount ?? null)===null||$tmp==='' ? '' ?? null : $tmp);?>
" />

		<label for="id_years">Lata: </label>
		<input id="id_years" type="text" name="years" value="<?php echo (($tmp = $_smarty_tpl->getValue('form')->years ?? null)===null||$tmp==='' ? '' ?? null : $tmp);?>
" />

		<label for="id_rate">Roczne oprocentowanie (%): </label>
		<input id="id_rate" type="text" name="rate" value="<?php echo (($tmp = $_smarty_tpl->getValue('form')->rate ?? null)===null||$tmp==='' ? '' ?? null : $tmp);?>
" />
	</fieldset>
	<input type="submit" value="Oblicz miesięczną ratę" class="pure-button pure-button-primary" />
</form>

<?php if ($_smarty_tpl->getValue('msgs')->isError()) {?>
	<ol style="margin-top: 1em; padding: 1em 1em 1em 2em; border-radius: 0.5em; background-color: #f88; width:25em;">
		<?php
$_from = $_smarty_tpl->getSmarty()->getRuntime('Foreach')->init($_smarty_tpl, $_smarty_tpl->getValue('msgs')->getErrors(), 'err');
$foreach0DoElse = true;
foreach ($_from ?? [] as $_smarty_tpl->getVariable('err')->value) {
$foreach0DoElse = false;
?>
			<li><?php echo $_smarty_tpl->getValue('err');?>
</li>
		<?php
}
$_smarty_tpl->getSmarty()->getRuntime('Foreach')->restore($_smarty_tpl, 1);?>
	</ol>
<?php }?>

<?php if ($_smarty_tpl->getValue('msgs')->isInfo()) {?> 
	<ol style="margin-top: 1em; padding: 1em 1em 1em 2em; border-radius: 0.5em; background-color: #inf; width:25em;">
		<?php
$_from = $_smarty_tpl->getSmarty()->getRuntime('Foreach')->init($_smarty_tpl, $_smarty_tpl->getValue('msgs')->getInfos(), 'inf');
$foreach1DoElse = true;
foreach ($_from ?? [] as $_smarty_tpl->getVariable('inf')->value) {
$foreach1DoElse = false;
?>
			<li><?php echo $_smarty_tpl->getValue('inf');?>
</li>
		<?php
}
$_smarty_tpl->getSmarty()->getRuntime('Foreach')->restore($_smarty_tpl, 1);?>
	</ol>
<?php }?>

<?php if ((null !== ($_smarty_tpl->getValue('res')->result ?? null))) {?>
<div style="margin-top: 1em; padding: 1em; border-radius: 0.5em; background-color: #ff0; width:25em;">
	Miesięczna rata: <?php echo sprintf("%.2f",$_smarty_tpl->getValue('res')->result);?>
 zł
</div>
<?php }?>

</div>

<?php
}
}
/* {/block 'content'} */
}
