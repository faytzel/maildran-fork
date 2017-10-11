<tr>
    <td>
        <table class="footer" align="center" width="570" cellpadding="0" cellspacing="0">
            <tr>
                <td class="content-cell" align="center">
                    @lang('email.template.msg1')
                    <br>
                    @lang('email.template.msg2')
                    <a href="https://t.me">@lang('email.template.msg3')</a>
                    @lang('email.template.msg4')
                    <a href="http://example.com">@lang('email.template.msg5')</a>
                    <br>
                    <br>
                    {{ Illuminate\Mail\Markdown::parse($slot) }}
                </td>
            </tr>
        </table>
    </td>
</tr>
