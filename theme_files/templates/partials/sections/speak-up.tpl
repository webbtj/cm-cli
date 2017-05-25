<!-- Speak Up ====================================================== -->
<section class="speak-up">

    <div class="content-container">
        <h2 class="heading--02 speak-up__title">{$speak_up_title}</h2>
        {if $speak_up_subtitle}
            <h5 class="heading--05 speak-up__copy">{$speak_up_subtitle}</h5>
        {/if}
        {if $speak_up_cta}
            <a href="{$speak_up_cta.link}" target="{$speak_up_cta.target}" title="{$speak_up_cta.text}" class="button--blue speak-up__cta">{$speak_up_cta.text}</a>
        {/if}
    </div>

</section>
