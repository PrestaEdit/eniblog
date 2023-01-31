{extends file='page.tpl'}

{block name='left_column'}
    <div id="left-column" class="col-xs-12 col-sm-4 col-md-3">
        {hook h="displayLeftColumnBlog"}
    </div>
{/block}

{block name='page_title'}
    <span class="sitemap-title">{l s='Sitemap' d='Shop.Theme.Global'}</span>
{/block}

{block name='content'}
    <div class="bs-callout bs-callout-danger">
        <h4>{l s='Error' mod='eniblog'}</h4>
        <p>{l s='A problem occurs. Contact the webmaster.' mod='eniblog'}</p>
    </div>
{/block}