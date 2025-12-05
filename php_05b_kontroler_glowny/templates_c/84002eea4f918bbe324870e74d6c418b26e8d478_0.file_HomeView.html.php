<?php
/* Smarty version 5.4.2, created on 2025-12-05 17:22:44
  from 'file:/home/scovy/AS-Zadania/php_05_kontroler_glowny/app/HomeView.html' */

/* @var \Smarty\Template $_smarty_tpl */
if ($_smarty_tpl->getCompiled()->isFresh($_smarty_tpl, array (
  'version' => '5.4.2',
  'unifunc' => 'content_693314e4e33fa8_53087614',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '84002eea4f918bbe324870e74d6c418b26e8d478' => 
    array (
      0 => '/home/scovy/AS-Zadania/php_05_kontroler_glowny/app/HomeView.html',
      1 => 1764955121,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
))) {
function content_693314e4e33fa8_53087614 (\Smarty\Template $_smarty_tpl) {
$_smarty_current_dir = '/home/scovy/AS-Zadania/php_05_kontroler_glowny/app';
$_smarty_tpl->getInheritance()->init($_smarty_tpl, true);
?>


<?php 
$_smarty_tpl->getInheritance()->instanceBlock($_smarty_tpl, 'Block_1871957619693314e4e2fdc7_69583643', 'content');
?>

<?php $_smarty_tpl->getInheritance()->endChild($_smarty_tpl, "../templates/main.html", $_smarty_current_dir);
}
/* {block 'content'} */
class Block_1871957619693314e4e2fdc7_69583643 extends \Smarty\Runtime\Block
{
public function callBlock(\Smarty\Template $_smarty_tpl) {
$_smarty_current_dir = '/home/scovy/AS-Zadania/php_05_kontroler_glowny/app';
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
