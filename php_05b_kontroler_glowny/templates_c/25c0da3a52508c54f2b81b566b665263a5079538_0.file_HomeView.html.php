<?php
/* Smarty version 5.4.2, created on 2025-12-05 19:20:11
  from 'file:HomeView.html' */

/* @var \Smarty\Template $_smarty_tpl */
if ($_smarty_tpl->getCompiled()->isFresh($_smarty_tpl, array (
  'version' => '5.4.2',
  'unifunc' => 'content_6933306b354db8_01137950',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '25c0da3a52508c54f2b81b566b665263a5079538' => 
    array (
      0 => 'HomeView.html',
      1 => 1764961483,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
))) {
function content_6933306b354db8_01137950 (\Smarty\Template $_smarty_tpl) {
$_smarty_current_dir = '/home/scovy/AS-Zadania/php_05b_kontroler_glowny/app/views';
$_smarty_tpl->getInheritance()->init($_smarty_tpl, true);
?>


<?php 
$_smarty_tpl->getInheritance()->instanceBlock($_smarty_tpl, 'Block_7314237276933306b354567_28783936', 'content');
?>

<?php $_smarty_tpl->getInheritance()->endChild($_smarty_tpl, "main.html", $_smarty_current_dir);
}
/* {block 'content'} */
class Block_7314237276933306b354567_28783936 extends \Smarty\Runtime\Block
{
public function callBlock(\Smarty\Template $_smarty_tpl) {
$_smarty_current_dir = '/home/scovy/AS-Zadania/php_05b_kontroler_glowny/app/views';
?>

<div style="width:90%; margin: 2em auto;">
    <p>Witaj w mojej aplikacji!</p>
    <p>Przejdź do kalkulatora kredytowego:</p>
    <a href="<?php echo $_smarty_tpl->getValue('conf')->action_root;?>
calcShow" class="pure-button">Kalkulator kredytowy</a>
</div>
<?php
}
}
/* {/block 'content'} */
}
