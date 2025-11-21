{extends file='layout.tpl'}

{block name='title'}Kalkulator kredytowy{/block}

{block name='content'}
<p class="userline">Witaj, {$user|escape}. {if $user != 'gość'}<a href="{$app_url}/security/logout.php">Wyloguj</a>{/if}</p>

<h2>Kalkulator kredytowy</h2>
<form action="{$app_url}/app/calc.php" method="post">
    <label for="id_amount">Kwota kredytu (PLN): </label>
    <input id="id_amount" type="text" name="amount" value="{$form->amount|escape}" /><br />

    <label for="id_years">Lata: </label>
    <input id="id_years" type="text" name="years" value="{$form->years|escape}" /><br />

    <label for="id_rate">Roczne oprocentowanie (%): </label>
    <input id="id_rate" type="text" name="rate" value="{$form->rate|escape}" /><br />

    <input type="submit" value="Oblicz miesięczną ratę" />
</form>

{if $msgs->isError()}
    <ol style="margin: 20px; padding: 10px 10px 10px 30px; border-radius: 5px; background-color: #f88; width:300px;">
    {foreach from=$msgs->getErrors() item=msg}
        <li>{$msg}</li>
    {/foreach}
    </ol>
{/if}

{if $msgs->isInfo()}
    <div class="result">
    Miesięczna rata: {$res->monthly|string_format:"%.2f"} zł
    </div>
{/if}

{/block}
