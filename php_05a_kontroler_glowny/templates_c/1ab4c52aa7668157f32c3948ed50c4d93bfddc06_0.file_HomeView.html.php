<?php
/* Smarty version 5.4.2, created on 2025-12-05 18:18:32
  from 'file:HomeView.html' */

/* @var \Smarty\Template $_smarty_tpl */
if ($_smarty_tpl->getCompiled()->isFresh($_smarty_tpl, array (
  'version' => '5.4.2',
  'unifunc' => 'content_693321f840d5d6_01973202',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '1ab4c52aa7668157f32c3948ed50c4d93bfddc06' => 
    array (
      0 => 'HomeView.html',
      1 => 1764957939,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
))) {
function content_693321f840d5d6_01973202 (\Smarty\Template $_smarty_tpl) {
$_smarty_current_dir = '/home/scovy/AS-Zadania/php_05a_kontroler_glowny/app/views';
$_smarty_tpl->getInheritance()->init($_smarty_tpl, true);
?>


<?php 
$_smarty_tpl->getInheritance()->instanceBlock($_smarty_tpl, 'Block_1105000554693321f8409a12_52862597', 'content');
?>

<?php $_smarty_tpl->getInheritance()->endChild($_smarty_tpl, "main.html", $_smarty_current_dir);
}
/* {block 'content'} */
class Block_1105000554693321f8409a12_52862597 extends \Smarty\Runtime\Block
{
public function callBlock(\Smarty\Template $_smarty_tpl) {
$_smarty_current_dir = '/home/scovy/AS-Zadania/php_05a_kontroler_glowny/app/views';
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
