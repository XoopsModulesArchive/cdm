<{$codeform.javascript}>
<form name="<{$codeform.name}>" action="<{$codeform.action}>" method="<{$codeform.method}>" <{$codeform.extra}>>
  <table class="outer" cellspacing="1">
    <tr>
    <th colspan="2"><{$codeform.title}></th>
    </tr>
    <!-- start of form elements loop -->
    <{foreach item=element from=$codeform.elements}>
      <{if $element.hidden !== true}>
      <tr>
        <td class="head"><{$element.caption}></td>
        <td class="<{cycle values="even,odd"}>"><{$element.body}></td>
      </tr>
      <{else}>
      <{$element.body}>
      <{/if}>
    <{/foreach}>
    <!-- end of form elements loop -->
  </table>
</form>
<!-- do not remove the following copyright section -->
<div align="right">
<br>CDM © 2004, <a href="http://akitson.bbcb.co.uk" title="Click to see software author's web page" target="_blank">A Kitson.</a> UK.
</div>
<!-- end of copyright section -->
